<?php

// Desactivar la visualización de errores
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Definir un manejador de errores personalizado
set_error_handler(function ($errno, $errstr, $errfile, $errline) {

    // Obtener la fecha y hora actuales
    $fecha = date('Y-m-d H:i:s');

    // Escribir el error en un archivo con la fecha y hora
    file_put_contents('error_users_databases_local.txt', $fecha . ' - ' . $errstr . ' in ' . $errfile . ' on line ' . $errline . "\n", FILE_APPEND);
});

session_start();

try {
    include 'server-local.php';

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena = hash('sha512', $contrasena);

    // Preparar la consulta
    $stmt = $conexion->prepare("SELECT * FROM users WHERE correo=? and contrasena=?");
    $stmt->bind_param("ss", $correo, $contrasena);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();

    // Verificar si se encontraron registros
    if ($user = $result->fetch_assoc()) {

     // Guardamos todo el objeto del usuario en la sesión
        $_SESSION['users'] = $user;
        header("location: /index.php");
        exit;
    } else {

        // Si no se encontró el usuario en la tabla 'users', buscar en la tabla 'admin'
        $stmt = $conexion->prepare("SELECT * FROM admin WHERE correo=? and contrasena=?");
        $stmt->bind_param("ss", $correo, $contrasena);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados
        $result = $stmt->get_result();

        // Verificar si se encontraron registros
        if ($admin = $result->fetch_assoc()) {

             // Guardamos todo el objeto del administrador en la sesión
            $_SESSION['admin'] = $admin;
            if ($admin['rol'] == 'Administrador') {
                header("location: ../admin/index_admin.php");
            } else {
                header("location: /index.php");
            }
            exit;
        } else {
            echo '
            <script>
            alert("Este correo no se encuentra registrado, por favor verifique la informacion");
            window.onload = function() {
        setTimeout(function() {
            window.location = "/lib/views/auth/login/login.php";
        }, 0); 
        };
            </script>
            ';
            exit;
        }
    }
} catch (Exception $e) {
    // Mostrar la alerta de error y redirigir después de que el usuario la cierre
    echo '<script>
    alert("No se ha podido conectar a la base de datos");
    window.onload = function() {
        setTimeout(function() {
            window.location = "/lib/views/auth/login/login.php";
        }, 0); 
    };
    </script>';
    exit;
}

?>