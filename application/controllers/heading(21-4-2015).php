<?php

class Heading extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('heading_model');
        $this->load->model('common_model');
        $this->load->helper('url');
        $this->load->helper('smiley');
        $this->session->unset_userdata('page_type');
//        $this->load->library('table');

        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {

        $this->load->helper('url');
    }

    function getDetails() {
        $data['main_content'] = 'heading_view';
        $category_id = $this->uri->segment(3);
        $data['tit'] = $this->heading_model->getAlltitle($category_id);
        $this->load->view('includes/template', $data);
    }

    function getAlltitle() {

        $data['city_id'] = $city_id = $this->uri->segment(3);
        $data['sub_category_id'] = $category_id = $this->uri->segment(4);

        $city_state = " AND city_id={$city_id}";
        $data['state'] = $city_state = $this->common_model->getFieldData('city', 'state_id', $city_state);
        $where_city_state = "AND state_id={$city_state}";
        $data['state_city_name'] = $this->common_model->get_content_by_field('city', 'state_id', $city_state);

        $where_city = " AND city_id={$city_id}";
        $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $where_city);

        $where_subcategory = " AND category_id={$data['sub_category_id']}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $whereStr = "AND category_id={$category_id}";
        $data['parent'] = $parent = $this->common_model->getFieldData('category', 'parent_id', $whereStr);

        $where_category = " AND category_id={$parent}";
        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_category);
//        echo "<pre>";
//        print_r($data['category']);
//        exit;
//        all_sub_cat
        //$lang_shortcode = Do_language::GetSessionLang();
        //$where = " AND parent_id={$parent}";
        $data['all_sub_cat'] = $this->common_model->get_content_by_field('category', 'parent_id', $parent);




// $category_content = $this->common_model->getDDArray('category', 'category_id', 'category_name_' . $lang_shortcode, $where);
//        echo "<pre>";
//        print_r($category_content);
//        exit;
//        unset($category_content['']);
//        $data['all_sub_cat'] = $category_content;

        $session = array(
            'stack_category_id' => $parent,
            'stack_subcategory_id' => $data['sub_category_id'],
        );
        $this->session->set_userdata($session);
        $current_date = date('Y-m-d H:i:s');
        $config['per_page'] = 30;
        $config["uri_segment"] = 5;
        $config['base_url'] = base_url() . 'heading/getAlltitle/' . $city_id . '/' . $category_id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 25;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $page = $this->uri->segment(5);

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['tit'] = $this->heading_model->getTitle($city_id, $category_id, $current_date, $config['per_page'], $limit_end);
        $data['count_products'] = $this->heading_model->getTitleCount($city_id, $category_id, $current_date);
        $config['total_rows'] = $data['count_products'];
        $fields = 'city';
        $sponser_field = "featured_ad";
        $sponser_value = "yes";
        $country_child = $city_id;
        $data['sponser_heading_data'] = $this->heading_model->post_data_by_category_sponser($city_id, $category_id, $fields, $country_child, $sponser_field, $sponser_value);
        $this->pagination->initialize($config);
        $data['main_content'] = 'heading_view';
        $this->load->view('includes/template', $data);
    }

    function get_all_title_data() {


        $data['state_id'] = $state_id = $this->uri->segment(3);
        $data['sub_category_id'] = $category_id = $this->uri->segment(4);
        $data['state_city_name'] = $this->common_model->get_content_by_field('city', 'state_id', $state_id);

        $where_state = " AND state_id={$state_id}";
        $data['state_name'] = $this->common_model->getFieldData('state', 'state_name', $where_state);

        $where_subcategory = " AND category_id={$data['sub_category_id']}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $whereStr = "AND category_id={$category_id}";
        $data['parent'] = $parent = $this->common_model->getFieldData('category', 'parent_id', $whereStr);

        $where_category = " AND category_id={$parent}";
        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_category);
//        $lang_shortcode = Do_language::GetSessionLang();
//        $where = " AND parent_id={$parent}";
//        $data['get_subcategory'] = $this->common_model->getDDArray('category', 'category_id', 'category_name_' . $lang_shortcode, $where);

        $data['all_sub_cat'] = $this->common_model->get_content_by_field('category', 'parent_id', $parent);
        $session = array(
            'stack_category_id' => $parent,
            'stack_subcategory_id' => $data['sub_category_id'],
        );

        $this->session->set_userdata($session);
        $current_date = date('Y-m-d H:i:s');
        $config['per_page'] = 30;
        $config["uri_segment"] = 5;
        $config['base_url'] = base_url() . 'heading/get_all_title_data/' . $state_id . '/' . $category_id;
        $config['use_page_numbers'] = TRUE;

        $config['num_links'] = 5;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $page = $this->uri->segment(5);

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['title'] = $this->heading_model->get_title_ads($state_id, $category_id, $current_date, $config['per_page'], $limit_end);
        $data['count_products'] = $this->heading_model->get_title_ads_count($state_id, $category_id, $current_date);
        $config['total_rows'] = $data['count_products'];
        $fields = 'state';
        $sponser_field = "featured_ad";
        $sponser_value = "yes";
        $country_child = $state_id;
        $data['sponser_heading_data'] = $this->heading_model->post_data_by_category_sponser($state_id, $category_id, $fields, $country_child, $sponser_field, $sponser_value);
        $this->pagination->initialize($config);
        $data['main_content'] = 'heading_view';
        $this->load->view('includes/template', $data);
    }

    function get_seraching_data() {
        $data['city_id'] = $session_city_id = $this->session->userdata('stack_city_id');
        $data['state_id'] = $session_state_id = $this->session->userdata('stack_state_id');
        //echo $_POST['search_text'];
        if (!empty($_POST['search_text'])) {
            $search_text = @base64_encode(serialize($_POST['search_text']));
        } else {
            $search_text = "";
        }
        $search_category = @$_POST['search_category'];
        if (isset($session_city_id) && !empty($session_city_id)) {
            $country_child = $session_city_id;
            $fields = 'city';
        } else {
            $country_child = $session_state_id;
            $fields = 'state';
        }
        if (isset($search_category)) {
            $session = array(
                'searching_category_id' => $search_category,
            );

            $this->session->set_userdata($session);
            $data['sub_category_id'] = $sub_category_id = $search_category;
            $whereStr = "AND category_id={$sub_category_id}";
            $data['parent'] = $this->common_model->getFieldData('category', 'parent_id', $whereStr);
        } else {
            $whereStr = "AND category_id={$this->session->userdata('searching_category_id')}";
            $data['parent'] = $this->common_model->getFieldData('category', 'parent_id', $whereStr);
            $data['sub_category_id'] = $sub_category_id = $this->session->userdata('searching_category_id');
        }

        $whereStr = "AND category_id={$data['sub_category_id']}";
        $data['category_id'] = $parent = $this->common_model->getFieldData('category', 'parent_id', $whereStr);

        $data['sub_category_id'] = $data['sub_category_id'];
        $where_category = "AND category_id={$data ['category_id']}";

        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_category);
        $where_sub_category = "AND category_id={$data['sub_category_id']}";

        $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_sub_category);
        $where = " AND parent_id={$parent}";

        if (!empty($session_city_id)) {
            $where_city = "AND city_id={$session_city_id}";
            $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $where_city);
            $where_city_state = "AND city_id={$session_city_id}";
            $city_state = $this->common_model->getFieldData('city', 'state_id', $where_city_state);
            $data['state_city_name'] = $this->common_model->get_content_by_field('city', 'state_id', $city_state);
        } else {
            $where_city = "AND state_id={$session_state_id}";
            $data['city_name'] = $this->common_model->getFieldData('state', 'state_name', $where_city);
            $data['state_city_name'] = $this->common_model->get_content_by_field('city', 'state_id', $session_state_id);
        }
        $lang_shortcode = Do_language::GetSessionLang();
        $category_content = $this->common_model->getDDArray('category', 'category_id', 'category_name_' . $lang_shortcode, $where);
        unset($category_content ['']);
        $data['get_subcategory'] = $category_content;

        $config['per_page'] = 30;
        $config["uri_segment"] = 3;
        $config['base_url'] = base_url() . 'heading/get_seraching_data';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 25;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $page = $this->uri->segment(3);

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        $data['heading_data'] = $this->heading_model->searching_post_data($search_text, $sub_category_id, $fields, $country_child, $config['per_page'], $limit_end);

        $data['count_products'] = $this->heading_model->searching_post_data_count($search_text, $sub_category_id, $fields, $country_child);
        $config['total_rows'] = $data['count_products'];

        $sponser_field = "featured_ad";
        $sponser_value = "yes";
        $data['sponser_heading_data'] = $this->heading_model->searching_post_data_by_sub_category_sponser($search_text, $sub_category_id, $fields, $country_child, $sponser_field, $sponser_value);

        $this->pagination->initialize($config);
        $data['main_content'] = 'searching_heading_view';
        $this->load->view('includes/template', $data);
    }

    function get_seraching_data_by_category() {

        $data['city_id'] = $session_city_id = $this->session->userdata('stack_city_id');
        $data['state_id'] = $session_state_id = $this->session->userdata('stack_state_id');
        if (!empty($_POST['search_text'])) {
            $search_text = @base64_encode(serialize($_POST['search_text']));
        } else {
            $search_text = "";
        }
        $search_category = @$_POST['search_category'];
        if ($search_category == '11' || $search_category == '4') {
            $stack_select_type = $this->session->userdata('stack_select_type');
            if ($stack_select_type == 'state') {
                $id = $this->session->userdata('stack_state_id');
            } else {
                $id = $this->session->userdata('stack_city_id');
            }
        }

        $sponser_field = "featured_ad";
        $sponser_value = "yes";
        if (isset($session_city_id) && !empty($session_city_id)) {
            $country_child = $session_city_id;
            $fields = 'city';
        } else {
            $country_child = $session_state_id;
            $fields = 'state';
        }
        if (isset($search_category)) {
            $session = array(
                'searching_category_id' => $search_category,
                'search_text' => $search_text,
            );
            $this->session->set_userdata($session);
            $data['category_id'] = $category_id = $search_category;
            $data['search_text'] = $search_text = $search_text;
        } else {
            $data['category_id'] = $category_id = $this->session->userdata('searching_category_id');
            $data['search_text'] = $search_text = $this->session->userdata('search_text');
        }
        $data['sub_category_id'] = $category_id;
        if (!empty($session_city_id)) {
            $where_city = " AND city_id={$session_city_id}";
            $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $where_city);
            $where_city_state = "AND city_id={$session_city_id}";
            $city_state = $this->common_model->getFieldData('city', 'state_id', $where_city_state);
            $data['state_city_name'] = $this->common_model->get_content_by_field('city', 'state_id', $city_state);
        } else {
            $data['state_city_name'] = $this->common_model->get_content_by_field('city', 'state_id', $session_state_id);
        }
        $lang_shortcode = Do_language::GetSessionLang();
        $where = " AND parent_id = '$category_id'";
        $category_content = $this->common_model->getDDArray('category', 'category_id', 'category_name_' . $lang_shortcode, $where);
        unset($category_content['']);
        $data['get_category'] = $category_content;


        $config['per_page'] = 30;
        $config["uri_segment"] = 3;
        $config ['base_url'] = base_url() . 'heading/get_seraching_data_by_category';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 25;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $page = $this->uri->segment(3);

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        $data['heading_data'] = $this->heading_model->searching_post_data_by_category($search_text, $category_id, $fields, $country_child, $config['per_page'], $limit_end);

        $data['count_products'] = $this->heading_model->searching_post_data_count_by_category($search_text, $category_id, $fields, $country_child);
        $config['total_rows'] = $data['count_products'];
        $data['sponser_heading_data'] = $this->heading_model->searching_post_data_by_category_sponser($search_text, $category_id, $fields, $country_child, $sponser_field, $sponser_value);
        $this->pagination->initialize($config);
        $data['main_content'] = 'searching_content_by_category_view';
        $this->load->view(
                'includes/template', $data);
    }

    function get_summary_city() {
        $data['city_id'] = $city_id = $this->uri->segment(3);
        //$parent_id = $this->uri->segment(5);
        $data['sub_category_id'] = $category_id = $this->uri->segment(4);
        $city_state = " AND city_id={$city_id}";
        $data['state'] = $city_state = $this->common_model->getFieldData('city', 'state_id', $city_state);
        // $where_city_state = "AND state_id={$city_state}";
        $data['state_city_name'] = $this->common_model->get_content_by_field('city', 'state_id', $city_state);
//        unset($data['state_city_name']['']);

        $where_city = " AND city_id={$city_id}";
        $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $where_city);

        $where_subcategory = " AND category_id={$data['sub_category_id']}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $whereStr = "AND category_id={$category_id}";
        $data['parent'] = $parent = $this->common_model->getFieldData('category', 'parent_id', $whereStr);

        $where_category = " AND category_id={$parent}";
        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_category);
        $lang_shortcode = Do_language::GetSessionLang();
        $where = " AND parent_id={$parent}";
        $category_content = $this->common_model->getDDArray('category', 'category_id', 'category_name_' . $lang_shortcode, $where);
        unset($category_content['']);
        $data['get_subcategory'] = $category_content;

        $session = array(
            'stack_category_id' => $parent,
            'stack_subcategory_id' => $data['sub_category_id'],
        );
        $this->session->set_userdata($session);
        $current_date = date('Y-m-d H:i:s');
        $config['per_page'] = 30;
        $config["uri_segment"] = 5;
        $config ['base_url'] = base_url() . 'heading/get_summary_city/' . $city_id . '/' . $category_id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 25;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $page = $this->uri->segment(5);
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['tit'] = $this->heading_model->getTitle($city_id, $category_id, $current_date, $config['per_page'], $limit_end);
        $data['count_products'] = $this->heading_model->getTitleCount($city_id, $category_id, $current_date);
        $config['total_rows'] = $data['count_products'];
        $fields = 'city';
        $sponser_field = "featured_ad";
        $sponser_value = "yes";
        $country_child = $city_id;
        $data['sponser_heading_data'] = $this->heading_model->post_data_by_category_sponser($city_id, $category_id, $fields, $country_child, $sponser_field, $sponser_value);

        $this->pagination->initialize($config);
        $data['main_content'] = 'summary_view';
        $this->load->view(
                'includes/template', $data);
    }

    function get_summary_state() {
        $data['state_id'] = $state_id = $this->uri->segment(3);
        $data['sub_category_id'] = $category_id = $this->uri->segment(4);
        $data['state_city_name'] = $this->common_model->get_content_by_field('city', 'state_id', $state_id);
        $where_state = " AND state_id={$state_id}";
        $data ['state_name'] = $this->common_model->getFieldData('state', 'state_name', $where_state);

        $where_subcategory = " AND category_id={$data['sub_category_id']}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $whereStr = "AND category_id={$category_id}";
        $data['parent'] = $parent = $this->common_model->getFieldData('category', 'parent_id', $whereStr);

        $where_category = " AND category_id={$parent}";
        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_category);
        $lang_shortcode = Do_language::GetSessionLang();
        $where = " AND parent_id={$parent}";
        $data['get_subcategory'] = $this->common_model->getDDArray('category', 'category_id', 'category_name_' . $lang_shortcode, $where);
        $session = array(
            'stack_category_id' => $parent,
            'stack_subcategory_id' => $data['sub_category_id'],);

        $this->session->set_userdata($session);
        $current_date = date('Y-m-d H:i:s');
        $config['per_page'] = 30;
        $config["uri_segment"] = 5;
        $config ['base_url'] = base_url() . 'heading/get_all_title_data/' . $state_id . '/' . $category_id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 25;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $page = $this->uri->segment(5);
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['title'] = $this->heading_model->get_title_ads($state_id, $category_id, $current_date, $config['per_page'], $limit_end);
        $data['count_products'] = $this->heading_model->get_title_ads_count($state_id, $category_id, $current_date);
        $config['total_rows'] = $data['count_products'];
        $fields = 'state';
        $sponser_field = "featured_ad";
        $sponser_value = "yes";
        $country_child = $state_id;
        $data['sponser_heading_data'] = $this->heading_model->post_data_by_category_sponser($state_id, $category_id, $fields, $country_child, $sponser_field, $sponser_value);
        $this->pagination->initialize($config);
        $data['main_content'] = 'summary_view';
        $this->load->view(
                'includes/template', $data);
    }

    function gallery_city() {
        $data['city_id'] = $city_id = $this->uri->segment(3);
        $data['sub_category_id'] = $sub_category_id = $this->uri->segment(4);
        $city_state = " AND city_id={$city_id}";
        $data['state'] = $this->common_model->getFieldData('city', 'state_id', $city_state);

        $data['state_city_name'] = $this->common_model->get_content_by_field('city', 'state_id', $data['state']);

        $where_city = " AND city_id={$city_id}";
        $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $where_city);

        $where_subcategory = " AND category_id={$data['sub_category_id']}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $whereStr = "AND category_id={$sub_category_id}";
        $parent = $this->common_model->getFieldData('category', 'parent_id', $whereStr);

        $where_category = " AND category_id={$parent}";
        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_category);
        $lang_shortcode = Do_language::GetSessionLang();
        $where = " AND parent_id={$parent}";
        $category_content = $this->common_model->getDDArray('category', 'category_id', 'category_name_' . $lang_shortcode, $where);
        unset($category_content ['']);

        $data['get_subcategory'] = $category_content;

        $current_date = date('Y-m-d H:i:s');
        $config['per_page'] = 30;
        $config["uri_segment"] = 5;
        $config ['base_url'] = base_url() . 'heading/gallery_city/' . $city_id . '/' . $sub_category_id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 25;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $page = $this->uri->segment(5);
        $limit_end = ( $page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['tit'] = $this->heading_model->getTitle($city_id, $sub_category_id, $current_date, $config['per_page'], $limit_end);
        $data['count_products'] = $this->heading_model->getTitleCount($city_id, $sub_category_id, $current_date);
        $config['total_rows'] = $data['count_products'];
        $fields = 'city';
        $sponser_field = "featured_ad";
        $sponser_value = "yes";
        $country_child = $city_id;
        $data['sponser_heading_data'] = $this->heading_model->post_data_by_category_sponser($city_id, $sub_category_id, $fields, $country_child, $sponser_field, $sponser_value);

        $this->pagination->initialize($config);
        $data['main_content'] = 'gallery_view';
        $this->load->view(
                'includes/template', $data);
    }

    function gallery_state() {
        $data['state_id'] = $state_id = $this->uri->segment(3);
        $data['sub_category_id'] = $category_id = $this->uri->segment(4);
        $data ['state_city_name'] = $this->common_model->get_content_by_field('city', 'state_id', $state_id);
        $where_state = " AND state_id={$state_id}";
        $data ['state_name'] = $this->common_model->getFieldData('state', 'state_name', $where_state);

        $where_subcategory = " AND category_id={$data['sub_category_id']}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $whereStr = "AND category_id={$category_id}";
        $parent = $this->common_model->getFieldData('category', 'parent_id', $whereStr);
        $lang_shortcode = Do_language::GetSessionLang();
        $where_category = " AND category_id={$parent}";
        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_category);
        $where = " AND parent_id={$parent}";
        $data['get_subcategory'] = $this->common_model->getDDArray('category', 'category_id', 'category_name_' . $lang_shortcode, $where);

        $current_date = date('Y-m-d H:i:s');
        $config['per_page'] = 30;
        $config["uri_segment"] = 5;
        $config ['base_url'] = base_url() . 'heading/gallery_state/' . $state_id . '/' . $category_id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 25;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $page = $this->uri->segment(5);
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['title'] = $this->heading_model->get_title_ads($state_id, $category_id, $current_date, $config['per_page'], $limit_end);
        $data['count_products'] = $this->heading_model->get_title_ads_count($state_id, $category_id, $current_date);
        $config['total_rows'] = $data['count_products'];
        $fields = 'state';
        $sponser_field = "featured_ad";
        $sponser_value = "yes";
        $country_child = $state_id;
        $data['sponser_heading_data'] = $this->heading_model->post_data_by_category_sponser($state_id, $category_id, $fields, $country_child, $sponser_field, $sponser_value);
        $this->pagination->initialize($config);
        $data['main_content'] = 'gallery_view';
        $this->load->view('includes/template', $data);
    }

}

