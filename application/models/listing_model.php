<?php

class listing_model extends CI_Model {

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
	
	public function get_posts_category_id($id) {
        $this->db->select('category');
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
    public function get_posts($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null,$uid) {

        $this->db->select('*');
        $this->db->from('posts');
		$this->db->where('uid', $uid);
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

    
    /**
     * Update category
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_posts() {
		$parent = $_POST['category']; 
		if( $parent == 1 || $parent == 2 )
		{
        $insertArr['selling_price'] = $_POST['selling_price'];
		}
	if( $parent == 2 || $parent == 5 || $parent == 10 || $parent == 8 || $parent == 9 || $parent == 1)
		{
		$insertArr['location'] = $_POST['location'];
		}
		
	if( $parent == 5 )
		{
		$insertArr['salary'] = $_POST['salary'];
		$insertArr['education'] = $_POST['education'];
		$insertArr['shift'] = implode(',',$_POST['shift']);
		$insertArr['work_status'] = implode(',',$_POST['work_status']);
		
		}
	if( $parent == 8 )
		{ 
		$insertArr['price'] = $_POST['price'];
		$insertArr['bedrooms'] = $_POST['bedrooms'];
		}
	if( $parent == 9 )
		{
		$insertArr['ad_placed_by'] = $_POST['ad_placed_by'];
		$insertArr['fees_paid_by'] = $_POST['fees_paid_by'];
		$insertArr['pets'] = $_POST['pets'];
		
        return $insert;
		}
	if( $parent == 4 || $parent == 11 )
		{
		$insertArr['age'] = $_POST['age'];
		}
		
		$insertArr['category'] = $_POST['category'];
        $insertArr['subcategory'] = $_POST['subcategory'];
        $insertArr['country'] = $_POST['country'];
        $insertArr['state'] = $_POST['state'];
        $insertArr['city'] = $_POST['city'];
       
        $insertArr['title'] = $_POST['title'];
       
        $insertArr['images'] = $_POST['images'];
        $insertArr['description'] = $_POST['description'];
        $insertArr['email'] = $_POST['email'];
       
        $where['posts_id'] = $_POST['posts_id'];
        $this->db->update('posts', $insertArr, $where);
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

}

?>