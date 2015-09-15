<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.js"></script>
<style>

    h1{
        line-height: 2.2;
    }

</style>
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
        /*        font-family: Verdana,Arial,sans-serif;
                font-size: 1.1em;*/
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
        /*        margin-top: 1px;*/
        position: relative;
    }
    .ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {
        border-radius: 4px;
    }
    .ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl {
        border-radius: 4px;
    }
    .ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr {
        border-radius: 4px;
    }
    .ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl {
        border-radius: 4px;
    }
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
        background-color: #5c80bb;
        /*        border: 1px solid #d3d3d3;*/
        color: #fff;
        font-weight: normal;
        margin-top: 1px;
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
        /*background: url("assets/images/ui-icons_ffffff_256x240.png") repeat-x scroll 50% 50% #ffffff;*/
        /*        border: 1px solid #aaaaaa;*/
        color: #fff;
        font-weight: normal;
    }
    .ui-accordion .ui-accordion-content {
        border-top: 0 none;
        overflow: auto;
        /*        padding: 1em 2.2em;*/
        padding: 0 0 0 7px;
    }
    .ui-accordion-content {
        height: auto;
    }
    .ui-widget-content {
        /*background: url("images/ui-icons_ffffff_256x240.png") repeat-x scroll 50% 50% #ffffff;*/
        /*        border: 1px solid #aaaaaa;*/
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
    .arrow {
        border-color: transparent transparent transparent #fff;
        border-style: solid;
        border-width: 8px;
        content: "";
        display: block;
        left: 7px;
        position: absolute;
        top: 6px;
        width: 0;
    }
    .downArrow {
        border-color: #fff transparent transparent;
        left: 3px;
        top: 10px;
    }

</style>
<script>
    // Accordion - Expand All #01
    $(function() {
        $(".accordion").accordion({
            collapsible: true,
            active: false,
            autoHeight: false
        });
        var icons = $(".accordion").accordion("option", "icons");
        $('.open').click(function() {
            $('.ui-accordion-header').removeClass('ui-corner-all').addClass('ui-accordion-header-active ui-state-active ui-corner-top').attr({
                'aria-selected': 'true',
                'tabindex': '0'
            });
            $('.ui-accordion-header-icon').removeClass(icons.header).addClass(icons.headerSelected);
            $('.ui-accordion-content').addClass('ui-accordion-content-active').attr({
                'aria-expanded': 'true',
                'aria-hidden': 'false'
            }).show();
            $(this).attr("disabled", "disabled");
            $('.close').removeAttr("disabled");
            // $('#arrow').addClass('downArrow');
        });
        $('.close').click(function() {
            $('.ui-accordion-header').removeClass('ui-accordion-header-active ui-state-active ui-corner-top').addClass('ui-corner-all').attr({
                'aria-selected': 'false',
                'tabindex': '-1'
            });
            $('.ui-accordion-header-icon').removeClass(icons.headerSelected).addClass(icons.header);
            $('.ui-accordion-content').removeClass('ui-accordion-content-active').attr({
                'aria-expanded': 'false',
                'aria-hidden': 'true'
            }).hide();
            $(this).attr("disabled", "disabled");
            $('.open').removeAttr("disabled");

        });
        $('.ui-accordion-header').click(function() {
            $('.open').removeAttr("disabled");
            $('.close').removeAttr("disabled");
        });
    });

    function toggleContainer(e) {
        $(e).children('#arrow').toggleClass('downArrow');
    }

</script>
<section class="main_div">
    <div class="main_area">
        <div class="local_hm">
            <ul>
                <li><a href="<?php echo base_url("home") ?>">StacksClassifieds.com</a>>></li>
                <li><a href="<?php echo base_url("ad_type") ?>"><?php echo _clang(POST_AD); ?></a></li>

            </ul>
        </div>
        <h1 class="usa_tit usuptit"><?php echo _clang(CHOOSE_METRO); ?></h1>

        <?php
//        $ci = & get_instance();
//        $ci->load->model('single_city_model');
//
//        $get_city = $ci->single_city_model->get_city();
//        echo "<div class='formate'>
//                    <ul>";
//        for ($s = 0; $s < count($get_city); $s++) {
//            $get_city_id = $get_city[$s]['city_id'];
//            echo "<li><a href='" . base_url("add_post/addpostdata/" . $get_city_id) . "'>
//                    " . $get_city[$s]['city_name'] . "</a></li>";
//        }
//        echo "</ul>
//                    </div>";
        ?>
        <?php
        $ci = & get_instance();
        $ci->load->model('multiple_city_model');
        for ($i = 0; $i < count($country_opt); $i++) {
            ?>
            <ul>
                <li>
                    <div class="accordion ui-accordion ui-widget ui-helper-reset" role="tablist">
                        <h3 style="background-color: #506fa3" class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-1-header-0" aria-controls="ui-accordion-1-panel-0" aria-selected="false" tabindex="0" onclick="toggleContainer(this)">
                            <span  class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e">
                            </span>
                            <div id="arrow" class="arrow"></div>
                            <?php echo $country_opt[$i]['country_name']; ?>
                            <span class="country_name">

                            </span>
                        </h3>
                        <ul class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom"  id="ui-accordion-1-panel-0" aria-labelledby="ui-accordion-1-header-0" role="tabpanel" aria-expanded="false" aria-hidden="true">
                            <div class="my">
                                <?php
                                $get_state = $ci->multiple_city_model->getState_by_field_value("country_id", $country_opt[$i]['country_id']);

                                for ($s = 0; $s < count($get_state); $s++) {
                                    if ($get_state[$s]['state_name'] != "(none)") {

                                        $get_city = $ci->multiple_city_model->getCity_by_field_value("state_id", $get_state[$s]['state_id']);
                                        ?>
                                        <li>
                                            <div class="accordion ui-accordion ui-widget ui-helper-reset" role="tablist">
                                                <div class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-2-header-0" aria-controls="ui-accordion-2-panel-0" aria-selected="false" tabindex="0" onclick="toggleContainer(this);">
                                                    <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e">
                                                    </span>
                                                    <div id="arrow" class="arrow"></div>
                                                    <?php echo $get_state[$s]['state_name']; ?>
                                                    <span class="state_name"></span>
                                                </div>
                                                <ul class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom"  id="ui-accordion-2-panel-0" aria-labelledby="ui-accordion-2-header-0" role="tabpanel" aria-expanded="false" aria-hidden="true" style=" padding: 0.1em 3em;">
                                                    <div class="formate">
                                                        <?php
                                                        for ($c = 0; $c < count($get_city); $c++) {
                                                            $get_city_id = $get_city[$c]['city_id'];
                                                            ?>
                                                            <div>
                                                                <li>
                                                                    <a href="<?php echo base_url("add_post/addpostdata/" . $get_city_id) ?> "><?php echo $get_city[$c]['city_name']; ?></span></a>
                                                                </li>
                                                            </div>
                                                        <?php } ?>
                                                    </div>

                                                </ul>

                                            </div>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                        </ul>
                    </div>
                </li>

            <?php } ?>
        </ul>
    </div>
</section>
