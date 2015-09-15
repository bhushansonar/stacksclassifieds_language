<?php

class heading_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    function getAlltitle($category_id) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('subcategory', $category_id);
        $this->db->where('status', 'Active');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getTitle($city_id, $category_id, $current_date, $limit_start = null, $limit_end = null) {
        if ($limit_start && $limit_end) {
            $lim = "LIMIT $limit_end ,$limit_start";
        }

        if ($limit_start != null) {
            $lim = "LIMIT $limit_end , $limit_start";
        }
        //echo "select * from posts WHERE FIND_IN_SET(" . $city_id . ",city) AND subcategory ='$category_id' AND payment_status ='complete' AND date <= '$current_date' AND status ='Active' ORDER BY move_to_ad DESC $lim";
        $query = $this->db->query("select * from posts WHERE FIND_IN_SET(" . $city_id . ",city) AND subcategory ='$category_id' AND payment_status ='complete' AND date <= '$current_date' AND status ='Active' ORDER BY move_to_ad DESC $lim");
        $a = $this->db->last_query();
//        echo "<pre>";
//        print_r($a);
//        exit;
        return $query->result_array();
    }

    function getTitleCount($city_id, $category_id, $current_date) {

        $query = $this->db->query("select * from posts WHERE FIND_IN_SET(" . $city_id . ",city) AND subcategory ='$category_id' AND payment_status ='complete' AND date <= '$current_date' AND status ='Active' ORDER BY move_to_ad DESC");
        return $query->num_rows();
    }

    function get_title_ads($state_id, $category_id, $current_date, $limit_start = null, $limit_end = null) {
        if ($limit_start && $limit_end) {
            $lim = "LIMIT $limit_end ,$limit_start";
        }

        if ($limit_start != null) {
            $lim = "LIMIT $limit_end , $limit_start";
        }
        $query = $this->db->query("select * from posts WHERE FIND_IN_SET(" . $state_id . ",state) AND subcategory ='$category_id' AND payment_status ='complete' AND date <= '$current_date' AND status ='Active' ORDER BY move_to_ad DESC $lim");
        $a = $this->db->last_query();
//        echo "<pre>";
//        print_r($a);
//        exit;
        return $query->result_array();
    }

    function get_title_ads_count($state_id, $category_id, $current_date) {
        $query = $this->db->query("select * from posts WHERE FIND_IN_SET(" . $state_id . ",state) AND subcategory ='$category_id' AND payment_status ='complete' AND date <= '$current_date' AND status ='Active' ORDER BY move_to_ad DESC");
        return $query->num_rows();
    }

    function searching_post_data($title, $sub_category_id, $fields, $country_child, $limit_start = null, $limit_end = null) {
        $this->db->select('*');
        $this->db->from('posts');
        if (!empty($title)) {
//            $this->db->like('title', $title, 'after');
            $this->db->like('title', $title, 'after');
        }
        $this->db->where('subcategory', $sub_category_id);
        $this->db->where($fields, $country_child);
        $this->db->where('payment_status', 'complete');
        $this->db->where('status', 'Active');
        $this->db->order_by("move_to_ad", "desc");

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        exit;
        return $query->result_array();
    }

    function searching_post_data_count($title, $sub_category_id, $fields, $country_child) {
        $this->db->select('*');
        $this->db->from('posts');
        if ($title) {
            $this->db->like('title', $title);
        }
        $this->db->where('subcategory', $sub_category_id);
        $this->db->where($fields, $country_child);
        $this->db->where('payment_status', 'complete');
        $this->db->where('status', 'Active');
        $this->db->order_by("move_to_ad", "desc");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function searching_post_data_by_category($title, $category_id, $field, $country_child, $limit_start = null, $limit_end = null) {
        $this->db->select('*');
        $this->db->from('posts');

        if ($title) {
            $this->db->like('title', $title);
        }
        $this->db->where('category', $category_id);
        $this->db->where($field, $country_child);
        $this->db->where('payment_status', 'complete');
        $this->db->where('status', 'Active');
        $this->db->order_by("move_to_ad", "desc");

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function searching_post_data_count_by_category($title, $category_id, $field, $country_child) {
        $this->db->select('*');
        $this->db->from('posts');
        if ($title) {
            $this->db->like('title', $title);
        }
        $this->db->where('category', $category_id);
        $this->db->where($field, $country_child);
        $this->db->where('payment_status', 'complete');
        $this->db->where('status', 'Active');
        $this->db->order_by("move_to_ad", "desc");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function searching_post_data_by_category_sponser($title, $category_id, $field, $country_child, $sponser_field, $sponser_value) {
        $this->db->select('*');
        $this->db->from('posts');

        if ($title) {
            $this->db->like('title', $title);
        }
        $this->db->where('category', $category_id);
        $this->db->where($field, $country_child);
        $this->db->where($sponser_field, $sponser_value);
        $this->db->where('payment_status', 'complete');
        $this->db->where('status', 'Active');
        $this->db->order_by("move_to_ad", "desc");
        $query = $this->db->get();
        $a = $this->db->last_query();
//        echo "<pre>";
//        print_r($a);
//        exit;
        return $query->result_array();
    }

    function searching_post_data_by_sub_category_sponser($title, $sub_category_id, $field, $country_child, $sponser_field, $sponser_value) {
        $this->db->select('*');
        $this->db->from('posts');

        if ($title) {
            $this->db->like('title', $title);
        }
        $this->db->where('subcategory', $sub_category_id);
        $this->db->where($field, $country_child);
        $this->db->where($sponser_field, $sponser_value);
        $this->db->where('payment_status', 'complete');
        $this->db->where('status', 'Active');
        $this->db->order_by("move_to_ad", "desc");
        $query = $this->db->get();
        $a = $this->db->last_query();
        return $query->result_array();
    }

    function post_data_by_category_sponser($city_id, $category_id, $field, $country_child, $sponser_field, $sponser_value) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('subcategory', $category_id);
        $this->db->where($field, $country_child);
        $this->db->where($sponser_field, $sponser_value);
        $this->db->where('payment_status', 'complete');
        $this->db->where('status', 'Active');
        $this->db->order_by("move_to_ad", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

}
