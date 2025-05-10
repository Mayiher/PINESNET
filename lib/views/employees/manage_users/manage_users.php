<?php
require '../../shared/header/header.php';

// Verificamos que exista la sesión de administrador y que su rol sea "administrador"
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SISTEL - Lista de Usuarios</title>
  <link rel="stylesheet" href="../../shared/header/header.css">
  <link rel="stylesheet" href="css/fontawesome-all.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container is-fluid">
  <div class="col-xs-12">
    <h1>Bienvenido Administrador <?php echo htmlspecialchars("$nombre $apellido"); ?></h1>
    <h2>Lista de usuarios</h2>

    <br><br>
    <div class="table-container">
      <table class="table table-striped table-dark" id="table_id">
        <thead>
          <tr>
            <th>Identificación</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Contraseña</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
<?php
// Conexión MySQLi: config/server.php debe definir $conexion = new mysqli(...)
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

if ($conexion->connect_errno) {
    echo '<tr><td colspan="8" class="text-center">'
       . 'Error de conexión: ' . htmlspecialchars($conexion->connect_error) .
       '</td></tr>';
} else {
    $sql = "SELECT identificacion, nombre, apellido, correo, telefono, contrasena, fecha_registro
            FROM users";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        if ($resultado->num_rows === 0) {
            echo '<tr><td colspan="8" class="text-center">No existen registros</td></tr>';
        } else {
            while ($fila = $resultado->fetch_assoc()) {
                ?>
        <tr>
          <td><?php echo htmlspecialchars($fila['identificacion']); ?></td>
          <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
          <td><?php echo htmlspecialchars($fila['apellido']); ?></td>
          <td><?php echo htmlspecialchars($fila['correo']); ?></td>
          <td><?php echo htmlspecialchars($fila['telefono']); ?></td>
          <td><?php echo htmlspecialchars($fila['contrasena']); ?></td>
          <td><?php echo htmlspecialchars($fila['fecha_registro']); ?></td>
          <td>
            <div class="action-button">
              <a class="btn btn-warning"
                 href="views/edit_user.php?identificacion=<?php echo urlencode($fila['identificacion']); ?>">
                <img src="/assets/images/boton-editar.png" alt="Editar" style="width:18px;height:18px;">
                <span>Editar</span>
              </a>
              <a class="btn btn-danger"
                 href="views/delete_user.php?identificacion=<?php echo urlencode($fila['identificacion']); ?>">
                <img src="/assets/images/eliminar.png" alt="Eliminar" style="width:18px;height:18px;">
                <span>Eliminar</span>
              </a>
            </div>
          </td>
        </tr>
                <?php
            }
        }
        $resultado->free();
    } else {
        echo '<tr><td colspan="8" class="text-center">'
           . 'Error en la consulta: ' . htmlspecialchars($conexion->error) .
           '</td></tr>';
    }
    $conexion->close();
}
?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require '../../shared/footer/footer.php'; ?>
</body>
</html>
