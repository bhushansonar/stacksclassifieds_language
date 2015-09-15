<?php

class Full_image extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('full_image_model');
        $this->load->helper('url');
        $this->load->model('common_model');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {
        $this->load->helper('url');
    }

    function getFullImage() {

        $data['posts_id'] = $posts_id = $this->uri->segment(3);
        $data['parent_id'] = $parent_id = $this->uri->segment(4);
        $data['post_city'] = $post_city = $this->uri->segment(5);

        $image_name = $this->uri->segment(6);
        $data['image_name'] = base64url_decode($image_name);
        if (isset($parent_id) && !empty($parent_id)) {
            $cetegory_id = $parent_id;
        } else {
            $cetegory_id = $this->session->userdata('stack_category_id');
        }

        $state_id = $this->session->userdata('stack_state_id');
        $type = $this->session->userdata('stack_select_type');
        if ($type == 'state') {
            $data['id'] = $state_id;
        } else {
            if (isset($post_city) && !empty($post_city)) {
                $data['id'] = $city_id = $post_city;
            } else {
                $data['id'] = $city_id = $this->session->userdata('stack_city_id');
            }
        }
        if (isset($state_id) && !empty($state_id)) {
            $data['function'] = "get_all_title_data";
            $where = " AND category={$parent_id} AND state={$state_id} AND payment_status='complete'";
            $data['city_id'] = $city = $this->common_model->getFieldData('posts', 'city', $where);
            $whereCity = " AND city_id={$city}";
            $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $whereCity);
            $whereCat = " AND category={$cetegory_id} AND state={$state_id} AND posts_id={$posts_id}";
            $subcategory = $this->common_model->getFieldData('posts', 'subcategory', $whereCat);
            $sub_cat = $subcategory;
        } else {
            $data['function'] = "getAlltitle";
            $where = " AND city_id={$city_id}";
            $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $where);
            $whereCat = " AND category={$cetegory_id} AND city={$city_id} AND posts_id={$posts_id}";
            $subcategory = $this->common_model->getFieldData('posts', 'subcategory', $whereCat);

            $sub_cat = $subcategory;
        }

        //$cetegory_id = $this->session->userdata('stack_category_id');
        $where_category = " AND category_id={$cetegory_id}";
        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_category);

        $data['sub_category_id'] = $sub_cat;
        $where_subcategory = " AND category_id={$sub_cat}";
        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $data['des'] = $this->full_image_model->getImage($posts_id);
        $img1 = $data['des']['0']['image1'];
        $img2 = $data['des']['0']['image2'];
        $img3 = $data['des']['0']['image3'];
        $img4 = $data['des']['0']['image4'];
        $img5 = $data['des']['0']['image5'];
        $img6 = $data['des']['0']['image6'];
        $img7 = $data['des']['0']['image7'];
        $img8 = $data['des']['0']['image8'];
        $img9 = $data['des']['0']['image9'];
        $img10 = $data['des']['0']['image10'];
        $img11 = $data['des']['0']['image11'];
        $img12 = $data['des']['0']['image12'];
        $images = array('image1' => $img1, 'image2' => $img2, 'image3' => $img3, 'image4' => $img4, 'image5' => $img5, 'image6' => $img6, 'image7' => $img7, 'image8' => $img8, 'image9' => $img9, 'image10' => $img10, 'image11' => $img11, 'image12' => $img12);

        foreach ($images as $im) {
            if (!empty($im)) {
                $count_img[] = $im;
            }
        }
        $data['current_img'] = $post_city = $this->uri->segment(6);
        $data['img'] = $count_img;
        $data['main_content'] = 'full_image_view';
        $this->load->view('includes/template', $data);
    }

}

