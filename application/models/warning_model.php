<?php

class warning_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    /*     * age_verify
     * Get product by his is
     * @param int $product_id 
     * @return array
     */

    public function get_data_from_age_verify() {
        $this->db->select('*');
        $this->db->from('age_verify');
        $query = $this->db->get();
        return $query->result_array();
    }

}

?>