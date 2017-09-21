<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Forgot Password</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body style="margin: 0; padding: 0;">
        <table border="0" cellpadding="0" cellspacing="0" width="600px" style="margin: 0 auto; letter-spacing: 1px; text-align: justify;">
            <!-- Logo Part -->
            <tr>
                <td bgcolor="#56B7E5" height="34px" style="padding: 10px 15px">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="500"><img src="http://offsiteassets.com/assets/images_offsite/login/logo.png" height="34" alt="Logo" /></td>
                            <td><img src="http://offsiteassets.com/images/redEnvelop.png" width="60" height="60" alt="" style="position: absolute; margin-top: -15px;" /></td>
                        </tr>
                    </table></td>
            </tr>
            <!-- Logo Part -->
            <tr>
                <td bgcolor="#eaeaea" style="padding: 30px 15px;">
                    <!-- Welcome Text -->
                    <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 30px;">
                        <tr style="font-size: 28px; font-weight: bold">
                            <td style="padding-right: 10px;">Hello</td>
                            <td style="padding-right: 10px;"><?php echo $users->name; ?></td>
                            <td style="padding-right: 10px;">,</td>
                        </tr>
                    </table>
                    <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 12px;">
                        <tr style="font-size: 15px;">
                            <td style="">You have recently requested to reset the password for your account. </td>
                        </tr>
                        <tr style="font-size: 15px;">
                            <td style=""></td>
                        </tr>
                        <tr style="font-size: 15px;">
                            <td style="">
                                Please use the following password listed below. This password is only valid for the first login. You will be prompted to change the password after login.
                            </td>
                        </tr>
                    </table>
                    <!-- Welcome Text -->
                    <!-- Body Part -->

                    <!-- Body Part -->
                </td>
            </tr>
            <!-- Additional Details -->
            <tr bgcolor="#f5f5f5">
                <td style="padding: 30px 15px;">
                    <table cellpadding="5" bgcolor="#4873B8" width="75%" style="margin: 0 auto; color: #fff; padding-bottom: 10px;">
                        <tr>
                            <td colspan="3" style="font-weight: bold; font-size: 21px; padding-top: 10px; padding-bottom: 10px;">Your new password is given below.</td>
                        </tr>
                        <tr>
                            <td><strong>Password</strong></td>
                            <td style="font-weight: bold;">:</td>
                            <td><?php echo $password; ?></td>
                        </tr>
                    </table></td>
            </tr>
            <!-- Additional Details -->
            <!-- Best Regards -->
            <tr>
                <td bgcolor="#f5f5f5" style="padding: 30px 15px; text-align: justify">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="padding-bottom: 10px">If you have any questions or concerns about your account, please feel free to contact us at :</td>
                        </tr>
                        <tr>
                            <td><b><?php echo $users->email; ?></b> or by calling <b><?php echo $users->phone; ?></b></td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; padding-top: 30px;">Best Regards,</td>
                        </tr>
                        <tr>
                            <td style="font-size: 21px;">The <b style="color: #9972B5">Checklist</b> Team,</td>
                        </tr>
                    </table></td>
            </tr>
            <!-- Best Regards -->
            <!-- Footer Part -->
            <tr bgcolor="#8EAADC">
                <td style="padding: 15px; display: flex; text-align: center">
                    <div style="margin: 0 auto;">
                        <div style="color: #fff; line-height: 24px; margin-right: 15px; float: left">
                            Powered by
                        </div><img style="float: left;" height="24px" src="<?php echo 'http://offsiteassets.com/' . 'images/logo.png'; ?>" alt="Logo" />
                    </div></td>
            </tr>
            <!-- Footer Part -->
        </table>
    </body>
</html>