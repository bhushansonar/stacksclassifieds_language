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
    /*    .four ul li a{
            font-size: 16;
        }*/

</style>
<section class="main_div">
    <div class="main_area">
        <div class="local_hm" style="margin-bottom: 2%">
            <ul>
                <li><a href="<?php echo base_url("home") ?>">StacksClassifieds.com</a>>></li>
                <li><a href="<?php echo base_url("ad_type") ?>">post ad</a>>></li>
                <li><a href="#"><?php echo $category; ?></a>>>
                </li>
                <li>
                    <a href="#"><?php echo $subcategory; ?></a>
                     <!--<a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")          ?>"><?php echo $subcategory; ?></a>-->
                </li>
            </ul>
        </div>
        <div class="sub">
            <?php
            $ci = & get_instance();
            $ci->load->model('choose_location_model');
            for ($i = 0; $i < count($content); $i++) {
                $country_opt = $ci->choose_location_model->get_country("country_id", $content[$i]['country_id']);
                ?>
                <div class="four formate_one">
                    <ul>
                        <?php
                        $get_city_id = $content[$i]['city_id'];
                        ?>
                        <li>
                            <a href="<?php echo base_url("warning/warning_data/" . $get_city_id . "/" . $content[$i]['city_name']) ?>">
                                <?php echo $content[$i]['city_name']; ?>
                            </a>
                        </li>
                        <?php
                        ?>
                    </ul>
                </div>

            <?php }
            ?></div>
    </div>
</section>