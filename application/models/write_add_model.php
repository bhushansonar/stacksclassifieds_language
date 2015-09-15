<?php

class write_add_model extends CI_Model {

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
    public function get_posts_by_id($id) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('posts_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_category_name_by_id($category_id) {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('category_name', $category_id);
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

        $this->db->select('*');
        $this->db->from('posts');
        $this->db->join('country', 'country.country_id = posts.country', 'left');
        $this->db->join('state', 'state.state_id = posts.state', 'left');
        $this->db->join('city', 'city.city_id = posts.city', 'left');
        //echo "where->".$wherestatus;
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
        $this->db->insert('posts', $data);
        return $this->db->insert_id();
    }

    function add_temp_post($data) {
        $this->db->insert('posts', $data);
        return $this->db->insert_id();
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

    public function get_post_content_by_id($data) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('posts_id', $data);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_promocode($promocode_name, $status) {
        $this->db->select('*');
        $this->db->from('promocode');
        $this->db->where('promocode_name', $promocode_name);
        $this->db->where('status', $status);
        $query = $this->db->get();
        return $query->result_array();
    }

    function updateStatus($posts_id, $data) {
        $this->db->where('posts_id', $posts_id);
        $this->db->update('posts', $data);
    }

    function get_category_by_posts_id($posts_id) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('posts_id', $posts_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_posts_cron() {
        $this->db->select('*');
        $this->db->from('posts');
//        $this->db->where('posts_id', '75');
//        $this->db->where('ads_type', 'free');
        $this->db->where('status', 'Active');
        $query = $this->db->get();
        return $query->result_array();
    }

}

?>