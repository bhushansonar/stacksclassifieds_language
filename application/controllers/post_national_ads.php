<?php

class post_national_ads extends CI_Controller {

    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */
    //const VIEW_FOLDER = 'admin/posts';
    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('post_national_ads_model');
        $this->load->model('common_model');
        $this->load->model('home_model');
        $this->load->model('multiple_city_model');
        $this->load->model('write_add_model');
        $this->load->library('recaptcha');
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->helper('email');
        $this->load->library('email');
        $this->load->library('image_lib');
        $this->load->library('upload');
        $this->load->library('Functions');
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

    }

    function check_captcha() {
        if (!$this->recaptcha->getIsValid()) {
            return FALSE;
        } else {
            return TRUE;
        }
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

        $data['category'] = $this->session->userdata('category');
        $data['total'] = $this->session->userdata('total');
        $category_id = $this->session->userdata('category');
        $data['parent_id'] = $category_id;
        $data['sub_category'] = $this->session->userdata('sub_category');
        $multiple_city_id = $this->session->userdata('multiple_city_id');
        $city_data = $this->multiple_city_model->get_multiple_city_value('multiple_city_id', $multiple_city_id);
        $data['country'] = @$city_data[0]['country'];
        $data['state'] = @$city_data[0]['state'];
        $data['city'] = @$city_data[0]['city'];
        $where_subcategory = " AND category_id={$data['sub_category']}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $where_subcategory1 = " AND category_id={$data['category']}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory1);
        $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $session = array(
                'total' => $_POST['total']
            );
            $this->session->set_userdata($session);

            $net_total = 0;
            if (isset($_POST['auto_repost_price'])) {
                $auto_repost_price = $_POST['auto_repost_price'];
            } else {
                $auto_repost_price = 0;
            }
            $tot = $_POST['total'] + $auto_repost_price;

            if (!empty($_POST['promocode'])) {
                $promocode_name = $_POST['promocode'];
                $status = "Active";
                $promocode = $this->write_add_model->get_promocode($promocode_name, $status);
                $promocode_value = !empty($promocode[0]['code']) ? $promocode[0]['code'] : "";
                $promocode_type = !empty($promocode[0]['promotype']) ? $promocode[0]['promotype'] : "";
                if ($promocode_type == 'amount') {
                    $net_total = $tot - $promocode_value;
                } else if ($promocode_type == 'percentage') {
                    $percent_total = $tot * $promocode_value;
                    $percent_value = $percent_total / 100;
                    $net_total = $tot - $percent_value;
                }
            } else {
                $net_total = $tot;
            }
            $parent_id = $_POST['parent_id'];
            $this->recaptcha->recaptcha_check_answer();
            $this->form_validation->set_rules('title', 'title', 'required|max_length[150]');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|matches[confirm_email]');
            $this->form_validation->set_rules('confirm_email', 'Email Address Confirmation', 'required');

            $this->form_validation->set_rules('recaptcha_response_field', 'Recaptcha', 'required|callback_check_captcha');
            $this->form_validation->set_message('check_captcha', 'Wrong Recaptcha');

            $where_check_adult = " AND category_id={$parent_id}";
            $check_adult = $this->common_model->getFieldData("category", "is_adult", $where_check_adult);
            if ($check_adult == "YES") {
                $this->form_validation->set_rules('age', 'age', 'required');
                $this->age_check($_POST['age']);
                $this->form_validation->set_rules('age', '', 'callback_age_check');
                $this->form_validation->set_message('age_check', 'Sorry, the ad poster must be over 18 years of age.');
            } else {
                $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required|numeric|exact_length[10]');
            }
            //if ($parent_id == 2 || $parent_id == 5 || $parent_id == 10 || $parent_id == 8 || $parent_id == 9 || $parent_id == 1) {
            $this->form_validation->set_rules('location', 'location', 'required');
            //}
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run() && $this->recaptcha->getIsValid()) {

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
                        $file_name12 = $data['upload_data']['file_name'];
                    } else {
                        $file_name12 = "";
                    }
                    $_POST['image12'] = $file_name12;
                }

                if ($parent_id == 5) {
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
                $adsType = "paid";
                $data_to_store = array(
                    'uid' => $user_id,
                    'ads_type' => $adsType,
                    'category' => isset($_POST['category_id']) ? $_POST['category_id'] : "",
                    'subcategory' => isset($_POST['sub_category_id']) ? $_POST['sub_category_id'] : "",
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
                    'contact_number' => isset($_POST['contact_number']) ? $_POST['contact_number'] : "",
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
//                    'sponsor_ad' => isset($_POST['sponsor_ad']) ? $_POST['sponsor_ad'] : "",
//                    'week' => isset($_POST['week']) ? $_POST['week'] : "",
                    'promotions_sponsor_ad' => isset($_POST['promotions_sponsor_ad']) ? $_POST['promotions_sponsor_ad'] : "",
                    'pets' => isset($_POST['pets']) ? $_POST['pets'] : "",
                    'fees_paid_by' => isset($_POST['fees_paid_by']) ? $_POST['fees_paid_by'] : "",
                    'ad_placed_by' => isset($_POST['ad_placed_by']) ? $_POST['ad_placed_by'] : "",
                    'age' => isset($_POST['age']) ? $_POST['age'] : "",
                    'selling_price' => isset($_POST['selling_price']) ? $_POST['selling_price'] : "",
                    'bedrooms' => isset($_POST['bedrooms']) ? $_POST['bedrooms'] : "",
                    'price' => isset($_POST['price']) ? $_POST['price'] : "",
                    'total' => isset($net_total) ? $net_total : "",
                    'date' => date('Y-m-d H:i:s'),
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
                    'post_ads_type' => "multiple",
                    'status' => "Inactive"
                );
                $post_national_ads = $this->post_national_ads_model->store_post_national_ads($data_to_store);
                if ($post_national_ads) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect("post_national_ads/preview_ad/$post_national_ads");
                    //redirect("heading/getAlltitle/$category_id/$parent_id");
                } else {
                    if (!$this->recaptcha->getIsValid()) {
                        $this->session->set_flashdata('flash_message', 'Wrong captcha');
                        $this->session->set_flashdata('flash_class', 'alert-error');
                    } else {
                        $this->session->set_flashdata('flash_message', 'add Successfully');
                        $this->session->set_flashdata('flash_class', 'alert-error');
                    }
                    $data['flash_message'] = FALSE;
                }
                //}
            }
        }
//        $where_featured_ad_sub_cat = " AND category_id={$data['sub_category']} AND city_id={$data['city']}";
//        $city_featured_price_sub_cat = $this->common_model->getFieldData('featured_price', 'featured_week_price', $where_featured_ad_sub_cat);
//        if (!empty($city_featured_price_sub_cat)) {
//            $data['city_featured_price'] = $city_featured_price_sub_cat;
//        } else {
//            $where_featured_ad_cat = " AND category_id={$category_id} AND city_id={$data['city']}";
//            $city_featured_price_cat = $this->common_model->getFieldData('featured_price', 'featured_week_price', $where_featured_ad_cat);
//            $data['city_featured_price'] = $city_featured_price_cat;
//        }

        $data['main_content'] = 'post_national_ads_view';
        $this->load->view('includes/template', $data);
    }

    public function update() {
        $data['posts_id'] = $posts_id = $this->uri->segment(3);

        $data['category'] = $category_id = $this->session->userdata('category');
        $data['sub_category'] = $this->session->userdata('sub_category');
        $where_subcategory = " AND category_id={$data['sub_category']}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $where_subcategory1 = " AND category_id={$data['category']}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory1);

        $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            if (!empty($_POST['auto_repost_price'])) {
                $auto_repost_price = $_POST['auto_repost_price'];
            } else {
                $auto_repost_price = "0";
            }
            $tot = $_POST['total'] + $auto_repost_price;
            $parent_id = $_POST['parent_id'];
            $id = $_POST['posts_id'];
            $this->recaptcha->recaptcha_check_answer();
            $this->form_validation->set_rules('title', 'title', 'required|max_length[150]');
            $this->form_validation->set_rules('description', 'description', 'required');

            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|matches[confirm_email]');
            $this->form_validation->set_rules('confirm_email', 'Email Address Confirmation', 'required');

            $this->form_validation->set_rules('recaptcha_response_field', 'Recaptcha', 'required|callback_check_captcha');
            $this->form_validation->set_message('check_captcha', 'Wrong Recaptcha');
            $where_check_adult = " AND category_id={$parent_id}";
            $check_adult = $this->common_model->getFieldData("category", "is_adult", $where_check_adult);
            if ($check_adult == "YES") {
                $this->form_validation->set_rules('age', 'age', 'required');
            } else {
                $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required|numeric|exact_length[10]');
            }
            //if ($parent_id == 2 || $parent_id == 5 || $parent_id == 10 || $parent_id == 8 || $parent_id == 9 || $parent_id == 1) {
            $this->form_validation->set_rules('location', 'location', 'required');
            //}
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run() && $this->recaptcha->getIsValid()) {

                $path = './uploads/images';
                $this->load->library('upload');
                $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "*"
                ));

                $data = $this->functions->do_upload_video('video');
                if (isset($data['upload_data'])) {
                    $video_name = $data['upload_data']['file_name'];
                    $_POST['video'] = $video_name;
                    @unlink("./uploads/video" . $this->input->post('old_video'));
                } else {
                    $video_name = $this->input->post('old_vedio');
                    $_POST['video'] = $video_name;
                }

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
                        'width' => 200,
                        'height' => 100
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
                        'width' => 200,
                        'height' => 100
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
                if ($parent_id == 5) {
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
                $data_to_store = array(
                    'uid' => $user_id,
                    'category' => isset($_POST['category_id']) ? $_POST['category_id'] : "",
                    'subcategory' => isset($_POST['sub_category_id']) ? $_POST['sub_category_id'] : "",
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
                    'contact_number' => isset($_POST['contact_number']) ? $_POST['contact_number'] : "",
                    'inquery' => isset($_POST['inquery']) ? $_POST['inquery'] : "",
                    'show_ad_links' => isset($_POST['show_ad_links']) ? $_POST['show_ad_links'] : "",
                    'show_joined_date' => isset($_POST['show_joined_date']) ? $_POST['show_joined_date'] : "",
                    'postcode' => isset($_POST['postcode']) ? $_POST['postcode'] : "",
                    'auto_repost_ad' => isset($_POST['auto_repost_ad']) ? $_POST['auto_repost_ad'] : "",
                    'auto_repost_day' => isset($_POST['auto_repost_day']) ? $_POST['auto_repost_day'] : "",
                    'auto_repost_time' => isset($_POST['auto_repost_time']) ? $_POST['auto_repost_time'] : "",
                    'auto_repost_no_of_time' => isset($_POST['auto_repost_no_of_time']) ? $_POST['auto_repost_no_of_time'] : "",
                    'auto_repost_price' => isset($_POST['auto_repost_price']) ? $_POST['auto_repost_price'] : "",
                    'promotions_sponsor_ad' => isset($_POST['promotions_sponsor_ad']) ? $_POST['promotions_sponsor_ad'] : "",
                    'pets' => isset($_POST['pets']) ? $_POST['pets'] : "",
                    'fees_paid_by' => isset($_POST['fees_paid_by']) ? $_POST['fees_paid_by'] : "",
                    'ad_placed_by' => isset($_POST['ad_placed_by']) ? $_POST['ad_placed_by'] : "",
                    'age' => isset($_POST['age']) ? $_POST['age'] : "",
                    'selling_price' => isset($_POST['selling_price']) ? $_POST['selling_price'] : "",
                    'bedrooms' => isset($_POST['bedrooms']) ? $_POST['bedrooms'] : "",
                    'price' => isset($_POST['price']) ? $_POST['price'] : "",
                    'total' => isset($tot) ? $tot : "",
                    'date' => date('Y-m-d H:i:s'),
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
                    'image12' => isset($_POST['image12']) ? $_POST['image12'] : ""
                );
                if ($this->post_national_ads_model->update_post_national_ads($id, $data_to_store) == TRUE) {
                    $this->session->set_flashdata('flash_message', 'updated');
                    // redirect("post_national_ads/preview_ad/$id");
                    redirect("post_national_ads/preview_ad/$id");
                } else {
                    if (!$this->recaptcha->getIsValid()) {
                        $this->session->set_flashdata('flash_message', 'Wrong captcha');
                        $this->session->set_flashdata('flash_class', 'alert-error');
                    } else {
                        $this->session->set_flashdata('flash_message', 'add Successfully');
                        $this->session->set_flashdata('flash_class', 'alert-error');
                    }
                    $data['flash_message'] = FALSE;
                }
                //}
            }
        }
        $data['post_national_ads_details'] = $this->post_national_ads_model->get_post_national_ads_by_id($posts_id);
        $data['main_content'] = 'post_national_ads_edit_view';
        $this->load->view('includes/template', $data);
    }

    function preview_ad() {
        $posts_id = $this->uri->segment(3);

        $data['category'] = $this->session->userdata('category');
        $data['sub_category'] = $this->session->userdata('sub_category');
        $where_subcategory = " AND category_id={$data['sub_category']}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $where_subcategory1 = " AND category_id={$data['category']}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory1);

        $data['post_national_ads'] = $this->post_national_ads_model->get_post_national_ads_by_id($posts_id);
        $lang_shotcode = Do_language::GetSessionLang();
        $data['category_opt'] = $this->common_model->getDDArray('category', 'category_id', 'category_name_' . $lang_shotcode);
        $data['main_content'] = 'post_national_preview_ad_view';
        $this->load->view('includes/template', $data);
    }

}
