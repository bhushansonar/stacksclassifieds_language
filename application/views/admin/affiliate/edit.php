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

    echo form_open('admin/affiliate/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php foreach ($affiliate as $affiliate_content) { ?>

            <div class="control-group">
                <label for="inputError" class="control-label">Affiliate Price for Register </label>
                <div class="controls">
                    <input type="hidden" id="" name="affiliate_name" value="name" >
                    <input type="text" id="register_price" name="register_price" value="<?php echo $affiliate_content['register_price']; ?>" >
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Affiliate Price for Posted ads </label>
                <div class="controls">
                    <input type="text" id="posted_ads_price" name="posted_ads_price" value="<?php echo $affiliate_content['posted_ad_price']; ?>">
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Status</label>
                <div class="controls">
                    <select name="status">
                        <option <?php $affiliate_content['status'] == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                        <option <?php $affiliate_content['status'] == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
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
