<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server-local.php';

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
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

    // Sanitizar y obtener datos
    $id             = intval($_POST['id']);
    $identificacion = trim($_POST['identificacion']);
    $nombre         = trim($_POST['nombre']);
    $apellido       = trim($_POST['apellido']);
    $correo         = trim($_POST['correo']);
    $telefono       = trim($_POST['telefono']);
    $contrasena     = trim($_POST['contrasena']);
    $rol            = trim($_POST['rol']);

    // Hashear la contraseña (opcional si ya está encriptada en la base de datos)
    $contrasena = hash('sha512', $contrasena);

    $consulta = "UPDATE employees 
                 SET identificacion = ?, 
                     nombre = ?, 
                     apellido = ?, 
                     correo = ?, 
                     telefono = ?, 
                     contrasena = ?, 
                     rol = ? 
                 WHERE id = ?";

    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt->bind_param("sssssssi", 
        $identificacion, 
        $nombre, 
        $apellido, 
        $correo, 
        $telefono, 
        $contrasena, 
        $rol, 
        $id
    );

    if (!$stmt->execute()) {
        die("Error al ejecutar: " . $stmt->error);
    }

    $stmt->close();
    header('Location: /lib/views/employees/manage_admin/manage_admin.php');
    exit;
}

function eliminar_registro() {
    global $conexion;

    $id = intval($_POST['id']);
    $consulta = "DELETE FROM employees WHERE id = ?";

    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die("Error al ejecutar: " . $stmt->error);
    }

    $stmt->close();
    header('Location: ../../index_admin.php');
    exit;
}
?>
