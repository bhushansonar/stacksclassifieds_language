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
        var price_week_count = $("#count_price_arr").val();
        console.log(price_week_count);
        var x = price_week_count;
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
            <a href="#">Update</a>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Updating <?php echo ucfirst('Featured Price'); ?>
        </h2>
    </div>
    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open('admin/featured_price/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php foreach ($featured_price as $city_content) { ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Country:-<span class="star">*</span></label>
                <div class="controls">
                    <?php
                    $js = "getPerPlaces(this,'state')";
                    $attribute = 'id="per_country"  onchange="' . $js . '"';
                    echo form_dropdown('country', $country_opt, $city_content['country_id'], $attribute);
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">States Name:-<span class="star">*</span></label>
                <div class="controls">
                    <?php
                    $js = "getPerPlaces(this,'city')";
                    $attribute = 'id="per_state" onchange="' . $js . '"';
                    echo form_dropdown('state', $state_opt, $city_content['state_id'], $attribute);
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">City<span class="star">*</span></label>
                <div class="controls">
                    <?php
                    $attribute = 'id="per_city"';
                    echo form_dropdown('city', $city_opt, $city_content['city_id'], $attribute);
                    ?>
                </div>
            </div>
            <?php
            $category_id = $city_content['category_id'];
            ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Select Category:</label>
                <div class="controls">
                    <select name="city_category">
                        <option value="0">--------- Parent Category ---------</option>
                        <?php
                        for ($i = 0, $n = count($par_cat_array); $i < $n; $i++) {
                            ?>
                            <?php
                            if ($par_cat_array[$i]['category_id'] == $category_id)
                                $selected = "selected='selected'";
                            else
                                $selected = "";
                            echo "<option value='" . $par_cat_array[$i]['category_id'] . "' $selected>" . $par_cat_array[$i]['path'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php
            $featured_price_after_decode = json_decode($city_content['featured_week_price']);
            $count_price = count($featured_price_after_decode);
            ?>
            <input type="hidden" name="count" id="count_price_arr"value="<?php echo $count_price; ?>"><?php
            foreach ($featured_price_after_decode as $key => $value) {
                foreach ($value as $key => $value1) {
                    if ($key == 1) {
                        $show = '<a class="add_field_button" href="javascript:void(0)">Add More Fields</a>';
                    } else {
                        $show = "";
                    }
                    ?>

                    <div class="control-group">
                        <label for="inputError" class="control-label"><?php echo $key; ?> Week Price<span class="star">*</span></label>
                        <input type="text" id="price_1" name="price_<?php echo $key; ?>" value="<?php echo $value1; ?>">
                        <input type="hidden" name="week_<?php echo $key; ?>" value="<?php echo $key; ?>">
                        <!--                        <a class="remove_field" href="#">Remove</a>-->
                        <?php echo $show; ?>
                    </div>

                    <?php
                }
            }
            ?>
            <div class="input_fields_wrap">

            </div>
            <div class = "control-group">
                <label for = "inputError" class = "control-label">Status</label>
                <div class = "controls">
                    <select name = "status">
                        <option <?php $city_content['status'] == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                        <option <?php $city_content['status'] == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        <?php } ?>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin/featured_price') ?>">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
