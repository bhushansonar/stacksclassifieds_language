<?php

class top_ads_model extends CI_Model {

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
    public function get_top_ads_by_id($id) {
        $this->db->select('*');
        $this->db->from('top_ads');
        $this->db->where('top_ads_id', $id);
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        exit;
        return $query->result_array();
    }

    public function get_category_by_top_ads_id($id) {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('category_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch top_ads data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_top_ads($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {
        $this->db->select('*,GROUP_CONCAT(DISTINCT category.category_name_en ORDER BY category.category_name_en) as g_category_name');
        $this->db->from('top_ads');
        $this->db->join('category', "FIND_IN_SET(category.category_id , `top_ads`.`category_id`) > 0", 'left');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('top_ads_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('top_ads_id', $order_type);
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
    function count_top_ads($search_string = null, $order = null) {
        $this->db->select('*,GROUP_CONCAT(DISTINCT category.category_name_en ORDER BY category.category_name_en) as g_category_name');
        $this->db->from('top_ads');
        $this->db->join('category', "FIND_IN_SET(category.category_id , `top_ads`.`category_id`) > 0", 'left');

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('top_ads_id', 'Asc');
        }
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        exit;
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_top_ads($data) {

# -------------------------------------

        $insert = $this->db->insert('top_ads', $data);
        return $insert;
    }

    /**
     * Update top_ads
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_top_ads($id, $data) {
        $this->db->where('top_ads_id', $id);
        $this->db->update('top_ads', $data);
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
     * Delete top_adsr
     * @param int $id - top_ads id
     * @return boolean
     */
    function delete_top_ads($id) {
        $this->db->where('top_ads_id', $id);
        $this->db->delete('top_ads');
    }

    public function get_top_ads_front() {
        $counter = "0";
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('top_ads_counter !=', $counter);
        $this->db->order_by('top_ads_counter', 'DESC');
        $this->db->limit(20);
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        exit;
        return $query->result_array();
    }

}

?>