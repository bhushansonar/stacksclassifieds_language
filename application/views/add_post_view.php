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

    /*text-decoration: -moz-anchor-decoration;*/


    /*.formate_one{
        width:23%;
                -moz-column-count: 4;
                -webkit-column-count: 4;
        overflow: hidden;
    }*/

</style>
<section class="main_div">
    <div class="main_area">
        <div class="local_hm">
            <ul>
                <li><a href="<?php echo base_url("home") ?>">StacksClassifieds.com</a>>></li>
                <li><a href="<?php echo base_url("ad_type") ?>"><?php echo _clang(POST_AD); ?></a></li>

            </ul>
        </div>
        <h1 class="usa_tit usuptit"><?php echo _clang(CATEGORIES); ?></h1>
        <div class="sub">
            <?php
            for ($i = 0; $i < count($cat); $i++) {
                echo '<div class="four formate_one"><ul>';
                $my_cat_id = $cat[$i]['category_id'];
                if (!empty($post_city_id)) {
                    $multiple = $post_city_id;
                } else {
                    $multiple = $this->uri->segment(3);
                }
                $session_category = !empty($cat[$i]['category_name_' . Do_language::GetSessionLang()]) ? $cat[$i]['category_name_' . Do_language::GetSessionLang()] : $cat[$i]['category_name_en'];
                echo "<li><a href='" . base_url("choose_category/choosecatdata/" . $my_cat_id . "/" . $multiple . "/" . $name) . "'>" . $session_category . "</a>
                </li>";
                echo '</ul></div>';
            }
            ?></div>
    </div>
</section>
