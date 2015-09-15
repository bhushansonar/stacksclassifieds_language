<script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>


<div class="set_errors">
    <?php
    if ($this->session->flashdata('validation_error_messages')) {
        echo $this->session->flashdata('validation_error_messages');
    }
    echo validation_errors();
    if ($this->session->flashdata('flash_message')) {

        echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
        echo '<a class="close" data-dismiss="alert">&#215;</a>';
        echo $this->session->flashdata("flash_message");
        echo '</div>';
    }
    ?>
</div>
<?php
$ci = & get_instance();
$ci->load->model('heading_model');
?>
<section class="main_div">
    <div class="main_area">

        <?php
        if (!empty($post_data)) {
            for ($i = 0; $i < count($post_data); $i++) {
                $postid = $post_data[$i]['posts_id'];
                $parent = $post_data[$i]['category'];
                ?>

                <div class="search_main">
                    <div class="search_key">
                        <div class="key_search">
                            <div class="key_left">
                                <label class="search_tex">Search</label>
                                <input type="search_name" class="key_in" placeholder="Enter your keyword here">
                            </div>
                            <div class="key_right">
                <!--                <select class="key_sel">
                                    <option>Buy/ Sell/ Trade</option>
                                </select>-->
                                <?php
                                $attribute = 'id="search_category" class="key_sel"';
                                echo form_dropdown('search_category', $get_subcategory, "", $attribute);
                                ?>
                                <input type="submit" class="search_btn" value="search">
                            </div>
                        </div>
                    </div>
                </div>
                <article class="list_main">
                    <div class="list_img">
                        <?php
                        $image = $tit[$i]['image1'];
                        $image2 = $tit[$i]['image2'];
                        $image3 = $tit[$i]['image3'];
                        $image4 = $tit[$i]['image4'];
                        $image5 = $tit[$i]['image5'];
                        $image6 = $tit[$i]['image6'];
                        $image7 = $tit[$i]['image7'];
                        $image8 = $tit[$i]['image8'];
                        $image9 = $tit[$i]['image9'];
                        $image10 = $tit[$i]['image10'];
                        $image11 = $tit[$i]['image11'];
                        $image12 = $tit[$i]['image12'];

                        if ($image) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image; ?>" alt="">
                        <?php } elseif ($image2) { ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image2; ?>" alt="">
                        <?php } elseif ($image3) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image3; ?>" alt="">
                        <?php } elseif ($image4) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image4; ?>" alt="">
                        <?php } elseif ($image5) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image5; ?>" alt="">
                        <?php } elseif ($image6) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image6; ?>" alt="">
                        <?php } elseif ($image7) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image7; ?>" alt="">
                        <?php } elseif ($image8) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image8; ?>" alt="">
                        <?php } elseif ($image9) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image9; ?>" alt="">
                        <?php } elseif ($image10) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image10; ?>" alt="">
                        <?php } elseif ($image11) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image11; ?>" alt="">
                        <?php } elseif ($image12) {
                            ?>
                            <img class="list_in" width="100" src="<?php echo base_url(); ?>uploads/post_ads/thumb/<?php echo $image12; ?>" alt="">
                        <?php } ?>
                    </div>
                    <div class="list_mainrg" style="width: 88%">
                        <div class="list_tital">
                            <div class="list_titallf">
                                <a href="<?php echo base_url("post_detail/getPostdetails/$postid/$parent") ?>">
                                    <?php echo unserialize(base64_decode($post_data[$i]['title'])); ?>
                                </a>
                            </div>
                            <div class="list_titlerg"><?php echo $date = date('D j F, Y', strtotime($post_data[$i]['date'])); ?></div>

                        </div>
                        <div class="read_tex">
                            <?php echo unserialize(base64_decode($post_data[$i]['description'])); ?>
                        </div>
                    </div>
                </article>
                <div class="clear"></div>
                <?php
            }
        } else {
            echo "No data available for this category";
        }
        ?>
    </div>
</section>