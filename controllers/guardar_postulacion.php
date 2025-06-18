<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

include_once('./../connection/index.php');
require_once('./mail/PHPMailer.php');

function response($status, $message, $icon = 'info')
{
    echo json_encode(['status' => $status, 'message' => $message, 'icon' => $icon]);
    exit;
}

// Validar campos personales
$campos = ['nombre', 'direccion', 'telefono', 'correo'];
foreach ($campos as $campo) {
    if (empty($_POST[$campo])) {
        response('error', "El campo $campo es obligatorio.", 'error');
    }
}

// Archivos obligatorios
if (!isset($_FILES['cv'])) {
    response('error', 'Debes adjuntar el CV', 'error');
}

// Crear carpeta de subida
$nombreCarpeta = preg_replace('/[^a-zA-Z0-9_]/', '_', $_POST['nombre']);
$rutaCarpeta = "../uploads/$nombreCarpeta";
if (!is_dir($rutaCarpeta)) mkdir($rutaCarpeta, 0777, true);

// Mover archivos
$cvPath = "$rutaCarpeta/CV.pdf";
$cartaPath = "$rutaCarpeta/Carta.pdf";
move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);
move_uploaded_file($_FILES['carta']['tmp_name'], $cartaPath);

// Insertar postulante
$stmt = $connection->prepare("INSERT INTO postulantes (nombre, direccion, telefono, correo, fecha_nacimiento, nacionalidad, sitio_web, estado_civil, habilidades, otros, cv_path, carta_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssss", $_POST['nombre'], $_POST['direccion'], $_POST['telefono'], $_POST['correo'], $_POST['fecha_nacimiento'], $_POST['nacionalidad'], $_POST['url_redes'], $_POST['estado_civil'], $_POST['habilidades'], $_POST['otros'], $cvPath, $cartaPath);
$stmt->execute();
$postulanteId = $stmt->insert_id;

// Convertir JSON
$experiencia = json_decode($_POST['experiencia_json'], true);
$educacion = json_decode($_POST['educacion_json'], true);

if (!is_array($experiencia)) {
    response('error', 'Error al decodificar experiencia.', 'error');
}
if (!is_array($educacion)) {
    response('error', 'Error al decodificar educación.', 'error');
}

// Insertar experiencia laboral
if (!empty($experiencia)) {
    $stmtExp = $connection->prepare("INSERT INTO experiencia_laboral (postulante_id, empresa, cargo, anio) VALUES (?, ?, ?, ?)");
    foreach ($experiencia as $exp) {
        if (!empty($exp['empresa']) && !empty($exp['cargo']) && !empty($exp['anioexp'])) {
            $stmtExp->bind_param("isss", $postulanteId, $exp['empresa'], $exp['cargo'], $exp['anioexp']);
            $stmtExp->execute();
        }
    }
}

// Insertar educación
if (!empty($educacion)) {
    $stmtEdu = $connection->prepare("INSERT INTO educacion (postulante_id, institucion, titulo, anio) VALUES (?, ?, ?, ?)");
    foreach ($educacion as $edu) {
        if (!empty($edu['institucion']) && !empty($edu['titulo']) && !empty($edu['anioedu'])) {
            $stmtEdu->bind_param("isss", $postulanteId, $edu['institucion'], $edu['titulo'], $edu['anioedu']);
            $stmtEdu->execute();
        }
    }
}

$eduCount = count($educacion);
$expCount = count($experiencia);

// ---------------------------
// Enviar correo
// ---------------------------
$mail = new PHPMailer\PHPMailer\PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'contactenos@overall.com.co';
    $mail->Password = 'Overall20-25**';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('contactenos@overall.com.co');
    $mail->CharSet = 'UTF-8';

    $sqlSelect = mysqli_query($connection, "
        SELECT * FROM postulantes AS p 
        INNER JOIN experiencia_laboral AS exp ON p.id = exp.postulante_id 
        WHERE p.id = $postulanteId
        LIMIT 1
    ");

    $data = mysqli_fetch_assoc($sqlSelect);
    if (!$data) {
        response('error', 'Error al recuperar datos del postulante para el correo.', 'error');
    }

    $nombre = $data['nombre'];
    $cargo = $data['cargo'];
    $telefono = $data['telefono'];

    $mail->addAddress('bjimenez@overall.com.co');
    $mail->addAttachment($cvPath, 'CV.pdf');
    $mail->addAttachment($cartaPath, 'Carta.pdf');
    $mail->isHTML(true);
    $mail->Subject = "Postulación - Talent Expat";
    $mail->Body = '
        <html>
        <body style="background-color:#eee;font-family:Roboto,Arial,sans-serif;font-size:16px;color:#333;">
            <div style="max-width:600px;margin:auto;background:#fff;padding:30px;border-radius:8px;">
                <div style="text-align:center;background:#1e5fa4;padding:15px 0;">
                    <img src="https://i.imgur.com/IA6URai.png" width="140" height="35" />
                </div>
                <p>Estimado equipo de Talent Expat,</p>
                <p>Mi nombre es <strong>' . $nombre . '</strong> y estoy interesado(a) en formar parte de las oportunidades internacionales que manejan desde Overall.</p>
                <p>Adjunto mi hoja de vida para que sea tenida en cuenta en procesos que se ajusten a mi perfil.</p>
                <p>Agradezco su atención y quedo atento(a) a cualquier novedad.</p>
                <p>Cordialmente,</p>
                <ul>
                    <li><b>Nombre completo: </b>' . $nombre . '</li>
                    <li><b>Profesión: </b>' . $cargo . '</li>
                    <li><b>Teléfono: </b>' . $telefono . '</li>
                </ul>
                <div style="text-align:center;color:#aaa;font-size:12px;margin-top:30px;">
                    &copy; 2025 Corporativo Overall. Todos los derechos reservados.
                </div>
            </div>
        </body>
        </html>';

    $mail->send();

    response('success', "Postulación registrada correctamente. Experiencia: $expCount, Educación: $eduCount.", 'success');
} catch (Exception $e) {
    response('error', 'Postulación registrada, pero error al enviar el correo: ' . $mail->ErrorInfo, 'warning');
}
