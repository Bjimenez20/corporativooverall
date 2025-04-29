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

$mail = new PHPMailer();
$mail->isSMTP();

$mail->Host = $host;
$mail->SMTPAuth = "true";
$mail->SMTPSecure = $encrypt;
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->Port = $port;
$mail->isHTML(true);
$mail->Username = $user;
$mail->Password = $pass;
$mail->setFrom($emailout);
$mail->CharSet = 'UTF-8';