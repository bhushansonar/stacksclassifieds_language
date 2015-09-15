<?php

class Add_post extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('add_post_model');
        $this->load->model('common_model');
        $this->load->helper('url');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    public function addpostdata() {

        $parent_id = 0;
        if (!empty($_POST['post_city'])) {
            $stack_city_id = $_POST['post_city'];
            $data['post_city_id'] = $stack_city_id;
            $whereStr = " AND city_id={$stack_city_id}";
            $data['name'] = $this->common_model->getFieldData('city', 'city_name', $whereStr);
        } else {
            $stack_city_id = $this->uri->segment(3);
            $data['name'] = $this->uri->segment(4);
        }

        if ($stack_city_id == 'multiple') {
            $this->session->unset_userdata('stack_city_id');
        } else if (!empty($stack_city_id)) {
            $session = array(
                'stack_city_id' => $stack_city_id,
            );
            $this->session->set_userdata($session);
        }
        $data['cat'] = $this->add_post_model->getAllcategory($parent_id);
        $data['main_content'] = 'add_post_view';
        $this->load->view('includes/template', $data);
    }

}

