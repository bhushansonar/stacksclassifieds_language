<style>
    .left{ float: left; width:15%; line-height: 25px; }
    .left_r{ float:left; width:85%;}
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    #title, #email, #confirm_email, #postcode, #location, #selling_price, #contact_number, #age, #price, #fees_paid_by, #salary, #education{ border: 1px solid #ccc; border-radius: 3px; padding: 4px; width: 158px;}

    .pad{
        padding:5px;
        margin-top: 1%;
        font-size: 18px;
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

        <div class="local_hm" style="display: inline-block;width: 87%">
            <ul>
                <li><a href="<?php echo base_url("home"); ?>"> <?php echo _clang(HOME); ?></a>>></li>
                <li><a ><?php echo $category_name; ?></a>></li>
                <li><a href="<?php echo base_url("heading/getAlltitle/$city/$subcategory"); ?>"><?php echo $sub_category_name; ?></a></li>
            </ul>
        </div>
        <div>
            <div style="display: inline-block;">
                <h3 style="line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
                    <?php echo _clang(AD_MANAGEMENT); ?>
                </h3>
            </div>
            <?php if (!$this->session->userdata('is_logged_in')) { ?>
                <div style="display: inline-block; float: right; margin-top: 2%;background-color: #fafad2;border: 1px solid #e9e93a;padding: 3px;">
                    <a href="<?php echo base_url("signin/signin_user"); ?>"><?php echo _clang(MY_ACCOUNT); ?></a>
                </div>
            <?php } ?>

        </div>
        <?php
        foreach ($post_ads as $post_ads_detail) {
            ?>
            <div class='pad'>
                <div style='display: inline-block;margin-right: 10px;'>
                    <a href='<?php echo base_url("write_add/update/$posts_id") ?>'><?php echo _clang(EDIT); ?></a>
                </div>
            </div>
            <div class='pad'>
                <div style='display: inline-block;margin-right: 10px;'>
                    <a href='<?php echo base_url("manage_ad_list/move_post_ad/$posts_id") ?>'><?php echo _clang(MOVE); ?></a> <?php echo _clang(TOP_AD); ?>
                </div>
            </div>
            <div class='pad'>
                <label>
                    <b> <?php echo _clang(PURCHASE); ?></b>
                </label>
                <div style="display: inline-block">
                    <a href="<?php echo base_url("manage_ad_list/purchase_sponsor_ad_post/$posts_id") ?>"><?php echo _clang(SPONSOR_AD); ?></a>
                </div>
                <div style="display: inline-block">
                    <a href="<?php echo base_url("manage_ad_list/purchase_auto_re_post/$posts_id") ?>"><?php echo _clang(AUTO_RE_POST); ?></a>
                </div>

            </div>

            <!--            <div class='pad'>
                            <label>
                                <b> <a href="<?php echo base_url("manage_ad_list/delete_ad/$posts_id") ?>"><?php echo _clang(DELETE); ?></a> <?php echo _clang(YOUR_AD); ?></b>
                        </div>-->
            <div class='pad'>
                <div style="display: inline-block">
                    <label>
                        <b><a href="<?php echo base_url("post_detail/getPostdetails/$posts_id/$category/$city") ?>"><?php echo _clang(VIEW); ?></a> <?php echo _clang(YOUR_AD); ?></b></label>
                    </label>

                </div>
                <div style="float: right;margin-top: 2%;border: 1px solid #000;padding: 3px; display: inline-block">
                    <?php echo _clang(AD_EXPIRES); ?> <?php echo date('d/m/Y', strtotime($post_ads_detail['expire_date'])); ?>
                </div>
            </div>
            <div class='pad' style='font-size: 25px;'>
                <b>
                    <?php echo unserialize(base64_decode($post_ads_detail['title'])); ?>
                </b>
            </div>

            <span class="post_info">
                <?php echo _clang(POSTED); ?><?php echo date('D, j F Y,g:i a', strtotime($post_ads_detail['date'])); ?>
            </span>
            <hr/>
            <div class='pad'>
                <div class="detail_left_inner">
                    <?php if ($post_ads_detail['inquery'] == 'yes') { ?>
                        <div style="margin-top: 2%">
                            <a class="link_btn" href="<?php echo base_url("reply/email_reply/$posts_id/$category"); ?>"><?php echo _clang(REPLY); ?></a>
                        </div>
                    <?php } ?>
                    <div style="margin-top: 2%"> <?php echo unserialize(base64_decode($post_ads_detail['description'])); ?></div>
                    <div style="margin-top: 2%">
                        <label><?php echo _clang(WRITE_ADD_LOCATION); ?>:</label>
                        <?php echo $post_ads_detail['location']; ?>

                    </div>
                    <div style="margin-top: 2%">
                        <a class="link_btn" href="<?php echo base_url("reply/email_ads/$posts_id/$category"); ?>"><?php echo _clang(EMAIL_THIS_AD); ?></a>
                    </div>
                </div>
                <div class="detil_right_inner">
                    <ul style='list-style: none; display: inline'>
                        <?php
                        if (!empty($post_ads_detail['image1'])) {

                            $image1 = base64url_encode($post_ads_detail['image1']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image1"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image1'] ?>"></a>
                                </div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image1"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } else { ?>
                            <li></li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image2'])) {
                            $image2 = base64url_encode($post_ads_detail['image2']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image2"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image2']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image2"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image3'])) {
                            $image3 = base64url_encode($post_ads_detail['image3']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image3"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image3']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image3"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image4'])) {
                            $image4 = base64url_encode($post_ads_detail['image4']);
                            ?>
                            <li class="man_ad_view" >
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image4"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image4']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image4"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image5'])) {
                            $image5 = base64url_encode($post_ads_detail['image5']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image4"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image5']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image5"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image6'])) {
                            $image6 = base64url_encode($post_ads_detail['image6']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image6"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image6']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image6"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image7'])) {
                            $image7 = base64url_encode($post_ads_detail['image7']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image7"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image7']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image7"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image8'])) {
                            $image8 = base64url_encode($post_ads_detail['image8']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image8"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image8']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image8"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image9'])) {
                            $image9 = base64url_encode($post_ads_detail['image9']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image9"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image9']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image9"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image10'])) {
                            $image10 = base64url_encode($post_ads_detail['image10']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image10"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image10']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image10"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image11'])) {
                            $image11 = base64url_encode($post_ads_detail['image11']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image11"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image11']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image11"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($post_ads_detail['image12'])) {
                            $image12 = base64url_encode($post_ads_detail['image12']);
                            ?>
                            <li class="man_ad_view">
                                <div><a href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image12"); ?>">
                                        <img class="man_ad_view_image" border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $post_ads_detail['image12']; ?>">
                                    </a></div>
                                <div class="man_ad_content"><a style="display: inline-flex" href="<?php echo base_url("full_image/getFullImage/$posts_id/$category/$city/$image12"); ?>"><?php echo _clang(ENLARGE_PIC); ?></a></div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

        <?php } ?>
    </div>
</section>

