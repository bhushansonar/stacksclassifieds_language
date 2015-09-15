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
                <?php //echo ucfirst($this->uri->segment(2)); ?>
                Top Twenty ADs
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">Update</a>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Updating Top Twenty ADs<?php //echo ucfirst($this->uri->segment(2));                                          ?>
        </h2>
    </div>

    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo validation_errors();
    echo form_open('admin/top_ads/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php foreach ($top_ads as $top_ads_content) { ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Title<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="title" name="title" value="<?php echo $top_ads_content['title']; ?>" >
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Select Category:<span class="star">*</span></label>
                <div class="controls">
                    <select name="category[]" size=6 multiple>
                        <option value="">--------- Parent Category ---------</option>
                        <?php
                        $category_id = explode(",", $top_ads_content['category_id']);
                        for ($i = 0, $n = count($par_cat_array); $i < $n; $i++) {
                            if (in_array($par_cat_array[$i]['category_id'], $category_id)) {
                                $selected = "selected='selected'";
                            } else {
                                $selected = "";
                            }
                            echo "<option value='" . $par_cat_array[$i]['category_id'] . "' $selected>" . $par_cat_array[$i]['path'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label"> Order <span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="order" name="order" value="<?php echo $top_ads_content['order'] ?>" >
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Status</label>
                <div class="controls">
                    <select name="status">
                        <option <?php echo $top_ads_content['status'] == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                        <option <?php echo $top_ads_content['status'] == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        <?php } ?>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/top_ads">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>



</div>
