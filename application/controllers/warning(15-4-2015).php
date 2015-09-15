<?php

class warning extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('warning_model');
        $this->load->model('common_model');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
//redirect('admin/login');
        }
    }

    function index() {

    }

    function warning_data() {
        $data['multiple_city'] = "";
        $data['category'] = $category_id = $this->session->userdata('category');
        $data['sub_category'] = $this->session->userdata('sub_category');

        $data['city_id'] = $city_id = $this->uri->segment(3);
//        $des = $this->warning_model->get_data_from_age_verify();
//        $data['description'] = $des[0]['description'];

        $where = " AND city_id='{$city_id}'";
        $data['city_name'] = $city_name = $this->common_model->getFieldData('city', 'city_name', $where);
        $city_contry_id = $this->common_model->getFieldData('city', 'country_id', $where);

        $where_country = " AND country_id='{$city_contry_id}'";
        $currency_type = $this->common_model->getFieldData('country', 'currency_type', $where_country);

        $session = array(
            'stack_city_id' => $city_id,
            'currency_type' => $currency_type,
        );
        $this->session->set_userdata($session);

        //$cat_flag = $this->session->userdata('cat_flag');
        if ($category_id == '11' || $category_id == '4') {
            $block_name = "age_verify";
            $data['warning_block'] = $block_name;
            $data['main_content'] = 'warning_view';
            $this->load->view('includes/template', $data);
        } else {
            redirect('write_add/add/' . $city_id . '/' . $city_name);
        }
    }

    function warning_multiple_city() {
        $data['sub_category_id'] = $sub_category_id = $this->uri->segment(3);
        $data['sub_category_name'] = $sub_category_name = $this->uri->segment(4);
//        $des = $this->warning_model->get_data_from_age_verify();
//        $data['description'] = $des[0]['description'];
        $session = array(
            'sub_category' => $sub_category_id,
        );
        $category_id = $this->session->userdata('category');
        $cat_flag = $this->session->userdata('cat_flag');

        if ($category_id == '11' || $category_id == '4') {
//            if ($cat_flag == '2') {
//                redirect('multiple_city/city_multiple/' . $sub_category_id . '/' . $sub_category_name);
//            } else {
            $block_name = "posting_adult_ads";
            $data['warning_block'] = $block_name;
            $data['multiple_city'] = "multiple";
            $data['main_content'] = 'warning_view';
            $this->load->view('includes/template', $data);
            //}
        } else {
            redirect('multiple_city/city_multiple/' . $sub_category_id . '/' . $sub_category_name);
        }
    }

    function warning_data_front() {

        $stack_select_type = $this->session->userdata('stack_select_type');
        $cat_flag = $this->session->userdata('cat_flag');

        if ($stack_select_type == 'city') {
            $data['id'] = $city_id = $this->uri->segment(3);
            $data['sub_category_id'] = $sub_category_id = $this->uri->segment(4);
            $data['type'] = "city";
            $whereStr = "AND city_id={$city_id}";
            $data['name'] = $this->common_model->getFieldData('city', 'city_name', $whereStr);
//            if ($cat_flag == '2') {
//                redirect("heading/getAlltitle/$city_id/$sub_category_id");
//            }
        } else {
            $data['id'] = $state_id = $this->uri->segment(3);
            $data['sub_category_id'] = $sub_category_id = $this->uri->segment(4);
            $data['type'] = "state";
            $whereStr = "AND state_id={$state_id}";
            $data['name'] = $this->common_model->getFieldData('state', 'state_name', $whereStr);
//            if ($cat_flag == '2') {
//                redirect("heading/get_all_title_data/$state_id/$sub_category_id");
//            }
        }

        $block_name = "viewing_adult_ads";
        $data['warning_block'] = $block_name;
        $data['main_content'] = 'warning_front_view';
        $this->load->view('includes/template', $data);
    }

    function warning_data_by_search_category() {

        $stack_select_type = $this->session->userdata('stack_select_type');
        if ($stack_select_type == 'city') {

            $data['id'] = $city_id = $this->uri->segment(3);
            $data['category_id'] = $category_id = $this->uri->segment(4);
            $data['search_text'] = $category_id = $this->uri->segment(5);
            $data['type'] = "city";
            $whereStr = "AND city_id={$city_id}";
            $data['name'] = $this->common_model->getFieldData('city', 'city_name', $whereStr);
//            if ($cat_flag == '2') {
//                redirect("heading/getAlltitle/$city_id/$sub_category_id");
//            }
        } else {
            $data['id'] = $state_id = $this->uri->segment(3);
            $data['category_id'] = $category_id = $this->uri->segment(4);
            $data['search_text'] = $this->uri->segment(5);
            $data['type'] = "state";
            $whereStr = "AND state_id={$state_id}";
            $data['name'] = $this->common_model->getFieldData('state', 'state_name', $whereStr);
        }

        $des = $this->warning_model->get_data_from_age_verify();
        $data['description'] = $des[0]['description'];
        $data['main_content'] = 'warning_by_search_category_view';
        $this->load->view('includes/template', $data);
    }

}

