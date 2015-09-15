<?php

class Admin_category_price extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'admin/category_price';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('category_price_model');
        if (!$this->session->userdata('is_logged_in_admin')) {
            redirect('admin/login');
        }
        if (!Access_level::get_access('category_price')) {
            redirect('admin/dashboard');
        }
    }

    public function index() {

        //if save button was clicked, get the data sent via post

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('price', 'Price', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

//if the form has passed through the validation
            if ($this->form_validation->run()) {
                $data_to_store = array('price' => $this->input->post('price'));
                if ($this->category_price_model->update_category_price($data_to_store)) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'price');
                    redirect('admin/category');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        $data['main_content'] = 'admin/category_price/add';
        $this->load->view('admin/includes/template', $data);
    }

}

