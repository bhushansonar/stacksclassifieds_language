<style>
    ul{
        list-style-type: none;
    }
</style>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

    function getCityName(obj) {
        var state_id = $(obj).val();
        $.ajax({
            type: 'POST',
            url: base_url + "citycategory/get_city",
            data: {state_id: state_id},
            success: function(data) {
                $('.before_city').hide();
                $('.after_city').show();
                $('#after_city').html(data);

            }
        });

    }
</script>
<div class="set_errors">
    <?php
    if ($this->session->flashdata('validation_error_messages')) {
        echo $this->session->flashdata('validation_error_messages');
    }
    echo validation_errors();
    if ($this->session->flashdata('flash_message')) {

        echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
        echo '<a class="close" data-dismiss="alert">&#215;</a>';
        echo $this->session->flashdata("flash_message");
        echo '</div>';
    }
    ?>
</div>
<?php
$ci = & get_instance();
$ci->load->model('citycategory_model');
$ci->load->model('city_model');
$ci->load->model('common_model');
$ci->load->model('top_ads_model');
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo form_open('heading/get_seraching_data_by_category', $attributes);
?>
<section class="main_div">
    <div class="main_area">
        <div class="search_main" style="margin-bottom: 2%">
            <div class="search_key">
                <div class="key_search">
                    <div class="key_left">
                        <!--                        <label class="search_tex">Search</label>-->
                        <input type="text" class="key_in" id="search_text" name="search_text" placeholder="<?php echo _clang(KEYWORD); ?>">
                    </div>
                    <div class="key_right">
                        <?php
                        $where_category = " AND parent_id = '0'";
                        $all_cat = $ci->citycategory_model->getAllcategory_Where_array(array('parent_id', 'status'), array('0', 'Active'));
                        //$all_cat = $ci->common_model->getDDArray('category', 'category_id', 'category_name_' . Do_language::GetSessionLang(), $where_category);
                        $attribute = 'id="search_category" class="key_sel"';
                        //echo form_dropdown('search_category', $all_cat, "", $attribute);
                        ?>
                        <select class="key_sel" id="search_category" name="search_category">
                            <option selected="selected" value="0">Select</option>
                            <?php
                            for ($i = 0; $i < count($all_cat); $i++) {
                                ?>
                                <option value="<?php echo $all_cat[$i]['category_id'] ?>"><?php echo (!empty($all_cat[$i]['category_name_' . Do_language::GetSessionLang()]) ? $all_cat[$i]['category_name_' . Do_language::GetSessionLang()] : $all_cat[$i]['category_name_en'] ) ?></option>
                            <?php } ?>
                        </select>
                        <input type="submit" name="submit" class="search_btn" value="<?php echo _clang(SEARCH); ?>">
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="lang">
            <div class="lang_sub">
                <?php
                $CI = & get_instance();
                $get_lang = $CI->site_language_model->get_language('', '', '', '', '', 'Active');
                for ($gl = 0; $gl < count($get_lang); $gl++) {
                    $lang_short = $get_lang[$gl]['language_shortcode'];
                    if ($lang_short == $country_language_shortcode || $lang_short == 'en') {
                        $session_lang = Do_language::GetSessionLang();
                        $class = ($session_lang == $lang_short) ? 'active_lang' : "";
                        if ($class == "active_lang") {
                            ?>
                            <a title="Active: <?php echo $get_lang[$gl]['language_longform'] ?>" style="color: #516ea4"><?php echo $get_lang[$gl]['language_longform'] ?></a>&nbsp;

                            <?php
                        } else {
                            ?>
                            <a title="<?php echo $get_lang[$gl]['language_longform'] ?>"  style="color: #516ea4" href="javascript:void(0)" onClick="set_session('<?php echo $lang_short ?>')" class="<?php echo $class ?>">
                                <?php echo $get_lang[$gl]['language_longform'] ?>
                            </a>&nbsp;
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
        <figure class="detail_left alignment">
            <article class="usa1">
                <?php
                for ($i = 0; $i < count($cat); $i++) {
                    $get_subcategory = $ci->citycategory_model->getAllSubcategory($cat[$i]['category_id']);
                    $current_date = date('Y-m-d H:i:s');
                    $count_category_post = $ci->citycategory_model->count_posts_by_category($city_id, $cat[$i]['category_id'], $current_date);
                    ?>
                    <div class="loc">
                        <h2 style="background-color: #506fa3;color: #ffffff; margin-right: 7%; text-align: center" class="local_tit"><?php echo!empty($cat[$i]['category_name_' . Do_language::GetSessionLang()]) ? $cat[$i]['category_name_' . Do_language::GetSessionLang()] : $cat[$i]['category_name_en']; ?><span class="local_small"> (<?php echo $count_category_post; ?>) </span></h2>
                        <ul style="padding: 6%">
                            <?php
                            for ($s = 0; $s < count($get_subcategory); $s++) {
                                if ($get_subcategory[$s]['category_name_' . Do_language::GetSessionLang()] != "(none)") {
                                    $subcategory_id = $get_subcategory[$s]['category_id'];
                                    $is_adult = $get_subcategory[$s]['is_adult'];
                                    if ($is_adult == 'YES') {
                                        $link = base_url("warning/warning_data_front/$city_id/$subcategory_id");
                                    } else {
                                        $link = base_url("heading/getAlltitle/$city_id/$subcategory_id");
                                    }
                                    ?>
                                    <li><a href="<?php echo $link; ?>"><?php echo (!empty($get_subcategory[$s]['category_name_' . Do_language::GetSessionLang()]) ? $get_subcategory[$s]['category_name_' . Do_language::GetSessionLang()] : $get_subcategory[$s]['category_name_en']); ?></a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            </article>
        </figure>
        <figure class="detil_right">
            <div class="mrg_right">

                <div class="detil_right_city_label">
                    <a href="<?php echo site_url('home/home_page'); ?>"><?php echo _clang(ALL_CITIES); ?></a></div>
                <div>
                    <?php
                    $whereStr = " AND city_id={$city_id}";
                    $get_states = $ci->common_model->getFieldData('city', 'state_id', $whereStr);
                    $get_all_states = $ci->common_model->getDDArray('state', 'state_id', 'state_name');
                    $all_city_by_state = $ci->common_model->get_content_by_field('city', 'state_id', $get_states);
                    $js = " getCityName(this) ";
                    $attribute = 'id="per_state" class="key_sel_two detil_right_select_box" onchange="' . $js . '" ';
                    echo form_dropdown('state', $get_all_states, $get_states, $attribute);
                    ?>
                </div>
                <div class="detil_right_city_content">
                    <ul class="before_city">
                        <?php
                        foreach ($all_city_by_state as $key => $city) {
                            ?>
                            <li>
                                <a href="<?php echo site_url(); ?>citycategory/cat/<?php echo $city['city_id'] . "/" . $city['city_name'] ?>"><?php echo $city['city_name'] ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <ul id="after_city" class="after_city" style="display: none">
                    </ul>
                </div>

            </div>
            <div class="mrg_right">
                <label>Top 20:</label>
                <ul>
                    <?php
                    $top_twenty_ads = $ci->top_ads_model->get_top_ads_front();


                    for ($t = 0; $t < count($top_twenty_ads); $t++) {
                        if ($top_twenty_ads[$t]['category_name_' . Do_language::GetSessionLang()] != "(none)") {
                            $subcat_id = $top_twenty_ads[$t]['category_id'];
                            $is_adult = $top_twenty_ads[$t]['is_adult'];
                            if ($is_adult == 'YES') {
                                $link = base_url("warning/warning_data_front/$city_id/$subcat_id");
                            } else {
                                $link = base_url("heading/getAlltitle/$city_id/$subcat_id");
                            }
                            ?>
                            <li>
                                <a style="color: #000;" href="<?php echo $link; ?>"><?php echo (!empty($top_twenty_ads[$t]['category_name_' . Do_language::GetSessionLang()]) ? $top_twenty_ads[$t]['category_name_' . Do_language::GetSessionLang()] : $top_twenty_ads[$t]['category_name_en']); ?></a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="mrg_right" style="margin-bottom: 5%; margin-top: 5%;">
                <a style="color: #2a4e89;" href="<?php echo site_url(); ?>ad_type/index/multiple"><?php echo _clang(MULT_POST_CITY); ?></a>
            </div>
        </figure>
    </div>
</section>