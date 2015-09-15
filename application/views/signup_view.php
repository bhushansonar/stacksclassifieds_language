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
    <section>
        <div class="set_errors ali">
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
        <div class="main_area signup_wi">

            <div class="form_area">
                <?php if (!$this->session->userdata('is_logged_in')) { ?>
                    <article>
                        <h1>Create Account</h1>
                        <form action="<?php echo site_url('signup/create_member_site') ?>" method="post" name="create_account">
                            <div><input type="hidden" name="type" value="user"></div>
                            <div style ="margin:1em 0;"><label>User Name:<span class="star">*</span></label> <input type="text" value="<?php echo custom_set_value('username') ?>" name="username" class="signup_input"></div>
                            <div style ="margin:1em 0;"><label>Email:<span class="star">*</span></label> <input type="text" value="<?php echo custom_set_value('create_email') ?>" name="create_email" class="signup_input"></div>
                            <div style ="margin:1em 0;"><label>Confirm Email: </label><input type ="text" value ="<?php echo custom_set_value('create_email_confirm') ?>" name="create_email_confirm" class="signup_input"></div>
                            <div style ="margin:1em 0;"><label>Password:<span class="star">*</span></label> <input type="password" value="" name ="password" class="signup_input"></div>
                            <div style ="margin:1em 0;"><label>Confirm Password:</label> <input type="password" value="" name="password_confirm" class="signup_input"></div>
                            <input type ="submit"  class ="signup_btn" value ="Create Account">
                        </form>
                    </article>
                </div>
            </div>
            <?php
        }
        ?>
    </section>
</div>
</main>