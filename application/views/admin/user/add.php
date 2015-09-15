<div class="container top">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url("admin") . '/' . $this->uri->segment(2); ?>">
                <?php echo ucfirst($this->uri->segment(2)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">New</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Adding <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>
    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    //form validationc
    echo validation_errors();
    echo form_open_multipart('admin/user/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">User Type</label>
            <div class="controls">
                <?php
                $user_role_array = Access_level::user_role_dropdown();
                $ci = & get_instance();
                $user_type = $ci->session->userdata('type_of_membership');
                ?>
                <select name="type_of_membership">

                    <?php foreach ($user_role_array[$user_type] as $key => $role_val) {
                        ?>
                        <option <?php echo custom_set_value('type_of_membership') == $key ? 'selected="selected"' : '' ?>  value="<?php echo $key ?>"><?php echo $role_val ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>
        <!--        <div class="control-group">
                    <label for="inputError" class="control-label">Membership Type:-</label>
                    <div class="controls">
        <?php
        $type_of_membership = "";
        $attribute = 'id="type_of_membership" ';
        echo form_dropdown('type_of_membership', $type_of_membership_opt, $type_of_membership, $attribute);
        ?>
                    </div>
                </div>-->
        <div class="control-group">
            <label for="inputError" class="control-label">First Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="firstname" value="<?php echo set_value('firstname'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Last Name</label>
            <div class="controls">
                <input type="text" id="" name="lastname" value="<?php echo custom_set_value('lastname'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">User Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="username" value="<?php echo set_value('username'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Password<span class="star">*</span></label>
            <div class="controls">
                <input type="password" id="" name="password" value="<?php echo set_value('password'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Confirm Password<span class="star">*</span></label>
            <div class="controls">
                <input type="password" id="" name="password2" value="<?php echo set_value('password2'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Primary E-mail<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="primary_email" value="<?php echo set_value('primary_email'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Affiliate Price for Register</label>
            <div class="controls">
                <input type="text" id="register_price" name="register_price" value="<?php echo set_value('register_price'); ?>" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Affiliate Price for Posted ads</label>
            <div class="controls">
                <input type="text" id="posted_ad_price" name="posted_ad_price" value="<?php echo set_value('posted_ad_price'); ?>" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
                <select name="status">
                    <option <?php echo custom_set_value('status') == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                    <option <?php echo custom_set_value('status') == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                </select>
                 <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/user">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
