<?php

class Payment extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model('payment_model');
        $this->load->model('write_add_model');
        $this->load->library('recaptcha');
        $this->load->helper('url');

        if (!$this->session->userdata('is_logged_in')) {
//redirect('admin/login');
        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {
        $this->load->helper('url');
    }

    public function single_city_payment() {

        if (!empty($_POST['promocode'])) {
            $promocode_name = $_POST['promocode'];
            $status = "Active";
            $promocode = $this->write_add_model->get_promocode($promocode_name, $status);
            $promocode_value = !empty($promocode[0]['code']) ? $promocode[0]['code'] : "";
            $promocode_type = !empty($promocode[0]['promotype']) ? $promocode[0]['promotype'] : "";
            $net_value = "0";
            if ($promocode_type == 'percentage') {
                $total = $_POST['auto_repost_price'];
                $percent_value = $total * $promocode_value;
                $percent_amount = $percent_value / 100;
                $net_value = $total - $percent_amount;
            } else {
                $total = $_POST['auto_repost_price'];
                $net_value = $total - $promocode_value;
            }
        } else {
            $net_value = $_POST['auto_repost_price'];
        }
        $session = array(
            'posts_id' => $_POST['posts_id'],
        );
        $this->session->set_userdata($session);
        $data['posts_id'] = !empty($_POST['posts_id']) ? $_POST['posts_id'] : "";
        $data['auto_repost'] = $net_value;
        $data['main_content'] = 'payment_view';
        $this->load->view('includes/template', $data);
    }

    public function payment_detail() {
        $session = array(
            'posts_id' => !empty($_POST['posts_id']) ? $_POST['posts_id'] : "",
        );
        $this->session->set_userdata($session);
        $data['posts_id'] = !empty($_POST['posts_id']) ? $_POST['posts_id'] : "";
        @$data['auto_repost'] = $_POST['auto_repost'];
        $data['main_content'] = 'payment_view';
        $this->load->view('includes/template', $data);
    }

    public function payment_send() {
        $data['payment_amt'] = decrypt($_POST["amt"]);
        $data['payment_type'] = isset($_POST['payment_type']) ? $_POST['payment_type'] : "";
        $data['posts_id'] = $_POST["posts_id"];
        $data['main_content'] = 'payment_send_view';
        $this->load->view('includes/template', $data);
    }

    public function retrieve_payment_data() {
        $data['main_content'] = 'payment_data';
        $this->load->view('includes/template', $data);
    }

}

