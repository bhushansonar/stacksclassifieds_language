<style>
    h1{
        font: 18pt/1.4em arial;
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
        <fieldset style="border:none;">
            <div>
                <h1>
                    <?php echo _clang(EMAIL_SENT); ?>
                </h1>
            </div>
            <div style="margin-top: 1%;font-size: 17px;">
                <?php echo _clang(THANK); ?>
            </div>
            <div style="margin-top: 2%">
                <a href="<?php echo base_url("home"); ?>"><?php echo strtolower($city_name) . ".StacksClassified.com"; ?></a>
            </div>

        </fieldset>


    </div>
</section>


