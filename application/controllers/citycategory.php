<?php

class Citycategory extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('citycategory_model');
        $this->load->model('city_model');
        $this->load->model('common_model');
        $this->load->model('country_model');
        $this->load->helper('url');
        $this->session->unset_userdata('page_type');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {

        $this->load->helper('url');
    }

    function cat() {

        $data['city_id'] = $city_id = $this->uri->segment(3);
        $seletctType = 'city';
        $this->session->unset_userdata('stack_state_id');
        $this->session->unset_userdata('stack_select_type');
        $session = array(
            'stack_city_id' => $city_id,
            'stack_select_type' => $seletctType
        );

        $this->session->set_userdata($session);

        $city_data = $this->city_model->get_city_by_Where_array(array('city_id'), array($city_id));
        $country_id = $city_data[0]['country_id'];
        $country_data = $this->country_model->get_country_by_id($country_id);
        $data['country_language_shortcode'] = !empty($country_data[0]['language_shortcode']) ? $country_data[0]['language_shortcode'] : "en";

//        if ($data['country_language_shortcode'] != Do_language::GetSessionLang()) {
//            $sessiondata = array(
//                'language_shortcode' => $data['country_language_shortcode'],
//            );
//
//            $this->session->set_userdata($sessiondata);
//        }
        $post_content = $this->citycategory_model->get_posts_field_value('city', $city_id);
        $where_category = "`parent_id` = '0'";
        $data['search_sub_category'] = $this->citycategory_model->getAllcategory($where_category);
        $data['cat'] = $this->citycategory_model->getAllcategory($where_category);
        $data['main_content'] = 'citycategory_view';
        $this->load->view('includes/template', $data);
    }

    function get_city() {

        $state_id = $_POST['state_id'];
        $all_city_by_state = $this->common_model->get_content_by_field('city', 'state_id', $state_id);
        if (!empty($all_city_by_state)) {
            foreach ($all_city_by_state as $place_id => $place) {
                ?>
                <li><a href="<?php echo site_url(); ?>citycategory/cat/<?php echo $place['city_id'] . "/" . $place['city_name'] ?>" style="color:#2a4e89"><?php echo $place['city_name'] ?></a></li>
                <?php
            }
        } else {
            echo "<li></li>";
        }
    }

//    function top_ads_aaa() {
//        $top_ads_id = $this->uri->segment(3);
//        $where_top_ads = " AND top_ads_id='{$top_ads_id}'";
//        //$data['title'] = $title = $this->common_model->getFieldData('top_ads', 'title', $where_top_ads);
//        $category = $this->common_model->getFieldData('top_ads', 'category_id', $where_top_ads);
//        if (!empty($category)) {
////            $where_top_ads = " AND top_ads_id='{$top_ads_id}'";
//            $data['title'] = $title = $this->common_model->getFieldData('top_ads', 'title', $where_top_ads);
//            $multi_cate = "'" . implode("','", explode(',', $category)) . "'";
//            $where_multi_cate = "category_id IN({$multi_cate})";
//
//            $lang_shortcode = Do_language::GetSessionLang();
//            $top_ads_category = $this->citycategory_model->get_top_ads_category_name('category', 'category_name_' . $lang_shortcode, $where_multi_cate);
//            $data['category_name'] = implode(" , ", $top_ads_category);
//
//            $category_id = explode(",", $category);
//            $data['cat_id'] = '';
//            $data['sub_cat_id'] = '';
//            $data['category'] = '';
//            $data['subcategory'] = '';
//            for ($i = 0; $i < count($category_id); $i++) {
//                $where_cat_id = " AND category_id='{$category_id[$i]}'";
//                $parent = $this->common_model->getFieldData('category', 'parent_id', $where_cat_id);
//                if ($parent == '0') {
//                    $data['category'] = "category";
//                    $data['cat_id'] = $category_id[$i];
//                } else {
//                    $data['subcategory'] = "subcategory";
//                    $data['sub_cat_id'] = $category_id[$i];
//                }
//            }
//
//            $cate_field = $data['category'];
//            $cate_id = $data['cat_id'];
//            $sub_cate_filed = $data['subcategory'];
//            $sub_cate_id = $data['sub_cat_id'];
//
//            $config['per_page'] = 10;
//            $config["uri_segment"] = 4;
//            $config['base_url'] = base_url() . 'citycategory/top_ads/' . $top_ads_id;
//            $config['use_page_numbers'] = TRUE;
//            $config['num_links'] = 25;
//            $config['full_tag_open'] = '<ul>';
//            $config['full_tag_close'] = '</ul>';
//            $config['num_tag_open'] = '<li>';
//            $config['num_tag_close'] = '</li>';
//            $config['cur_tag_open'] = '<li class="active"><a>';
//            $config['cur_tag_close'] = '</a></li>';
//
//            $page = $this->uri->segment(4);
//
//            $limit_end = ($page * $config['per_page']) - $config['per_page'];
//            if ($limit_end < 0) {
//                $limit_end = 0;
//            }
//            $data['top_ads'] = $this->common_model->get_top_ads_by_id('posts', $cate_field, $cate_id, $sub_cate_filed, $sub_cate_id, $config['per_page'], $limit_end);
//
//            if (!empty($data['top_ads'])) {
//                $data['top_ads_category_title'] = "{$data['category_name']} :{$data['title']}";
//            } else {
//                $data['top_ads_category_title'] = "";
//            }
//            $data['count_products'] = $this->common_model->count_top_ads_by_id('posts', $cate_field, $cate_id, $sub_cate_filed, $sub_cate_id);
//            $config['total_rows'] = $data['count_products'];
//            $this->pagination->initialize($config);
//        } else {
//            $data['top_ads_category_title'] = "";
//        }
//        $data['main_content'] = 'top_ads_view';
//        $this->load->view('includes/template', $data);
//    }

    function top_ads() {
        $top_ads_id = $this->uri->segment(3);
        $where_top_ads = " AND top_ads_id='{$top_ads_id}'";
        $category = $this->common_model->getFieldData('top_ads', 'category_id', $where_top_ads);

        if (!empty($category)) {
            $multi_cate = "'" . implode("','", explode(',', $category)) . "'";
            $where_multi_cate = "category_id IN({$multi_cate})";
            $lang_shortcode = Do_language::GetSessionLang();
            $top_ads_category = $this->citycategory_model->get_top_ads_category_name('category', 'category_name_' . $lang_shortcode, $where_multi_cate);
            $data['title'] = $title = $this->common_model->getFieldData('top_ads', 'title', $where_top_ads);
            $data['category_name'] = implode(" , ", $top_ads_category);
            $data['top_ads_category_title'] = "{$data['category_name']} :{$data['title']}";

            $data['category'] = '';
            $data['subcategory'] = '';

            $category_id = explode(",", $category);
            for ($i = 0; $i < count($category_id); $i++) {
                $where_cat_id = " AND category_id='{$category_id[$i]}'";
                $parent = $this->common_model->getFieldData('category', 'parent_id', $where_cat_id);
                if ($parent == '0') {
                    $data['category'] = "category";
                } else {
                    $data['subcategory'] = "subcategory";
                }
            }
            $config['per_page'] = 20;
            $config["uri_segment"] = 4;
            $config['base_url'] = base_url() . 'citycategory/top_ads/' . $top_ads_id;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 25;
            $config['full_tag_open'] = '<ul>';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';

            $page = $this->uri->segment(4);

            $limit_end = ($page * $config['per_page']) - $config['per_page'];
            if ($limit_end < 0) {
                $limit_end = 0;
            }

            $data['top_ads'] = $this->common_model->get_top_ads_by_id($top_ads_id, $data['category'], $data['subcategory'], $config['per_page'], $limit_end);
            $data['count_products'] = $a = $this->common_model->count_top_ads_by_id($top_ads_id, $data['category'], $data['subcategory']);
//
            $config['total_rows'] = $data['count_products'];
            $this->pagination->initialize($config);
        } else {
            $data['top_ads_category_title'] = "";
        }
        $data['main_content'] = 'top_ads_view';
        $this->load->view('includes/template', $data);
    }

}

