<?php
// api/sales_details/api-sales_details.php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'].'/config/server.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conexion->prepare("
      SELECT codigo_producto, descripcion, cantidad, precio_unitario, total
      FROM sales_details
      WHERE id_venta = ?
    ");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
    $stmt->close();
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);
    $stmt = $conexion->prepare("
      INSERT INTO sales_details
        (id_venta,codigo_producto,descripcion,cantidad,precio_unitario,bruto,porcentaje_iva,iva,total)
      VALUES (?,?,?,?,?,?,?,?,?)
    ");
    $stmt->bind_param('issiiiiii',
      $d['id_venta'],$d['codigo_producto'],$d['descripcion'],
      $d['cantidad'],$d['precio_unitario'],$d['bruto'],
      $d['porcentaje_iva'],$d['iva'],$d['total']
    );
    if ($stmt->execute()) {
      echo json_encode(['id_detalle'=>$conexion->insert_id]);
    } else {
      http_response_code(400);
      echo json_encode(['error'=>$stmt->error]);
    }
    $stmt->close();
}
else {
    http_response_code(405);
    echo json_encode(['error'=>'Método no permitido']);
}
$conexion->close();
