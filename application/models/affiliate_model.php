<?php

class affiliate_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    function getAllCity() {
        $this->db->select('*');
        $this->db->from('city');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getAllCategory() {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('parent_id !=', 0);
        $this->db->order_by('path');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function post_ads($order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null, $email) {

        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('email', $email);
        $this->db->where('status', 'Active');
        $this->db->group_by('posts_id');
        $this->db->order_by('posts_id', $order_type);
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

    function count_post_ads($search_string = null, $order = null, $email) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('email', $email);
        $this->db->where('status', 'Active');
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('posts_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function post_account_ads($order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null, $email) {

        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('email', $email);
        $this->db->where('status', 'Active');
        $this->db->group_by('posts_id');
        $this->db->order_by('posts_id', $order_type);
        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function count_account_post($field, $value) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where($field, $value);
        $this->db->where('status', 'Active');
        $this->db->order_by('posts_id', 'Asc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function earning_report($email) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('primary_email', $email);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_data_by_id($table, $field, $value) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where_in($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    function store_affiliate($data) {
        $insert = $this->db->insert('affiliate', $data);
        return $insert;
    }

    public function get_affiliate($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('affiliate');
        if ($wherestatus != null) {
            $this->db->where(
                    'status', $wherestatus);
        }
        if ($search_string) {
            $this->db->like($order, $search_string);
        } $this->db->group_by('affiliate_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('affiliate_id', $order_type);
        }

        if (
                $limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        } $query = $this->db->get();

        return $query->result_array();
    }

    public function get_users() {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('status', 'Active');
        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_affiliate($search_string = null, $order = null) {

        $this->db->select('*');
        $this->db->from('affiliate');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('affiliate_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_affiliate_by_id($id) {
        $this->db->select('*');
        $this->db->from('affiliate');
        $this->db->where('affiliate_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_affiliate($id, $data) {
        $this->db->where('affiliate_id', $id);
        $this->db->update('affiliate', $data);
        $report = array();


        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete_affiliate($id) {
        $this->db->where('affiliate_id', $id);
        $this->db->delete('affiliate');
    }

    function store_payment_info($data) {
        $insert = $this->db->insert('credit_card_details', $data);
        return $this->db->insert_id();
    }

    function validate_affiliate_front($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        //$this->db->where('type', 'affiliate');
        $this->db->where('account_confirmed', 'YES');
        $this->db->where('status', 'Active');
        $query = $this->db->get('user');
        if ($query->num_rows == 1) {
            return true;
        }
    }

    function validate_front_affiliate_account_confirm($username) {
        $this->db->where('username', $username);
        $this->db->where('type', 'affiliate');
        $this->db->where('account_confirmed', 'YES');
        $this->db->where('status', 'Active');
        $query = $this->db->get('user');
        if ($query->num_rows == 1) {
            return true;
        }
    }

    function get_user_id($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('user');

        if ($query->num_rows == 1) {
            return $query->result();
        }
    }

}

