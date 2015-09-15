<style>

    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    h1{
        font-size: 20px;
    }

</style>
<section class="main_div">
    <div class="main_area">
        <div class="local_hm" style="display: inline-block;width: 87%">
            <ul>
                <li><a href="<?php echo base_url("home"); ?>">Home</a>>></li>
                <li><a ><?php echo $city_name . " " . $category_name; ?></a>>></li>
                <li><a href="<?php echo base_url("heading/getAlltitle/$city/$subcategory"); ?>"><?php echo $city_name . " " . $sub_category_name; ?></a>>></li>
                <li> <a href="<?php echo base_url("post_detail/getPostdetails/$posts_id/$category/$city") ?>">ad</a>>></li>
                <li> <a><?php echo _clang(REPORT_AD); ?> </a></li>
            </ul>
        </div>
        <fieldset style="border:none; margin-top: 2%;">
            <div class="control-group bottom_space" style="margin-bottom: 20px;">
                <b><h1>Report Ad</h1></b>
            </div>
            <div class="control-group bottom_space" style="margin-bottom: 20px;">
                <?php echo _clang(REPORT_AD_SUCCESS); ?>
            </div>
            <div class="control-group bottom_space" style="margin-bottom: 20px;">
                <?php echo _clang(ACCIEDENTLLY_REPORTED); ?>
            </div>
            <div class="control-group bottom_space" style="margin-bottom: 20px;">
                <?php echo _clang(INVOLVE); ?>
            </div>
            <div class="control-group bottom_space" style="margin-bottom: 20px;">
                <a href="<?php echo base_url("heading/getAlltitle/$city/$subcategory") ?>"><?php echo _clang(BAKC_TO); ?> <?php echo $sub_category_name . ' ' . $category_name; ?><?php echo _clang(LISTING); ?></a>
            </div>
            <div class="control-group bottom_space" style="margin-bottom: 20px;">
                <a href="<?php echo base_url("post_detail/getPostdetails/$posts_id/$category/$city") ?>"><?php echo _clang(VIEW_AGAIN); ?></a>
            </div>

        </fieldset>
    </div>
</section>


