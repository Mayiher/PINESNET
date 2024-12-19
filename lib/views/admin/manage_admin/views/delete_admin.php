<?php

require '../../../shared/header/header.php';

if(!isset($_SESSION['admin']) || $_SESSION['admin']['rol'] != 'Administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../../../shared/header/header.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
<link rel="stylesheet" href="../css/es.css">
</head>
<body>
    
    <div class="container mt-5">
    <div class="row">
    <div class="col-sm-6 offset-sm-3">

     <?php
            // Incluir el archivo server.php
            require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

            // Consulta para obtener los datos del usuario
            $id = $_GET['id']; // Asegúrate de que este valor se está pasando correctamente
            $SQL = "SELECT * FROM admin WHERE id = $id";
            $resultado = mysqli_query($conexion, $SQL);
            $usuario = mysqli_fetch_assoc($resultado);
            ?>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Identificacion</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['identificacion']; ?></td>
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['apellido']; ?></td>
                        <td><?php echo $usuario['correo']; ?></td>
                        <td><?php echo $usuario['rol']; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="alert alert-danger text-center">
                <p>¿Desea confirmar la eliminacion del registro?</p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <form action="../includes/_functions.php" method="POST">
                        <input type="hidden" name="accion" value="eliminar_registro">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="" value="Eliminar" class= " btn btn-danger">
                        <a href="../../index_admin.php" class="btn btn-success">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
