<?php

class Signin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->helper('url');
        $this->session->unset_userdata('page_type');
        if ($this->session->userdata('is_logged_in')) {
            //redirect('home');
        }
    }

    function index() {

    }

    function signin_user() {
//        $user_id = $this->uri->segment(3);
//        $type = $this->uri->segment(4);
//        if ($type == "affiliate") {
//            $data['content'] = $this->user_model->get_user_by_filed('user_id', $user_id);
//            $data['main_content'] = 'affilate_view';
//            $this->load->view('includes/template', $data);
//        } else {
//            $session = array(
//                'type' => "user",
//            );
        //$this->session->set_userdata($session);
        //}
        $data['main_content'] = 'signin_view';
        $this->load->view('includes/template', $data);
    }

    function __encrip_password($password) {
        return md5($password);
    }

    function validate_credentials_front() {

        if (!$this->session->userdata('is_logged_in')) {
            $this->load->model('Admin_model');
            $username = $this->input->post('username');
            $password = $this->__encrip_password($this->input->post('password'));
            $is_account_confirm = $this->Admin_model->validate_front_account_confirm($username, $password);
            if ($is_account_confirm) {

                $is_valid = $this->Admin_model->validate_front($username, $password);
                if ($is_valid) {
                    $stored_user_data = $this->Admin_model->get_user_id($username);
                    $user_id = $stored_user_data[0]->user_id;
                    $primary_email = $stored_user_data[0]->primary_email;
                    $affiliate = $stored_user_data[0]->type;
                    $type_of_membership = $stored_user_data[0]->type_of_membership;

                    if (!empty($affiliate)) {
                        $type = $affiliate;
                    } else {
                        $type = 'user';
                    }
                    $data = array(
                        'username' => $username,
                        'primary_email' => $primary_email,
                        'user_id' => $user_id,
                        'type' => $type,
                        'type_of_membership' => $type_of_membership,
                        'is_logged_in' => true
                    );
                    $this->session->set_userdata($data);
                    if ($affiliate == 'affiliate') {
                        redirect("signin/signin_user/$user_id/affiliate");
                    } else {
                        $email = base64url_encode($primary_email);
                        redirect("home/account/$user_id/$email");
                    }
                } else {
                    $url = '<a href="' . base_url() . 'home/set_pass_mail">reset your password</a>';
                    $this->session->set_flashdata('flash_class', 'alert-danger');
                    $this->session->set_flashdata('flash_message', '<strong>ohh snap!</strong> Wrong Username And Password  </strong>');
                    $this->session->set_flashdata('flash_reset_url', 'Please try again or <strong>' . $url . '</strong>');
                    redirect('signin/signin_user');
                }
            } else {
                $this->session->set_flashdata('flash_class', 'alert-danger');
                $this->session->set_flashdata('flash_message', '<strong>ohh snap!</strong> Please Confirm Your Account By Your Email  </strong>');
                redirect('signin/signin_user');
            }
        } else {
            redirect('home');
        }
    }

}

