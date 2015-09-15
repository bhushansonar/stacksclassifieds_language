<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Access_level {

    private static $CI;

    public function __construct() {
        //Load all helpers here...
        self::$CI = & get_instance();
        self::$CI->load->model('user_model');
//        self::$CI->load->model('company_model');
//        self::$CI->load->model('user_role_extended_model');
        self::$CI->load->helper('url');
    }

    public static function session_user_type() {
        $user_type = self::$CI->session->userdata('type_of_membership');
        if (!empty($user_type)) {
            return $user_type;
        } else {
            redirect('admin/login');
        }
    }

    public static function session_user_id() {
        $user_id = self::$CI->session->userdata('user_id');
        if (!empty($user_id)) {
            return $user_id;
        } else {
            redirect('admin/login');
        }
    }

    public static function session_username() {
        $username = self::$CI->session->userdata('username');
        if (!empty($username)) {
            return $username;
        } else {
            redirect('admin/login');
        }
    }

//    public static function session_company_id() {
//        return $company_id = self::$CI->session->userdata('company_id');
////        if (!empty($company_id)) {
////            return $company_id;
////        } else {
////            redirect('admin/login');
////        }
//    }

    /*     * **********************************************
      /**********Users role Information****************

      1 	super_admin
      2 	admin
      3 	operator
      4 	customer


     * ***********************************************
     * ********************************************* */

    public static function user_role_array() {
        return array("power_admin" => "Super Admin", "Admin" => "Admin", "User" => "User", "Affilite" => "Affilite", "employee" => "Employee");
    }

    public static function user_role_dropdown() {
        return array(
            "power_admin" => array("Admin" => "Admin", "User" => "User", "Affilite" => "Affilite", "employee" => "Employee"),
            "Admin" => array("Admin" => "Admin", "User" => "User", "Affilite" => "Affilite", "employee" => "Employee"),
            "User" => array("User" => "User"),
            "Affilite" => array("Affilite" => "Affilite"),
            "employee" => array("employee" => "Employee"),
//            "customer" => array("customer" => "Customer")
        );
    }

//Define permissions to Aceess module by User Role
    public static function get_access($controller) {
        // 1 	super_admin
        $modules = array();
        $user_type = self::$CI->session->userdata('type_of_membership');

        if ($user_type == 'power_admin') {
            $modules = array('category', 'posts', 'user', 'country', 'state', 'city', 'city_category_price', 'cms', 'promocode', 'top_ads', 'featured_price', 'sitelanguage', 'languagekeyword', 'category_price');
        }
        //2 admin
        if ($user_type == 'Admin') {
            $modules = array('posts');
        }
        //3 operator
        if ($user_type == 'User') {
            $modules = array('posts');
        }
        //4 	customer
        if ($user_type == 'Affilite') {
            $modules = array('posts');
        }
        if ($user_type == 'employee') {
            $modules = array('posts');
        }
        if (in_array($controller, $modules)) {
            return true;
        } else {
            return false;
        }
    }

}
