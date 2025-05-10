<?php
// includes/ajax/get_client.php

// 1) Incluir la conexión MySQLi
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

// 2) Forzar respuesta JSON
header('Content-Type: application/json; charset=utf-8');

// 3) Verificar que recibimos el parámetro
if (!isset($_GET['identificacion'])) {
    echo json_encode([
        'success' => false,
        'error'   => 'Falta el parámetro de identificación.'
    ]);
    exit;
}

$identificacion = trim($_GET['identificacion']);
if ($identificacion === '') {
    echo json_encode([
        'success' => false,
        'error'   => 'La identificación está vacía.'
    ]);
    exit;
}

// 4) Preparar la consulta
$sql = "SELECT nombre, apellido FROM users WHERE identificacion = ?";
if (! $stmt = $conexion->prepare($sql)) {
    echo json_encode([
        'success' => false,
        'error'   => 'Error en la preparación de la consulta: ' . $conexion->error
    ]);
    exit;
}

// 5) Enlazar y ejecutar
$stmt->bind_param('s', $identificacion);
if (! $stmt->execute()) {
    echo json_encode([
        'success' => false,
        'error'   => 'Error al ejecutar la consulta: ' . $stmt->error
    ]);
    $stmt->close();
    exit;
}

// 6) Obtener resultado
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'success'         => true,
        'nombre_completo' => $row['nombre'] . ' ' . $row['apellido']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error'   => 'Cliente no encontrado.'
    ]);
}

$stmt->close();
$conexion->close();
