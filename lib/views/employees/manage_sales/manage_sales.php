<?php
require '../../shared/header/header.php';

// 1) Verificar sesión de administrador
if (
    !isset($_SESSION['admin']) ||
    empty($_SESSION['admin']) ||
    strtolower($_SESSION['admin']['rol']) !== 'administrador'
) {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}

$nombre   = $_SESSION['admin']['nombre'];
$apellido = $_SESSION['admin']['apellido'];

// 2) Conectar a MySQLi
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';
if ($conexion->connect_errno) {
    die("Error de conexión a la base de datos: " . htmlspecialchars($conexion->connect_error));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lista de Ventas</title>
  <link rel="stylesheet" href="../../shared/header/header.css">
  <link rel="stylesheet" href="css/fontawesome-all.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="container is-fluid">
    <div class="col-xs-12">
      <h1>Bienvenido Administrador <?php echo htmlspecialchars("$nombre $apellido"); ?></h1>
      <h2>Lista de ventas</h2>

      <div>
        <a class="btn-success" href="/lib/views/employees/manage_sales/create_sales/create_sales.php">
          <img src="/assets/images/agregar.png" alt="Nueva venta" style="width:25px;height:25px;">
          Nueva venta
        </a>
      </div>
      <br>

      <div class="table-container">
        <table class="table table-striped table-dark" id="table_id">
          <thead>
            <tr>
              <th>ID Venta</th>
              <th>Identificación Cliente</th>
              <th>Nombre Cliente</th>
              <th>Fecha</th>
              <th>Total</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
<?php
// 3) Consulta a MySQLi
$sql = "
  SELECT 
    s.id_venta, 
    s.id_usuario, 
    u.nombre AS nombre_cliente,
    u.apellido AS apellido_cliente,
    s.fecha, 
    s.total
  FROM sales s
  JOIN users u ON s.id_usuario = u.identificacion
";

if ($result = $conexion->query($sql)) {
    if ($result->num_rows === 0) {
        echo '<tr><td colspan="6" class="text-center">No existen registros</td></tr>';
    } else {
        while ($fila = $result->fetch_assoc()) {
            ?>
            <tr>
              <td><?php echo htmlspecialchars($fila['id_venta']); ?></td>
              <td><?php echo htmlspecialchars($fila['id_usuario']); ?></td>
              <td>
                <?php 
                  echo htmlspecialchars($fila['nombre_cliente'] . ' ' . $fila['apellido_cliente']); 
                ?>
              </td>
              <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
              <td><?php echo number_format($fila['total'], 0, ',', '.'); ?></td>
              <td>
                <div class="action-button">
                  <a class="btn btn-warning" href="views/details_sales/details_sales.php?id=<?php echo urlencode($fila['id_venta']); ?>">
                    <img src="/assets/images/details.png" alt="Ver detalles" style="width:18px;height:18px;">
                    <span>Ver detalles</span>
                  </a>
                  <a class="btn btn-danger" href="views/delete_sales.php?id=<?php echo urlencode($fila['id_venta']); ?>">
                    <img src="/assets/images/eliminar.png" alt="Eliminar" style="width:18px;height:18px;">
                    <span>Eliminar</span>
                  </a>
                </div>
              </td>
            </tr>
            <?php
        }
    }
    $result->free();
} else {
    echo '<tr><td colspan="6" class="text-center">Error al obtener los datos: '
       . htmlspecialchars($conexion->error) .
       '</td></tr>';
}

$conexion->close();
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
