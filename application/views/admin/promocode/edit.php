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

    echo form_open_multipart('admin/promocode/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />


        <div class="control-group">
            <label for="inputError" class="control-label">Promocode Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="promocode_name" value="<?php echo $user[0]['promocode_name']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">

            <label for="inputError" class="control-label">Promo Type<span class="star">*</span></label>
            <div class="controls">
                <?php
                $promotype = array('' => 'Select', 'amount' => 'AMOUNT', 'percentage' => 'PERCENTAGE');
                $attribute = 'id="promotype"';
                echo form_dropdown('promotype', $promotype, $user[0]['promotype'], $attribute);
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Code</label>
            <div class="controls">
                <input type="text" id="" name="code" value="<?php echo $user[0]['code']; ?>" >
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
<!--            <span style="display:none"; id="delete_msg">Are you really sure to delete this User?</span>-->
            <?php // if(user_access($this->session->userdata('user_id'),'delete_users') == true){?>
            <!--<a style="margin-left:30px;" href="<?php echo site_url("admin") ?>/user/delete/<?php echo $this->uri->segment(4) ?>" class="btn btn-danger complexConfirm">Delete User</a>-->
            <?php //} ?>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
