<!--<script type="text/javascript">
    var base_url = '<?php //echo base_url()                        ?>';

    function getPerPlaces(obj, child_type) {
        var parent_id = $(obj).val();
        $('#per_' + child_type)
        if (parent_id != "") {
            $.ajax({
                type: 'POST',
                url: base_url + "common_ctrl/get_places",
                data: {child_type: child_type, parent_id: parent_id},
                success: function(data) {
                    $('#per_' + child_type).html(data);
                    $('#per_' + child_type).change();
                }
            });
        } else {
            $('#per_' + child_type).html('<option value="">Select</option>');
            $('#per_' + child_type).change();
        }
    }
</script>-->

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
                Top Twenty ADs<?php //echo ucfirst($this->uri->segment(2));                          ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">New</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Adding Top Twenty ADs<?php //echo ucfirst($this->uri->segment(2));                           ?>
        </h2>
    </div>
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo validation_errors();
    echo form_open('admin/top_ads/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">Title<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="title" name="title" value="<?php echo set_value('title'); ?>" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Select Category:<span class="star">*</span></label>
            <div class="controls">
                <select name="category[]" size=6 multiple>
                    <option value="">--------- Parent Category ---------</option>
                    <?php
                    for ($i = 0, $n = count($par_cat_array); $i < $n; $i++) {
                        echo "<option value='" . $par_cat_array[$i]['category_id'] . "'>" . $par_cat_array[$i]['path'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label"> Order <span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="order" name="order" value="<?php echo set_value('order'); ?>" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
                <select name="status">
                    <option <?php echo set_value('status') == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                    <option <?php echo set_value('status') == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/top_ads">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
