<?php

class Mail {

    static function sendMail($destino) {
        $origen = "mimsoft.signup@gmail.com";
        $alias = "MIM Support";
        $asunto = "Alta Usuario";
        $destino = $destino;
        $sha1 = sha1($destino . Constantes::SEMILLA);
        $enlace = 'https://proyecto-notas-montselop.c9users.io/proyecto_notas/index.php?ruta=usuario2&accion=doactivar&email=' . $destino .
                '&iduser=' . $sha1;
        $mensaje = "Saludos Usuario. Para completar su registro y disfrutar de las funcionalidades de mimsoft pulse el siguiente enlace:" . $enlace;
        require_once 'correo/vendor/autoload.php';
        $cliente = new Google_Client();
        $cliente->setApplicationName('ProyectoEnviarCorreo');
        $cliente->setClientId('560186546771-akj46h6qmp75q4ekvii217km0j4gfhcb.apps.googleusercontent.com');
        $cliente->setClientSecret('iuicRUOf_HVh34_3nNzFk-Ov');
        $cliente->setRedirectUri('https://proyecto-notas-montselop.c9users.io/proyecto_notas/correo/guardar.php');
        $cliente->setScopes('https://www.googleapis.com/auth/gmail.compose');
        $cliente->setAccessToken(file_get_contents('correo/token.conf'));
        if ($cliente->getAccessToken()) {
            $service = new Google_Service_Gmail($cliente);
            try {
                $mail = new PHPMailer();
                $mail->CharSet = "UTF-8";
                $mail->From = $origen;        
                $mail->FromName = $alias;      
                $mail->AddAddress($destino);    
                $mail->AddReplyTo($origen, $alias);
                $mail->Subject = $asunto;     
                $mail->Body = $mensaje;      
                $mail->preSend();
                $mime = $mail->getSentMIMEMessage();
                $mime = rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');
                $mensaje = new Google_Service_Gmail_Message();
                $mensaje->setRaw($mime);
                $r = $service->users_messages->send('me', $mensaje);
                //echo "se ha enviado";
            } catch (Exception $e) {
                print("Error en el envío de correo" . $e->getMessage());
            }
        } else {
            echo "no conectado con gmail";
        }
        return $r["labelIds"][0];
    }

}