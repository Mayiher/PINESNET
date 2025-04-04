<?php

require '../../shared/header/header.php';

// Verificamos que exista la sesión de administrador y que su rol sea "administrador"
if (!isset($_SESSION['admin']) || empty($_SESSION['admin']) || strtolower($_SESSION['admin']['rol']) !== 'administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}

$adminData = $_SESSION['admin'];
$nombre   = $adminData['nombre'];
$apellido = $adminData['apellido'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SISTEL</title>
    <link rel="stylesheet" href="../../shared/header/header.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container is-fluid">
  <div class="col-xs-12">
    <h1>Bienvenido Administrador <?php echo htmlspecialchars($nombre . ' ' . $apellido); ?></h1>
    <h1>Lista de usuarios</h1>

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
// Incluimos la conexión a la base de datos SQLite
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server-local.php';

// Consulta: obtener todos los registros de la tabla 'users'
$SQL = "SELECT identificacion, nombre, apellido, correo, telefono, contrasena, fecha_registro FROM users";
$resultado = $conexion->query($SQL);

if (!$resultado) {
    // Si ocurre un error en la consulta, mostramos el error
    echo '<tr class="text-center"><td colspan="8">Error en la consulta: ' . htmlspecialchars($conexion->lastErrorMsg()) . '</td></tr>';
} else {
    $found = false;
    while ($fila = $resultado->fetchArray(SQLITE3_ASSOC)) {
        $found = true;
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
              <a class="btn btn-warning" href="views/edit_user.php?identificacion=<?php echo htmlspecialchars($fila['identificacion']); ?>">
                <img src="/assets/images/boton-editar.png" alt="Editar" style="width: 18px; height: 18px;">
                <p>Editar</p>
              </a>
              <a class="btn btn-danger" href="views/delete_user.php?identificacion=<?php echo htmlspecialchars($fila['identificacion']); ?>">
                <img src="/assets/images/eliminar.png" alt="Eliminar" style="width: 18px; height: 18px;">
                <p>Eliminar</p>
              </a>
            </div>
          </td>
        </tr>
        <?php
    }
    if (!$found) {
        ?>
        <tr class="text-center">
          <td colspan="8">No existen registros</td>
        </tr>
        <?php
    }
}
?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
