<?php

require '../../shared/header/header.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin']['rol'] != 'Administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

// Asegúrate de que la conexión esté activa
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../../shared/header/header.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Lista de Ventas</title>
</head>
<body>
<div class="container is-fluid">
    <div class="col-xs-12">
        <h1>Bienvenido Administrador <?php echo htmlspecialchars($nombre) . ' ' . htmlspecialchars($apellido); ?></h1>
        <br>
        <h1>Lista de ventas</h1>
        <br>
        <div>
            <a class="btn-success" href="views/create_sales/create_sales.php">
                <img src="/assets/images/agregar.png" alt="Nueva venta" style="width: 25px; height: 25px;">
                Nueva venta
            </a>
        </div>
        <br><br>
        <div class="table-container">
            <table class="table table-striped table-dark" id="table_id">
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>Identificación Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                // Consulta para obtener ventas y la identificación del cliente
                $SQL = "SELECT s.id_venta, s.id_usuario, s.fecha, u.nombre, u.apellido, s.total 
                        FROM sales s
                        JOIN users u ON s.id_usuario = u.identificacion";
                $dato = mysqli_query($conexion, $SQL);

                if ($dato && mysqli_num_rows($dato) > 0) {
                    while ($fila = mysqli_fetch_assoc($dato)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['id_venta']); ?></td>
                            <td><?php echo htmlspecialchars($fila['id_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                            <td><?php echo number_format($fila['total'], 0, ',', '.'); ?></td>
                            <td>
                                <div class="action-button">
                                    <a class="btn btn-warning" href="views/details_sales/details_sales.php?id=<?php echo $fila['id_venta']; ?>">
                                        <img src="/assets/images/details.png" alt="details" style="width: 18px; height: 18px;">
                                        <p>Ver detalles</p>
                                    </a>
                                    <a class="btn btn-danger" href="views/delete_admin.php?id=<?php echo $fila['id_venta']; ?>">
                                        <img src="/assets/images/eliminar.png" alt="Eliminar" style="width: 18px; height: 18px;">
                                        <p>Eliminar</p>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr class="text-center">
                        <td colspan="5">No existen registros</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>