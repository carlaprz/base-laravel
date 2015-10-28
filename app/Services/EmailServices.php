<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailService
{

    private function sendEmail( $from, $to, $subject, $view, $data )
    {
        Mail::send($view, $data, function ($message) use($from, $to, $subject) {
            $message->from('pau.garcia@thatzad.com');
            $message->to($to);
            $message->subject($subject);
        });
    }

    public function contactEmail($name, $surname ,$from, $province, $message, $phone)
    {
        $subject = 'Hitecsa.com - Contacto';
        $to = 'info@hitecsa.com';
        $view = 'emails.contact';
        $data =  ['data' => ['name' => $name , 'surname' => $surname, 'province' => $province , 'message' => $message , 'phone' => $phone, 'from' => $from]];
        $this->sendEmail($from, $to, $subject, $view, $data);
    }

    public function contactSchool($empresarazon, $empresatelefono, $empresafax,
                    $empresadireccion, $empresacp, $empresalocalidad, $modulosgen,
        $modulostec, $comentario, $solicitantenombre, $solicitanteactiv, $number,
        $solicitantedireccion, $solicitantecp, $solicitantelocalidad,
        $solicitantetelefono, $solicitanteemail)
    {
        $subject = 'Hitecsa.com - Escuela Hitecsa Inscripcción';
        $to = 'pere.chacon@hitecsa.com';
        $view = 'emails.schoolcontact';
        $data =  ['data' =>
                      ['empresarazon' => $empresarazon ,
                       'empresatelefono' => $empresatelefono,
                       'empresafax' => $empresafax ,
                       'empresadireccion' => $empresadireccion ,
                       'empresacp' => $empresacp,
                       'empresalocalidad' => $empresalocalidad,
                       'modulosgen' => $modulosgen,
                       'modulostec' => $modulostec,
                       'comentario' => $comentario,
                       'solicitantenombre' => $solicitantenombre,
                       'solicitanteactiv' => $solicitanteactiv,
                       'number' => $number,
                       'solicitantedireccion' => $solicitantedireccion,
                       'solicitantecp' => $solicitantecp,
                       'solicitantelocalidad' => $solicitantelocalidad,
                       'solicitantetelefono' => $solicitantetelefono,
                       'solicitanteemail' => $solicitanteemail
                      ]
                ];
        $this->sendEmail($solicitanteemail, $to, $subject, $view, $data);
    }

    public function contactSat($numerocliente, $companya,$personacontacto,                 $telefonocont,$direccion,$localidad, $modelouni, $serienum,
        $zona, $voltage, $fecha, $facturanumero, $opcionales, $mensaje,
        $solicitante){

        $subject = 'Hitecsa.com - Petición Servicio Técnico';
        $to = 'josep.farre@hitecsa.com';
        $view = 'emails.satcontact';
        $data =  ['data' =>
                      ['numerocliente' => $numerocliente,
                       'companya' => $companya,
                       'personacontacto' => $personacontacto,
                       'telefonocont' => $telefonocont,
                       'direccion' => $direccion,
                       'localidad' => $localidad,
                       'modelouni' => $modelouni,
                       'serienum' => $serienum,
                       'zona' => $zona,
                       'voltage' => $voltage,
                       'fecha' => $fecha,
                       'facturanumero' => $facturanumero,
                       'opcionales' => $opcionales,
                       'mensaje' => $mensaje,
                       'solicitante' => $solicitante
                      ]
        ];
        $this->sendEmail($solicitante, $to, $subject, $view, $data);
    }

    public function contactSoftware($empresa, $actividad, $direccion, $cp, $localidad, $estado, $provincia, $nombre, $apellidos, $telefonomov, $telefonofix,$email,  $program1, $program2,$program3){
        $subject = 'Hitecsa.com - Contacto Software';
        $to = 'info@hitecsa.com';
        $view = 'emails.softwarecontact';
        $data =  ['data' =>
              ['empresa' => $empresa,
               'actividad' => $actividad,
               'direccion' => $direccion,
               'cp' => $cp,
               'localidad' => $localidad,
               'estado' => $estado,
               'provincia' => $provincia,
               'nombre' => $nombre,
               'apellidos' => $apellidos,
               'telefonomov' => $telefonomov,
               'telefonofix' => $telefonofix,
               'email' => $email,
               'program1' => $program1,
               'program2' => $program2,
               'program3' => $program3
              ]
        ];
        $this->sendEmail($email, $to, $subject, $view, $data);
    }





}

