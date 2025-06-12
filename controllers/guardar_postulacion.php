<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ob_start();
header('Content-Type: application/json');
include_once('./../connection/index.php');

if ($connection->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión']);
    exit;
}

$nombre = $_POST['nombre'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$correo = $_POST['correo'] ?? '';
$fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
$nacionalidad = $_POST['nacionalidad'] ?? '';
$sitio_web = $_POST['sitio_web'] ?? '';
$estado_civil = $_POST['estado_civil'] ?? '';
$habilidades = $_POST['habilidades'] ?? '';
$otros = $_POST['otros'] ?? '';

// Manejar archivos
$cvPath = '';
$cartaPath = '';
$uploadDir = './../uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir);

if (isset($_FILES['cv'])) {
    $cvPath = $uploadDir . basename($_FILES['cv']['name']);
    move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);
}

if (isset($_FILES['carta'])) {
    $cartaPath = $uploadDir . basename($_FILES['carta']['name']);
    move_uploaded_file($_FILES['carta']['tmp_name'], $cartaPath);
}

// Insertar postulante
$stmt = $connection->prepare("INSERT INTO postulantes 
(nombre, direccion, telefono, correo, fecha_nacimiento, nacionalidad, sitio_web, estado_civil, habilidades, otros, cv_path, carta_path)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode(['error' => 'Prepare failed: ' . $connection->error]);
    exit;
}

$stmt->bind_param("ssssssssssss", $nombre, $direccion, $telefono, $correo, $fecha_nacimiento, $nacionalidad, $sitio_web, $estado_civil, $habilidades, $otros, $cvPath, $cartaPath);

if (!$stmt->execute()) {
    echo json_encode(['error' => 'Execute failed: ' . $stmt->error]);
    $stmt->close();
    exit;
}

$stmt->execute();
$postulante_id = $stmt->insert_id;
$stmt->close();

// Insertar experiencia
$experiencia = json_decode($_POST['experiencia'], true);
if ($experiencia) {
    $stmt = $connection->prepare("INSERT INTO experiencia_laboral (postulante_id, empresa, puesto, fecha_inicio, fecha_fin, descripcion) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($experiencia as $exp) {
        $stmt->bind_param("isssss", $postulante_id, $exp['empresa'], $exp['puesto'], $exp['inicio'], $exp['fin'], $exp['descripcion']);
        $stmt->execute();
    }
    $stmt->close();
}

// Insertar educación
$educacion = json_decode($_POST['educacion'], true);
if ($educacion) {
    $stmt = $connection->prepare("INSERT INTO educacion (postulante_id, institucion, titulo, fecha_inicio, fecha_fin, notas) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($educacion as $edu) {
        $stmt->bind_param("isssss", $postulante_id, $edu['institucion'], $edu['titulo'], $edu['inicio'], $edu['fin'], $edu['notas']);
        $stmt->execute();
    }
    $stmt->close();
}

$connection->close();
ob_end_clean(); // Borra cualquier salida inesperada antes de enviar JSON
echo json_encode(['success' => true]);
exit;
