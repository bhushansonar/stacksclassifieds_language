<style>
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
        $parent_id = $this->uri->segment(4);
        $posts_data = $this->reply_model->get_post_data_by_id($posts_id);

        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo validation_errors();
        echo form_open_multipart('reply/email_reply', $attributes);
        ?>

        <fieldset style="border:none;">
            <div class="control-group bottom_space" style="margin-bottom: 20px;">
                <label class="control-label"><b><?php echo _clang(RE); ?></b></label>
                <?php //echo @json_decode($posts_data[0]['title']); ?>
                <?php echo @unserialize(base64_decode($posts_data[0]['title'])); ?>
                <input type="hidden" name="title" value="<?php echo @unserialize(base64_decode($posts_data[0]['title'])); ?>">
                <input type="hidden" name="posts_id" value="<?php echo $posts_id; ?>">
                <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>">
            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label reply_left"><?php echo _clang(WRITE_ADD_EMAIL); ?><span class="star">*</span></label>
                <div class="controls reply_left_r">
                    <input type="text" id="reply_email" name="email" value="" >

                </div>
            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label reply_left"><?php echo _clang(WRITE_ADD_CONFIRM_EMAIL); ?><span class="star">*</span></label>
                <div class="controls reply_left_r">
                    <input type="text" id="reply_confirm_email" name="confirm_email" value="" >
                </div>
            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label reply_left"><?php echo _clang(WRITE_ADD_DESCRIPTION); ?></label>
                <div class="controls reply_left_r">
<!--                    <textarea class="" id="editor" name="description"></textarea>-->
                    <textarea name="description" id="description" class="des_height"></textarea><br>
                    <input type="button" value="Bold" onclick="formatText(description, 'b');" />
                    <input type="button" value="Italic" onclick="formatText(description, 'i');" />
                    <input type="button" value="Underline" onclick="formatText(description, 'u');" />
                </div>
            </div>
            <div class="control-group bottom_space" id="reply_capcha">
                <div class="controls reply_left_r">
                    <div class="comment_recaptcha"><?php echo $recaptcha_html; ?></div>
                </div>
            </div>
            <div class="form-actions" id="reply_btn">
                <button class="btn_mult" type="submit"><?php echo _clang(SEND_REPLY); ?></button>
<!--                <a class="btn" href="<?php echo site_url() ?>/write_add">Cancel</a>-->
            </div>
        </fieldset>

        <?php echo form_close(); ?>
    </div>
</section>