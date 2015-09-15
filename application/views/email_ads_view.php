<style>
    .left{ float: left; width:15%; line-height: 25px; }
    .left_r{ float:left; width:85%;}
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    label{color: #3d3d3d;transition: color 1s ease 0s;}
    .btn_mult {
        background-color: #506fa3;
        border: 1px outset #ccc;
        color: #fff;
        cursor: pointer;
    }

</style>
<script>
    function formatText(el, tag) {
        var selectedText = document.selection ? document.selection.createRange().text : el.value.substring(el.selectionStart, el.selectionEnd);
        if (selectedText != '') {
            var newText = '<' + tag + '>' + selectedText + '</' + tag + '>';
            el.value = el.value.replace(selectedText, newText)
        }
    }
</script>
<section class="main_div">
    <div class="main_area">
        <?php
        $ci = & get_instance();
        $ci->load->model('reply_model');
        $posts_id = $this->uri->segment(3);
        $category_id = $this->uri->segment(4);
        $posts_data = $this->reply_model->get_post_data_by_id($posts_id);

        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo validation_errors();
        echo form_open_multipart('reply/email_ads', $attributes);
        ?>

        <fieldset style="border:none;">
            <div class="control-group bottom_space" style="margin-bottom: 20px;">
                <input type="hidden" name="title" value="<?php echo @unserialize(base64_decode($posts_data[0]['title'])); ?>">
                <input type="hidden" name="post_description" value="<?php echo @unserialize(base64_decode($posts_data[0]['description'])); ?>">
                <input type="hidden" name="posts_id" value="<?php echo $posts_id; ?>">
                <input type="hidden" name="parent_id" value="<?php echo $category_id; ?>">
            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label email_view"><?php echo _clang(YOUR_EMAIL); ?><span class="star">*</span></label>
                <div class="controls email_view_r">
                    <input type="text" id="email_ads_view_pt" name="email" value="" >

                </div>
            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label email_view"><?php echo _clang(RECIPIENT_EMAIL); ?><span class="star">*</span></label>
                <div class="controls email_view_r">
                    <input type="text" id="reciever_email_ads_view_pt" name="reciever_email" value="" >
                </div>
            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label email_view"><?php echo _clang(WRITE_ADD_DESCRIPTION); ?></label>
                <div class="controls email_view_r">
<!--                    <textarea class="tinymce ckeditor" id="editor" name="description"></textarea>-->
                    <textarea name="description" id="description" class="des_height"></textarea><br>
                    <input type="button" value="Bold" onclick="formatText(description, 'b');" />
                    <input type="button" value="Italic" onclick="formatText(description, 'i');" />
                    <input type="button" value="Underline" onclick="formatText(description, 'u');" />
                </div>
            </div>


            <div class="control-group bottom_space" id="email_view_capcha">

                <div class="controls email_view_r">
                    <div class="comment_recaptcha"><?php echo $recaptcha_html; ?></div>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn_mult" type="submit"><?php echo _clang(SEND_REPLY); ?></button>
<!--                <a class="btn" href="<?php echo site_url() ?>/write_add">Cancel</a>-->
            </div>
        </fieldset>

        <?php echo form_close(); ?>
    </div>
</section>


