<?php
require_once(__DIR__ . '/../../connection/index.php');
require_once(__DIR__ . '/../mail/PHPMailer.php');

$sqlSelect = mysqli_query($connection, "
    SELECT * FROM postulantes AS p 
    INNER JOIN experiencia_laboral AS EXP ON p.id = EXP.postulante_id 
    ORDER BY p.id DESC 
    LIMIT 1
");

while ($date = mysqli_fetch_array($sqlSelect)) {
    $nombre = $date['nombre'];
    $cargo = $date['cargo'];
    $telefono = $date['telefono'];
    $cvPath = $date['cv_path'];
    $cartaPath = $date['carta_path'];
}

$subject = "Postulación - Talent Expat ";
$mail->addAddress('bjimenez@overall.com.co');

$mail->addAttachment($cvPath, 'CV.pdf');
$mail->addAttachment($cartaPath, 'Carta.pdf');

$mail->Subject = $subject;
$mail->Body = '
       <!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:box-shadow="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="background-color:#eee;">
    <div
        style="background-color:#eee;margin:0;padding:0;font-family:Roboto,Arial,sans-serif;font-weight:500;color:#F0F0F0;font-size:16px;">
        <p>&nbsp;</p>
        <table style="width: 100%; border-collapse: collapse;" border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr style="font-size: 14px; color:#545f75">
                    <td>&nbsp;</td>
                    <td style="width: 600px;">
                        <table style="width: 100%; border-collapse: collapse;background-color: #fff;" border="0"
                            cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div style="padding: 30px 0; text-align: center;background-color:#1e5fa4;">
                                            <div><img src="https://i.imgur.com/IA6URai.png" alt="SVGator" width="140"
                                                    height="35" /></div>
                                        </div>
                                        <div style="line-height: 150%;">
                                            <div style="padding: 60px 50px;">
                                                <p style="margin: 20px 0;">Estimado equipo de Talent Expat,</p>
                                                <p style="margin: 20px 0;">
                                                    Mi nombre es ' . $nombre . ' y estoy interesado(a) en formar parte de las oportunidades internacionales que manejan desde Overall.
                                                </p>
                                                <p style="margin: 20px 0;">
                                                  Adjunto mi hoja de vida para que sea tenida en cuenta en procesos que se ajusten a mi perfil. 
                                                </p>
                                                <p style="margin: 20px 0;">
                                                  Agradezco su atención y quedo atento(a) a cualquier novedad.
                                                </p>
                                                <p style="margin: 20px 0;">
                                                    Cordialmente,
                                                </p>
                                                <ul>
                                                    <li><b>Nombre completo: </b>' . $nombre . '</li>
                                                    <li><b>Profesión: </b>' . $cargo . '</li>
                                                    <li><b>Teléfono: </b>' . $telefono . '</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr style="color: white; text-align: center;">
                    <td>&nbsp;</td>
                    <td style="">
                        <div style="color: #172032; line-height: 1.5; margin: 25px 0; font-size: 14px;">&copy; 2025
                            Corporativo Overall. All rights reserved.<br /></div>
                    </td>
                    <td>&nbsp;</td>
                </tr>

            </tbody>
        </table>
    </div>
</body>

</html>';

if ($mail->send()) {
    response('success', "Postulación registrada correctamente. Experiencia: $expCount, Educación: $eduCount.", 'success');
} else {
    response('error', 'La postulación se registró, pero no se pudo enviar el correo.', 'warning');
}
