<style>
    .city_content{
        height: 38%;
        padding: 7% 0 0 4%;
        overflow-x: hidden;
        overflow:auto;
    }
    li{
        line-height: 22px;
    }
    li a{
        color: #2a4e89;
    }
    ul{
        list-style-type: none;
    }
</style>
<style>
    .inactive{
        cursor: default;
    }
    .pagination {
        height: 36px;
        margin: 18px 0;
        text-align: center;
    }
    .pagination ul {
        display: inline-block;
        *display: inline;
        /* IE7 inline-block hack */

        *zoom: 1;
        margin-left: 0;
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .pagination li {
        display: inline;
    }
    .pagination a {
        float: left;
        padding: 0 14px;
        line-height: 34px;
        text-decoration: none;
        border: 1px solid #ddd;
        border-left-width: 0;
    }
    .pagination a:hover, .pagination .active a {
        background-color: #f5f5f5;
    }
    .pagination .active a {
        color: #999999;
        cursor: default;
    }
    .pagination .disabled a, .pagination .disabled a:hover {
        color: #999999;
        background-color: transparent;
        cursor: default;
    }
    .pagination li:first-child a {
        border-left-width: 1px;
        -webkit-border-radius: 3px 0 0 3px;
        -moz-border-radius: 3px 0 0 3px;
        border-radius: 3px 0 0 3px;
    }
    .pagination li:last-child a {
        -webkit-border-radius: 0 3px 3px 0;
        -moz-border-radius: 0 3px 3px 0;
        border-radius: 0 3px 3px 0;
    }
    .pagination-centered {
        text-align: center;
    }
    .pagination-right {
        text-align: right;
    }
    .pager {
        margin-left: 0;
        margin-bottom: 18px;
        list-style: none;
        text-align: center;
        *zoom: 1;
    }
    .pager:before, .pager:after {
        display: table;
        content: "";
    }
    .pager:after {
        clear: both;
    }
    .pager li {
        display: inline;
    }
    .pager a {
        display: inline-block;
        padding: 5px 14px;
        background-color: #fff;
        border: 1px solid #ddd;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        border-radius: 15px;
    }
    .pager a:hover {
        text-decoration: none;
        background-color: #f5f5f5;
    }
    .pager .next a {
        float: right;
    }
    .pager .previous a {
        float: left;
    }
    .sponsors {
        /*        color: #bbb;*/
        font: 13pt arial;
    }
    #topSponsorWrapper {
        background: none repeat scroll 0 0 #fafad2;
        padding: 6px;
        z-index: 0;
        position: relative;
    }
    #topSponsorWrapper .sponsorBox, #topSponsorWrapper .sponsorBoxPlusImages {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        border: medium none;
        margin-bottom: 0;
    }
    #topSponsorWrapper .sponsorBoxPlusImages {
        height: auto;
        min-height: 42px;
        overflow: hidden;
        position: relative;
    }
    .post_right_ext{
        float: right;
        width: 100%;
    }
    .post_left {
        float: none;
        width: auto;
    }
</style>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

    function getCityName(obj) {
        var state_id = $(obj).val();
        $.ajax({
            type: 'POST',
            url: base_url + "citycategory/get_city",
            data: {state_id: state_id},
            success: function(data) {
                $('.before_city').hide();
                $('.after_city').show();
                $('#after_city').html(data);

            }
        });

    }
</script>
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
$ci->load->model('citycategory_model');
$ci->load->model('city_model');
$ci->load->model('common_model');
$ci->load->model('top_ads_model');
?>
<section class="main_div">
    <div class="main_area">
        <h1 style="font-size: 18pt; margin-bottom: 1%;line-height: 1.2;">

            <?php
            if (!empty($top_ads)) {

                echo $top_ads_category_title;
            }
            ?>
        </h1>
        <div style="width: 100%;overflow:hidden">
            <div style="width:78%;float:left;">
                <?php
                if (!empty($top_ads)) {
                    $samedate = '';
                    for ($i = 0; $i < count($top_ads); $i++) {
                        $postid = $top_ads[$i]['posts_id'];
                        $parent = $top_ads[$i]['category'];
                        $city = $top_ads[$i]['city'];
                        ?>
                        <div class="list_titlerg">
        <?php if ($samedate != date('Y-m-d', strtotime($top_ads[$i]['date']))) { ?>
                                <div class="list_titlerg">

                                    <?php
                                    echo $date = date('D .M .d', strtotime($top_ads[$i]['date']));
                                    //echo $date = date('D j F, Y', strtotime($tit[$i]['date']));
                                    ?></div>
                                <?php $samedate = date('Y-m-d', strtotime($top_ads[$i]['date'])); ?>
        <?php } ?>
                        </div>
                        <article class="list_main" style="margin: 0">
                            <div class="list_img">
                                <?php
                                $image = $top_ads[$i]['image1'];
                                $image2 = $top_ads[$i]['image2'];
                                $image3 = $top_ads[$i]['image3'];
                                $image4 = $top_ads[$i]['image4'];
                                $image5 = $top_ads[$i]['image5'];
                                $image6 = $top_ads[$i]['image6'];
                                $image7 = $top_ads[$i]['image7'];
                                $image8 = $top_ads[$i]['image8'];
                                $image9 = $top_ads[$i]['image9'];
                                $image10 = $top_ads[$i]['image10'];
                                $image11 = $top_ads[$i]['image11'];
                                $image12 = $top_ads[$i]['image12'];

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
                                <?php } else {
                                    ?>
                                    <img class = "list_in" width = "100" src = "" alt = "">
                                <?php }
                                ?>
                            </div>
                            <div class="list_mainrg">
                                <div class="list_tital">
                                    <div class="list_titallf">
                                        <a href="<?php echo base_url("post_detail/getPostdetails/$postid/$parent/$city") ?>">
                                            <?php
                                            echo '<span class="emoji">' . unserialize(base64_decode($top_ads[$i]['title'])) . '</span>';
                                            ?>
                                        </a>
                                    </div>


                                </div>
                                <div class="read_tex">
        <?php echo unserialize(base64_decode($top_ads[$i]['description'])); ?>
                                </div>
                            </div>
                        </article>
                        <div class="clear"></div>
                    <?php }
                    ?>
                    <div class="pagination"><?php echo $this->pagination->create_links() ?></div>
                    <?php
                } else {
                    echo "<div><h1 style='text-align:center'>There is No Data Available for this Ads</h1></div>";
                }
                ?>
            </div>
            <div style="width:22%;float:left;">
                <figure class="" style="background-color: #E3E9F2;margin:0 0 0 -0.3%;">
                    <div style="margin: 4% 0 0 4%;">
                        <div><a href="<?php echo site_url('home/home_page'); ?>" style="color: #516ea4">all cities</a></div>
                        <div>
                            <?php
                            $get_states = '';
//                            $whereStr = " AND city_id={$city_id}";
//                            $get_states = $ci->common_model->getFieldData('city', 'state_id', $whereStr);
                            $get_all_states = $ci->common_model->getDDArray('state', 'state_id', 'state_name');
                            $all_city_by_state = $ci->common_model->get_content_by_field('city', 'state_id', $get_states);
                            $js = " getCityName(this) ";
                            $attribute = 'id = "per_state" class = "key_sel" style = "width:100%;margin-top:7%;padding:5px 0" onchange = "' . $js . '" ';
                            echo form_dropdown('state', $get_all_states, '', $attribute);
                            ?>
                        </div>
                        <div class="city_content">
                            <!--                    <ul class="before_city">
<?php foreach ($all_city_by_state as $key => $city) { ?>
                                                                                                                                                                                                                                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                <a href="<?php echo site_url(); ?>citycategory/cat/<?php echo $city['city_id'] . "/" . $city['city_name'] ?>"><?php echo $city['city_name'] ?></a>
                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
<?php } ?>
                                                </ul>-->
                            <ul id="after_city" class="after_city" style="display: none">
                            </ul>
                        </div>

                    </div>
                    <div style="margin: 4% 0 0 4%; color: #516ea4;">
                        <label>Top 20:</label>
                        <ul>
                            <?php
                            $top_twenty_ads = $ci->top_ads_model->get_top_ads_front();
                            foreach ($top_twenty_ads as $key => $top_twenty) {
                                ?>
                                <li>
                                    <a style="color: #000;" href="<?php echo site_url(); ?>citycategory/top_ads/<?php echo $top_twenty['top_ads_id']; ?>"><?php echo $top_twenty['title']; ?></a>
                                </li>
<?php } ?>
                        </ul>
                    </div>
                    <div style="margin-bottom: 5%; margin-top: 14%;padding: 5%;">
                        <a style="color: #2a4e89;" href="<?php echo site_url(); ?>ad_type/index/multiple">post in multiple cities</a>
                    </div>
                </figure>
            </div>

        </div>
</section>