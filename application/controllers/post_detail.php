<?php

class Post_detail extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('post_detail_model');
        $this->load->model('common_model');
        $this->load->helper('url');
        $this->load->library('recaptcha');
        $this->load->helper('email');
        $this->load->library('email');
        $this->load->helper('url');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {
        //$this->load->helper('url');
    }

    function getPostdetails() {

        $data['posts_id'] = $posts_id = $this->uri->segment(3);
        $data['parent_id'] = $parent = $this->uri->segment(4);
        $post_city = $this->uri->segment(5);
        if (isset($parent) && !empty($parent)) {
            $cetegory_id = $parent;
        } else {
            $cetegory_id = $this->session->userdata('stack_category_id');
        }

        $city_id = $this->session->userdata('stack_city_id');
        $state_id = $this->session->userdata('stack_state_id');
        $type = $this->session->userdata('stack_select_type');
        if ($type == 'state') {
            if (!empty($state_id)) {
                $data['id'] = $state_id;
            } else {
                redirect('home');
            }
        } else {
            if (isset($post_city) && !empty($post_city)) {
                $data['id'] = $city_id = $post_city;
            } else {
                if (!empty($city_id)) {
                    $data['id'] = $city_id;
                } else {
                    redirect('home');
                }
            }
        }

        if (isset($state_id) && !empty($state_id)) {

            $data['function'] = "get_all_title_data";
            $whereCat = " AND category={$cetegory_id} AND state={$state_id} AND posts_id={$posts_id}";
            $subcategory = $this->common_model->getFieldData('posts', 'subcategory', $whereCat);
            $data['sub_category_id'] = $sub_cat = $subcategory;
            $where = " AND state_id={$state_id}";
            $data['name'] = $this->common_model->getFieldData('state', 'state_name', $where);
            $where_city = " AND subcategory={$sub_cat} AND state={$state_id} AND payment_status='complete'";
            $data['city_id'] = $this->common_model->getFieldData('posts', 'city', $where_city);
        } else {
            $data['function'] = "getAlltitle";
            $data['city_id'] = $city_id;
            $whereCat = " AND category={$cetegory_id} AND city={$city_id} AND posts_id={$posts_id}";
            $subcategory = $this->common_model->getFieldData('posts', 'subcategory', $whereCat);
            $data['sub_category_id'] = $sub_cat = $subcategory;
            $where = " AND city_id={$city_id}";
            $data['name'] = $this->common_model->getFieldData('city', 'city_name', $where);
        }

        $where_cat = " AND category_id='{$cetegory_id}'";
        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_cat);

        $where_subcategory = " AND category_id={$sub_cat}";

        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $data['des'] = $this->post_detail_model->getPostdetail($posts_id);
        $data['city_opt'] = $this->common_model->getDDArray('city', 'city_id', 'city_name');
        $data['main_content'] = 'post_detail_view';
        $this->load->view('includes/template', $data);
    }

    function post_ad_reported() {
        $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
        $data['posts_id'] = $posts_id = $this->uri->segment(3);
        $data['main_content'] = 'repoted_ad_view';
        $this->load->view('includes/template', $data);
    }

    function check_captcha() {
        if (!$this->recaptcha->getIsValid()) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function posts_reported_ads() {
        $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->recaptcha->recaptcha_check_answer();
            $this->form_validation->set_rules('recaptcha_response_field', 'Recaptcha', 'required|callback_check_captcha');
            $this->form_validation->set_message('check_captcha', 'Wrong Recaptcha');
            $this->form_validation->set_rules('repote_ad', 'category', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            $repote_ad = $this->input->post('repote_ad');
            $posts_id = $this->input->post('posts_id');
            if ($this->form_validation->run() && $this->recaptcha->getIsValid()) {

                $data_to_store = array(
                    'posts_id' => isset($posts_id) ? $posts_id : "",
                    'repote_ad' => isset($repote_ad) ? $repote_ad : "",
                );
                if ($this->post_detail_model->add_post_reported($data_to_store)) {

                    if ($this->session->userdata('is_logged_in')) {
                        $email = $this->session->userdata('primary_email');
                        $content = 'My email is ' . $email;
                    } else {
                        $email = "info@stacksclassifieds.com";
                        $content = "";
                    }
                    $where_posts = " AND posts_id='{$posts_id}'";
                    $title = $this->common_model->getFieldData('posts', 'title', $where_posts);

                    if (valid_email($email)) {
                        $get_admin_detail = get_admin_detail(); //common helper function for admin detail
                        $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $config['charset'] = 'iso-8859-1';
                        $config['mailtype'] = 'html';
                        $config['priority'] = 1;
                        $this->email->initialize($config);
                        $this->email->from($email);
                        $this->email->to($email);
                        $this->email->set_mailtype("html");
                        $this->email->subject('Reported Ads');
                        $mail_data['to_email'] = $get_admin_detail['email'];
                        $mail_data['title'] = unserialize(base64_decode($title));
                        $mail_data['from_email'] = $content;
                        $mail_data['reason'] = $repote_ad;
                        $message = $this->load->view('mail_templates/repoted_ads_post', $mail_data, true);
                        $this->email->message($message);
                        if (!$this->email->send()) {
                            $msgadd = "<strong>E-mail not sent </strong>";
                            $data['flash_message'] = TRUE;
                            $this->session->set_flashdata('flash_class', 'alert-error');
                            $this->session->set_flashdata('flash_message', $msgadd);
                            redirect('home/home_page');
                        } else {
                            $this->email->send();
                            redirect("post_detail/repoted_ad_success/$posts_id");
                        }
                    }
                }
            } else {
                $data['posts_id'] = $posts_id;
                $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
                $data['main_content'] = 'repoted_ad_view';
                $this->load->view('includes/template', $data);
            }
        }
    }

    function repoted_ad_success() {
        $data['posts_id'] = $posts_id = $this->uri->segment(3);
        $data['post_data'] = $this->common_model->get_content_by_field('posts', 'posts_id', $posts_id);
        $data['category'] = $category_id = $data['post_data']['0']['category'];
        $whereStr = " AND category_id={$category_id}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $whereStr);
        $data['subcategory'] = $sub_category_id = $data['post_data']['0']['subcategory'];
        $where = " AND category_id={$sub_category_id}";
        $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where);
        $data['city'] = $city_id = $data['post_data']['0']['city'];
        $wherecity = " AND city_id={$city_id}";
        $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $wherecity);
        $data['main_content'] = 'repoted_ad_success_view';
        $this->load->view('includes/template', $data);
    }

}

