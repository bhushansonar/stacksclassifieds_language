<?php

class affiliate extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('common_model');
        $this->load->model('affiliate_model');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
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

    function affiliate_confirm() {
        $email_encode = $this->uri->segment(3);
        if (!empty($email_encode)) {
            $email = base64url_decode($email_encode);
            $data_to_store = array(
                'status' => 'Active'
            );

            $this->user_model->update_user_by_email($email, $data_to_store);
            $userData = $this->user_model->get_user_by_filed('primary_email', $email);
            $user_id = $userData[0]['user_id'];
            $type = $userData[0]['type'];
            redirect("signin/signin_user/$user_id/$type");
        }
    }

    function ManageAds() {
        $email_encode = $this->uri->segment(3);
        $data['email'] = $email = base64url_decode($email_encode);
        $config['per_page'] = 15;
        $config["uri_segment"] = 4;
        $config['base_url'] = base_url() . 'affiliate/ManageAds/' . $email_encode;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $page = $this->uri->segment(4);

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['count_products'] = $this->affiliate_model->count_post_ads();
        $data['content'] = $this->affiliate_model->post_ads('', '', $config['per_page'], $limit_end, '', $email);
        $config['total_rows'] = $data['count_products'];

        $this->pagination->initialize($config);
        $data['main_content'] = 'manage_ads_view';
        $this->load->view('includes/template', $data);
    }

    function term() {
        $email_encode = $this->uri->segment(3);
        $data['email'] = $email = base64url_decode($email_encode);
        $data['main_content'] = 'affiliate_term_view';
        $this->load->view('includes/template', $data);
    }

    function affiliate_user() {
        $email_encode = $this->uri->segment(3);
        $data['from_email'] = base64url_decode($email_encode);
        $this->load->helper('email');
        $this->load->library('email');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|is_unique[user.primary_email]|matches[confirm_email]');
            $this->form_validation->set_rules('confirm_email', 'Email Address Confirmation', 'required');
            $this->form_validation->set_rules('description', 'Descrition', 'trim|required');
            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $description = $this->input->post('description');
                $from_email = $this->input->post('from_email');
                $from_email_uri = base64url_encode($from_email);
                if (valid_email($email)) {

                    //common helper function for admin detail
                    $this->email->from($from_email);
                    $this->email->to($email);
                    $this->email->set_mailtype("html");
                    $this->email->subject("Invitation for Stacksclassified site Registration");
                    $mail_data['description'] = $description;
                    $mail_data['email'] = $email;
                    $mail_data['from_email'] = $from_email;
                    $message = $this->load->view('mail_templates/affiliate_invitation', $mail_data, true);
                    $this->email->message($message);

                    // try send mail ant if not able print debug
                    if (!$this->email->send()) {
                        $msgadd = "<strong>E-mail not sent </strong>"; //.$this->email->print_debugger();
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', $msgadd);
                        redirect("affiliate/affiliate_user/" . $from_email_uri);
                    } else {
                        $data_to_store = array(
                            'affiliate_user_email' => isset($email) ? $email : "",
                            'affiliate_send_user_email' => isset($from_email) ? $from_email : "",
                        );
//                        echo "<pre>";
//                        print_r($data_to_store);
//                        exit;
                        $user_data = $this->common_model->get_content_by_field('affiliate', 'affiliate_user_email', $email);
                        if (!empty($user_data)) {
                            $data['flash_message'] = TRUE;
                            $this->session->set_flashdata('flash_message', 'Please choose another email this is already given');
                            redirect('home');
                        } else {
                            $this->user_model->update_user_afffiliate_email($from_email, $data_to_store);
                            $this->user_model->add_afffiliate_email($data_to_store);
                            if ($this->user_model->add_afffiliate_email($data_to_store)) {
                                $data['flash_message'] = TRUE;
                                $this->session->set_flashdata('flash_message', 'please check your mail to register');
                                redirect('home');
                                //redirect('admin/user'.'');
                            } else {
                                $data['flash_message'] = FALSE;
                            }
                        }
                    }
                }
            }
        }
        $data['main_content'] = 'affiliate_user_view';
        $this->load->view('includes/template', $data);
    }

    function affiliate_classifieds() {
        $type = $this->uri->segment(3);
        $affiliate_number = $this->uri->segment(4);


        if ($type == 'register') {
            $price = $this->common_model->get_content_by_field('user', 'affiliate_number', $affiliate_number);
//            echo "<pre>";
//            print_r($price);
//            exit;
            $affiliate_user_email = $price[0]['affiliate_user_email'];

//            if (!empty($affiliate_user_email)) {
//                redirect('home');
//            } else {
            $affiliate_earn_price = $price[0]['register_price'];
//                $data_to_store = array(
//                    'affiliate_earn' => isset($affiliate_earn_price) ? $affiliate_earn_price : "",
//                );

            $aff = base64url_encode($affiliate_number);
            redirect('signup/index/' . $aff);
//            $this->common_model->update_by_field('user', 'affiliate_number', $affiliate_number, $data_to_store);
//            exit;
            //}
        }
    }

}

