<?php

// Obtener los datos enviados desde el frontend (en formato JSON)
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si los datos están completos
if (!isset($data['cliente_identificacion']) || !isset($data['productos']) || !isset($data['total'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$clienteIdentificacion = $data['cliente_identificacion'];
$productos = $data['productos'];
$totalVenta = $data['total'];
$fechaVenta = date('Y-m-d H:i:s'); // Obtener la fecha actual para la venta
$subtotal = 0;
$totalIva = 0;

// Generar el SQL para la tabla de ventas
$sql = "";

// Primero, obtener el subtotal y el IVA total
foreach ($productos as $producto) {
    $subtotal += $producto['bruto'];
    $totalIva += $producto['iva'];
}

// Calcular el total después de IVA
$total = $subtotal + $totalIva - $data['descuento']; // Asumiendo que se envía un descuento

// Ejecutar la inserción en la tabla `sales`
$query = "INSERT INTO sales (id_usuario, fecha, subtotal, total_iva, descuento, total) 
          VALUES ('$clienteIdentificacion', '$fechaVenta', $subtotal, $totalIva, 0, $total)";
if (mysqli_query($conn, $query)) {
    $idVenta = mysqli_insert_id($conn); // Obtener el ID de la venta recién insertada

    // Insertar los detalles de los productos en `sales_details`
    foreach ($productos as $producto) {
        $codigoProducto = $producto['producto_codigo'];
        $descripcion = $producto['producto_descripcion'];
        $cantidad = $producto['cantidad'];
        $precioUnitario = $producto['precio_unitario'];
        $bruto = $producto['bruto'];
        $iva = $producto['iva'];
        $totalProducto = $producto['total'];

        $queryDetails = "INSERT INTO sales_details (id_venta, codigo_producto, descripcion, cantidad, precio_unitario, bruto, porcentaje_iva, iva, total) 
                         VALUES ($idVenta, '$codigoProducto', '$descripcion', $cantidad, $precioUnitario, $bruto, 19, $iva, $totalProducto)";
        mysqli_query($conn, $queryDetails);
    }

    echo json_encode(['success' => true, 'message' => 'Venta registrada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar la venta']);
}

?>
