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

            <?php
            echo $a = @cms_block(warning_block);
            ?>
        </div>
        <?php if ($multiple_city == 'multiple') { ?>
            <div style="margin-top: 2%">
                <a style=" background-color: #506fa3; border: 1px outset #ccc;color: #fff;font-size: 15px; padding: 2px;text-decoration: none;" href="<?php echo base_url("multiple_city/city_multiple/" . $sub_category_id . "/" . $sub_category_name) ?>">Continue</a>
            </div>
        <?php } else { ?>
            <div style="margin-top: 2%">
                <a style=" background-color: #506fa3; border: 1px outset #ccc;color: #fff;font-size: 15px; padding: 2px;text-decoration: none;" href="<?php echo base_url("write_add/add/" . $city_id . "/" . $city_name) ?>">Continue</a>
            </div>
        <?php } ?>



    </div>
</section>