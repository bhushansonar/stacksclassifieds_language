<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    $(document).ready(function() {
        var checkboxes = $(':checkbox');
        checkboxes.prop('checked', true);
    });

</script>
<style>
    /*.left{ float: left; width:15%; line-height: 25px; }
    .left_r{ float:left; width:85%;}*/
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    /*#title, #email, #confirm_email, #postcode, #location, #selling_price, #contact_number, #age, #price, #fees_paid_by, #salary, #education,#image,#address,#day,#time,#week,#auto_repost,#bedrooms,#promocode{
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
                <li><a href="<?php echo base_url("ad_type") ?>">post ad</a>>></li>
                <li><a href="#"><?php echo $category_name; ?></a>>>
                </li>
                <li>
                    <a href="#"><?php echo $category_name . " " . $sub_category; ?></a>
                     <!--<a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                                                          ?>"><?php //echo $sub_category;                                                            ?></a>-->
                </li>
            </ul>
        </div>
        <h2 style="line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
            Purchase Sponsor Ad
        </h2>

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo validation_errors();
        echo form_open_multipart('manage_ad_list/move_post_ad', $attributes);
        ?>
        <fieldset style="border:none;">
            <input type="hidden" name="posts_id" value="<?php echo $posts_id; ?>"/>
            <div class="control-group bottom_space">
                <div class="controls left_r">
                    <input type="checkbox" id="move_ad_top" name="move_ad_top" value="yes" />
                    <input type="hidden" id="move_ad_top_amount" name="move_ad_top_amount" value="1" />
                    <input type="hidden" id="payment_type" name="payment_type" value="move_ad_top" />
                    <span>For $1.00, your post will be moved to the top of the listings.</span>
                </div>
            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label left">Promocode:</label>
                <div class="controls left_r">
                    <input type="text" id="promocode" name="promocode" value="" >
                </div>
            </div>  
            <div id="re_post_btn" class="form-actions">
                <button class="btn" type="submit">Continue</button>
                <a class="btn" href="<?php echo site_url() ?>manage_ad_list/manage_ad_detail/<?php echo $posts_id; ?>">Cancel</a>
            </div>

        </fieldset>
        <?php echo form_close(); ?>
    </div>
</section>

