<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

if (isset($_POST['accion'])){ 
    switch ($_POST['accion']){
        case 'editar_registro':
            editar_registro();
            break; 
        case 'eliminar_registro':
            eliminar_registro();
            break;
    }
}

function editar_registro() {
    global $conexion;
    extract($_POST);

    // Cifra la contraseña antes de la consulta
    $contrasena = hash('sha512', $contrasena);

    $consulta="UPDATE users SET identificacion = '$identificacion', nombre = '$nombre', apellido = '$apellido', correo = '$correo', telefono = '$telefono'   WHERE identificacion = '$identificacion' ";
    mysqli_query($conexion, $consulta);
    header('Location: ../manage_users.php');
}


function eliminar_registro() {
    global $conexion;
    extract($_POST);
    $identificacion= $_POST['identificacion'];
    $consulta= "DELETE FROM users WHERE identificacion= $identificacion";
    mysqli_query($conexion, $consulta);
    header('Location: ../manage_users.php');
}
?>
