<?php

class payment_model extends CI_Model {

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
    function add_payment($data) {
        $this->db->insert('payment', $data);
        return $this->db->insert_id();
    }

}

?>