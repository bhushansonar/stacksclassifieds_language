<?php

class Choose_location extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('choose_location_model');
        $this->load->model('common_model');
        $this->load->helper('url');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {

        $selectTypes_sess = $this->session->userdata('stack_select_type');
        $stack_state_id_sess = $this->session->userdata('stack_state_id');
        $stack_city_id_sess = $this->session->userdata('stack_city_id');
        if (isset($stack_city_id_sess)) {
            $stack_city_id = $stack_city_id_sess;
        } else {
            echo "You haven't direct access please select city";
        }
        if (isset($stack_state_id_sess)) {

            $stack_state_id = $stack_state_id_sess;
        } else {
            echo "You haven't direct access please select state";
        }
        if (isset($selectTypes_sess)) {
            $selectTypes = $selectTypes_sess;
        } else {
            echo "You haven't direct access please select type";
        }
        $data['sub_cat'] = $sub_category_id = $this->uri->segment(3);
        $where_subcategory = " AND category_id={$sub_category_id}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $whereStr = "AND category_id={$sub_category_id}";
        $parent = $this->common_model->getFieldData('category', 'parent_id', $whereStr);

        $where_category = " AND category_id={$parent}";
        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_category);
        $session = array(
            'sub_category' => $data['sub_cat'],
        );

        $this->session->set_userdata($session);


        if ($selectTypes == 'state') {
            $data['content'] = $this->choose_location_model->getCity_by_field_value('state_id', $stack_state_id);
        } else if ($selectTypes == 'city') {

            $where = " AND city_id={$stack_city_id}";
            $states_id = $this->common_model->getFieldData('city', 'state_id', $where);
            $data['content'] = $this->choose_location_model->getCity_by_field_value('state_id', $states_id);
        } else {
            $data['city_id'] = $city_id = $this->uri->segment(4);
            $whereCity = " AND city_id={$city_id}";
            $states_id = $this->common_model->getFieldData('city', 'state_id', $whereCity);
            $data['content'] = $this->choose_location_model->getCity_by_field_value('state_id', $states_id);
        }

        $data['main_content'] = 'choose_location_view';
        $this->load->view('includes/template', $data);
    }

    /**
     * encript the password
     * @return mixed
     */
}

