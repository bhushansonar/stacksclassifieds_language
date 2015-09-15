<?php

class post_detail_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    function getPostdetail($posts_id) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('posts_id', $posts_id);
        $query = $this->db->get();

        return $query->result_array();
    }

    function add_post_reported($data) {
        $this->db->insert('reported_ad', $data);
        return $this->db->insert_id();
    }

    /* function getPosts_by_field_value($field= array(),$value=array()) {
      $this->db->select('*');
      $this->db->from('posts');
      if(count($field) > 0){

      for($i=0;$i<count($field);$i++){
      $this->db->where($field[$i], $value[$i]);
      }
      }
      $query = $this->db->get();
      return $query->result_array();
      } */

    /* function getAllSubcategory($category_id) {
      $this->db->select('*');
      $this->db->from('category');
      $this->db->where('parent_id',$category_id);
      $query = $this->db->get();
      return $query->result_array();
      } */

    /* function getState_by_field_value($field,$value) {
      $this->db->select('*');
      $this->db->from('state');
      $this->db->join('posts', 'posts.state = state.state_id');
      $this->db->where($field, $value);
      $query = $this->db->get();
      return $query->result_array();
      }
      function getCity_by_field_value($field,$value) {
      $this->db->select('*');
      $this->db->from('city');
      $this->db->join('posts', 'posts.city = city.city_id');
      $this->db->where($field, $value);
      $query = $this->db->get();
      return $query->result_array();
      } */
}
