<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replaceAll('tinymce');
</script>
<style>
    /*.aff_left_user{ float: left; width:15%; line-height: 25px; }
    .aff_left_user_r{ float:left; width:85%;}*/
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    /*#title, #email, #confirm_email, #postcode, #location, #selling_price, #contact_number, #age, #price, #fees_paid_by, #salary, #education{ border: 1px solid #ccc; border-radius: 3px; padding: 4px; width: 158px;}*/

    label{color: #3d3d3d;transition: color 1s ease 0s;}
    .btn_mult {
        background-color: #506fa3;
        border: 1px outset #ccc;
        color: #fff;
        cursor: pointer;
    }
    .ali{
        text-align: center;
    }

</style>
<div class="set_errors ali">
    <?php
    if ($this->session->flashdata('validation_error_messages')) {
        echo $this->session->flashdata('validation_error_messages');
    }
    echo validation_errors();
    if ($this->session->flashdata('flash_message')) {

        echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
        echo '<a class="close" data-dismiss="alert">&#215;</a>';
        echo $this->session->flashdata("flash_message");
        echo '</div>';
    }
    ?>
</div>
<section class="main_div">
    <div class="main_area">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart('affiliate/affiliate_user', $attributes);
        ?>

        <fieldset style="border:none;">
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label aff_left_user">Email<span class="star">*</span></label>
                <div class="controls aff_left_user_r">
                    <input type="hidden" id="email" name="from_email" value="<?php echo $from_email; ?>" >
                    <input type="hidden" id="affiliate_number" name="affiliate_number" value="<?php echo $affiliate_number ?>" >
                    <input type="text" id="email" name="email" value="<?php echo custom_set_value('email') ?>" >
                </div>

            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label aff_left_user">Confirm Email<span class="star">*</span></label>
                <div class="controls aff_left_user_r">
                    <input type="text" id="confirm_email" name="confirm_email" value="<?php echo custom_set_value('confirm_email') ?>" >
                </div>
            </div>
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label aff_left_user">Description(copy Html)<span class="star">*</span></label>
                <div class="controls aff_left_user_r">
                    <textarea  id="description" name="description" class="des_height"><?php echo custom_set_value('description') ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn_mult" type="submit">Send Email</button>
            </div>
        </fieldset>

        <?php echo form_close(); ?>
    </div>
</section>


