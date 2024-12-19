<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    define('DIRECT_EXECUTION', true);
}


$servidor = "localhost";          
$usuario = "root";                
$contraseña = "";                  
$base_de_datos = "pinesnet";       


$conexion = mysqli_connect($servidor, $usuario, $contraseña, $base_de_datos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}


if (!$conexion) {

    $fecha = date('Y-m-d H:i:s');
    file_put_contents('error_server_local_log.txt', $fecha . ' - ' . mysqli_connect_error() . "\n", FILE_APPEND);
    if (defined('DIRECT_EXECUTION')) {
        echo '<script>alert("No se ha podido conectar a la base de datos"); document.body.innerHTML = "";</script>';
    }
    exit;
}
if (defined('DIRECT_EXECUTION')) {
    echo '<script>alert("Conectado exitosamente a la base de datos")</script>';
}

?>
