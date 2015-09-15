<script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
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

    $(document).ready(function() {

        var max_fields = 52; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID
        var x = 1;
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="control-group"><label for="inputError" class="control-label">' + x + ' Week Price<span class="star">*</span></label><input type="text" value="" name="price_' + x + '"/><input type="hidden" name="week_' + x + '" value="' + x + '"><a href="#" class="remove_field">Remove</a></div>'); //add input box
            }
        });
        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });
    });
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
                <?php echo ucfirst('Featured Price'); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">New</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Adding <?php echo ucfirst('Featured Price'); ?>
        </h2>
    </div>
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo validation_errors();
    echo form_open('admin/featured_price/add', $attributes);
    ?>
    <fieldset>

        <div class="control-group">
            <label for="inputError" class="control-label">Country Name:-<span class="star">*</span></label>
            <div class="controls">
                <?php
                $js = " getPerPlaces(this,'state') ";
                $attribute = 'id="per_country"  onchange="' . $js . '" ';
                echo form_dropdown('country', $country_opt, '', $attribute);
                ?>
            </div>

        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">States Name:-<span class="star">*</span></label>
            <div class="controls">
                <?php
                $js = "getPerPlaces(this,'city')";
                $attribute = 'id="per_state" onchange="' . $js . '" ';
                echo form_dropdown('state', $state_opt, '', $attribute);
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">City<span class="star">*</span></label>
            <div class="controls">
                <?php
                $attribute = 'id="per_city"';
                echo form_dropdown('city', $city_opt, '', $attribute);
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
            <label for="inputError" class="control-label">1 Week Price<span class="star">*</span></label>
            <input type="text" id="price_1" name="price_1" value="<?php echo set_value('price_1'); ?>">
            <input type="hidden" name="week_1" value="1">
            <a class="add_field_button" href="javascript:void(0)">Add More Fields</a>
        </div>
        <div class="input_fields_wrap">

        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/featured_price">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>