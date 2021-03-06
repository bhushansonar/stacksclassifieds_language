<?php

class affiliate extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        if (!$this->session->userdata('is_logged_in')) {
//            redirect('signin/signin_user');
//        }
        $this->session->unset_userdata('page_type');
        $this->load->model('user_model');
        $this->load->model('common_model');
        $this->load->model('Admin_model');
        $this->load->model('affiliate_model');
        $this->load->model('home_model');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
        $this->load->helper('email');
        $this->load->library('email');
    }

    function index() {
        if ($this->session->userdata('is_logged_in')) {
            $type = $this->session->userdata('type');
            $user_id = $this->session->userdata('user_id');
            if ($type == 'user') {
                redirect("home/account/$user_id");
            } else {
                redirect("affiliate/affiliate_account_content/$user_id");
            }
        } else {
            $data['main_content'] = 'affiliate_signin_view';
            $this->load->view('includes/template', $data);
        }
    }

    function affiliate_singup_user() {
        $data['main_content'] = 'affiliate_signup_view';
        $this->load->view('includes/template', $data);
    }

    function __encrip_password($password) {
        return md5($password);
    }

    function affiliate_account_content() {
        $is_login_in = $this->session->userdata('is_logged_in');
        if (!empty($is_login_in)) {
            $user_id = $this->uri->segment(3);
            $data['content'] = $this->user_model->get_user_by_filed('user_id', $user_id);
            $data['main_content'] = 'affilate_view';
            $this->load->view('includes/template', $data);
        } else {
            redirect('home');
        }
    }

    function validate_credentials_affiliate_front() {
        $login = $this->session->userdata('is_logged_in');
        if (empty($login)) {
            $username = $this->input->post('username');
            $password = $this->__encrip_password($this->input->post('password'));
            $is_valid = $this->affiliate_model->validate_affiliate_front($username, $password);
            if ($is_valid) {
                $where_username = " AND username='{$username}' OR primary_email='$username'";
                $user_type = $this->common_model->getFieldData('user', 'type_of_membership', $where_username);

                if ($user_type == "Affilite") {
                    $is_account_confirm = $this->affiliate_model->validate_front_affiliate_account_confirm($username);
                    if (!empty($is_account_confirm)) {
                        $stored_user_data = $this->affiliate_model->get_user_id($username);
                        $user = $stored_user_data[0]->username;
                        $user_id = $stored_user_data[0]->user_id;
                        $primary_email = $stored_user_data[0]->primary_email;
                        $affiliate = $stored_user_data[0]->type;
                        $type_of_membership = $stored_user_data[0]->type_of_membership;
                        $data = array(
                            'username' => $user,
                            'primary_email' => $primary_email,
                            'user_id' => $user_id,
                            'type' => $affiliate,
                            'type_of_membership' => $type_of_membership,
                            'is_logged_in' => true
                        );
                        $this->session->set_userdata($data);
                        redirect("affiliate/affiliate_account_content/$user_id");
                    } else {
                        $this->session->set_flashdata('flash_class', 'alert-danger');
                        $this->session->set_flashdata('flash_message', '<strong>ohh snap!</strong> Please Confirm Your Account By Your Email  </strong>');
                        redirect('affiliate');
                    }
                } else {
                    $this->session->set_flashdata('flash_class', 'alert-danger');
                    $this->session->set_flashdata('flash_message', '<strong>ohh snap!</strong> Your are Not Affiliate User Please login with Normal login </strong>');
                    redirect('affiliate');
                }
            } else {
                $url = '<a href="' . base_url() . 'home/set_pass_mail">reset your password</a>';
                $this->session->set_flashdata('flash_class', 'alert-danger');
                $this->session->set_flashdata('flash_message', '<strong>ohh snap!</strong> Wrong Username or password!</strong>');
                $this->session->set_flashdata('flash_reset_url', 'Please try again or <strong>' . $url . '</strong>');
                redirect('affiliate');
            }
        } else {
            redirect('home');
        }
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
        if ($this->form_validation->run()) {
            $email = $this->input->post('create_email');
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
                $this->email->subject('StacksClassifieds.com new account:' . $email);
                $mail_data['url'] = site_url() . 'affiliate/affiliate_confirm/' . base64url_encode($email);
                $mail_data['email'] = $email;
                $message = $this->load->view('mail_templates/affiliate_confirmation_user', $mail_data, true);
                $this->email->message($message);

                if (!$this->email->send()) {
                    $msgadd = "<strong>E-mail not sent </strong>";
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_message', $msgadd);
                    redirect('affiliate/affiliate_singup_user');
                } else {
                    $affiliate_number = affiliate_number();
                    $pass = $this->input->post('password');
                    $data_to_store = array(
                        'username' => $this->input->post('username'),
                        'password' => md5($pass),
                        'firstname' => $this->input->post('username'),
                        'primary_email' => $email,
                        'type_of_membership' => 'Affilite',
                        'type' => $this->input->post('type'),
                        'affiliate_number' => $affiliate_number,
                        'status' => 'Inactive'
                    );
                    if ($this->user_model->store_user($data_to_store)) {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', '<strong>Well done!</strong> We have sent you a link to confirm your Account.');
                        redirect('home');
                    } else {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', '<strong>Oh snap!</strong> change a few things up and try submitting again.');
                        redirect('affiliate/affiliate_singup_user');
                    }
                }
            }
        } else {
            $this->session->set_flashdata('validation_error_messages', validation_errors());
            redirect('affiliate/affiliate_singup_user');
        }
    }

    function affiliate_confirm() {
        $email_encode = $this->uri->segment(3);
        if (!empty($email_encode)) {
            $email = base64url_decode($email_encode);
            $data_to_store = array(
                'status' => 'Active',
                'account_confirmed' => 'YES'
            );
            $this->user_model->update_user_by_email($email, $data_to_store);
//            $userData = $this->user_model->get_user_by_filed('primary_email', $email);
//            $user_id = $userData[0]['user_id'];
//            $type = $userData[0]['type'];
//            $type_of_membership = $userData[0]['type_of_membership'];
//            $username = $userData[0]['username'];
//
//
//            $data = array(
//                'username' => $username,
//                'primary_email' => $email,
//                'user_id' => $user_id,
//                'type' => $type,
//                'type_of_membership' => $type_of_membership,
//                'is_logged_in' => true
//            );
//            $this->session->set_userdata($data);
            //redirect("signin/signin_user/$user_id/$type");

            $data['flash_message'] = TRUE;
            $this->session->set_flashdata('flash_class', 'alert-success');
            $this->session->set_flashdata('flash_message', '<strong>Your account has been activated - please login below.</strong>');
            redirect("affiliate");
        }
    }

    function ManageAds() {

        $email_encode = $this->uri->segment(3);
        $user_id = $this->session->userdata('user_id');
        $data['email'
                ] = $email = base64url_decode($email_encode);
        $user_id = $this->session->userdata('user_id');
        $config['per_page'] = 25;
        $config["uri_segment"] = 4;
        $config['base_url'] = base_url() . 'affiliate/ManageAds/' . $email_encode;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 25;
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
        $data['country'] = $this->home_model->getAllCountry();
        $data['count_products'] = $this->affiliate_model->count_post_ads('', '', $email);
        $data['content'] = $this->affiliate_model->post_ads('', '', $config['per_page'], $limit_end, '', $email);
        $config['total_rows'] = $data['count_products'];
        $this->pagination->initialize($config);
        $data['main_content'] = 'manage_account_view';
        $this->
        load->view('includes/template', $data);
    }

    function term() {

        $email_encode = $this->uri->segment(3);
        $data['email'] = $email = base64url_decode($email_encode);
        $data['main_content'] = 'affiliate_term_view';
        $this->load->view('includes/template', $data);
    }

    function EarningsReport() {
        $email_encode = $this->uri->segment(3);
        $data['email'] = $email = base64url_decode($email_encode);
        $data['content'] = $this->affiliate_model->earning_report($email);
        $data['main_content'] = 'affiliate_earn_view';
        $this->load->view('includes/template', $data);
    }

    function affiliate_user() {
        $email_encode = $this->uri->segment(3);
        $aff_no = $this->uri->segment(4);
        $data['affiliate_number'] = $aff_no;
        $data['from_email'] = base64url_decode($email_encode);
        $this->load->helper('email');
        $this->load->library('email');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $email = $this->input->post('email');
            $description = $this->input->post('description');
            $from_email = $this->input->post('from_email');
            $affil_no = $this->input->post('affiliate_number');
            $from_email_uri = base64url_encode($from_email);
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|is_unique[user.primary_email]|matches[confirm_email]');
            $this->form_validation->set_rules('confirm_email', 'Email Address Confirmation', 'required');
            $this->form_validation->set_rules('description', 'Descrition', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            if ($this->form_validation->run()) {

                if (valid_email($email)) {

//common helper function for admin detail
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $config['charset'] = 'iso-8859-1';
                    $config['mailtype'] = 'html';
                    $config['priority'] = 1;
                    $this->email->initialize($config);
                    $this->email->from($from_email);
                    $this->email->to($email);
                    $this->email->set_mailtype("html");
                    $this->email->subject("Invitation for Stacksclassified site Registration");
                    $mail_data['description'] = $description;
                    $mail_data['email'] = $email;
                    $mail_data['from_email'] = $from_email;
                    $message = $this->load->view('mail_templates/affiliate_invitation', $mail_data, true);
                    $this->email->message($message);

                    if (!$this->email->send()) {
                        $msgadd = "<strong>E-mail not sent </strong>"; //.$this->email->print_debugger();
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', $msgadd);
                        redirect("affiliate/affiliate_user/" . $from_email_uri);
                    } else {
                        $user_data = $this->common_model->get_content_by_field('affiliate', 'affiliate_user_email', $email);
                        $affiliate_email = $this->common_model->count_affiliate_email('affiliate', 'affiliate_user_email', $email);
                        $data_to_store = array(
                            'affiliate_user_email' => isset($email) ? $email : "",
                            'affiliate_send_user_email' => isset($from_email) ? $from_email : "",);

                        if (!empty($user_data)) {
                            $data['flash_message'] = TRUE;
                            $this->session->set_flashdata('flash_message', 'Email is already give please choose another');
                            redirect('home');
                        } else {

                            if ($affiliate_email == "0") {
                                $this->user_model->update_user_afffiliate_email($from_email, $data_to_store);
                                $data_to_store_affiliate = array(
                                    'affiliate_number' => isset($affil_no) ? $affil_no : "",
                                    'affiliate_user_email' => isset($email) ? $email : "", 'affiliate_send_user_email' => isset($from_email) ? $from_email : "",
                                );
                                if ($this->user_model->add_afffiliate_email($data_to_store_affiliate)) {
                                    $data['flash_message'] = TRUE;
                                    $this->session->set_flashdata('flash_message', 'Please check your email to register');
                                    redirect('home');
                                } else {
                                    $data['flash_message'] = FALSE;
                                }
                            } else {
                                $data['flash_message'] = TRUE;
                                $this->session->set_flashdata('flash_message', 'Please choose another email you have already affiliated with this email');
                                redirect('home');
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
            $aff = base64url_encode($affiliate_number);
            $session = array('affiliate_register_number' => $aff);
            $this->session->set_userdata($session);
            redirect('signup/index/' . $aff);
        }
    }

    function PaymentInfo() {
        //$email_encode = $this->uri->segment(3);
        $data['email'] = $email = $this->session->userdata('primary_email');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if (!empty($_POST['expire'])) {
                $expire = $_POST['expire'];
                $date = str_replace('/', '-', $expire);
                $formating_date = explode('-', $date);
                $date1 = $formating_date[2] . '-' . $formating_date[0] . '-' . $formating_date[1];
                $this->form_validation->set_rules('expire', 'Expire Date', 'callback_check_date_valid[' . $expire . ']');
                $this->form_validation->set_message('check_date_valid', 'Invalid Expire Date');
            }

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('card_type', 'Card type', 'required');
            $this->form_validation->set_rules('card_number', 'Card Number', 'trim|required|numeric|min_length[14]');

            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            $user_id = $this->session->userdata('user_id');
            if ($this->form_validation->run() == TRUE) {
                $data_to_store = array(
                    'user_id' => $user_id,
                    'name' => isset($_POST['name']) ? $_POST['name'] : "",
                    'address' => isset($_POST['address']) ? $_POST['address'] : "",
                    'city' => isset($_POST['city']) ? $_POST['city'] : "",
                    'state' => isset($_POST['state']) ? $_POST['state'] : "",
                    'zip_code' => isset($_POST['zip_code']) ? $_POST['zip_code'] : "",
                    'card_type' => isset($_POST['card_type']) ? $_POST['card_type'] : "",
                    'card_number' => isset($_POST['card_number']) ? $_POST['card_number'] : "",
                    'expire' => isset($date1) ? $date1 : "",
                    'cvv_code' => isset($_POST['cvv_code']) ? $_POST['cvv_code'] : "",
                );
                $insert_id = $this->affiliate_model->store_payment_info($data_to_store);
                if ($insert_id) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect("affiliate");
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        $data['card_type_opt'] = array(
            '' => 'Card Type',
            'mastercard' => 'MasterCard',
            'visa' => 'Visa',
            'discover' => 'Discover',
            'diners_club' => 'Diners',
            'jcb' => 'JCB',
            'amex' => 'American Express'
        );
        $data['main_content'] = 'payment_details_view';
        $this->load->view('includes/template', $data);
    }

    function check_date_valid($d) {
        $date1 = date('m/d/Y');
        $date2 = $d;
        $today = new DateTime($date1);
        $post_date = new DateTime($date2);

        if ($post_date > $today) {

            return TRUE;
        } else {

            return FALSE;
        }
    }

}

