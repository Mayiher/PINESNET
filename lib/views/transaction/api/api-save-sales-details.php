<?php
// transaction/api/api-save-sales-details.php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'].'/config/server.php';

try {
    $in = json_decode(file_get_contents('php://input'), true) ?: [];
    // Campos obligatorios
    foreach (['id_venta','codigo_producto','descripcion','cantidad','precio_unitario','bruto','porcentaje_iva','iva','total'] as $f) {
        if (!isset($in[$f])) {
            http_response_code(400);
            exit(json_encode(['error'=>"Falta campo $f"]));
        }
    }
    // Insertar detalle
    $st = $conexion->prepare("
      INSERT INTO sales_details
        (id_venta, codigo_producto, descripcion, cantidad, precio_unitario, bruto, porcentaje_iva, iva, total)
      VALUES (?,?,?,?,?,?,?,?,?)
    ");
    $st->bind_param(
      'issiiiiii',
      $in['id_venta'],
      $in['codigo_producto'],
      $in['descripcion'],
      $in['cantidad'],
      $in['precio_unitario'],
      $in['bruto'],
      $in['porcentaje_iva'],
      $in['iva'],
      $in['total']
    );
    if (!$st->execute()) {
        http_response_code(500);
        throw new Exception($st->error);
    }
    echo json_encode(['id_detalle' => $conexion->insert_id]);
    $st->close();
} catch (Exception $e) {
    http_response_code($e->getCode()?:500);
    echo json_encode(['error' => $e->getMessage()]);
}
$conexion->close();
