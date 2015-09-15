<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replaceAll('tinymce')
</script>

    <div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>">
            Age Verify<?php //echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header users-header">
        <h2>
          Updating Age Verify<?php //echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>

<?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
     	echo validation_errors();
     	echo form_open('admin/age_verify/update/'.$this->uri->segment(4).'', $attributes);
?>
        <fieldset>
         <input type="hidden" value="<?php echo $this->session->userdata('redirect_url')?>" name="redirect_url" />
        
        
         
          <div class="control-group">
            <label for="inputError" class="control-label">Description</label>
            <div class="controls">
            <textarea class="tinymce ckeditor" name="description"><?php echo $cms[0]['description']?></textarea>
            </div>
          </div>
        
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
           <a class="btn" href="<?php echo $this->session->userdata('redirect_url');?>">Cancel</a>
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
function startFilter(){
		//alert(ele);
		var cs1 = $('#type').find(":selected").attr("class");
		    //var cs1 = $("option:selected", ele).attr("class");
    if(cs1 == 'hide_display_name'){
		$('.display_name').css("display","block");
		//$('.display_name').attr("disabled", false);
        //do something
    }else{
		$('.display_name').css("display","none");
		//$('.display_name').attr("disabled", true);
		}
}
</script>