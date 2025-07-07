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

$campos = ['nombre', 'direccion', 'telefono', 'correo', 'fecha_nacimiento', 'roles'];
foreach ($campos as $campo) {
    if (empty($_POST[$campo])) {
        response('error', "El campo $campo es obligatorio.", 'error');
    }
}

$nombreCarpeta = preg_replace('/[^a-zA-Z0-9_]/', '_', $_POST['nombre']);
$rutaCarpeta = "../uploads/$nombreCarpeta";
if (!is_dir($rutaCarpeta)) mkdir($rutaCarpeta, 0777, true);

$maxFileSize = 5 * 1024 * 1024; // 5MB

$cvPaths = [];
if (!isset($_FILES['cv'])) {
    response('error', 'Debes adjuntar al menos un archivo de CV.', 'error');
}
foreach ($_FILES['cv']['tmp_name'] as $index => $tmpName) {
    if ($_FILES['cv']['error'][$index] === UPLOAD_ERR_OK) {
        if ($_FILES['cv']['size'][$index] > $maxFileSize) {
            response('error', 'Uno de los archivos del CV supera los 5MB.', 'error');
        }

        $mime = mime_content_type($tmpName);
        if ($mime !== 'application/pdf') {
            response('error', 'Todos los archivos del CV deben ser PDF.', 'error');
        }

        $originalName = basename($_FILES['cv']['name'][$index]);
        $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $uniqueName = $safeName . '_' . time() . "_$index." . $extension;
        $filePath = "$rutaCarpeta/$uniqueName";

        if (move_uploaded_file($tmpName, $filePath)) {
            $cvPaths[] = $filePath;
        }
    }
}

$otrosPaths = [];
if (isset($_FILES['otros'])) {
    foreach ($_FILES['otros']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['otros']['error'][$index] === UPLOAD_ERR_OK) {
            if ($_FILES['otros']['size'][$index] > $maxFileSize) {
                response('error', 'Uno de los archivos en "Otros" supera los 5MB.', 'error');
            }

            $mime = mime_content_type($tmpName);
            if ($mime !== 'application/pdf') {
                response('error', 'Todos los archivos en "Otros" deben ser PDF.', 'error');
            }

            $originalName = basename($_FILES['otros']['name'][$index]);
            $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $uniqueName = $safeName . '_' . time() . "_$index." . $extension;
            $filePath = "$rutaCarpeta/$uniqueName";

            if (move_uploaded_file($tmpName, $filePath)) {
                $otrosPaths[] = $filePath;
            }
        }
    }
}

// Guardar postulante
$stmt = $connection->prepare("
    INSERT INTO postulantes 
    (nombre, direccion, telefono, correo, fecha_nacimiento, nacionalidad, sitio_web, estado_civil, habilidades, otros, perfil_cargo, cv_path, otros_path) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$cvPathsJson = json_encode($cvPaths);
$otrosPathsJson = json_encode($otrosPaths);
$stmt->bind_param(
    "sssssssssssss",
    $_POST['nombre'],
    $_POST['direccion'],
    $_POST['telefono'],
    $_POST['correo'],
    $_POST['fecha_nacimiento'],
    $_POST['nacionalidad'],
    $_POST['url_redes'],
    $_POST['estado_civil'],
    $_POST['habilidades'],
    $_POST['otros'],
    $_POST['roles'],
    $cvPathsJson,
    $otrosPathsJson
);
$stmt->execute();
$postulanteId = $stmt->insert_id;

// Guardar experiencia
$experiencia = json_decode($_POST['experiencia_json'], true);
if (!is_array($experiencia)) {
    response('error', 'Error al decodificar experiencia.', 'error');
}
if (!empty($experiencia)) {
    $stmtExp = $connection->prepare("INSERT INTO experiencia_laboral (postulante_id, empresa, cargo, anio) VALUES (?, ?, ?, ?)");
    foreach ($experiencia as $exp) {
        if (!empty($exp['empresa']) && !empty($exp['cargo']) && !empty($exp['anioexp'])) {
            $stmtExp->bind_param("isss", $postulanteId, $exp['empresa'], $exp['cargo'], $exp['anioexp']);
            $stmtExp->execute();
        }
    }
}

// Guardar educación
$educacion = json_decode($_POST['educacion_json'], true);
if (!is_array($educacion)) {
    response('error', 'Error al decodificar educación.', 'error');
}
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

// Enviar correo
$mail = new PHPMailer\PHPMailer\PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'contactenos@overall.com.co';
    $mail->Password = '0vera1120-25*-*';
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
    $cargo = $data['perfil_cargo'];
    $telefono = $data['telefono'];

    $mail->addAddress('bjimenez@overall.com.co');

    // Adjuntar archivos
    foreach ($cvPaths as $cvFile) {
        $mail->addAttachment($cvFile);
    }
    foreach ($otrosPaths as $otroFile) {
        $mail->addAttachment($otroFile);
    }

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
