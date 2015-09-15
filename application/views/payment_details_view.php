<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>-->
<style>
    h1 {

        font-family: "Questrial",Verdana,sans-serif;
        font-size: 20px;
        padding: 0;
        position: relative;

    }

    p {
        margin-bottom: 20px;
    }

    label:before {
        color: #c1bfbd;
        transition: color 1s ease 0s;
    }
    label {
        color: #7f7e7e;
        transition: color 1s ease 0s;
    }
    input:not([type="submit"]) {
        height: 40px;
    }
    input:required, textarea:required {
        box-shadow: none;
    }
    .iconic:before {
        font-family: "IconicStroke";
        font-size: 25px;
    }
    input:required, textarea:required {
        box-shadow: none;
    }
    textarea {
        min-height: 150px;
        resize: vertical;
    }
    #currentUser {
        color: #4668a8;
        font-size: 20px;
        font-weight: bold;
        padding-left: 14.3%;
        padding-top: 3%;
    }
    .ali{
        text-align: center;
    }
</style>
<script>
    $(function() {
        $("#expire").datepicker({
            minDate: '0'});
    });
</script>
</script>

<section class="main_div" id="SignupForm">

    <div class="set_errors ali">
        <?php
        if ($this->session->flashdata('validation_error_messages')) {
            echo $this->session->flashdata('validation_error_messages');
        }
        echo validation_errors();
        if ($this->session->flashdata('flash_message')) {

            echo '<div style="padding: 1%;font-size:17px; text-align: center;" class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo $this->session->flashdata("flash_reset_url");
            echo '</div>';
        }
        ?>

    </div>
    <div id="currentUser">
        <?php
        echo $email;
        $ci = & get_instance();
        $ci->load->model('affiliate_model');
        $ci->load->model('write_add_model');
        $user_details = $ci->affiliate_model->get_data_by_id('user', 'primary_email', $email);
        $user_email = base64url_encode($email);
        $user_id = $user_details[0]['user_id'];
        ?>
        <br>
        <span style="color:#000;font-size:16px;font-weight:normal;">
            <?php echo _clang(HELLO_AFFILIATE); ?> <span style="color:#f00;"><?php echo $user_details[0]['affiliate_number']; ?></span>:
            <a href='<?php echo site_url("affiliate/affiliate_account_content/$user_id") ?>'><?php echo _clang(TOOLS); ?> </a> |
            <a href="<?php echo site_url('affiliate/EarningsReport/' . $user_email) ?>"><?php echo _clang(REPORTS); ?> </a> |
       <!--       <a href="<?php echo site_url('affiliate/PaymentHistory/' . $user_email) ?>">Payment History</a> |
             <a href="<?php echo site_url('affiliate/PaymentInfo/' . $user_email) ?>">Payment Info</a> |-->
            <a href="<?php echo site_url('affiliate/PaymentInfo/' . $user_email) ?>"><?php echo _clang(PAYMENT_INFO); ?> </a> |
            <a href="<?php echo site_url('affiliate/term/' . $user_email) ?>"><?php echo _clang(AFFILIATE_TERMS); ?> </a> |
            <a href="<?php echo site_url('affiliate/ManageAds/' . $user_email); ?>"><?php echo _clang(ACCOUNT); ?> </a>

        </span>
    </div>
    <div class="main_area signup_wi">
        <div class="form_area">
            <?php if ($this->session->userdata('is_logged_in')) { ?>
                <article>
                    <h1><?php echo _clang(PAYMENT_INFO); ?></h1>
                    <form action="<?php echo site_url('affiliate/PaymentInfo') ?>" method="post" name="payment_info">
                        <div><input type="hidden" name="email" value="<?php echo $email ?>"></div>
                        <div style = "margin:1em 0;">
                            <label><?php echo _clang(NAME); ?><span class="star">*</span></label>
                            <input type="text" value="<?php echo custom_set_value('name') ?>" name="name" class="signup_input">
                        </div>
                        <div style = "margin:1em 0;">
                            <label><?php echo _clang(WRITE_ADD_ADDRESS); ?></label>
                            <input type="text" value="<?php echo custom_set_value('address') ?>" name="address" class="signup_input">
                        </div>
                        <div style = "margin:1em 0;">
                            <label><?php echo _clang(CITY); ?></label>
                            <input type = "text" value="<?php echo custom_set_value('city') ?>" name="city" class="signup_input">
                        </div>
                        <div style = "margin:1em 0;">
                            <label><?php echo _clang(STATE); ?></label>
                            <input type="text" value="<?php echo custom_set_value('state') ?>" name="state" class="signup_input">
                        </div>
                        <div style = "margin:1em 0;">
                            <label><?php echo _clang(ZIP); ?></label>
                            <input type ="text" value="<?php echo custom_set_value('zip_code') ?>" name="zip_code" class="signup_input">
                        </div>
                        <div style = "margin:1em 0;">
                            <label><?php echo _clang(CARD_TYPE); ?><span class="star">*</span></label>
                            <?php
                            $attribute = 'id="card_type" ';
                            echo form_dropdown('card_type', $card_type_opt, '', $attribute);
                            ?>
                        </div>
                        <div style = "margin:1em 0;">
                            <img src="<?php echo base_url(); ?>assets/images/payment/mastercard.png" alt="">
                            <img src="<?php echo base_url(); ?>assets/images/payment/visa.png" alt="">
                            <img src="<?php echo base_url(); ?>assets/images/payment/discover.png" alt="">
                            <img src="<?php echo base_url(); ?>assets/images/payment/diners_club.png" alt="">
                            <img src="<?php echo base_url(); ?>assets/images/payment/jcb.png" alt="">
                            <img src="<?php echo base_url(); ?>assets/images/payment/amex.png" alt="">
                        </div>
                        <div style = "margin:1em 0;">
                            <label><?php echo _clang(CARD_NUMBER); ?><span class="star">*</span></label>
                            <input type = "text" value = "<?php echo custom_set_value('card_number') ?>" name="card_number" class="signup_input">
                        </div>
                        <div style = "margin:1em 0;">
                            <label><?php echo _clang(EXPIRATION); ?></label>
                            <input type = "text" value ="<?php echo custom_set_value('expire') ?>" placeholder="MM/DD/YY" id="expire" name="expire" class="signup_input">
                        </div>
                        <div style = "margin:1em 0;">
                            <label><?php echo _clang(CVV); ?></label>
                            <input type = "text" value="<?php echo custom_set_value('cvv_code') ?>" name="cvv_code" class="signup_input">
                        </div>
                        <input type = "submit" id="card_s_btn" value = "<?php echo _clang(SAVE); ?>">
                    </form>
                </article>
            <?php } ?>
        </div>
    </div>
</section>


