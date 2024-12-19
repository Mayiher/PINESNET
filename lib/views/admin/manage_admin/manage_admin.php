<?php

require '../../shared/header/header.php';

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
    <link rel="stylesheet" href="../../shared/header/header.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container is-fluid">

  <div class="col-xs-12">
    <h1>Bienvenido Administrador <?php echo $nombre . ' ' . $apellido; ?></a></h1>
    <br>
    <h1>Lista de administradores</h1>
    <br>
    <div>
      <a class="btn-success" href="views/create_admin.php">
        <img src="/assets/images/agregar.png" alt="Nuevo Administrador" style="width: 25px; height: 25px;">
        Nuevo Administrador
      </a>
    </div>
    <br>
    <br>
    </form>

    <div class="table-container">
    <table class="table table-striped table-dark " id="table_id">
  <thead>
    <tr>
      <th>ID</th> 
      <th>Identificacion</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Correo</th>
      <th>Telefono</th>
      <th>Contraseña</th>
      <th>Rol</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';
$SQL = "SELECT id, identificacion, nombre, apellido, correo, telefono, contrasena, rol FROM admin";
$dato = mysqli_query($conexion, $SQL);

if ($dato->num_rows > 0) {
  while ($fila = mysqli_fetch_array($dato)) {
    ?>
    <tr>
      <td><?php echo $fila['id']; ?></td>
      <td><?php echo $fila['identificacion']; ?></td>
      <td><?php echo $fila['nombre']; ?></td>
      <td><?php echo $fila['apellido']; ?></td>
      <td><?php echo $fila['correo']; ?></td>
      <td><?php echo $fila['telefono']; ?></td>
      <td><?php echo $fila['contrasena']; ?></td>
      <td><?php echo $fila['rol']; ?></td>
      <td>
      <div class="action-button">
    <a class="btn btn-warning" href="views/edit_admin.php?id=<?php echo $fila['id'] ?> ">
        <img src="/assets/images/boton-editar.png" alt="Editar" style="width: 18px; height: 18px;">
        <p>Editar</p>
    </a>
    <a class="btn btn-danger" href="views/delete_admin.php?id=<?php echo $fila['id'] ?>">
        <img src="/assets/images/eliminar.png" alt="Eliminar" style="width: 18px; height: 18px;">
        <p>Eliminar</p>
    </a>
</div>

</td>

      </td>
    </tr>
    <?php
  }
} else {
  ?>
  <tr class="text-center">
    <td colspan="16">No existen registros</td>
  </tr>
  <?php
}
?>
        </body>
    </table>

</html>