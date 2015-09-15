<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.js"></script>
<style>
    .accordion-expand-holder {
        margin:10px 0;
    }
    .accordion-expand-holder .open, .accordion-expand-holder .close {
        margin: 0 10px 0 0;
    }
    .accordion-expand-holder .open, .accordion-expand-holder .close {
        margin:0 10px 0 0;
    }

    .ui-accordion-content{
        height:auto;
    }
    .ui-widget {
        font-family: Verdana,Arial,sans-serif;
        font-size: 1.1em;
    }
    .ui-helper-reset {
        border: 0 none;
        /*    font-size: 100%;*/
        line-height: 1.3;
        list-style: outside none none;
        margin: 0;
        outline: 0 none;
        padding: 0;
        text-decoration: none;
    }
    .ui-accordion .ui-accordion-icons {
        padding-left: 2.2em;
    }
    .ui-accordion .ui-accordion-header {
        cursor: pointer;
        display: block;
        margin-top: 2px;
        position: relative;
    }
    .ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {
        border-bottom-right-radius: 4px;
    }
    .ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl {
        border-bottom-left-radius: 4px;
    }
    .ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr {
        border-top-right-radius: 4px;
    }
    .ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl {
        border-top-left-radius: 4px;
    }
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
        background-color: #e6e6e6;
        border: 1px solid #d3d3d3;
        color: #555555;
        font-weight: normal;
    }
    .ui-helper-reset {
        font-size: 100%;
        /*        line-height: 1.3;*/
        line-height:1.6;
        list-style: outside none none;
        outline: 0 none;
        text-decoration: none;
    }
    .ui-accordion .ui-accordion-header .ui-accordion-header-icon {
        left: 0.5em;
        margin-top: -8px;
        position: absolute;
        top: 50%;
    }
    .ui-state-active .ui-icon {
        background-image: url("assets/images/ui-icons_222222_256x240.png");
    }
    .ui-state-default .ui-icon {
        background-image: url("assets/images/ui-icons_222222_256x240.png");
    }
    .ui-icon-triangle-1-e {
        background-position: -32px -16px;
    }
    .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active {
        background: url("assets/images/ui-icons_ffffff_256x240.png") repeat-x scroll 50% 50% #ffffff;
        border: 1px solid #aaaaaa;
        color: #212121;
        font-weight: normal;
    }
    .ui-accordion .ui-accordion-content {
        border-top: 0 none;
        overflow: auto;
        /*        padding: 1em 2.2em;*/
        padding: 0.5em 0.4em;
    }
    .ui-accordion-content {
        height: auto;
    }
    .ui-widget-content {
        background: url("images/ui-icons_ffffff_256x240.png") repeat-x scroll 50% 50% #ffffff;
        border: 1px solid #aaaaaa;
        color: #222222;
    }
    /*    .accordion-inner {
            margin-left: 5%;
            -moz-column-count: 3;
            -webkit-column-count: 3;
        }*/
    ul{
        list-style-type: none;
    }

</style>
<script>
    $(function() {
        // Apparently click is better chan change? Cuz IE?
        $('input[type="checkbox"]').change(function(e) {
            var checked = $(this).prop("checked"),
                    container = $(this).parent(),
                    siblings = container.siblings();
            container.find('input[type="checkbox"]').prop({
                indeterminate: false,
                checked: checked
            });
            function checkSiblings(el) {

                var parent = el.parent().parent(),
                        all = true;
                el.siblings().each(function() {
                    return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
                });
                if (all && checked) {
                    parent.children('input[type="checkbox"]').prop({
                        indeterminate: false,
                        checked: checked
                    });
                    checkSiblings(parent);
                } else if (all && !checked) {

                    parent.children('input[type="checkbox"]').prop("checked", checked);
                    parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
                    checkSiblings(parent);
                } else {
                    el.parents("li").children('input[type="checkbox"]').prop({
                        indeterminate: false,
                        checked: true
                    });

                }
            }

            checkSiblings(container);
        });
    });
    function checkTotal(e) {
        var name = $(e).attr('class');
        var sum = 0;
        if (name === "country") {
            $('#calculate').hide();
        } else if (name === "state") {
            $('#calculate').hide();

        } else {
            $('#calculate').show();
            for (i = 0; i < document.listForm.city.length; i++) {
                if (document.listForm.city[i].checked) {
                    sum += parseFloat(document.listForm.city[i].value, 10);
                }

            }

        }
        sum = sum.toFixed(2);
        if (document.listForm.week.value) {
            sum = sum * parseInt(document.listForm.week.value);
        }
        $('.total').text('$ ' + sum);
        $('#total').val(sum);
    }

    function get_city_id(c) {
        var value = [];
        $("input[name*='city']").each(function() {
            // Get all checked checboxes in an array
            if (jQuery(this).is(":checked")) {
                value.push($(this).attr('id'));
            }
        });
        $('#multi_city_id').val(value);
    }



</script>

<style>
    ul { margin-left:30px;}
    .break{ width:255px;  }
    .cls_country{ color:#000; font-size:20px;}
    .cls_state{ color:#3563a8; font-size:14px;}
    .cls_city{ color:#b59a28; font-size:12px; margin-bottom:5px; text-decoration:underline; cursor:pointer;}
    .cis_city:hover{ color:#000;}
    .isotope { max-width: 1200px; }
    .item {  float:left;}

    /*.left{ float: left; width:15%; line-height: 25px; }
    .left_r{ float:left; width:85%;}*/
    .bottom_space{ margin-bottom:10px; overflow: hidden;}
    #title, #email, #confirm_email, #postcode, #location, #selling_price, #contact_number, #age, #price, #fees_paid_by, #salary, #education{ border: 1px solid #ccc; border-radius: 3px; padding: 4px; width: 158px;}
    .btn_mult {background-color: #506fa3; border: 1px outset #ccc; color: #fff;}
</style>

<section class="main_div">
    <div class="main_area">
        <div class="local_hm">
            <ul>
                <li><a href="<?php echo base_url("home") ?>">StacksClassifieds.com</a>>></li>
                <li><a href="<?php echo base_url("ad_type") ?>"><?php echo _clang(POST_AD); ?></a>>></li>
                <li><a href="#"><?php echo $category_name; ?></a>>>
                </li>
                <li>
                    <a href="#"><?php echo $category_name . " " . $sub_category_name; ?></a>
                     <!--<a href="<?php //echo base_url("add_post/addpostdata/$city_id/$category_id")                                                                                                                                                                ?>"><?php echo $subcategory; ?></a>-->
                </li>
            </ul>
        </div>
        <h2 style="line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
            <?php echo _clang(CHOOSE_METRO); ?>
        </h2>

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '', 'name' => 'listForm');
        echo validation_errors();
        echo form_open('multiple_city/check_city', $attributes);
        ?>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label multiple_city_view_left">Step - 1</label>
            <div class="controls multiple_city_view_left_r">

                <?php echo _clang(WRITE_ADD_NUM_WEEKS); ?>
                <select name="week" id="week" onchange='checkTotal()'>
                    <option value="">select</option>
                    <?php
                    for ($i = 1; $i <= 52; $i++) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group bottom_space">
            <label for="inputError" class="control-label multiple_city_view_left">Step - 2</label>
            <div class="controls multiple_city_view_left_r">
                <span><?php echo _clang(ONE_MORE_METRO_AREA); ?></span>
            </div>
        </div>
        <div id="calculate" class="control-group bottom_space">
            <label for="inputError" class="control-label multiple_city_view_left"><?php echo _clang(TOTAL); ?>:</label>
            <div id='tlt'>

            </div>
            <div class="controls multiple_city_view_left_r">
                <span class="total"> </span>
                <input type="hidden" id="total" name="total" size="3" value="0" />
<!--                <input type="hidden"  name="multi_country_id" value="" id="multi_country_id"/>
                <input type="hidden"  name="multi_state_id" value=""  id="multi_state_id"/>-->
                <input type="hidden"  name="multi_city_id" value="" id="multi_city_id"/>
                <input type="hidden" name="sub_category" value="<?php echo $sub_category ?>"/>

            </div>
        </div>
        <h1 style="line-height: 1.2;margin-bottom: 20px;font-size: 22px; color: #5C80BB; margin-top: 2%;">
            <?php echo _clang(ONE_MORE_METRO_AREA); ?>
        </h1>
        <ul>
            <?php
            $ci = & get_instance();
            $ci->load->model('multiple_city_model');
            $ci->load->model('city_model');
            $parent_id = $this->uri->segment(4);
            for ($i = 0; $i < count($country_opt); $i++) {
                ?>
                <li>
                    <input type='checkbox' class='country' name='country[]' id='<?php echo $country_opt[$i]['country_id'] ?>' onchange='checkTotal(this);' value="<?php echo $country_opt[$i]['country_id'] ?>">
                    <label for = "tall" style = "font-size: 21px;" class > <?php echo $country_opt[$i]['country_name']; ?> </label>
                    <span class = "country_name" >
                    </span>
                    <ul>
                        <?php
                        $get_state = $ci->multiple_city_model->getState_by_field_value("country_id", $country_opt[$i]['country_id']);

                        for ($s = 0; $s < count($get_state); $s++) {
                            if ($get_state[$s]['state_name'] != "(none)") {

                                $get_city = $ci->multiple_city_model->getCity_by_field_value("state_id", $get_state[$s]['state_id']);
                                ?>
                                <li style = "color:#4c4c4c;">
                                    <input type ='checkbox'  id="<?php echo $get_state[$s]['state_id']; ?>" class='state' name='state[]'  onchange='checkTotal(this)' value="<?php echo $get_state[$s]['state_id']; ?>"/>
                                    <label for="tall-2" style="font-size: 20px;"><?php echo $get_state[$s]['state_name']; ?></label>

                                    <span class="state_name">

                                    </span>
                                    <ul class="accordion-inner">
                                        <?php
                                        for ($c = 0; $c < count($get_city); $c++) {
                                            $get_city_id = $get_city[$c]['city_id'];
                                            ?>
                                            <li style="color: #666666">
                                                <?php
                                                $city_price = $get_city[$c]['price'];
                                                $category = $this->session->userdata('category');
                                                $subcategory = $this->session->userdata('sub_category');
                                                //$city_category_id = $get_city[$c]['city_category'];



                                                if (!empty($get_city_id)) {
                                                    $where = " AND category_id={$subcategory} AND city_id={$get_city_id}";
                                                    $city_category_price = $this->common_model->getFieldData('city_category_price', 'price', $where);
                                                    if (!empty($city_category_price) && $city_category_price != "0") {
                                                        $city_cat_price = $city_category_price;
                                                    } else {
                                                        $whereStr = " AND category_id={$category} AND city_id={$get_city_id}";
                                                        $city_price = $this->common_model->getFieldData('city_category_price', 'price', $whereStr);
                                                        if (!empty($city_price) && $city_price != "0") {
                                                            $city_cat_price = $city_price;
                                                        } else {
                                                            $category_price = $ci->city_model->get_category_by_city_id($subcategory);
                                                            if (!empty($category_price) && $category_price[0]['price'] !== '0') {
                                                                $cat_price = $category_price[0]['price'];
                                                                $city_cat_price = $cat_price;
                                                            } else {
                                                                $category_price = $ci->city_model->get_category_by_city_id($category);
                                                                $cat_price = $category_price[0]['price'];
                                                                $city_cat_price = $cat_price;
                                                            }
                                                        }
                                                    }
                                                }


//                                                if ($city_category_id == $category || $city_category_id == $subcategory) {
//                                                    $price = $city_price;
//                                                } else {
//                                                    $category = $this->session->userdata('category');
//                                                    $sub_category_price = $ci->city_model->get_category_by_city_id($sub_category);
//                                                    $subcat_price = $sub_category_price[0]['price'];
//                                                    if ($sub_category_price[0]['price'] != '0') {
//                                                        $price = $subcat_price;
//                                                    } else {
//                                                        $category_price = $ci->city_model->get_category_by_city_id($category);
//                                                        $cat_price = $category_price[0]['price'];
//                                                        $price = $cat_price;
//                                                    }
//                                                }
//                                                if ($city_category_id != '0' && $city_price != '0') {
//                                                    $price = $city_price;
//                                                } else {
//                                                    $category = $this->session->userdata('category');
//                                                    $sub_category_price = $ci->city_model->get_category_by_city_id($sub_category);
//                                                    $subcat_price = $sub_category_price[0]['price'];
//                                                    if ($sub_category_price[0]['price'] != '0') {
//                                                        $price = $subcat_price;
//                                                    } else {
//                                                        $category_price = $ci->city_model->get_category_by_city_id($category);
//                                                        $cat_price = $category_price[0]['price'];
//                                                        $price = $cat_price;
//                                                    }
//                                                }
                                                ?>
                                                <input type='checkbox' class='city' name='city' id='<?php echo $get_city[$c]['city_id'] ?>' value='<?php echo $city_cat_price ?>' onchange='checkTotal(this), get_city_id(this)'/>
                                                <label for="tall-2-1"> <?php echo $get_city[$c]['city_name']; ?> (<?php echo "$" . $city_cat_price; ?>)</label>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>

                    </ul>
                </li>
                <?php
//                exit;
            }
            ?>
        </ul>

        <div class="form-actions">

            <button class="btn_mult" type="submit"><?php echo _clang(WRITE_ADD_CONTINUE_BTN); ?></button>
        </div>




































        <!--        <ul>
        <?php
//        $ci = & get_instance();
//        $ci->load->model('multiple_city_model');
//        $parent_id = $this->uri->segment(4);
//        for ($i = 0; $i < count($country_opt); $i++) {
        ?>

                                                                                                                                                                                                                                                                                                                                                                                                                                    <li><input type='checkbox' class='choice_country' name='choice_country' id='<?php echo $country_opt[$i]['country_id'] ?>' value='20' onchange='checkTotal(this);' style="margin-top: 10px; margin-left: 14px; position: absolute;z-index: 111;"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="accordion ui-accordion ui-widget ui-helper-reset" role="tablist" style="margin-bottom: 0.5%;position: relative">
                                                                                                                                                                                                                                                                                                                                                                                                                                            <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-1-header-0" aria-controls="ui-accordion-1-panel-0" aria-selected="false" tabindex="0">
                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e">
                                                                                                                                                                                                                                                                                                                                                                                                                                                </span>
        <?php // echo $country_opt[$i]['country_name'];                 ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="country_name">

                                                                                                                                                                                                                                                                                                                                                                                                                                                </span>
                                                                                                                                                                                                                                                                                                                                                                                                                                            </h3>
                                                                                                                                                                                                                                                                                                                                                                                                                                            <ul class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-1-panel-0" aria-labelledby="ui-accordion-1-header-0" role="tabpanel" aria-expanded="false" aria-hidden="true">
                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="my">
        <?php
//        $get_state = $ci->multiple_city_model->getState_by_field_value("country_id", $country_opt[$i]['country_id']);
//
//        for ($s = 0; $s < count($get_state); $s++) {
//            if ($get_state[$s]['state_name'] != "(none)") {
//
//                $get_city = $ci->multiple_city_model->getCity_by_field_value("state_id", $get_state[$s]['state_id']);
//
        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <input type='checkbox' title="choice_state" id="<?php echo $get_state[$s]['state_id']; ?>" style="margin-top: 10px; margin-left: 14px; position: absolute;z-index: 111;"class='choice_state' name='choice[]' value='10' onchange='checkTotal(this);' />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="accordion ui-accordion ui-widget ui-helper-reset" role="tablist" style="position: relative">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-2-header-0" aria-controls="ui-accordion-2-panel-0" aria-selected="false" tabindex="0">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </span>
        <?php //echo $get_state[$s]['state_name'];                 ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="state_name"></span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <ul class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-accordion-2-panel-0" aria-labelledby="ui-accordion-2-header-0" role="tabpanel" aria-expanded="false" aria-hidden="true">

        <?php
//        for ($c = 0; $c < count($get_city); $c++) {
//            $get_city_id = $get_city[$c]['city_id'];
        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <input type='checkbox' class='choice_city' name='city' id='<?php echo $get_city[$c]['city_id'] ?>' value='<?php echo $get_city[$c]['price'] ?>' onchange='checkTotal(this);'/>
        <?php //echo $get_city[$c]['city_name'];                ?>(<?php echo "$" . $get_city[$c]['price']; ?>)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </li>
        <?php //}                 ?>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </ul>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </li>
        <?php
//        }
//        }
        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                            </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                    </li>

        <?php //}                 ?></ul>-->
















<!--        <section id="container" >-->
        <!--        <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Step - 1</label>
                    <div class="controls left_r">

                        Number of weeks:
                        <select name="week" id="week" onchange='checkTotal()'>
                            <option value="">select</option>
        <?php
        for ($i = 1; $i <= 52; $i++) {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }
        ?>
                        </select>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Step - 2</label>
                    <div class="controls left_r">
                        <span>Select one or more metro areas:</span>
                    </div>
                </div>
                <div class="control-group bottom_space">
                    <label for="inputError" class="control-label left">Total</label>
                    <div id='tlt'>

                    </div>
                    <div class="controls left_r">
                        <input type="text" id="total" name="total" size="3" value="0" style="border:none;" readonly />
                        <input type="hidden" id="total" name="total" size="3" value="0" />
                        <input type="hidden"  name="multi_country_id" value="" />
                        <input type="hidden"  name="multi_state_id" value="" />
                        <input type="hidden"  name="multi_city_id" value="" />
                        <input type="hidden" name="sub_category" value="<?php echo $sub_category ?>"/>

                    </div>
                </div>
                <div class="control-group bottom_space">
        <?php
        $ci = & get_instance();
        $ci->load->model('multiple_city_model');
        $parent_id = $this->uri->segment(4);
        echo '<ul>';
        //$break = 1;
        for ($i = 0; $i < count($country_opt); $i++) { // country loop start
            echo "<li style='float: left;list-style: none outside none;width: 100%;'>
                        <input type='checkbox' class='choice_country' name='choice_country' id='" . $country_opt[$i]['country_id'] . "' value='20' onchange='checkTotal();' style='float:left' /><h1 class='cls_country'>" . $country_opt[$i]['country_name'] . "</h1>";
            $get_state = $ci->multiple_city_model->getState_by_field_value("country_id", $country_opt[$i]['country_id']);
            echo "<ul>";
            for ($s = 0; $s < count($get_state); $s++) { // state loop start
                if ($get_state[$s]['state_name'] != "(none)") {
                    echo "<li style='list-style: none outside none; width: 20%; vertical-align: top; display: inline-block; border-right:1px solid #cecdcd;padding:5px;'><input type='checkbox' class='choice_state' name='choice[]' id='" . $get_state[$s]['state_id'] . "' value='10' onchange='checkTotal();'  style='float:left' /><h2 class='cls_state'>" . $get_state[$s]['state_name'] . "</h2>";
                    $get_city = $ci->multiple_city_model->getCity_by_field_value("state_id", $get_state[$s]['state_id']);
                    echo "<ul>";
                    for ($c = 0; $c < count($get_city); $c++) {
//                                echo "<pre>";
//                                print_r($get_city);
//                                exit;
                        $get_city_id = $get_city[$c]['city_id'];
                        echo "<input type='checkbox' class='city' name='city' id='" . $get_city[$c]['city_id'] . "' value='" . $get_city[$c]['price'] . "' onchange='checkTotal();' style='float:left' />
                                    <li style='list-style:none ; display:block'><h3 class='cls_city'>" . $get_city[$c]['city_name'] . "</h3></li>";
                    }//city loop close
                    echo "</ul>
				</li>";
                }
            }
            echo "</ul>
                        </li>";
//                    if ($break == 5) {
//                        echo "</div><div class='break item'>";
//                        $break = 0;
//                    }
//                    $break++;
        }
        echo '</ul>';
        ?>
                </div>








                <div class="control-group bottom_space">

                    <div id="geoListings">
                        <div class="column">
                            <div class="geoBlock">

        <?php
        $ci = & get_instance();
        $ci->load->model('multiple_city_model');
        $parent_id = $this->uri->segment(4);

        for ($i = 0; $i < count($country_opt); $i++) {
            ?>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <input type='checkbox' class='choice_country' name='choice_country' id='" . $country_opt[$i]['country_id'] . "' value='20' onchange='checkTotal();' style='float:left' /><h1 class='cls_country'>" . $country_opt[$i]['country_name'] . "</h1>";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <input type='checkbox' class='choice_country' name='choice_country' id='<?php $country_opt[$i]['country_id'] ?>' value='20' onchange='checkTotal();' /><h2 class="cls_country"><?php echo $country_opt[$i]['country_name'] ?></h2>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="inner">
            <?php
            $get_state = $ci->multiple_city_model->getState_by_field_value("country_id", $country_opt[$i]['country_id']);
            for ($s = 0; $s < count($get_state); $s++) { // state loop start
                if ($get_state[$s]['state_name'] != "(none)") {
                    ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <h3 class="stat_tit"><?php echo $get_state[$s]['state_name']; ?></h3>
                    <?php
                    echo "<input type='checkbox' class='choice_state' name='choice[]' id='" . $get_state[$s]['state_id'] . "' value='10' onchange='checkTotal();'  style='float:left' /><h3 class='cls_state stat_tit'>" . $get_state[$s]['state_name'] . "</h3>";
                    $get_city = $ci->multiple_city_model->getCity_by_field_value("state_id", $get_state[$s]['state_id']);

                    echo "<ul>";
                    for ($c = 0; $c < count($get_city); $c++) {
//
                        $get_city_id = $get_city[$c]['city_id'];
                        echo "<input type='checkbox' class='city' name='city' id='" . $get_city[$c]['city_id'] . "' value='" . $get_city[$c]['price'] . "' onchange='checkTotal();' style='float:left' />
                                    <li><h3 class='cls_city'>" . $get_city[$c]['city_name'] . "</h3></li>";
                    }//city loop close
                    echo "</ul>";
                }
            }
            ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
        <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">

                        <button class="btn_mult" type="submit">Continue</button>
                    </div>

                </div>-->
        <!--    </section>-->
        <?php echo form_close(); ?>
    </div>
</section>
