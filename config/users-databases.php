<?php
// Desactivar la visualización de errores
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Definir un manejador de errores personalizado
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    date_default_timezone_set('America/Bogota');
    $fecha = date('Y-m-d H:i:s');
    file_put_contents(
        'error_users_databases.txt',
        "$fecha - $errstr in $errfile on line $errline\n",
        FILE_APPEND
    );
});

session_start();

try {
    include 'server.php';

    // Validar que vengan datos por POST
    if (empty($_POST['correo']) || empty($_POST['contrasena'])) {
        throw new Exception('Faltan credenciales');
    }

    $correo     = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $hashInput  = hash('sha256', $contrasena);

    // 1) Comprobar si el correo existe
    $stmt = $conexion->prepare("
        SELECT *
          FROM users
         WHERE correo = ?
    ");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$user = $result->fetch_assoc()) {
        // Correo no registrado
        echo '<script>
            alert("El correo no se encuentra registrado.");
            window.location = "/lib/views/auth/login-register/login-register.php";
        </script>';
        exit;
    }

    // 2) Verificar contraseña
    if ($user['contrasena'] !== $hashInput) {
        // Contraseña incorrecta
        echo '<script>
            alert("La contraseña es incorrecta. Por favor, inténtalo de nuevo.");
            window.location = "/lib/views/auth/login-register/login-register.php";
        </script>';
        exit;
    }

    // 3) Login exitoso: regenerar sesión y distinguir rol
    session_regenerate_id(true);
    $_SESSION['users'] = $user;

    if (strcasecmp($user['rol'], 'Administrator') === 0) {
        header("Location: /lib/views/employees/index_admin.php");
    } else {
        header("Location: /index.php");
    }
    exit;

} catch (Exception $e) {
    $msg = addslashes($e->getMessage());
    echo "<script>
        alert(\"Error al procesar la solicitud: {$msg}\");
        window.onload = function() {
            setTimeout(function() {
                window.location = '/lib/views/auth/login/login.php';
            }, 0);
        };
    </script>";
    exit;
}
