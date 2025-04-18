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
    <h1>Lista de administradores</h1>
    <div>
      <a class="btn-success" href="views/create_admin.php">
        <img src="/assets/images/agregar.png" alt="Nuevo Administrador" style="width: 25px; height: 25px;">
        Nuevo Administrador
      </a>
    </div>
    <br><br>
    <div class="table-container">
      <table class="table table-striped table-dark" id="table_id">
        <thead>
          <tr>
            <th>ID</th> 
            <th>Identificación</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Contraseña</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

$SQL = "SELECT id, identificacion, nombre, apellido, correo, telefono, contrasena 
        FROM admin 
        WHERE LOWER(rol) = 'administrador'";

$resultado = $conexion->query($SQL);

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
?>
        <tr>
            <td><?php echo htmlspecialchars($fila['id']); ?></td>
            <td><?php echo htmlspecialchars($fila['identificacion']); ?></td>
            <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
            <td><?php echo htmlspecialchars($fila['apellido']); ?></td>
            <td><?php echo htmlspecialchars($fila['correo']); ?></td>
            <td><?php echo htmlspecialchars($fila['telefono']); ?></td>
            <td><?php echo htmlspecialchars($fila['contrasena']); ?></td>
            <td>
              <div class="action-button">
                <a class="btn btn-warning" href="views/edit_admin.php?id=<?php echo htmlspecialchars($fila['id']); ?>">
                    <img src="/assets/images/boton-editar.png" alt="Editar" style="width: 18px; height: 18px;">
                    <p>Editar</p>
                </a>
                <a class="btn btn-danger" href="views/delete_admin.php?id=<?php echo htmlspecialchars($fila['id']); ?>">
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
            <td colspan="8">No existen registros</td>
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
