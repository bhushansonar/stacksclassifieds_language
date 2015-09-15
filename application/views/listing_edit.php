<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
 
    function getPerPlaces(obj, child_type) {
        var parent_id = $(obj).val();
//        toggle_loader($('#per_' + child_type))
        $('#per_' + child_type)
        if (parent_id != "") {
            $.ajax({
                type: 'POST',
                url: base_url + "common_ctrl/get_places",
                data: {child_type: child_type, parent_id: parent_id},
                success: function(data) {
                    $('#per_' + child_type).html(data);
                    $('#per_' + child_type).change();
//                    toggle_loader($('#per_' + child_type), 1);
                }
            });
        } else {
            $('#per_' + child_type).html('<option value="">Select</option>');
            $('#per_' + child_type).change();
//            toggle_loader($('#per_' + child_type), 1);
        }
    }
    CKEDITOR.replaceAll('tinymce');
</script>   

<div class="container top">

    

    <div class="page-header users-header">
        <h2>
            Updating <?php //echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>


    
    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open_multipart('listing/update/' . $this->uri->segment(4) . '', $attributes);
	$id = $this->uri->segment(3);
	$parent = $this->listing_model->get_posts_category_id($id);
	$parent_id = $parent[0]['category'];
	//echo "<pre>"; print_r($parent_id); die;
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php foreach ($posts as $posts_content) { ?>
            <input type="hidden" value="<?php echo $posts_content['posts_id'] ?>" name="posts_id" />
           
           <div class="control-group">
                <label for="inputError" class="control-label">Main Category:-</label>
                <div class="controls">
                    <?php
                    $js = "getPerPlaces(this,'subcategory')";
                    $attribute = 'id="per_main_category"  onchange="' . $js . '" ';
                    echo form_dropdown('category', $main_category_opt, $posts_content['category'], $attribute);
                    ?>

                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Subcategory:-</label>
                <div class="controls">
                    <?php
                    $attribute = 'id="per_subcategory" ';
                    echo form_dropdown('subcategory', $subcategory_opt, $posts_content['subcategory'], $attribute);
                    ?>

                </div>
            </div>
           
            <div class="control-group">
                <label for="inputError" class="control-label">Country:-</label>
                <div class="controls">
                    <?php
                    $js = " getPerPlaces(this,'state') ";
                    $attribute = 'id="per_country"  onchange="' . $js . '" ';
                    echo form_dropdown('country', $country_opt, $posts_content['country'], $attribute);
                    ?>

                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">States:-</label>
                <div class="controls">
                    <?php
                    $js = "getPerPlaces(this,'city')";
                    $attribute = 'id="per_state"  onchange="' . $js . '" ';

                    echo form_dropdown('state', $state_opt, $posts_content['state'], $attribute);
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">City</label>
                <div class="controls">
                    <?php
                    $attribute = 'id="per_city" ';
                    echo form_dropdown('city', $city_opt, $posts_content['city'], $attribute);
                    ?>
                </div>
            </div>

            <?php
		if( $parent_id == 8 )
		{
        echo '
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left">Price</label>
            <div class="controls left_r">
                <input type="text" id="price" name="price" value="' .$posts_content["price"] .'" >
            </div>
        </div>
		
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left">Bedrooms</label>
            <div class="controls left_r">
                <select name="bedrooms" value="' .$posts_content["bedrooms"] .'">
                	<option value="">Select </option>
                    <option value="0+">Studio </option>
                    <option value="1">1 </option>
                    <option value="2">2 </option>
                    <option value="3">3 </option>
                    <option value="4">4 </option>
                    <option value="5">5 </option>
                    <option value="6">6 </option>
                    <option value="7">7 </option>
                    <option value="8">8 </option>
                </select>
            </div>
        </div>
		';
		} ?>

            <div class="control-group">
                <label for="inputError" class="control-label">Title</label>
                <div class="controls">
                    <input type="text" id="" name="title" value="<?php echo $posts_content['title'] ?>" >

                </div>
            </div>
			
            <?php
				if( $parent_id == 1 || $parent_id == 2 )
				{
				echo '
				<div class="control-group bottom_space">
					<label for="inputError" class="control-label left">Selling Price</label>
					<div class="controls left_r">
						<input type="text" id="selling_price" name="selling_price" value="' .$posts_content["selling_price"] .'" >
						
					</div>
				</div>
				';
				}
			?>
            
            <?php
				if( $parent_id == 2 || $parent_id == 5 || $parent_id == 10 || $parent_id == 8 || $parent_id == 9 || $parent_id == 1)
				{
				echo '
				<div class="control-group bottom_space">
					<label for="inputError" class="control-label left">Location</label>
					<div class="controls left_r">
						<input type="text" id="location" name="location" value="' .$posts_content["location"] .'" >
					</div>
				</div>
				';
				}
			?>
        
			<?php
				if( $parent_id == 4 || $parent_id == 11 )
				{
				echo '
				<div class="control-group bottom_space">
					<label for="inputError" class="control-label left">Age</label>
					<div class="controls left_r">
						<input type="text" id="age" name="age" value="' .$posts_content["age"] .'" >
					</div>
				</div>
				';
				}
            ?>
            
            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
    <!--                <input type="file" name="image" id="gellary" onchange="preview_Image(this);">-->
                    <input type="file" name="images[]" multiple="multiple"  />
                    <?php
                    $view_images = explode(',', $posts_content['images']);
                    foreach ($view_images as $multi_images) {?>
                         <div style="float:left; padding: 1px;"><img width="100" src="<?php echo base_url(); ?>uploads/images/<?php echo $multi_images; ?>" /></div>
                    <?php }
                    ?>
                    <input type="hidden" name="old_image" value="<?php echo $posts_content['images'] ?>" />
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Description </label>
                <div class="controls">
                    <textarea class="tinymce ckeditor" id="editor" name="description"><?php echo $posts_content['description'] ?></textarea>
                </div>
            </div>
            <?php
				if( $parent_id == 9 )
				{
				echo '
				<div class="control-group bottom_space">
					<label for="inputError" class="control-label left">Ad Placed By</label>
					<div class="controls left_r">
					   <input type="radio" value="Owner/Property Manager" name="ad_placed_by">
					   <span>Owner/Property Manager</span>
					   <input type="radio" value="Agency/Locator Service" name="ad_placed_by">
					   <span>Agency/Finder Service</span>
					</div>
				</div>
				<div class="control-group bottom_space">
					<label for="inputError" class="control-label left">Fees Paid By</label>
					<div class="controls left_r">
						<input type="text" id="fees_paid_by" name="fees_paid_by" value="" >
					</div>
				</div>
				<div class="control-group bottom_space">
					<label for="inputError" class="control-label left">Pets</label>
					<div class="controls left_r">
						<input type="checkbox" value="Cats Ok" name="pets"><span style="margin:0 8px 0 3px;">Cats Ok</span>
						<input type="checkbox" value="Dogs Ok" name="pets"><span style="margin:0 8px 0 3px;">Dogs Ok</span>
					</div>
				</div>
				';
				} 
			?>
            <div class="control-group bottom_space">
            <label for="inputError" class="control-label left">Address</label>
            <div class="controls left_r">
                <textarea id="address" name="address" value="<?php echo $posts_content['address'] ?>" ></textarea>
            </div>
       	 	</div>
        	
            <?php
				if( $parent_id == 5 )
				{
				echo '
				<div class="control-group bottom_space">
					<label for="inputError" class="control-label left">Salary/Wage</label>
					<div class="controls left_r">
						<input type="text" id="salary" name="salary" value="" >
					</div>
				</div>
				<div class="control-group bottom_space">
					<label for="inputError" class="control-label left">Education</label>
					<div class="controls left_r">
						<input type="text" id="education" name="education" value="" >
					</div>
				</div>
				<div class="control-group bottom_space">
					<label for="inputError" class="control-label left">Work Status</label>
					<div class="controls left_r">
						<input type="checkbox" value="Full-time" name="work_status[]">
						<span style="margin:0 8px 0 3px;">Full-time</span>
						<input type="checkbox" value="Part-time" name="work_status[]">
						<span style="margin:0 8px 0 3px;">Part-time</span>
						<input type="checkbox" value="Temp/Contract" name="work_status[]">
						<span style="margin:0 8px 0 3px;">Temp/Contract</span>
						<input type="checkbox" value="Internship" name="work_status[]">
						<span style="margin:0 8px 0 3px;">Internship</span>  
					</div>
				</div>
				<div class="control-group bottom_space">
					<label for="inputError" class="control-label left">Shift</label>
					<div class="controls left_r">
						<input type="checkbox" value="Days" name="shift[]">
						<span style="margin:0 8px 0 3px;">Days</span>
						<input type="checkbox" value="Nights" name="shift[]">
						<span style="margin:0 8px 0 3px;">Nights</span>
						<input type="checkbox" value="Weekends" name="shift[]">
						<span style="margin:0 8px 0 3px;">Weekends</span>
					</div>
				</div>
				';
				} ?>
                
            <div class="control-group bottom_space">
                <label for="inputError" class="control-label left">Postcode</label>
                <div class="controls left_r">
                    <input type="text" id="postcode" name="postcode" value="<?php echo $posts_content['postcode'] ?>" >
                    <!--<span class="help-inline">Woohoo!</span>-->
                </div>
            </div>
        
            <div class="control-group">
                <label for="inputError" class="control-label">Email:</label>
                <div class="controls">
                    <input type="text" id="" name="email" value="<?php echo $posts_content['email'] ?>" >

                </div>
            </div>
            
          	<div class="control-group bottom_space">
            <label for="inputError" class="control-label left">Confirm Email:</label>
            <div class="controls left_r">
                <input type="text" id="confirm_email" name="confirm_email" value="<?php echo $posts_content['email'] ?>" >
               
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left">Contact Number:</label>
            <div class="controls left_r">
                <input type="text" id="contact_number" name="contact_number" value="<?php echo $posts_content['contact_number'] ?>" >
               
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left">Email Enquiries</label>
            <div class="controls left_r">
                <input type="radio" name="inquery" value="hide_email" ><span>Hide my email address and forward email inquiries to me.</span><br />
                <input type="radio" name="inquery" value="no" ><span>I don't want to receive any email enquiries.</span>
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left">Display options</label>
            <div class="controls left_r">
                <input type="radio" name="show_ad_links" value="yes" ><span>Yes, show links to my other postings in section.</span><br />
                <input type="radio" name="show_ad_links" value="no" ><span>No, do NOT show links to my other postings.</span>
            </div>
        </div>
        <div class="control-group bottom_space">
            <div class="controls left_r" style="margin-left:126px;">
                <input type="checkbox" name="show_joined_date" value="yes" ><span>Show the date I joined.</span>       
            </div>
        </div>
        <div class="control-group bottom_space" style="border-bottom:2px solid #999999; padding-bottom: 8px;">
            <div class="controls left_r">
               <h2>Upgrades<span style="font-weight:normal; font-size:12px;">(minimum purchase is &#163;0.99)</span></h2>       
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left">Auto Re-post Ad</label>
            <div class="controls left_r">
            <input type="checkbox" name="auto_repost_ad" value="yes" />
            <span style="margin:0 5px 0 5px;">Move your ad to the top of the listings every: </span>
              <select name="day" style="width: 55px;" value="">
              	<?php
                        for ($i = 1; $i <= 30; $i++) 
							{
                            	echo '<option value="' . $i . '">' .$i . '</option>';
                            }
                 ?>	
              </select><span style="margin:0 8px 0 8px;">After</span>
              
              <select name="time" style="width: 75px;" value="<?php echo $posts_content['time'] ?>">
              	<?php
                        for ($i = 0; $i < 24; $i++) 
							{
                            	echo '<option value="' . $i . '">' .date("H.i",
                                                            strtotime($i . ":00:00")) . '</option>';
                            }
                 ?>	
              </select>
              <br />
              <span>Number of times:</span>
              <select name="auto_repost" value="" >
              			<option value="4">4 times for &#163;1.00 </option>
                        <option value="8">8 times for &#163;2.00 </option>
                        <option value="12">12 times for &#163;3.00 </option>
                        <option value="26">26 times for &#163;6.00 </option>
              </select>
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label left">Sponsor Ad</label>
            <div class="controls left_r">
                <input type="checkbox" value="Yes" name="sponsor_ad">
                <span>Your ad will appear highlighted with thumbnails on the right side of the category.</span><span style="color:#FF0000;">More info</span><br />
                <span>Number of weeks:</span>
                <select name="week" value="" >
              	<?php
                        for ($i = 1; $i <= 52; $i++) 
							{
                            	echo '<option value="' . $i . '">' .$i .' week (&#163;'.$i * 0.02.')</option>';
                            }
                 ?>	
              </select>
            </div>
        </div>
        <div class="control-group bottom_space" style="margin-left:126px;">
            <span>or select a discounted package:</span>
            <div class="controls left_r">
                <input type="radio" name="promotions_sponsor_ad" value="4" ><span>4 weeks for &#163;0.06(25%)</span><br />
                <input type="radio" name="promotions_sponsor_ad" value="12" ><span>12 weeks for &#163;0.16(33%)</span><br />
                <input type="radio" name="promotions_sponsor_ad" value="26" ><span>26 weeks for &#163;0.26 (50%)</span>
            </div>
        </div>
 <?php 
 		//$ci->load->model('listing_model');
 		
 ?>           

<?php } ?>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo $this->session->userdata('redirect_url'); ?>">Cancel</a>
        </div>
    </fieldset>

<?php echo form_close(); ?>

</div>
