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
                Site Language<?php //echo ucfirst($this->uri->segment(2)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">New</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Adding Site Language<?php //echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>

    <?php
    //flash messages
    //print_r($flash_message);
    /* if(!empty($flash_message))
      {
      echo '<div class="alert alert-success">';
      echo '<a class="close" data-dismiss="alert">&#215;</a>';
      echo '<strong>Well done!</strong> new keyword created with success.';
      echo '</div>';
      }else{
      echo '<div class="alert alert-error">';
      echo '<a class="close" data-dismiss="alert">&#215;</a>';
      echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
      echo '</div>';
      } */
    ?>

    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open_multipart('admin/sitelanguage/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">Language Shortcode</label>
            <div class="controls">
                <input type="text" id="" name="language_shortcode" value="<?php echo set_value('language_shortcode'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Language longform</label>
            <div class="controls">
                <input type="text" id="" name="language_longform" value="<?php echo set_value('language_longform'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Language Flag</label>
            <div class="controls">
                <input style="float:left;" name="language_flag" type="file" />
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
                <select name="status">
                    <option <?php echo set_value('status') == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                    <option <?php echo set_value('status') == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                </select>
                 <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/sitelanguage">Cancel</a>

        </div>
    </fieldset>

    <?php echo form_close(); ?>
</div>