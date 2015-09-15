<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<style>

    h3 {
        background-color: #5C80BB;
        font-size: 18px;
        padding-left: 4%;
        margin-right: 3%;
    }
    h3 a {
        color: #000;
        text-decoration: none;
    }

    li {
        padding-left: 0.5em;
    }
    a {
        color: #666666;
        font-size: 14px;
        line-height: 27px;
        text-decoration: underline;
    }
</style>


<?php
$ci = & get_instance();
$ci->load->model('home_model');
?>

<section class="main_div">
    <div class="main_area_home">
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
        <h4 class="choose_tit"><?php echo _clang(CHOOSE_METRO); ?></h4>

        <div id="geoListings">
            <div class="column">
                <div class="geoBlock">
                    <?php
                    for ($i = 0; $i < count($country_opt); $i++) {
                        $county_id = 'country_' . $i;
                        $country_sub_id = "inner_" . $i
                        ?>
                        <h2 onclick="country_click(this);" id="<?php echo $county_id; ?>"><?php echo $country_opt[$i]['country_name'] ?></h2>
                        <div class="inner" id="<?php echo $country_sub_id; ?>">

                            <?php
                            $get_state = $ci->home_model->getState_by_field_value("country_id", $country_opt[$i]['country_id']);
                            foreach ($get_state as $key => $get_states) {
//                            for ($s = 0; $s < count($get_state); $s++) {
                                $get_city = $ci->home_model->getCity_by_field_value("state_id", $get_states['state_id']);
                                $get_state_id = $get_states['state_id'];
                                $state_name = $get_states['state_name'];
                                ?>

                                <div class="geoUnit">
                                    <h3>
                                        <a class="stat_tit" style="color: #fff;font-size: 18px" href="<?php echo base_url("state_category/cat/$get_state_id/$state_name") ?>">
                                            <?php echo $get_states['state_name']; ?>
                                        </a>
                                    </h3>

                                    <ul>
                                        <?php
                                        for ($c = 0; $c < count($get_city); $c++) {
                                            $get_city_id = $get_city[$c]['city_id'];
//                                            $city_count = $c;
                                            $city_name = $get_city[$c]['city_name'];
                                            ?>

                                            <li><a href="<?php echo base_url("citycategory/cat/$get_city_id/$city_name") ?>"><?php echo $get_city[$c]['city_name']; ?></a></li>

                                        <?php } ?>

                                    </ul>

                                </div>
                            <?php } ?>

                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</section>