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
    .left{ float: left; width:15%; line-height: 25px; }
    .left_r{ float:left; width:85%;}
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    #title, #email, #confirm_email, #postcode, #location, #selling_price, #contact_number, #age, #price, #fees_paid_by, #salary, #education,#image,#address,#day,#time,#week,#auto_repost,#bedrooms,#promocode{
        border: 1px dashed #dbdbdb;
        border-radius: 2px;
        color: #3f3f3f;
        display: block;
        font-family: "Droid Sans",Tahoma,Arial,Verdana sans-serif;
        font-size: 14px;
        outline: medium none;
        padding: 8px 8px;
        transition: background 0.2s linear 0s, box-shadow 0.6s linear 0s;
        width: 380px;}
    label{color: #3d3d3d;transition: color 1s ease 0s;}
</style>

<section class="main_div">
    <div class="main_area">
        <div class="local_hm">
            <!--            <ul>
                            <li><a href="<?php echo base_url("home") ?>">StacksClassifieds.com</a>>></li>
                            <li><a href="<?php echo base_url("ad_type") ?>">post ad</a>>></li>
                            <li><a href="#"><?php echo $category_name; ?></a>>>
                            </li>
                            <li>
                                <a href="#"><?php echo $category_name . " " . $sub_category; ?></a>
                                 <a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                    ?>"><?php echo $sub_category; ?></a>
                            </li>
                        </ul>-->
        </div>
        <h2 style="line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
            <?php echo _clang(DELETE_AD); ?>
        </h2>

        <?php
        //echo "<pre>";print_r($_POST); die;
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo validation_errors();
        echo form_open_multipart('manage_ad_list/delete_ad_confirm', $attributes);
        ?>
        <input type="hidden" name="posts_id" value="<?php echo $posts_id; ?>"/>
        <div class="control-group bottom_space">
            <h1> <?php echo _clang(PLEASE_DELETE_CONFIRM); ?></h1>
            <p> <?php echo _clang(DELETE_CONTENT); ?></p>
            <div class="form-actions" style="margin-left: 125px;">
                <button class="btn" type="submit"><?php echo _clang(DELETE_OR_NOT); ?></button>
<!--                <a class="btn" href="<?php echo site_url() ?>post_national_ads">Cancel</a>-->
                <a class="btn" onclick="window.history.go(-1);
        return false;" href="#"><?php echo _clang(CANCLE); ?></a>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>

