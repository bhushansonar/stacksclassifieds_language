
<style>
    .inactive{
        cursor: default;
    }
    .pagination {
        height: 36px;
        margin: 18px 0;
        text-align: center;
    }
    .pagination ul {
        display: inline-block;
        *display: inline;
        /* IE7 inline-block hack */

        *zoom: 1;
        margin-left: 0;
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .pagination li {
        display: inline;
    }
    .pagination a {
        float: left;
        padding: 0 14px;
        line-height: 34px;
        text-decoration: none;
        border: 1px solid #ddd;
        border-left-width: 0;
    }
    .pagination a:hover, .pagination .active a {
        background-color: #f5f5f5;
    }
    .pagination .active a {
        color: #999999;
        cursor: default;
    }
    .pagination .disabled a, .pagination .disabled a:hover {
        color: #999999;
        background-color: transparent;
        cursor: default;
    }
    .pagination li:first-child a {
        border-left-width: 1px;
        -webkit-border-radius: 3px 0 0 3px;
        -moz-border-radius: 3px 0 0 3px;
        border-radius: 3px 0 0 3px;
    }
    .pagination li:last-child a {
        -webkit-border-radius: 0 3px 3px 0;
        -moz-border-radius: 0 3px 3px 0;
        border-radius: 0 3px 3px 0;
    }
    .pagination-centered {
        text-align: center;
    }
    .pagination-right {
        text-align: right;
    }
    .pager {
        margin-left: 0;
        margin-bottom: 18px;
        list-style: none;
        text-align: center;
        *zoom: 1;
    }
    .pager:before, .pager:after {
        display: table;
        content: "";
    }
    .pager:after {
        clear: both;
    }
    .pager li {
        display: inline;
    }
    .pager a {
        display: inline-block;
        padding: 5px 14px;
        background-color: #fff;
        border: 1px solid #ddd;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        border-radius: 15px;
    }
    .pager a:hover {
        text-decoration: none;
        background-color: #f5f5f5;
    }
    .pager .next a {
        float: right;
    }
    .pager .previous a {
        float: left;
    }
    .sponsors {
        /*        color: #bbb;*/
        font: 13pt arial;
    }
    #topSponsorWrapper {
        background: none repeat scroll 0 0 #fafad2;
        padding: 6px;
        z-index: 0;
        position: relative;
    }
    #topSponsorWrapper .sponsorBox, #topSponsorWrapper .sponsorBoxPlusImages {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        border: medium none;
        margin-bottom: 0;
    }
    #topSponsorWrapper .sponsorBoxPlusImages {
        height: auto;
        min-height: 42px;
        overflow: hidden;
        position: relative;
    }
    /*    .post_right_ext{
            float: right;
            width: 100%;
        }*/
    .post_left {
        float: none;
        width: auto;
    }
</style>
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
$ci->load->model('heading_model');
?>
<section class="main_div">
    <div class="main_area">
        <?php if (!empty($tit)) { ?>
            <div class="local_hm" style="margin-bottom: 2%;">
                <ul>
                    <li><a href="<?php echo base_url("home") ?>">Home</a>>></li>
                    <li><a ><?php echo $city_name . " " . $category; ?></a>>></li>
                    <li><a href="<?php echo base_url("heading/getAlltitle/$city_id/$sub_category_id") ?>"><?php echo $city_name . " " . $subcategory; ?></a></li>
                </ul>
            </div>
            <div class="local_hm" style="margin-bottom: 2%; ">
                <ul>
                    <li><a  class="active" href="<?php echo base_url("heading/get_all_title_data/{$state}/{$sub_category_id}/All"); ?>">All</a></li>
                    <?php
                    for ($c = 0; $c < count($state_city_name); $c++) {
                        $s_city_id = $state_city_name[$c]['city_id'];
                        if ($city_id == $s_city_id) {
                            $class = "inactive";
                            $herf_content = "#";
                        } else {
                            $class = "active";
                            $herf_content = base_url("heading/getAlltitle/{$s_city_id}/{$sub_category_id}/{$state_city_name[$c]['city_name']}");
                        }
                        ?>
                        <li><a class="<?php echo $class; ?>"href="<?php echo $herf_content ?>"><?php echo $state_city_name[$c]['city_name'] ?> |</a> </li>

                    <?php } ?>
                </ul>
            </div>
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo form_open('heading/get_seraching_data', $attributes);
            ?>
            <div class="search_main">
                <div class="search_key">
                    <div class="key_search">
                        <div class="key_left">
                            <label class="search_tex">Search</label>
                            <input type="text" class="key_in" id="search_text" name="search_text" placeholder="<?php echo _clang(KEYWORD); ?>">
                        </div>
                        <div class="key_right">
                            <?php
                            $attribute = 'id="search_category" class="key_sel"';
                            echo form_dropdown('search_category', $get_subcategory, $sub_category_id, $attribute);
                            ?>
                            <input type="submit" name="submit" class="search_btn" value="search">
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
            <div style="width: 100%;overflow:hidden">
                <div style="width:100%;float:left;">
                    <div class="local_hm" style="margin-top: 2%">
                        <ul>
                            <li><a href="<?php echo base_url("heading/getAlltitle/$city_id/$sub_category_id") ?>"><?php echo _clang(BRIEF); ?></a>|</li>
                            <?php
                            if ($parent == "4" || $parent == "11") {
                                ?>
                                <li><a href="<?php echo base_url("heading/gallery_city/$city_id/$sub_category_id") ?>"><?php echo _clang(GALLERY); ?></a></li>
                            <?php } else {
                                ?>
                                <li><a href="<?php echo base_url("heading/get_summary_city/$city_id/$sub_category_id") ?>"><?php echo _clang(SUMMARY); ?></a></li>
                            <?php }
                            ?>
                        </ul>
                    </div>
                    <?php
                    $samedate = '';
                    for ($i = 0; $i < count($tit); $i++) {
                        $postid = $tit[$i]['posts_id'];
                        $parent = $tit[$i]['category'];
                        ?>
                        <div class="list_titlerg">
                            <?php if ($samedate != date('Y-m-d', strtotime($tit[$i]['date']))) { ?>
                                <div class="list_titlerg">

                                    <?php
                                    echo $date = date('D .M .d', strtotime($tit[$i]['date']));
                                    //echo $date = date('D j F, Y', strtotime($tit[$i]['date']));
                                    ?></div>
                                <?php $samedate = date('Y-m-d', strtotime($tit[$i]['date'])); ?>
                            <?php } ?>
                        </div>
                        <article class="list_main" style="margin: 0">
                <!--                <div class="list_titlerg"><?php echo $date = date('D j F, Y', strtotime($tit[$i]['date'])); ?></div>-->
                            <div>
                                <div class="list_img">
                                    <?php
                                    $image = $tit[$i]['image1'];
                                    $image2 = $tit[$i]['image2'];
                                    $image3 = $tit[$i]['image3'];
                                    $image4 = $tit[$i]['image4'];
                                    $image5 = $tit[$i]['image5'];
                                    $image6 = $tit[$i]['image6'];
                                    $image7 = $tit[$i]['image7'];
                                    $image8 = $tit[$i]['image8'];
                                    $image9 = $tit[$i]['image9'];
                                    $image10 = $tit[$i]['image10'];
                                    $image11 = $tit[$i]['image11'];
                                    $image12 = $tit[$i]['image12'];

                                    if ($image) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image; ?>" alt="">
                                    <?php } elseif ($image2) { ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image2; ?>" alt="">
                                    <?php } elseif ($image3) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image3; ?>" alt="">
                                    <?php } elseif ($image4) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image4; ?>" alt="">
                                    <?php } elseif ($image5) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image5; ?>" alt="">
                                    <?php } elseif ($image6) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image6; ?>" alt="">
                                    <?php } elseif ($image7) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image7; ?>" alt="">
                                    <?php } elseif ($image8) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image8; ?>" alt="">
                                    <?php } elseif ($image9) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image9; ?>" alt="">
                                    <?php } elseif ($image10) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image10; ?>" alt="">
                                    <?php } elseif ($image11) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image11; ?>" alt="">
                                    <?php } elseif ($image12) {
                                        ?>
                                        <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image12; ?>" alt="">
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="list_mainrg list_mainrg_width">
                                    <div class="list_tital">
                                        <div class="list_titallf">
                                            <a href="<?php echo base_url("post_detail/getPostdetails/$postid/$parent") ?>">
                                                <?php
                                                echo '<span class="emoji">' . unserialize(base64_decode($tit[$i]['title'])) . '</span>';
                                                ?>
                                            </a>
                                        </div>


                                    </div>
                                    <!--                                    <div class="read_tex">
                                    <?php //echo $tit[$i]['description'];    ?>
                                                                        </div>-->
                                </div>
                            </div>
                        </article>
                        <div class="clear"></div>
                        <?php
                    }
                    echo '<div class="pagination">' . $this->pagination->create_links() . '</div></div>';
                    echo '<div style="width:100%;float:left;">';
                    if (!empty($sponser_heading_data)) {

                        echo "<div style='margin: 2%;'>
                            ";
                        for ($s = 0; $s < count($sponser_heading_data); $s++) {
                            $post = $sponser_heading_data[$s]['posts_id'];
                            $category = $sponser_heading_data[$s]['category'];
                            ?>
                            <div id="topSponsorWrapper">
                                <div style="height:1px;margin:3px 0 0;line-height:1px;">&nbsp;</div>
                                <div class="sponsorBoxPlusImages">
                                    <div class="sponsorBoxContent post_left">
                                        <a href="<?php echo base_url("post_detail/getPostdetails/$post/$category") ?>">
                                            <?php echo unserialize(base64_decode($sponser_heading_data[$s]['title'])); ?>
                                        </a>

                                    </div>
                                    <div><?php echo unserialize(base64_decode($sponser_heading_data[$s]['description'])); ?></div>
                                    <?php
                                    $img_array = array($sponser_heading_data[$s]['image1'], $sponser_heading_data[$s]['image2'], $sponser_heading_data[$s]['image3'], $sponser_heading_data[$s]['image4'], $sponser_heading_data[$s]['image5'], $sponser_heading_data[$s]['image6'], $sponser_heading_data[$s]['image7'], $sponser_heading_data[$s]['image8'], $sponser_heading_data[$s]['image9'], $sponser_heading_data[$s]['image10'], $sponser_heading_data[$s]['image11'], $sponser_heading_data[$s]['image12']);
                                    for ($img = 0; $img < count($img_array); $img++) {
                                        if (!empty($img_array[$img])) {
                                            $featured_ad_images[] = $img_array[$img];
                                        }
                                    }
                                    $img1 = @$featured_ad_images[0];
                                    $img2 = @$featured_ad_images[1];
                                    $img3 = @$featured_ad_images[2];
                                    ?>

                                    <div class="post_right post_right_ext">
                                        <ul style='list-style: none;margin-top: 1%'>
                                            <?php if (!empty($img1)) { ?>
                                                <li style='padding-bottom: 3px;'>
                                                    <a href="<?php echo base_url("post_detail/getPostdetails/$post/$category") ?>">
                                                        <img width="50"  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo @$featured_ad_images[0]; ?>">
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($img2)) { ?>
                                                <li style='padding-bottom: 3px;'>
                                                    <a href="<?php echo base_url("post_detail/getPostdetails/$post/$category") ?>">
                                                        <img width="50"  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo @$featured_ad_images[1]; ?>">
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($img3)) { ?>
                                                <li style='padding-bottom: 3px;'>
                                                    <a href="<?php echo base_url("post_detail/getPostdetails/$post/$category") ?>">
                                                        <img width="50"  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo @$featured_ad_images[0]; ?>">
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>

                            </div>

                            <?php
                        }
                        echo " </div></div>";
                    }
                } else if (!empty($title)) {
                    ?>
                    <div class="local_hm" style="margin-bottom: 2%; ">
                        <ul>
                            <li><a href="<?php echo base_url("home") ?>">Home</a>>></li>
                            <li><a ><?php echo $state_name . " " . $category; ?></a>>></li>
                            <li><a href="<?php echo base_url("heading/get_all_title_data/$state_id/$sub_category_id") ?>"><?php echo $state_name . " " . $subcategory; ?></a></li>
                        </ul>
                    </div>
                    <div class="local_hm" style="margin-bottom: 2%; ">
                        <ul>
                            <li><a  class="inactive" href="<?php echo base_url("heading/get_all_title_data/{$state_id}/{$sub_category_id}/All"); ?>">All</a></li>
                            <?php
                            for ($s = 0; $s < count($state_city_name); $s++) {
                                $s_city_id = $state_city_name[$s]['city_id'];

                                $class = "active";
                                $herf_content = base_url("heading/getAlltitle/{$s_city_id}/{$sub_category_id}/{$state_city_name[$s]['city_name']}");
                                ?>
                                <li><a class="<?php echo $class; ?>"href="<?php echo $herf_content ?>"><?php echo $state_city_name[$s]['city_name'] ?> |</a> </li>

                            <?php } ?>
                        </ul>
                    </div>
                    <?php
                    $attributes = array('class' => 'form-horizontal', 'id' => '');
                    echo form_open('heading/get_seraching_data', $attributes);
                    ?>
                    <div class="search_main">
                        <div class="search_key">
                            <div class="key_search">
                                <div class="key_left">
                                    <label class="search_tex">Search</label>
                                    <input type="text" class="key_in" id="search_text" name="search_text" placeholder="<?php echo _clang(KEYWORD); ?>">
                                </div>
                                <div class="key_right">
                                    <?php
                                    $attribute = 'id="search_category" class="key_sel"';
                                    echo form_dropdown('search_category', $get_subcategory, $sub_category_id, $attribute);
                                    ?>
                                    <input type="submit" name="submit" class="search_btn" value="search">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <div style="width: 100%;overflow:hidden">
                        <div style="width:100%;float:left;">
                            <div class="local_hm" style="margin-top: 2%">
                                <ul>
                                    <li><a href="<?php echo base_url("heading/get_all_title_data/$state_id/$sub_category_id") ?>"><?php echo _clang(BRIEF); ?></a>|</li>
                                    <?php if ($parent == "4" || $parent == "11") { ?>
                                        <li><a href="<?php echo base_url("heading/gallery_state/$state_id/$sub_category_id") ?>"><?php echo _clang(GALLERY); ?></a></li>
                                    <?php } else { ?>
                                        <li><a href="<?php echo base_url("heading/get_summary_state/$state_id/$sub_category_id") ?>"><?php echo _clang(SUMMARY); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php
                            $samedate = "";
                            for ($i = 0; $i < count($title); $i++) {
                                $postid = $title[$i]['posts_id'];
                                $parent = $title[$i]['category'];
                                ?>
                                <div class="list_titlerg">
                                    <?php if ($samedate != date('Y-m-d', strtotime($title[$i]['date']))) { ?>
                                        <div class="list_titlerg">
                                            <?php
                                            echo $date = date('D .M .d', strtotime($title[$i]['date']));
                                            //echo $date = date('D j F, Y', strtotime($title[$i]['date']));
                                            ?></div>
                                        <?php $samedate = date('Y-m-d', strtotime($title[$i]['date'])); ?>
                                    <?php } ?>
                                </div>
                                <article class="list_main">

                                    <div>
                                        <div class="list_img">
                                            <?php
                                            $image = $title[$i]['image1'];
                                            $image2 = $title[$i]['image2'];
                                            $image3 = $title[$i]['image3'];
                                            $image4 = $title[$i]['image4'];
                                            $image5 = $title[$i]['image5'];
                                            $image6 = $title[$i]['image6'];
                                            $image7 = $title[$i]['image7'];
                                            $image8 = $title[$i]['image8'];
                                            $image9 = $title[$i]['image9'];
                                            $image10 = $title[$i]['image10'];
                                            $image11 = $title[$i]['image11'];
                                            $image12 = $title[$i]['image12'];

                                            if ($image) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image; ?>" alt="">
                                            <?php } elseif ($image2) { ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image2; ?>" alt="">
                                            <?php } elseif ($image3) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image3; ?>" alt="">
                                            <?php } elseif ($image4) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image4; ?>" alt="">
                                            <?php } elseif ($image5) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image5; ?>" alt="">
                                            <?php } elseif ($image6) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image6; ?>" alt="">
                                            <?php } elseif ($image7) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image7; ?>" alt="">
                                            <?php } elseif ($image8) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image8; ?>" alt="">
                                            <?php } elseif ($image9) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image9; ?>" alt="">
                                            <?php } elseif ($image10) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image10; ?>" alt="">
                                            <?php } elseif ($image11) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image11; ?>" alt="">
                                            <?php } elseif ($image12) {
                                                ?>
                                                <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image12; ?>" alt="">
                                            <?php } ?>
                                        </div>
                                        <div class="list_mainrg list_mainrg_width">
                                            <div class="list_tital">
                                                <div class="list_titallf">
                                                    <a href="<?php echo base_url("post_detail/getPostdetails/$postid/$parent") ?>">
                                                        <?php
                                                        echo '<span class="emoji">' . unserialize(base64_decode($title[$i]['title'])) . '</span>';
                                                        ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <!--                                            <div class="read_tex">
                                            <?php //echo $title[$i]['description'];     ?>
                                                                                        </div>-->
                                        </div>
                                    </div>
                                </article>
                                <div class="clear"></div>
                                <?php
                            }
                            echo '<div class="pagination">' . $this->pagination->create_links() . '</div></div>';
                            echo '<div style="width:100%;float:left;">';
                            if (!empty($sponser_heading_data)) {

                                echo "<div style='margin: 2%;'>
                                    ";
                                for ($s = 0; $s < count($sponser_heading_data); $s++) {
                                    $post = $sponser_heading_data[$s]['posts_id'];
                                    $category = $sponser_heading_data[$s]['category'];
                                    ?>
                                    <div id="topSponsorWrapper">
                                        <div style="height:1px;margin:3px 0 0;line-height:1px;">&nbsp;</div>
                                        <div class="sponsorBoxPlusImages">
                                            <div class="sponsorBoxContent post_left">
                                                <a href="<?php echo base_url("post_detail/getPostdetails/$post/$category") ?>">
                                                    <?php echo unserialize(base64_decode($sponser_heading_data[$s]['title'])); ?>
                                                </a>

                                            </div>
                                            <div><?php echo unserialize(base64_decode($sponser_heading_data[$s]['description'])); ?></div>
                                            <?php
                                            $img_array = array($sponser_heading_data[$s]['image1'], $sponser_heading_data[$s]['image2'], $sponser_heading_data[$s]['image3'], $sponser_heading_data[$s]['image4'], $sponser_heading_data[$s]['image5'], $sponser_heading_data[$s]['image6'], $sponser_heading_data[$s]['image7'], $sponser_heading_data[$s]['image8'], $sponser_heading_data[$s]['image9'], $sponser_heading_data[$s]['image10'], $sponser_heading_data[$s]['image11'], $sponser_heading_data[$s]['image12']);
                                            for ($img = 0; $img < count($img_array); $img++) {
                                                if (!empty($img_array[$img])) {
                                                    $featured_ad_images[] = $img_array[$img];
                                                }
                                            }
                                            $img1 = @$featured_ad_images[0];
                                            $img2 = @$featured_ad_images[1];
                                            $img3 = @$featured_ad_images[2];
                                            ?>

                                            <div class="post_right post_right_ext">
                                                <ul style='list-style: none;margin-top: 1%'>
                                                    <?php if (!empty($img1)) { ?>
                                                        <li style='padding-bottom: 3px;'>
                                                            <a href="<?php echo base_url("post_detail/getPostdetails/$post/$category") ?>">
                                                                <img width="50"  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo @$featured_ad_images[0]; ?>">
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if (!empty($img2)) { ?>
                                                        <li style='padding-bottom: 3px;'>
                                                            <a href="<?php echo base_url("post_detail/getPostdetails/$post/$category") ?>">
                                                                <img width="50"  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo @$featured_ad_images[1]; ?>">
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if (!empty($img3)) { ?>
                                                        <li style='padding-bottom: 3px;'>
                                                            <a href="<?php echo base_url("post_detail/getPostdetails/$post/$category") ?>">
                                                                <img width="50"  border="0" alt="" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo @$featured_ad_images[0]; ?>">
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>

                                    <?php
                                }
                                echo " </div></div>";
                            }
                        } else {
                            $attributes = array('class' => 'form-horizontal', 'id' => '');
                            echo form_open('heading/get_seraching_data', $attributes);
                            ?>
                            <div class="search_main">
                                <div class="search_key">
                                    <div class="key_search">
                                        <div class="key_left">
                                            <label class="search_tex">Search</label>
                                            <input type="text" class="key_in" id="search_text" name="search_text" placeholder="<?php echo _clang(KEYWORD); ?>">
                                        </div>
                                        <div class="key_right">
                                            <?php
                                            $attribute = 'id="search_category" class="key_sel"';
                                            echo form_dropdown('search_category', $get_subcategory, $sub_category_id, $attribute);
                                            ?>
                                            <input type="submit" name="submit" class="search_btn" value="search">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class='list_mainrg' style='width:100%;'>
                                <h1 style='text-align:center;margin-top: 3%;'>No data available for this category </h1>
                                <article class='list_main'>
                                </article>
                            </div>

                        <?php }
                        ?>
                    </div>
                    </section>