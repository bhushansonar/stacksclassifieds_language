<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Do_language {

    var $CI;

    public function __construct() {

        $this->CI = & get_instance();
        $this->CI->load->model('site_language_model');
        $this->CI->load->model('language_keyword_model');
        $this->set_language();
    }

    function set_language() {

        if (!$this->CI->session->userdata('language_shortcode')) {
            $data = array('language_shortcode' => 'en',);
            $this->CI->session->set_userdata($data);
        }
        $session_language_shortcode = $this->CI->session->userdata('language_shortcode');
        $get_lang_data = $this->CI->language_keyword_model->get_language_keyword('', '', '', '', '', '');
        for ($i = 0; $i < count($get_lang_data); $i++) {
            if (empty($get_lang_data[$i][$session_language_shortcode])) {
                $session_lang_short = $get_lang_data[$i]["en"];
            } else {
                $session_lang_short = $get_lang_data[$i][$session_language_shortcode];
            }
            define(stripslashes($get_lang_data[$i]["language_define"]), stripslashes($session_lang_short));
        }
    }

    public static function GetSessionLang() {
        $ci = self::CIInstance();
        $language_shrotcode = $ci->session->userdata('language_shortcode');
        $lang = !empty($language_shrotcode) ? $language_shrotcode : "en";
        return $lang;
    }

    public static function CIInstance() {
        return $ci = & get_instance();
    }

}

