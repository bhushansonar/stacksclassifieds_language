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
    echo form_open_multipart('admin/promocode/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">Promocode Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="promocode_name" value="<?php echo custom_set_value('promocode_name'); ?>" >
            </div>
        </div>
        <div class="control-group">

            <label for="inputError" class="control-label">Promo Type<span class="star">*</span></label>
            <div class="controls">
                <?php
                $promotype = array('' => 'Select', 'amount' => 'AMOUNT', 'percentage' => 'PERCENTAGE');
                $attribute = 'id="promotype"';
                echo form_dropdown('promotype', $promotype, "", $attribute);
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Promo Type Value</label>
            <div class="controls">
                <input type="text" id="" name="code" value="<?php echo custom_set_value('code'); ?>" >

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
            <a class="btn" href="<?php echo site_url('admin') ?>/promocode">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
