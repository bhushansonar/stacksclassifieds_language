
<style>
    .scroll p{
        text-align: justify;
    }
    ul{
        padding-left: 3.5em;
    }
    /*    .scroll{
            height: 50%;
            overflow: auto;
        }*/
</style>
<section class="main_div">
    <div class="main_area">
        <div class="scroll">
            <?php echo @cms_block($warning_block); ?>
        </div>
        <?php
        if ($type == 'city') {
            ?>
            <div style="margin-top: 2%;margin-bottom: 2%">
                <a  href="<?php echo base_url("heading/getAlltitle/$id/$sub_category_id") ?>">I agree</a>
            </div>
            <div style = "margin-top: 2%;margin-bottom: 2%">
                <a href = "<?php echo base_url("citycategory/cat/$id/$name"); ?>">I don't agree</a>
            </div>
        <?php } else { ?>
            <div style="margin-top: 2%;margin-bottom: 2%">
                <a  href="<?php echo base_url("heading/get_all_title_data/$id/$sub_category_id") ?>">I agree</a>
            </div>
            <div style = "margin-top: 2%;margin-bottom: 2%">
                <a href = "<?php echo base_url("state_category/cat/$id/$name"); ?>">I don't agree</a>
            </div>
        <?php }
        ?>
    </div>
</section>