<!--<style>
    h1{
        font: 18pt/1.4em arial;
    }
</style>
<section class="main_div">
    <div class="main_area">
        <div class="set_errors">
<?php
//if ($this->session->flashdata('validation_error_messages')) {
//    echo $this->session->flashdata('validation_error_messages');
//}
//echo validation_errors();
//if ($this->session->flashdata('flash_message')) {
//
//    echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
//    echo '<a class="close" data-dismiss="alert">&#215;</a>';
//    echo $this->session->flashdata("flash_message");
//    echo '</div>';
//}
?>
        </div>
        <fieldset style="border:none;">
            <div>
                <h1>
                    Email has been sent
                </h1>
            </div>
            <div style="margin-top: 1%;font-size: 17px;">
                Thank you
            </div>
            <div style="margin-top: 2%">
                <a href="<?php echo base_url("home"); ?>"><?php echo strtolower($city_name) . ".StacksClassified.com"; ?></a>
            </div>

        </fieldset>


    </div>
</section>-->

<style>
    h2 {
        line-height: 1.2;
        font-size: 22px;
    }
    ul {
        color: #000;
        list-style-type: square !important;
        margin: 0 0 0 1em;
        padding: 0;
    }
</style>
<section class="main_div">
    <div class="main_area">
        <div class="local_hm" style="display: inline-block;width: 87%">
            <ul>
                <li><a href="<?php echo base_url("home"); ?>">Home</a>>></li>
                <li><a ><?php echo $city_name . " " . $category_name; ?></a>>></li>
                <li><a href="<?php echo base_url("heading/getAlltitle/$city_id/$subcategory"); ?>"><?php echo $city_name . " " . $sub_category_name; ?></a>>></li>
                <li> <a href="<?php echo base_url("post_detail/getPostdetails/$posts_id/$parent_id/$city_id") ?>"><?php echo _clang(AD); ?></a>>></li>
                <li> <a href="<?php echo base_url("reply/email_reply/$posts_id/$parent_id"); ?>"><?php echo _clang(REPLY); ?> </a></li>
            </ul>
        </div>
        <fieldset style="border:none;">
            <div style="margin-top: 2%">
                <h2>
                    <?php echo _clang(REPLY_SENT); ?>
                </h2>

                <p><?php echo _clang(LIKE_NEXT); ?></p>

                <ul>
                    <li><a href="<?php echo base_url("reply/email_reply/$posts_id/$parent_id"); ?>"><?php echo _clang(VIEW_AGAIN); ?></a><br><br></li>

                    <li><a href="<?php echo base_url("heading/getAlltitle/$city_id/$subcategory"); ?>"><?php echo _clang(BACK_LIST); ?></a></li>
                </ul>
            </div>
        </fieldset>
    </div>
</section>
