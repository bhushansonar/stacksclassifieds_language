<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    function getPerPlaces(obj, child_type) {
        var parent_id = $(obj).val();
        $('#per_' + child_type)
        if (parent_id != "") {
            $.ajax({
                type: 'POST',
                url: base_url + "common_ctrl/get_places",
                data: {child_type: child_type, parent_id: parent_id},
                success: function(data) {
                    $('#per_' + child_type).html(data);
                    $('#per_' + child_type).change();
                }
            });
        } else {
            $('#per_' + child_type).html('<option value="">Select</option>');
            $('#per_' + child_type).change();
        }
    }
    function getPerCategory(obj, child_type) {
        var parent_id = $(obj).val();
        getInputText(parent_id);
        $('#per_' + child_type)
        if (parent_id != "") {
            $.ajax({
                type: 'POST',
                url: base_url + "common_ctrl/get_places",
                data: {child_type: child_type, parent_id: parent_id},
                success: function(data) {
                    $('#per_' + child_type).html(data);
                    $('#per_' + child_type).change();
                }
            });
        } else {
            $('#per_' + child_type).html('<option value="">Select</option>');
            $('#per_' + child_type).change();
        }
    }
    function getInputText(category_id) {
        if (category_id == '1' || category_id == '2') {
            $('.inputshow1').show();
        } else {
            $('.inputshow1').hide();
        }
        if (category_id == '8') {
            $('.inputshow2').show();
        } else {
            $('.inputshow2').hide();
        }
        if (category_id == '4' || category_id == '11') {
            $('.inputshow3').show();
        } else {
            $('.inputshow3').hide();
        }
        if (category_id == '9') {
            $('.inputshow4').show();
        } else {
            $('.inputshow4').hide();
        }
    }
    CKEDITOR.replaceAll('tinymce');
</script>


<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url("admin") . '/' . $this->uri->segment(2); ?>">
                <?php echo ucfirst($this->uri->segment(2)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">New</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Adding <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>
    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open_multipart('admin/posts/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">Main Category:-</label>
            <div class="controls">
                <?php
                $js = "getPerCategory(this,'subcategory')";
                $attribute = 'id="per_main_category"  onchange="' . $js . '" ';
                echo form_dropdown('category', $main_category_opt, $category, $attribute);
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Subcategory:-</label>
            <div class="controls">
                <?php
                $attribute = 'id="per_subcategory" ';
                echo form_dropdown('subcategory', $subcategory_opt, $subcategory, $attribute);
                ?>
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Country:-</label>
            <div class="controls">
                <?php
                $js = " getPerPlaces(this,'state') ";
                $attribute = 'id="per_country"  onchange="' . $js . '" ';
                echo form_dropdown('country', $country_opt, $country, $attribute);
                ?>
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">States:-</label>
            <div class="controls">
                <?php
                $js = "getPerPlaces(this,'city')";
                $attribute = 'id="per_state"  onchange="' . $js . '" ';
                echo form_dropdown('state', $state_opt, $state, $attribute);
                ?>
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">City</label>
            <div class="controls">
                <?php
                $attribute = 'id="per_city" ';
                echo form_dropdown('city', $city_opt, $city, $attribute);
                ?>
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Title<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="title" value="" >
            </div>
        </div>

        <div class="control-group inputshow1" style="display: none">
            <label for="inputError" class="control-label">Selling Price</label>
            <div class="controls">
                <input type="text" id="" name="selling_price" value="<?php echo custom_set_value('selling_price'); ?>" >
            </div>
        </div>
        <div class="control-group inputshow2" style="display: none">
            <label for="inputError" class="control-label">Price</label>
            <div class="controls">
                <input type="text" id="" name="price" value="<?php echo custom_set_value('price'); ?>" >
            </div>
        </div>
        <div class="control-group inputshow2" style="display: none">
            <label for="inputError" class="control-label">Bedrooms</label>
            <div class="controls">
                <select id="" name="bedrooms" style="width:15%">
                    <option value="">Select </option>
                    <option <?php echo custom_set_select('bedrooms', '0+') ?>  value="0+">Studio </option>
                    <option <?php echo custom_set_select('bedrooms', '1') ?> value="1">1 </option>
                    <option <?php echo custom_set_select('bedrooms', '2') ?> value="2">2 </option>
                    <option <?php echo custom_set_select('bedrooms', '3') ?> value="3">3 </option>
                    <option <?php echo custom_set_select('bedrooms', '4') ?> value="4">4 </option>
                    <option <?php echo custom_set_select('bedrooms', '5') ?> value="5">5 </option>
                    <option <?php echo custom_set_select('bedrooms', '6') ?> value="6">6 </option>
                    <option <?php echo custom_set_select('bedrooms', '7') ?> value="7">7 </option>
                    <option <?php echo custom_set_select('bedrooms', '8') ?> value="8">8 </option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Location<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="location" value="<?php echo custom_set_value('location'); ?>" >
            </div>
        </div>
        <div class="control-group inputshow3" style="display: none">
            <label for="inputError" class="control-label">Age<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="age" value="<?php echo custom_set_value('age'); ?>" style="width:8%">
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Description</label>
            <div class="controls">
                <textarea class="tinymce ckeditor" id="editor" name="description"></textarea>
<!--                <textarea name="description" id="description" class="requir des_height"></textarea><br>
                <input type="button" value="Bold" onclick="formatText(description, 'b');" />
                <input type="button" value="Italic" onclick="formatText(description, 'i');" />
                <input type="button" value="Underline" onclick="formatText(description, 'u');" />-->
            </div>
        </div>
        <div class="control-group inputshow4" style="display: none">
            <label for="inputError" class="control-label">Ad Placed By</label>
            <div class="controls">
                <input type="radio" value="Owner_Property_Manager" <?php echo custom_set_radio('ad_placed_by', 'Owner_Property_Manager') ?> name="ad_placed_by">
                <span>Owner/Property Manager</span>
                <input type="radio" value="Agency_Locator_Service" <?php echo custom_set_radio('ad_placed_by', 'Agency_Locator_Service') ?> name="ad_placed_by">
                <span>Agency/Finder Service</span>
            </div>
        </div>
        <div class="control-group inputshow4" style="display: none">
            <label for="inputError" class="control-label">Fees Paid By</label>
            <div class="controls">
                <input type="text" id="" name="fees_paid_by" value="<?php echo custom_set_value('fees_paid_by'); ?>" >
            </div>
        </div>
        <div class="control-group inputshow4" style="display: none">
            <label for="inputError" class="control-label">Pets</label>
            <div class="controls">
                <input type="checkbox" value="cats_ok" <?php echo custom_set_radio('pets', 'cats_ok') ?> name="pets"><span style="margin:0 8px 0 3px;">Cats Ok</span>
                <input type="checkbox" value="dogs_ok" <?php echo custom_set_radio('pets', 'dogs_ok') ?> name="pets"><span style="margin:0 8px 0 3px;">Dogs Ok</span>
            </div>
        </div>
        <div class="control-group inputshow4" style="display: none">
            <label for="inputError" class="control-label">Salary/Wage</label>
            <div class="controls">
                <input type="text" id="salary" name="salary" value="<?php echo custom_set_value('salary'); ?>" >
            </div>
        </div>
        <div class="control-group inputshow4" style="display: none">
            <label for="inputError" class="control-label">Education</label>
            <div class="controls">
                <input type="text" id="education" name="education" value="<?php echo custom_set_value('education'); ?>" >
            </div>
        </div>
        <div class="control-group inputshow4" style="display: none">
            <label for="inputError" class="control-label">Work Status</label>
            <div class="controls">
                <input type="checkbox" value="Full-time" <?php echo set_checkbox('work_status', 'Full-time') ?> name="work_status[]">
                <span style="margin:0 8px 0 3px;">Full-time</span>
                <input type="checkbox" value="Part-time" <?php echo set_checkbox('work_status', 'Part-time') ?> name="work_status[]">
                <span style="margin:0 8px 0 3px;">Part-time</span>
                <input type="checkbox" value="Temp/Contract" <?php echo set_checkbox('work_status', 'Temp/Contract') ?> name="work_status[]">
                <span style="margin:0 8px 0 3px;">Temp/Contract</span>
                <input type="checkbox" value="Internship" <?php echo set_checkbox('work_status', 'Internship') ?> name="work_status[]">
                <span style="margin:0 8px 0 3px;">Internship</span>
            </div>
        </div>
        <div class="control-group inputshow4" style="display: none">
            <label for="inputError" class="control-label left">Shift</label>
            <div class="controls left_r">
                <input type="checkbox" value="Days" <?php echo set_checkbox('shift', 'Days') ?> name="shift[]">
                <span style="margin:0 8px 0 3px;">Days</span>
                <input type="checkbox" value="Nights" <?php echo set_checkbox('shift', 'Nights') ?> name="shift[]">
                <span style="margin:0 8px 0 3px;">Nights</span>
                <input type="checkbox" value="Weekends" <?php echo set_checkbox('shift', 'Nights') ?> name="shift[]">
                <span style="margin:0 8px 0 3px;">Weekends</span>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Address</label>
            <div class="controls">
                <textarea id="address" name="address" value="" ><?php echo custom_set_value('address') ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Postcode</label>
            <div class="controls">
                <input type="text" id="postcode" name="postcode" value="<?php echo custom_set_value('postcode') ?>" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Email:<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="email" value="" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Confirm Email:<span class="star">*</span></label>
            <div class="controls">
                <input type="text" class="requir" id="confirm_email" name="confirm_email" value="" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Contact Number:<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="contact_number" name="contact_number" value="<?php echo custom_set_value('contact_numbers') ?>" >

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Email Enquiries</label>
            <div class="controls">
                <input type="radio" name="inquery" <?php echo custom_set_radio('inquery', 'yes') ?> value="yes" ><span>Hide my email address and forward email inquiries to me.</span><br />
                <input type="radio" name="inquery" <?php echo custom_set_radio('inquery', 'no') ?> value="no" ><span>I don't want to receive any email enquiries.</span>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Display options</label>
            <div class="controls">
                <input type="radio" name="show_ad_links" <?php echo custom_set_radio('show_ad_links', 'yes') ?> value="yes" ><span>Yes, show links to my other postings in section.</span><br />
                <input type="radio" name="show_ad_links" <?php echo custom_set_radio('show_ad_links', 'no') ?> value="no" ><span>No, do NOT show links to my other postings.</span>
            </div>
        </div>
        <div class="control-group">
            <div class="controls" >
                <input type="checkbox" <?php echo custom_set_radio('show_joined_date', 'yes') ?> name="show_joined_date" value="yes" ><span>Show the date I joined.</span>
            </div>
        </div>
        <div class="control-group">

            <div style="margin: 2% 0 0 0">
                <span style="font:13pt arial;"><b>Add Video</b></span>
                <span style="color: #f00;font-size: 10px;font-weight: bold;">(new!)</span>
                <br>
                <span class="editAdText">Max length is 30 sec or 15mb.</span><br><br>
            </div>
            <div class="controls">
                <input type="file" id="video" name="video" />
            </div>
        </div>
        <div class="control-group">
            <div>
                <span style="font:13pt arial;"><b>Upload Images</b></span>
                <span class="editAdText">Images must be in jpg, gif, or png format.</span><br><br>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">
                <input type="file" id="image1" name="image1" value=""/>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image2" name="image2" value=""/>

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image3" name="image3" value=""/>

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image4" name="image4" value=""/>

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image5" name="image5" value=""/>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image6" name="image6" value=""/>

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image7" name="image7" value=""/>

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image8" name="image8" value=""/>

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image9" name="image9" value=""/>

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image10" name="image10" value=""/>

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image11" name="image11" value=""/>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: </label>
            <div class="controls">

                <input type="file" id="image12" name="image12" value=""/>

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Auto Re-post Ad</label>
            <div class="controls">
                <div>
                    <input type="checkbox" <?php echo custom_set_radio('auto_repost_ad', 'yes') ?> name="auto_repost_ad" value="yes" />
                    <span style="margin:0 5px 0 5px;">Move your ad to the top of the listings every: </span>
                    <div style="display: inline-block"><select name="auto_repost_day" id="day" style="width: 90px;">
                            <?php
                            echo '<option value="">Select</option>';
                            for ($i = 1; $i <= 30; $i++) {
                                if ($i == '1') {
                                    $days = 'day';
                                } else {
                                    $days = 'days';
                                }
                                echo '<option ' . custom_set_select('auto_repost_day', $i) . ' value="' . $i . '">' . $i . ' ' . $days . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div style="display: inline-block"><span style="margin:0 8px 0 8px;">After</span></div>

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
                <span>Number of times:</span>

                <div style="display: inline-block">
                    <select id="auto_repost_no_of_time" style="width: 150px;" name="auto_repost_no_of_time" onchange="getTextAutoRepost(this)" >
                        <option value="">select</option>
                        <option <?php echo custom_set_select('auto_repost_no_of_time', '4') ?> value="4">4 times for &#163; 1.00 </option>
                        <option <?php echo custom_set_select('auto_repost_no_of_time', '8') ?> value="8">8 times for &#163; 2.00 </option>
                        <option <?php echo custom_set_select('auto_repost_no_of_time', '12') ?> value="12">12 times for &#163; 3.00 </option>
                        <option <?php echo custom_set_select('auto_repost_no_of_time', '26') ?> value="26">26 times for &#163; 6.00 </option>
                    </select>

                </div>
                <div id="hidden_price">

                </div>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">featured AD'S</label>
            <div class="controls">
                <input type="checkbox" value="yes" <?php echo custom_set_radio('featured_ad', 'yes') ?> name="featured_ad">
                <span>Your ad will appear highlighted with thumbnails.</span><br /><br />
                <span style="margin-left: 2.8% ">Number of weeks:</span>
                <div style="display: inline-block">
                    <select style="width: 150px;"id="week" name="featured_ad_week_price" onchange="getval(this);">
                        <?php
                        echo '<option value="">Select</option>';
                        for ($i = 1; $i <= 52; $i++) {

                            echo '<option ' . custom_set_select('featured_ad_week_price', ($i * 0.02)) . ' value="' . $i * 0.02 . '">' . $i . ' week (&#163;' . $i * 0.02 . ')</option>';
                        }
                        ?>
                    </select>
                    <div id="featured_ad_week">

                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/posts">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
<script>
    function getTextAutoRepost() {
        var price = $('#auto_repost_no_of_time>option:selected').text();
        var result_price = price.split(" ");
        $('#hidden_price').html("<input type='hidden' name='auto_repost_price' value='" + result_price[4] + "'>");
    }

    function formatText(el, tag) {
        var selectedText = document.selection ? document.selection.createRange().text : el.value.substring(el.selectionStart, el.selectionEnd);
        if (selectedText != '') {
            var newText = '<' + tag + '>' + selectedText + '</' + tag + '>';
            el.value = el.value.replace(selectedText, newText)
        }
    }

    function getval() {
        var str = $('#week>option:selected').text();
        var result = str.split(" ");
        $('#featured_ad_week').html("<input type='hidden' name='featured_ad_week' value='" + result[0] + "'>");
    }
</script>
