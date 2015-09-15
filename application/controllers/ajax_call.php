<?php

class Ajax_call extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */
    //const VIEW_FOLDER = 'kd2a2a0u1g4/site_language';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('site_language_model');
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function set_session_language_shortcode() {
        $language_shortcode = $this->input->post('lang');
        $data = array(
            'language_shortcode' => $language_shortcode,
        );
        $this->session->set_userdata($data);
    }

    public function profile_delete() {
        $id = $this->input->post('language_id');
        $field = $this->input->post('field');
        $user_id = $this->input->post('table_id');
        $get_user = $this->user_model->get_user_by_id($user_id);
        $data = $get_user[0][$field];
        $newdata = explode(",", $data);
        //print_r($newdata);
        if (in_array($id, $newdata)) {
            unset($newdata[array_search($id, $newdata)]);
        }
        //print_r($newdata);
        if (count($newdata) > 0) {
            $str = implode(",", $newdata);
            $array = array($field => $str);
        } else {
            $array = array($field => '');
        }
        //print_r($array);
        if ($this->user_model->update_user($user_id, $array) == true) {
            return true;
        }
    }

    public function update_user() {

        $field = $this->input->post('field');
        $user_id = $this->input->post('user_id');
        $get_user = $this->user_model->get_user_by_id($user_id);
        $userdata = $get_user[0][$field];
        if ($userdata == "YES") {
            $this->user_model->update_user($user_id, array($field => "NO"));
            echo "NO";
        } else if ($userdata == "NO") {
            $this->user_model->update_user($user_id, array($field => "YES"));
            echo "YES";
        }
    }

    public function remove_avatar() {

        $field = 'avatar';
        $user_id = $this->session->userdata('user_id');
        $get_user = $this->user_model->get_user_by_id($user_id);
        $userdata = $get_user[0][$field];

        @unlink(FCPATH . "uploads/avatar/" . $userdata);
        //echo FCPATH."uploads\avatar/".$userdata; die;
        $this->user_model->update_user($user_id, array($field => ""));
        echo "YES";
    }

}

