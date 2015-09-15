<html><body><div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td align="center" valign="top" style="padding:20px 0 20px 0">
                        <table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="background:none repeat scroll 0 0 #506fa3;">
                            <tr class="logo" style="background:#ffff; border:none;">
                                <td valign="top">
                                    <div style="background: none repeat scroll 0% 0% #92b6f1; padding: 10px; position: relative;">
                                        <img src="<?php echo site_url() ?>assets/images/logo.png">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <table cellspacing="0" cellpadding="0" border="0" width="650">
                                        <tr>
                                            <td colspan="2">
                                                <h2 style="color:#FFF;">Reported a Posting Ads</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#FFFFFF; color:#000000; text-align:left; font-size:13px; padding:5px; font-weight:bold;" >
                                                <p style="color:#000 !important">
                                                    Hi, <?php echo $to_email; ?>
                                                    <br>
                                                    Report to below ADs:-
                                                    <b style="color: red"><blockquote> <?php echo $title; ?> </blockquote></b>
                                                    Reason of the ADs:-
                                                    <b style="color: red"><blockquote> <?php echo $reason; ?> </blockquote></b>
                                                    <?php echo $from_email ?>
                                                </p>
                                                <!--                                                <div style="color: #E46C0A; font-weight: bold;">
                                                                                                    <span style="color: #5C80BB; font-weight: bold;">Thank you for using StacksClassifieds,</span><br/>
                                                                                                    <span style="color: #5C80BB; font-weight: bold;">StacksClassifieds Team.</span>
                                                                                                </div>-->
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div></body></html>
