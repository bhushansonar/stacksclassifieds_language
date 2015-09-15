<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

    CKEDITOR.replaceAll('tinymce');
    function formatText(el, tag) {
        var selectedText = document.selection ? document.selection.createRange().text : el.value.substring(el.selectionStart, el.selectionEnd);
        if (selectedText != '') {
            var newText = '<' + tag + '>' + selectedText + '</' + tag + '>';
            el.value = el.value.replace(selectedText, newText)
        }
    }
</script>
<style>
    /*    .left_a{ float: left; width:23%; line-height: 25px; }*/
    /*    .left_r{ float:left; width:85%;}*/
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    /*    #title, #email, #confirm_email, #postcode, #location, #selling_price, #contact_number, #age, #price, #fees_paid_by, #salary, #education,#image,#address,#day,#time,#week,#auto_repost,#promocode{
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
                     <!--<a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                                                                                                                                                                                   ?>"><?php echo $subcategory; ?></a>-->
                </li>
            </ul>
        </div>
        <div>
            <h2 style="display: inline-block; line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
                Step1: Write Ad
            </h2>
            <span style="display: inline-block; font-size: 14px; font-weight: normal;" class="requir">&nbsp;required fields&nbsp;</span>
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
        echo form_open_multipart('post_national_ads/add', $attributes);
        $ci = & get_instance();
        $ci->load->model('common_model');
        $where = " AND category_id={$parent_id}";
        $check_adult = $ci->common_model->getFieldData("category", "is_adult", $where);
        ?>
        <fieldset style="border:none;">
            <input type="hidden" name="category_id" value="<?php echo $category; ?>"/>
            <input type="hidden" name="sub_category_id" value="<?php echo $sub_category; ?>"/>
            <input type="hidden" name="country" value="<?php echo $country; ?>"/>
            <input type="hidden" name="state" value="<?php echo $state; ?>"/>
            <input type="hidden" name="city" value="<?php echo $city; ?>"/>
            <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>"/>
            <input type="hidden" name="total" value="<?php echo $total; ?>"/>

            <?php
            if ($parent_id == 8) {
                echo '
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_PRICE) . '</label>
            <div class="controls left_b">
                <input type="text" id="price" name="price" value=' . custom_set_value('price') . ' >
            </div>
        </div>

        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_BEDROOMS) . '</label>
            <div class="controls left_b">
                <select name="bedrooms">
                	<option value="">Select </option>
                    <option ' . custom_set_select('bedrooms', '0+') . ' value="0+">Studio </option>
                    <option ' . custom_set_select('bedrooms', '1') . ' value="1">1 </option>
                    <option ' . custom_set_select('bedrooms', '2') . ' value="2">2 </option>
                    <option ' . custom_set_select('bedrooms', '3') . ' value="3">3 </option>
                    <option ' . custom_set_select('bedrooms', '4') . ' value="4">4 </option>
                    <option ' . custom_set_select('bedrooms', '5') . ' value="5">5 </option>
                    <option ' . custom_set_select('bedrooms', '6') . ' value="6">6 </option>
                    <option ' . custom_set_select('bedrooms', '7') . ' value="7">7 </option>
                    <option ' . custom_set_select('bedrooms', '8') . ' value="8">8 </option>
                </select>
            </div>
        </div>
		';
            }
            ?>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label left_a"><?php echo _clang(WRITE_ADD_TITLE); ?><span class="star">*</span></label>
                <div class="controls left_b">
                    <input type="text" class="requir" id="title" name="title" value="<?php echo custom_set_value('title'); ?>" >
                </div>
            </div>
            <?php
            if ($parent_id == 1 || $parent_id == 2) {
                echo '
		<div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_SELLING_PRICE) . '</label>
            <div class="controls left_b">
                <input type="text" id="selling_price" name="selling_price" value="' . custom_set_value('selling_price') . '" >

            </div>
        </div>
		';
            }
            ?>
            <?php
            //if ($parent_id == 2 || $parent_id == 5 || $parent_id == 10 || $parent_id == 8 || $parent_id == 9 || $parent_id == 1) {
            echo '
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_LOCATION) . '<span class="star">*</span></label>
            <div class="controls left_b">
                <input type="text" class="requir" id="location" name="location" value="' . custom_set_value('location') . '" >
            </div>
        </div>
		';
            //}
            ?>
            <?php
            if ($check_adult == "YES") {
                echo '
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_AGE) . '<span class="star">*</span></label>
            <div class="controls left_b">
                <input type="text" class="requir" id="age" name="age" value="' . custom_set_value('age') . '" >
            </div>
        </div>
		';
            }
            ?>

            <div class="control-group bottom_space">
                <label for="inputError" class="control-label left_a"><?php echo _clang(WRITE_ADD_DESCRIPTION); ?><span class="star">*</span></label>
                <div class="controls left_b">
                    <!--   <textarea class="tinymce ckeditor" id="editor" name="description"></textarea>-->

                    <textarea name="description"  class="requir des_height" id="description"><?php echo custom_set_value('description') ?></textarea><br>
                    <input type="button" value="Bold" onclick="formatText(description, 'b');" />
                    <input type="button" value="Italic" onclick="formatText(description, 'i');" />
                    <input type="button" value="Underline" onclick="formatText(description, 'u');" />

                </div>
            </div>
            <?php
            if ($parent_id == 9) {
                echo '
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_AD_PLACE) . '</label>
            <div class="controls left_b">
               <input type="radio" value="Owner/Property Manager" ' . custom_set_radio('ad_placed_by', 'Owner/Property Manager') . ' name="ad_placed_by">
               <span>Owner/Property Manager</span>
               <input type="radio" value="Agency/Locator Service" ' . custom_set_radio('ad_placed_by', 'Agency/Locator Service') . ' name="ad_placed_by">
               <span>Agency/Finder Service</span>
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_FEES_PAID) . '</label>
            <div class="controls left_b">
                <input type="text" id="fees_paid_by" name="fees_paid_by" value="' . custom_set_value('fees_paid_by') . '">
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_PETS) . '</label>
            <div class="controls left_b">
                <input type="checkbox" value="Cats Ok" ' . custom_set_radio('pets', 'Cats Ok') . ' name="pets"><span style="margin:0 8px 0 3px;">Cats Ok</span>
                <input type="checkbox" value="Dogs Ok" ' . custom_set_radio('pets', 'Dogs Ok') . ' name="pets"><span style="margin:0 8px 0 3px;">Dogs Ok</span>
            </div>
        </div>
		';
            }
            ?>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label left_a"><?php echo _clang(WRITE_ADD_ADDRESS); ?></label>
                <div class="controls left_b">
                    <textarea id="address" name="address" value="" ><?php echo custom_set_value('address') ?></textarea>
                </div>
            </div>
            <?php
            if ($parent_id == 5) {
                echo '
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_SALARY_WAGE) . '</label>
            <div class="controls left_b">
                <input type="text" id="salary" name="salary" value="' . custom_set_value('salary') . '" >
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_EDUCATION) . '</label>
            <div class="controls left_b">
                <input type="text" id="education" name="education" value="' . custom_set_value('education') . '" >
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_WORK_STATUS) . '</label>
            <div class="controls left_b">
                <input type="checkbox" value="Full-time"  ' . set_checkbox('work_status', 'Full-time') . ' name="work_status[]">
                <span style="margin:0 8px 0 3px;">Full-time</span>
                <input type="checkbox" value="Part-time"  ' . set_checkbox('work_status', 'Part-time') . ' name="work_status[]">
                <span style="margin:0 8px 0 3px;">Part-time</span>
                <input type="checkbox" value="Temp/Contract"  ' . set_checkbox('work_status', 'Temp/Contract') . ' name="work_status[]">
                <span style="margin:0 8px 0 3px;">Temp/Contract</span>
                <input type="checkbox" value="Internship"  ' . set_checkbox('work_status', 'Internship') . ' name="work_status[]">
                <span style="margin:0 8px 0 3px;">Internship</span>
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left_a">' . _clang(WRITE_ADD_SHIFT) . '</label>
            <div class="controls left_b">
                <input type="checkbox" value="Days" ' . set_checkbox('shift', 'Days') . ' name="shift[]">
                <span style="margin:0 8px 0 3px;">Days</span>
                <input type="checkbox" value="Nights" ' . set_checkbox('shift', 'Nights') . ' name="shift[]">
                <span style="margin:0 8px 0 3px;">Nights</span>
                <input type="checkbox" value="Weekends" ' . set_checkbox('shift', 'Nights') . ' name="shift[]">
                <span style="margin:0 8px 0 3px;">Weekends</span>
            </div>
        </div>
		';
            }
            ?>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label left_a"><?php echo _clang(WRITE_ADD_POSTCODE); ?></label>
                <div class="controls left_b">
                    <input type="text" id="postcode" name="postcode" value="<?php echo custom_set_value('postcode') ?>" >
                </div>
            </div>
            <?php if (!$this->session->userdata('is_logged_in')) { ?>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_EMAIL); ?>:<span class="star">*</span></label>
                    <div class="controls left_r">
                        <input type="text" class="requir" id="email" name="email" value="<?php echo custom_set_value('email') ?>" >

                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_CONFIRM_EMAIL); ?>:<span class="star">*</span></label>
                    <div class="controls left_r">
                        <input type="text" class="requir" id="confirm_email" name="confirm_email" value="<?php echo custom_set_value('confirm_email') ?>" >

                    </div>
                </div><?php
            } else {
                ?>
                <div class = "control-group bottom_space">
                    <label for = "inputError" class = "control-label left"><?php echo _clang(WRITE_ADD_EMAIL); ?>:<span class = "star">*</span></label>
                    <div class = "controls left_r">
                        <?php $email = $this->session->userdata('primary_email'); ?>
                        <input type = "text" class="requir" id = "email" name = "email" value = "<?php echo (!empty($email) ? $email : custom_set_value('email')) ?>" >

                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_CONFIRM_EMAIL); ?>:<span class="star">*</span></label>
                    <div class="controls left_r">
                        <input type="text" class="requir" id="confirm_email" name="confirm_email" value="<?php echo (!empty($email) ? $email : custom_set_value('email')) ?>" >

                    </div>
                </div>
            <?php } ?>
            <?php if ($check_adult != "YES") { ?>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left_a"><?php echo _clang(WRITE_ADD_CONTACT_NO); ?>:<span class="star">*</span></label>
                    <div class="controls left_b">
                        <input type="text" class="requir" id="contact_number" name="contact_number" value="<?php echo custom_set_value('contact_number') ?>" >
                    </div>
                </div>
            <?php } ?>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label left_a"><?php echo _clang(WRITE_ADD_EMAIL_ENQUIRIES); ?></label>
                <div class="controls left_b">
                    <input type="radio" name="inquery" <?php echo custom_set_radio('inquery', 'yes') ?> value="yes" ><span><?php echo _clang(WRITE_ADD_EMAIL_ENQUIRIES_ONE); ?></span><br />
                    <input type="radio" name="inquery" <?php echo custom_set_radio('inquery', 'no') ?> value="no" ><span><?php echo _clang(WRITE_ADD_EMAIL_ENQUIRIES_TWO); ?></span>
                </div>
            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label left_a"><?php echo _clang(WRITE_ADD_DISPLAY_OPT); ?></label>
                <div class="controls left_b">
                    <input type="radio" name="show_ad_links" <?php echo custom_set_radio('show_ad_links', 'yes') ?> value="yes" ><span><?php echo _clang(WRITE_ADD_DISPLAY_OPT_ONE); ?></span><br />
                    <input type="radio" name="show_ad_links" <?php echo custom_set_radio('show_ad_links', 'no') ?> value="no" ><span><?php echo _clang(WRITE_ADD_DISPLAY_OPT_TWO); ?></span>
                </div>
            </div>
            <div class="control-group bottom_space">
                <div class="controls left_b" style="margin-left:126px;">
                    <input type="checkbox" <?php echo custom_set_radio('show_joined_date', 'yes') ?> name="show_joined_date" value="yes" ><span><?php echo _clang(WRITE_ADD_SHOW_DATE_JOIN); ?></span>
                </div>
            </div>
            <div style="margin: 2% 0 0 0">
                <span style="font:13pt arial;"><b><?php echo _clang(WRITE_ADD_VIDEO); ?></b></span>
                <span style="color: #f00;font-size: 10px;font-weight: bold;">(new!)</span>
                <br>
                <span class="editAdText"><?php echo _clang(WRITE_ADD_VIDEO_TEXT); ?></span><br><br>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="video" name="video" />
                </div>
            </div>
            <div style="margin: 2% 0 2% 0">
                <span style="font:13pt arial;"><b><?php echo _clang(WRITE_ADD_UPLOAD_IMG); ?></b></span><br>
                <span><?php echo _clang(WRITE_ADD_UPLOAD_IMG_TEXT); ?></span>
                <br>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image1" name="image1" value="" multiple="multiple"/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image2" name="image2" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image3" name="image3" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image4" name="image4" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image5" name="image5" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image6" name="image6" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image7" name="image7" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image8" name="image8" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image9" name="image9" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image10" name="image10" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image11" name="image11" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_b">
                    <input type="file" id="image12" name="image12" value=""/>
                </div>
            </div>
            <div class="control-group bottom_space" style="border-bottom:2px solid #999999; padding-bottom: 8px;">
                <div class="controls left_b">
                    <h2><?php echo _clang(WRITE_ADD_UPGRADE); ?><span style="font-weight:normal; font-size:12px;">(<?php echo _clang(WRITE_ADD_UPGRADE_MINIMUM); ?> <?php echo $this->session->userdata('currency_type') ?> 0.99)</span></h2>
                </div>
            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label left_a"><?php echo _clang(WRITE_ADD_AUTO_REPOST); ?></label>
                <div class="controls left_b">
                    <div>
                        <input type="checkbox" <?php echo custom_set_radio('auto_repost_ad', 'yes') ?>  name="auto_repost_ad" value="yes" />
                        <span style="margin:0 5px 0 5px;"><?php echo _clang(MOVE_AD_TOP); ?> </span>
                        <div style="display: inline-block"><select name="auto_repost_day" id="day" style="width: 90px;">
                                <?php
                                echo '<option value="">Select</option>';
                                for ($i = 1; $i <= 30; $i++) {
                                    if ($i == '1') {
                                        $days = 'day';
                                    } else {
                                        $days = 'days';
                                    }
                                    echo '<option ' . custom_set_select('auto_repost_day', $i) . '  value="' . $i . '">' . $i . ' ' . $days . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div style="display: inline-block"><span style="margin:0 8px 0 8px;"><?php echo _clang(AFTER); ?></span></div>

                        <div style="display: inline-block">
                            <select name="auto_repost_time" id="time" style="width: 100px;">
                                <?php
                                echo '<option value="">Select</option>';
                                for ($i = 0; $i < 24; $i++) {
                                    echo '<option ' . custom_set_select('auto_repost_time', date("H:i A", strtotime($i . ":00:00"))) . ' value="' . date("H:i A", strtotime($i . ":00:00")) . '">' . date("H:i A", strtotime($i . ":00:00")) . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <span><?php echo _clang(WRITE_ADD_NUM_WEEKS); ?></span>

                    <select id="auto_repost_no_of_time" style="width: 160px;" name="auto_repost_no_of_time" onchange="getTextAutoRepost(this)" >
                        <option value="">select</option>
                        <option <?php echo custom_set_select('auto_repost_no_of_time', '4') ?> value="4">4 times for &#163; 1.00 </option>
                        <option <?php echo custom_set_select('auto_repost_no_of_time', '8') ?> value="8">8 times for &#163; 2.00 </option>
                        <option <?php echo custom_set_select('auto_repost_no_of_time', '12') ?> value="12">12 times for &#163; 3.00 </option>
                        <option <?php echo custom_set_select('auto_repost_no_of_time', '26') ?> value="26">26 times for &#163; 6.00 </option>
                    </select>
                    <div id="hidden_price">

                    </div>
                </div>
            </div>
            <?php /* ?><div class="control-group bottom_space">
              <label for="inputError" class="control-label left">Sponsor Ad</label>
              <div class="controls left_r">
              <input type="checkbox" value="Yes" name="sponsor_ad">
              <span>Your ad will appear highlighted with thumbnails on the right side of the category.</span><span style="color:#FF0000;">More info</span><br />
              <span>Number of weeks:</span>
              <select id="week" style="width:150px;" name="week">
              <?php
              for ($i = 1; $i <= 52; $i++) {
              echo '<option value="' . $i . '">' . $i . ' week (&#163;' . $i * 0.02 . ')</option>';
              }
              ?>
              </select>
              </div>
              </div><?php */ ?>


            <div class="control-group bottom_space">
                <label for="inputError" class="control-label left_a"><?php echo _clang(WRITE_ADD_PROMOCODE); ?></label>
                <div class="controls left_b">
                    <input type="text" id="promocode" name="promocode" value="<?php echo custom_set_value('promocode') ?>" >

                </div>
            </div>

            <div class="control-group bottom_space" id="sp">

                <div class="controls left_b">
                    <div class="comment_recaptcha"><?php echo $recaptcha_html; ?></div>
                </div>
            </div>
            <div class="form-actions_views">
                <div class="form-actions" id="st">
                    <button class="btn_mult" type="submit"><?php echo _clang(WRITE_ADD_CONTINUE_BTN); ?></button>
                    <!--                <a class="btn" href="" onclick="window.history.go(-1);
                            return false;">Cancel</a>-->
                </div>
                <div class="st_text"> <?php echo _clang(PRIVACY_AGREE_TEXT); ?> <a href="<?php echo site_url('term'); ?>"><?php echo _clang(TERMS); ?></a>
                    <?php
                    $str = "";
                    if ($parent_id == 4 || $parent_id == 11) {
                        $str = "and ";
                        $str.='<a href="' . site_url("privacy") . '"> "' . _clang(WRITE_ADD_PRIVACY) . '"</a>';
                    }
                    echo $str;
                    ?>
                    .</div>

            </div>
        </fieldset>
        <?php echo form_close(); ?>
    </div>
</section>
<script>
    function getTextAutoRepost() {
        var price = $('#auto_repost_no_of_time>option:selected').text();
        var result_price = price.split(" ");
        $('#hidden_price').html("<input type='hidden' name='auto_repost_price' value='" + result_price[4] + "'>");
    }
</script>