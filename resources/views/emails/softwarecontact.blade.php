<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->
    <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->
    <title>Potoroze | mdp</title>

    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table {
            border-spacing: 0;
        }

        table td {
            border-collapse: collapse;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        .ReadMsgBody {
            width: 100%;
            background-color: #ebebeb;
        }

        table {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        .yshortcuts a {
            border-bottom: none !important;
        }

        @media screen and (max-width: 599px) {
            table[class="force-row"],
            table[class="container"] {
                width: 100% !important;
                max-width: 100% !important;
            }
        }
        @media screen and (max-width: 400px) {
            td[class*="container-padding"] {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
        }
        .ios-footer a {
            color: #aaaaaa !important;
            text-decoration: underline;
        }

        @media screen and (max-width: 599px) {
            td[class="col"] {
                width: 100% !important;
                border-top: 1px solid #eee;
            }

            td[class="cols-wrapper"] {
                padding-top: 18px;
            }

            img[class="image"] {
                float: right;
                max-width: 40% !important;
                height: auto !important;
                margin-left: 12px;
            }

            div[class="subtitle"] {
                margin-top: 0 !important;
            }
        }
        @media screen and (max-width: 400px) {
            td[class="cols-wrapper"] {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            td[class="content-wrapper"] {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
        }
    </style>

</head>
<body style="margin:0; padding:0;" bgcolor="#F0F0F0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!-- 100% background wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
    <tr>
        <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">

            <br>

            <!-- 600px container (white background) -->
            <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px;">
                <tr>
                    <td class="container-padding header" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px">

                    </td>
                </tr>
                <tr style="">
                    <td class="content" align="left" style="padding-top:12px;padding-bottom:12px;background-color:#ffffff;border:1px solid #EEEEEE;border-radius:5px;">
                        <table width="600" border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 600px;">
                            <tr>
                                <td class="content-wrapper" align="center" style="padding-left:24px;padding-right:24px;padding-top:24px;">
                                    <img style="margin-bottom:20px;" class="logo" src="{{ asset('/img/logo.png') }}" alt="HITECSA" />
                                    <br><br>
                                    <div class="title" style="font-family: Helvetica, Arial, sans-serif;font-size: 33px;font-weight: lighter; color: #374550;">Hitecsa.com - Contacto Software</div>
                                    <br><br>
                                    <div style="text-align:left;"><p style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;text-align:left;color:#333333;margin-top:12px">
                <br/>
                 <b>Empresa:</b>  {{$data['empresa']}}<br/>
                 <b>Actividad:</b>  {{$data['actividad']}}<br/>
                 <b>Dirección:</b>  {{$data['direccion']}}<br/>
                 <b>Código Postal:</b>  {{$data['cp']}}<br/>
                 <b>Localidad:</b>  {{$data['localidad']}}<br/>
                 <b>Estado:</b>  {{$data['estado']}}<br/>
                 <b>Provincia:</b>  {{$data['provincia']}}<br/>
                 <b>Nombre:</b>  {{$data['nombre']}}<br/>
                 <b>Apellidos:</b>  {{$data['apellidos']}}<br/>
                 <b>Teléfono Movil:</b><a href="tel:{{$data['telefonomov']}}">{{$data['telefonomov']}}</a><br/>
                 <b>Teléfono Fijo:</b><a href="tel:{{$data['telefonofix']}}">{{$data['telefonofix']}}</a><br/>
                 <b>Email:</b><a href="mailto:{{$data['email']}}">
                                            {{$data['email']}}</a><br/><br/>
                 @if($data['program1'] == 0 && $data['program2'] == 0 && $data['program3'] == 0)
                  <b>El usuario no ha seleccionado ningun software del formulario</b>
                     @else
                    <b>Programas que quiere descargar:</b>
                @endif
                @if($data['program1'] != 0)
                    <b>WINCLIM II<br/></b>
                @endif
                @if($data['program2'] != 0)
                    <b>WINCLIM III<br/></b>
                @endif
                @if($data['program3'] != 0)
                    <b>eCLIM<br/></b>
                @endif
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--/600px container -->
        </td>
    </tr>
</table>
<!--/100% background wrapper-->
</body>
</html>
