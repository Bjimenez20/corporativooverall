<?php
function guardarPostulante($conn, $nombre, $direccion, $telefono, $correo, $cvPath, $cartaPath) {
    $stmt = $conn->prepare("INSERT INTO postulantes (nombre, direccion, telefono, correo, cv, carta) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $direccion, $telefono, $correo, $cvPath, $cartaPath);
    $stmt->execute();
    return $conn->insert_id;
}

function guardarExperiencia($conn, $postulante_id, $empresa, $cargo, $duracion) {
    $stmt = $conn->prepare("INSERT INTO experiencia_laboral (postulante_id, empresa, cargo, duracion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $postulante_id, $empresa, $cargo, $duracion);
    $stmt->execute();
}

function guardarEducacion($conn, $postulante_id, $institucion, $titulo, $anio) {
    $stmt = $conn->prepare("INSERT INTO educacion (postulante_id, institucion, titulo, anio) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $postulante_id, $institucion, $titulo, $anio);
    $stmt->execute();
}
?>
