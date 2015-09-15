<?php

class Multiple_city extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('multiple_city_model');
        $this->load->model('common_model');
        $this->load->helper('url');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {
        //$this->load->helper('url');
    }

    function city_multiple() {
        $subcategory_name_url = $this->uri->segment(4);
        $cat_id = $this->uri->segment(3);

        $whereStr = "AND category_id={$cat_id}";
        $parent = $this->common_model->getFieldData('category', 'parent_id', $whereStr);
        $cat_flag = $this->session->userdata('cat_flag');

//        if ($parent == '11' || $parent == '4') {
//            $session = array(
//                'cat_flag' => '2',
//            );
//            $this->session->set_userdata($session);
//        }
//        echo "<pre>";
//        print_r($this->session->all_userdata());
//        exit;
        $session = array(
            'sub_category' => $cat_id,
        );
        $this->session->set_userdata($session);
        $where_subcategory = " AND category_id={$cat_id}";
        $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $where_category = " AND category_id={$parent}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_category);

        //$this->session->set_userdata($session);
        $data['sub_category'] = $cat_id;
        $data['main_content'] = 'multiple_city_view';
        $data['country_opt'] = $this->multiple_city_model->getAllCountry();
        $data['parent_id'] = $this->multiple_city_model->get_parent_id($cat_id);
        $this->load->view('includes/template', $data);
    }

    function check_city() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['category'] = $category_id = $this->session->userdata('category');

            $data['country_opt'] = $this->multiple_city_model->getAllCountry();
            $data['sub_category'] = $sub_category_id = $this->session->userdata('sub_category');
            $where_subcategory = " AND category_id={$data['sub_category']}";
            $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

            $where_subcategory1 = " AND category_id={$data['category']}";
            $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory1);


            $this->form_validation->set_rules('total', 'total', 'required');
            $this->form_validation->set_rules('city', 'city', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            if ($this->form_validation->run()) {
                $multiple_city_id = $this->multiple_city_model->addMultiplecity();
                $session = array(
                    'multiple_city_id' => $multiple_city_id,
                    'total' => $_POST['total'],
                );

                $this->session->set_userdata($session);
                if ($multiple_city_id) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect("post_national_ads/add");
                } else {
                    if (!$this->recaptcha->getIsValid()) {
                        $this->session->set_flashdata('flash_message', 'Wrong captcha');
                        $this->session->set_flashdata('flash_class', 'alert-error');
                    } else {
                        $this->session->set_flashdata('flash_message', 'add Successfully');
                        $this->session->set_flashdata('flash_class', 'alert-error');
                    }
                    $data['flash_message'] = FALSE;
                }
            }
        }

        $data['main_content'] = 'multiple_city_view';
        $this->load->view('includes/template', $data);
    }

}

