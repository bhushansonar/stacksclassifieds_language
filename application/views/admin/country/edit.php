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

    echo form_open('admin/country/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php foreach ($country as $country_content) { ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Country Name<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="country_name" name="country_name" value="<?php echo $country_content['country_name'] ?>" >
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Currency Type<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="currency_type" name="currency_type" value="<?php echo $country_content['currency_type'] ?>" >
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Active Language</label>
                <div class="controls">
                    <select name="language_shortcode">
                        <?php for ($i = 0; $i < count($site_language); $i++) { ?>
                            <option <?php echo $site_language[$i]['language_shortcode'] == $country_content['language_shortcode'] ? 'selected="selected"' : '' ?>  value="<?php echo $site_language[$i]['language_shortcode'] ?>"><?php echo $site_language[$i]['language_longform'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Status</label>
                <div class="controls">
                    <select name="status">
                        <option <?php $country_content['status'] == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                        <option <?php $country_content['status'] == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
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
