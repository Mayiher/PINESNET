<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

if(isset($_POST['registrar'])){

    if(strlen($_POST['nombre']) >=1 && strlen($_POST['apellido'])  >=1 && strlen($_POST['correo'])  >=1 && strlen($_POST['telefono'])  >=1 
    && strlen($_POST['contrasena'])  >=1 && strlen($_POST['identificacion']) >= 1 ){

    $identificacion = trim($_POST['identificacion']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $contrasena = trim($_POST['contrasena']);

    $contrasena = hash('sha512', $contrasena);

    $consulta= "INSERT INTO users (identificacion, nombre, apellido, correo, telefono, contrasena)
    VALUES ('$identificacion', '$nombre', '$apellido', '$correo','$telefono','$contrasena')";

    mysqli_query($conexion, $consulta);
    mysqli_close($conexion);

    header('Location: ../index_admin.php');
  }
}
?>