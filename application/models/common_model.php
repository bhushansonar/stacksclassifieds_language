<?php

class common_model extends CI_Model {
    /* This function fetches single row from table name provided in first parameter based on fieldname
      and its value provided in second and third parameter respectively from database */

    function getRow($tableName = "", $fieldName = "", $value = "", $where = "") {
        $sql = sprintf("SELECT * FROM `%s` WHERE %s = '%s' %s", $tableName, $fieldName, $this->db->escape_str($value), $where);
        $query = $this->db->query($sql);
        $data = $query->result();
        if ($data) {
            return $data[0];
        }
        return false;
    }

    /* This function fetches count of the field provided in second parameter from the table name
      provided in first parameter based on criteria given in third parameter from database. */

    function getCount($tableName = "", $fieldName = "", $where = "") {

        if ($where != "") {
            $where = "1  " . $where;
        } else {
            $where = "1";
        }
        $sql = sprintf("SELECT COUNT(%s) as cnt FROM %s WHERE %s", $fieldName, $tableName, $where);
        $query = $this->db->query($sql);
        $data = $query->result();
        if ($data) {
            return $data[0]->cnt;
        }
        return false;
    }

    /* This function returns the data in the form of array can be used for dropdown.
      This second parameter will be as array index and third parameter as array value in the result. */

    function getDDArray($table = "", $indexField = "", $valueField = "", $where = "", $orderByIndexField = False, $orderByField = "") {
        $options = "";
        if ($orderByField == "") {
            $orderByField = $valueField;
            if ($orderByIndexField) {
                $orderByField = $indexField;
            }
        }
        $tables = explode(",", $table);
        $table = implode(",", $tables);
        $arrTemp = array();
        $sql = "SELECT $indexField,$valueField FROM $table WHERE 1 $where AND $tables[0].status='Active' ORDER BY " . $orderByField;
        $query = $this->db->query($sql);
        $data = $query->result();
        if ($data) {
            $indexField = array_pop(explode(".", $indexField));
            $valueField = array_pop(explode(".", $valueField));
            $arrTemp[""] = "Select";
            foreach ($data as $arrV) {
                $arrTemp[$arrV->$indexField] = $arrV->$valueField;
            }
        }
        return $arrTemp;
    }

    /* This function returns all specified records */

    function getAllRows($tableName = "", $fieldName = "", $value = "", $where = "") {
        $sql = sprintf("SELECT * FROM `%s` WHERE %s = '%s' %s", $tableName, $fieldName, mysql_real_escape_string($value), $where);
        $query = $this->db->query($sql);
        $data = $query->result();
        if ($data) {
            return $data;
        }
        return false;
    }

    function restoreRow($tableName = "", $fieldName = "", $value = "") {
        $updateArr['status'] = '1';
        $updateArr['modified_by'] = $this->phpsession->get('USER_ID');
        $updateArr['modified_date'] = date('Y-m-d H:i:s');
        if (!is_array($value)) {
            $value = explode(",", $value);
        }
        $this->db->where_in($fieldName, $value);
        $data = $this->db->update($tableName, $updateArr);
        if ($data) {
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        }
        return false;
    }

    function removeRow($tableName = "", $fieldName = "", $value = "") {
        $updateArr['status'] = '-1';
        $updateArr['modified_by'] = $this->phpsession->get('USER_ID');
        $updateArr['modified_date'] = date('Y-m-d H:i:s');
        if (!is_array($value)) {
            $value = explode(",", $value);
        }
        $this->db->where_in($fieldName, $value);
        $data = $this->db->update($tableName, $updateArr);
        if ($data) {
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        }
        return false;
    }

    function getFieldData($tabel, $field, $whereStr) {

        if ($field == 'category_name' && $tabel == 'category') {
            $field = 'category_name_' . Do_language::GetSessionLang();
            $sql = "Select $field,category_name_en from $tabel where 1 $whereStr";

            $query = $this->db->query($sql);
            $data = $query->result();

            if (!empty($data[0]->$field)) {
                return @$data[0]->$field;
            } else {
                return @$data[0]->category_name_en;
            }
        } else {
            $sql = "Select $field from $tabel where 1 $whereStr";
            $query = $this->db->query($sql);
            $data = $query->result();
            if ($data) {

                return $data[0]->$field;
            }
        }
    }

    function generatePassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function get_content_by_field($table, $field, $value) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_top_ads_by_id($top_ads_id, $category, $subcategory, $limit_start = null, $limit_end = null) {
        if (!empty($category) && !empty($subcategory)) {
            $find_cat = "FIND_IN_SET(category, category_id) OR FIND_IN_SET(subcategory, category_id)";
        } else if (!empty($category) && empty($subcategory)) {
            $find_cat = "FIND_IN_SET(category, category_id)";
        } else if (empty($category) && !empty($subcategory)) {
            $find_cat = "FIND_IN_SET(subcategory, category_id)";
        }
        if ($limit_start && $limit_end) {
            $lim = "LIMIT $limit_end ,$limit_start";
        }

        if ($limit_start != null) {
            $lim = "LIMIT $limit_end , $limit_start";
        }
        $sql = "SELECT * FROM top_ads,posts WHERE top_ads_id = {$top_ads_id} AND ($find_cat) AND posts.status='Active' AND post_ads_type='single' $lim";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function count_top_ads_by_id($top_ads_id, $category, $subcategory) {

        if (!empty($category) && !empty($subcategory)) {
            $find_cat = "FIND_IN_SET(category, category_id) OR FIND_IN_SET(subcategory, category_id)";
        } else if (!empty($category) && empty($subcategory)) {
            $find_cat = "FIND_IN_SET(category, category_id)";
        } else if (empty($category) && !empty($subcategory)) {
            $find_cat = "FIND_IN_SET(subcategory, category_id)";
        }
        $sql = "SELECT * FROM top_ads,posts WHERE top_ads_id = {$top_ads_id} AND ($find_cat) AND posts.status='Active' AND post_ads_type='single'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function get_single_content_by_field($table, $table_field, $field, $value, $field1, $value1) {
        $this->db->select($table_field);
        $this->db->from($table);
        $this->db->where($field, $value);
        $this->db->where($field1, $value1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_by_field($table, $field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update($table, $data);
    }

    function count_affiliate_email($table, $field, $value) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->num_rows();
    }

}

?>
