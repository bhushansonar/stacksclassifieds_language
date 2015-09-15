<?php

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('email');
        $this->load->library('email');
        $this->load->model('user_model');
        $this->session->unset_userdata('page_type');
        if ($this->session->userdata('is_logged_in')) {
            redirect('home');
        }
    }

    function index() {
        $data['main_content'] = 'signup_view';
        $this->load->view('includes/template', $data);
    }

    function create_member_site() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'User Name', 'required|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
        $this->form_validation->set_rules('create_email', 'Email Address', 'trim|required|valid_email|is_unique[user.primary_email]|matches[create_email_confirm]');
        $this->form_validation->set_rules('create_email_confirm', 'Email Address Confirmation', 'required');
        $this->form_validation->set_message('is_unique', 'The %s is already taken! Please choose another.');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

        $email = $this->input->post('create_email');
        $pass = $this->input->post('password');
        $type = $this->input->post('type');
        if ($this->form_validation->run()) {

            if (valid_email($email)) {
                $get_admin_detail = get_admin_detail();
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['priority'] = 1;
                $this->email->initialize($config);
                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to($email);
                $this->email->set_mailtype("html");

                $this->email->subject('Register confirmation for StacksClassifieds');
                $mail_data['url'] = site_url() . 'home/confirm/' . base64url_encode($email);
                $mail_data['email'] = $email;
                $message = $this->load->view('mail_templates/signup_mail', $mail_data, true);
                $this->email->message($message);

                if (!$this->email->send()) {

                    $msgadd = "<strong>E-mail not sent </strong>";
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_message', $msgadd);
                    redirect('signup');
                } else {

                    $data_to_store = array(
                        'username' => $this->input->post('username'),
                        'password' => md5($pass),
                        'firstname' => $this->input->post('username'),
                        'primary_email' => $email,
                        'type_of_membership' => 'User',
                        'type' => $type,
                        'status' => 'Inactive'
                    );
                    if ($this->user_model->store_user($data_to_store)) {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', '<strong>Well done!</strong> We have sent you a link to confirm your Account.');
                        $this->email->clear(TRUE);
                        $get_admin_detail = get_admin_detail();
                        $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $config['charset'] = 'iso-8859-1';
                        $config['mailtype'] = 'html';
                        $config['priority'] = 1;
                        $this->email->initialize($config);
                        $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                        $this->email->to('new_accounts@stacksclassifieds.com');
                        $this->email->set_mailtype("html");
                        $this->email->subject('StacksClassified New Account Created');
                        $mail_data_admin['email'] = $email;
                        $message1 = $this->load->view('mail_templates/new_account_create', $mail_data_admin, true);
                        $this->email->message($message1);
                        $this->email->send();
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', '<strong>Well done!</strong> We have sent you a link to confirm your Account.');
                        redirect('home');
                    } else {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', '<strong>Oh snap!</strong> change a few things up and try submitting again.');
                        redirect('home');
                    }
                }
            }
        }
//        else {
//            $this->session->set_flashdata('validation_error_messages', validation_errors());
//            redirect('signup');
//        }

        $data['main_content'] = 'signup_view';
        $this->load->view('includes/template', $data);
    }

    function set_password() {
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('create_email_confirm', 'Password Confirmation', 'trim|required|matches[password]');
        if ($this->form_validation->run()) {
            $email = base64url_decode($this->input->post('create_email'));
            $data_to_store = array(
                'password' => md5($this->input->post('password')),
                'status' => 'Active'
            );
            if ($this->user_model->update_user_by_email($email, $data_to_store)) {
                $data['flash_message'] = TRUE;
                $this->session->set_flashdata('flash_class', 'alert-success');
                $this->session->set_flashdata('flash_message', '<strong>Well done!</strong> We sent you password on your E-mail.');
                redirect('signup');
            } else {
                $data['flash_message'] = TRUE;
                $this->session->set_flashdata('flash_class', 'alert-error');
                $this->session->set_flashdata('flash_message', '<strong>Oh snap!</strong> change a few things up and try submitting again.');
                redirect('signup');
            }
        }
    }

}

