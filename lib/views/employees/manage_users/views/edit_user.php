<?php
require '../../../shared/header/header.php';

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
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Editar Usuario</title>
  <link rel="stylesheet" href="../../../shared/header/header.css">
  <link rel="stylesheet" href="../css/fontawesome-all.min.css">
  <link rel="stylesheet" href="../css/es.css">
</head>
<body id="page-top">

<?php
// 2) Conexión MySQLi
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';
if ($conexion->connect_errno) {
    die("Error de conexión a la base de datos: " . htmlspecialchars($conexion->connect_error));
}

// 3) Validar y sanitizar el identificador por GET
if (!isset($_GET['identificacion'])) {
    echo '<script>alert("Identificación no proporcionada.");</script>';
    echo '<script>window.location.href="../../index_admin.php";</script>';
    exit;
}
$identificacion = $_GET['identificacion']; 
// Si identificacion es numérica, usar intval; si alfanumérica, échale real_escape:
$identificacion = $conexion->real_escape_string($identificacion);

// 4) Preparar y ejecutar la consulta
$stmt = $conexion->prepare(
    "SELECT identificacion, nombre, apellido, correo, telefono 
     FROM users 
     WHERE identificacion = ?"
);
if (!$stmt) {
    die("Error al preparar la consulta: " . htmlspecialchars($conexion->error));
}
$stmt->bind_param("s", $identificacion);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

if (!$usuario) {
    echo '<script>alert("No se encontró el usuario con esa identificación.");</script>';
    echo '<script>window.location.href="../../index_admin.php";</script>';
    exit;
}
?>

<form action="../includes/_functions.php" method="POST">
  <div id="login">
    <div class="container">
      <div id="login-row" class="row justify-content-center align-items-center">
        <div id="login-column" class="col-md-6">
          <div id="login-box" class="col-md-12">
            <h3 class="text-center">Editar Usuario</h3>

            <div class="form-group">
              <label for="identificacion" class="form-label">Identificación *</label>
              <input
                type="text"
                id="identificacion"
                name="identificacion"
                class="form-control"
                value="<?php echo htmlspecialchars($usuario['identificacion']); ?>"
                readonly
              >
            </div>

            <div class="form-group">
              <label for="nombre" class="form-label">Nombre *</label>
              <input
                type="text"
                id="nombre"
                name="nombre"
                class="form-control"
                value="<?php echo htmlspecialchars($usuario['nombre']); ?>"
                required
              >
            </div>

            <div class="form-group">
              <label for="apellido" class="form-label">Apellido *</label>
              <input
                type="text"
                id="apellido"
                name="apellido"
                class="form-control"
                value="<?php echo htmlspecialchars($usuario['apellido']); ?>"
                required
              >
            </div>

            <div class="form-group">
              <label for="correo" class="form-label">Correo *</label>
              <input
                type="email"
                id="correo"
                name="correo"
                class="form-control"
                value="<?php echo htmlspecialchars($usuario['correo']); ?>"
                required
              >
            </div>

            <div class="form-group">
              <label for="telefono" class="form-label">Teléfono *</label>
              <input
                type="tel"
                id="telefono"
                name="telefono"
                class="form-control"
                value="<?php echo htmlspecialchars($usuario['telefono']); ?>"
                required
              >
            </div>

            <!-- No manejamos contraseña aquí -->

            <!-- Campos ocultos -->
            <input type="hidden" name="accion" value="editar_registro">
            <input
              type="hidden"
              name="identificacion_original"
              value="<?php echo htmlspecialchars($usuario['identificacion']); ?>"
            >

            <div class="form-group text-center">
              <button type="submit" class="btn btn-primary">Guardar cambios</button>
              <a href="../../index_admin.php" class="btn btn-danger">Cancelar</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</form>

</body>
</html>
