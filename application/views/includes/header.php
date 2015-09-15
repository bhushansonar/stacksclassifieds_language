<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0;">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/media.css">
<!--        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/main_1.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/media_1.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/core.css">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/contact.css">-->
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
<!--        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->

        <script src="<?php echo base_url(); ?>assets/js/plugins.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script_t.js"></script>
        <script type="text/javascript">var base_url = '<?php echo base_url(); ?>'</script>

        <!--<script src="a/j/libs/modernizr-2.5.3.min.js"></script>-->
        <style>
            @fontface{ font-family:Roboto; src:url(<?php echo base_url(); ?>assets/Roboto-Regular.ttf);}
        </style>
        <title>StacksClassifieds</title>
    </head>
    <body>
        <div id="wrap">
            <header>
                <div class="main_head">
                    <?php if ($this->session->userdata('page_type') == "home") { ?>
                        <div class="log_head_home">
                        <?php } else { ?>
                            <div class="log_head">
                            <?php } ?>

                            <nav class="log_right">
                                <ul>
                                    <?php
                                    //echo "<pre>"; print_r($this->session->all_userdata());
                                    if (!$this->session->userdata('is_logged_in')) {
                                        ?>
                                        <li><a href="<?php echo site_url('signin/signin_user'); ?>"><?php echo _clang(LOGIN); ?></a></li>
                                        <li><a href="<?php echo site_url('term') ?>"><?php echo _clang(TERM); ?></a></li>
                                        <li><a href="<?php echo site_url('privacy') ?>"><?php echo _clang(PRIVACY); ?></a></li>
                                        <li><a href="<?php echo site_url('safety') ?>"><?php echo _clang(SAFETY); ?></a></li>
        <!--                                    <li><a href="<?php echo site_url('signup/signup_user'); ?>">Register </a></li>-->
                                        <?php
                                    } else {
//                                        $a = $this->session->userdata('type');
//                                        echo "<pre>";
//                                        print_r($a);
//                                        exit;
//
                                        $email = $this->session->userdata('primary_email');
                                        $user_id = $this->session->userdata('user_id');
                                        $primary_email = base64url_encode($email);
                                        if ($this->session->userdata('type') == 'affiliate') {
                                            ?>

                                            <li>
                                                <a href="<?php echo site_url('affiliate/affiliate_account_content/' . $user_id); ?>"><?php
                                                    echo "logged in as" . " " . $email;
                                                    ?>
                                                </a>
                                            </li>
                                        <?php } else { ?>
                                            <li>
                                                <a href="<?php echo site_url('home/account/' . $user_id . '/' . $primary_email); ?>"><?php
                                                    echo "logged in as" . " " . $email;
                                                    ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <li>
                                            <?php $user_email = base64url_encode($email); ?><a href="<?php echo site_url("home/change_password/{$user_email}"); ?>"><?php echo _clang(CHANGE_PASSWORD); ?></a></li>
                                        <li><a href="<?php echo site_url('home/logout'); ?>"><?php echo _clang(LOGOUT); ?></a></li>
                                    <?php } ?>

                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="main_headmenu">
                        <?php if ($this->session->userdata('page_type') == "home") { ?>
                            <div class="main_hemenu_home">
                            <?php } else { ?>
                                <div class="main_hemenu">
                                <?php } ?>
                                <h1 class="logo"><a href="<?php echo site_url('home/home_page'); ?>"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt=""></a></h1>
                                <div class="group_main">
                                    <nav class="group">
                                        <h2 class="navheader slide-trigger">Menu <span></span></h2>
                                        <ul class="navigation">
                                            <li><a href="<?php echo site_url('home'); ?>"><?php echo _clang(HOME); ?></a></li>
                                            <li><a href="<?php echo site_url('affiliate'); ?>"><?php echo _clang(AFFILIATES); ?></a></li>
<!--                                            <li><a href="#"><?php echo _clang(PROMOTE); ?></a></li>-->
                                            <li><a href="<?php echo site_url('contactus') ?>"><?php echo _clang(CONTACT); ?></a></li>
                                            <li><a href="<?php echo site_url('help') ?>"><?php echo _clang(HELP); ?></a></li>
                                        </ul>
                                    </nav>
                                    <div class="post_add">
                                        <a href="<?php echo base_url("ad_type") ?>"><?php echo _clang(POST_ADS); ?></a>
                                    </div>
                                </div>
                                <div style="clear: both; float: right; font-size: 19px;">
                                    <?php
                                    $ci = & get_instance();
                                    $ci->load->model('common_model');
                                    $stack_state_id_selected = $this->session->userdata('stack_state_id');
                                    $stack_city_id_selected = $this->session->userdata('stack_city_id');
                                    if (!empty($stack_state_id_selected)) {
                                        $where_state = " AND state_id='{$stack_state_id_selected}'";
                                        $state_name = $ci->common_model->getFieldData('state', 'state_name', $where_state);
                                        echo $classifieds = $state_name . ', <span style="color:bfc5ce">' . _clang(FREE_CLASSIFIEDS) . '</span>';
                                    } elseif (!empty($stack_city_id_selected)) {
                                        $where_city = " AND city_id='{$stack_city_id_selected}'";
                                        $city_name = $ci->common_model->getFieldData('city', 'city_name', $where_city);
                                        echo $classifieds = $city_name . ', <span style="color:#bfc5ce">' . _clang(FREE_CLASSIFIEDS) . '</span>';
                                    } else {
                                        if (isset($page_type)) {
                                            if ($page_type == 'home') {
                                                echo $classifieds = "";
                                            }
                                        } else {
                                            echo $classifieds = "StacksClassifieds.com, <span style='color:#bfc5ce'>" . _clang(FREE_CLASSIFIEDS) . "</span>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        </header>
