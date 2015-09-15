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
        width: 380px;
    }*/
    input:required, textarea:required {
        box-shadow: none;
    }
    .iconic:before {
        font-family: "IconicStroke";
        font-size: 25px;
    }
    /*input[type="submit"] {
        background: -moz-linear-gradient(center top , #f7f7f7 1%, #f2f2f2 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        box-shadow: 0 1px 1px #ffffff inset, 0 0 0 5px #eaeaea;
        color: #767676;
        cursor: pointer;
        font-family: "Alice",serif;
        font-size: 18px;
        margin-left: 235px;
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
</style>
<section class="main_div">
    <div class="main_area contect_wi">
        <div class="form_area">
            <h1>To contact me, please fill in the following form:</h1>
            <p style=" color: #7f7e7e;transition: color 1s ease 0s;">All fields with a star * are required.</p>
            <form  action="<?php echo site_url('contactus/contactus_data') ?>" method="POST" enctype="multipart/form-data">
                <p><label> Your name:<span class="iconic user">*</span></label><input name="username" placeholder="How may I call you ?" class="contact_input" type="text" value="" size="30" required="required"/></p>
                <p><label>Your email: <span class="iconic mail-alt">*</span></label><input name="usermail" placeholder="I hate spam as much as you do." class="contact_input" type="text" value="" size="30" required="required"/></p>
                <p><label>Your message:<span class="required">*</span></label><textarea name="message" placeholder="Don't be shy, leave me a friendly message." class="contact_input" rows="7" cols="30" required="required"></textarea></p>

                <input type="submit" class="contact_btn" value="Submit"/>
            </form>
        </div>
    </div>
</section>