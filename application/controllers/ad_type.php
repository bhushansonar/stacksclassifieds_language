<?php

class Ad_type extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('common_model');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {
        $data['state_id'] = $state_id = $this->session->userdata('stack_state_id');
        $data['city_id'] = $city_id = $this->session->userdata('stack_city_id');

        $multiple = $this->uri->segment(3);

        if ($multiple == 'multiple') {
            $this->session->unset_userdata('stack_city_id');
            $this->session->unset_userdata('stack_state_id');
            $data['main_content'] = 'ad_type_view';
        } else if (isset($state_id) && !empty($state_id)) {
            $whereState = " AND state_id='{$state_id}'";
            $state_name = $this->common_model->getFieldData('state', 'state_name', $whereState);
            redirect("add_post/addpostdata/$state_id/$state_name");
        } else if (isset($city_id) && !empty($city_id)) {

            $whereCity = " AND city_id='{$city_id}'";
            $city_name = $this->common_model->getFieldData('city', 'city_name', $whereCity);
            redirect("add_post/addpostdata/$city_id/$city_name");
        } else {
            $data['main_content'] = 'ad_type_view';
        }
        $this->load->view('includes/template', $data);
    }

    function cat() {
        $data['main_content'] = 'ad_type_view';
        $parent_id = 0;
        $this->load->view('includes/template', $data);
    }

    /**
     * encript the password
     * @return mixed
     */
}

