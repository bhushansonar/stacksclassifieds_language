<style>
    #currentUser {
        color: #4668a8;
        font-size: 20px;
        font-weight: bold;
    }

    .widgetDemo {
        float: left;
    }
    .widgetDemo .size {
        font-size: 12px;
        text-align: center;
    }
    textarea {
        border: 1px dashed #dbdbdb;
        border-radius: 2px;
        color: #3f3f3f;
        display: block;
        font-family: "Droid Sans",Tahoma,Arial,Verdana sans-serif;
        font-size: 14px;
        outline: medium none;
        padding: 4px 8px;
        transition: background 0.2s linear 0s, box-shadow 0.6s linear 0s;
        width: 380px;
    }
    textarea {
        min-height: 150px;
        resize: vertical;
    }
    select,.customTextCls{
        border: 1px dashed #dbdbdb;
        border-radius: 2px;
        color: #3f3f3f;
        display: block;
        font-family: "Droid Sans",Tahoma,Arial,Verdana sans-serif;
        font-size: 14px;
        outline: medium none;
        padding: 8px;
        transition: background 0.2s linear 0s, box-shadow 0.6s linear 0s

    }
    h3{
        font-size: 19px;
        margin-top: 2%;
    }
    .widgetDemo {
        float:left;
    }
    .widgetDemo .size {
        text-align:center;
        font-size:12px;
    }

</style>
<script language="JavaScript">
    var base_url = '<?php echo base_url() ?>';
    var affiliate_number = '<?php echo $content[0]['affiliate_number'] ?>';

    var cleared;
    function clearInput(obj) {
        if (!cleared)
            obj.value = "";
        cleared = true;
    }
    function generateTextReg() {
        var form = document.forms['textAds'];
        for (var i = 0; i < form.elements["city"].length; i++) {

            if (form.elements["city"][i].selected == true) {
                var cityAddr = form.elements["city"][i].value;
                var city = form.elements["city"][i].innerHTML;
            }
        }

        for (var i = 0; i < form.elements["category"].length; i++) {
            if (form.elements["category"][i].selected == true) {
                var category = form.elements["category"][i].value;
                var catName = form.elements["category"][i].innerHTML;
                catName = catName.split('&gt;')[1];
            }
            //console.log(category);
        }

        var customText = form.elements["customText"].value;
        if (category && !cityAddr) {
            alert("If you choose a category, please choose a city as well.");
            return;
        }

        if (cleared && customText) {
            var myText = customText;
        } else if (category && cityAddr) {
            var myText = city + " " + catName;
        } else if (category) {
            var myText = catName + " Classifieds";
        } else if (cityAddr) {
            var myText = city + " Free Classifieds";
        } else {
            var myText = "Free Classifieds";
        }
        console.log(cityAddr);
        if (!cityAddr) {
            var cityAddr = "www.stacksclassifieds.com/affiliate/affiliate_classifieds/register/" + affiliate_number;
        }


        var newWindow = form.elements["newWindow"].checked ? " target=\"_blank\"" : "";
        if (category) {
            var string = "<a href=\"http://" + cityAddr + "/" + category + "" + "\"" + newWindow + ">" + myText + " Classifieds</a>";
        } else {
            var string = "<a href=\"http://" + cityAddr + "\"" + newWindow + ">" + myText + " Classifieds</a>";
        }
        document.getElementById("textAdTarget").value = string;
        document.getElementById("textLinkSample").innerHTML = string;

    }

    function generateTextPost() {
        var form = document.forms['textAdsPost'];
        for (var i = 0; i < form.elements["city"].length; i++) {

            if (form.elements["city"][i].selected == true) {
                var cityAddr = form.elements["city"][i].value;
                var city = form.elements["city"][i].innerHTML;
            }
        }

        for (var i = 0; i < form.elements["category"].length; i++) {
            if (form.elements["category"][i].selected == true) {
                var category = form.elements["category"][i].value;
                var catName = form.elements["category"][i].innerHTML;
                catName = catName.split('&gt;')[1];
            }
        }

        var customText = form.elements["customText"].value;
        if (category && !cityAddr) {
            alert("If you choose a category, please choose a city as well.");
            return;
        }

        if (cleared && customText) {
            var myText = customText;
        } else if (category && cityAddr) {
            var myText = city + " " + catName;
        } else if (category) {
            var myText = catName + " Classifieds";
        } else if (cityAddr) {
            var myText = city + " Free Classifieds";
        } else {
            var myText = "Free Classifieds";
        }

        if (!cityAddr) {
            var cityAddr = "www.stacksclassifieds.com/affiliate/affiliate_classifieds/posting";
        }


        var newWindow = form.elements["newWindow"].checked ? " target=\"_blank\"" : "";
        if (category) {
            var string = "<a href=\"http://" + cityAddr + "/" + category + "/" + affiliate_number + "/post_ad \"" + newWindow + ">" + myText + " Classifieds</a>";
        } else {
            var string = "<a href=\"http://" + cityAddr + "/" + affiliate_number + "/post_ad \"" + newWindow + ">" + myText + " Classifieds</a>";
        }
        document.getElementById("textAdTargetPost").value = string;
        document.getElementById("textLinkSamplePost").innerHTML = string;

    }

//    function generateBans() {
//        var form = document.forms['banners'];
//        for (var i = 0; i < form.elements["city"].length; i++) {
//            if (form.elements["city"][i].selected == true) {
//                var cityAddr = form.elements["city"][i].value;
//                var city = form.elements["city"][i].innerHTML;
//            }
//        }
//
//        for (var i = 0; i < form.elements["category"].length; i++) {
//            if (form.elements["category"][i].selected == true) {
//                var category = form.elements["category"][i].value;
//                var catName = form.elements["category"][i].innerHTML;
//                catName = catName.split('&gt;')[1];
//            }
//        }
//
//        if (category && !cityAddr) {
//            alert("If you choose a category, please choose a city as well.");
//            return;
//        }
//
//        if (!cityAddr) {
//            var cityAddr = "www.stacksclassifieds.com";
//            var city = "free";
//        }
//
//        var thisCategory = category ? "/" + category : "";
//        var thisCatName = category ? catName : "classifieds";
//        if (!category)
//            cityAddr = cityAddr + "/" + affiliate_number;
//        else
//            thisCategory = thisCategory + "/" + affiliate_number;
//        var obj1 = '<img src="' + base_url + 'assets/images/first_image.gif" border="0">';
//        var obj2 = '<img src="' + base_url + 'assets/images/second_image.gif" border=\"0\">';
//        var obj3 = '<img src="' + base_url + 'assets/images/third_image.gif" border="0">';
//        var obj4 = '<img src="' + base_url + 'assets/images/forth_image.gif" border="0">';
//        var newWindow = form.elements["newWindow"].checked ? " target=\"_blank\"" : "";
//        var string1 = "<div><a href=\"http://" + cityAddr + thisCategory + "\"" + newWindow + ">" + obj1 + "</a></div>";
//        var string2 = "<div><a href=\"http://" + cityAddr + thisCategory + "\"" + newWindow + ">" + obj2 + "</a></div>";
//        var string3 = "<div><a href=\"http://" + cityAddr + thisCategory + "\"" + newWindow + ">" + obj3 + "</a></div>";
//        var string4 = "<div><a href=\"http://" + cityAddr + thisCategory + "\"" + newWindow + ">" + obj4 + "</a></div>";
//        document.getElementById("banAdTarget1").value = string1;
//        document.getElementById("banAdTarget2").value = string2;
//        document.getElementById("banAdTarget3").value = string3;
//        document.getElementById("banAdTarget4").value = string4;
//    }
//
//    function generateBtns() {
//        var form = document.forms['buttons'];
//        for (var i = 0; i < form.elements["city"].length; i++) {
//            if (form.elements["city"][i].selected == true) {
//                var cityAddr = form.elements["city"][i].value;
//                var city = form.elements["city"][i].innerHTML;
//            }
//        }
//
//        for (var i = 0; i < form.elements["category"].length; i++) {
//            if (form.elements["category"][i].selected == true) {
//                var category = form.elements["category"][i].value;
//                var catName = form.elements["category"][i].innerHTML;
//                catName = catName.split('&gt;')[1];
//            }
//        }
//
//        if (category && !cityAddr) {
//            alert("If you choose a category, please choose a city as well.");
//            return;
//        }
//
//        if (!cityAddr) {
//            var cityAddr = "www.stacksclassifieds.com";
//            var city = "free";
//        }
//
//        var thisCategory = category ? "/" + category : "";
//        var thisCatName = category ? catName : "classifieds";
//        if (!category)
//            cityAddr = cityAddr + "/" + affiliate_number;
//        else
//            thisCategory = thisCategory + "/" + affiliate_number;
//        var obj1 = "<img src='" + base_url + "assets/images/stacks_one.png' border='0'>\n\<br>\n\<div style='float:left;padding-left:3px;'><span style='color:#6699CC; font-size:16px;'><u><b>" + city + " " + thisCatName + "</b></u></span></div>";
//        var obj2 = "<img src='" + base_url + "assets/images/stacks_two.png' border='0' align='left'><div style='float:left;padding-top:2px;'><span style='color:#6699CC; font-size:11px;'><u><b>" + city + " <br>" + thisCatName + "</b></u></span></div>";
//        var obj3 = "<img src='" + base_url + "assets/images/stacks_three.png' border='0'><br><div style='float:left;padding-left:2px;'><span style='color:#6699CC; font-size:13px;'><u><b>" + city + " " + thisCatName + "</b></u></span></div>";
//        var newWindow = form.elements["newWindow"].checked ? " target=\"_blank\"" : "";
//        var string1 = "<div><a href=\"http://" + cityAddr + thisCategory + "\"" + newWindow + ">" + obj1 + "</a></div>";
//        var string2 = "<div><a href=\"http://" + cityAddr + thisCategory + "\"" + newWindow + ">" + obj2 + "</a></div>";
//        var string3 = "<div><a href=\"http://" + cityAddr + thisCategory + "\"" + newWindow + ">" + obj3 + "</a></div>";
//        document.getElementById("city1").innerHTML = city;
//        document.getElementById("city2").innerHTML = city;
//        document.getElementById("city3").innerHTML = city;
//        document.getElementById("catname1").innerHTML = thisCatName;
//        document.getElementById("catname2").innerHTML = thisCatName;
//        document.getElementById("catname3").innerHTML = thisCatName;
//        document.getElementById("btnAdTarget1").value = string1;
//        document.getElementById("btnAdTarget2").value = string2;
//        document.getElementById("btnAdTarget3").value = string3;
//    }
//
//    function generateWidget() {
//        var form = document.forms['widgets'];
//        for (var i = 0; i < form.elements["city"].length; i++) {
//            if (form.elements["city"][i].selected == true) {
//                var cityAddr = form.elements["city"][i].value;
//                var city = form.elements["city"][i].innerHTML;
//            }
//        }
//        if (!cityAddr) {
//            var errorMsg = "Please choose a city."
//        }
//        for (var i = 0; i < form.elements["category"].length; i++) {
//            if (form.elements["category"][i].selected == true) {
//                var category = form.elements["category"][i].value;
//                var catName = form.elements["category"][i].innerHTML;
//            }
//        }
//        if (!category) {
//            var errorMsg = errorMsg ? errorMsg + "\n" + "Please choose a category." : "Please choose a category.";
//        }
//        for (var i = 0; i < form.elements["size"].length; i++) {
//            if (form.elements["size"][i].selected == true) {
//                var size = form.elements["size"][i].value;
//            }
//        }
//        if (!size) {
//            var errorMsg = errorMsg ? errorMsg + "\n" + "Please choose a size." : "Please choose a size.";
//        }
//        for (var i = 0; i < form.elements["style"].length; i++) {
//            if (form.elements["style"][i].selected == true) {
//                var style = form.elements["style"][i].value;
//            }
//        }
//        if (!style) {
//            var errorMsg = errorMsg ? errorMsg + "\n" + "Please choose a style." : "Please choose a style.";
//        }
//        for (var i = 0; i < form.elements["th"].length; i++) {
//            if (form.elements["th"][i].checked == true) {
//                var showThumbs = form.elements["th"][i].value;
//            }
//        }
//
//        if (errorMsg) {
//            alert(errorMsg);
//            return;
//        }
//
//        var myText = city + " " + catName;
//        var newWindow = form.elements["newWindow"].checked ? "/true" : "";
//        var string = '<scr' + 'ipt language="JavaScript" src="http://' + cityAddr + '/' + category + '/' + size + '/' + showThumbs + newWindow + '/' + affiliate_number + '" type="text/javascript"></scr' + 'ipt>';
//        document.getElementById("widgetTarget").value = string;
//        switch (size) {
//            case "half":
//                var width = 234;
//                var height = 60;
//                var boxWidth = 65;
//                var boxHeight = 48;
//                var moreWidth = 152
//                break;
//            case "full":
//                var width = 468;
//                var height = 60;
//                var boxWidth = 85;
//                var boxHeight = 48;
//                var moreWidth = 386;
//                break;
//            case "sky":
//                var width = 120;
//                var height = 600;
//                var boxWidth = false;
//                var boxHeight = false;
//                var moreWidth = false;
//                break;
//            case "vertical":
//                var width = 120;
//                var height = 240;
//                var boxWidth = false;
//                var boxHeight = false;
//                var moreWidth = false;
//                break;
//        }
//
//        if (showThumbs == "yes" && boxWidth) {
//            boxWidth = boxWidth * 2;
//        }
//
//        switch (style) {
//            case "blue":
//                var bgcolor = "E4E8EF";
//                var headbgColor = "D4D8DF";
//                var linkColor = "516ea4";
//                break;
//            case "black":
//                var bgcolor = "111111";
//                var headbgColor = "000000";
//                var linkColor = "FFFFFF";
//                break;
//            case "gold":
//                var bgcolor = "FEE776";
//                var headbgColor = "EED766";
//                var linkColor = "AA0000";
//                break;
//            case "green":
//                var bgcolor = "E4EFE8";
//                var headbgColor = "D4DFD8";
//                var linkColor = "51a46e";
//                break;
//        }
//
//
//
//
//        var myStyles = "#bpInclude {\nposition:relative;\nwidth:" + width + "px;\nheight:" + height + "px;\noverflow:hidden;\nmargin:4px;\npadding:0px;\nbackground-color:#" + bgcolor + ";\nborder: 0px solid 000;\nfont-family:verdana,arial,helvetica,sans-serif;\nfont-size:10px;\nborder:1px solid #" + bgcolor + ";\n}\n#bpInclude {\ntext-decoration: none;\n}\n#bpInclude a {\n color:#" + linkColor + ";\ntext-decoration: none;\n}\n#bpInclude a:hover {\ntext-decoration: underline;\n}\n.bpHeader {\n margin:0;\nbackground-color:#" + headbgColor + ";\n font-size: 13px;\nfont-weight:bold;\n}\n.bpHeader a {\n display:block;\ncolor: #" + linkColor + ";\n line-height:1.2em;\n}\n.bpWrap{\n font-size:10px;\n}\n.bpMore {\n line-height:1.2em;\n position:absolute;\n bottom:2px;\n right:2px;\n font-weight:bold;\n background-color:#" + bgcolor + ";\n}";
//        if (size == "half" || size == "full") {
//            myStyles = "<style>\n\n" + myStyles + "\n.bpHeader {\n float: left;\n margin-right:5px;\n padding-right:6px;\n padding-left:4px;\n text-align:right;\n}\n.bpHeader a {\n margin-top:14px;\n height:" + height + "px;\n width:70px;\n}\n.bpWrap {\n display:inline;\n float:left;\n padding:0 3px 0 0;\n margin:3px 0;\n width:" + boxWidth + "px;\n height:" + boxHeight + "px;\n}\n.bpAdImages{\n display:inline;\n float:left;\nmargin-right:5px;\n}\n.bpTitle {\n display:inline;\n line-height:1.0em;\n text-align: left;\n}\n.bpMore {\n text-align:right;\nwidth:" + moreWidth + "px;\nheight:12px;\n}\n\n</style>";
//        } else {
//            myStyles = "<style>\n\n" + myStyles + "\n.bpHeader {\n width:" + width + "px;\n padding-top:4px;\n padding-bottom:4px;\n text-align:center;\n}\n.bpWrap {\n margin:6px 0;\n padding-left: 6px;\n padding-right: 6px;\n}\n.bpAdImages{\n text-align:center;\n}\n.bpTitle {\n line-height:1.2em;\n text-align: center;\n margin-top:4px;\n clear:both;\n}\n.bpMore {\n text-align:center;\n width:" + width + "px;\n height:24px;\n}\n\n</style>";
//        }
//        document.getElementById("stylesTarget").value = myStyles;
//    }

</script>
<style>

    /* .cityClass{
         width: 57%;
     }*/
</style>

<section class="main_div">
    <div class="main_area">
        <div style="clear:both;" id="currentUser">
            <?php
            echo $content[0]['primary_email'];
            $email = $content[0]['primary_email'];
            $user_email = base64url_encode($email);

            $user_id = $content[0]['user_id'];
            ?><br>
            <span style="color:#000;font-size:16px;font-weight:normal;">
                Hello, Affiliate <span style="color:#f00;"><?php echo $content[0]['affiliate_number']; ?></span>:
                <a href='<?php echo site_url("affiliate/affiliate_account_content/$user_id") ?>'>Tools</a> |
                <a href="<?php echo site_url('affiliate/EarningsReport/' . $user_email) ?>">Reports</a> |
            <!--      <a href="<?php echo site_url('affiliate/PaymentHistory/' . $user_email) ?>">Payment History</a> |-->
                <a href="<?php echo site_url('affiliate/PaymentInfo/' . $user_email) ?>">Payment Info</a> |
                <a href="<?php echo site_url('affiliate/term/' . $user_email) ?>">Affiliate Terms</a> |
                <a href="<?php echo site_url('affiliate/ManageAds/' . $user_email); ?>">Account</a>

            </span>
        </div>

        <h3>Affiliate Program</h3>

        <p>Earn commission on new users you refer to post on StacksClassifieds.com. Commissions are paid on upgrades purchased by Users. Upgrades include sponsor ads, paid postings, and auto re-postings. Simply add links to your blog or web site using urls with your affiliate id.</p>
        <!--        <div style="padding-left:20px;" class="affPgm">
                    <strong style="padding-left:-20px;">Examples below:</strong><br>
                    http://www.stacksclassifieds.com/348570302<br>
                    http://miami.stacksclassifieds.com/348570302<br>
                    http://dallas.stacksclassifieds.com/buyselltrade/Category?key=PetsForSale&id=348570302<br>
                </div>-->
        <div class="affPgm">
            create custom ads below with your affiliate id: <?php echo $content[0]['affiliate_number']; ?>.
        </div>
        <div class="aff_view">

            <div>
                <h3 style="margin-bottom:0;">Text ads</h3>
                <div class="aff_view_copy">
                    <div class="aff_view_creat_left">
                        <form action="" method="get" name="textAds">
                            <span id="textLinkSample" style="color:#9900FF; font-size:13px;">
                                <a href="#">

                                </a>
                            </span>
                            <br>
                            <br>
                            <?php
                            $ci = & get_instance();
                            //$ci->load->model('common_model');
                            $ci->load->model('affiliate_model');
                            $city_content = $ci->affiliate_model->getAllCity();
                            $category_content = $ci->affiliate_model->getAllCategory();
                            array_pop($category_content);
                            $aff_no = $content[0]['affiliate_number'];
                            ?>
                            <select class="cityClass" name="city">
                                <option value="">Choose a city (optional)</option>
                                <?php
                                for ($c = 0; $c < count($city_content); $c++) {
                                    ?>
                                    <option  value="<?php echo "www.stacksclassifieds.com/affiliate/affiliate_classifieds/register/" . $aff_no . "/" . $city_content[$c]['city_id']; ?>"><?php echo trim($city_content[$c]['city_name']); ?></option>
                                <?php } ?>
                            </select>
                            <br>
                            <br>
                            <select class='cityClass' name="category">
                                <option value="">Choose a category (optional)</option>
                                <?php
                                for ($cat = 0; $cat < count($category_content); $cat++) {
                                    ?>
                                    <option value="<?php echo $category_content[$cat]['category_id']; ?>"><?php echo $category_content[$cat]['path']; ?></option>
                                <?php } ?>
                            </select>

                            <br><br>
                            <input type="text" onmousedown="clearInput(this);" value="Custom text (optional)" name="customText" class="customTextCls"><br><br>
                            <input type="checkbox" value="yes" name="newWindow">open a link in a new window when checked<br><br>

                            <button onclick="generateTextReg();
        return false;" value="Generate code">Generate code For Register</button>

                        </form>
                    </div>
                    <div class="aff_view_creat_right">
                        Copy this HTML code and emil to your Friend or User to click this link:<br><br>
                        <textarea class="aff_view_textarea" id="textAdTarget"></textarea>
                        <a href="<?php echo site_url('affiliate/affiliate_user/' . $user_email . "/" . $aff_no) ?>" >Invite to your friend</a>
                        <br clear="all">
                    </div>

                </div>
                <div style="clear:left;border-bottom: 1px solid #000;">
                    <br>
                </div>
                <br>
                <!--                <h3 style="margin-bottom:0;">Text ads</h3>
                                <div style="padding:0 20px 20px;">
                                    <div style="float:left;width:327px;">
                                        <form action="" method="get" name="textAdsPost">
                                            <span id="textLinkSamplePost" style="color:#9900FF; font-size:13px;">
                                                <a href="#">

                                                </a>
                                            </span>
                                            <br>
                                            <br>
                <?php
                $ci = & get_instance();
                //$ci->load->model('common_model');
                $ci->load->model('affiliate_model');
                $city_content = $ci->affiliate_model->getAllCity();
                $category_content = $ci->affiliate_model->getAllCategory();
                array_pop($category_content);
                ?>
                                            <select class="cityClass" name="city">
                                                <option value="">Choose a city (optional)</option>
                <?php
                for ($c = 0; $c < count($city_content); $c++) {
                    ?>
                                                                                                                                                                            <option  value="<?php echo "www.stacksclassifieds/affiliate/affiliate_classifieds/posting/" . $city_content[$c]['city_id']; ?>"><?php echo trim($city_content[$c]['city_name']); ?></option>
                <?php } ?>
                                            </select>
                                            <br>
                                            <br>
                                            <select class='cityClass' name="category">
                                                <option value="">Choose a category (optional)</option>
                <?php
                for ($cat = 0; $cat < count($category_content); $cat++) {
                    ?>
                                                                                                                                                                            <option value="<?php echo $category_content[$cat]['category_id']; ?>"><?php echo $category_content[$cat]['path']; ?></option>
                <?php } ?>
                                            </select>

                                            <br><br>
                                            <input type="text" onmousedown="clearInput(this);" value="Custom text (optional)" name="customText" style="width:229px;" class="customTextCls"><br><br>
                                            <input type="checkbox" value="yes" name="newWindow">open a link in a new window when checked<br><br>

                                            <button onclick="generateTextPost();
                        return false;" value="Generate code">Generate code For Posting Ads</button>

                                    </div>
                                    </form>
                                </div>
                                <div style="float:left;">
                                    Copy this HTML code and emil to your Friend or User to click this link:<br><br>
                                    <textarea style="width:300px; height:80px;" id="textAdTargetPost"></textarea>
                                    <a href="<?php echo site_url('affiliate/affiliate_user/' . $user_email) ?>" >Invite to your friend</a>
                                    <br clear="all">
                                </div>-->

            </div>
            <!--            <div style="clear:left;border-bottom: 1px solid #000;">
                            <br>
                        </div>-->



            <!--                <h3 style="margin-bottom:0;">Banners</h3>
                            <div style="padding:0 20px 20px;">
                                <form action="" method="get" name="banners">
                                    <div>
                                        <div style="float:left;width:400px;">
                                            <br><br><img src="<?php echo base_url(); ?>assets/images/first_image.gif">
                                        </div>
                                        <div style="float:left;">
                                            Copy this HTML code into your web site or blog:<br><br>
                                            <textarea style="width:300px; height:90px;" id="banAdTarget1"></textarea>
                                        </div>
                                        <div style="clear:left;border-bottom: 2px solid #ececec;">
                                            <br>
                                        </div>
                                    </div>

                                    <div style="margin-top:20px;">
                                        <div style="float:left;width:400px;">
                                            <img src="<?php echo base_url(); ?>assets/images/second_image.gif">
                                        </div>
                                        <div style="float:left;">
                                            <textarea style="width:300px; height:90px;" id="banAdTarget2"></textarea>
                                        </div>
                                        <div style="clear:left;border-bottom: 2px solid #ececec;">
                                            <br>
                                        </div>
                                    </div>

                                    <div style="margin-top:20px;">
                                        <div style="float:left;width:400px;">
                                            <img src="<?php echo base_url(); ?>assets/images/third_image.gif">
                                        </div>
                                        <div style="float:left;">
                                            <textarea style="width:300px; height:90px;" id="banAdTarget3"></textarea>
                                        </div>
                                        <div style="clear:left;border-bottom: 2px solid #ececec;">
                                            <br>
                                        </div>
                                    </div>

                                    <div style="margin-top:20px;">
                                        <div style="float:left;width:400px;">
                                            <img src="<?php echo base_url(); ?>assets/images/forth_image.gif">
                                        </div>
                                        <div style="float:left;">
                                            <textarea style="width:300px; height:90px;" id="banAdTarget4"></textarea>
                                        </div>
                                        <div style="clear:left;border-bottom: 2px solid #ececec;">
                                            <br>
                                        </div>
                                    </div>

                                    <div style="clear:left;margin-top:20px;">
                                        You can also modify the ads above to link to a specific city.<br><br>
                                        <select style="width:29%;" name="city">
                                            <option value="">Choose a city (optional)</option>
            <?php
            for ($c = 0; $c < count($city_content); $c++) {
                ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <option  value="<?php echo "www.stacksclassifieds/" . $city_content[$c]['city_id']; ?>"><?php echo trim($city_content[$c]['city_name']); ?></option>
            <?php } ?>

                                        </select><br><br>
                                        <select style="width:29%;" name="category">
                                            <option value="">Choose a category (optional)</option>
            <?php
            for ($cat = 0; $cat < count($category_content); $cat++) {
                ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <option value="<?php echo $category_content[$cat]['category_id']; ?>"><?php echo $category_content[$cat]['path']; ?></option>
            <?php } ?>
                                        </select>
                                        <br><br>
                                        <input type="checkbox" value="yes" name="newWindow">open a link in a new window when checked<br><br>
                                        <button onclick="generateBans();
                    return false;" value="Generate code">Generate code</button>
                                    </div>
                                </form>

                                <p>Find many more banner ads <a href="http://www.stacksclassifieds.com/classifieds/affiliates/MoreBannerAds">here</a>.</p>
                            </div>
                            <div style="clear:left;border-bottom: 1px solid #000;">
                                <br>
                            </div>
                            <br>
                            <h3 style="margin-bottom:0;">Buttons</h3>
                            <div style="padding:0 20px 20px;">
                                <form action="" method="get" name="buttons">
                                    <div>
                                        <div style="float:left;width:400px;">
                                            <br><br><img src="<?php echo base_url(); ?>assets/images/stacks_one.png"><br><div style="float:left;padding-left:3px;"><span style=" color:#6699CC; font-size:16px;"><u><b><span id="city1">free</span> <span id="catname1">classifieds</span></b></u></span></div>
                                        </div>
                                        <div style="float:left;">
                                            Copy this HTML code into your web site or blog:<br><br>
                                            <textarea style="width:300px; height:90px;" id="btnAdTarget1"></textarea>
                                        </div>
                                        <div style="clear:left;border-bottom: 2px solid #ececec;">
                                            <br>
                                        </div>
                                    </div>

                                    <div style="margin-top:20px;">
                                        <div style="float:left;width:400px;">
                                            <img align="left" src="<?php echo base_url(); ?>assets/images/stacks_two.png"><div style="float:left;padding-top:2px;"><span style=" color:#6699CC; font-size:11px;"><u><b><span id="city2">free</span> <br><span id="catname2">classifieds</span></b></u></span></div>
                                        </div>
                                        <div style="float:left;">
                                            <textarea style="width:300px; height:90px;" id="btnAdTarget2"></textarea>
                                        </div>
                                        <div style="clear:left;border-bottom: 2px solid #ececec;">
                                            <br>
                                        </div>
                                    </div>

                                    <div style="margin-top:20px;">
                                        <div style="float:left;width:400px;">
                                            <img src="<?php echo base_url(); ?>assets/images/stacks_three.png"><br><div style="float:left;padding-left:2px;"><span style=" color:#6699CC; font-size:13px;"><u><b><span id="city3">free</span> <span id="catname3">classifieds</span></b></u></span></div>
                                        </div>
                                        <div style="float:left;">
                                            <textarea style="width:300px; height:90px;" id="btnAdTarget3"></textarea>
                                        </div>
                                        <div style="clear:left;border-bottom: 2px solid #ececec;">
                                            <br>
                                        </div>
                                    </div>

                                    <div style="clear:left;margin-top:20px;">
                                        You can also modify the ads above to link to a specific city.<br><br>
                                        <select style="width:29%;" name="city">
                                            <option value="">Choose a city (optional)</option>
            <?php
            for ($c = 0; $c < count($city_content); $c++) {
                ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <option  value="<?php echo "www.stacksclassifieds/" . $city_content[$c]['city_id']; ?>"><?php echo trim($city_content[$c]['city_name']); ?></option>
            <?php } ?>

                                        </select><br><br>
                                        <select style="width:29%;" name="category">
                                            <option value="">Choose a category (optional)</option>
            <?php
            for ($cat = 0; $cat < count($category_content); $cat++) {
                ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <option value="<?php echo $category_content[$cat]['category_id']; ?>"><?php echo $category_content[$cat]['path']; ?></option>
            <?php } ?>
                                        </select>
                                        <br><br>
                                        <input type="checkbox" value="yes" name="newWindow">open a link in a new window when checked<br><br>
                                        <button onclick="generateBtns();
                    return false;" value="Generate code">Generate code</button>
                                    </div>
                                </form>
                            </div>
                            <div style="clear:left;border-bottom: 1px solid #000;">
                                <br>
                            </div>
                            <br>


                            <h3 style="margin-bottom:0;">Widgets</h3>
                            <div style="padding:0 20px 20px;">
                                <div style="float:left;width:400px;">
                                    <form action="" method="get" name="widgets">
                                        <div style="padding-right:20px;">The backpage widget displays actual ads using JavaScript. If your site or blog accepts Javascript, these are  the best ads to post on your site. Note: some sites do not accept Javascript.</div><br><br>
                                        <select style="width:57%;" name="city">
                                            <option value="">Choose a city (optional)</option>
            <?php
            for ($c = 0; $c < count($city_content); $c++) {
                ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <option  value="<?php echo "www.stacksclassifieds/" . $city_content[$c]['city_id']; ?>"><?php echo trim($city_content[$c]['city_name']); ?></option>
            <?php } ?>

                                        </select><br><br>
                                        <select style="width:57%;" name="category">
                                            <option value="">Choose a category (optional)</option>
            <?php
            for ($cat = 0; $cat < count($category_content); $cat++) {
                ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <option value="<?php echo $category_content[$cat]['category_id']; ?>"><?php echo $category_content[$cat]['path']; ?></option>
            <?php } ?>
                                        </select>
                                        <br><br>
                                        <select style="width:230px;" name="size">
                                            <option value="">Choose a size</option>
                                            <option value="half">Half Banner (60x234)</option>
                                            <option value="full">Full Banner (60x468)</option>
                                            <option value="sky">Skyscraper (600x120)</option>
                                            <option value="vertical">Vertical Banner (240x120)</option>
                                        </select><br><br>
                                        <select style="width:230px;" name="style">
                                            <option value="">Choose a style</option>
                                            <option value="blue">blue</option>
                                            <option value="black">black</option>
                                            <option value="gold">gold</option>
                                            <option value="green">green</option>
                                        </select><br><br>
                                        Choose to show thumbnail images<br>
                                        <input type="radio" checked="" value="yes" name="th"> yes&nbsp;&nbsp;&nbsp;<input type="radio" value="no" name="th"> no<br><br>
                                        <input type="checkbox" value="yes" name="newWindow">open a link in a new window when checked<br><br>
                                        <button onclick="generateWidget();
                    return false;" value="Generate code">Generate code</button><br><br>
                                    </form>
                                </div>

                                <div style="float:left;">
                                    Copy this HTML code into your web site or blog:<br><br>
                                    <textarea style="width:300px; height:80px;" id="widgetTarget"></textarea><br><br>
                                    Include these styles into your web site or blog:<br><br>
                                    <textarea style="width:300px; height:220px;" id="stylesTarget"></textarea>
                                    <br clear="all">
                                </div>
                            </div>-->

            <!--                <div style="clear:left;width:700px;">
                                           <h3 style="margin-bottom:0;">Widget Ad Samples</h3>
                                           <div id="widgetDemo1" class="widgetDemo">
                                               <style>
                                                   #widgetDemo1 #bpInclude {
                                                       position:relative;
                                                       width:120px;
                                                       height:600px;
                                                       overflow:hidden;
                                                       margin:4px;
                                                       padding:0px;
                                                       background-color:#E4E8EF;
                                                       border: 0px solid 000;
                                                       font-family:verdana,arial,helvetica,sans-serif;
                                                       font-size:10px;
                                                       border:1px solid #D4D8DF;
                                                   }

                                                   #widgetDemo1 #bpInclude {
                                                       text-decoration: none;
                                                   }
                                                   #widgetDemo1 #bpInclude a {
                                                       color:#516ea4;
                                                       text-decoration: none;
                                                   }
                                                   #widgetDemo1 #bpInclude a:hover {
                                                       text-decoration: underline;
                                                   }

                                                   #widgetDemo1 .bpHeader {
                                                       margin:0;
                                                       background-color:#D4D8DF;
                                                       font-size: 13px;
                                                       font-weight:bold;
                                                   }

                                                   #widgetDemo1 .bpHeader a {
                                                       display:block;
                                                       color: #516ea4;
                                                       line-height:1.2em;
                                                   }

                                                   #widgetDemo1 .bpWrap{
                                                       font-size:10px;
                                                   }

                                                   #widgetDemo1 .bpMore {
                                                       line-height:1.2em;
                                                       position:absolute;
                                                       bottom:2px;
                                                       right:2px;
                                                       font-weight:bold;
                                                       background-color:#E4E8EF;
                                                   }






                                                   #widgetDemo1 .bpHeader {
                                                       width:120px;
                                                       padding-top:4px;
                                                       padding-bottom:4px;
                                                       text-align:center;
                                                   }
                                                   #widgetDemo1 .bpWrap {
                                                       margin:6px 0;
                                                       padding-left: 6px;
                                                       padding-right: 6px;
                                                   }
                                                   #widgetDemo1 .bpAdImages{
                                                       text-align:center;
                                                   }
                                                   #widgetDemo1 .bpTitle {
                                                       line-height:1.2em;
                                                       text-align: center;
                                                       margin-top:4px;
                                                       clear:both;
                                                   }
                                                   #widgetDemo1 .bpMore {
                                                       text-align:center;
                                                       width:120px;
                                                       height:24px;
                                                   }
                                               </style>
                                               <div class="size">Skyscraper<br>(600x120)</div>
                                               <script type="text/javascript" src="http://dallas.stacksclassifieds.com/online/Marketing/Include?key=AutosForSale&si=sky&th=yes&id=348570302" language="JavaScript"></script>
                                           </div>
                                           <div id="widgetDemo2" class="widgetDemo">
                                               <div class="size">Full (60x468)</div>
                                               <style>
                                                   #widgetDemo2 #bpInclude {
                                                       position:relative;
                                                       width:468px;
                                                       height:60px;
                                                       overflow:hidden;
                                                       margin:4px;
                                                       padding:0px;
                                                       background-color:#FEE776;
                                                       border: 0px solid 000;
                                                       font-family:verdana,arial,helvetica,sans-serif;
                                                       font-size:10px;
                                                       border:1px solid #EED766;
                                                   }

                                                   #widgetDemo2 #bpInclude {
                                                       text-decoration: none;
                                                   }
                                                   #widgetDemo2 #bpInclude a {
                                                       color:#AA0000;
                                                       text-decoration: none;
                                                   }
                                                   #widgetDemo2 #bpInclude a:hover {
                                                       text-decoration: underline;
                                                   }

                                                   #widgetDemo2 .bpHeader {
                                                       margin:0;
                                                       background-color:#EED766;
                                                       font-size: 13px;
                                                       font-weight:bold;
                                                   }

                                                   #widgetDemo2 .bpHeader a {
                                                       display:block;
                                                       color: #AA0000;
                                                       line-height:1.2em;
                                                   }

                                                   #widgetDemo2 .bpWrap{
                                                       font-size:10px;
                                                   }

                                                   #widgetDemo2 .bpMore {
                                                       line-height:1.2em;
                                                       position:absolute;
                                                       bottom:2px;
                                                       right:2px;
                                                       font-weight:bold;
                                                       background-color:#FEE776;
                                                   }






                                                   #widgetDemo2 .bpHeader {
                                                       float: left;
                                                       margin-right:5px;
                                                       padding-right:6px;
                                                       padding-left:4px;
                                                       text-align:right;
                                                   }
                                                   #widgetDemo2 .bpHeader a {
                                                       margin-top:14px;
                                                       height:60px;
                                                       width:70px;
                                                   }
                                                   #widgetDemo2 .bpWrap {
                                                       display:inline;
                                                       float:left;
                                                       padding:0 3px 0 0;
                                                       margin:3px 0;
                                                       width:85px;
                                                       height:48px;
                                                   }
                                                   #widgetDemo2 .bpAdImages{
                                                       display:inline;
                                                       float:left;
                                                       margin-right:5px;
                                                   }
                                                   #widgetDemo2 .bpTitle {
                                                       display:inline;
                                                       line-height:1.0em;
                                                       text-align: left;
                                                   }
                                                   #widgetDemo2 .bpMore {
                                                       text-align:right;
                                                       width:386px;
                                                       height:12px;
                                                   }


                                               </style>
                                               <script type="text/javascript" src="http://dallas.stacksclassifieds.com/online/Marketing/Include?key=AutosForSale&si=full&id=348570302" language="JavaScript"></script>
                                           </div>
                                           <div id="widgetDemo3" class="widgetDemo">
                                               <div class="size">Half (60x234)</div>
                                               <style>
                                                   #widgetDemo3 #bpInclude {
                                                       position:relative;
                                                       width:234px;
                                                       height:60px;
                                                       overflow:hidden;
                                                       margin:4px;
                                                       padding:0px;
                                                       background-color:#E4EFE8;
                                                       border: 0px solid 000;
                                                       font-family:verdana,arial,helvetica,sans-serif;
                                                       font-size:10px;
                                                       border:1px solid #D4DFD8;
                                                   }

                                                   #widgetDemo3 #bpInclude {
                                                       text-decoration: none;
                                                   }
                                                   #widgetDemo3 #bpInclude a {
                                                       color:#51a46e;
                                                       text-decoration: none;
                                                   }
                                                   #widgetDemo3 #bpInclude a:hover {
                                                       text-decoration: underline;
                                                   }

                                                   #widgetDemo3 .bpHeader {
                                                       margin:0;
                                                       background-color:#D4DFD8;
                                                       font-size: 13px;
                                                       font-weight:bold;
                                                   }

                                                   #widgetDemo3 .bpHeader a {
                                                       display:block;
                                                       color: #51a46e;
                                                       line-height:1.2em;
                                                   }

                                                   #widgetDemo3 .bpWrap{
                                                       font-size:10px;
                                                   }

                                                   #widgetDemo3 .bpMore {
                                                       line-height:1.2em;
                                                       position:absolute;
                                                       bottom:2px;
                                                       right:2px;
                                                       font-weight:bold;
                                                       background-color:#E4EFE8;
                                                   }






                                                   #widgetDemo3 .bpHeader {
                                                       float: left;
                                                       margin-right:5px;
                                                       padding-right:6px;
                                                       padding-left:4px;
                                                       text-align:right;
                                                   }
                                                   #widgetDemo3 .bpHeader a {
                                                       margin-top:14px;
                                                       height:60px;
                                                       width:70px;
                                                   }
                                                   #widgetDemo3 .bpWrap {
                                                       display:inline;
                                                       float:left;
                                                       padding:0 3px 0 0;
                                                       margin:3px 0;
                                                       width:65px;
                                                       height:48px;
                                                   }
                                                   #widgetDemo3 .bpAdImages{
                                                       display:inline;
                                                       float:left;
                                                       margin-right:5px;
                                                   }
                                                   #widgetDemo3 .bpTitle {
                                                       display:inline;
                                                       line-height:1.0em;
                                                       text-align: left;
                                                   }
                                                   #widgetDemo3 .bpMore {
                                                       text-align:right;
                                                       width:152px;
                                                       height:12px;
                                                   }
                                               </style>
                                               <script type="text/javascript" src="http://dallas.stacksclassifieds.com/online/Marketing/Include?key=AutosForSale&si=half&id=348570302" language="JavaScript"></script>
                                           </div>
                                           <div id="widgetDemo5" class="widgetDemo">
                                               <div class="size">Half (60x234)</div>
                                               <style>

                                                   #widgetDemo5 #bpInclude {
                                                       position:relative;
                                                       width:234px;
                                                       height:60px;
                                                       overflow:hidden;
                                                       margin:4px;
                                                       padding:0px;
                                                       background-color:#FEE776;
                                                       border: 0px solid 000;
                                                       font-family:verdana,arial,helvetica,sans-serif;
                                                       font-size:10px;
                                                       border:1px solid #EED766;
                                                   }

                                                   #widgetDemo5 #bpInclude {
                                                       text-decoration: none;
                                                   }
                                                   #widgetDemo5 #bpInclude a {
                                                       color:#AA0000;
                                                       text-decoration: none;
                                                   }
                                                   #widgetDemo5 #bpInclude a:hover {
                                                       text-decoration: underline;
                                                   }

                                                   #widgetDemo5 .bpHeader {
                                                       margin:0;
                                                       background-color:#EED766;
                                                       font-size: 13px;
                                                       font-weight:bold;
                                                   }

                                                   #widgetDemo5 .bpHeader a {
                                                       display:block;
                                                       color: #AA0000;
                                                       line-height:1.2em;
                                                   }

                                                   #widgetDemo5 .bpWrap{
                                                       font-size:10px;
                                                   }

                                                   #widgetDemo5 .bpMore {
                                                       line-height:1.2em;
                                                       position:absolute;
                                                       bottom:2px;
                                                       right:2px;
                                                       font-weight:bold;
                                                       background-color:#FEE776;
                                                   }








                                                   #widgetDemo5 .bpHeader {
                                                       float: left;
                                                       margin-right:5px;
                                                       padding-right:6px;
                                                       padding-left:4px;
                                                       text-align:right;
                                                   }
                                                   #widgetDemo5 .bpHeader a {
                                                       margin-top:14px;
                                                       height:60px;
                                                       width:70px;
                                                   }
                                                   #widgetDemo5 .bpWrap {
                                                       display:inline;
                                                       float:left;
                                                       padding:0 3px 0 0;
                                                       margin:3px 0;
                                                       width:130px;
                                                       height:48px;
                                                   }
                                                   #widgetDemo5 .bpAdImages{
                                                       display:inline;
                                                       float:left;
                                                       margin-right:5px;
                                                   }
                                                   #widgetDemo5 .bpTitle {
                                                       display:inline;
                                                       line-height:1.0em;
                                                       text-align: left;
                                                   }
                                                   #widgetDemo5 .bpMore {
                                                       text-align:right;
                                                       width:152px;
                                                       height:12px;
                                                   }



                                               </style>
                                               <script type="text/javascript" src="http://dallas.stacksclassifieds.com/online/Marketing/Include?key=AutosForSale&si=half&th=yes&id=348570302" language="JavaScript"></script>
                                           </div>
                                           <div id="widgetDemo4" class="widgetDemo">
                                               <div class="size">Vertical<br>(240x120)</div>
                                               <style>
                                                   #widgetDemo4 #bpInclude {
                                                       position:relative;
                                                       width:120px;
                                                       height:240px;
                                                       overflow:hidden;
                                                       margin:4px;
                                                       padding:0px;
                                                       background-color:#111111;
                                                       border: 0px solid 000;
                                                       font-family:verdana,arial,helvetica,sans-serif;
                                                       font-size:10px;
                                                       border:1px solid #000000;
                                                   }

                                                   #widgetDemo4 #bpInclude {
                                                       text-decoration: none;
                                                   }
                                                   #widgetDemo4 #bpInclude a {
                                                       color:#FFFFFF;
                                                       text-decoration: none;
                                                   }
                                                   #widgetDemo4 #bpInclude a:hover {
                                                       text-decoration: underline;
                                                   }

                                                   #widgetDemo4 .bpHeader {
                                                       margin:0;
                                                       background-color:#000000;
                                                       font-size: 13px;
                                                       font-weight:bold;
                                                   }

                                                   #widgetDemo4 .bpHeader a {
                                                       display:block;
                                                       color: #FFFFFF;
                                                       line-height:1.2em;
                                                   }

                                                   #widgetDemo4 .bpWrap{
                                                       font-size:10px;
                                                   }

                                                   #widgetDemo4 .bpMore {
                                                       line-height:1.2em;
                                                       position:absolute;
                                                       bottom:2px;
                                                       right:2px;
                                                       font-weight:bold;
                                                       background-color:#111111;
                                                   }






                                                   #widgetDemo4 .bpHeader {
                                                       width:120px;
                                                       padding-top:4px;
                                                       padding-bottom:4px;
                                                       text-align:center;
                                                   }
                                                   #widgetDemo4 .bpWrap {
                                                       margin:6px 0;
                                                       padding-left: 6px;
                                                       padding-right: 6px;
                                                   }
                                                   #widgetDemo4 .bpAdImages{
                                                       text-align:center;
                                                   }
                                                   #widgetDemo4 .bpTitle {
                                                       line-height:1.2em;
                                                       text-align: center;
                                                       margin-top:4px;
                                                       clear:both;
                                                   }
                                                   #widgetDemo4 .bpMore {
                                                       text-align:center;
                                                       width:120px;
                                                       height:24px;
                                                   }


                                               </style>
                                               <script type="text/javascript" src="http://dallas.stacksclassifieds.com/online/Marketing/Include?key=AutosForSale&si=vertical&th=yes&id=348570302" language="JavaScript"></script>
                                           </div>
                                       </div>-->
            <!--                <div style="clear:left;border-bottom: 1px solid #000;">
                                <br>
                            </div>-->

        </div>
    </div>

</div>
</section>