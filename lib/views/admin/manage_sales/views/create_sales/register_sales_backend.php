<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php'; // Mantener la configuración del servidor

// Verificación de acceso solo para administradores
if (!isset($_SESSION['admin']) || $_SESSION['admin']['rol'] != 'Administrador') {
    // Redirigir con mensaje de acceso restringido
    header("Location: confirm_sale.php?alert=Acceso restringido. Solo los administradores pueden acceder a esta página.&alert_type=error");
    exit;
}

// Obtener los datos de los productos y total de la venta
$productos = json_decode($_POST['productos'], true);
$totalVenta = $_POST['totalVenta'];

// Obtener la identificación del usuario (cliente) desde el primer producto
$idUsuario = $productos[0]['clienteIdentificacion'];  // Asumimos que todos los productos son del mismo cliente

// Obtener el subtotal, IVA total y el total con IVA
$subtotal = 0;
$totalIva = 0;

foreach ($productos as $producto) {
    $subtotal += $producto['totalProducto'];  // Suma de los totales de los productos (sin IVA)
    $totalIva += $producto['totalConIva'] - $producto['totalProducto'];  // Suma de los valores de IVA
}

// Insertar la venta en la tabla `sales`
$sqlVenta = "INSERT INTO sales (id_usuario, subtotal, total_iva, total) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sqlVenta);
$stmt->execute([$idUsuario, $subtotal, $totalIva, $totalVenta]);

// Obtener el ID de la venta recién insertada
$idVenta = $pdo->lastInsertId();

// Insertar los detalles de los productos en la tabla `sales_details`
foreach ($productos as $producto) {
    $codigoProducto = $producto['productoCodigo'];
    $descripcion = $producto['productoDescripcion'];
    $cantidad = $producto['cantidad'];
    $precioUnitario = $producto['precioUnitario'];
    $bruto = $producto['totalProducto'];  // Total sin IVA
    $porcentajeIva = 19;  // Asumimos un 19% de IVA
    $iva = $producto['totalConIva'] - $producto['totalProducto'];  // IVA del producto
    $totalProducto = $producto['totalConIva'];  // Total con IVA

    $sqlDetalle = "INSERT INTO sales_details (id_venta, codigo_producto, descripcion, cantidad, precio_unitario, bruto, porcentaje_iva, iva, total) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtDetalle = $pdo->prepare($sqlDetalle);
    $stmtDetalle->execute([$idVenta, $codigoProducto, $descripcion, $cantidad, $precioUnitario, $bruto, $porcentajeIva, $iva, $totalProducto]);
}

// Redirigir a confirm_sale.php con el mensaje de éxito
header("Location: confirm_sale.php?alert=Venta registrada con éxito.&alert_type=success");
exit;
?>
