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

<body id="page-top">

<form  action="../includes/_functions.php" method="POST">
<div id="login" >
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                    
<?php
// Incluir el archivo server.php
include $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

// Consulta para obtener los datos del usuario
$id = $_GET['id']; // Asegúrate de que este valor se está pasando correctamente
$SQL = "SELECT * FROM admin WHERE id = $id";
$resultado = mysqli_query($conexion, $SQL);
$administrador = mysqli_fetch_assoc($resultado);
?>

<h3 class="text-center">Editar usuario</h3>
  <div class="form-group">
    <label for="identificacion" class="form-label">Identificacion *</label>
    <input type="text" id="identificacion" name="identificacion" class="form-control" value="<?php echo $administrador['identificacion'];?>" required>
  </div>
  <div class="form-group">
    <label for="nombre" class="form-label">Nombre *</label>
    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $administrador['nombre'];?>" required>
  </div>
  <div class="form-group">
    <label for="apellido" class="form-label">Apellido *</label>
    <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $administrador['apellido'];?>" required>
  </div>
  <div class="form-group">
    <label for="correo">Correo *:</label><br>
    <input type="email" name="correo" id="correo" class="form-control" placeholder="" value="<?php echo $administrador['correo'];?>">
  </div>
  <div class="form-group">
    <label for="telefono" class="form-label">Telefono *</label>
    <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo $administrador['telefono'];?>" required>
  </div>
  <div class="form-group">
    <label for="contrasena" class="form-label">Contraseña:</label><br>
    <input type="password" name="contrasena" id="contrasena" class="form-control" value="<?php echo $administrador['contrasena'];?>" required>
  </div>
<br>
</br>
  <button type="submit" class="btn btn-primary">Guardar cambios</button>
</form>
<br>
<div class="mb-3">
  <a href="../../index_admin.php" class="btn btn-danger">Cancelar</a>                  
</html>