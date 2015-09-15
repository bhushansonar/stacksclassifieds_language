<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replaceAll('tinymce')
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
                CMS<?php //echo ucfirst($this->uri->segment(2));       ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">Update</a>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Updating CMS<?php //echo ucfirst($this->uri->segment(2));       ?>
        </h2>
    </div>

    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();
    echo form_open('admin/cms/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />
        <div class="control-group">
            <label for="inputError" class="control-label">Location</label>
            <div class="controls">
                <input type="text" id="" name="location" value="<?php echo $cms[0]['location']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Type</label>
            <div class="controls">
                <select id="type" onchange="startFilter();" name="type">
                    <option <?php echo ($cms[0]['type'] == "block") ? 'selected="selected"' : ""; ?> value="block">Block</option>
                    <option class="hide_display_name" <?php echo ($cms[0]['type'] == "help_page") ? 'selected="selected"' : ""; ?> value="help_page">Help Page</option>
                    <option class="" <?php echo ($cms[0]['type'] == "page") ? 'selected="selected"' : ""; ?> value="page">CMS Page</option>
                </select>

            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Block name</label>
            <div class="controls">
                <input disabled="disabled" type="text" id="" name="block_name" value="<?php echo $cms[0]['block_name']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>

        <?php for ($i = 0; $i < count($site_language); $i++) { ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Description <?php echo $site_language[$i]['language_longform'] ?></label>
                <div class="controls">
                    <textarea class="tinymce ckeditor" id="editor_cms" name="description_<?php echo $site_language[$i]['language_shortcode'] ?>"><?php echo $cms[0]['description_' . $site_language[$i]['language_shortcode']] ?></textarea>
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
<script>
    startFilter();
    /*function startFilter(value){
     //var cs1 = $('#type').find(":selected").attr("class");

     //var cs1 = $("option:selected", ele).attr("class");
     alert(value)
     if(value == 'help_page'){
     $('.display_name').css("display","block");
     $('.display_name').attr("disabled", false);
     //do something
     }else{
     $('.display_name').css("display","none");
     $('.display_name').attr("disabled", true);
     }
     }*/
    function startFilter() {
        //alert(ele);
        var cs1 = $('#type').find(":selected").attr("class");
        //var cs1 = $("option:selected", ele).attr("class");
        if (cs1 == 'hide_display_name') {
            $('.display_name').css("display", "block");
            //$('.display_name').attr("disabled", false);
            //do something
        } else {
            $('.display_name').css("display", "none");
            //$('.display_name').attr("disabled", true);
        }
    }
</script>