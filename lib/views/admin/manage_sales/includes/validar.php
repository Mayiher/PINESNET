<?php
include '../../../../server.php';

if(isset($_POST['registrar'])){

    if(strlen($_POST['nombre']) >=1 && strlen($_POST['apellido'])  >=1 && strlen($_POST['correo'])  >=1 && strlen($_POST['telefono'])  >=1 
    && strlen($_POST['contrasena'])  >=1 && strlen($_POST['rol']) >= 1 && strlen($_POST['identificacion']) >= 1 ){

    $identificacion = trim($_POST['identificacion']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $contrasena = trim($_POST['contrasena']);
    $rol = trim($_POST['rol']);

    $contrasena = hash('sha512', $contrasena);

    $consulta= "INSERT INTO distribution (identificacion, nombre, apellido, correo, telefono, contrasena, rol)
    VALUES ('$identificacion', '$nombre', '$apellido', '$correo','$telefono','$contrasena', '$rol' )";

    mysqli_query($conexion, $consulta);
    mysqli_close($conexion);

    header('Location: ../admin.php');
  }
}
?>
