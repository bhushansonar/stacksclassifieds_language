<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

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
</script>

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
                <?php echo ucfirst('city category Price'); ?>
            </a> 
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">New</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Adding <?php echo ucfirst('city category Price'); ?>
        </h2>
    </div>
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo validation_errors();
    echo form_open('admin/city_category_price/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">Country Name:-<span class="star">*</span></label>
            <div class="controls">
                <?php
                $js = " getPerPlaces(this,'state') ";
                $attribute = 'id="per_country"  onchange="' . $js . '" ';
                echo form_dropdown('country', $country_opt, $country, $attribute);
                ?>
            </div>

        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">States Name:-<span class="star">*</span></label>
            <div class="controls">
                <?php
                $js = "getPerPlaces(this,'city')";
                $attribute = 'id="per_state" onchange="' . $js . '" ';
                echo form_dropdown('state', $state_opt, $state, $attribute);
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">City<span class="star">*</span></label>
            <div class="controls">
                <?php
                $attribute = 'id="per_city"';
                echo form_dropdown('city', $city_opt, $city, $attribute);
                ?>

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Select Category:<span class="star">*</span></label>
            <div class="controls">
                <select name="city_category">
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
            <label for="inputError" class="control-label">Price<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="price" name="price" value="<?php echo set_value('price'); ?>" >
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/city_category_price">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>