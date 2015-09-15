<style>
    .left{ float: left; width:15%; line-height: 25px; }
    .left_r{ float:left; width:85%;}
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    #title, #email, #confirm_email, #postcode, #location, #selling_price, #contact_number, #age, #price, #fees_paid_by, #salary, #education{ border: 1px solid #ccc; border-radius: 3px; padding: 4px; width: 158px;}

    .pad{
        padding:5px;
    }
    .post_ads {
        background: none repeat scroll 0 0 #ffffff;
        border-radius: 5px;
        /*    display: inline-block;
            float: right;*/
        vertical-align: top;
    }
    .post_info{
        color: #666;
        font: 10pt arial;
    }
    .text_ali{
        text-align: center;

    }
    li a{
        color: #000;
    }

</style>
<section class="main_div">
    <div class="main_area">
        <?php
        if ($this->session->flashdata('flash_message')) {

            echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo '</div>';
        }
        ?>
        <div class="local_hm">
            <ul>
                <li><a href="<?php echo base_url("home") ?>">StacksClassifieds.com</a>>></li>
                <li><a href="<?php echo base_url("ad_type") ?>"><?php echo _clang(POST_AD); ?></a>>></li>
                <li><a href="#"><?php echo $category_name; ?></a>>>
                </li>
                <li>
                    <a href="#"><?php echo $category_name . " " . $sub_category_name; ?></a>
                     <!--<a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                                                                                                                                                                                                                                                                                  ?>"><?php echo $subcategory; ?></a>-->
                </li>
            </ul>
        </div>
        <h3 style="line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
            <?php echo _clang(PREVIEW_AD); ?>
        </h3>
        <ul id="stepButtons">
            <li class="postAdButtonOn">
                <div class="indexSectionHeader"><?php echo _clang(WRITE_ADD_1); ?></div>
            </li>
            <li class="postAdButtonOn">
                <div class="indexSectionHeader"><?php echo _clang(PREVIEW_AD); ?></div>
            </li>
            <li class="postAdButtonOff">
                <div class="indexSectionHeader"><?php echo _clang(CHECK_MAIL_FOR_LINK); ?></div>
            </li>
            <li class="postAdButtonOff">
                <div class="indexSectionHeader"><?php echo _clang(ALL_DONE); ?></div>
            </li>
        </ul>
        <?php
        foreach ($post_ads as $post_ads_detail) {
            $posts_id = $post_ads_detail['posts_id'];
            ?>
            <div class="pad">
                <div  style='display: inline-block;margin-right: 10px;'>
                    <a href='<?php echo base_url("write_add/update/$posts_id") ?>'><?php echo _clang(EDIT); ?></a>
                </div>
                <div style='display: inline-block;margin-left: 10px;'>
                    <?php
                    $attributes = array('class' => 'form-horizontal', 'id' => '');
                    echo validation_errors();
                    if ($post_ads_detail['ads_type'] == 'paid') {
                        echo form_open_multipart('payment/payment_detail', $attributes);
                    } else {
                        echo form_open_multipart('write_add/sending_mail', $attributes);
                    }
                    ?>
                    <?php
                    $net_value = $post_ads_detail['total'];
                    if ($net_value == '0' || $net_value < '0') {
                        $final_price = "1";
                    } else {
                        $final_price = $net_value;
                    }
                    ?>
                    <input type="hidden" name="posts_id" value="<?php echo $post_ads_detail['posts_id'] ?>">
                    <input type="hidden" name="title" value="<?php echo $post_ads_detail['title'] ?>">
                    <input type="hidden" name="email" value="<?php echo $post_ads_detail['email'] ?>">
                    <input type="hidden" name="auto_repost" value="<?php echo $final_price ?>">
                    <input type="hidden" name="featured_ad" value="<?php echo $post_ads_detail['featured_ad'] ?>">
                    <input type='submit' name='submit' value="<?php echo _clang(PLACE_AD_NOW); ?>"/>
                    <?php echo form_close(); ?>
                </div>

            </div>
            <div class='pad'>
                <label>
                    <b><?php echo _clang(CATEGORIES); ?>:</b>
                </label>
                <?php
                echo $category_name;
                ?>
            </div>
            <div class='pad'>
                <label>
                    <b><?php echo _clang(SUB_CATEGORIES); ?>:</b>
                </label>
                <?php echo $sub_category_name; ?>
            </div>
            <div class='pad'>
                <label><b><?php echo _clang(AD_PRICE); ?></b></label>
                <?php
                if ($post_ads_detail['ads_type'] == 'free') {
                    $price = "Free";
                } else {
                    $price = $final_price;
                }
                echo $price;
                ?>
            </div>
            <div class='pad'>
                <label><b><?php echo _clang(METRO_AREA); ?></b></label>
                <?php
                $ci = & get_instance();
                $ci->load->model('post_national_ads_model');
                $where = "city_id IN({$post_ads_detail['city']})";
                $city_opt = $ci->post_national_ads_model->get_city_name_by_id($where);
                foreach ($city_opt as $city) {
                    foreach ($city as $value) {
                        echo $value . ",";
                    }
                }
                ?>
            </div>
            <div class='pad' style='font-size: 20px;'>
                <b><?php echo '<span class="emoji">' . unserialize(base64_decode($post_ads_detail['title'])) . '</span>'; ?></b>
            </div>
            <span class="post_info">
                <?php echo _clang(POSTED); ?> <?php echo date('l, j F, Y g:i A', strtotime($post_ads_detail['date'])); ?>
            </span>
            <hr/>
            <div class='post_view_main'>
                <div class="post_left_other">
                    <?php echo unserialize(base64_decode($post_ads_detail['description'])); ?>
                </div>
                <div class="post_right">

                    <ul>
                        <?php if (!empty($post_ads_detail['image1'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image1']; ?>"><img border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image1']; ?>"></a>
                            </li>

                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image2'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image2']; ?>"><img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image2']; ?>"></a>
        <!--                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image2']; ?>">Enlarge Picture</a>-->
                            </li>

                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image3'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image3']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image3']; ?>"></a>
        <!--                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image3']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image4'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image4']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image4']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image4']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image5'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image5']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image5']; ?>"></a>
        <!--                                <a target="_blank" href="<?php echo base_url(); ?>uploads/<?php echo $post_ads_detail['image5']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image6'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image6']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image6']; ?>"></a>
        <!--                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image6']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image7'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image7']; ?>"> <img border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image7']; ?>"></a>
        <!--                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image7']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image8'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image8']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image8']; ?>"></a>
        <!--                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image8']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image9'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image9']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image9']; ?>"></a>
        <!--                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image9']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image10'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image10']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image10']; ?>"></a>
        <!--                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image10']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image11'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image11']; ?>">
                                    <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image11']; ?>">
                                </a>
        <!--                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image11']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_ads_detail['image12'])) { ?>
                            <li>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image12']; ?>"><img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image12']; ?>"></a>
        <!--                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_ads_detail['image12']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="clearboth"></div>
        <?php } ?>
    </div>
</section>