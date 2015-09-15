<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/gallery.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/gallery_media.css">
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

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
                            <!--                            <label class="search_tex">Search</label>-->
                            <input type="text" class="key_in" id="search_text" name="search_text" placeholder="keyword">
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
                <div class="gallery_left">
                    <div class="local_hm" style="margin-top: 2%;margin-bottom: 2%">
                        <ul>
                            <li><a href="<?php echo base_url("heading/getAlltitle/$city_id/$sub_category_id") ?>">brief</a>|</li>
                            <li><a href="<?php echo base_url("heading/gallery_state/$city_id/$sub_category_id") ?>">gallery</a></li>
                        </ul>
                    </div>
                    <?php
                    $samedate = '';
                    for ($i = 0; $i < count($tit); $i++) {
                        $gellary_img = array();
                        $count = 0;

                        $postid = $tit[$i]['posts_id'];
                        $parent = $tit[$i]['category'];
                        ?>
                        <?php
                        $img_array = array($tit[$i]['image1'], $tit[$i]['image2'], $tit[$i]['image3'], $tit[$i]['image4'], $tit[$i]['image5'], $tit[$i]['image6'], $tit[$i]['image7'], $tit[$i]['image8'], $tit[$i]['image9'], $tit[$i]['image10'], $tit[$i]['image11'], $tit[$i]['image12']);

                        for ($img = 0; $img < count($img_array); $img++) {
                            if (!empty($img_array[$img]) && $img_array[$img] != '0') {
                                $gellary_img[] = $img_array[$img];
                                if (!empty($img_array[$img])) {
                                    $count++;
                                }
                                //$gellary_img_count[] = count($img_array);
                            }
                        }
                        ?>

                        <div class="cat gallery">
                            <div style="display: none;" class="galleryOverlay">
                                <a href="<?php echo base_url("post_detail/getPostdetails/$postid/$parent") ?>">

                                    <?php for ($w = 0; $w < count($gellary_img); $w++) { ?>
                                        <img style="left: 0px; display: block;" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $gellary_img[$w]; ?>" alt="">
                                    <?php }
                                    ?>

                                    <div class = "galleryDots">
                                        <?php
                                        for ($dot = 1; $dot < $count; $dot++) {
                                            if ($dot == 1) {
                                                $class = "class='active'";
                                            } else {
                                                $class = "";
                                            }
                                            ?>
                                            <span <?php echo $class ?>>•</span>
                                        <?php }
                                        ?>
                                    </div>
                                </a>
                            </div>
                            <div class="galleryImgCont gallery_z-index">
                                <a class="galleryImage"  href="<?php echo base_url("post_detail/getPostdetails/$postid/$parent") ?>">
                                    <img  src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo @$gellary_img[0]; ?>" alt="">
                                </a>
                            </div>
                            <div class="galleryHeader">
                                <a href="<?php echo base_url("post_detail/getPostdetails/$postid/$parent") ?>">
                                    <?php echo unserialize(base64_decode($tit[$i]['title'])); ?>
                                </a>
                            </div>
                            <div class="galleryPosted"><?php echo date('D. M. j, g:i A', strtotime($tit[$i]['date'])); ?></div>
                        </div>
                    <?php }
                    ?>
                    <div class="clearboth"></div>
                    <?php
                    echo '<div class="pagination">' . $this->pagination->create_links() . '</div></div>';
                    echo '<div class="gallery_right">';
                    if (!empty($sponser_heading_data)) {

                        echo "<div>";
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
                                    <input type="text" class="key_in" id="search_text" name="search_text" placeholder="Enter your keyword here">
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
                                    <li><a href="<?php echo base_url("heading/get_all_title_data/$state_id/$sub_category_id") ?>">brief</a>|</li>
                                    <li><a href="<?php echo base_url("heading/gallery_state/$state_id/$sub_category_id") ?>">gallery</a></li>
                                </ul>
                            </div>
                            <?php
                            $samedate = "";
                            for ($i = 0; $i < count($title); $i++) {
                                $gellary_img = array();
                                $count = 0;
                                $postid = $title[$i]['posts_id'];
                                $parent = $title[$i]['category'];
                                ?>
                                <?php
                                $img_array = array($title[$i]['image1'], $title[$i]['image2'], $title[$i]['image3'], $title[$i]['image4'], $title[$i]['image5'], $title[$i]['image6'], $title[$i]['image7'], $title[$i]['image8'], $title[$i]['image9'], $title[$i]['image10'], $title[$i]['image11'], $title[$i]['image12']);

                                for ($img = 0; $img < count($img_array); $img++) {
                                    if (!empty($img_array[$img]) && $img_array[$img] != '0') {
                                        $gellary_img[] = $img_array[$img];
                                        if (!empty($img_array[$img])) {
                                            $count++;
                                        }
                                        //$gellary_img_count[] = count($img_array);
                                    }
                                }
                                ?>

                                <div class="cat gallery">
                                    <div style="display: none;" class="galleryOverlay">
                                        <a href="<?php echo base_url("post_detail/getPostdetails/$postid/$parent") ?>">

                                            <?php for ($w = 0; $w < count($gellary_img); $w++) { ?>
                                                <img style="left: 0px; display: block;" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $gellary_img[$w]; ?>" alt="">
                                            <?php }
                                            ?>

                                            <div class = "galleryDots">
                                                <?php
                                                for ($dot = 1; $dot < $count; $dot++) {
                                                    if ($dot == 1) {
                                                        $class = "class='active'";
                                                    } else {
                                                        $class = "";
                                                    }
                                                    ?>
                                                    <span <?php echo $class ?>>•</span>
                                                <?php }
                                                ?>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="galleryImgCont gallery_z-index">
                                        <a class="galleryImage"  href="<?php echo base_url("post_detail/getPostdetails/$postid/$parent") ?>">
                                            <img  src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo @$gellary_img[0]; ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="galleryHeader">
                                        <a href="<?php echo base_url("post_detail/getPostdetails/$postid/$parent") ?>">
                                            <?php echo unserialize(base64_decode($title[$i]['title'])) ?>
                                        </a>
                                    </div>
                                    <div class="galleryPosted"><?php echo date('D. M. j, g:i A', strtotime($title[$i]['date'])); ?></div>
                                </div>

                            <?php }
                            ?>
                        </div>
                        <div class="clearboth"></div>
                        <div class="pagination"><?php echo $this->pagination->create_links(); ?> </div>

                        <div style="width:100%;float:left;">
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
                                                        echo unserialize(base64_decode($sponser_heading_data[$s]['title']));
                                                        ?>
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

                                    <?php }
                                    ?>
                                </div></div>
                            <?php
                        }
                    } else {
                        $attributes = array('class' => 'form-horizontal', 'id' => '');
                        echo form_open('heading/get_seraching_data', $attributes);
                        ?>

                        <div class="search_main">
                            <div class="search_key">
                                <div class="key_search">
                                    <div class="key_left">
                                        <!--                            <label class="search_tex">Search</label>-->
                                        <input type="text" class="key_in" id="search_text" name="search_text" placeholder="keyword">
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
                        <?php
                    }
                    ?>
                </div>
                </section>