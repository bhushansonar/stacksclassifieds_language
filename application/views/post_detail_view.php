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
<?php
$ci = & get_instance();
$ci->load->model('post_detail_model');
?>
<section class="main_div">
    <div class="main_area">
        <div >
            <div class="local_hm post_detail_wi">
                <ul>
                    <li><a href="<?php echo base_url("home"); ?>">Home</a>>></li>
                    <li><a ><?php echo $name . " " . $category; ?></a>>></li>
                    <li><a href="<?php echo base_url("heading/$function/$id/$sub_category_id"); ?>"><?php echo $name . " " . $subcategory; ?></a></li>
                </ul>
            </div>
            <div style="display: inline-block">
                <a class="link_btn" href="<?php echo base_url("post_detail/post_ad_reported/" . $posts_id); ?>"><?php echo _clang(REPORT_AD); ?></a>
            </div>
        </div>
        <?php
        for ($i = 0; $i < count($des); $i++) {
            ?>
            <article class="home_local" style="border-bottom: 2px solid #cecdcd">
                <div class="fxtit"><?php echo '<span class="emoji">' . unserialize(base64_decode($des[$i]['title'])) . '</span>'; ?>
                </div>
                <div class = "post_datetit">
                    <?php echo _clang(POSTED) . " " . date('l, F j , Y g:i A', strtotime($des[$i]['date']));
                    ?></div>
            </article>
            <article class="preview_ad_main">
                <figure class="preview_ad_left">
                    <ul>
                        <?php
                        if (!empty($des[$i]['image1'])) {
                            $image1 = base64url_encode($des[$i]['image1']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image1"); ?>">
                                    <img  border="0" class="image_cl" alt="<?php echo $des[$i]['image1']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image1']; ?>">
                                </a>
        <!--                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image1"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image2'])) {
                            $image2 = base64url_encode($des[$i]['image2']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image2"); ?>">
                                    <img border="0" class="image_cl" alt="<?php echo $des[$i]['image2']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image2']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image2"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image3'])) {
                            $image3 = base64url_encode($des[$i]['image3']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image3"); ?>">
                                    <img  border="0" class="image_cl" alt="<?php echo $des[$i]['image3']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image3']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image3"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image4'])) {
                            $image4 = base64url_encode($des[$i]['image4']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image4"); ?>">
                                    <img  border="0" class="image_cl" alt="<?php echo $des[$i]['image4']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image4']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image4"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image5'])) {
                            $image5 = base64url_encode($des[$i]['image5']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image5"); ?>">
                                    <img  border="0" class="image_cl" alt="<?php echo $des[$i]['image5']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image5']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image5"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image6'])) {
                            $image6 = base64url_encode($des[$i]['image6']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image6"); ?>">
                                    <img  border="0" class="image_cl" alt="<?php echo $des[$i]['image6']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image6']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image6"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image7'])) {
                            $image7 = base64url_encode($des[$i]['image7']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image7"); ?>">
                                    <img  border="0" class="image_cl" alt="<?php echo $des[$i]['image7']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image7']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image7"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image8'])) {
                            $image8 = base64url_encode($des[$i]['image8']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image8"); ?>">
                                    <img  border="0" class="image_cl" alt="<?php echo $des[$i]['image8']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image8']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image8"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image9'])) {
                            $image9 = base64url_encode($des[$i]['image9']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image9"); ?>">
                                    <img  border="0" class="image_cl" alt="<?php echo $des[$i]['image9']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image9']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image9"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image10'])) {
                            $image10 = base64url_encode($des[$i]['image10']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image10"); ?>">
                                    <img  border="0"  class="image_cl"alt="<?php echo $des[$i]['image10']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image10']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image10"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image11'])) {
                            $image11 = base64url_encode($des[$i]['image11']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image11"); ?>">
                                    <img  border="0" class="image_cl" alt="<?php echo $des[$i]['image11']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image11']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image11"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($des[$i]['image12'])) {
                            $image12 = base64url_encode($des[$i]['image12']);
                            ?>
                            <li>
                                <a href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image12"); ?>">
                                    <img  border="0"  class="image_cl" alt="<?php echo $des[$i]['image12']; ?>" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $des[$i]['image12']; ?>">
                                </a>
        <!--                                <a  href="<?php echo base_url("full_image/getFullImage/$posts_id/$parent_id/$city_id/$image12"); ?>">Enlarge Picture</a>-->
                            </li>
                        <?php } ?>
                    </ul>
                </figure>

                <figure class="preview_ad_right">
                    <?php
                    $inquery = $des[$i]['inquery'];
                    if ($inquery == 'yes') {
                        ?>
                        <div style="font-size: 17px;">
                            <a class="link_btn" href="<?php echo base_url("reply/email_reply/$posts_id/$parent_id"); ?>"><?php echo _clang(REPLY); ?></a>
                        </div>
                    <?php } ?>
                    <p>
                        <?php echo unserialize(base64_decode($des[$i]['description'])); ?>
                    </p>
                    <div class="sanmnu"><ul>
                            <?php if ($parent_id == 5) { ?>

                                <li><b>Salary/Wage :</b><?php echo $des[$i]['salary']; ?></li>
                                <li><b>Education :</b><?php echo $des[$i]['education']; ?></li>
                                <li><b>Status :</b><?php echo $des[$i]['work_status']; ?></li>
                                <li><?php echo $des[$i]['shift']; ?></li>
                                <!--                                <li>10/18 Los Angeles</li>-->
                            <?php } if ($parent_id == 8) { ?>
                                <li><b>Bedrooms :</b><?php echo $des[$i]['bedrooms']; ?></li>
                            <?php } if ($parent_id == 4 || $parent_id == 11) { ?>
                                <li><b>Poster Age :</b><?php echo $des[$i]['age']; ?></li>
                            <?php } ?>
                            <li>
                                <strong>Location :</strong>
                                <?php
                                $ci = & get_instance();
                                $ci->load->model('common_model');
                                $city_ids = $des[$i]['city'];
                                $city_id_single_quote = "'" . $city_ids . "'";
                                $city_location = str_replace(",", "','", $city_id_single_quote);

                                $where = " AND city_id IN ($city_location)";
                                $city_opt = $ci->common_model->getDDArray('city', 'city_id', 'city_name', $where);

                                foreach ($city_opt as $value) {
                                    $city_option[] = $value;
                                }
                                array_shift($city_option);
                                $post_city = implode(",", $city_option);
                                echo $post_city;
                                ?></li>
                            <?php
                            $mail = $des[$i]['inquery'];
                            if ($mail != 'yes') {
                                ?>
                                <li><b>Mail :</b><?php echo $des[$i]['email']; ?></li>
                            <?php } ?>
                            <li><b>Post ID :</b><?php echo $des[$i]['posts_id']; ?></li>
                        </ul>
                    </div>
                    <div style="font-size: 17px;">
                        <a class="link_btn" href="<?php echo base_url("reply/email_ads/$posts_id/$parent_id"); ?>"><?php echo _clang(EMAIL_THIS_AD); ?></a>
                    </div>
                </figure>
            </article>

        <?php } ?>
    </div>
</section>