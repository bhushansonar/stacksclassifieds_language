<!--<style>
    #loginForm form {
        background-color: #eef;
        border: 2px solid #46a;
        border-radius: 10px;
        font-size: 14px;
        margin: 0 auto;
        padding: 18px;
        text-align: center;
    }
    #loginForm form {
        width: 350px;
    }
    #loginForm form div {
        text-align: right;
    }
    #loginForm input.signIn {
        background-color: #46a;
        border: 0 none;
        border-radius: 4px;
        color: #fff;
        font-size: 1.5em;
    }
    #loginForm {
        margin: 50px auto;
    }
    #loginForm form div input {
        width: 200px;
    }
</style>-->
<style>
    h1 {

        font-family: "Questrial",Verdana,sans-serif;
        font-size: 20px;
        padding: 0;
        position: relative;

    }

    p {
        margin-bottom: 20px;
    }

    label:before {
        color: #c1bfbd;
        transition: color 1s ease 0s;
    }
    label {
        color: #7f7e7e;
        transition: color 1s ease 0s;
    }
    input:not([type="submit"]) {
        height: 40px;
    }
    /*input:not([type="submit"]), textarea {
        border: 1px dashed #dbdbdb;
        border-radius: 2px;
        color: #3f3f3f;
        display: block;
        font-family: "Droid Sans",Tahoma,Arial,Verdana sans-serif;
        font-size: 14px;
        outline: medium none;
        padding: 4px 8px;
        transition: background 0.2s linear 0s, box-shadow 0.6s linear 0s;
        width: 75%;
    }*/
    input:required, textarea:required {
        box-shadow: none;
    }
    .iconic:before {
        font-family: "IconicStroke";
        font-size: 25px;
    }
    /* input[type="submit"] {
         background: -moz-linear-gradient(center top , #f7f7f7 1%, #f2f2f2 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
         border: 1px solid #e0e0e0;
         border-radius: 5px;
         box-shadow: 0 1px 1px #ffffff inset, 0 0 0 5px #eaeaea;
         color: #767676;
         cursor: pointer;
         font-family: "Alice",serif;
         font-size: 18px;
         margin-left: 180px;
         padding: 10px 4px;
         text-shadow: 0 1px 1px #e8e8e8;
         transition: all 0.2s linear 0s;
     }*/
    input:required, textarea:required {
        box-shadow: none;
    }
    textarea {
        min-height: 150px;
        resize: vertical;
    }
    .ali{
        text-align: center;
    }
</style>

<div id="SignupForm">
    <div class="set_errors ali">
        <?php
        if ($this->session->flashdata('validation_error_messages')) {
            echo $this->session->flashdata('validation_error_messages');
        }
        echo validation_errors();
        if ($this->session->flashdata('flash_message')) {

            echo '<div style="padding: 1%;font-size:17px; text-align: center;" class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo $this->session->flashdata("flash_reset_url");
            echo '</div>';
        }
        ?>

    </div>
    <section>

        <div class="main_area ragister_wi">
            <div class="form_area rag">
                <?php if ($this->session->userdata('is_logged_in')) { ?>
                    <article>
                        <h1><?php echo _clang(CHANGE_PASSWORD); ?></h1>
                        <form action="<?php echo site_url('home/change_password') ?>" method="post" name="create_account">
                            <input type="hidden" name="email" value="<?php echo $email; ?>" />
                            <div style = "margin:1em 0;"><label><?php echo _clang(OLD_PASS); ?></label><input type="password" class="ragister_input" value ="<?php echo custom_set_value("old_password") ?>" name ="old_password"></div>
                            <div style = "margin:1em 0;"><label><?php echo _clang(NEW_PASSWORD); ?> <span class="star">*</span></label><input type="password" class="ragister_input" value ="<?php echo custom_set_value("password") ?>" name ="password"></div>
                            <div style = "margin:1em 0;"><label><?php echo _clang(C_NEW_PASSWORD); ?><span class="star">*</span></label> <input type="password" class="ragister_input" value="<?php echo custom_set_value("password2") ?>" name="password2"></div>
                            <input type="submit" name="Submit" class="login_btn" value="<?php echo _clang(SET_PASSWORD); ?>" >
                        </form>
                    </article>
                </div>
            </div>
            <?php
        } else {
            echo "Please login first";
        }
        ?>
    </section>
</div>
<!--</main>-->