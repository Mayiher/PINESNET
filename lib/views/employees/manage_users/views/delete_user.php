<?php
require '../../../shared/header/header.php';

// 1) Verificar sesión de administrador
if (
    !isset($_SESSION['admin']) ||
    empty($_SESSION['admin']) ||
    strtolower($_SESSION['admin']['rol']) !== 'administrador'
) {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="/index.php";</script>';
    exit;
}

// 2) Conexión MySQLi
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';
if ($conexion->connect_errno) {
    die("Error de conexión a la base de datos: " . htmlspecialchars($conexion->connect_error));
}

// 3) Obtener y validar identificador por GET
if (!isset($_GET['identificacion'])) {
    echo '<script>alert("Identificación no proporcionada.");</script>';
    echo '<script>window.location.href="../manage_users.php";</script>';
    exit;
}
$identificacion = $_GET['identificacion'];

// 4) Consulta preparada
$stmt = $conexion->prepare(
    "SELECT identificacion, nombre, apellido, correo 
     FROM users 
     WHERE identificacion = ?"
);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . htmlspecialchars($conexion->error));
}
$stmt->bind_param("s", $identificacion);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

if (!$usuario) {
    echo '<script>alert("No se encontró el usuario con esa identificación.");</script>';
    echo '<script>window.location.href="../manage_users.php";</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Confirmar Eliminación</title>
  <link rel="stylesheet" href="../../../shared/header/header.css">
  <link rel="stylesheet" href="../css/fontawesome-all.min.css">
  <link rel="stylesheet" href="../css/es.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-6 offset-sm-3">

        <h2 class="text-center mb-4">Confirmar eliminación de usuario</h2>

        <table class="table table-striped table-dark">
          <thead>
            <tr>
              <th>Identificación</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Correo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo htmlspecialchars($usuario['identificacion']); ?></td>
              <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
              <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
              <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
            </tr>
          </tbody>
        </table>

        <div class="alert alert-danger text-center">
          <p>¿Desea confirmar la eliminación de este registro?</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-auto">
            <form action="../includes/_functions.php" method="POST">
              <input type="hidden" name="accion" value="eliminar_registro">
              <input type="hidden" name="identificacion" value="<?php echo htmlspecialchars($usuario['identificacion']); ?>">
              <button type="submit" class="btn btn-danger">Eliminar</button>
              <a href="../manage_users.php" class="btn btn-secondary">Cancelar</a>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</body>
</html>
