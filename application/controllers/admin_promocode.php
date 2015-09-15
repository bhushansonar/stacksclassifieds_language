<?php

class Admin_promocode extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'admin/promocode';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('promocode_model');
        //$this->load->model('site_language_model');
        //$this->load->model('newsletter_language_model');
        //$this->load->model('newsletter_keyword_model');
        $this->load->helper('url');
        if (!$this->session->userdata('is_logged_in_admin')) {
            redirect('admin/login');
        }
        if (!Access_level::get_access('promocode')) {
            redirect('admin/dashboard');
        }
    }

    function __encrip_password($password) {
        return md5($password);
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

        //all the posts sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 20;

        $config['base_url'] = base_url() . 'admin/promocode';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        //if order type was changed
        if ($order_type) {
            $filter_session_data['order_type'] = $order_type;
        } else {
            //we have something stored in the session?
            if ($this->session->userdata('order_type')) {
                $order_type = $this->session->userdata('order_type');
            } else {
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'DESC';
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data
        //filtered && || paginated
        if ($search_string !== false && $order !== false || $this->uri->segment(3) == true) {

            /*
              The comments here are the same for line 79 until 99

              if post is not null, we store it in session data array
              if is null, we use the session data already stored
              we save order into the the var to load the view with the param already selected
             */
            if ($search_string) {
                $filter_session_data['search_string_selected'] = $search_string;
            } else {
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if ($order) {
                $filter_session_data['order'] = $order;
            } else {
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            if (isset($filter_session_data)) {
                $this->session->set_userdata($filter_session_data);
            }

            //fetch sql data into arrays
            $data['count_products'] = $this->promocode_model->count_promocode($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['user'] = $this->promocode_model->get_promocode($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['user'] = $this->promocode_model->get_promocode($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['user'] = $this->promocode_model->get_promocode('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['user'] = $this->promocode_model->get_promocode('', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['user_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products'] = $this->promocode_model->count_promocode();
            $data['user'] = $this->promocode_model->get_promocode('', '', $order_type, $config['per_page'], $limit_end);
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'admin/promocode/list';
        $this->load->view('admin/includes/template', $data);
    }

//index

    public function add() {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            //form validation
            $this->form_validation->set_rules('promocode_name', 'Promocode name', 'trim|required');
            $this->form_validation->set_rules('promotype', 'Promo Type', 'trim|required');
            $this->form_validation->set_rules('code', 'code', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run()) {
//                $data = $this->functions->do_upload('avatar', './uploads/avatar/');
//                if (isset($data['upload_data'])) {
//                    $file_name = $data['upload_data']['file_name'];
//                } else {
//                    $file_name = "";
//                }
//                if (is_array($this->input->post('user_interests'))) {
//                    $user_interests = implode(",", $this->input->post('user_interests'));
//                } else {
//                    $user_interests = '';
//                }
//                if (is_array($this->input->post('language_id'))) {
//                    $language_ids = implode(",", $this->input->post('language_id'));
//                } else {
//                    $language_ids = '';
//                }
//                $user_rand_id = $this->functions->get_user_rand_id();
                $data_to_store = array(
                    'promocode_name' => $this->input->post('promocode_name'),
                    'code' => $this->input->post('code'),
                    'promotype' => $this->input->post('promotype'),
                    'status' => $this->input->post('status')
                );
                //if the insert has returned true then we show the flash message
                if ($this->promocode_model->store_promocode($data_to_store)) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect('admin/promocode/');
                    //redirect('admin/user'.'');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        $data['main_content'] = 'admin/promocode/add';
        $this->load->view('admin/includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update() {
        //product id
        $id = $this->uri->segment(4);
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->form_validation->set_rules('promocode_name', 'promocode name', 'trim|required');
            $this->form_validation->set_rules('promotype', 'Promo Type', 'trim|required');
            $this->form_validation->set_rules('code', 'Code', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run()) {
                // $data = $this->functions->do_upload('avatar', './uploads/avatar/');
//                if (isset($data['upload_data'])) {
//                    $file_name = $data['upload_data']['file_name'];
//                    @unlink("./uploads/avatar/" . $this->input->post('old_avatar'));
//                } else {
//                    $file_name = $this->input->post('old_avatar');
//                }
//                if (is_array($this->input->post('user_interests'))) {
//                    $user_interests = implode(",", $this->input->post('user_interests'));
//                } else {
//                    $user_interests = '';
//                }
//                if (is_array($this->input->post('language_id'))) {
//                    $language_ids = implode(",", $this->input->post('language_id'));
//                } else {
//                    $language_ids = '';
//                }
                //Main Power admin will not be inactive
                $status = ($id == 1) ? 'Active' : $this->input->post('status');
                //$type_of_membership = ($id == 1) ? 'power_admin' : $this->input->post('type_of_membership');
                $redirect_url = $this->input->post('redirect_url');
                $data_to_store = array(
                    'promocode_name' => $this->input->post('promocode_name'),
                    'code' => $this->input->post('code'),
                    'promotype' => $this->input->post('promotype'),
                    'status' => $status
                );
//                if (isset($_POST['password'])) {
//                    $this->db->set('password', $this->__encrip_password($this->input->post('password')));
//                }
                //if the insert has returned true then we show the flash message
                if ($this->promocode_model->update_promocode($id, $data_to_store) == TRUE) {
                    $this->session->set_flashdata('flash_message', 'updated');
                } else {
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                $this->session->set_flashdata('flash_message', 'update');
                redirect($redirect_url);
            }//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data

        $data['user'] = $this->promocode_model->get_promocode_by_id($id);

        //load the view
        $data['main_content'] = 'admin/promocode/edit';
        $this->load->view('admin/includes/template', $data);
    }

//update

    /**
     * Delete product by his id
     * @return void
     */
    public function delete() {
        //product id
        $id = $this->uri->segment(4);
        $this->promocode_model->delete_promocode($id);

        if ($id == 1) {
            $this->session->set_flashdata('flash_message', 'error');
        } else {
            $this->session->set_flashdata('flash_message', 'delete');
        }
        redirect('admin/promocode/');
    }

//edit



    function validate_user_interests($str) {
        $array_value = $str; //this is redundant, but it's to show you how
        //the content of the fields gets automatically passed to the method
        //print_r($str);
        if (count($array_value) <= 10) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
