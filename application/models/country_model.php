<?php

class country_model extends CI_Model {

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
    public function get_country_by_id($id) {
        $this->db->select('*');
        $this->db->from('country');
        $this->db->where('country_id', $id);
        $query = $this->db->get();
//        echo $b = $this->db->last_query();
//        exit;
        return $query->result_array();
    }

    /**
     * Fetch country data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_country($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('country');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        //$this->db->order_by('status', 'Active');

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('country_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('country_id', $order_type);
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
    function count_country($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('country');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('country_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
//    function getCountryPathById($iCatId) {
//
//        $sql_query = "select path FROM country where country_id='$iCatId'";
//        $query = $this->db->query($sql_query);
//        $db_cat_rs = $query->result_array();
//        return $db_cat_rs[0]['path'];
//    }

    function store_country($insertArr) {
        $insert = $this->db->insert('country', $insertArr);
        return $insert;
    }

    /**
     * Update country
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_country($id, $data) {
        $this->db->where('country_id', $id);
        $this->db->update('country', $data);
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
     * Delete countryr
     * @param int $id - country id
     * @return boolean
     */
    function delete_country($id) {
        $this->db->where('country_id', $id);
        $this->db->delete('country');
    }

}

?>