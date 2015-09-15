<?php

class common_ctrl extends CI_Controller {

    var $controller = "common_ctrl";
    var $tableName = "user";
    var $fieldName = "user";
    var $preName = "";
    var $pageType = "list";
    var $viewContent = array();
    var $headerContent = array();
    var $formValues = array();
    var $table_arr = array();

    public function __construct() {
        parent::__construct();

        $this->load->model('common_model');
    }

    function get_places() {
        if (isset($_POST['child_type']) && isset($_POST['parent_id']) && $_POST['parent_id'] != "") {
            $data = array();
            $place = "";
            switch ($_POST['child_type']) {
                case 'state':
                    $data = $this->common_model->getDDArray('state', 'state_id', 'state_name', " AND country_id = '{$_POST['parent_id']}'");
                    break;
                case 'city':
                    $data = $this->common_model->getDDArray('city', 'city_id', 'city_name', " AND state_id = '{$_POST['parent_id']}'");
                    break;
                case 'subcategory':
                    $data = $this->common_model->getDDArray('category', 'category_id', 'category_name_en', " AND parent_id = '{$_POST['parent_id']}'");
                    break;
            }
            if (!empty($data)) {
                foreach ($data as $place_id => $place) {
                    ?>
                    <option value='<?php echo $place_id ?>'><?php echo $place ?></option>
                    <?php
                }
            } else {
                echo "<option value=''>Select</option>";
            }
        } else {
            echo "<option value=''>Select</option>";
        }
    }

    function get_content_by_category($post_id, $category_id) {
        if (isset($post_id) && isset($category_id) && $category_id != "") {
            $data = array();
            $place = "";
            switch ($category_id) {
                case 'state':
                    $data = $this->common_model->getDDArray('state', 'state_id', 'state_name', " AND country_id = '{$_POST['parent_id']}'");
                    break;
                case 'city':
                    $data = $this->common_model->getDDArray('city', 'city_id', 'city_name', " AND state_id = '{$_POST['parent_id']}'");
                    break;
                case 'subcategory':
                    $data = $this->common_model->getDDArray('category', 'category_id', 'category_name', " AND parent_id = '{$_POST['parent_id']}'");
                    break;
            }
            if (!empty($data)) {
                foreach ($data as $place_id => $place) {
                    ?>
                    <option value='<?php echo $place_id ?>'><?php echo $place ?></option>
                    <?php
                }
            } else {
                echo "<option value=''>Select</option>";
            }
        } else {
            echo "<option value=''>Select</option>";
        }
    }

}
