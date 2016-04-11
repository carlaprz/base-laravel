@include('emails.complements.header')
<tr>
    <td class="content" align="left" style="padding-top:12px;padding-bottom:12px;background-color:#ffffff;border:1px solid #EEEEEE;border-radius:5px;">

        <table width="600" border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 600px;">
            <tr>
                <td class="content-wrapper" align="center" style="padding-left:24px;padding-right:24px;padding-top:24px;">
                    <a class="padding logo" href="{{route('home')}}" target="_blank"><img style="margin-bottom:20px;" class="logo" src="{{ asset('front/images/mail/logo.png') }}" alt="Potoroze" /></a>
                    <br><br>
                    <div class="title" style="font-family: Helvetica, Arial, sans-serif;font-size: 33px;font-weight: lighter; color: #374550;">@lang('msg.mdp_mail.title')</div>
                    <br><br>
                    <div><p style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;text-align:left;color:#333333;margin-top:12px">@lang('msg.mails.welcome') {{ $data['name'] }},<br>
                            @lang('msg.mdp_mail.text1')<br><br>
                            @lang('msg.mdp_mail.text2')<br><br>
                            <a href="{{route('passwordRecovery.edit',['hash' => $data['hash'] ])}}" alt="réinitialisation" style="color: #d600c1;"> {{route('passwordRecovery.edit',['hash' => $data['hash'] ])}}</a><br><br>@lang('msg.mdp_mail.text3')<br><br>
                            @lang('msg.mails.footer_3') www.potoroze.com
                        </p><br>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="content-wrapper" align="center" style="padding-left:24px;padding-right:24px;padding-top:24px;">
                    <div>
                        <p style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;text-align:center;color:#333333;margin-top:12px;text-align: right;">
                            <b style="color:#d600c1;font-weight: 300;">L’équipe Potoroze</b>
                        </p><br>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@include('emails.complements.footer')
