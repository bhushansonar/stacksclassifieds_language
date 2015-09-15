<?php

class Admin_posts extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'admin/posts';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->load->model('posts_model');
        $this->load->model('common_model');
        $this->load->model('home_model');
        $this->load->library('Common');
        $this->load->library('image_lib');
        $this->load->library('Upload');
        $this->load->library('upload');
        $this->load->library('Functions');
        $this->load->helper('text');
        if (!$this->session->userdata('is_logged_in_admin')) {
            redirect('admin/login');
        }
        if (!Access_level::get_access('posts')) {
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
        $config['per_page'] = 25;

        $config['base_url'] = base_url() . 'admin/posts';
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
            $data['count_products'] = $this->posts_model->count_posts($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['posts'] = $this->posts_model->get_posts($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['posts'] = $this->posts_model->get_posts($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['posts'] = $this->posts_model->get_posts('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['posts'] = $this->posts_model->get_posts('', '', $order_type, $config['per_page'], $limit_end);
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
            $data['count_products'] = $this->posts_model->count_posts();
            $data['posts'] = $this->posts_model->get_posts('', '', $order_type, $config['per_page'], $limit_end);
//            echo "<pre>";
//            print_r($data['posts']);
//            exit;
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'admin/posts/list';
        $this->load->view('admin/includes/template', $data);
    }

    function check_default($post_string) {
        if ($post_string >= '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function age_check($age) {
        if ($age <= '17') {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function add() {

        $data['state_opt'] = array("" => "Select");
        $data['city_opt'] = array("" => "Select");
        $data['subcategory_opt'] = array("" => "Select");
        $data['city'] = "";
        $data['state'] = "";
        $data['country'] = "";
        $data['subcategory'] = "";
        $data['category'] = "";

        $where = " AND parent_id= '0' ";
        $data['main_category_opt'] = $this->common_model->getDDArray('category', 'category_id', 'category_name_en', $where);

        $data['country_opt'] = $this->common_model->getDDArray('country', 'country_id', 'country_name');
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $parent_id = $_POST['category'];
            //form validation
            $this->form_validation->set_rules('country', 'country', 'required');
            $this->form_validation->set_rules('category', 'Main Category', 'required');
            $this->form_validation->set_rules('title', 'title', 'required|max_length[150]');
            $this->form_validation->set_rules('description', 'description', 'required');
            //$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required|numeric|exact_length[10]');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|matches[confirm_email]');
            $this->form_validation->set_rules('confirm_email', 'Email Address Confirmation', 'required');
            $this->form_validation->set_rules('location', 'location', 'required');
            if ($parent_id == 4 || $parent_id == 11) {
                $this->form_validation->set_rules('age', 'age', 'required');
                $this->age_check($_POST['age']);
                $this->form_validation->set_rules('age', '', 'callback_age_check');
                $this->form_validation->set_message('age_check', 'Sorry, the ad poster must be over 18 years of age.');
            }

            if (isset($_POST['featured_ad'])) {
                if (isset($_POST['featured_ad_week_price'])) {
                    $this->form_validation->set_rules('featured_ad_week_price', 'Featured Ad Week Price', 'required');
                    $this->check_default($_POST['featured_ad_week_price']);
                    $this->form_validation->set_rules('featured_ad_week_price', '', 'callback_check_default');
                    $this->form_validation->set_message('check_default', 'Please add upgrades to have a minimum purchase of 0.99');
                }
            }
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run()) {

                $path = './upload/post_ads';
                $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "*"
                ));

                $data = $this->functions->do_upload_video('video');
                if (isset($data['upload_data'])) {
                    $video = $data['upload_data']['file_name'];
                } else {
                    $video = "";
                }

                if (!empty($_FILES['image1']['name'])) {
                    $data = $this->functions->do_upload('image1', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }

                    if (isset($data['upload_data'])) {
                        $file_name1 = $data['upload_data']['file_name'];
                    } else {
                        $file_name1 = "";
                    }
                    $_POST['image1'] = $file_name1;
                }
                if (!empty($_FILES['image2']['name'])) {
                    $data = $this->functions->do_upload('image2', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }

                    if (isset($data['upload_data'])) {
                        $file_name2 = $data['upload_data']['file_name'];
                    } else {
                        $file_name2 = "";
                    }
                    $_POST['image2'] = $file_name2;
                }
                if (!empty($_FILES['image3']['name'])) {
                    $data = $this->functions->do_upload('image3', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name3 = $data['upload_data']['file_name'];
                    } else {
                        $file_name3 = "";
                    }
                    $_POST['image3'] = $file_name3;
                }
                if (!empty($_FILES['image4']['name'])) {
                    $data = $this->functions->do_upload('image4', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name4 = $data['upload_data']['file_name'];
                    } else {
                        $file_name4 = "";
                    }
                    $_POST['image4'] = $file_name4;
                }
                if (!empty($_FILES['image5']['name'])) {
                    $data = $this->functions->do_upload('image5', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name5 = $data['upload_data']['file_name'];
                    } else {
                        $file_name5 = "";
                    }
                    $_POST['image5'] = $file_name5;
                }
                if (!empty($_FILES['image6']['name'])) {
                    $data = $this->functions->do_upload('image6', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name6 = $data['upload_data']['file_name'];
                    } else {
                        $file_name6 = "";
                    }
                    $_POST['image6'] = $file_name6;
                }
                if (!empty($_FILES['image7']['name'])) {
                    $data = $this->functions->do_upload('image7', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name7 = $data['upload_data']['file_name'];
                    } else {
                        $file_name7 = "";
                    }
                    $_POST['image7'] = $file_name7;
                }
                if (!empty($_FILES['image8']['name'])) {
                    $data = $this->functions->do_upload('image8', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name8 = $data['upload_data']['file_name'];
                    } else {
                        $file_name8 = "";
                    }
                    $_POST['image8'] = $file_name8;
                }
                if (!empty($_FILES['image9']['name'])) {
                    $data = $this->functions->do_upload('image9', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name9 = $data['upload_data']['file_name'];
                    } else {
                        $file_name9 = "";
                    }
                    $_POST['image9'] = $file_name9;
                }
                if (!empty($_FILES['image10']['name'])) {
                    $data = $this->functions->do_upload('image10', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name10 = $data['upload_data']['file_name'];
                    } else {
                        $file_name10 = "";
                    }
                    $_POST['image10'] = $file_name10;
                }
                if (!empty($_FILES['image11']['name'])) {
                    $data = $this->functions->do_upload('image11', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name11 = $data['upload_data']['file_name'];
                    } else {
                        $file_name11 = "";
                    }
                    $_POST['image11'] = $file_name11;
                }
                if (!empty($_FILES['image12']['name'])) {
                    $data = $this->functions->do_upload('image12', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name12 = $data['upload_data']['file_name'];
                    } else {
                        $file_name12 = "";
                    }
                    $_POST['image12'] = $file_name12;
                }
                if (isset($_POST['work_status'])) {
                    $work_status = implode(",", $_POST['work_status']);
                } else {
                    $work_status = "";
                }
                if (isset($_POST['shift'])) {
                    $shift = implode(",", $_POST['shift']);
                } else {
                    $shift = "";
                }
                $date = date('Y-m-d H:i:s');
                $currentDate = strtotime($date);
                $futureDate = $currentDate;
                //after 5 minute store in database
                //$futureDate = $currentDate + (60 * 5);
                //end 5 minute code
                $formatDate = date("Y-m-d H:i:s", $futureDate);
                $today_date = new DateTime(date('Y-m-d'));
//                $exp_data = date_add($today_date, new DateInterval('P36D'));
                $res = date('Y-m-d', strtotime('1 week', strtotime($date)));
                $disallowed = array('sex', 'greek', 'suck', 'fuck', 'anal');
                if (!empty($_POST['title'])) {
                    $title = word_censor($_POST['title'], $disallowed);
                    $tit = base64_encode(serialize($title));
                } else {
                    $tit = "";
                }
                if (!empty($_POST['location'])) {
                    $location = word_censor($_POST['location'], $disallowed);
                } else {
                    $location = "";
                }
                if (!empty($_POST['description'])) {
                    $description = word_censor($_POST['description'], $disallowed);
                    $descr = base64_encode(serialize($description));
                } else {
                    $descr = "";
                }
                if (!empty($_POST['address'])) {
                    $address = word_censor($_POST['address'], $disallowed);
                } else {
                    $address = "";
                }
                if (isset($_POST['auto_repost_price'])) {
                    $auto_repost_price = $_POST['auto_repost_price'];
                } else {
                    $auto_repost_price = 0;
                }
                if (isset($_POST['featured_ad_week_price'])) {
                    $featured_ad_week_price = $_POST['featured_ad_week_price'];
                } else {
                    $featured_ad_week_price = 0;
                }
                $max_value = $this->home_model->get_maximum_value();
                $update_max_val = $max_value + 1;
                $total = $auto_repost_price + $featured_ad_week_price;
                $user_id = $this->session->userdata('user_id');
                $adsType = 'paid';
                $payment_status = 'complete';
                $data_to_store = array(
                    'uid' => $user_id,
                    'ads_type' => $adsType,
                    'category' => isset($_POST['category']) ? $_POST['category'] : "",
                    'subcategory' => isset($_POST['subcategory']) ? $_POST['subcategory'] : "",
                    'country' => isset($_POST['country']) ? $_POST['country'] : "",
                    'state' => isset($_POST['state']) ? $_POST['state'] : "",
                    'city' => isset($_POST['city']) ? $_POST['city'] : "",
                    'title' => isset($tit) ? $tit : "",
                    'location' => isset($location) ? $location : "",
                    'description' => isset($descr) ? $descr : "",
                    'address' => isset($address) ? $address : "",
                    'salary' => isset($_POST['salary']) ? $_POST['salary'] : "",
                    'education' => isset($_POST['education']) ? $_POST['education'] : "",
                    'work_status' => $work_status,
                    'shift' => $shift,
                    'postcode' => isset($_POST['postcode']) ? $_POST['postcode'] : "",
                    'email' => isset($_POST['email']) ? $_POST['email'] : "",
                    //'contact_number' => isset($_POST['contact_number']) ? $_POST['contact_number'] : "",
                    'inquery' => isset($_POST['inquery']) ? $_POST['inquery'] : "",
                    'show_ad_links' => isset($_POST['show_ad_links']) ? $_POST['show_ad_links'] : "",
                    'show_joined_date' => isset($_POST['show_joined_date']) ? $_POST['show_joined_date'] : "",
                    'postcode' => isset($_POST['postcode']) ? $_POST['postcode'] : "",
                    'auto_repost_ad' => isset($_POST['auto_repost_ad']) ? $_POST['auto_repost_ad'] : "",
                    'auto_repost_day' => isset($_POST['auto_repost_day']) ? $_POST['auto_repost_day'] : "",
                    'auto_repost_time' => isset($_POST['auto_repost_time']) ? $_POST['auto_repost_time'] : "",
                    'auto_repost_no_of_time' => isset($_POST['auto_repost_no_of_time']) ? $_POST['auto_repost_no_of_time'] : "",
                    'auto_repost_price' => isset($_POST['auto_repost_price']) ? $_POST['auto_repost_price'] : "",
                    'featured_ad' => isset($_POST['featured_ad']) ? $_POST['featured_ad'] : "",
                    'featured_ad_week_price' => isset($_POST['featured_ad_week_price']) ? $_POST['featured_ad_week_price'] : "",
                    'featured_ad_week' => isset($_POST['featured_ad_week']) ? $_POST['featured_ad_week'] : "",
                    'total' => isset($total) ? $total : "",
                    'pets' => isset($_POST['pets']) ? $_POST['pets'] : "",
                    'fees_paid_by' => isset($_POST['fees_paid_by']) ? $_POST['fees_paid_by'] : "",
                    'ad_placed_by' => isset($_POST['ad_placed_by']) ? $_POST['ad_placed_by'] : "",
                    'age' => isset($_POST['age']) ? $_POST['age'] : "",
                    'selling_price' => isset($_POST['selling_price']) ? $_POST['selling_price'] : "",
                    'bedrooms' => isset($_POST['bedrooms']) ? $_POST['bedrooms'] : "",
                    'price' => isset($_POST['price']) ? $_POST['price'] : "",
                    'date' => $formatDate,
                    'expire_date' => $res,
                    'payment_status' => $payment_status,
                    'status' => 'Active',
                    'video' => $video,
                    'image1' => isset($_POST['image1']) ? $_POST['image1'] : "",
                    'image2' => isset($_POST['image2']) ? $_POST['image2'] : "",
                    'image3' => isset($_POST['image3']) ? $_POST['image3'] : "",
                    'image4' => isset($_POST['image4']) ? $_POST['image4'] : "",
                    'image5' => isset($_POST['image5']) ? $_POST['image5'] : "",
                    'image6' => isset($_POST['image6']) ? $_POST['image6'] : "",
                    'image7' => isset($_POST['image7']) ? $_POST['image7'] : "",
                    'image8' => isset($_POST['image8']) ? $_POST['image8'] : "",
                    'image9' => isset($_POST['image9']) ? $_POST['image9'] : "",
                    'image10' => isset($_POST['image10']) ? $_POST['image10'] : "",
                    'image11' => isset($_POST['image11']) ? $_POST['image11'] : "",
                    'image12' => isset($_POST['image12']) ? $_POST['image12'] : "",
                    'post_ads_type' => "single",
                    'move_to_ad' => $update_max_val,
                );

                if ($this->posts_model->addPosts($data_to_store)) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect('admin/posts/');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        $data['main_content'] = 'admin/posts/add';
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
            $parent_id = $_POST['category'];

            $this->form_validation->set_rules('country', 'country', 'required');
            $this->form_validation->set_rules('category', 'Main Category', 'required');
            $this->form_validation->set_rules('location', 'location', 'required');
            $this->form_validation->set_rules('title', 'title', 'required|max_length[150]');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|matches[confirm_email]');
            $this->form_validation->set_rules('confirm_email', 'Email Address Confirmation', 'required');
            // $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required|numeric|exact_length[10]');

            if ($parent_id == 4 || $parent_id == 11) {
                $this->form_validation->set_rules('age', 'age', 'required');
                $this->age_check($_POST['age']);
                $this->form_validation->set_rules('age', '', 'callback_age_check');
                $this->form_validation->set_message('age_check', 'Sorry, the ad poster must be over 18 years of age.');
            }
            if (isset($_POST['featured_ad'])) {
                if (isset($_POST['featured_ad_week_price'])) {
                    $this->form_validation->set_rules('featured_ad_week_price', 'Featured Ad Week Price', 'required');
                    $this->check_default($_POST['featured_ad_week_price']);
                    $this->form_validation->set_rules('featured_ad_week_price', '', 'callback_check_default');
                    $this->form_validation->set_message('check_default', 'Please add upgrades to have a minimum purchase of 0.99');
                }
            }



            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

            if ($this->form_validation->run()) {
                $path = './upload/post_ads';
                $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "*"
                ));
                $old_image1 = $this->input->post('old_image1');
                $old_image2 = $this->input->post('old_image2');
                $old_image3 = $this->input->post('old_image3');
                $old_image4 = $this->input->post('old_image4');
                $old_image5 = $this->input->post('old_image5');
                $old_image6 = $this->input->post('old_image6');
                $old_image7 = $this->input->post('old_image7');
                $old_image8 = $this->input->post('old_image8');
                $old_image9 = $this->input->post('old_image9');
                $old_image10 = $this->input->post('old_image10');
                $old_image11 = $this->input->post('old_image11');
                $old_image12 = $this->input->post('old_image12');

                if ($_FILES['image1']['error'] != '4') {
                    $data = $this->functions->do_upload('image1', './uploads/post_ads');

                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

                    // do it!
                    if (!$this->image_lib->resize()) {
                        // if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        //echo "hi";exit;
                        // otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {

                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image1'] = $file_name;
                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image1'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image1'));
                    } else {
                        $file_name = $this->input->post('old_image1');
                        $_POST['image1'] = $file_name;
                    }
                } else {
                    if (isset($old_image1)) {
                        $_POST['image1'] = $old_image1;
                    }
                }


                if ($_FILES['image2']['error'] != '4') {
                    $data = $this->functions->do_upload('image2', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

                    // do it!
                    if (!$this->image_lib->resize()) {
                        // if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        //echo "hi";exit;
                        // otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image2'] = $file_name;
                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image2'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image2'));
                    } else {
                        $file_name = $this->input->post('old_image2');
                        $_POST['image2'] = $file_name;
                    }
                } else {
                    if (isset($old_image2)) {
                        $_POST['image2'] = $old_image2;
                    }
                }
                if ($_FILES['image3']['error'] != '4') {
                    $data = $this->functions->do_upload('image3', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

                    // do it!
                    if (!$this->image_lib->resize()) {
                        // if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        //echo "hi";exit;
                        // otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image3'] = $file_name;

                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image3'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image3'));
                    } else {
                        $file_name = $this->input->post('old_image3');
                        $_POST['image3'] = $file_name;
                    }
                } else {
                    if (isset($old_image3)) {
                        $_POST['image3'] = $old_image3;
                    }
                }

                if ($_FILES['image4']['error'] != '4') {
                    $data = $this->functions->do_upload('image4', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

                    // do it!
                    if (!$this->image_lib->resize()) {
                        // if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        //echo "hi";exit;
                        // otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image4'] = $file_name;
                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image4'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image4'));
                    } else {
                        $file_name = $this->input->post('old_image4');
                        $_POST['image4'] = $file_name;
                    }
                } else {
                    if (isset($old_image4)) {
                        $_POST['image4'] = $old_image4;
                    }
                }

                if ($_FILES['image5']['error'] != '4') {
                    $data = $this->functions->do_upload('image5', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

// do it!
                    if (!$this->image_lib->resize()) {
// if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
//echo "hi";exit;
// otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image5'] = $file_name;
                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image5'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image5'));
                    } else {
                        $file_name = $this->input->post('old_image5');
                        $_POST['image5'] = $file_name;
                    }
                } else {
                    if (isset($old_image5)) {
                        $_POST['image5'] = $old_image5;
                    }
                }

                if ($_FILES['image6']['error'] != '4') {
                    $data = $this->functions->do_upload('image6', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

// do it!
                    if (!$this->image_lib->resize()) {
// if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
//echo "hi";exit;
// otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image6'] = $file_name;

                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image6'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image6'));
                    } else {
                        $file_name = $this->input->post('old_image6');
                        $_POST['image6'] = $file_name;
                    }
                } else {
                    if (isset($old_image6)) {
                        $_POST['image6'] = $old_image6;
                    }
                }
                if ($_FILES['image7']['error'] != '4') {
                    $data = $this->functions->do_upload('image7', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

// do it!
                    if (!$this->image_lib->resize()) {
// if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
//echo "hi";exit;
// otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image7'] = $file_name;
                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image7'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image7'));
                    } else {
                        $file_name = $this->input->post('old_image7');
                        $_POST['image7'] = $file_name;
                    }
                } else {
                    if (isset($old_image7)) {
                        $_POST['image7'] = $old_image7;
                    }
                }
                if ($_FILES['image8']['error'] != '4') {
                    $data = $this->functions->do_upload('image8', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

// do it!
                    if (!$this->image_lib->resize()) {
// if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
//echo "hi";exit;
// otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image8'] = $file_name;
                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image8'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image8'));
                    } else {
                        $file_name = $this->input->post('old_image8');
                        $_POST['image8'] = $file_name;
                    }
                } else {
                    if (isset($old_image8)) {
                        $_POST['image8'] = $old_image8;
                    }
                }
                if ($_FILES['image9']['error'] != '4') {
                    $data = $this->functions->do_upload('image9', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

// do it!
                    if (!$this->image_lib->resize()) {
// if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
//echo "hi";exit;
// otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image9'] = $file_name;
                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image9'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image9'));
                    } else {
                        $file_name = $this->input->post('old_image9');
                        $_POST['image9'] = $file_name;
                    }
                } else {
                    if (isset($old_image9)) {
                        $_POST['image9'] = $old_image9;
                    }
                }
                if ($_FILES['image10']['error'] != '4') {
                    $data = $this->functions->do_upload('image10', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

// do it!
                    if (!$this->image_lib->resize()) {
// if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
//echo "hi";exit;
// otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image10'] = $file_name;
                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image10'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image10'));
                    } else {
                        $file_name = $this->input->post('old_image10');
                        $_POST['image10'] = $file_name;
                    }
                } else {
                    if (isset($old_image10)) {
                        $_POST['image10'] = $old_image10;
                    }
                }
                if ($_FILES['image11']['error'] != '4') {
                    $data = $this->functions->do_upload('image11', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

// do it!
                    if (!$this->image_lib->resize()) {
// if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
//echo "hi";exit;
// otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image11'] = $file_name;

                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image11'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image11'));
                    } else {
                        $file_name = $this->input->post('old_image11');
                        $_POST['image11'] = $file_name;
                    }
                } else {
                    if (isset($old_image11)) {
                        $_POST['image11'] = $old_image11;
                    }
                }
                if ($_FILES['image12']['error'] != '4') {
                    $data = $this->functions->do_upload('image12', './uploads/post_ads');
                    $resize_conf = array(
                        'source_image' => $data['upload_data']['full_path'],
                        'new_image' => $data['upload_data']['file_path'] . 'thumb/' . $data['upload_data']['file_name'],
                        'width' => 300,
                        'height' => 200
                    );
                    $this->image_lib->initialize($resize_conf);

// do it!
                    if (!$this->image_lib->resize()) {
// if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
//echo "hi";exit;
// otherwise, put each upload data to an array.
                        $success[] = $data['upload_data'];
                    }
                    if (isset($data['upload_data'])) {
                        $file_name = $data['upload_data']['file_name'];
                        $_POST['image12'] = $file_name;

                        @unlink("./uploads/post_ads/thumb" . $this->input->post('old_image12'));
                        @unlink("./uploads/post_ads/" . $this->input->post('old_image12'));
                    } else {
                        $file_name = $this->input->post('old_image12');
                        $_POST['image12'] = $file_name;
                    }
                } else {
                    if (isset($old_image12)) {
                        $_POST['image12'] = $old_image12;
                    }
                }

                //if the insert has returned true then we show the flash message
                $redirect_url = $this->input->post('redirect_url');
                foreach ($_POST as $k => $v) {
                    if (in_array($k, array('redirect_url'))) {
                        unset($_POST[$k]);
                    }
                }
                if (!empty($_POST['work_status'])) {
                    $work_status = implode(",", $_POST['work_status']);
                    $shift = implode(",", $_POST['shift']);
                    $_POST['work_status'] = $work_status;
                    $_POST['shift'] = $shift;
                }
                if ($this->session->userdata('user_id')) {
                    $user_id = $this->session->userdata('user_id');
                } else {
                    $user_id = "0";
                }


                $disallowed = array('sex', 'greek', 'suck', 'fuck', 'anal');
                if (!empty($_POST['title'])) {
                    $title = word_censor($_POST['title'], $disallowed);
                    $tit = base64_encode(serialize($title));
                } else {
                    $tit = "";
                }
                if (!empty($_POST['location'])) {
                    $location = word_censor($_POST['location'], $disallowed);
                } else {
                    $location = "";
                }
                if (!empty($_POST['description'])) {
                    $description = word_censor($_POST['description'], $disallowed);
                    $descr = base64_encode(serialize($description));
                } else {
                    $descr = "";
                }
                if (!empty($_POST['address'])) {
                    $address = word_censor($_POST['address'], $disallowed);
                } else {
                    $address = "";
                }

                if (isset($_POST['featured_ad']) || isset($_POST['auto_repost_ad'])) {
                    if (isset($_POST['auto_repost_price'])) {
                        $auto_repost_price = $_POST['auto_repost_price'];
                    } else {
                        $auto_repost_price = 0;
                    }
                    if (isset($_POST['featured_ad_week_price'])) {
                        $featured_ad_week_price = $_POST['featured_ad_week_price'];
                    } else {
                        $featured_ad_week_price = 0;
                    }

                    $total = $auto_repost_price + $featured_ad_week_price;
                }
                $date = date('Y-m-d H:i:s');
                $currentDate = strtotime($date);
                //after 5 minute store in database
                //$futureDate = $currentDate + (60 * 5);
                //end 5 minute code
                $futureDate = $currentDate;
                $formatDate = date("Y-m-d H:i:s", $futureDate);
                $today_date = new DateTime(date('Y-m-d'));
//                $exp_data = date_add($today_date, new DateInterval('P36D'));
                $res = date('Y-m-d', strtotime('1 week', strtotime($date)));

                $max_value = $this->home_model->get_maximum_value();
                $update_max_val = $max_value + 1;

                $adsType = 'paid';
                $payment_status = 'complete';
                $data_to_store = array(
                    'uid' => $user_id,
                    'ads_type' => $adsType,
                    'category' => isset($_POST['category']) ? $_POST['category'] : "",
                    'subcategory' => isset($_POST['subcategory']) ? $_POST['subcategory'] : "",
                    'country' => isset($_POST['country']) ? $_POST['country'] : "",
                    'state' => isset($_POST['state']) ? $_POST['state'] : "",
                    'city' => isset($_POST['city']) ? $_POST['city'] : "",
                    'title' => isset($tit) ? $tit : "",
                    'location' => isset($location) ? $location : "",
                    'description' => isset($descr) ? $descr : "",
                    'address' => isset($address) ? $address : "",
                    'salary' => isset($_POST['salary']) ? $_POST['salary'] : "",
                    'education' => isset($_POST['education']) ? $_POST['education'] : "",
                    'work_status' => isset($_POST['work_status']) ? $_POST['work_status'] : "",
                    'shift' => isset($_POST['shift']) ? $_POST['shift'] : "",
                    'postcode' => isset($_POST['postcode']) ? $_POST['postcode'] : "",
                    'email' => isset($_POST['email']) ? $_POST['email'] : "",
                    //'contact_number' => isset($_POST['contact_number']) ? $_POST['contact_number'] : "",
                    'inquery' => isset($_POST['inquery']) ? $_POST['inquery'] : "",
                    'show_ad_links' => isset($_POST['show_ad_links']) ? $_POST['show_ad_links'] : "",
                    'show_joined_date' => isset($_POST['show_joined_date']) ? $_POST['show_joined_date'] : "",
                    'auto_repost_ad' => isset($_POST['auto_repost_ad']) ? $_POST['auto_repost_ad'] : "",
                    'postcode' => isset($_POST['postcode']) ? $_POST['postcode'] : "",
                    'auto_repost_ad' => isset($_POST['auto_repost_ad']) ? $_POST['auto_repost_ad'] : "",
                    'auto_repost_day' => isset($_POST['auto_repost_day']) ? $_POST['auto_repost_day'] : "",
                    'auto_repost_time' => isset($_POST['auto_repost_time']) ? $_POST['auto_repost_time'] : "",
                    'auto_repost_no_of_time' => isset($_POST['auto_repost_no_of_time']) ? $_POST['auto_repost_no_of_time'] : "",
                    'auto_repost_price' => isset($_POST['auto_repost_price']) ? $_POST['auto_repost_price'] : "",
                    'featured_ad' => isset($_POST['featured_ad']) ? $_POST['featured_ad'] : "",
                    'featured_ad_week_price' => isset($_POST['featured_ad_week_price']) ? $_POST['featured_ad_week_price'] : "",
                    'featured_ad_week' => isset($_POST['featured_ad_week']) ? $_POST['featured_ad_week'] : "",
                    'total' => isset($total) ? $total : "",
                    'video' => isset($_POST['video']) ? $_POST['video'] : "",
                    'image1' => isset($_POST['image1']) ? $_POST['image1'] : "",
                    'image2' => isset($_POST['image2']) ? $_POST['image2'] : "",
                    'image3' => isset($_POST['image3']) ? $_POST['image3'] : "",
                    'image4' => isset($_POST['image4']) ? $_POST['image4'] : "",
                    'image5' => isset($_POST['image5']) ? $_POST['image5'] : "",
                    'image6' => isset($_POST['image6']) ? $_POST['image6'] : "",
                    'image7' => isset($_POST['image7']) ? $_POST['image7'] : "",
                    'image8' => isset($_POST['image8']) ? $_POST['image8'] : "",
                    'image9' => isset($_POST['image9']) ? $_POST['image9'] : "",
                    'image10' => isset($_POST['image10']) ? $_POST['image10'] : "",
                    'image11' => isset($_POST['image11']) ? $_POST['image11'] : "",
                    'image12' => isset($_POST['image12']) ? $_POST['image12'] : "",
                    'promotions_sponsor_ad' => isset($_POST['promotions_sponsor_ad']) ? $_POST['promotions_sponsor_ad'] : "",
                    'pets' => isset($_POST['pets']) ? $_POST['pets'] : "",
                    'fees_paid_by' => isset($_POST['fees_paid_by']) ? $_POST['fees_paid_by'] : "",
                    'ad_placed_by' => isset($_POST['ad_placed_by']) ? $_POST['ad_placed_by'] : "",
                    'age' => isset($_POST['age']) ? $_POST['age'] : "",
                    'selling_price' => isset($_POST['selling_price']) ? $_POST['selling_price'] : "",
                    'bedrooms' => isset($_POST['bedrooms']) ? $_POST['bedrooms'] : "",
                    'price' => isset($_POST['price']) ? $_POST['price'] : "",
                    'post_ads_type' => "single",
                    'date' => $formatDate,
                    'expire_date' => $res,
                    'payment_status' => $payment_status,
                    'status' => 'Active',
                    'move_to_ad' => $update_max_val,
                );
                if ($this->posts_model->update_posts($id, $data_to_store) == TRUE) {
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
        $data['main_category_opt'] = $this->common_model->getDDArray('category', 'category_id', 'category_name_en', $where);
        $data['country_opt'] = $this->common_model->getDDArray('country', 'country_id', 'country_name');
        $data['posts'] = $this->posts_model->get_posts_by_id($id);

        if ($data['posts'][0]['country'] != "") {
            $data['state_opt'] = $this->common_model->getDDArray('state', 'state_id', 'state_name', " AND country_id='{$data['posts'][0]['country']}'");
        }
        if ($data['posts'][0]['state'] != "") {
            //echo "hiiii"; die;
            $data['city_opt'] = $this->common_model->getDDArray('city', 'city_id', 'city_name', " AND state_id='{$data['posts'][0]['state']}'");
        }
        if ($data['posts'][0]['category'] != "") {

            $where_subcategory = " AND parent_id!= '0' AND parent_id='{$data['posts'][0]['category']}'";
            $data['subcategory_opt'] = $this->common_model->getDDArray('category', 'category_id', 'category_name_en', $where_subcategory);
        }
        $data['main_content'] = 'admin/posts/edit';
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
        $this->posts_model->delete_posts($id);
        $this->session->set_flashdata('flash_message', 'delete');
        redirect('admin/posts/');
    }

    public function delete_image() {

        $id = $this->uri->segment(4);
        $img = $this->uri->segment(5);
        $posts_data = $this->posts_model->get_posts_by_id($id);
        if ($img == "1") {
            $key = "image1";
            $image_name = $posts_data[0]['image1'];
        } elseif ($img == "2") {
            $key = "image2";
            $image_name = $posts_data[0]['image2'];
        } else if ($img == "3") {
            $key = "image3";
            $image_name = $posts_data[0]['image3'];
        } else if ($img == "4") {
            $key = "image4";
            $image_name = $posts_data[0]['image4'];
        } else if ($img == "5") {
            $key = "image5";
            $image_name = $posts_data[0]['image5'];
        } else if ($img == "6") {
            $key = "image6";
            $image_name = $posts_data[0]['image6'];
        } else if ($img == "7") {
            $key = "image7";
            $image_name = $posts_data[0]['image7'];
        } else if ($img == "8") {
            $key = "image8";
            $image_name = $posts_data[0]['image8'];
        } else if ($img == "9") {
            $key = "image9";
            $image_name = $posts_data[0]['image9'];
        } else if ($img == "10") {
            $key = "image10";
            $image_name = $posts_data[0]['image10'];
        } else if ($img == "11") {
            $key = "image11";
            $image_name = $posts_data[0]['image11'];
        } else if ($img == "12") {
            $key = "image12";
            $image_name = $posts_data[0]['image12'];
        }

        $checkImage = array();
        $checkImage = $this->posts_model->get_posts_by_field($key, $image_name);

        if ($this->posts_model->update_posts($id, array($key => "")) == TRUE) {
            $this->session->set_flashdata('flash_message', 'delete_image');
            if (count($checkImage) <= 1) {
                @unlink("./uploads/post_ads/" . $image_name);
            }
        }
        redirect('admin/posts/update/' . $id);
    }

//edit
}

