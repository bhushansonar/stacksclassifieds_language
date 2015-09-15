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
    label{color: #3d3d3d;transition: color 1s ease 0s;}
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
                     <!--<a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                                        ?>"><?php //echo $sub_category;                                          ?></a>-->
                </li>
            </ul>
        </div>
        <h2 style="line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
            <?php echo _clang(PURCHASE_FEATURED_AD); ?>
        </h2>

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo validation_errors();
        echo form_open_multipart('manage_ad_list/purchase_sponsor_ad_post', $attributes);
        ?>
        <fieldset style="border:none;">

            <?php
            foreach ($posts_ads_details as $key => $posts_ads) {
                $post_id = $posts_ads['posts_id'];
                ?>
                <input type="hidden" name="posts_id" value="<?php echo $post_id; ?>"/>


                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left"><?php echo _clang(PURCHASE_FEATURED_AD); ?></label>
                    <div class="controls left_r">
                        <div>
                            <?php
                            $ch = '';
                            if ($posts_ads['featured_ad'] == 'yes') {
                                $ch = 'checked';
                            }
                            ?>
                            <input type="checkbox" <?php echo $ch; ?> name="featured_ad" value="yes" />


                            <span><?php echo _clang(YOUR_AD_HIGHLIGHTED); ?><br />
                                <span><?php echo _clang(WRITE_ADD_NUM_WEEKS); ?></span>
                                <div style="display: inline-block">
                                    <select style="width: 150px;"id="week" name="featured_ad_week_price" >
                                        <?php
                                        echo '<option value="0">Select</option>';
                                        for ($i = 1; $i <= 52; $i++) {

                                            echo '<option value="' . $i * 0.02 . '">' . $i . ' week (&#163;' . $i * 0.02 . ')</option>';
                                        }
                                        ?>
                                    </select>
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
                <div  id="re_post_btn"class="form-actions">
                    <button class="btn" type="submit"><?php echo _clang(WRITE_ADD_CONTINUE_BTN); ?></button>
                    <a class="btn" href="<?php echo site_url() ?>manage_ad_list/manage_ad_detail/<?php echo $post_id; ?>"><?php echo _clang(CANCLE); ?></a>
                </div>
            <?php } ?>
        </fieldset>
        <?php echo form_close(); ?>
    </div>
</section>

