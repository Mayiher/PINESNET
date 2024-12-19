<?php
require_once ("../../../../server.php");

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

    $consulta="UPDATE distribution SET identificacion = '$identificacion', nombre = '$nombre', apellido = '$apellido', correo = '$correo', telefono = '$telefono', contrasena ='$contrasena', rol = '$rol' WHERE id = '$id' ";
    mysqli_query($conexion, $consulta);
    header('Location: ../admin.php');
}


function eliminar_registro() {
    global $conexion;
    extract($_POST);
    $id= $_POST['id'];
    $consulta= "DELETE FROM distribution WHERE id= $id";
    mysqli_query($conexion, $consulta);
    header('Location: ../admin.php');
}

?>
