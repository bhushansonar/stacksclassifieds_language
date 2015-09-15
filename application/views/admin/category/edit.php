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

    echo form_open('admin/category/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />
        <div class="control-group">
            <label for="inputError" class="control-label">Select Parent Menu:</label>
            <div class="controls">
                <select name="parent_id">
                    <option value="0">--------- Parent Category ---------</option>
                    <?php
                    for ($i = 0, $n = count($par_cat_array); $i < $n; $i++) {
                        ?>

                        <?php
                        if ($par_cat_array[$i]['category_id'] == $category[0]['parent_id'])
                            $selected = "selected";
                        else
                            $selected = "";
                        echo "<option value='" . $par_cat_array[$i]['category_id'] . "' $selected>" . $par_cat_array[$i]['path'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php
        foreach ($category as $category_content) {
            ?>
            <?php for ($i = 0; $i < count($site_language); $i++) { ?>
                <div class="control-group">
                    <label for="inputError" class="control-label">Category Name <?php echo $site_language[$i]['language_longform'] ?></label>
                    <div class="controls">
                        <input type="text" id="" name="category_name_<?php echo $site_language[$i]['language_shortcode'] ?>" value="<?php echo $category_content['category_name_' . $site_language[$i]['language_shortcode']] ?>" >
                    </div>
                </div>
            <?php } ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Price</label>
                <div class="controls">
                    <input type="text" id="price" name="price" value="<?php echo $category_content['price'] ?>" >

                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Display Order<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="" name="display_order" value="<?php echo $category_content['display_order'] ?>" >

                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Is Adult</label>
                <div class="controls">
                    <?php
                    $is_adult = $category_content['is_adult'];
                    $checked = '';
                    if ($is_adult == 'YES') {
                        $checked = "checked='checked'";
                    }
                    ?>
                    <input type="checkbox" <?php echo $checked; ?> id="is_adult" name="is_adult" value="YES" >
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Status</label>
                <div class="controls">
                    <select name="status">
                        <option <?php $category_content['status'] == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                        <option <?php $category_content['status'] == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                    </select>
                     <!--<span class="help-inline">Woohoo!</span>-->
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
