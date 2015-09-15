<?php

class Reply extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('reply_model');
        $this->load->model('common_model');
        $this->load->library('recaptcha');
        $this->load->library('form_validation');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {
        $data['main_content'] = 'reply_view';
    }

    function email_reply() {

        $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
        $this->load->helper('email');
        $this->load->library('email');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->recaptcha->recaptcha_check_answer();
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|matches[confirm_email]');
            $this->form_validation->set_rules('confirm_email', 'Email Address Confirmation', 'required');
            if ($this->form_validation->run() && $this->recaptcha->getIsValid()) {
                $title = $this->input->post('title');
                $posts_id = $this->input->post('posts_id');
                $parent_id = $this->input->post('parent_id');
                $email = $this->input->post('email');
                $description = $this->input->post('description');
                if (valid_email($email)) {
                    $where_post_id = " AND posts_id={$posts_id}";
                    $uid = $this->common_model->getFieldData('posts', 'uid', $where_post_id);
                    if ($uid !== '0') {
                        $where_uid = " AND user_id={$uid}";
                        $reciever_email = $this->common_model->getFieldData('user', 'primary_email', $where_uid);
                    } else {
                        $where_id = " AND posts_id={$posts_id}";
                        $reciever_email = $this->common_model->getFieldData('posts', 'email', $where_id);
                    }
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $config['charset'] = 'utf-8';
                    $config['mailtype'] = 'html';
                    $config['priority'] = 1;
                    $this->email->initialize($config);
                    $get_admin_detail = get_admin_detail(); //common helper function for admin detail
                    $this->email->from($email);
                    $this->email->to($reciever_email);
                    $this->email->set_mailtype("html");
                    $this->email->subject("StacksClassified Response:$title");
                    $mail_data['description'] = $description;
                    $mail_data['email'] = $email;
                    $mail_data['from_email'] = $reciever_email;
                    $message = $this->load->view('mail_templates/reply_to_post', $mail_data, true);
                    $this->email->message($message);

                    // try send mail ant if not able print debug
                    if (!$this->email->send()) {
                        $msgadd = "<strong>E-mail not sent </strong>"; //.$this->email->print_debugger();
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', $msgadd);
                        redirect('reply/email_reply/' . $posts_id . '/' . $parent_id);
                    } else {
                        $data_to_store = array(
                            'posts_id' => isset($posts_id) ? $posts_id : "",
                            'email' => isset($email) ? $email : "",
                            'description' => isset($description) ? $description : "",
                            'title' => isset($title) ? $title : ""
                        );

                        if ($this->reply_model->add_post_reply($data_to_store)) {
                            redirect("reply/reply_sent/$posts_id/$parent_id");
                        }
                    }
                }
            }
        }
        $data['main_content'] = 'reply_view';
        $this->load->view('includes/template', $data);
    }

    function email_ads() {

        $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
        $this->load->helper('email');
        $this->load->library('email');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->recaptcha->recaptcha_check_answer();
            $this->form_validation->set_rules('email', 'Your email Address', 'trim|required');
            $this->form_validation->set_rules('reciever_email', 'Recipients email address', 'trim|required');
            if ($this->form_validation->run() && $this->recaptcha->getIsValid()) {
                $title = $this->input->post('title');
                $post_description = $this->input->post('post_description');
                $posts_id = $this->input->post('posts_id');
                $parent_id = $this->input->post('parent_id');
                $email = $this->input->post('email');
                $reciever_email = $this->input->post('reciever_email');
                $description = $this->input->post('description');
                if (valid_email($reciever_email)) {
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $config['charset'] = 'utf-8';
                    $config['mailtype'] = 'html';
                    $config['priority'] = 1;
                    $this->email->initialize($config);
                    $get_admin_detail = get_admin_detail(); //common helper function for admin detail
                    $this->email->from($email);
                    $this->email->to($reciever_email);
                    $this->email->set_mailtype("html");
                    $this->email->subject("StacksClassified Response:$title");
                    $mail_data['post_description'] = $post_description;
                    $mail_data['description'] = $description;
                    $mail_data['url'] = site_url() . 'post_detail/getPostdetails/' . $posts_id . '/' . $parent_id;
                    $message = $this->load->view('mail_templates/reply_to_email_this_ad', $mail_data, true);
                    $this->email->message($message);

                    // try send mail ant if not able print debug
                    if (!$this->email->send()) {
                        $msgadd = "<strong>E-mail not sent </strong>"; //.$this->email->print_debugger();
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', $msgadd);
                        redirect('reply/email_ads' . $posts_id . '/' . $parent_id);
                    } else {
//                        $data_to_store = array(
//                            'posts_id' => isset($posts_id) ? $posts_id : "",
//                            'email' => isset($email) ? $email : "",
//                            'description' => isset($description) ? $description : "",
//                            'title' => isset($title) ? $title : ""
//                        );
                        redirect("reply/email_ad_sent/$posts_id/$parent_id");
                    }
                }
            }
        }
        $data['main_content'] = 'email_ads_view';
        $this->load->view('includes/template', $data);
    }

    public function email_ad_sent() {

        $data['sub_category'] = $this->session->userdata('sub_category');
        $data['posts_id'] = $posts_id = $this->uri->segment(3);
        $data['parent_id'] = $this->uri->segment(4);
        $where_post = " AND posts_id={$posts_id}";
        $data['city_id'] = $city_id = $this->common_model->getFieldData('posts', 'city', $where_post);
        $where_city = " AND city_id={$city_id}";
        $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $where_city);
        $data['main_content'] = 'email_send_ad_view';
        $this->load->view('includes/template', $data);
    }

    public function reply_sent() {
        //post_detail/getPostdetails/$posts_id/$parent_id
//        $data['sub_category'] = $this->session->userdata('sub_category');
        $data['posts_id'] = $posts_id = $this->uri->segment(3);
        $data['parent_id'] = $category_id = $this->uri->segment(4);

        $where_category_name = " AND category_id={$category_id}";
        $data['category_name'] = $category_id = $this->common_model->getFieldData('category', 'category_name', $where_category_name);

        $where_post = " AND posts_id={$posts_id}";
        $data['city_id'] = $city_id = $this->common_model->getFieldData('posts', 'city', $where_post);

        $where_sub_cat = " AND posts_id={$posts_id}";
        $data['subcategory'] = $subcategory = $this->common_model->getFieldData('posts', 'subcategory', $where_sub_cat);

        $where_sub_cat_name = " AND category_id={$subcategory}";
        $data['sub_category_name'] = $sub_category_id = $this->common_model->getFieldData('category', 'category_name', $where_sub_cat_name);


        $where_city = " AND city_id={$city_id}";
        $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $where_city);

        $data['main_content'] = 'reply_sent_view';
        $this->load->view('includes/template', $data);
    }

}

?>