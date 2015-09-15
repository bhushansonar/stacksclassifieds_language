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
            <div class="local_hm" style="margin-bottom: 2%; ">
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
                            <input type="text" class="key_in" id="search_text" name="search_text" placeholder="<?php echo _clang(KEYWORD); ?>">
                        </div>
                        <!--                        <div class="key_right">
                        <?php
                        $attribute = 'id="search_category" class="key_sel"';
                        echo form_dropdown('search_category', $get_subcategory, $sub_category_id, $attribute);
                        ?>
                                                    <input type="submit" name="submit" class="search_btn" value="search">
                                                </div>-->

                        <div class="key_right">
                            <select class="key_sel" id="search_category" name="search_category">
                                <!--                                <option  value="">Select</option>-->
                                <?php for ($i = 0; $i < count($all_sub_cat); $i++) { ?>
                                    <option <?php echo ($all_sub_cat[$i]['category_id'] == $sub_category_id) ? 'selected="selected"' : "" ?> value="<?php echo $all_sub_cat[$i]['category_id'] ?>"><?php echo (!empty($all_sub_cat[$i]['category_name_' . Do_language::GetSessionLang()]) ? $all_sub_cat[$i]['category_name_' . Do_language::GetSessionLang()] : $all_sub_cat[$i]['category_name_en'] ) ?></option>
                                <?php } ?>
                            </select>
                            <input type="submit" name="submit" class="search_btn" value="search">
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>

            <div style="width: 100%;overflow:hidden">
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
                <div class="heading_left">
                    <?php
                    $samedate = '';
                    for ($i = 0; $i < count($tit); $i++) {
                        $postid = $tit[$i]['posts_id'];
                        $parent = $tit[$i]['category'];
                        ?>
                        <article class="list_main">
                            <div class="list_mainrg">
                                <div class="list_tital">
                                    <?php //echo date('Y-m-d', strtotime($tit[$i]['date']));   ?>
                                    <?php if ($samedate != date('Y-m-d', strtotime($tit[$i]['date']))) { ?>
                                        <div class="list_titlerg">
                                            <?php
                                            //echo $date = date('D j F, Y', strtotime($tit[$i]['date']));
                                            echo $date = date('D .M .d', strtotime($tit[$i]['date']));
                                            ?></div>
                                        <?php $samedate = date('Y-m-d', strtotime($tit[$i]['date'])); ?>
                                    <?php } ?>
                                    <div class="list_titallf">
                                        <a href="<?php echo base_url("post_detail/getPostdetails/" . $postid . "/" . $parent) ?>"
                                        <?php
                                        $ci = & get_instance();
                                        $ci->load->model('common_model');
                                        $where_postid = " AND posts_id={$postid}";
                                        $location = $ci->common_model->getFieldData('posts', 'location', $where_postid);
                                        echo '<span class="emoji">' . unserialize(base64_decode($tit[$i]['title'])) . '</span>';
                                        ?>
                                    </a>&nbsp;
                                    <span style="font-size: 15px; color: #000;"><?php echo (!empty($location) ? "( " . $location . " )" : ""); ?></span>
                                </div>


                            </div>
                        </div>
                    </article>

                    <?php
                }
                echo '<div class="pagination">' . $this->pagination->create_links() . '</div></div>';
                echo '<div class="heading_right">';
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
                                        <?php
                                        $sponser_title = $sponser_heading_data[$s]['title'];
                                        $titles = substr($sponser_title, 0, 50);
                                        echo unserialize(base64_decode($titles)) . '...';
                                        ?>
                                    </a>

                                </div>
                                <div>
                                    <?php
                                    $sponser_description = $sponser_heading_data[$s]['description'];
                                    $description = substr($sponser_description, 0, 100);
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

                        <?php
                    }
                    echo " </div></div>";
                }
                echo '</div>';
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
                                <!--                                <label class="search_tex">Search</label>-->
                                <input type="text" class="key_in" id="search_text" name="search_text" placeholder="<?php echo _clang(KEYWORD); ?>">
                            </div>
                            <div class="key_right">
                                <select class="key_sel" id="search_category" name="search_category">
                                    <!--                                <option  value="">Select</option>-->
                                    <?php for ($i = 0; $i < count($all_sub_cat); $i++) { ?>
                                        <option <?php echo ($all_sub_cat[$i]['category_id'] == $sub_category_id) ? 'selected="selected"' : "" ?> value="<?php echo $all_sub_cat[$i]['category_id'] ?>"><?php echo (!empty($all_sub_cat[$i]['category_name_' . Do_language::GetSessionLang()]) ? $all_sub_cat[$i]['category_name_' . Do_language::GetSessionLang()] : $all_sub_cat[$i]['category_name_en'] ) ?></option>
                                    <?php } ?>
                                </select>
                                <input type="submit" name="submit" class="search_btn" value="search">
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
                <div style="width: 100%;overflow:hidden">
                    <div class="heading_left">
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
                        $samedate = '';
                        for ($i = 0; $i < count($title); $i++) {
                            $postid = $title[$i]['posts_id'];
                            $parent = $title[$i]['category'];
                            ?>
                            <article class="list_main">
                                <div class="list_mainrg" style="width: 100%">
                                    <div class="list_tital">
                                        <?php if ($samedate != date('Y-m-d', strtotime($title[$i]['date']))) { ?>
                                            <div class="list_titlerg">
                                                <?php
                                                echo $date = date('D .M .d', strtotime($title[$i]['date']));
                                                //echo $date = date('D j F, Y', strtotime($title[$i]['date']));
                                                ?>
                                            </div>
                                            <?php $samedate = date('Y-m-d', strtotime($title[$i]['date'])); ?>
                                        <?php } ?>

                                        <div class="list_titallf">
                                            <a href="<?php echo base_url("post_detail/getPostdetails/" . $postid . "/" . $parent) ?>">
                                                <?php
                                                $ci = & get_instance();
                                                $ci->load->model('common_model');
                                                $where_postid = " AND posts_id={$postid}";
                                                $location = $ci->common_model->getFieldData('posts', 'location', $where_postid);
                                                echo '<span class="emoji">' . unserialize(base64_decode($title[$i]['title'])) . '</span>';
                                                ?>
                                            </a>
                                            <span style="font-size: 15px; color: #000;"><?php echo (!empty($location) ? "( " . $location . " )" : ""); ?></span>
                                        </div>


                                    </div>

                                </div>
                            </article>
                        <?php }
                        ?>
                        <div class="pagination">
                            <?php echo $this->pagination->create_links() ?>
                        </div>
                    </div>
                    <div class="heading_right">
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
                                                    $sponser_title = $sponser_heading_data[$s]['title'];
                                                    $titles = substr($sponser_title, 0, 50);
                                                    echo unserialize(base64_decode($titles)) . '...';
                                                    ?>
                                                </a>

                                            </div>
                                            <div>
                                                <?php
                                                $sponser_description = $sponser_heading_data[$s]['description'];
                                                $description = substr($sponser_description, 0, 100);
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
                <?php
            } else {

                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo form_open('heading/get_seraching_data', $attributes);
                ?>
                <div class="search_main">
                    <div class="search_key">
                        <div class="key_search">
                            <div class="key_left">
                                <!--                                <label class="search_tex">Search</label>-->
                                <input type="text" class="key_in" id="search_text" name="search_text" placeholder="<?php echo _clang(KEYWORD); ?>">
                            </div>
                            <div class="key_right">
                                <select class="key_sel" id="search_category" name="search_category">
                                    <!--                                <option  value="">Select</option>-->
                                    <?php for ($i = 0; $i < count($all_sub_cat); $i++) { ?>
                                        <option <?php echo ($all_sub_cat[$i]['category_id'] == $sub_category_id) ? 'selected="selected"' : "" ?> value="<?php echo $all_sub_cat[$i]['category_id'] ?>"><?php echo (!empty($all_sub_cat[$i]['category_name_' . Do_language::GetSessionLang()]) ? $all_sub_cat[$i]['category_name_' . Do_language::GetSessionLang()] : $all_sub_cat[$i]['category_name_en'] ) ?></option>
                                    <?php } ?>
                                </select>
                                <input type="submit" name="submit" class="search_btn" value="search">
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
                <div class='list_mainrg' style='width:100%;'>
                    <h1 style='text-align:center;margin-top: 3%;'>No data available for this category  </h1>
                    <article class='list_main'>
                    </article>
                </div>

            <?php } ?>
        </div>
        </section>