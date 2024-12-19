<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';
require '../../../../shared/header/header.php';

// Verificación de acceso solo para administradores
if (!isset($_SESSION['admin']) || $_SESSION['admin']['rol'] != 'Administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}

if (isset($_POST['productos']) && isset($_POST['totalVenta'])) {
    $productos = json_decode($_POST['productos'], true);
    $totalVenta = $_POST['totalVenta'];
} else {
    echo '<script>alert("Los datos no fueron enviados correctamente. Por favor, inténtalo nuevamente.");</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../../../../shared/header/header.css">
    <link rel="stylesheet" href="../../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../css/es.css">
    <title>Confirmación de Venta</title>
</head>
<body>

<div class="container">
    <h2>Confirmación de Venta</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Identificación Cliente</th>
                    <th>Nombre Cliente</th>
                    <th>Código Producto</th>
                    <th>Descripción Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total Producto</th>
                    <th>IVA</th>
                    <th>Total con IVA</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($productos as $producto) {
                    echo "<tr>
                            <td>{$producto['clienteIdentificacion']}</td>
                            <td>{$producto['clienteNombre']}</td>
                            <td>{$producto['productoCodigo']}</td>
                            <td>{$producto['productoDescripcion']}</td>
                            <td>{$producto['cantidad']}</td>
                            <td>{$producto['precioUnitario']}</td>
                            <td>{$producto['totalProducto']}</td>
                            <td>{$producto['ivaProducto']}</td>
                            <td>{$producto['totalConIva']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Total Venta: $<?php echo number_format($totalVenta, 0, ',', '.'); ?></h3>

        <!-- Formulario para confirmar la venta -->
        <form action="register_sales_backend.php" method="POST">
            <input type="hidden" name="productos" value='<?php echo json_encode($productos); ?>'>
            <input type="hidden" name="totalVenta" value="<?php echo $totalVenta; ?>">

            <!-- Botón para confirmar la venta -->
            <button type="submit" class="btn btn-success">Confirmar Venta</button>
        </form>
    </div>
</div>

</body>
</html>
