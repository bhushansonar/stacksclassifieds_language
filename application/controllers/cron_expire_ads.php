<?php

class cron_expire_ads extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = '';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('write_add_model');
        $this->load->model('common_model');
        $this->load->helper('email');
        $this->load->library('email');

        if (!$this->session->userdata('is_logged')) {
            //redirect('kd2a2a0u1g4/login');
        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

    }

    /**
     * Sending out newsletter
     * @return void
     */
    public function process() {

        date_default_timezone_set('UTC');
        $start_day_hour = date("H:i");
        $current_date = strtotime(date('Y-m-d H:i:s'));
        $result_array = $this->write_add_model->get_posts_cron();
        if (!empty($result_array)) {
            for ($i = 0; $i < count($result_array); $i++) {

                $expire_date = strtotime($result_array[$i]['expire_date']);
                $posts_id = $result_array[$i]['posts_id'];
                $email = $result_array[$i]['email'];
                $uid = $result_array[$i]['uid'];
                if (!empty($expire_date)) {
                    if ($expire_date < $current_date) {
                        if (valid_email($email)) {
                            $title = "Expiration StacksClassifieds AD";
                            $get_admin_detail = get_admin_detail(); //common helper function for admin detail
                            $config['protocol'] = 'sendmail';
                            $config['mailpath'] = '/usr/sbin/sendmail';
                            $config['charset'] = 'iso-8859-1';
                            $config['mailtype'] = 'html';
                            $config['priority'] = 1;
                            $this->email->initialize($config);
                            $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                            $this->email->to($email);
                            $this->email->set_mailtype("html");
                            $this->email->subject($title);
                            $where_uid = " AND user_id={$uid}";
                            $username = $this->common_model->getFieldData('user', 'username', $where_uid);
                            if (!empty($username)) {
                                $mail_data['username'] = $username;
                            } else {
                                $mail_data['username'] = '';
                            }
                            // $mail_data['url'] = base_url() . 'write_add/update/' . $posts_id;
                            $mail_data['title'] = $title;
                            $mail_data['url'] = base_url() . 'write_add/update/' . $posts_id . '/renew';
                            $mail_data['description'] = 'Your StacksClassifieds Post has been Expired';
                            $message = $this->load->view('mail_templates/expiration_post_ad', $mail_data, true);
                            $this->email->message($message);
                            if (!$this->email->send()) {
                                $msgadd = "<strong>E-mail not sent </strong>";
                                $data['flash_message'] = TRUE;
                                $this->session->set_flashdata('flash_class', 'alert-error');
                                $this->session->set_flashdata('flash_message', $msgadd);
                            } else {
                                $data_to_store = array('status' => 'Inactive');
                                $post_update = $this->write_add_model->update_posts($posts_id, $data_to_store);
                            }
                        }
                    }
                }
            }
        }
    }

}

