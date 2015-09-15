<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox();
    });
    var base_url = '<?php echo base_url() ?>';

    function getPerPlaces(obj, child_type) {
        var parent_id = $(obj).val();
//        toggle_loader($('#per_' + child_type))
        $('#per_' + child_type)
        if (parent_id != "") {
            $.ajax({
                type: 'POST',
                url: base_url + "common_ctrl/get_places",
                data: {child_type: child_type, parent_id: parent_id},
                success: function(data) {
                    $('#per_' + child_type).html(data);
                    $('#per_' + child_type).change();
//                    toggle_loader($('#per_' + child_type), 1);
                }
            });
        } else {
            $('#per_' + child_type).html('<option value="">Select</option>');
            $('#per_' + child_type).change();
//            toggle_loader($('#per_' + child_type), 1);
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
    $(document).ready(function() {
        var category_id = '<?php echo $posts[0]['category']; ?>';
        getInputText(category_id);
    });
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
            <a href="#">Update</a>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Updating <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>



    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open_multipart('admin/posts/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php foreach ($posts as $posts_content) { ?>
            <input type="hidden" value="<?php echo $posts_content['posts_id'] ?>" name="posts_id" />
            <div class="control-group">
                <label for="inputError" class="control-label">Main Category:-</label>
                <div class="controls">
                    <?php
                    $js = "getPerCategory(this,'subcategory')";
                    $attribute = 'id="per_main_category" onchange="' . $js . '" ';
                    echo form_dropdown('category', $main_category_opt, $posts_content['category'], $attribute);
                    ?>

                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Subcategory:-</label>
                <div class="controls">
                    <?php
                    $attribute = 'id="per_subcategory" ';
                    echo form_dropdown('subcategory', $subcategory_opt, $posts_content['subcategory'], $attribute);
                    ?>

                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Country:-</label>
                <div class="controls">
                    <?php
                    $js = " getPerPlaces(this,'state') ";
                    $attribute = 'id="per_country"  onchange="' . $js . '" ';
                    echo form_dropdown('country', $country_opt, $posts_content['country'], $attribute);
                    ?>

                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">States:-</label>
                <div class="controls">
                    <?php
                    $js = "getPerPlaces(this,'city')";
                    $attribute = 'id="per_state"  onchange="' . $js . '" ';

                    echo form_dropdown('state', $state_opt, $posts_content['state'], $attribute);
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">City</label>
                <div class="controls">
                    <?php
                    $attribute = 'id="per_city" ';
                    echo form_dropdown('city', $city_opt, $posts_content['city'], $attribute);
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Title<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="" name="title" value="<?php echo unserialize(base64_decode($posts_content['title'])) ?>" >

                </div>
            </div>

            <div class = "control-group inputshow1" style = "display: none">
                <label for = "inputError" class = "control-label">Selling Price</label>
                <div class = "controls">
                    <input type = "text" id = "" name = "selling_price" value = "<?php echo $posts_content['selling_price'] ?>" >
                </div>
            </div>

            <div class="control-group inputshow2" style="display: none">
                <label for="inputError" class="control-label">Price</label>
                <div class="controls">
                    <input type="text" id="" name="price" value="<?php echo $posts_content['price'] ?>" >
                </div>
            </div>
            <div class="control-group inputshow2" style="display: none">
                <label for="inputError" class="control-label">Bedrooms</label>
                <div class="controls">
                    <?php
                    $attribute = 'id="bedrooms" ';
                    $bedrooms = $posts_content['bedrooms'];
                    $bedrooms_opt = array('' => 'Select', '0' => 'Studio', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8');
                    echo form_dropdown('bedrooms', $bedrooms_opt, $bedrooms, $attribute);
                    ?>
                </div>
            </div>
            <div class = "control-group">
                <label for = "inputError" class = "control-label">Location<span class="star">*</span></label>
                <div class = "controls">
                    <input type = "text" id = "" name = "location" value = "<?php echo $posts_content['location']; ?>" >
                </div>
            </div>

            <div class = "control-group inputshow3" style = "display: none">
                <label for = "inputError" class = "control-label">Age<span class="star">*</span></label>
                <div class = "controls">
                    <input type = "text" id = "" name = "age" value = "<?php echo $posts_content['age']; ?>" style = "width:8%">
                </div>
            </div>
            <div class = "control-group inputshow4" style = "display: none">
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
                <label for = "inputError" class = "control-label">Ad Placed By</label>
                <div class = "controls">
                    <input type = "radio" <?php echo $owner_ad_placed_by ?> value = "Owner_Property_Manager" name="ad_placed_by">
                    <span>Owner/Property Manager</span>
                    <input type="radio" <?php echo $ad_placed_by ?> value="Agency_Locator_Service"  name="ad_placed_by">
                    <span>Agency/Finder Service</span>
                </div>
            </div>
            <div class="control-group inputshow4" style="display: none">
                <label for="inputError" class="control-label">Fees Paid By</label>
                <div class="controls">
                    <input type="text" id="" name="fees_paid_by" value="<?php echo $posts_content['fees_paid_by']; ?>" >
                </div>
            </div>
            <div class="control-group inputshow4" style="display: none">
                <label for="inputError" class="control-label">Pets</label>
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
                <div class="controls">
                    <input type="checkbox" <?php echo $pets_cat; ?> value="cats_ok"  name="pets"><span style="margin:0 8px 0 3px;">Cats Ok</span>
                    <input type="checkbox" <?php echo $pets; ?> value="dogs_ok"  name="pets"><span style="margin:0 8px 0 3px;">Dogs Ok</span>
                </div>
            </div>
            <div class="control-group inputshow4" style="display: none">
                <label for="inputError" class="control-label">Salary/Wage</label>
                <div class="controls">
                    <input type="text" id="salary" name="salary" value="<?php echo $posts_content['salary'] ?>" >
                </div>
            </div>
            <div class="control-group inputshow4" style="display: none">
                <label for="inputError" class="control-label">Education</label>
                <div class="controls">
                    <input type="text" id="education" name="education" value="<?php echo $posts_content['education']; ?>" >
                </div>
            </div>
            <div class="control-group inputshow4" style="display: none">
                <label for="inputError" class="control-label">Work Status</label>
                <?php
                $work_status_arr = explode(',', $posts_content['work_status']);

                if (in_array("Full-time", $work_status_arr)) {
                    $full_time = "checked='checked'";
                } else {
                    $full_time = "";
                }
                if (in_array("Part-time", $work_status_arr)) {
                    $part_time = "checked='checked'";
                } else {
                    $part_time = "";
                }
                if (in_array("Temp/Contract", $work_status_arr)) {
                    $temp_contract = "checked='checked'";
                } else {
                    $temp_contract = "";
                }
                if (in_array("Internship", $work_status_arr)) {
                    $internship = "checked='checked'";
                } else {
                    $internship = "";
                }
                ?>
                <div class="controls">
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
            <div class="control-group inputshow4" style="display: none">
                <label for="inputError" class="control-label left">Shift</label>
                <div class="controls left_r">
                    <?php
                    $shift_arr = explode(',', $posts_content['shift']);

                    if (in_array("Days", $shift_arr)) {
                        $days = "checked='checked'";
                    } else {
                        $days = "";
                    }
                    if (in_array("Nights", $shift_arr)) {
                        $nights = "checked='checked'";
                    } else {
                        $nights = "";
                    }
                    if (in_array("Weekends", $shift_arr)) {
                        $weekends = "checked='checked'";
                    } else {
                        $weekends = "";
                    }
                    ?>
                    <input type='checkbox' <?php echo $days; ?> value='Days' name='shift[]'>
                    <span style='margin:0 8px 0 3px;'>Days</span>
                    <input type='checkbox' <?php echo $nights; ?> value='Nights' name='shift[]'>
                    <span style='margin:0 8px 0 3px;'>Nights</span>
                    <input type='checkbox' <?php echo $weekends; ?> value='Weekends' name='shift[]'>
                    <span style='margin:0 8px 0 3px;'>Weekends</span>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Address</label>
                <div class="controls">
                    <textarea id="address" name="address" value="" ><?php echo $posts_content['address']; ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Postcode</label>
                <div class="controls">
                    <input type="text" id="postcode" name="postcode" value="<?php echo $posts_content['postcode']; ?>" >
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Description </label>
                <div class="controls">
                    <textarea class="tinymce ckeditor" id="editor" name="description"><?php echo unserialize(base64_decode($posts_content['description'])) ?></textarea>
    <!--                    <textarea name="description" id="description" class="requir des_height"><?php echo unserialize(base64_decode($posts_content['description'])) ?></textarea><br>
                    <input type="button" value="Bold" onclick="formatText(description, 'b');" />
                    <input type="button" value="Italic" onclick="formatText(description, 'i');" />
                    <input type="button" value="Underline" onclick="formatText(description, 'u');" />-->
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Email:</label>
                <div class="controls">
                    <input type="text" id="" name="email" value="<?php echo $posts_content['email'] ?>" >

                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Confirm Email:</label>
                <div class="controls">
                    <input type="text" id="confirm_email" name="confirm_email" value="<?php echo $posts_content['email'] ?>" >

                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Contact Number:<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="contact_number" name="contact_number" value="<?php echo $posts_content['contact_number']; ?>" >

                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Email Enquiries</label>
                <div class="controls">
                    <?php
                    $checked = 'unchecked';
                    $checked1 = 'unchecked';
                    if ($posts_content['inquery'] == 'yes') {
                        $checked = 'checked';
                    } else if ($posts_content['inquery'] == 'no') {
                        $checked1 = 'checked';
                    }
                    ?>
                    <input type="radio" name="inquery" <?php echo $checked; ?> value="yes" ><span>Hide my email address and forward email inquiries to me.</span><br />
                    <input type="radio" name="inquery" <?php echo $checked1; ?> value="no" ><span>I don't want to receive any email enquiries.</span>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Display options</label>
                <div class="controls">
                    <?php
                    $check = 'unchecked';
                    $check1 = 'unchecked';
                    if ($posts_content['show_ad_links'] == 'yes') {
                        $check = 'checked';
                    } else if ($posts_content['show_ad_links'] == 'no') {
                        $check1 = 'checked';
                    }
                    ?>
                    <input type="radio" name="show_ad_links" <?php echo $check ?> value="yes" ><span>Yes, show links to my other postings in section.</span><br />
                    <input type="radio" name="show_ad_links" <?php echo $check1 ?> value="no" ><span>No, do NOT show links to my other postings.</span>
                </div>
            </div>
            <div class="control-group">
                <div class="controls" >
                    <?php
                    $chec = '';
                    if ($posts_content['show_joined_date'] == 'yes') {
                        $chec = 'checked';
                    }
                    ?>
                    <input type="checkbox" <?php echo $chec; ?> name="show_joined_date" value="yes" ><span>Show the date I joined.</span>
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
                    <?php if (!empty($posts_content['video'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <video width="115" controls>
                                <source src="<?php echo base_url(); ?>uploads/video/<?php echo $posts_content['video']; ?>" type="video/mp4">
                            </video>
                        </div>
                        <input type="hidden" name="old_video" value="<?php echo $posts_content['video'] ?>" />
                    <?php } else { ?>
                        <div>

                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image1" id="image1" /></div>
                    <?php if (!empty($posts_content['image1'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image1']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $posts_content['image1']; ?>" />
                            </a>
                        </div>
                        <div>
                            <span class="help-inline"><a href="<?php echo site_url('admin') . '/posts/delete_image/' . $posts_content['posts_id'] . '/1' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden"  name="old_image1" value="<?php echo $posts_content['image1'] ?>" />
                    <?php } ?>

                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image2" id="image2" /></div>
                    <?php if (!empty($posts_content['image2'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image2']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image2']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/2' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image2" value="<?php echo $posts_content['image2'] ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image3" id="image3" /></div>
                    <?php if (!empty($posts_content['image3'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image3']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image3']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/3' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image3" value="<?php echo $posts_content['image3'] ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image4" id="image4" /></div>
                    <?php if (!empty($posts_content['image4'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image4']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image4']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/4' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image4" value="<?php echo $posts_content['image4'] ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image5" id="image5" /></div>
                    <?php if (!empty($posts_content['image5'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image5']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image5']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/5' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image5" value="<?php echo $posts_content['image5'] ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image6" id="image6" /></div>
                    <?php if (!empty($posts_content['image6'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image6']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image6']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/6' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image6" value="<?php echo $posts_content['image6'] ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image7" id="image7" /></div>
                    <?php if (!empty($posts_content['image7'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image7']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image7']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/7' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image7" value="<?php echo $posts_content['image7'] ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image8" id="image8" /></div>
                    <?php if (!empty($posts_content['image8'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image8']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image8']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/8' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image8" value="<?php echo $posts_content['image8'] ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image9" id="image9" /></div>
                    <?php if (!empty($posts_content['image9'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image9']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image9']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/9' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image9" value="<?php echo $posts_content['image9'] ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image10" id="image10" /></div>
                    <?php if (!empty($posts_content['image10'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image10']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image10']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/10' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image10" value="<?php echo $posts_content['image10'] ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image11" id="image11" /></div>
                    <?php if (!empty($posts_content['image11'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image11']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image11']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/11' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image11" value="<?php echo $posts_content['image11'] ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <div><input type="file" name="image12" id="image12" /></div>
                    <?php if (!empty($posts_content['image12'])) { ?>
                        <div style="float:left; padding: 1px;">
                            <a href="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image12']; ?>" class='fancybox'  title="" alt=""  >
                                <img width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $posts_content['image12']; ?>" />
                            </a>
                        </div>
                        <div><span style="display:none;" id="delete_msg">Are you sure to delete this Image?</span>
                            <span class="help-inline"><a href="<?php echo site_url("admin") . '/posts/delete_image/' . $posts_content['posts_id'] . '/12' ?>" class="btn btn-danger complexConfirm">Delete</a></span></div>
                        <input type="hidden" name="old_image12" value="<?php echo $posts_content['image12'] ?>" />
                    <?php } ?>

                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Auto Re-post Ad</label>
                <div class="controls">
                    <div>
                        <?php
                        $ch = '';
                        if ($posts_content['auto_repost_ad'] == 'yes') {
                            $ch = 'checked';
                        }
                        ?>
                        <input type="checkbox" <?php echo $ch; ?> <?php echo custom_set_radio('auto_repost_ad', 'yes') ?> name="auto_repost_ad" value="yes" />
                        <span style="margin:0 5px 0 5px;">Move your ad to the top of the listings every: </span>
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
                                    <option <?php echo $i == $posts_content['auto_repost_day'] ? 'selected="selected"' : '' ?>  value="<?php echo $i ?>"><?php echo $i . ' ' . $days ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div style="display: inline-block"><span style="margin:0 8px 0 8px;">After</span></div>

                        <div style="display: inline-block">
                            <select name="auto_repost_time" id="time" style="width: 100px;">
                                <?php
                                for ($i = 0; $i < 24; $i++) {
                                    //$time = date("H:i A", strtotime($i . ":00:00"));
                                    ?>
                                    <option <?php echo $i == $posts_content['auto_repost_time'] ? 'selected="selected"' : '' ?>  value="<?php echo date("H:i A", strtotime($i . ":00:00")) ?>"><?php echo date("H:i A", strtotime($i . ":00:00")) ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    <span>Number of times:</span>

                    <div style="display: inline-block">
                        <?php
                        $attribute = 'id="auto_repost_no_of_time" style="width:150px;" onchange="getTextAutoRepost(this)"';
                        $auto_repost_no_of_time = $posts_content['auto_repost_no_of_time'];
                        $auto_repost_opt = array('4' => '4 times for &#163; 1.00', '8' => '8 times for &#163; 2.00', '12' => '12 times for &#163; 3.00', '26' => '26 times for &#163; 6.00');
                        echo form_dropdown('auto_repost_no_of_time', $auto_repost_opt, $auto_repost_no_of_time, $attribute);
                        ?>

                    </div>
                    <div>
                        <input id="hidden_price" type="hidden" name="auto_repost_price" value="<?php echo $posts_content['auto_repost_price']; ?>">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">featured AD'S</label>
                <div class="controls">
                    <?php
                    $featured_ad = '';
                    if ($posts_content['featured_ad'] == 'yes') {
                        $featured_ad = 'checked';
                    }
                    ?>
                    <input type = "checkbox" <?php echo $featured_ad; ?> value = "yes" name="featured_ad">
                    <span>Your ad will appear highlighted with thumbnails.</span><br /><br />
                    <span style="margin-left: 2.8% ">Number of weeks:</span>
                    <div style="display: inline-block">
                        <select style="display: inline-block;width: 140px;" name="featured_ad_week_price" id="week" onchange="getval(this);">
                            <?php
                            for ($i = 1; $i <= 52; $i++) {
                                ?>
                                <option <?php echo $i == $posts_content['featured_ad_week'] ? 'selected="selected"' : '' ?>  value="<?php echo $i * 0.02 ?>"><?php echo $i . ' week (&#163; ' . $i * 0.02 . ') ' ?></option>
                            <?php }
                            ?>
                        </select>
                        <div>
                            <input id="featured_ad_week" type="hidden" name="featured_ad_week" value="<?php echo $posts_content['featured_ad_week']; ?>">
                        </div>
                    </div>
                </div>
            </div>


        <?php } ?>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo $this->session->userdata('redirect_url'); ?>">Cancel</a>
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