<?php

class demo extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('posts_model');
    }

    function index() {
        $post_details = $this->posts_model->get_posts_detail();
        for ($i = 0; $i < count($post_details); $i++) {
            $id = $post_details[$i]['posts_id'];
            $title = base64_encode(serialize($post_details[$i]['title']));
            $description = base64_encode(serialize($post_details[$i]['description']));
            $data_to_store = array(
                'title' => $title,
                'description' => $description
            );

            $this->posts_model->update_posts_detail($id, $data_to_store);
        }
    }

}

