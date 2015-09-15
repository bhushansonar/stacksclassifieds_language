<?php

class Contactus extends CI_Controller {

    public function __construct() {
        parent::__construct();


        $this->load->helper('email');
        $this->load->library('email');
        $this->session->unset_userdata('page_type');

        if (!$this->session->userdata('is_logged_in')) {

        }
    }

    function index() {
        $data['main_content'] = 'contactus_view';
        $this->load->view('includes/template', $data);
    }

    function contactus_data() {
//        echo "<pre>";
//        print_r($_POST);
//        exit;
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'User name', 'trim|required');
        $this->form_validation->set_rules('usermail', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('message', 'message', 'trim|required');

        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
        if ($this->input->post('redirect')) {
            $redirect = $this->input->post('redirect');
        } else {
            $redirect = '';
        }
        if ($this->form_validation->run()) {

            //$pass = generate_password();
            $username = $this->input->post('username');
            $usermail = $this->input->post('usermail');
            $message = $this->input->post('message');

//            $data_to_store = array(
//                'username' => $this->input->post('username'),
//                'usermail' => $this->input->post('usermail'),
//                'message' => $this->input->post('message')
//            );

            $this->load->helper('email');
            $this->load->library('email');

            //read parameters from $_POST using input class
            // check is email addrress valid or no
            if (valid_email($usermail)) {
                // compose email
                $get_admin_detail = get_admin_detail(); //common helper function for admin detail
                $this->email->from($usermail);
                $this->email->to($get_admin_detail['email']);
                $this->email->set_mailtype("html");
                $this->email->subject('Contact Us');

                $mail_data['username'] = $this->input->post('username');
                $mail_data['usermail'] = $this->input->post('usermail');
                $mail_data['message'] = $this->input->post('message');

                $message = $this->load->view('mail_templates/contactus_mail', $mail_data, true);

                $this->email->message($message);

                // try send mail ant if not able print debug
                if (!$this->email->send()) {
                    $msgadd = "<strong> Email Not Sent </strong>"; //.$this->email->print_debugger();
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_message', $msgadd);
                    redirect('contactus');
                } else {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_class', 'alert-success');
                    $this->session->set_flashdata('flash_message', '<strong>Email Sent </strong>');
                    redirect('contactus');
                }
            } else {
                if ($redirect == 'home') {
                    $this->session->set_flashdata('validation_error_messages', validation_errors());
                    redirect('home');
                }
            }
        }
        $data['main_content'] = 'contactus_view';
        $this->load->view('includes/template', $data);
    }

}

?>