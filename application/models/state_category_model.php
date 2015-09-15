<?php

class state_category_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    function getAllcategory($whereStr) {

        $sql = "Select * from category WHERE $whereStr order by display_order ASC";
        $query = $this->db->query($sql);
        $data = $query->result();
        return $query->result_array();
    }

    function getAllSubcategory($category_id) {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where_in('parent_id', $category_id);
        $query = $this->db->get();
        //echo $a=$this->db->last_query();exit;
        return $query->result_array();
    }

    function get_posts_field_by_state($field, $value) {
        $this->db->select('*');
        $this->db->from('posts');
        //$this->db->like('state', $value);
        $this->db->where($field, $value);
        $this->db->where("payment_status", "complete");
        $query = $this->db->get();
        //$a = $this->db->last_query();
        return $query->result_array();
    }

    function get_posts_category($table, $field, $whereStr) {
        $sql = "Select $field from $table WHERE $whereStr";
        $query = $this->db->query($sql);
        $data = $query->result();
        return $query->result_array();
    }

    function count_posts_by_category($state, $subcategory = array()) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where("FIND_IN_SET('$state',state)!=", 0);
        $this->db->where_in('category', $subcategory);
        $this->db->where("payment_status", "complete");
        $this->db->where("status", "Active");
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        exit;
        return $query->num_rows();
    }

    function get_state_by_Where_array($where_field, $where_value) {
        $this->db->select('*');
        $this->db->from('state');
        if (count($where_field) > 0 && count($where_value) > 0) {
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_value[$i]);
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

}
