<?php

class posts_model extends CI_Model {

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
    public function get_posts_by_field($field, $value) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_posts_by_id($id) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('posts_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch category data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_posts($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

//        $this->db->select('*');
//        $this->db->from('posts');
//        $this->db->join('country', 'country.country_id = posts.country', 'left');
//        $this->db->join('state', 'state.state_id = posts.state', 'left');
//        $this->db->join('city', 'city.city_id = posts.city', 'left');
        //echo "where->".$wherestatus;


        $this->db->select('posts.*,GROUP_CONCAT(DISTINCT country.country_name ORDER BY country.country_name) as g_country_name,GROUP_CONCAT(DISTINCT state.state_name ORDER BY state.state_name) as g_state_name,GROUP_CONCAT(DISTINCT city.city_name ORDER BY city.city_name) as g_city_name');
        $this->db->from('posts');
        $this->db->join('country', "FIND_IN_SET(country.country_id , posts.country) > 0", 'left');
        $this->db->join('state', "FIND_IN_SET(state.state_id , posts.state) > 0", 'left');
        $this->db->join('city', "FIND_IN_SET(city.city_id , posts.city) > 0", 'left');


        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('posts.posts_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('posts.posts_id', $order_type);
        }

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

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_posts($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->join('country', 'country.country_id = posts.country', 'left');
        $this->db->join('state', 'state.state_id = posts.state', 'left');
        $this->db->join('city', 'city.city_id = posts.city', 'left');

        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('posts_id', 'Asc');
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
    function getCategoryPathById($iCatId) {

        $sql_query = "select path FROM posts where posts_id='$iCatId'";
        $query = $this->db->query($sql_query);
        $db_cat_rs = $query->result_array();
        return $db_cat_rs[0]['path'];
    }

    function addPosts($data) {
        $insert = $this->db->insert('posts', $data);
        return $insert;
    }

    /**
     * Update category
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_posts($id, $data) {

        $this->db->where('posts_id', $id);
        $this->db->update('posts', $data);
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
     * Delete categoryr
     * @param int $id - category id
     * @return boolean
     */
    function delete_posts($id) {
        $this->db->where('posts_id', $id);
        $this->db->delete('posts');
    }

    public function get_posts_detail() {
        $this->db->select('*');
        $this->db->from('posts');
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_posts_detail($id, $data) {
        $this->db->where('posts_id', $id);
        $this->db->update('posts', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

}

?>