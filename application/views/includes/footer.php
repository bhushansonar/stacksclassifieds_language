<footer class="foot_main">
    <div class="foot_head">
        <div class="head_foot">
            <ul>
                <?php if (!$this->session->userdata('is_logged_in')) { ?>
                    <li><a href="<?php echo site_url('signin/signin_user'); ?>"><?php echo _clang(LOGIN); ?> </a></li>
                    <?php
                } else {
                    $user_id = $this->session->userdata('user_id');
                    $primary_email = $this->session->userdata('primary_email');
                    $email = base64url_encode($primary_email);


                    if ($this->session->userdata('type') == 'affiliate') {
                        ?>

                        <li>
                            <a href="<?php echo site_url('affiliate/affiliate_account_content/' . $user_id); ?>"><?php
                                echo _clang(MY_ACCOUNT);
                                ?>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li><a href="<?php echo site_url('home/account/' . $user_id . '/' . $email); ?>"><?php echo _clang(MY_ACCOUNT); ?></a></li>
                    <?php } ?>




                <?php } ?>
                <li><a href="<?php echo site_url('affiliate'); ?>"><?php echo _clang(AFFILIATES); ?></a></li>
                <!--                <li><a href="#">Promote</a></li>-->
                <li><a href="<?php echo site_url('contactus') ?>"><?php echo _clang(CONTACT); ?></a></li>
                <li><a href="<?php echo site_url('help') ?>"><?php echo _clang(HELP); ?></a></li>
                <li><a href="<?php echo site_url("privacy"); ?>"><?php echo _clang(PRIVACY); ?></a></li>
                <li><a href="<?php echo site_url("term"); ?>"><?php echo _clang(TERM); ?></a></li>
                <li><a href="<?php echo site_url('safety') ?>"> <?php echo _clang(SAFETY); ?></a></li>
            </ul>
            <?php
            $cms_block = "footer_content";
            echo cms_block($cms_block);
            ?>
            <?php //echo _clang(ALL_RIGHTS);
            ?>
        </div>

    </div>
    <script src="<?php echo base_url(); ?>assets/js/jquery.confirm.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
</footer>
</div>
</body>
</html>