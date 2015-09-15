<style>
    h3{
        font-size: 25px;
    }

</style>
<section class="main_div">
    <div class="main_area">
        <div class="local_hm">
            <ul>
                <li><a href="<?php echo base_url("home"); ?>">Home</a>>></li>
                <li><a ><?php echo $city_name . " " . $category; ?></a>>></li>
                <li><a href="<?php echo base_url("heading/$function/$id/$sub_category_id"); ?>"><?php echo $city_name . " " . $subcategory; ?></a></li>>>
                <li><a href="<?php echo base_url("post_detail/getPostdetails/$posts_id/$parent_id/$id") ?>"><?php echo _clang(AD); ?></a></li>
            </ul>
        </div>
        <div class="back_images">
            <div class="back_images_second">
                <div class="back">
                    <a href="#" onclick="history.go(-1);
                            return false;">
                        <?php echo _clang(BACK_TO_AD); ?> </a>

                </div>
                <div class="right" style="margin:0;">
                    <?php
                    $current_img = $current_img;
                    for ($m = 0; $m < count($img); $m++) {

                        $next_prev_img[] = base64url_encode($img[$m]);
                    }
                    $key = array_search($current_img, $next_prev_img);
                    $prev = !empty($next_prev_img[($key - 1)]) ? $next_prev_img[($key - 1)] : "";
                    $next = !empty($next_prev_img[($key + 1)]) ? $next_prev_img[($key + 1)] : "";
                    ?>

                    <?php if (!empty($prev)) { ?>
                        <a  href="<?php echo base_url("full_image/getFullImage/{$posts_id}/{$parent_id}/{$post_city}/{$prev}"); ?>">< PREV</a>
                    <?php } ?>

                    <ul style="display:inline-block;">
                        <?php
                        for ($m = 0; $m < count($img); $m++) {
                            $image_pagination = base64url_encode($img[$m]);
                            $image_array[] = base64url_encode($img[$m]);
                            ?>
                            <li class="img_count"><a href="<?php echo base_url("full_image/getFullImage/{$posts_id}/{$parent_id}/{$post_city}/{$image_pagination}"); ?>"><?php echo $m + 1; ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>

                    <?php if (!empty($next)) { ?>
                        <a href="<?php echo base_url("full_image/getFullImage/{$posts_id}/{$parent_id}/{$post_city}/{$next}"); ?>">NEXT ></a>
                    <?php } ?>

                </div>

                <?php
                $ci = & get_instance();
                $ci->load->model('post_detail_model');
                ?>
                <ul style="list-style-type: none;">
                    <?php //for ($i = 0; $i < count($des); $i++) {         ?>
                    <li style='list-style:none' class='des_img'>
                        <h1 class='description_img'>
                            <?php
                            $image_pagination = base64url_encode($image_name);

                            $count_img = count($image_array);
                            for ($i = 0; $i < $count_img; $i++) {
                                if ($image_array[$i] == $image_pagination) {

                                    $sub = $i + 1;
                                    if ($i == ($count_img - 1)) {
                                        $next_ele = array('0' => $image_array[0]);
                                    } else {
                                        for ($m = $sub; $m < count($image_array); $m++) {
                                            $next_ele[] = $image_array[$m];
                                        }
                                    }
                                }
                            }
                            $image_pagination_next = @$next_ele[0];
                            if ($image_pagination_next == 'none') {
                                $img_url = $image_array[0];
                            } else {
                                $img_url = $image_pagination_next;
                            }
                            ?>
                            <span class="img_name" style="display: none;">
                                <?php echo $image_pagination = base64url_encode($image_name); ?>
                            </span>
                            <a href="<?php echo base_url("full_image/getFullImage/{$posts_id}/{$parent_id}/{$post_city}/{$image_pagination_next}"); ?>"> <img src="<?php echo base_url(); ?>uploads/post_ads/<?php echo $image_name; ?>" /> </a>
                        </h1>
                    </li>


                    <?php //}                                ?>
                </ul>
            </div>

        </div>
        <div style='margin:3% 0 4px 0;font-size:20px;'>
            <h3>
                <?php echo unserialize(base64_decode($des[0]['title'])); ?>
                <?php // echo json_decode($des[0]['title']);    ?>
            </h3>
        </div>
        <div style="margin:2% 0 4px 0;">
            <a class="link_btn" href="<?php echo base_url("reply/email_reply/$posts_id/$parent_id"); ?>"><?php echo _clang(REPLY); ?></a>
        </div>
        <div class='img_full' style="margin:1% 0 4px 0;">
            <a href="#" onclick="history.go(-1);
                            return false;">
                <?php echo _clang(BACK_TO_AD); ?> </a>
             <!--<a href=" <?php //echo base_url("post_detail/getPostdetails/$posts_id/$parent_id/$id")               ?> "><?php //echo _clang(BACK_TO_AD);             ?></a>-->
        </div>
        <div style="clear:both"></div>
    </div>
</section>

