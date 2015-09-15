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
            <?php echo $description ?>
        </div>
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart('heading/get_seraching_data_by_category', $attributes);
        ?>
        <input type = "hidden" name = "search_category" value = "<?php echo $category_id; ?>">
        <input type = "hidden" name = "search_text" value = "<?php echo $search_text; ?>">
        <input type = "hidden" name = "disclaimer_agree" value = "YES">
        <?php
        if ($type == 'city') {
            ?>
            <div style="margin-top: 2%;margin-bottom: 2%">
                <button type="submit" type="submit" name="submit">I agree</button>
    <!--                <a  href="<?php echo base_url("heading/get_seraching_data_by_category") ?>">I agree</a>-->
            </div>
            <div style = "margin-top: 2%;margin-bottom: 2%">
                <a href = "<?php echo base_url("citycategory/cat/$id/$name"); ?>">I don't agree</a>
            </div>
        <?php } else { ?>
            <div style="margin-top: 2%;margin-bottom: 2%">

                                    <!--                <a  href="<?php echo base_url("heading/get_all_title_data") ?>">I agree</a>-->
                <button type="submit" type="submit" name="submit">I agree</button>
            </div>
            <div style = "margin-top: 2%;margin-bottom: 2%">
                <a href = "<?php echo base_url("state_category/cat/$id/$name"); ?>">I don't agree</a>
            </div>
            <?php
        }
        echo form_close();
        ?>
    </div>
</section>