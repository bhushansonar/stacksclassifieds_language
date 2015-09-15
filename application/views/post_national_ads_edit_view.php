<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

</script>
<style>
    /*    .left{ float: left; width:15%; line-height: 25px; }
        .left_r{ float:left; width:85%;}*/
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    /*    #title, #email, #confirm_email, #postcode, #location, #selling_price, #contact_number, #age, #price, #fees_paid_by, #salary, #education,#image,#address,#day,#time,#week,#auto_repost{
            border: 1px dashed #dbdbdb;
            border-radius: 2px;
            color: #3f3f3f;
            display: block;
            font-family: "Droid Sans",Tahoma,Arial,Verdana sans-serif;
            font-size: 14px;
            outline: medium none;
            padding: 8px 8px;
            transition: background 0.2s linear 0s, box-shadow 0.6s linear 0s;
            width: 380px;}*/
    label{color: #3d3d3d;transition: color 1s ease 0s;}
    .btn_mult {
        background-color: #506fa3;
        border: 1px outset #ccc;
        color: #fff;
        cursor: pointer;
    }
    .requir{
        background-color: #ffffb9;
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
                     <!--<a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                                                                                                                                                        ?>"><?php echo $subcategory; ?></a>-->
                </li>
            </ul>
        </div>
        <div>
            <h2 style="display: inline-block; line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
                <?php echo _clang(EDIT_POST); ?>
            </h2>
            <span style="display: inline-block; font-size: 14px; font-weight: normal;" class="requir">&nbsp;<?php echo _clang(REQUIREDS); ?>&nbsp;</span>
        </div>
        <ul id="stepButtons">
            <li class="postAdButtonOn">
                <div class="indexSectionHeader"><?php echo _clang(WRITE_ADD_1); ?></div>
            </li>
            <li class="postAdButtonOff">
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
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo validation_errors();
        echo form_open_multipart("post_national_ads/update/$posts_id", $attributes);
        $ci = & get_instance();
        $ci->load->model('common_model');
        ?>
        <fieldset style="border:none;">
            <?php
            foreach ($post_national_ads_details as $key => $post_national_ads) {

                $where = " AND category_id={$post_national_ads['category']}";
                $check_adult = $ci->common_model->getFieldData("category", "is_adult", $where);
                ?>
                <input type="hidden" name="category_id" value="<?php echo $post_national_ads['category']; ?>"/>
                <input type="hidden" name="sub_category_id" value="<?php echo $post_national_ads['subcategory']; ?>"/>
                <input type="hidden" name="country" value="<?php echo $post_national_ads['country']; ?>"/>
                <input type="hidden" name="state" value="<?php echo $post_national_ads['state']; ?>"/>
                <input type="hidden" name="city" value="<?php echo $post_national_ads['city']; ?>"/>
                <input type="hidden" name="parent_id" value="<?php echo $post_national_ads['category']; ?>"/>
                <input type="hidden" name="posts_id" value="<?php echo $post_national_ads['posts_id']; ?>"/>
                <input type="hidden" name="total" value="<?php echo $post_national_ads['total']; ?>"/>

                <?php if ($post_national_ads['category'] == 8) { ?>

                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_PRICE); ?></label>
                        <div class='controls left_r'>
                            <input type='text' id='price' name='price' value='<?php echo $post_national_ads['price'] ?>' >
                        </div>
                    </div>

                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_BEDROOMS); ?></label>
                        <div class='controls left_r'>

                            <?php
                            $attribute = 'id="bedrooms" ';
                            $bedrooms = $post_national_ads['bedrooms'];
                            $bedrooms_opt = array('' => 'Select', '0' => 'Studio', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8');
                            echo form_dropdown('bedrooms', $bedrooms_opt, $bedrooms, $attribute);
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_TITLE); ?><span class="star">*</span></label>
                    <div class="controls left_r">
                        <input type="text" class="requir" id="title" name="title" value="<?php echo unserialize(base64_decode($post_national_ads['title'])) ?>" >
                    </div>
                </div>
                <?php
                if ($post_national_ads['category'] == 1 || $post_national_ads['category'] == 2) {
                    echo "
		<div class='control-group bottom_space'>
            <label for='inputError' class='control-label left'>" . _clang(WRITE_ADD_SELLING_PRICE) . "</label>
            <div class='controls left_r'>
                <input type='text' id='selling_price' name='selling_price' value='{$post_national_ads['selling_price']}' >

            </div>
        </div>
		";
                }
                ?>
                <?php
                //if ($post_national_ads['category'] == 2 || $post_national_ads['category'] == 5 || $post_national_ads['category'] == 10 || $post_national_ads['category'] == 8 || $post_national_ads['category'] == 9 || $post_national_ads['category'] == 1) {
                echo "
        <div class='control-group bottom_space'>
            <label for='inputError'  class='control-label left'>" . _clang(WRITE_ADD_LOCATION) . "<span class='star'>*</span></label>
            <div class='controls left_r'>
                <input type='text' class='requir' id='location' name='location' value='{$post_national_ads['location']}' >
            </div>
        </div>
		";
                //}
                ?>
                <?php
                if ($check_adult == "YES") {
                    echo "
        <div class='control-group bottom_space'>
            <label for='inputError' class='control-label left'>" . _clang(WRITE_ADD_AGE) . "<span class='star'>*</span></label>
            <div class='controls left_r'>
                <input type='text' id='age' class='requir' name='age' value='{$post_national_ads['age']}' >
            </div>
        </div>
		";
                }
                ?>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left_a"><?php echo _clang(WRITE_ADD_DESCRIPTION); ?><span class="star">*</span></label>
                    <div class="controls left_b">
                        <!--   <textarea class="tinymce ckeditor" id="editor" name="description"></textarea>-->

                        <textarea name="description"  class="requir des_height"  id="description"><?php echo unserialize(base64_decode($post_national_ads['description'])); ?></textarea><br>
                        <input type="button" value="Bold" onclick="formatText(description, 'b');" />
                        <input type="button" value="Italic" onclick="formatText(description, 'i');" />
                        <input type="button" value="Underline" onclick="formatText(description, 'u');" />

                    </div>
                </div>
                <?php if ($post_national_ads['category'] == 9) { ?>

                    <div class='control-group bottom_space'>
                        <?php
                        if ($post_national_ads['ad_placed_by'] == 'Owner_Property_Manager') {
                            $ad_placed_by = "checked";
                        } else if ($post_national_ads['ad_placed_by'] == 'Agency_Locator_Service') {
                            $ad_placed_by = "checked";
                        } else {
                            $ad_placed_by = '';
                        }
                        ?>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_AD_PLACE) ?></label>
                        <div class='controls left_r'>
                            <input type='radio' <?php echo $ad_placed_by ?> value='Owner_Property_Manager' name='ad_placed_by'>
                            <span>Owner/Property Manager</span>
                            <input type='radio' <?php echo $ad_placed_by ?>  value='Agency_Locator_Service' name='ad_placed_by'>
                            <span>Agency/Finder Service</span>
                        </div>
                    </div>
                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_FEES_PAID); ?></label>
                        <div class='controls left_r'>
                            <input type='text' id='fees_paid_by' name='fees_paid_by' value='<?php echo $post_national_ads['fees_paid_by'] ?>' >
                        </div>
                    </div>
                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_PETS) ?></label>
                        <div class='controls left_r'>
                            <?php
                            if ($post_national_ads['pets'] == 'Cats') {
                                $pets = "checked";
                            } else if ($post_national_ads['pets'] == 'Dogs') {
                                $pets = "checked";
                            } else {
                                $pets = '';
                            }
                            ?>
                            <input type='checkbox' value='Cats' name='pets'><span style='margin:0 8px 0 3px;'>Cats Ok</span>
                            <input type='checkbox' value='Dogs' name='pets'><span style='margin:0 8px 0 3px;'>Dogs Ok</span>
                        </div>
                    </div>

                <?php } ?>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_ADDRESS); ?></label>
                    <div class="controls left_r">
                        <textarea id="address" name="address" value="" ><?php echo $post_national_ads['address'] ?></textarea>
                    </div>
                </div>
                <?php if ($post_national_ads['category'] == 5) { ?>

                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_SALARY_WAGE); ?></label>
                        <div class='controls left_r'>
                            <input type='text' id='salary' name='salary' value='<?php echo $post_national_ads['salary'] ?>' >
                        </div>
                    </div>
                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_EDUCATION) ?></label>
                        <div class='controls left_r'>
                            <input type='text' id='education' name='education' value='<?php echo $post_national_ads['education'] ?>' >
                        </div>
                    </div>
                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_WORK_STATUS); ?></label>
                        <div class='controls left_r'>
                            <?php
                            $work_status_arr = explode(',', $post_national_ads['work_status']);
                            if (in_array("Full-time", $work_status_arr)) {
                                $full_time = "checked";
                            } else {
                                $full_time = "";
                            }
                            if (in_array("Part-time", $work_status_arr)) {
                                $part_time = "checked";
                            } else {
                                $part_time = "";
                            }
                            if (in_array("Temp/Contract", $work_status_arr)) {
                                $temp_contract = "checked";
                            } else {
                                $temp_contract = "";
                            }
                            if (in_array("Internship", $work_status_arr)) {
                                $internship = "checked";
                            } else {
                                $internship = "";
                            }
                            ?>
                            <input type='checkbox'  <?php echo $full_time; ?> value='Full-time' name='work_status[]'>
                            <span style='margin:0 8px 0 3px;'>Full-time</span>
                            <input type='checkbox' <?php echo $part_time; ?> value='Part-time' name='work_status[]'>
                            <span style='margin:0 8px 0 3px;'>Part-time</span>
                            <input type='checkbox'  <?php echo $temp_contract; ?> value='Temp/Contract' name='work_status[]'>
                            <span style='margin:0 8px 0 3px;'>Temp/Contract</span>
                            <input type='checkbox'  <?php echo $internship; ?> value='Internship' name='work_status[]'>
                            <span style='margin:0 8px 0 3px;'>Internship</span>
                        </div>
                    </div>
                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_SHIFT); ?></label>
                        <div class='controls left_r'>
                            <?php
                            $shift_arr = explode(',', $post_national_ads['shift']);

                            if (in_array("Days", $shift_arr)) {
                                $days = "checked";
                            } else {
                                $days = "";
                            }
                            if (in_array("Nights", $shift_arr)) {
                                $nights = "checked";
                            } else {
                                $nights = "";
                            }
                            if (in_array("Weekends", $shift_arr)) {
                                $weekends = "checked";
                            } else {
                                $weekends = "";
                            }
                            ?>
                            <input type='checkbox' <?php echo $days; ?> value='Days' name='shift[]'>
                            <span style='margin:0 8px 0 3px;'><?php echo _clang(DAYS) ?></span>
                            <input type='checkbox' <?php echo $nights; ?> value='Nights' name='shift[]'>
                            <span style='margin:0 8px 0 3px;'><?php echo _clang(NIGHTS) ?></span>
                            <input type='checkbox' <?php echo $weekends; ?> value='Weekends' name='shift[]'>
                            <span style='margin:0 8px 0 3px;'><?php echo _clang(WEEKENDS) ?></span>
                        </div>
                    </div>

                <?php } ?>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_POSTCODE); ?></label>
                    <div class="controls left_r">
                        <input type="text" id="postcode" name="postcode" value="<?php echo $post_national_ads['postcode'] ?>" >
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_EMAIL); ?>:<span class="star">*</span></label>
                    <div class="controls left_r">
                        <input type="text" class='requir' id="email" name="email" value="<?php echo $post_national_ads['email']; ?>" >

                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_CONFIRM_EMAIL); ?>:<span class="star">*</span></label>
                    <div class="controls left_r">
                        <input type="text" class='requir' id="confirm_email" name="confirm_email" value="<?php echo $post_national_ads['email']; ?>" >

                    </div>
                </div>
                <?php if ($check_adult != "YES") { ?>
                    <div class="control-group bottom_space">
                        <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_CONTACT_NO); ?>:<span class="star">*</span></label>
                        <div class="controls left_r">
                            <input type="text" class='requir' id="contact_number" name="contact_number" value="<?php echo $post_national_ads['contact_number']; ?>" >

                        </div>
                    </div>
                <?php } ?>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_EMAIL_ENQUIRIES); ?></label>
                    <div class="controls left_r">
                        <?php
                        $checked = 'unchecked';
                        $checked1 = 'unchecked';
                        if ($post_national_ads['inquery'] == 'yes') {
                            $checked = 'checked';
                        } else if ($post_national_ads['inquery'] == 'no') {
                            $checked1 = 'checked';
                        }
                        ?>
                        <input type="radio" name="inquery" <?php echo $checked; ?> value="hide_email" ><span><?php echo _clang(WRITE_ADD_EMAIL_ENQUIRIES_ONE); ?></span><br />
                        <input type="radio" name="inquery" <?php echo $checked1; ?> value="no" ><span><?php echo _clang(WRITE_ADD_EMAIL_ENQUIRIES_TWO); ?></span>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_DISPLAY_OPT); ?></label>
                    <div class="controls left_r">
                        <?php
                        $check = 'unchecked';
                        $check1 = 'unchecked';
                        if ($post_national_ads['show_ad_links'] == 'yes') {
                            $check = 'checked';
                        } else if ($post_national_ads['show_ad_links'] == 'no') {
                            $check1 = 'checked';
                        }
                        ?>
                        <input type="radio" name="show_ad_links" <?php echo $check ?> value="yes" ><span><?php echo _clang(WRITE_ADD_DISPLAY_OPT_ONE); ?></span><br />
                        <input type="radio" name="show_ad_links" <?php echo $check1 ?> value="no" ><span><?php echo _clang(WRITE_ADD_DISPLAY_OPT_TWO); ?></span>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <?php
                    $chec = '';
                    if ($post_national_ads['show_joined_date'] == 'yes') {
                        $chec = 'checked';
                    }
                    ?>
                    <div class="controls left_r" style="margin-left:126px;">
                        <input type="checkbox" name="show_joined_date" <?php echo $chec; ?> value="yes" ><span><?php echo _clang(WRITE_ADD_SHOW_DATE_JOIN); ?></span>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_VIDEO); ?>:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="video" id="video" /></div>
                        <?php if (!empty($post_national_ads['video'])) { ?>
                            <div style="float:left; padding: 1px;">

                                <video width="115" controls>
                                    <source src="<?php echo base_url(); ?>uploads/video/<?php echo $post_national_ads['video']; ?>" type="video/mp4">

                                </video>
                            </div>
                            <input type="hidden" name="old_video" value="<?php echo $post_national_ads['video'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image1" id="image1" /></div>
                        <?php if (!empty($post_national_ads['image1'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image1']; ?>" />
                            </div>
                            <input type="hidden" name="old_image1" value="<?php echo $post_national_ads['image1'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image2" id="image2" /></div>
                        <?php if (!empty($post_national_ads['image2'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image2']; ?>" />
                            </div>
                            <input type="hidden" name="old_image2" value="<?php echo $post_national_ads['image2'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image3" id="image3" /></div>
                        <?php if (!empty($post_national_ads['image3'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image3']; ?>" />
                            </div>
                            <input type="hidden" name="old_image3" value="<?php echo $post_national_ads['image3'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image4" id="image4" /></div>
                        <?php if (!empty($post_national_ads['image4'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image4']; ?>" />
                            </div>
                            <input type="hidden" name="old_image4" value="<?php echo $post_national_ads['image4'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image5" id="image5" /></div>
                        <?php if (!empty($post_national_ads['image5'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image5']; ?>" />
                            </div>
                            <input type="hidden" name="old_image5" value="<?php echo $post_national_ads['image5'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image6" id="image6" /></div>
                        <?php if (!empty($post_national_ads['image6'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image6']; ?>" />
                            </div>
                            <input type="hidden" name="old_image6" value="<?php echo $post_national_ads['image6'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image7" id="image7" /></div>
                        <?php if (!empty($post_national_ads['image7'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image7']; ?>" />
                            </div>
                            <input type="hidden" name="old_image7" value="<?php echo $post_national_ads['image7'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image8" id="image8" /></div>
                        <?php if (!empty($post_national_ads['image8'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image8']; ?>" />
                            </div>
                            <input type="hidden" name="old_image8" value="<?php echo $post_national_ads['image8'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image9" id="image9" /></div>
                        <?php if (!empty($post_national_ads['image9'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image9']; ?>" />
                            </div>
                            <input type="hidden" name="old_image9" value="<?php echo $post_national_ads['image9'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image10" id="image10" /></div>
                        <?php if (!empty($post_national_ads['image10'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image10']; ?>" />
                            </div>
                            <input type="hidden" name="old_image10" value="<?php echo $post_national_ads['image10'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image11" id="image11" /></div>
                        <?php if (!empty($post_national_ads['image11'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image11']; ?>" />
                            </div>
                            <input type="hidden" name="old_image11" value="<?php echo $post_national_ads['image11'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image12" id="image12" /></div>
                        <?php if (!empty($post_national_ads['image12'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $post_national_ads['image12']; ?>" />
                            </div>
                            <input type="hidden" name="old_image12" value="<?php echo $post_national_ads['image12'] ?>" />
                        <?php } else { ?>
                            <div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space" style="border-bottom:2px solid #999999; padding-bottom: 8px;">
                    <div class="controls left_r">
                        <h2><?php echo _clang(WRITE_ADD_UPGRADE); ?><span style="font-weight:normal; font-size:12px;">(<?php echo _clang(WRITE_ADD_UPGRADE_MINIMUM); ?> <?php echo $this->session->userdata('currency_type') ?> 0.99)</span></h2>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_AUTO_REPOST); ?></label>
                    <div class="controls left_r">
                        <div>
                            <?php
                            $ch = '';
                            if ($post_national_ads['auto_repost_ad'] == 'yes') {
                                $ch = 'checked';
                            }
                            ?>
                            <input type="checkbox" <?php echo $ch; ?> name="auto_repost_ad" value="yes" />
                            <span style="margin:0 5px 0 5px;"><?php echo _clang(MOVE_AD_TOP); ?> </span>
                            <div style="display: inline-block">
                                <select id="day" name="auto_repost_day" style="width: 90px;">
                                    <?php
                                    for ($i = 1; $i <= 30; $i++) {
                                        if ($i == '1') {
                                            $days = 'day';
                                        } else {
                                            $days = 'days';
                                        }
                                        ?>
                                        <option <?php echo $i == $post_national_ads['auto_repost_day'] ? 'selected="selected"' : '' ?>  value="<?php echo $i ?>"><?php echo $i . ' ' . $days ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <span style="margin:0 8px 0 8px;"><?php echo _clang(AFTER); ?></span>
                            <div style="display: inline-block">
                                <select name="auto_repost_time" id="time" style="width: 100px;">
                                    <?php
                                    for ($i = 0; $i < 24; $i++) {
                                        //$time = date("H:i A", strtotime($i . ":00:00"));
                                        ?>
                                        <option <?php echo $i == $post_national_ads['auto_repost_time'] ? 'selected="selected"' : '' ?>  value="<?php echo date("H:i A", strtotime($i . ":00:00")) ?>"><?php echo date("H:i A", strtotime($i . ":00:00")) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <br/>
                            <span><?php echo _clang(WRITE_ADD_NUM_WEEKS); ?>:</span>
                            <div style="display: inline-block"> <?php
                                $attribute = 'id="auto_repost_no_of_time" style="width:150px;" onchange="getTextAutoRepost(this)"';
                                $auto_repost_no_of_time = $post_national_ads['auto_repost_no_of_time'];
                                $auto_repost_opt = array('4' => '4 times for &#163; 1.00', '8' => '8 times for &#163; 2.00', '12' => '12 times for &#163; 3.00', '26' => '26 times for &#163; 6.00');
                                echo form_dropdown('auto_repost_no_of_time', $auto_repost_opt, $auto_repost_no_of_time, $attribute);
                                ?>

                            </div>
                            <div>
                                <input id="hidden_price" type="hidden" name="auto_repost_price" value="<?php echo $post_national_ads['auto_repost_price']; ?>">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_PROMOCODE); ?></label>
                    <div class="controls left_r">
                        <input type="text" id="promocode" name="promocode" value="" >

                    </div>
                </div>
                <div class="control-group bottom_space" id="sp">

                    <div class="controls left_r">
                        <div class="comment_recaptcha"><?php echo $recaptcha_html; ?></div>
                    </div>
                </div>
                <div class="form-actions" id="st">
                    <button class="btn_mult" type="submit"><?php echo _clang(WRITE_ADD_CONTINUE_BTN); ?></button>
                    <!--                    <a class="btn" href="" onclick="window.history.go(-1);
                                return false;">Cancel</a>-->
                    <span> <?php echo _clang(PRIVACY_AGREE_TEXT); ?> <a href="<?php echo site_url('term'); ?>"><?php echo _clang(TERMS); ?></a>
                        <?php
                        $str = "";
                        if ($post_national_ads['category'] == 4 || $post_national_ads['category'] == 11) {
                            $str = "and ";
                            $str.='<a href="' . site_url("privacy") . '"> "' . _clang(WRITE_ADD_PRIVACY) . '"</a>';
                        }
                        echo $str;
                        ?>
                        .</span>
                </div>
            <?php } ?>
        </fieldset>
        <?php echo form_close(); ?>
    </div>
</section>
<script>
    function getTextAutoRepost() {
        var price = $('#auto_repost_no_of_time>option:selected').text();
        console.log(price);
        var result_price = price.split(" ");
        $('#hidden_price').val(result_price[4]);
    }

</script>

