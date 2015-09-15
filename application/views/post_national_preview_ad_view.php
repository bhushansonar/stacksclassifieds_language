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
</style>
<section class="main_div">
    <div class="main_area">
        <div class="local_hm">
            <ul>
                <li><a href="<?php echo base_url("home") ?>">StacksClassifieds.com</a>>></li>
                <li><a href="<?php echo base_url("ad_type") ?>"><?php echo _clang(POST_AD); ?></a>>></li>
                <li><a href="#"><?php echo $category_name; ?></a>>>
                </li>
                <li>
                    <a href="#"><?php echo $category_name . " " . $subcategory; ?></a>
                     <!--<a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                                                                                                                                                                                                    ?>"><?php echo $subcategory; ?></a>-->
                </li>
            </ul>
        </div>
        <h2 style="line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
            <?php echo _clang(PREVIEW_AD); ?>
        </h2>
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
        <h2 style="margin-bottom: 20px;">
            <?php echo _clang(PREVIEW_AD_TEXT); ?>
        </h2>
        <?php
        foreach ($post_national_ads as $post_national) {
            $posts_id = $post_national['posts_id'];
            ?>
            <div class='pad'>
                <div style='display: inline-block;margin-right: 10px;'>
                    <a href='<?php echo base_url("post_national_ads/update/$posts_id") ?>'><?php echo _clang(EDIT); ?></a>
                </div>

                <div style='display: inline-block;margin-left: 10px;'>
                    <?php
                    $attributes = array('class' => 'form-horizontal', 'id' => '');
                    echo validation_errors();
                    echo form_open_multipart('payment/payment_detail', $attributes);

                    $net_value = "0";
                    $net_value = $post_national['total'];

                    if ($net_value == '0' || $net_value < '0') {
                        $final_price = "1";
                    } else {
                        $final_price = $net_value;
                    }
                    ?>
                    <input type="hidden" name="posts_id" value="<?php echo $post_national['posts_id'] ?>">
                    <input type="hidden" name="auto_repost" value="<?php echo $final_price ?>">
                    <input type='submit' name='submit' value='<?php echo _clang(PLACE_AD_NOW); ?>'/>
                    <?php echo form_close(); ?>
                </div>

            </div>

            <div class='pad'>
                <label>
                    <b><?php echo _clang(SECTION); ?></b>
                </label>
                <?php
                echo @$category_opt[$post_national['category']];
                ?>
            </div>
            <div class='pad'>
                <label>
                    <b> <?php echo _clang(CATEGORIES); ?>:</b>
                </label>

                <?php echo @$category_opt[$post_national['subcategory']]; ?>
            </div>

            <div class='pad'>
                <label><b><?php echo _clang(AD_PRICE); ?></b></label>
                <?php echo "$ " . $final_price; ?>
            </div>
            <div class='pad'>
                <label><b><?php echo _clang(METRO_AREA); ?></b></label>
                <?php
                $ci = & get_instance();
                $ci->load->model('post_national_ads_model');
                if (empty($post_national['city'])) {
                    $city = "0";
                } else {
                    $city = $post_national['city'];
                }
                $where = "city_id IN({$city})";
                $city_opt = $ci->post_national_ads_model->get_city_name_by_id($where);

                foreach ($city_opt as $city) {
                    foreach ($city as $value) {
                        echo $value . ",";
                    }
                }
                ?>
            </div>
            <div class='pad' style='font-size: 20px;'>
                <b>
                    <?php echo '<span class="emoji">' . unserialize(base64_decode($post_national['title'])) . '</span>'; ?>

                </b>
            </div>
            <span class="post_info">
                <?php echo _clang(POSTED); ?> <?php echo date('l, j F, Y g:i A', strtotime($post_national['date'])); ?>

            </span>
            <hr/>

            <div class='post_view_main'>
                <div style="font-size: 17px;">
                    <?php
                    $posts_id = $post_national['posts_id'];
                    $category_id = $post_national['category'];
                    ?>
    <!--                    <b>Reply:</b> <a href="<?php echo base_url("reply/email_reply/$posts_id/$category_id"); ?>">click here</a>-->
                </div>
                <div class="post_left_other">
                    <?php echo unserialize(base64_decode($post_national['description'])); ?>
                </div>
                <div class="post_right">

                    <ul style='list-style: none;'>
                        <?php if (!empty($post_national['image1'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image1']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image1']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image1']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image2'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image2']; ?>"><img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image2']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image2']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image3'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image3']; ?>"> <img border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image3']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image3']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image4'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image4']; ?>"> <img border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image4']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image4']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image5'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image5']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image5']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image5']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image6'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image6']; ?>"><img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image6']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image6']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image7'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image7']; ?>"><img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image7']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image7']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image8'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image8']; ?>"><img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image8']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image8']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image9'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image9']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image9']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image9']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image10'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image10']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image10']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image10']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image11'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image11']; ?>"> <img  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image11']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image11']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                        <?php if (!empty($post_national['image12'])) { ?>
                            <li style='padding-bottom: 3px;'>
                                <a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image12']; ?>"><img border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national['image12']; ?>"></a>
                                <!--<a target="_blank" href="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_national['image12']; ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } else { ?>

                        <?php } ?>
                    </ul>


                </div>

            </div>
        <?php } ?>
    </div>
</section>