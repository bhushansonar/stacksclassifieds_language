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
    echo form_open('admin/country/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">Country Name <span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="country_name" name="country_name" value="<?php echo set_value('country_name'); ?>" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Currency Type<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="currency_type" name="currency_type" value="<?php echo set_value('currency_type'); ?>" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Active Language</label>
            <div class="controls">
                <select name="language_shortcode">
                    <?php for ($i = 0; $i < count($site_language); $i++) { ?>
                        <option <?php echo custom_set_value($site_language[$i]['language_shortcode']) == $site_language[$i]['language_shortcode'] ? 'selected="selected"' : '' ?>  value="<?php echo $site_language[$i]['language_shortcode'] ?>"><?php echo $site_language[$i]['language_longform'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/country">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
