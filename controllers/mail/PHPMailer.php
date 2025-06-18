<?php

// VARIABLES DE ENTORNO
include_once('components/env.php');

// INCLUIR ARCHIVOS DE PHP MAILER
require 'components/PHPMailer.php';
require 'components/Exception.php';
require 'components/SMTP.php';

// DEFINIR USOS
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// INSTANCIAR MAILER
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = $host;
$mail->SMTPAuth = true;
$mail->Username = $user;
$mail->Password = $pass;
$mail->SMTPSecure = $encrypt;
$mail->Port = $port;
$mail->isHTML(true);
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

// 🚨 ESTABLECER CORRECTAMENTE LA CODIFICACIÓN
$mail->CharSet = 'UTF-8';        // Asegura codificación correcta
$mail->Encoding = 'base64';      // Recomendado para caracteres especiales

$mail->setFrom($emailout);
