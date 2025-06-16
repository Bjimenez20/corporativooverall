<?php
include_once('../../connection/index.php');
require_once('../mail/PHPMailer.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = $_POST['full_name'];
    $position = $_POST['position'];
    $company = $_POST['company'];
    $business_sector = $_POST['business_sector'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $unidad = $_POST['unidad'];
    $message = $_POST['message'];

    $sql = "INSERT INTO `contacts` (`full_name`, `position`, `company`, `business_sector`, `email`, `country`, `unidad`, `message`) VALUES ('$full_name', '$position', '$company', '$business_sector', '$email', '$country', '$unidad', '$message')";

    $query = mysqli_query($connection, $sql);

    if ($query) {
        $sqlSelect = mysqli_query($connection, "SELECT * FROM contacts ORDER BY id DESC LIMIT 1");

        while ($date = mysqli_fetch_array($sqlSelect)) {
            $full_name = $date['full_name'];
            $position = $date['position'];
            $company = $date['company'];
            $business_sector = $date['business_sector'];
            $email = $date['email'];
            $country = $date['country'];
            $unidad = $date['unidad'];
            $message = $date['message'];
        }

        $subject = "Estrategias de Trade Marketing";
        $mail->addAddress('bjimenez@overall.com.co');

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
                                                <p style="margin: 20px 0;">Buen día,</p>
                                                <p style="margin: 20px 0;">
                                                    Estoy evaluando nuevas estrategias de trade marketing para fortalecer nuestra presencia en canal moderno y tradicional.
                                                </p>
                                                <p style="margin: 20px 0;">
                                                   Agradezco si pueden compartir detalles sobre su enfoque, cobertura y casos aplicables.
                                                </p>
                                                <p style="margin: 20px 0;">
                                                    Saludos,
                                                </p>
                                                <ul>
                                                    <li><b>Nombre completo: </b>' . $full_name . '</li>
                                                    <li><b>Empresa: </b>' . $company . '</li>
                                                    <li><b>Teléfono: </b>' . $phone . '</li>
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

        $mail->send();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
