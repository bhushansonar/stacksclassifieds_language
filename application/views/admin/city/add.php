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
    echo form_open('admin/city/add', $attributes);
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
                $attribute = 'id="per_state" ';

                echo form_dropdown('state', $state_opt, $state, $attribute);
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">City Name <span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="city_name" value="<?php echo set_value('city_name'); ?>" >
            </div>
        </div>
        

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/city">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>
