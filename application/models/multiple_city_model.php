<?php

class multiple_city_model extends CI_Model {

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

    function getAllCountry() {
        $this->db->select('*');
        $this->db->from('country');
        //$this->db->join('posts', 'posts.country = country.country_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getState_by_field_value($field, $value) {
        $this->db->select('*');
        $this->db->from('state');
        //$this->db->join('posts', 'posts.state = state.state_id');
        $this->db->group_by('state_name');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCity_by_field_value($field, $value) {
        $this->db->select('*');
        $this->db->from('city');
        //$this->db->join('posts', 'posts.city = city.city_id');
        $this->db->group_by('city_name');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_multiple_city_value($field, $value) {
        $this->db->select('*');
        $this->db->from('multiple_city');
        $this->db->group_by('multiple_city_id');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    function addMultiplecity() {
        if (empty($_POST['country'])) {
            $country = "";
        } else {
            $country = implode(',', $_POST['country']);
        }
        if (empty($_POST['state'])) {
            $state = "";
        } else {
            $state = implode(',', $_POST['state']);
        }

        $insertArr['country'] = $country;
        $insertArr['state'] = $state;
        $insertArr['city'] = isset($_POST['multi_city_id']) ? $_POST['multi_city_id'] : "";
        $insertArr['week'] = isset($_POST['week']) ? $_POST['week'] : "";
        $insertArr['total'] = isset($_POST['total']) ? $_POST['total'] : "";
        $this->db->insert('multiple_city', $insertArr);
        return $this->db->insert_id();
    }

    function get_parent_id($cat_id) {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('category_id', $cat_id);
        $query = $this->db->get();
        return $query->result_array();
    }

}
