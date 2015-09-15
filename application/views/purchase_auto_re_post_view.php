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
    /*    .left{ float: left; width:15%; line-height: 25px; }
        .left_r{ float:left; width:85%;}*/

    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    /*    #title, #email, #confirm_email, #postcode, #location, #selling_price, #contact_number, #age, #price, #fees_paid_by, #salary, #education,#image,#address,#day,#time,#week,#auto_repost,#bedrooms,#promocode{
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
    .label{color: #3d3d3d;transition: color 1s ease 0s;}
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
                    <a href="#"><?php echo $category_name . " " . $sub_category; ?></a>
                     <!--<a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                                ?>"><?php //echo $sub_category;                                  ?></a>-->
                </li>
            </ul>
        </div>
        <h2 style="line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
            <?php echo _clang(PURCHASE_RE_POST); ?>
        </h2>

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo validation_errors();
        echo form_open_multipart('payment/single_city_payment', $attributes);
        ?>
        <fieldset style="border:none;">

            <?php
            foreach ($posts_ads_details as $key => $posts_ads) {
                $post_id = $posts_ads['posts_id'];
                ?>
                <input type="hidden" name="posts_id" value="<?php echo $post_id; ?>"/>


                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_AUTO_REPOST); ?></label>
                    <div class="controls left_r">
                        <div>
                            <input type="checkbox" name="auto_repost_ad" value="yes" />
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
                                        echo '<option value="' . $i . '">' . $i . ' ' . $days . '</option>';
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
                                        echo '<option value="' . date("H:i A", strtotime($i . ":00:00")) . '">' . date("H:i A", strtotime($i . ":00:00")) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <span><?php echo _clang(NUMBER_OF_TIMES); ?></span>

                        <div style="display: inline-block">
                            <select id="auto_repost_no_of_time" style="width: 150px;" name="auto_repost_no_of_time" onchange="getTextAutoRepost(this)" >
                                <option value="">select</option>
                                <option value="4">4 times for &#163; 1.00 </option>
                                <option value="8">8 times for &#163; 2.00 </option>
                                <option value="12">12 times for &#163; 3.00 </option>
                                <option value="26">26 times for &#163; 6.00 </option>
                            </select>
    <!--                        <select id="price" style="width: 150px;" name="auto_repost" >
                                <option value="">select</option>
                                <option value="1">4 times for &#163;1.00 </option>
                                <option value="2">8 times for &#163;2.00 </option>
                                <option value="3">12 times for &#163;3.00 </option>
                                <option value="26">26 times for &#163;6.00 </option>
                            </select>-->
                        </div>
                        <div id="hidden_price">

                        </div>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(WRITE_ADD_PROMOCODE); ?></label>
                    <div class="controls left_r">
                        <input type="text" id="promocode" name="promocode" value="" >
                    </div>
                </div>
                <div  id="re_post_btn" class="form-actions">
                    <button class="btn" type="submit"><?php echo _clang(WRITE_ADD_CONTINUE_BTN); ?></button>
                    <a class="btn" href="<?php echo site_url() ?>manage_ad_list/manage_ad_detail/<?php echo $post_id; ?>"><?php echo _clang(CANCLE); ?></a>
                </div>
            <?php } ?>
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