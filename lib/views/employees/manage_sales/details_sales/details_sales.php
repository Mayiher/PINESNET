<?php
require '../../../../shared/header/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../../../../shared/header/header.css">
    <link rel="stylesheet" href="details_sales.css">
    <title>Detalles de la Venta</title>
</head>
<body>

<?php
// Verificar si el usuario está autenticado y tiene el rol adecuado
if (!isset($_SESSION['admin']) || $_SESSION['admin']['rol'] != 'Administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

// Obtener el ID de la venta de la URL
$id_venta = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Si no hay ID o no es válido, redirigir a la lista de ventas
if ($id_venta <= 0) {
    echo '<script>window.location.href="lista_ventas.php";</script>';
    exit;
}

// Consultar los detalles básicos de la venta
$SQL = "SELECT * FROM sales WHERE id = $id_venta";
$dato = mysqli_query($conexion, $SQL);

if ($dato && $dato->num_rows > 0) {
    $venta = mysqli_fetch_assoc($dato);
} else {
    echo '<script>alert("Venta no encontrada.");</script>';
    echo '<script>window.location.href="lista_ventas.php";</script>';
    exit;
}

// Consultar los detalles de los productos vendidos en esta venta
$SQL_items = "SELECT sd.codigo_principal, sd.descripcion, sd.cantidad, sd.precio_unitario, sd.bruto, sd.porcentaje_iva, sd.iva, sd.total 
              FROM sales_details sd
              WHERE sd.venta_id = $id_venta";
$dato_items = mysqli_query($conexion, $SQL_items);
?>

<div class="container is-fluid">
    <div class="col-xs-12">
        <h1>Detalles de la Venta</h1>
        <br>

        <!-- Mostrar los detalles básicos de la venta -->
        <div class="sale-details">
            <p><strong>ID de Venta:</strong> <?php echo htmlspecialchars($venta['id']); ?></p>
            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($venta['fecha']); ?></p>
            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($venta['cliente']); ?></p>
            <p><strong>Total:</strong> <?php echo number_format($venta['total'], 0, ',', '.'); ?> COP</p>
        </div>

        <br>

        <!-- Mostrar los productos vendidos -->
        <h3>Productos Vendidos</h3>
        <?php if ($dato_items && $dato_items->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Precio Bruto</th>
                        <th>IVA (%)</th>
                        <th>IVA (COP)</th>
                        <th>Total (COP)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($dato_items)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['codigo_principal']); ?></td>
                            <td><?php echo htmlspecialchars($item['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                            <td><?php echo number_format($item['precio_unitario'], 0, ',', '.'); ?> COP</td>
                            <td><?php echo number_format($item['bruto'], 0, ',', '.'); ?> COP</td>
                            <td><?php echo htmlspecialchars($item['porcentaje_iva']); ?>%</td>
                            <td><?php echo number_format($item['iva'], 0, ',', '.'); ?> COP</td>
                            <td><?php echo number_format($item['total'], 0, ',', '.'); ?> COP</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay productos asociados a esta venta.</p>
        <?php endif; ?>

        <br>

        <!-- Enlace para volver a la lista de ventas -->
        <div>
            <a href="../../manage_sales.php" class="btn btn-primary">Volver a la lista de ventas</a>
        </div>
    </div>
</div>

</body>
</html>
