<?php

class State_category extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('state_category_model');
        $this->load->model('common_model');
        $this->load->model('country_model');
        $this->load->helper('url');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {

    }

    function cat() {
        $data['state_id'] = $state_id = $this->uri->segment(3);
        $seletctType = 'state';
        $this->session->unset_userdata('stack_city_id');
        $this->session->unset_userdata('stack_select_type');
        $session = array(
            'stack_state_id' => $state_id,
            'stack_select_type' => $seletctType
        );
        $this->session->set_userdata($session);
        $state_data = $this->state_category_model->get_state_by_Where_array(array('state_id'), array($state_id));
        $country_id = $state_data[0]['country_id'];
        $country_data = $this->country_model->get_country_by_id($country_id);
        $data['country_language_shortcode'] = !empty($country_data[0]['language_shortcode']) ? $country_data[0]['language_shortcode'] : "en";

//        if ($data['country_language_shortcode'] != Do_language::GetSessionLang()) {
//            $sessiondata = array(
//                'language_shortcode' => $data['country_language_shortcode'],
//            );
//
//            $this->session->set_userdata($sessiondata);
//        }
//$post_content = $this->state_category_model->get_posts_field_by_state('state', $state_id);
        $where_category = "`parent_id` = '0'";
        $data['cat'] = $this->state_category_model->getAllcategory($where_category);
        $data['main_content'] = 'state_category_view';
        $this->load->view('includes/template', $data);
    }

}

