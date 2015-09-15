<?php

class city_model extends CI_Model {

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
    public function get_city_by_id($id) {
        $this->db->select('*');
        $this->db->from('city');
        $this->db->where('city_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_city_category_price_by_id($id) {
        $this->db->select('*');
        $this->db->from('city_category_price');
        $this->db->where('city_category_price_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_category_by_city_id($id) {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('category_id', $id);
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        exit;
        return $query->result_array();
    }

    /**
     * Fetch city data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_city($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('city');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('city_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('city_id', $order_type);
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

    public function get_city_category_price($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('city_category_price');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('city_category_price_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('city_category_price_id', $order_type);
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
    function count_city($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('city');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('city_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_city_category_price($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('city_category_price');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('city_category_price_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_city() {

# -------------------------------------

        $insertArr = array();
        $insertArr['country_id'] = $_REQUEST['country'];
        $insertArr['state_id'] = $_REQUEST['state'];
        $insertArr['city_name'] = $_REQUEST['city_name'];
        $insert = $this->db->insert('city', $insertArr);
        return $insert;
    }

    function store_city_price($data) {

        $this->db->insert('city_category_price', $data);
        return $this->db->insert_id();
    }

    function update_city_price($id, $data) {

        $this->db->where('city_id', $id);
        $this->db->update('city', $data);

        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_city_price_by_id($id, $data) {

        $this->db->where('city_category_price_id', $id);
        $this->db->update('city_category_price', $data);

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
     * Update city
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_city($id, $data) {
        $this->db->where('city_id', $id);
        $this->db->update('city', $data);
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
     * Delete cityr
     * @param int $id - city id
     * @return boolean
     */
    function delete_city($id) {
        $this->db->where('city_id', $id);
        $this->db->delete('city');
    }

    function delete_city_price($id) {
        $this->db->where('city_category_price_id', $id);
        $this->db->delete('city_category_price');
    }

    function get_city_by_Where_array($where_field, $where_value) {
        $this->db->select('*');
        $this->db->from('city');
        if (count($where_field) > 0 && count($where_value) > 0) {
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_value[$i]);
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

}

?>