<?php

class citycategory_model extends CI_Model {

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
        $this->db->order_by("display_order", "asc");
        $query = $this->db->get();
        //echo $a = $this->db->last_query();
        return $query->result_array();
    }

    function get_posts_field_value($field, $value) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->like('city', $value);
        $this->db->where('payment_status', 'complete');
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        exit;
        return $query->result_array();
    }

    function get_posts_category($table, $field, $whereStr) {
        $sql = "Select $field from $table WHERE $whereStr";
        $query = $this->db->query($sql);
        $data = $query->result();
        return $query->result_array();
    }

    function count_posts_by_category($city, $subcategory = array(), $current_date) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where("FIND_IN_SET('$city',city)!=", 0);
        $this->db->where_in('category', $subcategory);
        //$this->db->where('date <= ', $current_date);
        $this->db->where("payment_status", "complete");
        $this->db->where("status", "Active");
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        exit;
        return $query->num_rows();
    }

    function get_top_ads_category_name($table, $field, $whereStr) {
        //$arr = array();
        $sql = "Select $field from $table WHERE $whereStr";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        foreach ($data as $key => $arrV) {
            $arr[] = $arrV[$field];
        }
        return $arr;
    }

    function getAllcategory_Where_array($where_field, $where_value) {
        $this->db->select('*');
        $this->db->from('category');
        //$sql = "Select * from category WHERE $whereStr order by display_order ASC";
        if (count($where_field) > 0 && count($where_value) > 0) {
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_value[$i]);
            }
        }
        $this->db->order_by('display_order', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

}

