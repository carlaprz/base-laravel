@include('emails.complements.header')
<tr>
    <td class="content" align="left" style="padding-top:12px;padding-bottom:12px;background-color:#ffffff;border:1px solid #EEEEEE;border-radius:5px;">

        <table width="600" border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 600px;">
            <tr>
                <td class="content-wrapper" align="center" style="padding-left:24px;padding-right:24px;padding-top:24px;">
                    <a class="padding logo" href="{{route('home')}}" target="_blank"><img style="margin-bottom:20px;" class="logo" src="{{ asset('front/images/mail/logo.png') }}" alt="Potoroze" /></a>
                    <br><br>
                    <div class="title" style="font-family: Helvetica, Arial, sans-serif;font-size: 33px;font-weight: lighter; color: #374550;">BIENVENUE</div>
                    <br><br>
                    <div><p style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;text-align:left;color:#333333;margin-top:12px">@lang('msg.welcome_mail.welcome') {{ $name }},<br>
                            @lang('msg.welcome_mail.text1')<br>
                            @lang('msg.welcome_mail.text2')
                        </p><br>

                    </div>
                </td>
            </tr>
            <tr>
                <td class="cols-wrapper" style="padding-left:12px;padding-right:12px; max-width: 600px">

                    <!--[if mso]>
                    <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">
                        <tr><td width="192" style="width: 192px;" valign="top"><![endif]-->


                    <table width="600" border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 600px;">
                        <tr>
                            <td class="col" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                                <img src="{{ asset($image) }}" alt="Potoroze Profile" style="border-radius: 50%;"/>
                            </td>
                            <td class="col" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                                <div class="subtitle" style="font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:600;color:#5c5c5c;margin-top:18px;text-transform: uppercase;">@lang('msg.welcome_mail.text3')</div>
                                <div class="col-copy" style="font-family:Helvetica, Arial, sans-serif;font-size:13px;line-height:20px;text-align:left;color:#333333;margin-top:12px">
                                    @lang('msg.welcome_mail.text4')<br>
                                    @lang('msg.welcome_mail.text5')
                                </div><br/><br/>
                                <a class="btAction" style="margin-right: 12%;padding: 1em 1em;text-transform: uppercase;font-size: .8em;
                                   color: white;font-weight: bold;background-color: #d600c1;font-family: Helvetica, Arial, sans-serif;
                                   float: right;min-width: 10em; text-align: center;  text-decoration: none;"  href="{{route('user.edit')}}">@lang('msg.welcome_mail.text6')</a>
                                <br>
                            </td>
                        </tr>
                    </table>

                    <!--[if mso]></td><td width="192" style="width: 192px;" valign="top"><![endif]-->

                    <!--[if mso]></td><td width="192" style="width: 192px;" valign="top"><![endif]-->


                    <table width="600" border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 600px;">
                        <tr>
                            <td class="col" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                                <div class="subtitle" style="font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:600;color:#5c5c5c;margin-top:18px;text-transform: uppercase;">@lang('msg.welcome_mail.text7')</div>
                                <div class="col-copy" style="font-family:Helvetica, Arial, sans-serif;font-size:13px;line-height:20px;text-align:left;color:#333333;margin-top:12px">                    @lang('msg.welcome_mail.text8')<br>@lang('msg.welcome_mail.text9')     </div><br/><br/>
                                <a class="btAction" style="margin-right: 12%;padding: 1em 1em;text-transform: uppercase;font-size: .8em;
                                   color: white;font-weight: bold;background-color: #d600c1;font-family: Helvetica, Arial, sans-serif;
                                   float: right;min-width: 10em;text-align: center;text-decoration: none;" href="{{route('user.looks.create')}}" >@lang('msg.welcome_mail.text10')</a>
                                <br>
                            </td>
                            <td class="col" valign="top" style="
                                -webkit-padding-left:12px;
                                -moz-padding-left:12px;
                                -webkit-padding-right:12px;
                                -moz-padding-right:12px;
                                -webkit-padding-top:18px;
                                -moz-padding-top:18px;
                                -webkit-padding-bottom:12px;
                                -moz-padding-bottom:12px;">

                                <img src="{{ asset('front/images/image-look.png') }}" alt="Potoroze Looks" style="width: 20em;"/>
                            </td>
                        </tr>
                    </table>


                    <table width="600" border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 600px;">
                        <tr>
                            <td class="col" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                                <img src="{{ asset('front/images/smartphone.png') }}" alt="Potoroze Frips" style="width: 20em;" />
                            </td>
                            <td class="col" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                                <div class="subtitle" style="font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:600;color:#5c5c5c;margin-top:18px;text-transform: uppercase;">@lang('msg.welcome_mail.text11')</div>
                                <div class="col-copy" style="font-family:Helvetica, Arial, sans-serif;font-size:13px;line-height:20px;text-align:left;color:#333333;margin-top:12px">
                                    @lang('msg.welcome_mail.text12')
                                </div><br/><br/>
                                <a class="btAction" style="    margin-right: 12%;padding: 1em 1em;text-transform: uppercase;font-size: .8em;
                                   color: white;font-weight: bold;background-color: #d600c1;font-family: Helvetica, Arial, sans-serif;
                                   float: right;min-width: 10em;text-align: center; text-decoration: none;" href="{{route('my_account.ads.create')}}">@lang('msg.welcome_mail.text13')</a>
                                <br>
                            </td>
                        </tr>
                    </table>


                    <!--[if mso]></td></tr></table><![endif]-->

                </td>
            </tr>

            <tr>
                <td class="content-wrapper" align="center" style="padding-left:24px;padding-right:24px;padding-top:24px;">
                    <div><p style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;text-align:center;color:#333333;margin-top:12px">   @lang('msg.mails.footer_1') <a style="color:#333333;text-decoration: none;" href="www.potoroze.com">www.potoroze.com</a><br>
                            <b style="color:#d600c1;font-weight: 300;">@lang('msg.mails.footer_2')</b>
                        </p><br>
                    </div>
                </td>
            </tr>
        </table>

    </td>
</tr>
@include('emails.complements.footer')
