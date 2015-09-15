<?php

class Admin_featured_price extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'admin/featured_price';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('featured_price_model');
        $this->load->model('city_model');
        $this->load->model('common_model');
        $this->load->model('category_model');

        if (!$this->session->userdata('is_logged_in_admin')) {
            redirect('admin/login');
        }
        if (!Access_level::get_access('featured_price')) {
            redirect('admin/dashboard');
        }
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
        $config['base_url'] = base_url() . 'admin/featured_price';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $page = $this->uri->segment(3);

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
            $data['count_products'] = $this->featured_price_model->count_featured_price($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['city'] = $this->featured_price_model->count_featured_price($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['city'] = $this->featured_price_model->get_featured_price($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['city'] = $this->featured_price_model->get_featured_price('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['city'] = $this->featured_price_model->get_featured_price('', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['city_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products'] = $this->featured_price_model->count_featured_price();
            $data['city'] = $this->featured_price_model->get_featured_price('', '', $order_type, $config['per_page'], $limit_end);
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
        $this->pagination->initialize($config);
        $data['category_opt'] = $this->common_model->getDDArray('category', 'category_id', 'category_name_en');
        $data['main_content'] = 'admin/featured_price/list';
        $this->load->view('admin/includes/template', $data);
    }

    public function add() {

        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $week_price_arr = array(
                array(
                    //"week_1" => isset($_POST['week_1']) ? $_POST['week_1'] : "",
                    isset($_POST['week_1']) ? $_POST['week_1'] : "" => isset($_POST['price_1']) ? $_POST['week_1'] : ""
                ),
                array(
                    //"week_2" => isset($_POST['week_2']) ? $_POST['week_2'] : "",
                    isset($_POST['week_2']) ? $_POST['week_2'] : "" => isset($_POST['price_2']) ? $_POST['price_2'] : ""
                ),
                array(
                    //"week_3" => isset($_POST['week_3']) ? $_POST['week_3'] : "",
                    isset($_POST['week_3']) ? $_POST['week_3'] : "" => isset($_POST['price_3']) ? $_POST['price_3'] : ""
                ),
                array(
                    //"week_4" => isset($_POST['week_4']) ? $_POST['week_4'] : "",
                    isset($_POST['week_4']) ? $_POST['week_4'] : "" => isset($_POST['price_4']) ? $_POST['price_4'] : ""
                ),
                array(
                    //"week_5" => isset($_POST['week_5']) ? $_POST['week_5'] : "",
                    isset($_POST['week_5']) ? $_POST['week_5'] : "" => isset($_POST['price_5']) ? $_POST['price_5'] : ""
                ),
                array(
                    //"week_6" => isset($_POST['week_6']) ? $_POST['week_6'] : "",
                    isset($_POST['week_6']) ? $_POST['week_6'] : "" => isset($_POST['price_6']) ? $_POST['price_6'] : ""
                ),
                array(
                    //"week_7" => isset($_POST['week_7']) ? $_POST['week_7'] : "",
                    isset($_POST['week_7']) ? $_POST['week_7'] : "" => isset($_POST['price_7']) ? $_POST['price_7'] : ""
                ),
                array(
                    //"week_8" => isset($_POST['week_8']) ? $_POST['week_8'] : "",
                    isset($_POST['week_8']) ? $_POST['week_8'] : "" => isset($_POST['price_8']) ? $_POST['price_8'] : ""
                ),
                array(
                    //"week_9" => isset($_POST['week_9']) ? $_POST['week_9'] : "",
                    isset($_POST['week_9']) ? $_POST['week_9'] : "" => isset($_POST['price_9']) ? $_POST['price_9'] : ""
                ),
                array(
                    //"week_10" => isset($_POST['week_10']) ? $_POST['week_10'] : "",
                    isset($_POST['week_10']) ? $_POST['week_10'] : "" => isset($_POST['price_10']) ? $_POST['price_10'] : ""
                ),
                array(
                    //"week_11" => isset($_POST['week_11']) ? $_POST['week_11'] : "",
                    isset($_POST['week_11']) ? $_POST['week_11'] : "" => isset($_POST['price_11']) ? $_POST['price_11'] : ""
                ),
                array(
                    //"week_12" => isset($_POST['week_12']) ? $_POST['week_12'] : "",
                    isset($_POST['week_12']) ? $_POST['week_12'] : "" => isset($_POST['price_12']) ? $_POST['price_12'] : ""
                ),
                array(
                    //"week_13" => isset($_POST['week_13']) ? $_POST['week_13'] : "",
                    isset($_POST['week_13']) ? $_POST['week_13'] : "" => isset($_POST['price_13']) ? $_POST['price_13'] : ""
                ),
                array(
                    // "week_14" => isset($_POST['week_14']) ? $_POST['week_14'] : "",
                    isset($_POST['week_14']) ? $_POST['week_14'] : "" => isset($_POST['price_14']) ? $_POST['price_14'] : ""
                ),
                array(
                    //"week_15" => isset($_POST['week_15']) ? $_POST['week_15'] : "",
                    isset($_POST['week_15']) ? $_POST['week_15'] : "" => isset($_POST['price_15']) ? $_POST['price_15'] : ""
                ),
                array(
                    //"week_16" => isset($_POST['week_16']) ? $_POST['week_16'] : "",
                    isset($_POST['week_16']) ? $_POST['week_16'] : "" => isset($_POST['price_16']) ? $_POST['price_16'] : ""
                ),
                array(
                    //"week_17" => isset($_POST['week_17']) ? $_POST['week_17'] : "",
                    isset($_POST['week_17']) ? $_POST['week_17'] : "" => isset($_POST['price_17']) ? $_POST['price_17'] : ""
                ),
                array(
                    //"week_18" => isset($_POST['week_18']) ? $_POST['week_18'] : "",
                    isset($_POST['week_18']) ? $_POST['week_18'] : "" => isset($_POST['price_18']) ? $_POST['price_18'] : ""
                ),
                array(
                    //"week_19" => isset($_POST['week_19']) ? $_POST['week_19'] : "",
                    isset($_POST['week_19']) ? $_POST['week_19'] : "" => isset($_POST['price_19']) ? $_POST['price_19'] : ""
                ),
                array(
                    // "week_20" => isset($_POST['week_20']) ? $_POST['week_20'] : "",
                    isset($_POST['week_20']) ? $_POST['week_20'] : "" => isset($_POST['price_20']) ? $_POST['price_20'] : ""
                ),
                array(
                    //"week_21" => isset($_POST['week_21']) ? $_POST['week_21'] : "",
                    isset($_POST['week_21']) ? $_POST['week_21'] : "" => isset($_POST['price_21']) ? $_POST['price_21'] : ""
                ),
                array(
                    //"week_22" => isset($_POST['week_22']) ? $_POST['week_22'] : "",
                    isset($_POST['week_22']) ? $_POST['week_22'] : "" => isset($_POST['price_22']) ? $_POST['price_22'] : ""
                ),
                array(
                    //"week_23" => isset($_POST['week_23']) ? $_POST['week_23'] : "",
                    isset($_POST['week_23']) ? $_POST['week_23'] : "" => isset($_POST['price_23']) ? $_POST['price_23'] : ""
                ),
                array(
                    //"week_24" => isset($_POST['week_24']) ? $_POST['week_24'] : "",
                    isset($_POST['week_24']) ? $_POST['week_24'] : "" => isset($_POST['price_24']) ? $_POST['price_24'] : ""
                ),
                array(
                    //"week_25" => isset($_POST['week_25']) ? $_POST['week_25'] : "",
                    isset($_POST['week_25']) ? $_POST['week_25'] : "" => isset($_POST['price_25']) ? $_POST['price_25'] : ""
                ),
                array(
                    //"week_26" => isset($_POST['week_26']) ? $_POST['week_26'] : "",
                    isset($_POST['week_26']) ? $_POST['week_26'] : "" => isset($_POST['price_26']) ? $_POST['price_26'] : ""
                ),
                array(
                    //"week_27" => isset($_POST['week_27']) ? $_POST['week_27'] : "",
                    isset($_POST['week_27']) ? $_POST['week_27'] : "" => isset($_POST['price_27']) ? $_POST['price_27'] : ""
                ),
                array(
                    //"week_28" => isset($_POST['week_28']) ? $_POST['week_28'] : "",
                    isset($_POST['week_28']) ? $_POST['week_28'] : "" => isset($_POST['price_28']) ? $_POST['price_28'] : ""
                ),
                array(
                    //"week_29" => isset($_POST['week_29']) ? $_POST['week_29'] : "",
                    isset($_POST['week_29']) ? $_POST['week_29'] : "" => isset($_POST['price_29']) ? $_POST['price_29'] : ""
                ),
                array(
                    // "week_30" => isset($_POST['week_30']) ? $_POST['week_30'] : "",
                    isset($_POST['week_30']) ? $_POST['week_30'] : "" => isset($_POST['price_30']) ? $_POST['price_30'] : ""
                ),
                array(
                    //"week_31" => isset($_POST['week_31']) ? $_POST['week_31'] : "",
                    isset($_POST['week_31']) ? $_POST['week_31'] : "" => isset($_POST['price_31']) ? $_POST['price_31'] : ""
                ),
                array(
                    //"week_32" => isset($_POST['week_32']) ? $_POST['week_32'] : "",
                    isset($_POST['week_32']) ? $_POST['week_32'] : "" => isset($_POST['price_32']) ? $_POST['price_32'] : ""
                ),
                array(
                    //"week_33" => isset($_POST['week_33']) ? $_POST['week_33'] : "",
                    isset($_POST['week_33']) ? $_POST['week_33'] : "" => isset($_POST['price_33']) ? $_POST['price_33'] : ""
                ),
                array(
                    //"week_34" => isset($_POST['week_34']) ? $_POST['week_34'] : "",
                    isset($_POST['week_34']) ? $_POST['week_34'] : "" => isset($_POST['price_34']) ? $_POST['price_34'] : ""
                ),
                array(
                    //"week_35" => isset($_POST['week_35']) ? $_POST['week_35'] : "",
                    isset($_POST['week_35']) ? $_POST['week_35'] : "" => isset($_POST['price_35']) ? $_POST['price_35'] : ""
                ),
                array(
                    //"week_36" => isset($_POST['week_36']) ? $_POST['week_36'] : "",
                    isset($_POST['week_36']) ? $_POST['week_36'] : "" => isset($_POST['price_36']) ? $_POST['price_36'] : ""
                ),
                array(
                    //"week_37" => isset($_POST['week_37']) ? $_POST['week_37'] : "",
                    isset($_POST['week_37']) ? $_POST['week_37'] : "" => isset($_POST['price_37']) ? $_POST['price_37'] : ""
                ),
                array(
                    //"week_38" => isset($_POST['week_38']) ? $_POST['week_38'] : "",
                    isset($_POST['week_38']) ? $_POST['week_38'] : "" => isset($_POST['price_38']) ? $_POST['price_38'] : ""
                ),
                array(
                    //"week_39" => isset($_POST['week_39']) ? $_POST['week_39'] : "",
                    isset($_POST['week_39']) ? $_POST['week_39'] : "" => isset($_POST['price_39']) ? $_POST['price_39'] : ""
                ),
                array(
                    //"week_40" => isset($_POST['week_40']) ? $_POST['week_40'] : "",
                    isset($_POST['week_40']) ? $_POST['week_40'] : "" => isset($_POST['price_40']) ? $_POST['price_40'] : ""
                ),
                array(
                    //"week_41" => isset($_POST['week_41']) ? $_POST['week_41'] : "",
                    isset($_POST['week_41']) ? $_POST['week_41'] : "" => isset($_POST['price_41']) ? $_POST['price_41'] : ""
                ),
                array(
                    //"week_42" => isset($_POST['week_42']) ? $_POST['week_42'] : "",
                    isset($_POST['week_42']) ? $_POST['week_42'] : "" => isset($_POST['price_42']) ? $_POST['price_42'] : ""
                ),
                array(
                    //"week_43" => isset($_POST['week_43']) ? $_POST['week_43'] : "",
                    isset($_POST['week_43']) ? $_POST['week_43'] : "" => isset($_POST['price_43']) ? $_POST['price_43'] : ""
                ),
                array(
                    //"week_44" => isset($_POST['week_44']) ? $_POST['week_44'] : "",
                    isset($_POST['week_44']) ? $_POST['week_44'] : "" => isset($_POST['price_44']) ? $_POST['price_44'] : ""
                ),
                array(
                    //"week_45" => isset($_POST['week_45']) ? $_POST['week_45'] : "",
                    isset($_POST['week_45']) ? $_POST['week_45'] : "" => isset($_POST['price_45']) ? $_POST['price_45'] : ""
                ),
                array(
                    //"week_46" => isset($_POST['week_46']) ? $_POST['week_46'] : "",
                    isset($_POST['week_46']) ? $_POST['week_46'] : "" => isset($_POST['price_46']) ? $_POST['price_46'] : ""
                ),
                array(
                    //"week_47" => isset($_POST['week_47']) ? $_POST['week_47'] : "",
                    isset($_POST['week_47']) ? $_POST['week_47'] : "" => isset($_POST['price_47']) ? $_POST['price_47'] : ""
                ),
                array(
                    //"week_48" => isset($_POST['week_48']) ? $_POST['week_48'] : "",
                    isset($_POST['week_48']) ? $_POST['week_48'] : "" => isset($_POST['price_48']) ? $_POST['price_48'] : ""
                ),
                array(
                    //"week_49" => isset($_POST['week_49']) ? $_POST['week_49'] : "",
                    isset($_POST['week_49']) ? $_POST['week_49'] : "" => isset($_POST['price_49']) ? $_POST['price_49'] : ""
                ),
                array(
                    //"week_50" => isset($_POST['week_50']) ? $_POST['week_50'] : "",
                    isset($_POST['week_50']) ? $_POST['week_50'] : "" => isset($_POST['price_50']) ? $_POST['price_50'] : ""
                ),
                array(
                    //"week_51" => isset($_POST['week_51']) ? $_POST['week_51'] : "",
                    isset($_POST['week_51']) ? $_POST['week_51'] : "" => isset($_POST['price_51']) ? $_POST['price_51'] : ""
                ),
                array(
                    //"week_52" => isset($_POST['week_52']) ? $_POST['week_52'] : "",
                    isset($_POST['week_52']) ? $_POST['week_52'] : "" => isset($_POST['price_52']) ? $_POST['price_52'] : ""
                )
            );

            $aryMain = array_filter(array_map('array_filter', $week_price_arr));
            $featured_week_price = json_encode($aryMain);

            $data = array();
            $this->form_validation->set_rules('country', 'Country Name', 'required');
            $this->form_validation->set_rules('state', 'State Name', 'required');
            $this->form_validation->set_rules('city', 'City Name', 'required');
            $this->form_validation->set_rules('city_category', 'Category', 'required');
            if (isset($_POST['price_1'])) {
                $this->form_validation->set_rules('price_1', '1 Week Price', 'required');
            }
            if (isset($_POST['price_2'])) {
                $this->form_validation->set_rules('price_2', '2 Week Price', 'required');
            }
            if (isset($_POST['price_3'])) {
                $this->form_validation->set_rules('price_3', '3 Week Price', 'required');
            }
            if (isset($_POST['price_4'])) {
                $this->form_validation->set_rules('price_4', '4 Week Price', 'required');
            }
            if (isset($_POST['price_5'])) {
                $this->form_validation->set_rules('price_5', '5 Week Price', 'required');
            }
            if (isset($_POST['price_6'])) {
                $this->form_validation->set_rules('price_6', '6 Week Price', 'required');
            }
            if (isset($_POST['price_7'])) {
                $this->form_validation->set_rules('price_7', '7 Week Price', 'required');
            }
            if (isset($_POST['price_8'])) {
                $this->form_validation->set_rules('price_8', '8 Week Price', 'required');
            }
            if (isset($_POST['price_9'])) {
                $this->form_validation->set_rules('price_9', '9 Week Price', 'required');
            }
            if (isset($_POST['price_10'])) {
                $this->form_validation->set_rules('price_10', '10 Week Price', 'required');
            }
            if (isset($_POST['price_11'])) {
                $this->form_validation->set_rules('price_11', '11 Week Price', 'required');
            }
            if (isset($_POST['price_12'])) {
                $this->form_validation->set_rules('price_12', '12 Week Price', 'required');
            }
            if (isset($_POST['price_13'])) {
                $this->form_validation->set_rules('price_13', '13 Week Price', 'required');
            }
            if (isset($_POST['price_14'])) {
                $this->form_validation->set_rules('price_14', '14 Week Price', 'required');
            }
            if (isset($_POST['price_15'])) {
                $this->form_validation->set_rules('price_15', '15 Week Price', 'required');
            }
            if (isset($_POST['price_16'])) {
                $this->form_validation->set_rules('price_16', '16 Week Price', 'required');
            }
            if (isset($_POST['price_17'])) {
                $this->form_validation->set_rules('price_17', '17 Week Price', 'required');
            }
            if (isset($_POST['price_18'])) {
                $this->form_validation->set_rules('price_18', '18 Week Price', 'required');
            }if (isset($_POST['price_19'])) {
                $this->form_validation->set_rules('price_19', '19 Week Price', 'required');
            }if (isset($_POST['price_20'])) {
                $this->form_validation->set_rules('price_20', '20 Week Price', 'required');
            }if (isset($_POST['price_21'])) {
                $this->form_validation->set_rules('price_21', '21 Week Price', 'required');
            }if (isset($_POST['price_22'])) {
                $this->form_validation->set_rules('price_22', '22 Week Price', 'required');
            }
            if (isset($_POST['price_23'])) {
                $this->form_validation->set_rules('price_23', '23 Week Price', 'required');
            }
            if (isset($_POST['price_24'])) {
                $this->form_validation->set_rules('price_24', '24 Week Price', 'required');
            }
            if (isset($_POST['price_25'])) {
                $this->form_validation->set_rules('price_25', '25 Week Price', 'required');
            }
            if (isset($_POST['price_25'])) {
                $this->form_validation->set_rules('price_25', '25 Week Price', 'required');
            }
            if (isset($_POST['price_26'])) {
                $this->form_validation->set_rules('price_26', '26 Week Price', 'required');
            }
            if (isset($_POST['price_27'])) {
                $this->form_validation->set_rules('price_27', '27 Week Price', 'required');
            }
            if (isset($_POST['price_28'])) {
                $this->form_validation->set_rules('price_28', '28 Week Price', 'required');
            }
            if (isset($_POST['price_29'])) {
                $this->form_validation->set_rules('price_29', '29 Week Price', 'required');
            }
            if (isset($_POST['price_30'])) {
                $this->form_validation->set_rules('price_30', '30 Week Price', 'required');
            }
            if (isset($_POST['price_31'])) {
                $this->form_validation->set_rules('price_31', '31 Week Price', 'required');
            }
            if (isset($_POST['price_32'])) {
                $this->form_validation->set_rules('price_32', '32 Week Price', 'required');
            }
            if (isset($_POST['price_33'])) {
                $this->form_validation->set_rules('price_33', '33 Week Price', 'required');
            }
            if (isset($_POST['price_34'])) {
                $this->form_validation->set_rules('price_34', '34 Week Price', 'required');
            }
            if (isset($_POST['price_35'])) {
                $this->form_validation->set_rules('price_35', '35 Week Price', 'required');
            }
            if (isset($_POST['price_36'])) {
                $this->form_validation->set_rules('price_36', '36 Week Price', 'required');
            }
            if (isset($_POST['price_37'])) {
                $this->form_validation->set_rules('price_37', '37 Week Price', 'required');
            }
            if (isset($_POST['price_38'])) {
                $this->form_validation->set_rules('price_38', '38 Week Price', 'required');
            }
            if (isset($_POST['price_39'])) {
                $this->form_validation->set_rules('price_39', '39 Week Price', 'required');
            }
            if (isset($_POST['price_40'])) {
                $this->form_validation->set_rules('price_40', '40 Week Price', 'required');
            }
            if (isset($_POST['price_41'])) {
                $this->form_validation->set_rules('price_41', '41 Week Price', 'required');
            }
            if (isset($_POST['price_42'])) {
                $this->form_validation->set_rules('price_42', '42 Week Price', 'required');
            }
            if (isset($_POST['price_43'])) {
                $this->form_validation->set_rules('price_43', '43 Week Price', 'required');
            }
            if (isset($_POST['price_44'])) {
                $this->form_validation->set_rules('price_44', '44 Week Price', 'required');
            }
            if (isset($_POST['price_45'])) {
                $this->form_validation->set_rules('price_45', '45 Week Price', 'required');
            }if (isset($_POST['price_46'])) {
                $this->form_validation->set_rules('price_46', '46 Week Price', 'required');
            }
            if (isset($_POST['price_47'])) {
                $this->form_validation->set_rules('price_47', '47 Week Price', 'required');
            }
            if (isset($_POST['price_48'])) {
                $this->form_validation->set_rules('price_48', '48 Week Price', 'required');
            }
            if (isset($_POST['price_49'])) {
                $this->form_validation->set_rules('price_49', '49 Week Price', 'required');
            }
            if (isset($_POST['price_50'])) {
                $this->form_validation->set_rules('price_50', '50 Week Price', 'required');
            }
            if (isset($_POST['price_51'])) {
                $this->form_validation->set_rules('price_51', '51 Week Price', 'required');
            }

            if (isset($_POST['price_52'])) {
                $this->form_validation->set_rules('price_52', '52 Week Price', 'required');
            }


            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run()) {
                //if the insert has returned true then we show the flash message
                $data_to_store = array(
                    'country_id' => isset($_POST['country']) ? $_POST['country'] : "",
                    'state_id' => isset($_POST['state']) ? $_POST['state'] : "",
                    'city_id' => isset($_POST['city']) ? $_POST['city'] : "",
                    'category_id' => isset($_POST['city_category']) ? $_POST['city_category'] : "",
                    'featured_week_price' => $featured_week_price,
                );

                if ($this->featured_price_model->store_featured_price($data_to_store)) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect('admin/featured_price');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        $data['state_opt'] = array("" => "Select");
        $data['city_opt'] = array("" => "Select");
        $data['country_opt'] = $this->common_model->getDDArray('country', 'country_id', 'country_name');
        $data['par_cat_array'] = $this->category_model->getParentCategoryList(0, $old_cat = "", 0, 1, 5);
        $data['main_content'] = 'admin/featured_price/add';
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

            $this->form_validation->set_rules('country', 'Country Name', 'required');
            $this->form_validation->set_rules('state', 'State Name', 'required');
            $this->form_validation->set_rules('city', 'City Name', 'required');
            $this->form_validation->set_rules('city_category', 'Category', 'required');

            if (isset($_POST['price_1'])) {
                $this->form_validation->set_rules('price_1', '1 Week Price', 'required');
            }
            if (isset($_POST['price_2'])) {
                $this->form_validation->set_rules('price_2', '2 Week Price', 'required');
            }
            if (isset($_POST['price_3'])) {
                $this->form_validation->set_rules('price_3', '3 Week Price', 'required');
            }
            if (isset($_POST['price_4'])) {
                $this->form_validation->set_rules('price_4', '4 Week Price', 'required');
            }
            if (isset($_POST['price_5'])) {
                $this->form_validation->set_rules('price_5', '5 Week Price', 'required');
            }
            if (isset($_POST['price_6'])) {
                $this->form_validation->set_rules('price_6', '6 Week Price', 'required');
            }
            if (isset($_POST['price_7'])) {
                $this->form_validation->set_rules('price_7', '7 Week Price', 'required');
            }
            if (isset($_POST['price_8'])) {
                $this->form_validation->set_rules('price_8', '8 Week Price', 'required');
            }
            if (isset($_POST['price_9'])) {
                $this->form_validation->set_rules('price_9', '9 Week Price', 'required');
            }
            if (isset($_POST['price_10'])) {
                $this->form_validation->set_rules('price_10', '10 Week Price', 'required');
            }
            if (isset($_POST['price_11'])) {
                $this->form_validation->set_rules('price_11', '11 Week Price', 'required');
            }
            if (isset($_POST['price_12'])) {
                $this->form_validation->set_rules('price_12', '12 Week Price', 'required');
            }
            if (isset($_POST['price_13'])) {
                $this->form_validation->set_rules('price_13', '13 Week Price', 'required');
            }
            if (isset($_POST['price_14'])) {
                $this->form_validation->set_rules('price_14', '14 Week Price', 'required');
            }
            if (isset($_POST['price_15'])) {
                $this->form_validation->set_rules('price_15', '15 Week Price', 'required');
            }
            if (isset($_POST['price_16'])) {
                $this->form_validation->set_rules('price_16', '16 Week Price', 'required');
            }
            if (isset($_POST['price_17'])) {
                $this->form_validation->set_rules('price_17', '17 Week Price', 'required');
            }
            if (isset($_POST['price_18'])) {
                $this->form_validation->set_rules('price_18', '18 Week Price', 'required');
            }if (isset($_POST['price_19'])) {
                $this->form_validation->set_rules('price_19', '19 Week Price', 'required');
            }if (isset($_POST['price_20'])) {
                $this->form_validation->set_rules('price_20', '20 Week Price', 'required');
            }if (isset($_POST['price_21'])) {
                $this->form_validation->set_rules('price_21', '21 Week Price', 'required');
            }if (isset($_POST['price_22'])) {
                $this->form_validation->set_rules('price_22', '22 Week Price', 'required');
            }
            if (isset($_POST['price_23'])) {
                $this->form_validation->set_rules('price_23', '23 Week Price', 'required');
            }
            if (isset($_POST['price_24'])) {
                $this->form_validation->set_rules('price_24', '24 Week Price', 'required');
            }
            if (isset($_POST['price_25'])) {
                $this->form_validation->set_rules('price_25', '25 Week Price', 'required');
            }
            if (isset($_POST['price_25'])) {
                $this->form_validation->set_rules('price_25', '25 Week Price', 'required');
            }
            if (isset($_POST['price_26'])) {
                $this->form_validation->set_rules('price_26', '26 Week Price', 'required');
            }
            if (isset($_POST['price_27'])) {
                $this->form_validation->set_rules('price_27', '27 Week Price', 'required');
            }
            if (isset($_POST['price_28'])) {
                $this->form_validation->set_rules('price_28', '28 Week Price', 'required');
            }
            if (isset($_POST['price_29'])) {
                $this->form_validation->set_rules('price_29', '29 Week Price', 'required');
            }
            if (isset($_POST['price_30'])) {
                $this->form_validation->set_rules('price_30', '30 Week Price', 'required');
            }
            if (isset($_POST['price_31'])) {
                $this->form_validation->set_rules('price_31', '31 Week Price', 'required');
            }
            if (isset($_POST['price_32'])) {
                $this->form_validation->set_rules('price_32', '32 Week Price', 'required');
            }
            if (isset($_POST['price_33'])) {
                $this->form_validation->set_rules('price_33', '33 Week Price', 'required');
            }
            if (isset($_POST['price_34'])) {
                $this->form_validation->set_rules('price_34', '34 Week Price', 'required');
            }
            if (isset($_POST['price_35'])) {
                $this->form_validation->set_rules('price_35', '35 Week Price', 'required');
            }
            if (isset($_POST['price_36'])) {
                $this->form_validation->set_rules('price_36', '36 Week Price', 'required');
            }
            if (isset($_POST['price_37'])) {
                $this->form_validation->set_rules('price_37', '37 Week Price', 'required');
            }
            if (isset($_POST['price_38'])) {
                $this->form_validation->set_rules('price_38', '38 Week Price', 'required');
            }
            if (isset($_POST['price_39'])) {
                $this->form_validation->set_rules('price_39', '39 Week Price', 'required');
            }
            if (isset($_POST['price_40'])) {
                $this->form_validation->set_rules('price_40', '40 Week Price', 'required');
            }
            if (isset($_POST['price_41'])) {
                $this->form_validation->set_rules('price_41', '41 Week Price', 'required');
            }
            if (isset($_POST['price_42'])) {
                $this->form_validation->set_rules('price_42', '42 Week Price', 'required');
            }
            if (isset($_POST['price_43'])) {
                $this->form_validation->set_rules('price_43', '43 Week Price', 'required');
            }
            if (isset($_POST['price_44'])) {
                $this->form_validation->set_rules('price_44', '44 Week Price', 'required');
            }
            if (isset($_POST['price_45'])) {
                $this->form_validation->set_rules('price_45', '45 Week Price', 'required');
            }if (isset($_POST['price_46'])) {
                $this->form_validation->set_rules('price_46', '46 Week Price', 'required');
            }
            if (isset($_POST['price_47'])) {
                $this->form_validation->set_rules('price_47', '47 Week Price', 'required');
            }
            if (isset($_POST['price_48'])) {
                $this->form_validation->set_rules('price_48', '48 Week Price', 'required');
            }
            if (isset($_POST['price_49'])) {
                $this->form_validation->set_rules('price_49', '49 Week Price', 'required');
            }
            if (isset($_POST['price_50'])) {
                $this->form_validation->set_rules('price_50', '50 Week Price', 'required');
            }
            if (isset($_POST['price_51'])) {
                $this->form_validation->set_rules('price_51', '51 Week Price', 'required');
            }

            if (isset($_POST['price_52'])) {
                $this->form_validation->set_rules('price_52', '52 Week Price', 'required');
            }
            $week_price_arr = array(
                array(
                    //"week_1" => isset($_POST['week_1']) ? $_POST['week_1'] : "",
                    isset($_POST['week_1']) ? $_POST['week_1'] : "" => isset($_POST['price_1']) ? $_POST['week_1'] : ""
                ),
                array(
                    //"week_2" => isset($_POST['week_2']) ? $_POST['week_2'] : "",
                    isset($_POST['week_2']) ? $_POST['week_2'] : "" => isset($_POST['price_2']) ? $_POST['price_2'] : ""
                ),
                array(
                    //"week_3" => isset($_POST['week_3']) ? $_POST['week_3'] : "",
                    isset($_POST['week_3']) ? $_POST['week_3'] : "" => isset($_POST['price_3']) ? $_POST['price_3'] : ""
                ),
                array(
                    //"week_4" => isset($_POST['week_4']) ? $_POST['week_4'] : "",
                    isset($_POST['week_4']) ? $_POST['week_4'] : "" => isset($_POST['price_4']) ? $_POST['price_4'] : ""
                ),
                array(
                    //"week_5" => isset($_POST['week_5']) ? $_POST['week_5'] : "",
                    isset($_POST['week_5']) ? $_POST['week_5'] : "" => isset($_POST['price_5']) ? $_POST['price_5'] : ""
                ),
                array(
                    //"week_6" => isset($_POST['week_6']) ? $_POST['week_6'] : "",
                    isset($_POST['week_6']) ? $_POST['week_6'] : "" => isset($_POST['price_6']) ? $_POST['price_6'] : ""
                ),
                array(
                    //"week_7" => isset($_POST['week_7']) ? $_POST['week_7'] : "",
                    isset($_POST['week_7']) ? $_POST['week_7'] : "" => isset($_POST['price_7']) ? $_POST['price_7'] : ""
                ),
                array(
                    //"week_8" => isset($_POST['week_8']) ? $_POST['week_8'] : "",
                    isset($_POST['week_8']) ? $_POST['week_8'] : "" => isset($_POST['price_8']) ? $_POST['price_8'] : ""
                ),
                array(
                    //"week_9" => isset($_POST['week_9']) ? $_POST['week_9'] : "",
                    isset($_POST['week_9']) ? $_POST['week_9'] : "" => isset($_POST['price_9']) ? $_POST['price_9'] : ""
                ),
                array(
                    //"week_10" => isset($_POST['week_10']) ? $_POST['week_10'] : "",
                    isset($_POST['week_10']) ? $_POST['week_10'] : "" => isset($_POST['price_10']) ? $_POST['price_10'] : ""
                ),
                array(
                    //"week_11" => isset($_POST['week_11']) ? $_POST['week_11'] : "",
                    isset($_POST['week_11']) ? $_POST['week_11'] : "" => isset($_POST['price_11']) ? $_POST['price_11'] : ""
                ),
                array(
                    //"week_12" => isset($_POST['week_12']) ? $_POST['week_12'] : "",
                    isset($_POST['week_12']) ? $_POST['week_12'] : "" => isset($_POST['price_12']) ? $_POST['price_12'] : ""
                ),
                array(
                    //"week_13" => isset($_POST['week_13']) ? $_POST['week_13'] : "",
                    isset($_POST['week_13']) ? $_POST['week_13'] : "" => isset($_POST['price_13']) ? $_POST['price_13'] : ""
                ),
                array(
                    // "week_14" => isset($_POST['week_14']) ? $_POST['week_14'] : "",
                    isset($_POST['week_14']) ? $_POST['week_14'] : "" => isset($_POST['price_14']) ? $_POST['price_14'] : ""
                ),
                array(
                    //"week_15" => isset($_POST['week_15']) ? $_POST['week_15'] : "",
                    isset($_POST['week_15']) ? $_POST['week_15'] : "" => isset($_POST['price_15']) ? $_POST['price_15'] : ""
                ),
                array(
                    //"week_16" => isset($_POST['week_16']) ? $_POST['week_16'] : "",
                    isset($_POST['week_16']) ? $_POST['week_16'] : "" => isset($_POST['price_16']) ? $_POST['price_16'] : ""
                ),
                array(
                    //"week_17" => isset($_POST['week_17']) ? $_POST['week_17'] : "",
                    isset($_POST['week_17']) ? $_POST['week_17'] : "" => isset($_POST['price_17']) ? $_POST['price_17'] : ""
                ),
                array(
                    //"week_18" => isset($_POST['week_18']) ? $_POST['week_18'] : "",
                    isset($_POST['week_18']) ? $_POST['week_18'] : "" => isset($_POST['price_18']) ? $_POST['price_18'] : ""
                ),
                array(
                    //"week_19" => isset($_POST['week_19']) ? $_POST['week_19'] : "",
                    isset($_POST['week_19']) ? $_POST['week_19'] : "" => isset($_POST['price_19']) ? $_POST['price_19'] : ""
                ),
                array(
                    // "week_20" => isset($_POST['week_20']) ? $_POST['week_20'] : "",
                    isset($_POST['week_20']) ? $_POST['week_20'] : "" => isset($_POST['price_20']) ? $_POST['price_20'] : ""
                ),
                array(
                    //"week_21" => isset($_POST['week_21']) ? $_POST['week_21'] : "",
                    isset($_POST['week_21']) ? $_POST['week_21'] : "" => isset($_POST['price_21']) ? $_POST['price_21'] : ""
                ),
                array(
                    //"week_22" => isset($_POST['week_22']) ? $_POST['week_22'] : "",
                    isset($_POST['week_22']) ? $_POST['week_22'] : "" => isset($_POST['price_22']) ? $_POST['price_22'] : ""
                ),
                array(
                    //"week_23" => isset($_POST['week_23']) ? $_POST['week_23'] : "",
                    isset($_POST['week_23']) ? $_POST['week_23'] : "" => isset($_POST['price_23']) ? $_POST['price_23'] : ""
                ),
                array(
                    //"week_24" => isset($_POST['week_24']) ? $_POST['week_24'] : "",
                    isset($_POST['week_24']) ? $_POST['week_24'] : "" => isset($_POST['price_24']) ? $_POST['price_24'] : ""
                ),
                array(
                    //"week_25" => isset($_POST['week_25']) ? $_POST['week_25'] : "",
                    isset($_POST['week_25']) ? $_POST['week_25'] : "" => isset($_POST['price_25']) ? $_POST['price_25'] : ""
                ),
                array(
                    //"week_26" => isset($_POST['week_26']) ? $_POST['week_26'] : "",
                    isset($_POST['week_26']) ? $_POST['week_26'] : "" => isset($_POST['price_26']) ? $_POST['price_26'] : ""
                ),
                array(
                    //"week_27" => isset($_POST['week_27']) ? $_POST['week_27'] : "",
                    isset($_POST['week_27']) ? $_POST['week_27'] : "" => isset($_POST['price_27']) ? $_POST['price_27'] : ""
                ),
                array(
                    //"week_28" => isset($_POST['week_28']) ? $_POST['week_28'] : "",
                    isset($_POST['week_28']) ? $_POST['week_28'] : "" => isset($_POST['price_28']) ? $_POST['price_28'] : ""
                ),
                array(
                    //"week_29" => isset($_POST['week_29']) ? $_POST['week_29'] : "",
                    isset($_POST['week_29']) ? $_POST['week_29'] : "" => isset($_POST['price_29']) ? $_POST['price_29'] : ""
                ),
                array(
                    // "week_30" => isset($_POST['week_30']) ? $_POST['week_30'] : "",
                    isset($_POST['week_30']) ? $_POST['week_30'] : "" => isset($_POST['price_30']) ? $_POST['price_30'] : ""
                ),
                array(
                    //"week_31" => isset($_POST['week_31']) ? $_POST['week_31'] : "",
                    isset($_POST['week_31']) ? $_POST['week_31'] : "" => isset($_POST['price_31']) ? $_POST['price_31'] : ""
                ),
                array(
                    //"week_32" => isset($_POST['week_32']) ? $_POST['week_32'] : "",
                    isset($_POST['week_32']) ? $_POST['week_32'] : "" => isset($_POST['price_32']) ? $_POST['price_32'] : ""
                ),
                array(
                    //"week_33" => isset($_POST['week_33']) ? $_POST['week_33'] : "",
                    isset($_POST['week_33']) ? $_POST['week_33'] : "" => isset($_POST['price_33']) ? $_POST['price_33'] : ""
                ),
                array(
                    //"week_34" => isset($_POST['week_34']) ? $_POST['week_34'] : "",
                    isset($_POST['week_34']) ? $_POST['week_34'] : "" => isset($_POST['price_34']) ? $_POST['price_34'] : ""
                ),
                array(
                    //"week_35" => isset($_POST['week_35']) ? $_POST['week_35'] : "",
                    isset($_POST['week_35']) ? $_POST['week_35'] : "" => isset($_POST['price_35']) ? $_POST['price_35'] : ""
                ),
                array(
                    //"week_36" => isset($_POST['week_36']) ? $_POST['week_36'] : "",
                    isset($_POST['week_36']) ? $_POST['week_36'] : "" => isset($_POST['price_36']) ? $_POST['price_36'] : ""
                ),
                array(
                    //"week_37" => isset($_POST['week_37']) ? $_POST['week_37'] : "",
                    isset($_POST['week_37']) ? $_POST['week_37'] : "" => isset($_POST['price_37']) ? $_POST['price_37'] : ""
                ),
                array(
                    //"week_38" => isset($_POST['week_38']) ? $_POST['week_38'] : "",
                    isset($_POST['week_38']) ? $_POST['week_38'] : "" => isset($_POST['price_38']) ? $_POST['price_38'] : ""
                ),
                array(
                    //"week_39" => isset($_POST['week_39']) ? $_POST['week_39'] : "",
                    isset($_POST['week_39']) ? $_POST['week_39'] : "" => isset($_POST['price_39']) ? $_POST['price_39'] : ""
                ),
                array(
                    //"week_40" => isset($_POST['week_40']) ? $_POST['week_40'] : "",
                    isset($_POST['week_40']) ? $_POST['week_40'] : "" => isset($_POST['price_40']) ? $_POST['price_40'] : ""
                ),
                array(
                    //"week_41" => isset($_POST['week_41']) ? $_POST['week_41'] : "",
                    isset($_POST['week_41']) ? $_POST['week_41'] : "" => isset($_POST['price_41']) ? $_POST['price_41'] : ""
                ),
                array(
                    //"week_42" => isset($_POST['week_42']) ? $_POST['week_42'] : "",
                    isset($_POST['week_42']) ? $_POST['week_42'] : "" => isset($_POST['price_42']) ? $_POST['price_42'] : ""
                ),
                array(
                    //"week_43" => isset($_POST['week_43']) ? $_POST['week_43'] : "",
                    isset($_POST['week_43']) ? $_POST['week_43'] : "" => isset($_POST['price_43']) ? $_POST['price_43'] : ""
                ),
                array(
                    //"week_44" => isset($_POST['week_44']) ? $_POST['week_44'] : "",
                    isset($_POST['week_44']) ? $_POST['week_44'] : "" => isset($_POST['price_44']) ? $_POST['price_44'] : ""
                ),
                array(
                    //"week_45" => isset($_POST['week_45']) ? $_POST['week_45'] : "",
                    isset($_POST['week_45']) ? $_POST['week_45'] : "" => isset($_POST['price_45']) ? $_POST['price_45'] : ""
                ),
                array(
                    //"week_46" => isset($_POST['week_46']) ? $_POST['week_46'] : "",
                    isset($_POST['week_46']) ? $_POST['week_46'] : "" => isset($_POST['price_46']) ? $_POST['price_46'] : ""
                ),
                array(
                    //"week_47" => isset($_POST['week_47']) ? $_POST['week_47'] : "",
                    isset($_POST['week_47']) ? $_POST['week_47'] : "" => isset($_POST['price_47']) ? $_POST['price_47'] : ""
                ),
                array(
                    //"week_48" => isset($_POST['week_48']) ? $_POST['week_48'] : "",
                    isset($_POST['week_48']) ? $_POST['week_48'] : "" => isset($_POST['price_48']) ? $_POST['price_48'] : ""
                ),
                array(
                    //"week_49" => isset($_POST['week_49']) ? $_POST['week_49'] : "",
                    isset($_POST['week_49']) ? $_POST['week_49'] : "" => isset($_POST['price_49']) ? $_POST['price_49'] : ""
                ),
                array(
                    //"week_50" => isset($_POST['week_50']) ? $_POST['week_50'] : "",
                    isset($_POST['week_50']) ? $_POST['week_50'] : "" => isset($_POST['price_50']) ? $_POST['price_50'] : ""
                ),
                array(
                    //"week_51" => isset($_POST['week_51']) ? $_POST['week_51'] : "",
                    isset($_POST['week_51']) ? $_POST['week_51'] : "" => isset($_POST['price_51']) ? $_POST['price_51'] : ""
                ),
                array(
                    //"week_52" => isset($_POST['week_52']) ? $_POST['week_52'] : "",
                    isset($_POST['week_52']) ? $_POST['week_52'] : "" => isset($_POST['price_52']) ? $_POST['price_52'] : ""
                )
            );

            $aryMain = array_filter(array_map('array_filter', $week_price_arr));
            $featured_week_price = json_encode($aryMain);


            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            if ($this->form_validation->run()) {
                $redirect_url = $this->input->post('redirect_url');
                foreach ($_POST as $k => $v) {
                    if (in_array($k, array('redirect_url'))) {
                        unset($_POST[$k]);
                    }
                }
                $data_to_store = array(
                    'country_id' => isset($_POST['country']) ? $_POST['country'] : "",
                    'state_id' => isset($_POST['state']) ? $_POST['state'] : "",
                    'city_id' => isset($_POST['city']) ? $_POST['city'] : "",
                    'category_id' => isset($_POST['city_category']) ? $_POST['city_category'] : "",
                    'featured_week_price' => $featured_week_price,
                );
                if ($this->featured_price_model->update_featured_price($id, $data_to_store) == TRUE) {
                    $this->session->set_flashdata('flash_message', 'updated');
                } else {
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                $this->session->set_flashdata('flash_message', 'update');
                redirect($redirect_url);
            }
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data


        $data['featured_price'] = $this->featured_price_model->get_featured_price_by_id($id);
        $data['country_opt'] = $this->common_model->getDDArray('country', 'country_id', 'country_name');
        $data['state_opt'] = $this->common_model->getDDArray('state', 'state_id', 'state_name');
        $data['city_opt'] = $this->common_model->getDDArray('city', 'city_id', 'city_name');
        $data['par_cat_array'] = $this->category_model->getParentCategoryList(0, $old_cat = "", 0, 1, 5);
        $data['main_content'] = 'admin/featured_price/edit';
        $this->load->view('admin/includes/template', $data);
    }

//update

    /**
     * Delete product by his id
     * @return void
     */
    public function delete() {
        $id = $this->uri->segment(4);
        $this->featured_price_model->delete_featured_price($id);
        $this->session->set_flashdata('flash_message', 'delete');
        redirect('admin/featured_price');
    }

}
