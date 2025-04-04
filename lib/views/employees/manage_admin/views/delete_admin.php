<?php
require '../../../shared/header/header.php';

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
    <title>Confirmar Eliminación</title>
    <link rel="stylesheet" href="../../../shared/header/header.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/es.css">
</head>
<body>
    
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            <?php
            // Incluir la conexión a la base de datos SQLite (archivo ubicado en /config)
            require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server-local.php';

            // Obtener el ID pasado por GET y forzar a entero para seguridad
            $id = intval($_GET['id']);

            // Consulta para obtener los datos del registro en la tabla "employees"
            $SQL = "SELECT * FROM employees WHERE id = $id";
            $resultado = $conexion->query($SQL);
            $usuario = $resultado->fetchArray(SQLITE3_ASSOC);
            ?>

            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['identificacion']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="alert alert-danger text-center">
                <p>¿Desea confirmar la eliminación del registro?</p>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <form action="../includes/_functions.php" method="POST">
                        <input type="hidden" name="accion" value="eliminar_registro">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                        <input type="submit" value="Eliminar" class="btn btn-danger">
                        <a href="../../index_admin.php" class="btn btn-success">Cancelar</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>
