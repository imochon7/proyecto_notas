<?php
session_start();
require_once 'vendor/autoload.php';
$cliente = new Google_Client();
$cliente->setApplicationName('ProyectoEnviarCorreo');
$cliente->setClientId('560186546771-akj46h6qmp75q4ekvii217km0j4gfhcb.apps.googleusercontent.com');
$cliente->setClientSecret('iuicRUOf_HVh34_3nNzFk-Ov');
$cliente->setRedirectUri('https://proyecto-notas-montselop.c9users.io/proyecto_notas/correo/guardar.php');
$cliente->setScopes('https://www.googleapis.com/auth/gmail.compose');
$cliente->setAccessType('offline');
if (isset($_GET['code'])) {
   $cliente->authenticate($_GET['code']);
   $_SESSION['token'] = $cliente->getAccessToken();
   $archivo = "token.conf";
   $fh = fopen($archivo, 'w') or die("error");
   fwrite($fh, json_encode($cliente->getAccessToken()));
   fclose($fh);
}
