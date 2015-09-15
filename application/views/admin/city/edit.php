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

    echo form_open('admin/city/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php foreach ($city as $city_content) { ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Country:-<span class="star">*</span></label>
                <div class="controls">
                    <?php
                    $attribute = 'id="per_country"';
                    echo form_dropdown('country_id', $country_opt, $city_content['country_id'], $attribute);
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">States Name:-<span class="star">*</span></label>
                <div class="controls">
                    <?php
                    $attribute = 'id="per_state" ';

                    echo form_dropdown('state_id', $state_opt, $city_content['state_id'], $attribute);
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">City Name<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="" name="city_name" value="<?php echo $city_content['city_name'] ?>" >
                </div>
            </div>
            
            <div class="control-group">
                <label for="inputError" class="control-label">Status</label>
                <div class="controls">
                    <select name="status">
                        <option <?php $city_content['status'] == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                        <option <?php $city_content['status'] == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        <?php } ?>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo $this->session->userdata('redirect_url'); ?>">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
