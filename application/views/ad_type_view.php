<style>
    a{ color:#5C80BB; text-decoration: underline;}
    li{ margin-top:20px; font-size:17px; list-style:none;list-style-type: square;}

    h1{
        font-size: 21px;

    }
</style>
<section class="main_div">
    <div class="main_area">
        <div class="form_area">
            <div class="local_hm" style="margin-bottom: 1%">
                <ul>
                    <li><a href="<?php echo base_url("home") ?>">StacksClassifieds.com</a>>></li>
                    <li><a href="<?php echo base_url("ad_type") ?>"><?php echo _clang(POST_AD); ?></a></li>

                </ul>
            </div>
            <h1 style="text-align: left;"><?php echo _clang(POST_AN_AD); ?></h1>
            <div class="post_type_div">
                <ul>
                    <?php
                    $multiple = 'multiple';
                    ?>
                    <li><a href="<?php echo base_url("single_city") ?>"><?php echo _clang(POST_LOCAL_ADS); ?></a> (<?php echo _clang(MAINLY_FREE); ?>)</li>
                    <li><a href="<?php echo base_url("add_post/addpostdata/$multiple"); ?> "><?php echo _clang(POST_IN_MULT_CITIES); ?></a> (<?php echo _clang(PAID_SPONSOR_ADS); ?>)</li>

                </ul>
                <div style="margin-top:20px;font-size: 17px;"><?php echo _clang(AD_TYPE_MSG); ?></div>
            </div>
        </div>
    </div>
</section>