<?php
require '../../../shared/header/header.php';

// Verificamos que exista la sesión de administrador y que su rol sea "Administrador"
if (!isset($_SESSION['admin']) || empty($_SESSION['admin']) || strtolower($_SESSION['admin']['rol']) !== 'administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}

$nombre   = $_SESSION['admin']['nombre'];
$apellido = $_SESSION['admin']['apellido'];

// Incluir la conexión a la base de datos SQLite
include $_SERVER['DOCUMENT_ROOT'] . '/config/server-local.php';

// Validar que se reciba un ID válido por GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo '<script>alert("ID inválido.");</script>';
    echo '<script>window.location.href="../../index_admin.php";</script>';
    exit;
}

// Consulta para obtener los datos del registro (administrador) a editar de la tabla "employees"
$SQL = "SELECT * FROM employees WHERE id = $id";
$resultado = $conexion->query($SQL);
$administrador = $resultado->fetchArray(SQLITE3_ASSOC);
if (!$administrador) {
    echo '<script>alert("Registro no encontrado.");</script>';
    echo '<script>window.location.href="../../index_admin.php";</script>';
    exit;
}
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

<form action="../includes/_functions.php" method="POST">
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <h3 class="text-center">Editar usuario</h3>
                        <div class="form-group">
                            <label for="identificacion" class="form-label">Identificación *</label>
                            <input type="text" id="identificacion" name="identificacion" class="form-control" 
                                   value="<?php echo htmlspecialchars($administrador['identificacion']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" 
                                   value="<?php echo htmlspecialchars($administrador['nombre']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido" class="form-label">Apellido *</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" 
                                   value="<?php echo htmlspecialchars($administrador['apellido']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="correo" class="form-label">Correo *</label><br>
                            <input type="email" name="correo" id="correo" class="form-control" 
                                   value="<?php echo htmlspecialchars($administrador['correo']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono *</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control" 
                                   value="<?php echo htmlspecialchars($administrador['telefono']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena" class="form-label">Contraseña *</label><br>
                            <input type="password" name="contrasena" id="contrasena" class="form-control" 
                                   value="<?php echo htmlspecialchars($administrador['contrasena']); ?>" required>
                        </div>
                        <!-- Campo de rol en solo lectura -->
                        <div class="form-group">
                            <label for="rol" class="form-label">Rol *</label>
                            <input type="text" id="rol" name="rol" class="form-control" value="Administrador" readonly>
                        </div>
                        <br>
                        <!-- Enviamos el ID oculto y la acción -->
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($administrador['id']); ?>">
                        <input type="hidden" name="accion" value="editar_registro">
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
