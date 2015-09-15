<?php

class Featured_ads extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('featured_ads_model');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {
        $html = "";
        $feature_ads = $this->featured_ads_model->getAllFeatured();
        @$rand_arr = $this->array_random($feature_ads, 8);
        $rand_filter_arr = array_filter($rand_arr);
        $html.="<div class='statclass'>
            <ul><div><li style='display:inline-block;vertical-align: top;'><img alt='sc' height='100' src='" . base_url() . "uploads/post_ads/thumb/sc.png'></li>";
        for ($s = 0; $s < count($rand_filter_arr); $s++) {
            $html.="<li style='display:inline-block;vertical-align: top;'>";
            $html.="<a target='_blank' href='" . base_url('post_detail/getPostdetails/' . $rand_filter_arr[$s]["posts_id"] . '/' . $rand_filter_arr[$s]["category"] . '/' . $rand_filter_arr[$s]["city"]) . "'><img  height='100'  alt='" . @$rand_filter_arr[$s]['image1'] . "' src='" . base_url() . "uploads/post_ads/thumb/" . @$rand_filter_arr[$s]['image1'] . "'></a>";
            $html.="</li>";
        }
        $html.="</div></ul></div>";
        echo $html;
    }

    function array_random($arr, $num = 1) {
        shuffle($arr);
        $r = array();
        for ($i = 0; $i < $num; $i++) {
            $r[] = $arr[$i];
        }
        return $num == 1 ? $r[0] : $r;
    }

}

