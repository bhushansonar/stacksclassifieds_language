<?php

class Single_city extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('single_city_model');
        $this->load->model('common_model');
        $this->load->helper('url');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {
        $data['country_opt'] = $this->single_city_model->getAllCountry();
        $data['main_content'] = 'single_city_view';
        $this->load->view('includes/template', $data);
    }

    /**
     * encript the password
     * @return mixed
     */
}

