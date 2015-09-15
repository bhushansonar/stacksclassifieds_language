<!--<link href="<?php echo base_url(); ?>assets/css/admin/bootstrap.css" rel="stylesheet" type="text/css">-->
<!--<link href="<?php echo base_url(); ?>assets/css/admin/bootstrap.min.css" rel="stylesheet" type="text/css">-->
<style>
    #dataTable {
        margin: 20px auto 18px;

    }

    #dataTable table {
        width: 100%;
    }

    th, td {
        font-size: 12pt;
    }
    tr{
        text-align: center;
        vertical-align: top;
    }
    #dataTable th a {
        color: #fff;
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
    #currentUser {
        color: #4668a8;
        font-size: 20px;
        font-weight: bold;
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
        <div id="dataTable">
            <table cellspacing="1" cellpadding="4" border="0">
                <tbody>
                    <tr style="background-color:#5C80BB;color:#fff;">
                        <th><label><?php echo _clang(NAME); ?></th>
                        <th><?php echo _clang(AFFILIATE_NUMBER); ?></th>
                        <th><label><?php echo _clang(WRITE_ADD_EMAIL); ?></th>
                        <th><?php echo _clang(EARN); ?></th>
                    </tr>
                    <?php
                    for ($i = 0; $i < count($content); $i++) {
                        ?>
                        <tr style="background-color: #ccddee">
                            <td>
                                <?php echo $content[$i]['firstname']; ?>
                            </td>
                            <td>
                                <?php echo $content[$i]['affiliate_number']; ?>
                            </td>
                            <td>
                                <?php echo $content[$i]['primary_email']; ?>
                            </td>
                            <td>
                                <?php echo $content[$i]['affiliate_earn']; ?>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody></table>
            <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
            ?>
        </div>

    </div>
</section>