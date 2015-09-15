<?php

class Home extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model('home_model');
        $this->load->model('user_model');
        $this->load->model('common_model');
        $this->load->model('payment_model');
        $this->load->model('write_add_model');
        $this->load->model('affiliate_model');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('email');

        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {
        $id = isset($_POST['posts_id']) ? $_POST['posts_id'] : "";
        if (isset($_POST) && !empty($_POST)) {
            $transaction_approval = $_POST['Transaction_Approved'];

            if ($transaction_approval != 'NO') {
                if ($this->session->userdata('user_id')) {
                    $user_id = $this->session->userdata('user_id');
                } else {
                    $user_id = "0";
                }

                $data_to_store = array(
                    'uid' => $user_id,
                    'payment_type' => isset($_POST['payment_type']) ? $_POST['payment_type'] : "",
                    'trans_id' => isset($_POST['x_trans_id']) ? $_POST['x_trans_id'] : "",
                    'invoice_num' => isset($_POST['x_invoice_num']) ? $_POST['x_invoice_num'] : "",
                    'description' => isset($_POST['x_description']) ? $_POST['x_description'] : "",
                    'amount' => isset($_POST['x_amount']) ? $_POST['x_amount'] : "",
                    'cust_id' => isset($_POST['x_cust_id']) ? $_POST['x_cust_id'] : "",
                    'first_name' => isset($_POST['x_first_name']) ? $_POST['x_first_name'] : "",
                    'last_name' => isset($_POST['x_last_name']) ? $_POST['x_last_name'] : "",
                    'company' => isset($_POST['x_company']) ? $_POST['x_company'] : "",
                    'address' => isset($_POST['x_address']) ? $_POST['x_address'] : "",
                    'city' => isset($_POST['x_city']) ? $_POST['x_city'] : "",
                    'state' => isset($_POST['x_state']) ? $_POST['x_state'] : "",
                    'zip' => isset($_POST['x_zip']) ? $_POST['x_zip'] : "",
                    'country' => isset($_POST['x_country']) ? $_POST['x_country'] : "",
                    'phone' => isset($_POST['x_phone']) ? $_POST['x_phone'] : "",
                    'email' => isset($_POST['x_email']) ? $_POST['x_email'] : "",
                    'ship_to_first_name' => isset($_POST['x_ship_to_first_name']) ? $_POST['x_ship_to_first_name'] : "",
                    'ship_to_last_name' => isset($_POST['x_ship_to_last_name']) ? $_POST['x_ship_to_last_name'] : "",
                    'ship_to_company' => isset($_POST['x_ship_to_company']) ? $_POST['x_ship_to_company'] : "",
                    'ship_to_address' => isset($_POST['x_ship_to_address']) ? $_POST['x_ship_to_address'] : "",
                    'ship_to_city' => isset($_POST['x_ship_to_city']) ? $_POST['x_ship_to_city'] : "",
                    'ship_to_state' => isset($_POST['x_ship_to_state']) ? $_POST['x_ship_to_state'] : "",
                    'ship_to_zip' => isset($_POST['x_ship_to_zip']) ? $_POST['x_ship_to_zip'] : "",
                    'ship_to_country' => isset($_POST['x_ship_to_country']) ? $_POST['x_ship_to_country'] : "",
                    'discount_amount' => isset($_POST['discount_amount']) ? $_POST['discount_amount'] : "",
                );
                $payment_id = $this->payment_model->add_payment($data_to_store);
                $status = 'Active';
                $this->write_add_model->updateStatus($id, $status);
                if ($_POST['payment_type'] == 'move_ad_top') {
                    $posts_id = $_POST['posts_id'];
                    $max_value = $this->home_model->get_maximum_value();
                    $update_max_val = $max_value + 1;
                    $data_store = array('move_to_ad' => $update_max_val);
                    $this->home_model->add_payment_type($data_store, $posts_id);
                }
                if (isset($payment_id) && !empty($payment_id)) {
                    $data_to_update = array(
                        'payment_status' => 'complete',);

                    if ($this->write_add_model->update_posts($id, $data_to_update) == TRUE) {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', 'our payment has not been done');
                        redirect("home");
                    }
                }
            } else {
                $data['flash_message'] = TRUE;
                $this->session->set_flashdata('flash_class', 'alert-error');
                $this->session->set_flashdata('flash_message', 'Your payment has not been approval');
                redirect("home");
            }
        } else {
            $data['page_type'] = $home = $this->uri->segment(1);
            $stack_state_id_selected = $this->session->userdata('stack_state_id');
            $stack_city_id_selected = $this->session->userdata('stack_city_id');
            if (!empty($stack_state_id_selected)) {
                $where_state = " AND state_id='{$stack_state_id_selected}'";
                $state_name = $this->common_model->getFieldData('state', 'state_name', $where_state);
                redirect('state_category/cat/' . $stack_state_id_selected . '/' . $state_name);
            } elseif (!empty($stack_city_id_selected)) {
                $where_city = " AND city_id='{$stack_city_id_selected}'";
                $city_name = $this->common_model->getFieldData('city', 'city_name', $where_city);
                redirect('citycategory/cat/' . $stack_city_id_selected . '/' . $city_name);
            } else {
                $data['main_content'] = 'home_view';
                $data['country_opt'] = $this->home_model->getAllCountry();
                $this->load->view('includes/template', $data);
            }
        }
    }

    function home_page() {
        $this->session->unset_userdata('stack_city_id');
        $this->session->unset_userdata('stack_state_id');
        $this->session->unset_userdata('stack_select_type');
        redirect('home');
    }

    function confirm() {
        $email_encode = $this->uri->segment(3);

        if (!empty($email_encode)) {
            $email = base64url_decode($email_encode);
            $data_to_store = array(
                'status' => 'Active',
            );

            $this->load->helper('email');
            //load email library
            $this->load->library('email');

            //read parameters from $_POST using input class
            // check is email addrress valid or no
            if (valid_email($email)) {
                $update_url = $this->user_model->update_user_by_email($email, $data_to_store);
                $where_flag = " AND primary_email='{$email}'";
                $affiliate_flag = $this->common_model->getFieldData('user', 'affiliate_flag', $where_flag);

                if ($update_url) {
                    $affiliate_user_data = $this->common_model->getRow('affiliate', 'affiliate_user_email', $email);
                    if (!empty($affiliate_user_data)) {
                        $user_data = $this->common_model->get_content_by_field('user', 'affiliate_send_user_email', $affiliate_user_data->affiliate_send_user_email);
                        $affiliate_earn = $user_data[0]['affiliate_earn'];
                        $register_price = $user_data[0]['register_price'];
                        $affiliate_number = $user_data[0]['affiliate_number'];
                        $earn_price = $register_price + $affiliate_earn;

                        if ($affiliate_flag == '0') {
                            $flag_data_store = array('affiliate_flag' => '1');
                            $this->user_model->update_user_by_email($email, $flag_data_store);
                            $earn_price = $register_price + $affiliate_earn;
                            $data_store = array(
                                'affiliate_earn' => $earn_price,
                            );
                            $this->common_model->update_by_field('user', 'affiliate_number', $affiliate_number, $data_store);
                            $data['flash_message'] = TRUE;
                            $this->session->set_flashdata('flash_class', 'alert-success');
                            $this->session->set_flashdata('flash_message', '<strong>Thank you for confirming your account.</strong>');
                            redirect('home');
                        } else {
                            redirect('home');
                        }
                    } else {

                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', '<strong>Your account has been activated - please login below.</strong>');
                        redirect('signin/signin_user');
                    }
                } else {

                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_message', '<strong>Oh snap! change a few things up and try submitting again.</strong>');
                    redirect('signup');
                }
            }
        } else {
            redirect('signin/signin_user');
        }
    }

    function account() {
        $data['user_id'] = $user_id = $this->uri->segment(3);
        $email_encode = $this->uri->segment(4);
        $whereStr = " AND user_id={$user_id}";
        $affi_number = $this->common_model->getFieldData('user', 'affiliate_number', $whereStr);

        if (!empty($affi_number)) {
            redirect("signin/signin_user/{$user_id}/affiliate");
        } else {
            $data['country'] = $this->home_model->getAllCountry();
            $count_post = $this->affiliate_model->count_account_post('uid', $user_id);
            if (!empty($count_post)) {
                $data['email'] = $email = base64url_decode($email_encode);
                $config['per_page'] = 25;
                $config["uri_segment"] = 5;
                $config['base_url'] = base_url() . 'home/account/' . $user_id . '/' . $email_encode;
                $config['use_page_numbers'] = TRUE;
                $config['num_links'] = 20;
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
                // echo $a = $this->affiliate_model->count_post_ads();

                $data['count_products'] = $this->affiliate_model->count_post_ads('', '', $user_id);
                $data['content'] = $this->affiliate_model->post_account_ads('', '', $config['per_page'], $limit_end, '', $user_id);
                $config['total_rows'] = $data['count_products'];
                $this->pagination->initialize($config);
            }
            $data['main_content'] = 'user_account_view';
            $this->load->view('includes/template', $data);
        }
    }

    function affiliate_number_account() {
        $user_id = $this->uri->segment(3);
        $whereStr = " AND user_id={$user_id}";
        $affi_number = $this->common_model->getFieldData('user', 'affiliate_number', $whereStr);
        if (!empty($affi_number)) {
            redirect("signin/signin_user/{$user_id}/affiliate");
        } else {
            $affiliate_number = affiliate_number();
            $data_store = array('affiliate_number' => $affiliate_number, 'type' => 'affiliate');
            $this->common_model->update_by_field('user', 'user_id', $user_id, $data_store);
            redirect("signin/signin_user/{$user_id}/affiliate");
        }
    }

    function change_password() {
        $email_encode = $this->uri->segment(3);
        $data['email'] = base64url_decode($email_encode);
        $data['main_content'] = 'reset_password_view';
        $this->load->view('includes/template', $data);
    }

    function set_pass_mail() {
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');

        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $email_exist = $this->common_model->count_email_exist('user', 'primary_email', $email);
            if ($email_exist != '0') {
                if (valid_email($email)) {
                    $get_admin_detail = get_admin_detail(); //common helper function for admin detail
                    $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                    $this->email->to($email);
                    $this->email->set_mailtype("html");
                    $this->email->subject("password reset:$email");
                    $mail_data['email'] = $email;
                    $mail_data['url'] = site_url() . 'home/set_password/' . base64url_encode($email);
                    $message = $this->load->view('mail_templates/reset_password_mail', $mail_data, true);
                    $this->email->message($message);

                    // try send mail ant if not able print debug
                    if (!$this->email->send()) {
                        $msgadd = "<strong>E-mail not sent </strong>"; //.$this->email->print_debugger();
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', $msgadd);
                        redirect("home/set_pass_mail");
                    } else {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', '<strong>please check your email!</strong>');
                        redirect("home");
                    }
                }
            } else {
                $msgadd = "<strong>You have not authorise to this Email please put correct Email </strong>"; //.$this->email->print_debugger();
                $data['flash_message'] = TRUE;
                $this->session->set_flashdata('flash_class', 'alert-error');
                $this->session->set_flashdata('flash_message', $msgadd);
                redirect("home/set_pass_mail");
            }
        }
        $data['main_content'] = 'reset_pass_mail_view';
        $this->load->view('includes/template', $data);
    }

    function set_password() {
        $email_encode = $this->uri->segment(3);
        $data['email'] = $email = base64url_decode($email_encode);

        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');


        if ($this->form_validation->run()) {

            $old_password = $this->input->post('old_password');
            $email = $this->input->post('email');
            $this->has_match($old_password, $email);
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[4]|max_length[32]|callback_has_match');

            $data_to_store = array(
                'password' => md5($this->input->post('password')),
                'status' => 'Active'
            );
            if ($this->user_model->update_user_by_email($email, $data_to_store)) {
                $data['flash_message'] = TRUE;
                $user_data = $this->common_model->get_content_by_field('user', 'primary_email', $email);

                $username = $user_data[0]['username'];
                $user_id = $user_data[0]['user_id'];
                $primary_email = $user_data[0]['primary_email'];
                $affiliate = $user_data[0]['type'];
                $type_of_membership = $user_data[0]['type_of_membership'];
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
                    $email1 = base64url_encode($primary_email);
                    redirect("home/account/$user_id/$email1");
                }
                //redirect("home/change_password/{$emial_encode}");
            }
        }
        $data['main_content'] = 'reset_password_view';
        $this->load->view('includes/template', $data);
    }

    public function has_match($old_password, $check_email) {
        $pass = md5($old_password);
        $result = $this->home_model->check_password($pass, $check_email);
//        exit;
        $emial_encode = base64_encode($check_email);
        if ($result == '1') {
            $data['flash_message'] = TRUE;
            $this->session->set_flashdata('flash_message', 'password has been change');
        } else {

            //$msg = $this->form_validation->set_message('has_match', 'Invalid Old Password entered ');
            $data['flash_message'] = TRUE;
            $this->session->set_flashdata('flash_message', 'Invalid Old Password entered');
            redirect("home/change_password/{$emial_encode}");
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('home');
    }

}

