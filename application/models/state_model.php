<?php

class state_model extends CI_Model {

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
    public function get_state_by_id($id) {
        $this->db->select('*');
        $this->db->from('state');
        $this->db->where('state_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    
    /**
     * Fetch state data from the database
     * possibility to mix search, filter and order
     * @param string $search_string 
     * @param strong $order
     * @param string $order_type 
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_state($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('state');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        //$this->db->order_by('status', 'Active');

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('state_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('state_id', $order_type);
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

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_state($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('state');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('state_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean 
     */


    function store_state() {

# -------------------------------------
       
        $insertArr = array();
        $insertArr['country_id'] = $_REQUEST['country'];
        $insertArr['state_name'] = $_REQUEST['state_name'];
        $insert = $this->db->insert('state', $insertArr);
        return $insert;
    }

    /**
     * Update state
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_state($id, $data) {
        $this->db->where('state_id', $id);
        $this->db->update('state', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete stater
     * @param int $id - state id
     * @return boolean
     */
    function delete_state($id) {
        $this->db->where('state_id', $id);
        $this->db->delete('state');
    }
}

?>