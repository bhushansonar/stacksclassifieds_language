<style>
    .left{ float: left; width:15%; line-height: 25px; }
    .left_r{ float:left; width:85%;}
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    /*#title, #email, #confirm_email, #postcode, #location, #selling_price, #contact_number, #age, #price, #fees_paid_by, #salary, #education{ border: 1px solid #ccc; border-radius: 3px; padding: 4px; width: 158px;}*/
    #email,#confirm_email{
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
    .btn_mult {
        background-color: #506fa3;
        border: 1px outset #ccc;
        color: #fff;
        cursor: pointer;
    }

</style>
<section class="main_div">
    <div class="main_area">
        <div class="set_errors">
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
        <?php
        //echo validation_errors();
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart('post_detail/posts_reported_ads', $attributes);
        ?>

        <fieldset style="border:none;">
            <div class="control-group bottom_space" style="margin-bottom: 20px;">
                <label class="control-label"><b><h1><?php echo _clang(REPORT_AD); ?></h1></b></label>
            </div>
            <div class="control-group bottom_space" style="margin-bottom: 20px;">
                <?php echo _clang(SELECT_CATEGORY); ?>
                <input type="hidden" name="posts_id" value="<?php echo $posts_id ?>">
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_r">
                    <input type="radio"  name="repote_ad" value="Inappropriate Content" >
                    Inappropriate or Illegal Content - If this involves a threat to a child or an image of child exploitation, please email
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_r">
                    <input type="radio"  name="repote_ad" value="Over Posted" >
                    Over Posted/Spam
                </div>
            </div>
            <div class="control-group bottom_space">

                <div class="controls left_r">
                    <input type="radio"  name="repote_ad" value="Wrong Category" >
                    Wrong Category
                </div>
            </div>
            <!--            <div class="control-group bottom_space">
                            <label for="inputError" class="control-label left">Description</label>
                            <div class="controls left_r">
                                <textarea class="tinymce ckeditor" id="editor" name="description"></textarea>
                            </div>
                        </div>-->


            <div class="control-group bottom_space">

                <div class="controls left_r">
                    <div class="comment_recaptcha_one"><?php echo $recaptcha_html; ?></div>
                </div>
            </div>
            <div class="form-actions_new">
                <button class="btn_mult" type="submit"><?php echo _clang(SUBMIT_REPORT); ?></button>

            </div>
        </fieldset>

        <?php echo form_close(); ?>
    </div>
</section>


