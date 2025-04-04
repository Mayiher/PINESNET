<?php

// Definir la constante DIRECT_EXECUTION si el archivo se está ejecutando directamente
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    define('DIRECT_EXECUTION', true);
}

$servidor = "localhost";          
$usuario = "root";                
$contraseña = "";                  
$base_de_datos = "pinesnet";     


$conexion = mysqli_connect($servidor, $usuario, $contraseña, $base_de_datos);

if (!$conexion) {
    // Obtener la fecha y hora actuales
    $fecha = date('Y-m-d H:i:s');

    // Escribir el error en un archivo con la fecha y hora
    file_put_contents('error_server_log.txt', $fecha . ' - ' . mysqli_connect_error() . "\n", FILE_APPEND);

    // Solo muestra la alerta si el código se está ejecutando directamente
    if (defined('DIRECT_EXECUTION')) {
        echo '<script>alert("No se ha podido conectar a la base de datos"); document.body.innerHTML = "";</script>';
    }
    exit;
}

// Solo muestra la alerta si el código se está ejecutando directamente
if (defined('DIRECT_EXECUTION')) {
    echo '<script>
    alert("Conectado exitosamente a la base de datos");
    window.onload = function() {
        setTimeout(function() {
            window.location = "";
        }, 0); 
    };
    </script>';
}

?>
