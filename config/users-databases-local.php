<?php

// Desactivar la visualización de errores
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Definir un manejador de errores personalizado
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    $fecha = date('Y-m-d H:i:s');
    file_put_contents('error_users_databases_local.txt', $fecha . ' - ' . $errstr . ' in ' . $errfile . ' on line ' . $errline . "\n", FILE_APPEND);
});

session_start();

try {
    // Incluir el archivo de conexión (SQLite3)
    include 'server-local.php';

    $correo = $_POST['correo'];
    $contrasena = hash('sha512', $_POST['contrasena']);

    // Buscar en la tabla 'users'
    $stmt = $conexion->prepare("SELECT * FROM users WHERE correo = ? AND contrasena = ?");
    $stmt->bindValue(1, $correo, SQLITE3_TEXT);
    $stmt->bindValue(2, $contrasena, SQLITE3_TEXT);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if ($user) {
        // Si se encontró en 'users', se guarda en $_SESSION['users']
        $_SESSION['users'] = $user;
        header("Location: /index.php");
        exit;
    } else {
        // Si no se encontró en 'users', buscar en la tabla 'employees'
        $stmt = $conexion->prepare("SELECT * FROM employees WHERE correo = ? AND contrasena = ?");
        $stmt->bindValue(1, $correo, SQLITE3_TEXT);
        $stmt->bindValue(2, $contrasena, SQLITE3_TEXT);
        $result = $stmt->execute();
        $employee = $result->fetchArray(SQLITE3_ASSOC);

        if ($employee) {
            // Si el empleado es administrador, guardarlo solo en $_SESSION['admin']
            if (strtolower($employee['rol']) === 'administrador') {
                $_SESSION['admin'] = $employee;
                header("Location: /lib/views/employees/index_admin.php");
                exit;
            } else {
                // Para otros empleados, se guarda en $_SESSION['employees']
                $_SESSION['employees'] = $employee;
                header("Location: /index.php");
                exit;
            }
        } else {
            echo '
            <script>
                alert("Este correo no se encuentra registrado, por favor verifique la información");
                window.location.href = "/lib/views/auth/login/login.php";
            </script>
            ';
            exit;
        }
    }
} catch (Exception $e) {
    echo '<script>
        alert("No se ha podido conectar a la base de datos");
        window.location.href = "/lib/views/auth/login/login.php";
    </script>';
    exit;
}
?>
