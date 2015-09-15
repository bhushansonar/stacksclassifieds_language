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
            <a href="#">Update</a>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Updating <?php echo ucfirst('city category price'); ?>
        </h2>
    </div>
    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open('admin/city_category_price/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php foreach ($city_category_price as $city_content) { ?>
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


            <div class = "control-group">
                <label for = "inputError" class = "control-label">Price<span class = "star">*</span></label>
                <div class = "controls">
                    <input style = "height: 27px;" type = "text" id = "price" name = "price" value = "<?php echo $city_content['price']; ?>" >
                </div>
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
            <a class="btn" href="<?php echo site_url('admin/city_category_price') ?>">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
