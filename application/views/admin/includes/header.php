<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>StacksClassifieds Admin - <?php echo ucfirst($this->uri->segment(2)); ?></title>
        <meta charset="utf-8">
        <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
        <script type="text/javascript"> var base_url = '<?php echo base_url(); ?>'</script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.fancybox.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.fancybox.css" media="screen" />
    </head>
    <?php
    $CI = & get_instance();
    ?>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <?php
                    $type_of_membership = $this->session->userdata('type_of_membership');
//                    if ($type_of_membership != 'Admin') {
                    $url = base_url();
                    $link = "{$url}admin/user/update/{$this->session->userdata['user_id']}";
//                    } else {
//                        $link = "#";
//                    }
                    ?>
      <a class="brand"><!--<img src="<?php echo base_url(); ?>assets/images/admin/logo.png" />-->StacksClassifieds Admin</a>

                    <div class="brand logininfo">logged in as <a href="<?php echo $link; ?>"><?php echo $this->session->userdata['username']; ?></a>&nbsp; <a href="<?php echo base_url(); ?>admin/logout">Logout</a></div>
                    <ul class="nav">
                        <li <?php
                        if ($this->uri->segment(2) == 'dashboard') {
                            echo 'class="active"';
                        }
                        ?>>
                            <a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">StacksClassifieds<b <?php //echo ($m_count > 0) ? 'style="margin-top:11px"' : ''                                  ?> class="caret"></b></a>
                            <?php // if($m_count > 0){ ?>
                            <div class="tip_div"><span class="tip"><span class="tip_in"><?php //echo $m_count;                                 ?></span></span></div>
                            <?php // }   ?>
                            <ul class="dropdown-menu">
                                <li <?php
                                if ($type_of_membership != 'Admin') {
                                    if ($this->uri->segment(2) == 'category') {
                                        echo 'class="active"';
                                    }
                                    ?>>
                                        <a href="<?php echo base_url(); ?>admin/category">Category</a>
                                    </li>
                                <?php } ?>
                                <li <?php
                                if ($this->uri->segment(2) == 'posts') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="<?php echo base_url(); ?>admin/posts">Posts</a>
                                </li>

                            </ul>
                        </li>
                        <?php
                        if ($type_of_membership != 'Admin') {
                            ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Languages <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li <?php
                                    if ($this->uri->segment(2) == 'sitelanguage') {
                                        echo 'class="active"';
                                    }
                                    ?>>
                                        <a href="<?php echo base_url(); ?>admin/sitelanguage">Site Languages</a>
                                    </li>
                                    <li <?php
                                    if ($this->uri->segment(2) == 'languagekeyword') {
                                        echo 'class="active"';
                                    }
                                    ?>>
                                        <a href="<?php echo base_url(); ?>admin/languagekeyword">Language Database</a>
                                    </li>
                                </ul>
                            </li>
                            <li <?php
                            if ($this->uri->segment(2) == 'user') {
                                echo 'class="active"';
                            }
                            ?>>
                                <a href="<?php echo base_url(); ?>admin/user">User</a>
                            </li>
                        <?php } ?>
                        <?php /* ?> <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">System <b class="caret"></b></a>
                          <ul class="dropdown-menu">

                          </ul>
                          </li><?php */ ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">System <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/logout">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>