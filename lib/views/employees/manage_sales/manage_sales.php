<?php
require '../../shared/header/header.php';

// Verificamos que exista la sesión de administrador y que su rol sea "administrador"
if (!isset($_SESSION['admin']) || empty($_SESSION['admin']) || strtolower($_SESSION['admin']['rol']) !== 'administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}

$nombre   = $_SESSION['admin']['nombre'];
$apellido = $_SESSION['admin']['apellido'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server-local.php';

// Aseguramos que la conexión esté activa
if (!$conexion) {
    die("Error de conexión: " . $conexion->lastErrorMsg());
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
            <a class="btn-success" href="/lib/views/employees/manage_sales/create_sales/create_sales.php">
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
                
                $stmt = $conexion->prepare($SQL);
                if (!$stmt) {
                    die("Error en la preparación de la consulta: " . $conexion->lastErrorMsg());
                }
                
                $resultado = $stmt->execute();

                if ($resultado) {
                    $hayResultados = false;
                    while ($fila = $resultado->fetchArray(SQLITE3_ASSOC)) {
                        $hayResultados = true;
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
                    if (!$hayResultados) {
                        ?>
                        <tr class="text-center">
                            <td colspan="5">No existen registros</td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr class="text-center">
                        <td colspan="5">Error al obtener los datos</td>
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
