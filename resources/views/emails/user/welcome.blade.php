<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Welcome To {{Setting::get('sitename')}}</title>
    <style type="text/css" media="screen">

        .ExternalClass * {line-height: 100%}

        /* Début style responsive (via media queries) */

        @media only screen and (max-width: 480px) {
            *[id=email-penrose-conteneur] {width: 100% !important;}
            table[class=resp-full-table] {width: 100%!important; clear: both;}
            td[class=resp-full-td] {width: 100%!important; clear: both;}
            img[class="email-penrose-img-header"] {width:100% !important; max-width: 340px !important;}
        }

        /* Fin style responsive */

    </style>

</head>
<body style="background-color:#ecf0f1">
<div align="center" style="background-color:#ecf0f1;">

    <!-- Début en-tête -->

    <table id="email-penrose-conteneur" width="660" align="center" style="padding:20px 0px;" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table width="660" class="resp-full-table" align="center" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="50%" style="text-align:left;">
                            <a href="#" style="text-decoration:none;"><h3 style="font-size: 25px;font-family: 'Helvetica Neue', helvetica, arial, sans-serif;font-weight: bold;color: #6B6B6B;margin: 0;">{{Setting::get('sitename')}}</h3></a>
                        </td>
                        <td width="50%" style="text-align:right;">
                            <table align="right" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <h5 style="font-size: 20px;font-family: 'Helvetica Neue', helvetica, arial, sans-serif;font-weight: bold;color: #6B6B6B;margin: 0;"><?php
                                        $datetime = date("M-d-Y");
                                        $timestamp = strtotime($datetime) - 7*60*60;
                                        $time = date("M-d-Y", $timestamp);
                                        echo $time;?></h5>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    
    </table>

    <!-- Fin en-tête -->

    <table id="email-penrose-conteneur" width="660" align="center" style="border-right:1px solid #e2e8ea; border-bottom:1px solid #e2e8ea; border-left:1px solid #e2e8ea; background-color:#ffffff;" border="0" cellspacing="0" cellpadding="0">

        <!-- Début bloc "mise en avant" -->

        <tr>
            <td style="background-color:#2ecc71">
                <table width="660" class="resp-full-table" align="center" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="resp-full-td" valign="top" style="padding:20px; text-align:center;">
                            <span style="font-size:25px; font-family:'Helvetica Neue', helvetica, arial, sans-serif; font-weight:100; color:#ffffff"><a href="#" style="color:#ffffff; outline:none; text-decoration:none;">Welocme To {{ Setting::get('sitename')}}</a> </span>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>


        <!-- Début article 1 -->

        <tr>
            <td style="border-bottom: 1px solid #e2e8ea">
                <table width="660" class="resp-full-table" align="center" border="0" cellspacing="0" cellpadding="0" style="padding:20px;">
                    <tr>
                        <td width="100%">

                            <table width="100%" align="right" class="resp-full-table" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                </tr>
                            </table>

                            <h3>Hello {{$email_data['name']}}</h3>

                            <p style="font-size: 16px; line-height: 24px;">Your Username is: <a href="#">{{$email_data['email']}}</a> and your password is <b>{{$email_data['password']}}</b>. Please remember to change your password the first time you login by going to the Profile tab > Change Password.</p>

                            <!--  -->


                            <p style="font-size: 16px;line-height: 26px;">Thank you!</p>
                            <p style="font-size: 16px;line-height: 5px;">{{Setting::get('sitename')}}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Fin article 1 -->

    </table>

    <!-- Début footer -->


    <!-- Fin footer -->

</div>
</body>
</html>