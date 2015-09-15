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
    .post_right_ext{
        float: right;
        width: 100%;
    }
    .post_left {
        float: none;
        width: auto;
    }
</style>
<?php
$ci = & get_instance();
$ci->load->model('heading_model');
?>

<section class="main_div">
    <div class="main_area">
        <div class="local_hm" style="margin-bottom: 2%; ">
            <ul>
                <li><a href="<?php echo base_url("home") ?>">Home</a>>></li>
                <li><a ><?php echo $city_name . " " . $category_name; ?></a></li>
                <?php if (!empty($sub_category_id) && !empty($city_id)) {
                    ?>
                    <li>>><a href="<?php echo base_url("heading/getAlltitle/$city_id/$sub_category_id"); ?>"><?php echo $city_name . " " . $sub_category_name; ?></a></li>
                <?php } else { ?>
                    <li></li>
                <?php }
                ?>

            </ul>
        </div>

        <div class="local_hm" style="margin-bottom: 2%; ">
            <ul>
                <li><a  class="inactive" href="<?php //echo base_url("heading/get_all_title_data/{$state_id}/{$sub_category_id}/All");                                                                             ?>">All</a></li>
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
        <div class="local_hm" style="margin-top: 2%">
            <?php
            if ($city_id) {
                $id = $city_id;
                $function = 'getAlltitle';
                $gallery_fun = "gallery_city";
                $summary_fun = "get_summary_city";
            } else {
                $id = $state_id;
                $function = 'get_all_title_data';
                $gallery_fun = "gallery_state";
                $summary_fun = "get_summary_state";
            }
            ?>
            <?php if (!empty($heading_data)) { ?>
                <ul>
                    <li><a href="<?php echo base_url("heading/$function/$id/$sub_category_id") ?>"><?php echo _clang(BRIEF); ?></a>|</li>

                    <?php
                    if ($parent == "4" || $parent == "11") {
                        ?>
                        <li><a href="<?php echo base_url("heading/$gallery_fun/$id/$sub_category_id") ?>"><?php echo _clang(GALLERY); ?></a></li>
                    <?php } else {
                        ?>
                        <li><a href="<?php echo base_url("heading/$summary_fun/$id/$sub_category_id") ?>"><?php echo _clang(SUMMARY); ?></a></li>
                    <?php }
                    ?>

                </ul>
            <?php } ?>
        </div>
        <?php if (!empty($heading_data)) { ?>
            <div style="width: 100%;overflow:hidden">
                <div style="width:80%;float:left;">
                    <?php
                    $samedate = '';
                    for ($i = 0; $i < count($heading_data); $i++) {
                        $postid = $heading_data[$i]['posts_id'];
                        $parent = $heading_data[$i]['category'];
                        ?>
                        <article class="list_main" style="margin: 0">
                            <div class="list_mainrg" style="width: 100%">
                                <div class="list_tital">
                                    <?php if ($samedate != date('Y-m-d', strtotime($heading_data[$i]['date']))) { ?>
                                        <div class="list_titlerg">
                                            <?php
                                            //echo $date = date('D j F, Y', strtotime($heading_data[$i]['date']));
                                            echo $date = date('D .M .d', strtotime($heading_data[$i]['date']));
                                            ?></div>
                                        <?php $samedate = date('Y-m-d', strtotime($heading_data[$i]['date'])); ?>
                                    <?php } ?>
                                    <div class="list_titallf">
                                        <a href="<?php echo base_url("post_detail/getPostdetails/" . $postid . "/" . $parent) ?>"
                                        <?php
                                        $ci = & get_instance();
                                        $ci->load->model('common_model');
                                        $where_postid = " AND posts_id={$postid}";
                                        $location = $ci->common_model->getFieldData('posts', 'location', $where_postid);
                                        echo '<span class="emoji">' . unserialize(base64_decode($heading_data[$i]['title'])) . '</span>';
                                        ?>
                                    </a>&nbsp;
                                    <span style="font-size: 15px; color: #000;"><?php echo (!empty($location) ? "( " . $location . " )" : ""); ?></span>
                                </div>


                            </div>
                        </div>
                    </article>
                    <div class="clear"></div>
                <?php }
                ?>
                <div class="pagination">
                    <?php echo $this->pagination->create_links() ?>
                </div>
            </div>
            <div style="width:20%;float:left;">
                <?php if (!empty($sponser_heading_data)) { ?>

                    <div style='margin: 2%;'>
                        <?php
                        for ($s = 0; $s < count($sponser_heading_data); $s++) {
                            $post = $sponser_heading_data[$s]['posts_id'];
                            $category = $sponser_heading_data[$s]['category'];
                            ?>
                            <div id="topSponsorWrapper">
                                <div style="height:1px;margin:3px 0 0;line-height:1px;">&nbsp;</div>
                                <div class="sponsorBoxPlusImages">
                                    <div class="sponsorBoxContent post_left">
                                        <a href="<?php echo base_url("post_detail/getPostdetails/$post/$category") ?>">
                                            <?php
                                            $titles = substr($sponser_heading_data[$s]['title'], 0, 50);
                                            echo unserialize(base64_decode($titles)) . '...';
                                            ?>
                                        </a>

                                    </div>
                                    <div>
                                        <?php
                                        $description = substr($sponser_heading_data[$s]['description'], 0, 100);
                                        echo unserialize(base64_decode($description)) . '...';
                                        ?>
                                    </div>
                                    <div class="post_right post_right_ext">
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

                        <?php }
                        ?>
                    </div>

                <?php } ?>
            </div>
        </div>
    <?php } else {
        ?>
        <div class='list_mainrg'>
            <h1 style='text-align:center;margin-top: 3%;'>No data available for this category</h1>
            <article class='list_main'>
            </article>
        </div>

    <?php }
    ?>
</div>
</section>
