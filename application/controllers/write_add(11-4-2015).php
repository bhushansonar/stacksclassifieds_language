<?php

class Write_add extends CI_Controller {

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

        $this->load->model('write_add_model');
        $this->load->model('common_model');
        $this->load->model('home_model');
        $this->load->model('city_model');
        $this->load->library('recaptcha');
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->helper('email');
        $this->load->library('email');
//        $this->load->helper('smiley');
        $this->load->library('table');
        $this->load->library('image_lib');
        $this->load->library('upload');
        $this->load->library('Functions');
        $this->load->library('Recaptcha');
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

    function check_captcha() {
        if (!$this->recaptcha->getIsValid()) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function update() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $parent_id = $_POST['parent_id'];
            $id = $_POST['posts_id'];
            $this->recaptcha->recaptcha_check_answer();
            $this->form_validation->set_rules('title', 'title', 'required|max_length[150]');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|matches[confirm_email]');
            $this->form_validation->set_rules('confirm_email', 'Email Address Confirmation', 'required');
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required|numeric|exact_length[10]');
            $this->form_validation->set_rules('recaptcha_response_field', 'Recaptcha', 'required|callback_check_captcha');
            $this->form_validation->set_message('check_captcha', 'Wrong Recaptcha');
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

            //if ($parent_id == 2 || $parent_id == 5 || $parent_id == 10 || $parent_id == 8 || $parent_id == 9 || $parent_id == 1) {
            $this->form_validation->set_rules('location', 'location', 'required');
            //}
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

            if ($this->form_validation->run() && $this->recaptcha->getIsValid()) {

                $path = './upload/post_ads';

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

                    if (!$this->image_lib->resize()) {

                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {

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

                    if (!$this->image_lib->resize()) {

                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {

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

                    if (!$this->image_lib->resize()) {

                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {

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
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
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
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
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
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
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
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
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

                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
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
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
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
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
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
                    if (!$this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
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

                $current_date = strtotime(date('Y-m-d H:i:s'));
                $expire_date = strtotime($_POST['expire_date']);
                $status = isset($_POST['status']) ? $_POST['status'] : "";
                $renew = isset($_POST['renew']) ? $_POST['renew'] : "";
                if (!empty($renew)) {
                    if ($renew == 'renew') {
                        if (!empty($expire_date)) {
                            if ($expire_date < $current_date) {
                                $res = date('Y-m-d', strtotime('1 week', $current_date));
                            }
                            $sta = $status;
                        }
                    }
                } else {
                    $res = date('Y-m-d', $expire_date);
                    $sta = "Inactive";
                }

                $total = "0";
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


                $ads_type = $_POST['ads_type'];
                if ($ads_type == 'paid') {
                    $city_category_price = isset($_POST['city_category_price']) ? $_POST['city_category_price'] : 0;
                    $final_total = $total + $city_category_price;
                    $data_to_store = array(
                        'uid' => $user_id,
                        'ads_type' => $ads_type,
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
                        'featured_ad' => isset($_POST['featured_ad']) ? $_POST['featured_ad'] : "",
                        'featured_ad_week_price' => isset($_POST['featured_ad_week_price']) ? $_POST['featured_ad_week_price'] : "",
                        'featured_ad_week' => isset($_POST['featured_ad_week']) ? $_POST['featured_ad_week'] : "",
                        'total' => isset($final_total) ? $final_total : "",
                        'video' => $_POST['video'],
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
                        'payment_status' => 'pending',
//                        'date' => date('Y-m-d H:i:s'),
                        'expire_date' => $res,
                        'status' => $sta
                    );
                } else {
                    $data_to_store = array(
                        'uid' => $user_id,
                        'ads_type' => $ads_type,
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
//                        'date' => date('Y-m-d H:i:s'),
                        'expire_date' => $res,
                        'status' => $sta
                    );
                }
                if ($this->write_add_model->update_posts($id, $data_to_store) == TRUE) {
                    //$this->session->set_flashdata('flash_message', 'updated');
                    redirect("write_add/preview_ad_single_city/$id");
                }
            }
        }
        $data['posts_id'] = $post_id = $this->uri->segment(3);
        $data['renew'] = $this->uri->segment(4);
        $data['posts_category'] = $this->session->userdata('category');
        if (!empty($data['posts_category'])) {
            $data['category'] = $category_id = $this->session->userdata('category');
            $data['sub_category'] = $this->session->userdata('sub_category');
        } else {
            $posts_data = $this->write_add_model->get_category_by_posts_id($post_id);
            $data['category'] = $posts_data[0]['category'];
            $data['sub_category'] = $posts_data[0]['subcategory'];
            $data['city'] = $posts_data[0]['city'];
            $session_category = array(
                "category" => $data['category'],
                "sub_category" => $data['sub_category'],
                "stack_city_id" => $data['city']
            );
            $this->session->set_userdata($session_category);
        }
        $where_subcategory = " AND category_id={$data['sub_category']}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $where_subcategory1 = " AND category_id={$data['category']}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory1);
        $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
        $data['posts_ads_details'] = $this->write_add_model->get_posts_by_id($post_id);

        if (!empty($data['posts_ads_details'][0]['category'])) {
            $where_featured_ad_sub_cat = " AND category_id={$data['posts_ads_details'][0]['subcategory']} AND city_id={$data['posts_ads_details'][0]['city']}";
            $city_featured_price_sub_cat = $this->common_model->getFieldData('featured_price', 'featured_week_price', $where_featured_ad_sub_cat);
            if (!empty($city_featured_price_sub_cat)) {
                $data['city_featured_price'] = $city_featured_price_sub_cat;
            } else {
                $where_featured_ad_cat = " AND category_id={$data['posts_ads_details'][0]['category']} AND city_id={$data['posts_ads_details'][0]['city']}";
                $city_featured_price_cat = $this->common_model->getFieldData('featured_price', 'featured_week_price', $where_featured_ad_cat);
                $data['city_featured_price'] = $city_featured_price_cat;
            }
        }
        $data['main_content'] = 'write_add_edit_view';
        $this->load->view('includes/template', $data);
    }

    public function add() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            if (isset($_POST['featured_ad'])) {
                if (isset($_POST['featured_ad_week_price'])) {
                    $this->form_validation->set_rules('featured_ad_week_price', 'Featured Ad Week Price', 'required');
                    $this->check_default($_POST['featured_ad_week_price']);
                    $this->form_validation->set_rules('featured_ad_week_price', '', 'callback_check_default');
                    $this->form_validation->set_message('check_default', 'Please add upgrades to have a minimum purchase of 0.99');
                }
            }
            if (isset($_POST['auto_repost_ad'])) {
                $this->form_validation->set_rules('auto_repost_no_of_time', 'Auto Repost Number of time', 'required');
                $this->form_validation->set_message('auto_repost_no_of_time', 'Number of time Required');
                $this->form_validation->set_rules('auto_repost_day', 'Auto Repost Day', 'required');
                $this->form_validation->set_rules('auto_repost_time', 'Auto Repost Time', 'required');
            }
            $parent_id = $_POST['parent_id'];
            $this->recaptcha->recaptcha_check_answer();
            $this->form_validation->set_rules('title', 'title', 'required|max_length[150]');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required|numeric|exact_length[10]');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|matches[confirm_email]');
            $this->form_validation->set_rules('confirm_email', 'Email Address Confirmation', 'required');
            $this->form_validation->set_rules('recaptcha_response_field', 'Recaptcha', 'required|callback_check_captcha');
            $this->form_validation->set_message('check_captcha', 'Wrong Recaptcha');
            if ($parent_id == 4 || $parent_id == 11) {
                $this->form_validation->set_rules('age', 'age', 'required');
                $this->age_check($_POST['age']);
                $this->form_validation->set_rules('age', '', 'callback_age_check');
                $this->form_validation->set_message('age_check', 'Sorry, the ad poster must be over 18 years of age.');
            }

            $this->form_validation->set_rules('location', 'location', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

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
                if ($this->session->userdata('user_id')) {
                    $user_id = $this->session->userdata('user_id');
                } else {
                    $user_id = "0";
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

                $date = date('Y-m-d');
                $currentDate = strtotime($date);
                $futureDate = $currentDate + (60 * 5);
                $formatDate = date("Y-m-d H:i:s", $futureDate);
                $res = date('Y-m-d', strtotime('1 week', strtotime($date)));

                $city_category_price = isset($_POST['city_category_price']) ? $_POST['city_category_price'] : "";
                if (!empty($city_category_price)) {

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

                    $tot = $auto_repost_price + $featured_ad_week_price + $city_category_price;

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
                    $adsType = 'paid';
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
                        'work_status' => $work_status,
                        'shift' => $shift,
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
                        'featured_ad' => isset($_POST['featured_ad']) ? $_POST['featured_ad'] : "",
                        'featured_ad_week_price' => isset($_POST['featured_ad_week_price']) ? $_POST['featured_ad_week_price'] : "",
                        'featured_ad_week' => isset($_POST['featured_ad_week']) ? $_POST['featured_ad_week'] : "",
                        'total' => isset($net_total) ? $net_total : "",
                        'pets' => isset($_POST['pets']) ? $_POST['pets'] : "",
                        'fees_paid_by' => isset($_POST['fees_paid_by']) ? $_POST['fees_paid_by'] : "",
                        'ad_placed_by' => isset($_POST['ad_placed_by']) ? $_POST['ad_placed_by'] : "",
                        'age' => isset($_POST['age']) ? $_POST['age'] : "",
                        'selling_price' => isset($_POST['selling_price']) ? $_POST['selling_price'] : "",
                        'bedrooms' => isset($_POST['bedrooms']) ? $_POST['bedrooms'] : "",
                        'price' => isset($_POST['price']) ? $_POST['price'] : "",
                        'date' => $formatDate,
                        'expire_date' => $res,
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
                        'status' => "Inactive"
                    );

                    $insert_id = $this->write_add_model->add_temp_post($data_to_store);
                    if ($insert_id) {
                        //$this->session->set_flashdata('flash_message', 'add');
                        redirect("write_add/preview_ad_single_city/$insert_id");
                    }
                } else {
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

                        $tot = $auto_repost_price + $featured_ad_week_price;

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

                        $adsType = 'paid';
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
                            'work_status' => $work_status,
                            'shift' => $shift,
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
                            'featured_ad' => isset($_POST['featured_ad']) ? $_POST['featured_ad'] : "",
                            'featured_ad_week_price' => isset($_POST['featured_ad_week_price']) ? $_POST['featured_ad_week_price'] : "",
                            'featured_ad_week' => isset($_POST['featured_ad_week']) ? $_POST['featured_ad_week'] : "",
                            'total' => isset($net_total) ? $net_total : "",
                            'pets' => isset($_POST['pets']) ? $_POST['pets'] : "",
                            'fees_paid_by' => isset($_POST['fees_paid_by']) ? $_POST['fees_paid_by'] : "",
                            'ad_placed_by' => isset($_POST['ad_placed_by']) ? $_POST['ad_placed_by'] : "",
                            'age' => isset($_POST['age']) ? $_POST['age'] : "",
                            'selling_price' => isset($_POST['selling_price']) ? $_POST['selling_price'] : "",
                            'bedrooms' => isset($_POST['bedrooms']) ? $_POST['bedrooms'] : "",
                            'price' => isset($_POST['price']) ? $_POST['price'] : "",
                            'date' => $formatDate,
                            'expire_date' => $res,
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
                            'status' => "Inactive"
                        );

                        $insert_id = $this->write_add_model->add_temp_post($data_to_store);
                        if ($insert_id) {
                            //$this->session->set_flashdata('flash_message', 'add');
                            redirect("write_add/preview_ad_single_city/$insert_id");
                        }
                    } else {

                        $adsType = 'free';
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
                            'work_status' => $work_status,
                            'shift' => $shift,
                            'postcode' => isset($_POST['postcode']) ? $_POST['postcode'] : "",
                            'email' => isset($_POST['email']) ? $_POST['email'] : "",
                            'contact_number' => isset($_POST['contact_number']) ? $_POST['contact_number'] : "",
                            'inquery' => isset($_POST['inquery']) ? $_POST['inquery'] : "",
                            'show_ad_links' => isset($_POST['show_ad_links']) ? $_POST['show_ad_links'] : "",
                            'show_joined_date' => isset($_POST['show_joined_date']) ? $_POST['show_joined_date'] : "",
                            'auto_repost_ad' => isset($_POST['auto_repost_ad']) ? $_POST['auto_repost_ad'] : "",
                            'postcode' => isset($_POST['postcode']) ? $_POST['postcode'] : "",
                            'promotions_sponsor_ad' => isset($_POST['promotions_sponsor_ad']) ? $_POST['promotions_sponsor_ad'] : "",
                            'pets' => isset($_POST['pets']) ? $_POST['pets'] : "",
                            'fees_paid_by' => isset($_POST['fees_paid_by']) ? $_POST['fees_paid_by'] : "",
                            'ad_placed_by' => isset($_POST['ad_placed_by']) ? $_POST['ad_placed_by'] : "",
                            'age' => isset($_POST['age']) ? $_POST['age'] : "",
                            'selling_price' => isset($_POST['selling_price']) ? $_POST['selling_price'] : "",
                            'bedrooms' => isset($_POST['bedrooms']) ? $_POST['bedrooms'] : "",
                            'price' => isset($_POST['price']) ? $_POST['price'] : "",
                            'payment_status' => "complete",
                            'date' => $formatDate,
                            'expire_date' => $res,
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
                            'status' => "Inactive"
                        );

                        $ads_post_id = $this->write_add_model->addPosts($data_to_store);
                        if ($ads_post_id) {
                            $data['flash_message'] = TRUE;
                            //$this->session->set_flashdata('flash_message', 'add');
                            redirect("write_add/preview_ad_single_city/$ads_post_id");
                        }
                    }
                }
            }
        }
        $city_id = $this->uri->segment(3);
        $session = array(
            "city" => $city_id,
        );
        $this->session->set_userdata($session);
        $data['city'] = $city = $this->session->userdata('stack_city_id');
        $data['category'] = $category_id = $this->session->userdata('category');
        $city_data = $this->home_model->getCity_by_field_value('city_id', $city);
        $data['subcategory'] = $sub_cat = $this->session->userdata('sub_category');
        $where_subcategory = " AND category_id={$data['category']}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $data['state'] = @$city_data[0]['state_id'];
        $data['country'] = @$city_data[0]['country_id'];
        $data['parent_id'] = @$this->session->userdata('category');
        $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();

        if (!empty($category_id)) {
            if ($category_id == '11' || $category_id == '4') {
                $where = " AND category_id={$sub_cat} AND city_id={$city}";
                $city_category_price = $this->common_model->getFieldData('city_category_price', 'price', $where);
                if (!empty($city_category_price) && $city_category_price != "0") {
                    $data['city_category_price'] = $city_category_price;
                } else {
                    $whereStr = " AND category_id={$category_id} AND city_id={$city}";
                    $city_category_price1 = $this->common_model->getFieldData('city_category_price', 'price', $whereStr);
                    if (!empty($city_category_price1) && $city_category_price1 != "0") {
                        $data['city_category_price'] = $city_category_price1;
                    } else {

                        $category_price = $this->city_model->get_category_by_city_id($sub_cat);
                        if (!empty($category_price[0]['price']) && $category_price[0]['price'] !== '0') {
                            $data['city_category_price'] = $category_price[0]['price'];
                        } else {
                            $category_price = $this->city_model->get_category_by_city_id($category_id);
                            $data['city_category_price'] = $category_price[0]['price'];
                        }
                    }
                }
            }
            $where_featured_ad_sub_cat = " AND category_id={$sub_cat} AND city_id={$city}";
            $city_featured_price_sub_cat = $this->common_model->getFieldData('featured_price', 'featured_week_price', $where_featured_ad_sub_cat);
            if (!empty($city_featured_price_sub_cat)) {
                $data['city_featured_price'] = $city_featured_price_sub_cat;
            } else {
                $where_featured_ad_cat = " AND category_id={$category_id} AND city_id={$city}";
                $city_featured_price_cat = $this->common_model->getFieldData('featured_price', 'featured_week_price', $where_featured_ad_cat);
                $data['city_featured_price'] = $city_featured_price_cat;
            }
        }


        $data['main_content'] = 'write_add_view';
        $this->load->view('includes/template', $data);
    }

    function preview_ad_single_city() {
        $post_id = $this->uri->segment(3);
        $where_post_id = " AND posts_id={$post_id}";
        $data['promocode_value'] = $this->uri->segment(4);
        $data['promotype'] = $this->uri->segment(5);
        $category_id = $this->session->userdata('category');
        if (!empty($category_id)) {
            $data['category'] = $category_id;
        } else {
            $data['category'] = $this->common_model->getFieldData('posts', 'category', $where_post_id);
        }
        $sub_category_id = $this->session->userdata('sub_category');
        if (!empty($sub_category_id)) {
            $data['sub_category'] = $sub_category_id;
        } else {
            $data['sub_category'] = $this->common_model->getFieldData('posts', 'category', $where_post_id);
        }
        $where_subcategory = " AND category_id={$data['sub_category']}";
        $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $where_subcategory = " AND category_id={$data['category']}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $data['post_ads'] = $this->write_add_model->get_posts_by_id($post_id);
        $data['main_content'] = 'preview_ad_single_city_view';
        $this->load->view('includes/template', $data);
    }

    function sending_mail() {
        $title = unserialize(base64_decode($this->input->post('title')));
        $short_title = substr($title, 0, 89);

        $posts_id = $this->input->post('posts_id');
        $enctyp_post_id = encrypt($posts_id);
        $auto_repost = $this->input->post('auto_repost_ad');
        $email = $this->input->post('email');
        $featured_ad = $this->input->post('featured_ad');
        if (!empty($auto_repost)) {
            $auto_repost_data = $auto_repost;
        } else {
            $auto_repost_data = 'NO';
        }
        if (!empty($featured_ad)) {
            $featured_ad_data = $featured_ad;
        } else {
            $featured_ad_data = 'NO';
        }
        //exit;
        if (valid_email($email)) {
            $get_admin_detail = get_admin_email_verification(); //common helper function for admin detail
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'utf-8';
            $config['mailtype'] = 'html';
            $config['priority'] = 1;
            $this->email->initialize($config);
            $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
            $this->email->to($email);
            $this->email->set_mailtype("html");
            $this->email->subject('Click link to post ' . $short_title . '...');
            $mail_data['url'] = base_url() . 'write_add/view_ads/' . $enctyp_post_id;
            $mail_data['title'] = $title;
            $mail_data['featured_ad'] = $featured_ad_data;
            $mail_data['auto_repost_ad'] = $auto_repost_data;
            $mail_data['posting_date'] = date("D j F, Y, g:i a");

            $current_date = date('Y-m-d');
            $posting_exipire_date = date('D j F, Y, g:i a', strtotime('1 week', strtotime($current_date)));
            $mail_data['posting_exipire_date'] = $posting_exipire_date;
            $mail_data_admin['email'] = $email;
            $message = $this->load->view('mail_templates/classfied_post', $mail_data, true);
            $this->email->message($message);
            if (!$this->email->send()) {
                $msgadd = "<strong>E-mail not sent </strong>";
                $data['flash_message'] = TRUE;
                $this->session->set_flashdata('flash_class', 'alert-error');
                $this->session->set_flashdata('flash_message', $msgadd);
                redirect("write_add/preview_ad_single_city/$posts_id");
            } else {
                $max_value = $this->home_model->get_maximum_value();
                $update_max_val = $max_value + 1;
                $data_store = array(
                    'move_to_ad' => $update_max_val,
                    'status' => 'Active'
                );
                $this->write_add_model->updateStatus($posts_id, $data_store);

                $this->email->clear(TRUE);
                $get_admin_detail = get_admin_email_verification();
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['priority'] = 1;
                $this->email->initialize($config);
                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to('new_ads@stacksclassifieds.com');
                $this->email->set_mailtype("html");
                $this->email->subject('Click link to post ' . $title);
                $mail_data_admin['title'] = $title;
                $mail_data_admin['featured_ad'] = $featured_ad_data;
                $mail_data_admin['auto_repost_ad'] = $auto_repost_data;
                $mail_data_admin['posting_date'] = date("D j F, Y, g:i a");
                $current_date = date('Y-m-d');
                $posting_exipire_date = date('D j F, Y, g:i a', strtotime('1 week', strtotime($current_date)));
                $mail_data['posting_exipire_date'] = $posting_exipire_date;
                $mail_data_admin['email'] = $email;
                $message1 = $this->load->view('mail_templates/classfied_post_to_admin', $mail_data_admin, true);
                $this->email->message($message1);
                $this->email->send();
                redirect("write_add/chekck_email_page/$posts_id");
            }
        }
    }

    function view_ads() {
        $posts_id = $this->uri->segment(3);
        $decrypt_post_id = decrypt($posts_id);
        $session_post_by_mail = array(
            "click_by_email" => true,
        );
        $this->session->set_userdata($session_post_by_mail);
        redirect("manage_ad_list/manage_ads/$decrypt_post_id");
    }

    function chekck_email_page() {
        $post_id = $this->uri->segment(3);
        $data['category'] = $category_id = $this->session->userdata('category');
        $data['sub_category'] = $this->session->userdata('sub_category');
        $where_subcategory = " AND category_id={$data['sub_category']}";
        $data['sub_category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $where_subcategory = " AND category_id={$data['category']}";
        $data['category_name'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $data['post_data'] = $this->write_add_model->get_post_content_by_id($post_id);
        $where_city = " AND city_id={$data['post_data'][0]['city']}";
        $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $where_city);
        $data['main_content'] = 'check_email_page_view';
        $this->load->view('includes/template', $data);
    }

}

