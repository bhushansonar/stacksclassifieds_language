<style>
    .left{ float: left; width:15%; line-height: 25px; }
    .left_r{ float:left; width:85%;}
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    #email, #postcode,#name, #city, #state, #card_number{ border: 1px solid #ccc; border-radius: 3px; padding: 4px; width: 158px;}
    .btn_mult {
        background-color: #506fa3;
        border: 1px outset #ccc;
        color: #fff;
        cursor: pointer;
        padding: 0.5%;
        list-style-type: none;
    }
</style>
<section class="main_div">
    <div class="main_area">
        <h1><?php echo _clang(PAYMENT_PAGE); ?></h1>
        <br>
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo validation_errors();
        echo form_open_multipart('payment/payment_send', $attributes);
        $amt = encrypt($auto_repost);
        ?>

        <?php echo _clang(PAYMENT_AMOUNT); ?> $<input name="x_amount" value="<?php echo $auto_repost ?>" type="text" readonly>
        <input type="hidden" name="posts_id" value="<?php echo $posts_id ?>">
        <input type="hidden" name="amt" value="<?php echo $amt ?>">
        <input type="submit" class="btn_mult" value="Pay Now">

        <?php echo form_close(); ?>
        <hr>
        <label><?php echo _clang(CANCLE_AND_RETURN); ?>
            <a href="#" onclick="history.go(-1);
                    return false;"> click here </a>
            <!--            <a class="btn_mult" href='javascript:history.go(-1)'>click here</a>-->
    </div>
</section>

