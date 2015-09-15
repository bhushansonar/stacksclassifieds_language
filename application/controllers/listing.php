<?php

class Listing extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('listing_model');
        $this->load->model('common_model');
        $this->load->library('Common');
        $this->load->library('Upload');
        $this->load->library('upload');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

        //all the posts sent by the view
        $id = $this->uri->segment(3);

        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');
        $user = $this->session->userdata;
        $uid = $user['user_id'];
        //pagination settings
        $config['per_page'] = 20;

        $config['base_url'] = base_url() . 'listing/index';
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
            //echo "search_c->". $search_string; die;
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
            $data['count_products'] = $this->listing_model->count_posts($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['posts'] = $this->listing_model->get_posts($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['posts'] = $this->listing_model->get_posts($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['posts'] = $this->listing_model->get_posts('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['posts'] = $this->listing_model->get_posts('', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['posts_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products'] = $this->listing_model->count_posts();
            $data['posts'] = $this->listing_model->get_posts('', '', $order_type, $config['per_page'], $limit_end, '', $uid);
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'listing_view';
        $this->load->view('includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update() {
        //product id
        $id = $this->uri->segment(3);

        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->form_validation->set_rules('country', 'country', 'required');
            $this->form_validation->set_rules('category', 'Main Category', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

            if ($this->form_validation->run()) {

                $this->load->library('upload');
                $path = './uploads/images';

                $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "*"
                ));
                if ($this->upload->do_multi_upload("images")) {

                    $file_name = $this->upload->get_multi_upload_data();
                    foreach ($file_name as $value) {
                        $images[] = $value['file_name'];
                    }

                    $_POST['images'] = implode(',', $images);
                } else {
                    $_POST['images'] = $this->input->post('old_image');
                }

                //if the insert has returned true then we show the flash message
                $redirect_url = $this->input->post('redirect_url');
                foreach ($_POST as $k => $v) {
                    if (in_array($k, array('redirect_url'))) {
                        unset($_POST[$k]);
                    }
                }

                if ($this->listing_model->update_posts() == TRUE) {
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

        $where = " AND parent_id= '0' ";
        $data['main_category_opt'] = $this->common_model->getDDArray('category', 'category_id', 'category_name', $where);
        $data['country_opt'] = $this->common_model->getDDArray('country', 'country_id', 'country_name');
        $data['posts'] = $this->listing_model->get_posts_by_id($id);
        if ($data['posts'][0]['country'] != "") {
            $data['state_opt'] = $this->common_model->getDDArray('state', 'state_id', 'state_name', " AND country_id='{$data['posts'][0]['country']}'");
        }
        if ($data['posts'][0]['state'] != "") {
            $data['city_opt'] = $this->common_model->getDDArray('city', 'city_id', 'city_name', " AND state_id='{$data['posts'][0]['state']}'");
        }
        if ($data['posts'][0]['category'] != "") {

            $where_subcategory = " AND parent_id!= '0' AND parent_id='{$data['posts'][0]['category']}'";
            $data['subcategory_opt'] = $this->common_model->getDDArray('category', 'category_id', 'category_name', $where_subcategory);
        }
        $data['main_content'] = 'listing_edit.php';
        $this->load->view('includes/template', $data);
    }

//update

    /**
     * Delete product by his id
     * @return void
     */
    public function delete() {
        //product id
        $id = $this->uri->segment(3);
        $this->listing_model->delete_posts($id);
        $this->session->set_flashdata('flash_message', 'delete');
        redirect('listing/index');
    }

//edit
}

