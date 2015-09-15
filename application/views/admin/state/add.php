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
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo validation_errors();
    echo form_open('admin/state/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">Country:-<span class="star">*</span></label>
            <div class="controls">
                <?php
                $attribute = 'id="per_country"';
                echo form_dropdown('country', $country_opt, $country, $attribute);
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">State Name <span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="state_name" value="<?php echo set_value('state_name'); ?>" >
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/state">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
