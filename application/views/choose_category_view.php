<div class="set_errors">
    <?php
    if ($this->session->flashdata('validation_error_messages')) {
        echo $this->session->flashdata('validation_error_messages');
    }
    echo validation_errors();
    if ($this->session->flashdata('flash_message')) {

        echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
        echo '<a class="close" data-dismiss="alert">&#215;</a>';
        echo $this->session->flashdata("flash_message");
        echo '</div>';
    }
    ?>
</div>
<style>


</style>
<section class="main_div">
    <div class="main_area">
        <div class="local_hm">
            <ul>
                <li><a href="<?php echo base_url("home") ?>">StacksClassifieds.com</a>>></li>
                <li><a href="<?php echo base_url("ad_type") ?>"><?php echo _clang(POST_AD); ?></a>>></li>
                <li><a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                                          ?>"><?php echo $category; ?></a></li>
            </ul>
        </div>
        <h1 class="usa_tit usuptit"><?php echo _clang(SUB_CATEGORIES); ?></h1>
        <div class="sub">
            <?php
            $ci = & get_instance();
            $ci->load->model('common_model');
            if (!empty($cat)) {
                for ($i = 0; $i < count($cat); $i++) {
                    echo '<div class="four ext"> <ul>';
                    $cat_id = $cat[$i]['category_id'];
                    $where_check_adult = " AND category_id={$cat_id}";
                    $check_adult = $ci->common_model->getFieldData("category", "is_adult", $where_check_adult);
                    $session_sub_category = !empty($cat[$i]['category_name_' . Do_language::GetSessionLang()]) ? $cat[$i]['category_name_' . Do_language::GetSessionLang()] : $cat[$i]['category_name_en'];
                    if ($city_id == 'multiple') {
                        $subcategory1 = str_replace("&", "_", $cat[$i]['category_name_' . Do_language::GetSessionLang()]);
                        $subcategory = preg_replace('/\s+/', '', $subcategory1);

                        if ($check_adult == "YES") {
                            echo "<li><a href='" . base_url("warning/warning_multiple_city/$cat_id/$subcategory") . "'>" . $session_sub_category . "</a>
                    </li>";
                        } else {
                            echo "<li><a href='" . base_url("multiple_city/city_multiple/$cat_id/$subcategory") . "'>" . $session_sub_category . "</a>
                    </li>";
                        }
                    } else {
                        echo "<li><a href='" . base_url("choose_location/index/$cat_id/$city_id/$name") . "'>
                        " . $session_sub_category . "</a>
                            </li>";
                    }
                    echo '</ul></div>';
                }
            } else {
                echo "<h1 style='font-size: 20px;text-align: center;'>There is no subcategory for this </h1>";
            }
            ?>
        </div>
    </div>
</section>