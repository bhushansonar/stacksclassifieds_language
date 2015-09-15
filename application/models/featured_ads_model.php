<?php

class featured_ads_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getAllFeatured() {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('status', 'Active');
        $this->db->where('payment_status', 'complete');
        $this->db->where('featured_ad', 'yes');
        $this->db->where('post_ads_type', 'single');
        $query = $this->db->get();
//        echo $abc = $this->db->last_query();
//        exit;
        return $query->result_array();
    }

}

