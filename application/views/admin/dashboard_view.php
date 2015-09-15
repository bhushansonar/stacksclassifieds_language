<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <?php echo ucfirst($this->uri->segment(2)); ?>
    </ul>

    <div class="page-header">
        <h2>
            <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
        <?php
//        $type_of_membership = $this->session->userdata('type_of_membership');
//        if ($type_of_membership != 'Admin') {
        $url = base_url();
        $link = "{$url}admin/user/update/{$this->session->userdata['user_id']}";
//        } else {
//            $link = "#";
//        }
        ?>
        <h3 style="margin-top:5px;">Welcome <a href="<?php echo $link; ?>"><?php echo $this->session->userdata['username']; ?></a> to StacksClassifieds Admin.</h3>
    </div>

    <?php
    $type_of_membership = $this->session->userdata('type_of_membership');
    if ($type_of_membership == 'Admin') {
        ?>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/posts" title="posts">
                <img alt="Add posts" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Posts</span>
            </a>
        </div>
    <?php } else {
        ?>

        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/category" title="Category">
                <img alt="Add Category" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Category</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/category_price" title="All Category Price">
                <img alt="Add All Category Price" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>All Category Price</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/posts" title="posts">
                <img alt="Add posts" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Posts</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/user" title="User">
                <img alt="Add User" src="<?php echo base_url(); ?>/assets/img/admin/ico/user.png" />
                <span>Users</span>
            </a>
        </div>

        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/country" title="country">
                <img alt="Add Country" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Country</span>
            </a>
        </div>

        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/state" title="state">
                <img alt="Add State" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>State</span>
            </a>
        </div>

        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/city" title="city">
                <img alt="Add City" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>City</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/city_category_price" title="city">
                <img alt="Add City" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>City Price</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/cms" title="CMS">
                <img alt="Add CMS" src="<?php echo base_url(); ?>/assets/img/admin/ico/static_pageico.png" />
                <span>CMS</span>
            </a>
        </div>

        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/promocode" title="promocode">
                <img alt="Add promocode" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Promocode</span>
            </a>
        </div>
        <!--    <div class="quickLink">
                <a href="<?php echo base_url(); ?>admin/affiliate" title="Affiliate">
                    <img alt="Add Affiliate" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                    <span>Affiliate</span>
                </a>
            </div>-->
        <!--    <div class="quickLink">
                <a href="<?php echo base_url(); ?>admin/age_verify" title="Age Verify">
                    <img alt="Add Age Verify" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                    <span>Age Verify</span>
                </a>
            </div>-->
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/top_ads" title="Top Twenty Ads">
                <img alt="Add Top Twenty Ads" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Top Twenty Ads</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/featured_price" title="Featured Price">
                <img alt="Add Featured Price" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
                <span>Featured Price</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/sitelanguage" title="Site Language">
                <img alt="Add Site Language" src="<?php echo base_url(); ?>/assets/img/admin/ico/language.png" />
                <span>Site Language</span>
            </a>
        </div>
        <div class="quickLink">
            <a href="<?php echo base_url(); ?>admin/languagekeyword" title="Language Keyword">
                <img alt="Add Language Keyword" src="<?php echo base_url(); ?>/assets/img/admin/ico/keyword.png" />
                <span>Language Database</span>
            </a>
        </div>
    <?php } ?>
</div>


<?php //echo '<pre>';print_r($this->session->userdata);  ?>

