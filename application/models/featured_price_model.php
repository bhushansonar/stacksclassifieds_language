<?php

class featured_price_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    /**
     * Get product by his is
     * @param int $product_id
     * @return array
     */
    public function get_featured_price_by_id($id) {
        $this->db->select('*');
        $this->db->from('featured_price');
        $this->db->where('featured_price_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_featured_price($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('featured_price');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('featured_price_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('featured_price_id', $order_type);
        }

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    function count_featured_price($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('featured_price');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('featured_price_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function store_featured_price($data) {
        $insert = $this->db->insert('featured_price', $data);
        return $insert;
    }

    function update_featured_price($id, $data) {

        $this->db->where('featured_price_id', $id);
        $this->db->update('featured_price', $data);

        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete_featured_price($id) {
        $this->db->where('featured_price_id', $id);
        $this->db->delete('featured_price');
    }

}

?>