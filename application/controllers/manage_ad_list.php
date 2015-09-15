<?php

class manage_ad_list extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('write_add_model');
        $this->load->model('common_model');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {

        $session = array(
            'type' => "affiliate",
        );

        $this->session->set_userdata($session);

        $data['main_content'] = 'signin_view';
        $this->load->view('includes/template', $data);
    }

    function check_default($post_string) {
        if ($post_string >= '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function manage_ad_detail() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('home');
        } else {
            $data['posts_id'] = $posts_id = $this->uri->segment(3);
            $today_date = date('Y-m-d');
            $after_today_date = strtotime($today_date);
            $where_post_id = " AND posts_id={$posts_id}";
            $expire_date = $this->common_model->getFieldData('posts', 'expire_date', $where_post_id);
            $after_expire_date = strtotime($expire_date);
            if ($after_expire_date >= $today_date) {
                $where_post = " AND posts_id={$posts_id}";
                $data['city'] = $city_id = $this->common_model->getFieldData('posts', 'city', $where_post);

                $where_post_category_id = " AND posts_id={$posts_id}";
                $data['category'] = $category_id = $this->common_model->getFieldData('posts', 'category', $where_post_category_id);
                $where_category_name = " AND category_id={$category_id}";
                $data['category_name'] = $category_id = $this->common_model->getFieldData('category', 'category_name', $where_category_name);

                $where_sub_cat = " AND posts_id={$posts_id}";
                $data['subcategory'] = $subcategory = $this->common_model->getFieldData('posts', 'subcategory', $where_sub_cat);
                $where_sub_cat_name = " AND category_id={$subcategory}";
                $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_sub_cat_name);

                $data['post_ads'] = $this->write_add_model->get_posts_by_id($posts_id);
                $data['main_content'] = 'manage_ad_view';
                $this->load->view('includes/template', $data);
            }
        }
    }

    function purchase_auto_re_post() {
//        if (!$this->session->userdata('is_logged_in')) {
//            redirect('home');
//        } else {
        $posts_id = $this->uri->segment(3);
        $data['post_category'] = $this->session->userdata('category');

        if (!empty($data['post_category'])) {
            $data['category'] = $category_id = $this->session->userdata('category');
            $data['sub_category'] = $this->session->userdata('sub_category');
        } else {

            $posts_data = $this->write_add_model->get_category_by_posts_id($posts_id);
            $data['category'] = $posts_data[0]['category'];
            $data['sub_category'] = $posts_data[0]['subcategory'];
            $data['city'] = $posts_data[0]['city'];

            $session_category = array(
                "category" => $data['category'],
                "sub_category" => $data['sub_category'],
                "stack_city_id" => $data['city']
            );
            $this->session->set_userdata($session_category);
        }
        $data['posts_ads_details'] = $this->write_add_model->get_posts_by_id($posts_id);
        $data['category'] = $category_id = $this->session->userdata('category');
        $data['sub_category'] = $this->session->userdata('sub_category');

        $where_subcategory = " AND category_id={$data['sub_category']}";
        $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $where_subcategory = " AND category_id={$data['category']}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $data['main_content'] = 'purchase_auto_re_post_view';
        $this->load->view('includes/template', $data);
        // }
    }

    function purchase_sponsor_ad_post() {
//        if (!$this->session->userdata('is_logged_in')) {
//            redirect('home');
//        } else {
        $posts_id = $this->uri->segment(3);
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->form_validation->set_rules('featured_ad', 'featured ad', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            if (isset($_POST['featured_ad'])) {
                if (isset($_POST['featured_ad_week_price']) && !$_POST['featured_ad_week_price'] == "0") {
                    $this->check_default($_POST['featured_ad_week_price']);
                    $this->form_validation->set_rules('featured_ad_week_price', '', 'callback_check_default');
                    $this->form_validation->set_message('check_default', 'Please add upgrades to have a minimum purchase of 0.99');
                }
            }


            if ($this->form_validation->run()) {
                if (!empty($_POST['promocode'])) {
                    $promocode_name = $_POST['promocode'];
                    $status = "Active";
                    $promocode = $this->write_add_model->get_promocode($promocode_name, $status);
                    //echo "<pre>"; print_r($promocode); die;
                    $promocode_value = $promocode[0]['code'];
                    $promocode_type = $promocode[0]['promotype'];
                    //echo $data['promocode_value']; die;

                    $net_value = "0";
                    if ($promocode_type == 'percentage') {
                        $total = $_POST['featured_ad_week_price'];
                        $percent_value = $total * $promocode_value;
                        $percent_amount = $percent_value / 100;
                        $net_value = $total - $percent_amount;
                    } else {
                        $total = $_POST['featured_ad_week_price'];
                        $net_value = $total - $promocode_value;
                    }
                } else {
                    $net_value = $_POST['featured_ad_week_price'];
                }
                $session = array(
                    'posts_id' => $_POST['posts_id'],
                );
                $this->session->set_userdata($session);
                $data['posts_id'] = $posts_id = $_POST['posts_id'];
                $data['featured_ad'] = $net_value;
                redirect("manage_ad_list/featured_ad_payment/$posts_id/$net_value");
            }
        }
        $data['post_category'] = $this->session->userdata('category');

        if (!empty($data['post_category'])) {
            $data['category'] = $category_id = $this->session->userdata('category');
            $data['sub_category'] = $this->session->userdata('sub_category');
        } else {
            //echo "hiiii"; die;
            $posts_data = $this->write_add_model->get_category_by_posts_id($posts_id);
            //echo "<pre>"; print_r($posts_data); die;
            $data['category'] = $posts_data[0]['category'];
            $data['sub_category'] = $posts_data[0]['subcategory'];
            $data['city'] = $posts_data[0]['city'];
            //echo "<pre>"; print_r($data['city']); die;
            $session_category = array(
                "category" => $data['category'],
                "sub_category" => $data['sub_category'],
                "stack_city_id" => $data['city']
            );
            $this->session->set_userdata($session_category);
        }
        $data['posts_ads_details'] = $this->write_add_model->get_posts_by_id($posts_id);
        $data['category'] = $category_id = $this->session->userdata('category');
        $data['sub_category'] = $this->session->userdata('sub_category');

        $where_subcategory = " AND category_id={$data['sub_category']}";
        $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $where_subcategory = " AND category_id={$data['category']}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $data['main_content'] = 'purchase_sponsor_ad_view';
        $this->load->view('includes/template', $data);
        //}
    }

    function featured_ad_payment() {
        $data['posts_id'] = $this->uri->segment(3);
        $data['featured_ad'] = $this->uri->segment(4);
        $data['main_content'] = 'featured_ad_payment_view';
        $this->load->view('includes/template', $data);
    }

    function move_post_ad() {
        //if (!$this->session->userdata('is_logged_in')) {
        //  redirect('home');
        //} else {
        $data['posts_id'] = $posts_id = $this->uri->segment(3);
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            if (!empty($_POST['promocode'])) {
                $promocode_name = $_POST['promocode'];
                $status = "Active";
                $promocode = $this->write_add_model->get_promocode($promocode_name, $status);

                $promocode_value = $promocode[0]['code'];
                $promocode_type = $promocode[0]['promotype'];

                $net_value = "0";
                if ($promocode_type == 'percentage') {
                    $total = $_POST['move_ad_top_amount'];
                    $percent_value = $total * $promocode_value;
                    $percent_amount = $percent_value / 100;
                    $net_value1 = $total - $percent_amount;
                    if ($net_value1 <= '0') {
                        $net_value = '1';
                    } else {
                        $net_value = $net_value1;
                    }
                } else {
                    $total = $_POST['move_ad_top_amount'];
                    $net_value1 = $total - $promocode_value;
                    if ($net_value1 <= '0') {
                        $net_value = '1';
                    } else {
                        $net_value = $net_value1;
                    }
                    $net_value;
                }
            } else {
                $net_value = $_POST['move_ad_top_amount'];
            }
            $session = array(
                'posts_id' => $_POST['posts_id'],
            );
            $this->session->set_userdata($session);
            $id = $_POST['posts_id'];
            $data['payment_type'] = $payment_type = $_POST['payment_type'];
            $data['move_ad_top_amount'] = $net_value;
            redirect("manage_ad_list/move_post_ad_payment/$id/$net_value/$payment_type");
        }
        $data['post_category'] = $this->session->userdata('category');

        if (!empty($data['post_category'])) {
            $data['category'] = $category_id = $this->session->userdata('category');
            $data['sub_category'] = $this->session->userdata('sub_category');
        } else {

            $posts_data = $this->write_add_model->get_category_by_posts_id($posts_id);
            $data['category'] = $posts_data[0]['category'];
            $data['sub_category'] = $posts_data[0]['subcategory'];
            $data['city'] = $posts_data[0]['city'];

            $session_category = array(
                "category" => $data['category'],
                "sub_category" => $data['sub_category'],
                "stack_city_id" => $data['city']
            );
            $this->session->set_userdata($session_category);
        }
        $data['posts_ads_details'] = $this->write_add_model->get_posts_by_id($posts_id);
        $data['category'] = $category_id = $this->session->userdata('category');
        $data['sub_category'] = $this->session->userdata('sub_category');

        $where_subcategory = " AND category_id={$data['sub_category']}";
        $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $where_subcategory = " AND category_id={$data['category']}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $data['main_content'] = 'move_post_ad_view';
        $this->load->view('includes/template', $data);
        //}
    }

    function move_post_ad_payment() {
        $data['posts_id'] = $this->uri->segment(3);
        $data['move_ad_top_amount'] = $this->uri->segment(4);
        $data['payment_type'] = $this->uri->segment(5);
        $data['main_content'] = 'payment_move_ad_top_view';
        $this->load->view('includes/template', $data);
    }

    function delete_ad() {
        //if (!$this->session->userdata('is_logged_in')) {
        // redirect('home');
        //} else {
        $data['posts_id'] = $this->uri->segment(3);
        $data['main_content'] = 'delete_ad_view';
        $this->load->view('includes/template', $data);
        //}
    }

    function delete_ad_confirm() {
        $posts_id = $_POST['posts_id'];

        $data_to_store = array('status' => 'Inactive');
        $this->write_add_model->updateStatus($posts_id, $data_to_store);
        redirect('home');
    }

    function manage_ads() {
        if (!$this->session->userdata('click_by_email')) {
            redirect('home');
        } else {
            $data['posts_id'] = $posts_id = $this->uri->segment(3);
            $today_date = date('Y-m-d');
            $after_today_date = strtotime($today_date);
            $where_post_id = " AND posts_id={$posts_id}";
            $expire_date = $this->common_model->getFieldData('posts', 'expire_date', $where_post_id);
            $after_expire_date = strtotime($expire_date);
            if ($after_expire_date >= $today_date) {
                $where_post = " AND posts_id={$posts_id}";
                $data['city'] = $city_id = $this->common_model->getFieldData('posts', 'city', $where_post);
                $where_post_category_id = " AND posts_id={$posts_id}";
                $data['category'] = $category_id = $this->common_model->getFieldData('posts', 'category', $where_post_category_id);
                $where_category_name = " AND category_id={$category_id}";
                $data['category_name'] = $category_id = $this->common_model->getFieldData('category', 'category_name', $where_category_name);
                $where_sub_cat = " AND posts_id={$posts_id}";
                $data['subcategory'] = $subcategory = $this->common_model->getFieldData('posts', 'subcategory', $where_sub_cat);
                $where_sub_cat_name = " AND category_id={$subcategory}";
                $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_sub_cat_name);
                $data['post_ads'] = $this->write_add_model->get_posts_by_id($posts_id);
                $data['main_content'] = 'manage_ad_view';
                $this->load->view('includes/template', $data);
            }
        }
    }

}

