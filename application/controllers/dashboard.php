<?php

class Dashboard extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    function index() {

        $data['main_content'] = 'admin/dashboard_view';
        $this->load->view('admin/includes/template', $data);

        if (!$this->session->userdata('is_logged_in_admin')) {
            redirect('admin/login');
        }
//        if (!Access_level::get_access('dashboard')) {
//            redirect('admin/dashboard');
//        }
    }

    /**
     * encript the password
     * @return mixed
     */
}

