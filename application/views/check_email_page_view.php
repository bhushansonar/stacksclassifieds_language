<style>
    a{ color:#5C80BB; text-decoration: underline;}
    li{ margin-top:20px; font-size:17px; list-style:none;}
    .post_type_div{
        margin-top: -1%;
        margin-left: 2%;
    }
    h1{
        font-size: 21px;

    }
</style>
<section class="main_div">
    <div class="main_area" style="font-size: 17px;">
        <div class="local_hm">
            <ul>
                <li><a href="<?php echo base_url("home") ?>">StacksClassifieds.com</a>>></li>
                <li><a href="<?php echo base_url("ad_type") ?>">post ad</a>>></li>
                <li><a href="#"><?php echo $category_name; ?></a>>>  
                </li>
                <li>
                    <a href="#"><?php echo $category_name . " " . $sub_category_name; ?></a>
                     <!--<a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                       ?>"><?php echo $subcategory; ?></a>-->
                </li>
            </ul>
        </div>
        <h3 style="line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
            Step3: check email for link
        </h3>
        <ul id="stepButtons">
            <li class="postAdButtonOn">
                <div class="indexSectionHeader">Step 1: Write Ad</div>
            </li>
            <li class="postAdButtonOn">
                <div class="indexSectionHeader">Step 2: Preview Ad</div>
            </li>
            <li class="postAdButtonOn">
                <div class="indexSectionHeader">Step 3: check email for link</div>
            </li>
            <li class="postAdButtonOff">
                <div class="indexSectionHeader">Step 4: All Done</div>
            </li>
        </ul>
        <b>Almost Done!</b>
        <br><br>
        To make your ad live, please click the link sent to <b><?php echo $post_data[0]['email']; ?></b>. <br>If you do not
        receive an email from us shortly after posting please see our <a href="<?php echo site_url('help') ?>">help section.</a>
        <br><br>
        <?php if (!$this->session->userdata('is_logged_in')) {
            ?>
            <a href="<?php echo base_url("signin/signin_user") ?>">Login to your account</a> and click the verify link in the far right column.

            <br>If you do not have an account,
            you can sign up for one by <a href="<?php echo base_url("signup") ?>">clicking here</a>.
            <br><br><br>
            <?php
        } else {
            
        }
        ?>
        To post another ad, <a href="<?php
        $city_id = $post_data[0]['city'];
        echo base_url("add_post/addpostdata/$city_id")
        ?>">click here</a>.
        <br><br>
        To post in multiple cities, <a href="<?php echo site_url(); ?>ad_type/index/multiple">click here</a>.
        <br><br>
        <span data-value="success">Thank you</span><br>
        <b class="emailSig"><a href="<?php echo base_url("citycategory/cat/$city_id"); ?>">
                <?php echo strtolower($city_name); ?>.StacksClassifieds.com
            </a>
        </b><br><br>
    </div>
</section>