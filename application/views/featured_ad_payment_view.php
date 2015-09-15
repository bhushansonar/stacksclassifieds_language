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

<div style="text-align:center; margin-bottom:20px;">

</div>

<section class="main_div">
    <div class="main_area">
        <h1>Payment Page</h1>
        <br>
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo validation_errors();
        echo form_open_multipart('payment/payment_send', $attributes);
        ?>

        Payment Amount $<input name="x_amount" value="<?php echo $featured_ad ?>" type="text">
        <input type="hidden" name="posts_id" value="<?php echo $posts_id ?>">
        <input type="submit" class="btn_mult" value="Pay Now">

        <?php echo form_close(); ?>
        <hr>
        To cancel this transaction and return to the posting form,<a class="btn_mult" href='<?php echo base_url("post_national_ads/update/$posts_id") ?>'>click here</a>
    </div>
</section>

