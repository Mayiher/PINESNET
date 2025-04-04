<?php
require '../../../shared/header/header.php';

// Verificamos que exista la sesión de administrador y que su rol sea "Administrador"
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
                        <?php
                        // Incluir la conexión a la base de datos SQLite (server-local.php)
                        require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server-local.php';

                        // Verificar que se haya pasado un identificador por GET
                        if (isset($_GET['identificacion'])) {
                            // Sanitizamos el identificador para evitar inyección
                            $identificacion = SQLite3::escapeString($_GET['identificacion']);

                            // Consulta para obtener los datos del usuario de la tabla "users"
                            $SQL = "SELECT * FROM users WHERE identificacion = :identificacion";
                            $stmt = $conexion->prepare($SQL);
                            if (!$stmt) {
                                echo '<script>alert("Error al preparar la consulta.");</script>';
                                echo '<script>window.location.href="../../index_admin.php";</script>';
                                exit;
                            }
                            // Enlazar parámetro
                            $stmt->bindValue(':identificacion', $identificacion, SQLITE3_TEXT);
                            // Ejecutar
                            $resultado = $stmt->execute();
                            // Obtener el registro
                            $usuario = $resultado->fetchArray(SQLITE3_ASSOC);

                            if (!$usuario) {
                                echo '<script>alert("No se encontró el usuario con ese identificador.");</script>';
                                echo '<script>window.location.href="../../index_admin.php";</script>';
                                exit;
                            }
                        } else {
                            echo '<script>alert("Identificación no proporcionada.");</script>';
                            echo '<script>window.location.href="../../index_admin.php";</script>';
                            exit;
                        }
                        ?>

                        <h3 class="text-center">Editar usuario</h3>
                        <div class="form-group">
                            <label for="identificacion" class="form-label">Identificación *</label>
                            <input type="text" id="identificacion" name="identificacion" class="form-control" 
                                   value="<?php echo htmlspecialchars($usuario['identificacion']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" 
                                   value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido" class="form-label">Apellido *</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" 
                                   value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="correo" class="form-label">Correo *</label><br>
                            <input type="email" name="correo" id="correo" class="form-control" 
                                   value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono *</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control" 
                                   value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
                        </div>
                        <!-- No se incluye el campo de contraseña para edición -->

                        <!-- Campo oculto de acción -->
                        <input type="hidden" name="accion" value="editar_registro">
                        <!-- Campo oculto con el identificador -->
                        <input type="hidden" name="identificacion" value="<?php echo htmlspecialchars($usuario['identificacion']); ?>">

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            <a href="../../index_admin.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div><!-- fin login-box -->
                </div><!-- fin login-column -->
            </div><!-- fin login-row -->
        </div><!-- fin container -->
    </div><!-- fin login -->
</form>

</body>
</html>
