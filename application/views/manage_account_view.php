<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/table.css">
<style>
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

</style>
<section class="main_div">
    <div class="main_area">

        <div id="currentUser">
            <?php
            echo $email;
            $ci = & get_instance();
            $ci->load->model('affiliate_model');
            $ci->load->model('write_add_model');
            $user_details = $ci->affiliate_model->get_data_by_id('user', 'primary_email', $email);
            $user_email = base64url_encode($email);
            $user_id = $user_details[0]['user_id'];
            ?><br>
            <span style="color:#000;font-size:16px;font-weight:normal;">
                <?php echo _clang(HELLO_AFFILIATE); ?> <span style="color:#f00;"><?php echo $user_details[0]['affiliate_number']; ?></span>:
                <a href='<?php echo site_url("affiliate/affiliate_account_content/$user_id") ?>'><?php echo _clang(TOOLS); ?> </a> |
                <a href="<?php echo site_url('affiliate/EarningsReport/' . $user_email) ?>"><?php echo _clang(REPORTS); ?> </a> |
           <!--       <a href="<?php echo site_url('affiliate/PaymentHistory/' . $user_email) ?>">Payment History</a> |
                 <a href="<?php echo site_url('affiliate/PaymentInfo/' . $user_email) ?>">Payment Info</a> |-->
                <a href="<?php echo site_url('affiliate/PaymentInfo/' . $user_email) ?>"><?php echo _clang(PAYMENT_INFO); ?> </a> |
                <a href="<?php echo site_url('affiliate/term/' . $user_email) ?>"><?php echo _clang(AFFILIATE_TERMS); ?> </a> |
                <a href="<?php echo site_url('affiliate/ManageAds/' . $user_email); ?>"><?php echo _clang(ACCOUNT); ?> </a>

            </span>
        </div>


        <div style="float: right;">
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo validation_errors();
            echo form_open_multipart('add_post/addpostdata', $attributes);

            $ci = & get_instance();
            $ci->load->model('common_model');
            ?>

            <label><?php echo _clang(POST_NEW_AD); ?></label>

            <select id="post_city" name="post_city">
                <?php for ($c = 0; $c < count($country); $c++) { ?>
                    <option value="" style="background:#000;color:#fff;font-weight:bold;text-transform:uppercase;" disabled="disabled"><?php echo $country[$c]['country_name']; ?></option>
                    <?php
                    $country_id = $country[$c]['country_id'];
                    $city_opt = $ci->common_model->get_content_by_field('city', 'country_id', $country_id);

                    for ($m = 0; $m < count($city_opt); $m++) {
                        ?>
                        <option value="<?php echo $city_opt[$m]['city_id']; ?>"><?php echo $city_opt[$m]['city_name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <input type="submit" value="<?php echo _clang(GO); ?>">
            <?php echo form_close(); ?>
            <div id="postMultipleAds"><a href="<?php echo site_url(); ?>ad_type/index/multiple"><?php echo _clang(POST_SPONSOR_AD); ?></a></div>

        </div>
        <div style="clear: both"></div>
        <?php
        if (!empty($content)) {
            ?>
            <div id="tableWrapper">
                <div id="manageAds">
                    <div id="mobile" style="display:none;">
                        <div id="manageAdHeader">
                            <div id="adsFound">
                                <div class="pagination">
                                    <p class="paginationDetails" style="margin-bottom: 5px; text-align: center;font-size: 16px;">

                                        <span class="paginationCount" style="color: #000; margin: 0; padding: 0;">
                                            <?php echo $count_products; ?>
                                        </span>
                                        <?php echo _clang(ADS_FOUND); ?>

                                    </p>

                                </div>

                            </div>

                        </div>
                        <?php
                        foreach ($content as $key => $post_content) {

                            $today_date = strtotime(date('Y-m-d H:i:s'));
                            $expire_date = strtotime($post_content['expire_date']);

                            if ($expire_date < $today_date) {
                                $status = 'Expired';
                            } else {
                                if ($post_content['payment_status'] == 'complete') {
                                    $status = 'Live';
                                } else if ($post_content['payment_status'] == 'pending') {
                                    $status = 'Pending';
                                }
                            }

                            if ($status == 'Expired') {
                                $bg_color = "style='background-color:#bbccdd'";
                            } else if ($status == 'Live') {
                                $bg_color = "style='background-color:#ccddee'";
                            }

                            $city_name = $ci->affiliate_model->get_data_by_id('city', 'city_id', $post_content['city']);
                            $category_name = $ci->affiliate_model->get_data_by_id('category', 'category_id', $post_content['category']);
                            ?>
                            <div class="manageAdBox" <?php echo $bg_color; ?>>

                                <h2 class="manageAdTitle">

                                    <?php echo unserialize(base64_decode($post_content['title'])); ?>

                                </h2>

                                <div class="manageAdBoxDetails">

                                    <p class="adDetails">
                                        <span class="infoBlock">
                                            <?php echo _clang(POSTED); ?>
                                        </span>
                                        <?php echo date("d-m-y", strtotime($post_content['date'])); ?>
                                    </p>

                                    <p class="adDetails">
                                        <span class="infoBlock">
                                            <?php echo _clang(CITY); ?>
                                        </span>
                                        <?php echo $city_name[0]['city_name']; ?>
                                    </p>

                                    <p class="adDetails">
                                        <span class="infoBlock">
                                            <?php echo _clang(CATEGORIES); ?>
                                        </span>
                                        <?php
                                        $lang_shortcode = Do_language::GetSessionLang();

                                        echo $category_name[0]['category_name_' . $lang_shortcode];
                                        ?>
                                    </p>

                                </div>

                                <div class="manageAdBoxBtm">
                                    <h3>
                                        <span class="adStatus">
                                            <?php echo _clang(STATUS); ?>
                                        </span>
                                        <span class="adStatusText">
                                            <?php
                                            echo $status;
                                            ?>
                                        </span>
                                    </h3>
                                    <?php
                                    if ($status == 'Live') {
                                        $manage = _clang(MANAGE_AD);
                                        $posts_id = $post_content['posts_id'];
                                        ?>	<a class="adManageSubmit" href="<?php echo base_url("manage_ad_list/manage_ad_detail/$posts_id") ?>"><?php echo $manage; ?></a>
                                        <?php
                                    }
                                    if ($status == 'Pending') {
                                        $manage = 'Verify';
                                        echo "<a href=''>$manage</a>";
                                    }
                                    if ($status == 'Expired') {
                                        $manage = _clang(RENEW);
                                        $post_type = 'renew';
                                        $posts_id = $post_content['posts_id'];
                                        //echo "<a href=''>$manage</a>";
                                        ?> <a class="adManageSubmit" href="<?php echo base_url("write_add/update/$posts_id/$post_type") ?>"><?php echo $manage; ?></a>
                                        <?php
                                    }
                                    ?>
                                    <div class="clear">

                                    </div>


                                </div>

                            </div>

                            <?php
                        }
                        ?>

                        <div id="manageAdHeader">
                            <?php
                            $page = $this->pagination->create_links();
                            if (!empty($page)) {
                                $this->session->set_userdata('redirect_url', current_url());
                                echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
                            } else {
                                ?>
                                <div id ="adsFound">
                                    <div class = "pagination">
                                        <p class = "paginationDetails" style = "margin-bottom: 5px;text-align: center;font-size: 16px;">
                                            <span class = "paginationCount" style = "color: #000; margin: 0; padding: 0;">
                                                <?php echo $count_products; ?>
                                            </span>
                                            <?php echo _clang(ADS_FOUND); ?> </p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>

                    <div id="standard">
                        <div id="dataTable">
                            <table border="0" cellpadding="4" cellspacing="1" style="text-align: center">
                                <tr style="background-color:#5C80BB;color:#fff;">
                                    <th><?php echo _clang(DATE); ?></th>
                                    <th><?php echo _clang(CITY); ?></th>
                                    <th><?php echo _clang(AD_TITLE); ?></th>
                                    <th><?php echo _clang(CATEGORIES); ?></th>
                                    <th> <?php echo _clang(PAY_TYPE); ?></th>
                                    <th><?php echo _clang(STATUS); ?></th>
                                    <th>&nbsp;</th>

                                </tr>
                                <?php
                                foreach ($content as $key => $post_content) {
                                    $city_name = $ci->affiliate_model->get_data_by_id('city', 'city_id', $post_content['city']);
                                    $category_name = $ci->affiliate_model->get_data_by_id('category', 'category_id', $post_content['category']);
                                    $today_date = strtotime(date('Y-m-d H:i:s'));
                                    $expire_date = strtotime($post_content['expire_date']);
                                    if ($expire_date < $today_date) {
                                        $status = 'Expired';
                                    } else {
                                        if ($post_content['payment_status'] == 'complete') {
                                            $status = 'Live';
                                        } else if ($post_content['payment_status'] == 'pending') {
                                            $status = 'Pending';
                                        }
                                    }
                                    if ($status == 'Expired') {
                                        $bg_color = "style='background-color:#bbccdd'";
                                    } else if ($status == 'Live') {
                                        $bg_color = "style='background-color:#ccddee'";
                                    }
                                    ?>
                                    <tr <?php echo $bg_color; ?>>
                                        <td>
                                            <?php echo date("d-m-y", strtotime($post_content['date'])); ?>
                                        </td>
                                        <td>
                                            <?php echo $city_name[0]['city_name']; ?>
                                        </td>

                                        <td> <?php echo unserialize(base64_decode($post_content['title'])); ?></td>
                                        <td>
                                            <?php
                                            $lang_shortcode = Do_language::GetSessionLang();
                                            echo $category_name[0]['category_name_' . $lang_shortcode];
                                            ?>
                                        </td>
                                        <td><?php echo $post_content['ads_type']; ?></td>

                                        <td>
                                            <?php
                                            echo $status;
                                            ?>
                                        </td>

                                        <td>

                                            <?php
                                            if ($status == 'Live') {
                                                $manage = _clang(MANAGE_AD);
                                                $posts_id = $post_content['posts_id'];
                                                ?>
                                                <a href="<?php echo base_url("manage_ad_list/manage_ad_detail/$posts_id") ?>"><?php echo $manage; ?></a>
                                                <?php
                                            }
                                            if ($status == 'Pending') {
                                                $manage = 'Verify';
                                                echo "<a href=''>$manage</a>";
                                            }
                                            if ($status == 'Expired') {
                                                $manage = _clang(RENEW);
                                                $post_type = 'renew';
                                                $posts_id = $post_content['posts_id'];
                                                ?>
                                                <a href="<?php echo base_url("write_add/update/$posts_id/$post_type") ?>"><?php echo $manage; ?></a>
                                                <?php
                                            }
                                            ?>

                                        </td>

                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>


                            <?php
                            $page = $this->pagination->create_links();
                            if (!empty($page)) {
                                $this->session->set_userdata('redirect_url', current_url());
                                echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
                            } else {
                                ?>
                                <div id ="adsFound">
                                    <div class = "pagination">
                                        <p class = "paginationDetails" style = "margin-bottom: 5px;">
                                            <span class = "paginationCount" style = "color: #000; margin: 0; padding: 0;">
                                                <?php echo $count_products; ?>
                                            </span>
                                            <?php echo _clang(ADS_FOUND); ?> </p>
                                    </div>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo "<h1 style='font-size: 18px; margin-top: 4%;text-align: center;'>There is no record available for this User</h1>";
        }
        ?>

    </div>
</section>