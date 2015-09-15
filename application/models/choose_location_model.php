<?php

class choose_location_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    function getAllposts() {
        $this->db->select('*');
        $this->db->from('posts');
        $query = $this->db->get();

        return $query->result_array();
    }

    function getPosts_by_field_value($field = array(), $value = array()) {
        $this->db->select('*');
        $this->db->from('posts');
        if (count($field) > 0) {

            for ($i = 0; $i < count($field); $i++) {
                $this->db->where($field[$i], $value[$i]);
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_country($field, $value) {
        $this->db->select('*');
        $this->db->from('country');
        $this->db->group_by('country_name');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_state_by_field_value($field, $value) {
        $this->db->select('*');
        $this->db->from('state');
        $this->db->group_by('state_name');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCity_by_field_value($field, $value) {
        $this->db->select('*');
        $this->db->from('city');
        $this->db->group_by('city_name');
        $this->db->where($field, $value);
        $query = $this->db->get();
//        echo "<pre>";
//        print_r($this->db->last_query());
//        die;
        return $query->result_array();
    }

    function get_parent_id($category_id) {
        $this->db->select('parent_id');
        $this->db->from('category');
        $this->db->where('category_id', $category_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_parent_city_country($city_id) {
        $this->db->select('country_id');
        $this->db->from('city');
        $this->db->where('city_id', $city_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_parent_city_state($city_id) {
        $this->db->select('state_id');
        $this->db->from('city');
        $this->db->where('city_id', $city_id);
        $query = $this->db->get();
        return $query->result_array();
    }

}

