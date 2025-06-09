<?php
// transaction/api/api-save-sales.php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'].'/config/server.php';

try {
    $in = json_decode(file_get_contents('php://input'), true) ?: [];
    // Campos obligatorios
    foreach (['id_usuario','fecha','subtotal','total_iva','descuento','total'] as $f) {
        if (!isset($in[$f])) {
            http_response_code(400);
            exit(json_encode(['error'=>"Falta campo $f"]));
        }
    }
    // Insertar cabecera de venta
    $st = $conexion->prepare("
      INSERT INTO sales
        (id_usuario, fecha, subtotal, total_iva, descuento, total)
      VALUES (?,?,?,?,?,?)
    ");
    $st->bind_param(
      'isiiii',
      $in['id_usuario'],
      $in['fecha'],
      $in['subtotal'],
      $in['total_iva'],
      $in['descuento'],
      $in['total']
    );
    if (!$st->execute()) {
        http_response_code(500);
        throw new Exception($st->error);
    }
    echo json_encode(['id_venta' => $conexion->insert_id]);
    $st->close();
} catch (Exception $e) {
    http_response_code($e->getCode()?:500);
    echo json_encode(['error' => $e->getMessage()]);
}
$conexion->close();
