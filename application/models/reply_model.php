<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class reply_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // $this->load->database();
    }

    public function form_data() {
        $data = array(
            'email' => $_POST['email'],
            'description' => $_POST['description'],
            'email_to' => $_POST['email_to']
        );
    }

    public function get_post_data_by_id($post_id) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('posts_id', $post_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function add_post_reply($data) {
        $this->db->insert('posts_reply', $data);
        return $this->db->insert_id();
    }

}