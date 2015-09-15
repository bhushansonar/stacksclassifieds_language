<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    function formatText(el, tag) {
        var selectedText = document.selection ? document.selection.createRange().text : el.value.substring(el.selectionStart, el.selectionEnd);
        if (selectedText != '') {
            var newText = '<' + tag + '>' + selectedText + '</' + tag + '>';
            el.value = el.value.replace(selectedText, newText)
        }
    }

</script>
<style>
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    label{color: #3d3d3d;transition: color 1s ease 0s;}
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
                <li><a href="#"><?php echo $category_name; ?></a>>></li>
                <li><a href="#"><?php echo $category_name . " " . $subcategory; ?></a></li>
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
        $ci = & get_instance();
        $ci->load->model('common_model');
        echo validation_errors();
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart("write_add/update/$posts_id", $attributes);
        $ci = & get_instance();
        $ci->load->model('common_model');
        ?>
        <fieldset style="border:none;">
            <?php
            foreach ($posts_ads_details as $key => $posts_ads) {
                $where = " AND category_id={$posts_ads['category']}";
                $check_adult = $ci->common_model->getFieldData("category", "is_adult", $where);
                ?>
                <input type="hidden" name="category_id" value="<?php echo $posts_ads['category']; ?>"/>
                <input type="hidden" name="sub_category_id" value="<?php echo $posts_ads['subcategory']; ?>"/>
                <input type="hidden" name="country" value="<?php echo $posts_ads['country']; ?>"/>
                <input type="hidden" name="state" value="<?php echo $posts_ads['state']; ?>"/>
                <input type="hidden" name="city" value="<?php echo $posts_ads['city']; ?>"/>
                <input type="hidden" name="parent_id" value="<?php echo $posts_ads['category']; ?>"/>
                <input type="hidden" name="posts_id" value="<?php echo $posts_ads['posts_id']; ?>"/>
                <input type="hidden" id="ads_type" name="ads_type" value="<?php echo $posts_ads['ads_type']; ?>"/>
                <input type="hidden" name="expire_date" value="<?php echo $posts_ads['expire_date']; ?>"/>
                <?php if (!empty($renew)) { ?>
                    <input type="hidden" name="renew" value="<?php echo $renew; ?>"/>
                    <input type="hidden" name="status" value="<?php echo $posts_ads['status']; ?>"/>
                <?php }
                ?>
                <?php
                if ($check_adult == "YES") {
                    if (!empty($posts_ads['category'])) {
                        if ($posts_ads['category'] == '11' || $posts_ads['category'] == '4') {
                            $where = " AND category_id={$posts_ads['subcategory']} AND city_id={$posts_ads['city']}";
                            $city_category_price = $ci->common_model->getFieldData('city_category_price', 'price', $where);
                            if (!empty($city_category_price)) {
                                $city_price = $city_category_price;
                            } else {
                                $whereStr = " AND category_id={$posts_ads['category']} AND city_id={$posts_ads['city']}";
                                $city_price = $ci->common_model->getFieldData('city_category_price', 'price', $whereStr);
                            }
                        }
                    }
                    if (!empty($city_price)) {
                        ?>
                        <div class="control-group bottom_space">
                            <label for="inputError" class="control-label"><?php echo _clang(WRITE_ADD_CITY_CAT_PRICE_TEXT); ?> $<?php echo $city_price; ?></label>

                            <input type="hidden" id="city_category_price" name="city_category_price"  value="<?php echo $city_price; ?>">

                        </div>
                    <?php } ?>
                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_AGE); ?><span class='star'>*</span></label>
                        <div class='controls left_r'>
                            <input type='text' id='age' name='age' class="requir" value='<?php echo $posts_ads['age'] ?>' style='width:30%' >
                        </div>
                    </div>

                <?php }
                ?>
                <?php if ($posts_ads['category'] == 8) { ?>

                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_PRICE); ?></label>
                        <div class='controls left_r'>
                            <input type='text' id='price' name='price' value='<?php echo $posts_ads['price'] ?>' >
                        </div>
                    </div>

                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_BEDROOMS); ?></label>
                        <div class='controls left_r'>

                            <?php
                            $attribute = 'id="bedrooms" ';
                            $bedrooms = $posts_ads['bedrooms'];
                            $bedrooms_opt = array('' => 'Select', '0' => 'Studio', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8');
                            echo form_dropdown('bedrooms', $bedrooms_opt, $bedrooms, $attribute);
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_TITLE); ?><span class="star">*</span></label>
                    <div class="controls left_r">
                        <input type="text" class="requir" id="title" name="title" value="<?php echo unserialize(base64_decode($posts_ads['title'])); ?>" >
                    </div>
                </div>
                <?php
                if ($posts_ads['category'] == 1 || $posts_ads['category'] == 2) {
                    echo "
		<div class='control-group bottom_space'>
            <label for='inputError' class='control-label left'>" . _clang(WRITE_ADD_SELLING_PRICE) . "</label>
            <div class='controls left_r'>
                <input type='text' id='selling_price' name='selling_price' value='{$posts_ads['selling_price']}' >

            </div>
        </div>
		";
                }
                ?>
                <?php
                //if ($posts_ads['category'] == 2 || $posts_ads['category'] == 5 || $posts_ads['category'] == 10 || $posts_ads['category'] == 8 || $posts_ads['category'] == 9 || $posts_ads['category'] == 1) {
                echo "
        <div class='control-group bottom_space'>
            <label for='inputError' class='control-label left'>" . _clang(WRITE_ADD_LOCATION) . "<span class='star'>*</span></label>
            <div class='controls left_r'>
                <input type='text' class='requir' id='location' name='location' value='{$posts_ads['location']}' >
            </div>
        </div>
		";
                // }
                ?>

                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_DESCRIPTION); ?> <span class="star">*</span></label>
                    <div class="controls left_r">
                        <textarea name="description" id="description" class="requir des_height"><?php echo unserialize(base64_decode($posts_ads['description'])); ?></textarea><br>
                        <input type="button" value="Bold" onclick="formatText(description, 'b');" />
                        <input type="button" value="Italic" onclick="formatText(description, 'i');" />
                        <input type="button" value="Underline" onclick="formatText(description, 'u');" />
                    </div>
                </div>
                <?php if ($posts_ads['category'] == 9) { ?>

                    <div class='control-group bottom_space'>
                        <?php
                        if ($posts_content['ad_placed_by'] == 'Owner_Property_Manager') {

                            $owner_ad_placed_by = "checked='checked'";
                        } else {
                            $owner_ad_placed_by = '';
                        }
                        if ($posts_content['ad_placed_by'] == 'Agency_Locator_Service') {
                            $ad_placed_by = "checked='checked'";
                        } else {
                            $ad_placed_by = '';
                        }
                        ?>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_AD_PLACE) ?></label>
                        <div class='controls left_r'>
                            <input type='radio' <?php echo $owner_ad_placed_by ?> value='Owner_Property_Manager' name='ad_placed_by'>
                            <span>Owner/Property Manager</span>
                            <input type='radio' <?php echo $ad_placed_by ?>  value='Agency_Locator_Service' name='ad_placed_by'>
                            <span>Agency/Finder Service</span>
                        </div>
                    </div>
                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_FEES_PAID); ?></label>
                        <div class='controls left_r'>
                            <input type='text' id='fees_paid_by' name='fees_paid_by' value='<?php echo $posts_ads['fees_paid_by'] ?>' >
                        </div>
                    </div>
                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_PETS) ?></label>
                        <div class='controls left_r'>
                            <?php
                            if ($posts_content['pets'] == 'cats_ok') {
                                $pets_cat = "checked='checked'";
                            } else {
                                $pets_cat = '';
                            }
                            if ($posts_content['pets'] == 'dogs_ok') {
                                $pets = "checked='checked'";
                            } else {
                                $pets = '';
                            }
                            ?>
                            <input type='checkbox' <?php echo $pets_cat; ?> value='cats_ok' name='pets'><span style='margin:0 8px 0 3px;'>Cats Ok</span>
                            <input type='checkbox' <?php echo $pets; ?> value='dogs_ok' name='pets'><span style='margin:0 8px 0 3px;'>Dogs Ok</span>
                        </div>
                    </div>

                <?php } ?>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_ADDRESS); ?></label>
                    <div class="controls left_r">
                        <textarea id="address" name="address" value="" ><?php echo $posts_ads['address'] ?></textarea>
                    </div>
                </div>
                <?php if ($posts_ads['category'] == 5) { ?>

                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_SALARY_WAGE); ?></label>
                        <div class='controls left_r'>
                            <input type='text' id='salary' name='salary' value='<?php echo $posts_ads['salary'] ?>' >
                        </div>
                    </div>
                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_EDUCATION) ?></label>
                        <div class='controls left_r'>
                            <input type='text' id='education' name='education' value='<?php echo $posts_ads['education'] ?>' >
                        </div>
                    </div>
                    <div class='control-group bottom_space'>
                        <label for='inputError' class='control-label left'><?php echo _clang(WRITE_ADD_WORK_STATUS); ?></label>
                        <div class='controls left_r'>
                            <?php
                            $work_status_arr = explode(',', $posts_ads['work_status']);
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
                            $shift_arr = explode(',', $posts_ads['shift']);

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
                        <input type="text" id="postcode" name="postcode" value="<?php echo $posts_ads['postcode'] ?>" >
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_EMAIL); ?>:<span class="star">*</span></label>
                    <div class="controls left_r">
                        <input type="text" class='requir' id="email" name="email" value="<?php echo $posts_ads['email']; ?>" >

                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_CONFIRM_EMAIL); ?>:<span class="star">*</span></label>
                    <div class="controls left_r">
                        <input type="text" class='requir' id="confirm_email" name="confirm_email" value="<?php echo $posts_ads['email']; ?>" >

                    </div>
                </div>
                <?php if ($check_adult != "YES") { ?>
                    <div class="control-group bottom_space">
                        <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_CONTACT_NO); ?>:<span class="star">*</span></label>
                        <div class="controls left_r">
                            <input type="text" class='requir' id="contact_number" name="contact_number" value="<?php echo $posts_ads['contact_number']; ?>" />
                        </div>
                    </div>
                <?php } ?>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_EMAIL_ENQUIRIES); ?></label>
                    <div class="controls left_r">
                        <?php
                        $checked = 'unchecked';
                        $checked1 = 'unchecked';
                        if ($posts_ads['inquery'] == 'yes') {
                            $checked = 'checked';
                        } else if ($posts_ads['inquery'] == 'no') {
                            $checked1 = 'checked';
                        }
                        ?>
                        <input type="radio" name="inquery" <?php echo $checked; ?> value="yes" ><span><?php echo _clang(WRITE_ADD_EMAIL_ENQUIRIES_ONE); ?></span><br />
                        <input type="radio" name="inquery" <?php echo $checked1; ?> value="no" ><span><?php echo _clang(WRITE_ADD_EMAIL_ENQUIRIES_TWO); ?></span>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_DISPLAY_OPT); ?></label>
                    <div class="controls left_r">
                        <?php
                        $check = 'unchecked';
                        $check1 = 'unchecked';
                        if ($posts_ads['show_ad_links'] == 'yes') {
                            $check = 'checked';
                        } else if ($posts_ads['show_ad_links'] == 'no') {
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
                    if ($posts_ads['show_joined_date'] == 'yes') {
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
                        <?php if (!empty($posts_ads['video'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <video width="115" controls>
                                    <source src="<?php echo base_url(); ?>uploads/video/<?php echo $posts_ads['video']; ?>" type="video/mp4">
                                </video>
                            </div>
                            <input type="hidden" name="old_video" value="<?php echo $posts_ads['video'] ?>" />
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
                        <?php if (!empty($posts_ads['image1'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image1']; ?>" />
                            </div>
                            <input type="hidden" name="old_image1" value="<?php echo $posts_ads['image1'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image2" id="image2" /></div>
                        <?php if (!empty($posts_ads['image2'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image2']; ?>" />
                            </div>
                            <input type="hidden" name="old_image2" value="<?php echo $posts_ads['image2'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image3" id="image3" /></div>
                        <?php if (!empty($posts_ads['image3'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image3']; ?>" />
                            </div>
                            <input type="hidden" name="old_image3" value="<?php echo $posts_ads['image3'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image4" id="image4" /></div>
                        <?php if (!empty($posts_ads['image4'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image4']; ?>" />
                            </div>
                            <input type="hidden" name="old_image4" value="<?php echo $posts_ads['image4'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image5" id="image5" /></div>
                        <?php if (!empty($posts_ads['image5'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image5']; ?>" />
                            </div>
                            <input type="hidden" name="old_image5" value="<?php echo $posts_ads['image5'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image6" id="image6" /></div>
                        <?php if (!empty($posts_ads['image6'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image6']; ?>" />
                            </div>
                            <input type="hidden" name="old_image6" value="<?php echo $posts_ads['image6'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image7" id="image7" /></div>
                        <?php if (!empty($posts_ads['image7'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image7']; ?>" />
                            </div>
                            <input type="hidden" name="old_image7" value="<?php echo $posts_ads['image7'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image8" id="image8" /></div>
                        <?php if (!empty($posts_ads['image8'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image8']; ?>" />
                            </div>
                            <input type="hidden" name="old_image8" value="<?php echo $posts_ads['image8'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image9" id="image9" /></div>
                        <?php if (!empty($posts_ads['image9'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image9']; ?>" />
                            </div>
                            <input type="hidden" name="old_image9" value="<?php echo $posts_ads['image9'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image10" id="image10" /></div>
                        <?php if (!empty($posts_ads['image10'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image10']; ?>" />
                            </div>
                            <input type="hidden" name="old_image10" value="<?php echo $posts_ads['image10'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image11" id="image11" /></div>
                        <?php if (!empty($posts_ads['image11'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image11']; ?>" />
                            </div>
                            <input type="hidden" name="old_image11" value="<?php echo $posts_ads['image11'] ?>" />
                        <?php } ?>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Images:</label>
                    <div class="controls left_r">
                        <div><input type="file" name="image12" id="image12" /></div>
                        <?php if (!empty($posts_ads['image12'])) { ?>
                            <div style="float:left; padding: 1px;">
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_ads['image12']; ?>" />
                            </div>
                            <input type="hidden" name="old_image12" value="<?php echo $posts_ads['image12'] ?>" />
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
                            if ($posts_ads['auto_repost_ad'] == 'yes') {
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
                                        <option <?php echo $i == $posts_ads['auto_repost_day'] ? 'selected="selected"' : '' ?>  value="<?php echo $i ?>"><?php echo $i . ' ' . $days ?></option>
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
                                        <option <?php echo $i == $posts_ads['auto_repost_time'] ? 'selected="selected"' : '' ?>  value="<?php echo date("H:i A", strtotime($i . ":00:00")) ?>"><?php echo date("H:i A", strtotime($i . ":00:00")) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <br/>
                            <span><?php echo _clang(WRITE_ADD_NUM_WEEKS); ?>:</span>
                            <div style="display: inline-block"> <?php
                                $attribute = 'id="auto_repost_no_of_time" style="width:150px;" onchange="getTextAutoRepost(this)"';
                                $auto_repost_no_of_time = $posts_ads['auto_repost_no_of_time'];
                                $auto_repost_opt = array('4' => '4 times for &#163; 1.00', '8' => '8 times for &#163; 2.00', '12' => '12 times for &#163; 3.00', '26' => '26 times for &#163; 6.00');
                                echo form_dropdown('auto_repost_no_of_time', $auto_repost_opt, $auto_repost_no_of_time, $attribute);
                                ?>

                            </div>
                            <div>
                                <input id="hidden_price" type="hidden" name="auto_repost_price" value="<?php echo $posts_ads['auto_repost_price']; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (!empty($city_featured_price)) {
                    $featured_price_after_decode = json_decode($city_featured_price);
                    ?>
                    <div class="control-group bottom_space">
                        <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_FEATURED_ADS); ?></label>
                        <div class="controls left_r">
                            <?php
                            $featured_ad = '';
                            if ($posts_ads['featured_ad'] == 'yes') {
                                $featured_ad = 'checked';
                            }
                            ?>
                            <input type="checkbox" id="featured_ad" <?php echo $featured_ad; ?> value="yes" name="featured_ad" onchange="getchecked(this);">
                            <span><?php echo _clang(WRITE_ADD_FEATURED_ADS_TEXT); ?></span><br /><br />
                            <span style="margin-left: 2.8% "><?php echo _clang(WRITE_ADD_NUM_WEEKS); ?>:</span>
                            <div style="display: inline-block">
                                <select style="width: 150px;"id="week" name="featured_ad_week_price" onchange="getval(this);">
                                    <?php
                                    //echo $posts_ads['featured_ad_week_price'];
                                    echo '<option value="">Select</option>';

                                    foreach ($featured_price_after_decode as $key => $value) {
                                        foreach ($value as $key => $value1) {

                                            if ($value1 == $posts_ads['featured_ad_week_price']) {
                                                $selected = "selected=selected";
                                            } else {
                                                $selected = "";
                                            }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo $value1; ?>"><?php echo $key . ' week (' . $this->session->userdata('currency_type') . $value1 . ')' ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div>
                                    <input id="featured_ad_week" type="hidden" name="featured_ad_week" value="<?php echo $posts_ads['featured_ad_week']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>

                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_PROMOCODE); ?></label>
                    <div class="controls left_r">
                        <input type="text" id="promocode" name="promocode" value="" >

                    </div>
                </div>
                <div class="control-group bottom_space" id="ef">

                    <div class="controls left_r">
                        <div class="comment_recaptcha"><?php echo $recaptcha_html; ?></div>
                    </div>
                </div>
                <div class="form-actions_others">
                    <div class="form-actions" id="gh">
                        <input class="btn" type="submit" name="submit" value="<?php echo _clang(WRITE_ADD_CONTINUE_BTN); ?>">
                        <!--                    <a class="btn" href="" onclick="window.history.go(-1);
                                    return false;">Cancel</a>-->
                    </div>
                    <div class="cd_text"> <?php echo _clang(PRIVACY_AGREE_TEXT); ?> <a href="<?php echo site_url('term'); ?>"><?php echo _clang(TERMS); ?></a>
                        <?php
                        $str = "";
                        if ($posts_ads['category'] == 4 || $posts_ads['category'] == 11) {
                            $str = "and ";
                            $str.='<a href="' . site_url("privacy") . '">"' . _clang(WRITE_ADD_PRIVACY) . '"</a>';
                        }
                        echo $str;
                        ?>
                        .</div>

                </div>
            <?php } ?>
        </fieldset>
        <?php echo form_close(); ?>
    </div>
</section>
<script>
    function getchecked(obj) {
//var check = $(obj);
        if ($(obj).prop('checked') == true) {
            var ads_type = "paid";
            $('#ads_type').val(ads_type);
        } else {
            var ads_type = '<?php echo $posts_ads['ads_type']; ?>';
            $('#ads_type').val(ads_type);

        }
    }
    function getTextAutoRepost() {
        var price = $('#auto_repost_no_of_time>option:selected').text();
        var result_price = price.split(" ");
        $('#hidden_price').val(result_price[4]);
    }
    function getval() {
        var str = $('#week>option:selected').text();
        var result = str.split(" ");
        $('#featured_ad_week').val(result[0]);
    }
</script>
