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
            <a href="#">Update</a>
        </li>
    </ul>
    <div class="page-header users-header">
        <h2>
            Updating <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>
    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    //form validation
    echo validation_errors();
    echo form_open_multipart('admin/user/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />
        <div class="control-group">
            <label for="inputError" class="control-label">Type<span class="star">*</span></label>
            <div class="controls">
                <select name="type_of_membership">
                    <?php
                    $user_role_array = Access_level::user_role_dropdown();
                    $ci = & get_instance();
                    $user_type = $ci->session->userdata('type_of_membership');
                    ?>
                    <?php foreach ($user_role_array[$user_type] as $key => $role_val) {
                        ?>
                        <option <?php echo $user[0]['type_of_membership'] == $key ? 'selected="selected"' : '' ?>  value="<?php echo $key ?>"><?php echo $role_val ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>
        <!--        <div class="control-group">
                    <label for="inputError" class="control-label">Type<span class="star">*</span></label>
                    <div class="controls">
        <?php
        $type_of_membership = $user[0]['type_of_membership'];
        $attribute = 'id="type_of_membership" ';
        echo form_dropdown('type_of_membership', $type_of_membership_opt, $type_of_membership, $attribute);
        ?>
                    </div>
                </div>-->

        <div class="control-group">
            <label for="inputError" class="control-label">First Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="firstname" value="<?php echo $user[0]['firstname']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Last Name</label>
            <div class="controls">
                <input type="text" id="" name="lastname" value="<?php echo $user[0]['lastname']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">User Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="username" value="<?php echo $user[0]['username']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Password<span class="star">*</span></label>
            <div class="controls">
                <input disabled="disabled" type="password" class="pass_disabled" name="password" value="<?php echo $user[0]['password']; ?>" >
                <span class="help-inline"><a onclick="changepassword();" href="javascript:void(0)">Change</a></span>
            </div>
        </div>
        <div id="confirm_div" style="display:none;" class="control-group">
            <label for="inputError" class="control-label">Confirm Password<span class="star">*</span></label>
            <div class="controls">
                <input disabled="disabled" type="password" class="pass_disabled" name="password2" value="<?php echo $user[0]['password']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Primary E-mail<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="primary_email" value="<?php echo $user[0]['primary_email']; ?>" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Affiliate Price for Register</label>
            <div class="controls">
                <input type="text" id="register_price" name="register_price" value="<?php echo $user[0]['register_price']; ?>" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Affiliate Price for Posted ads</label>
            <div class="controls">
                <input type="text" id="posted_ad_price" name="posted_ad_price" value="<?php echo $user[0]['posted_ad_price']; ?>" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
                <select name="status">
                    <option <?php echo trim($user[0]['status']) == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                    <option <?php echo trim($user[0]['status']) == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                </select>
                 <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo $this->session->userdata('redirect_url'); ?>">Cancel</a>
            <span style="display:none"; id="delete_msg">Are you really sure to delete this User?</span>
            <?php if (user_access($this->session->userdata('user_id'), 'delete_users') == true) { ?>
                <a style="margin-left:30px;" href="<?php echo site_url("admin") ?>/user/delete/<?php echo $this->uri->segment(4) ?>" class="btn btn-danger complexConfirm">Delete User</a>
            <?php } ?>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
