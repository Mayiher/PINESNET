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
    
    // Obtener y sanitizar los datos enviados por POST
    $old_identificacion = trim($_POST['old_identificacion']);  // Valor original (oculto en el formulario)
    $new_identificacion = trim($_POST['identificacion']);      // Nuevo valor (visible en el formulario)
    $nombre         = trim($_POST['nombre']);
    $apellido       = trim($_POST['apellido']);
    $correo         = trim($_POST['correo']);
    $telefono       = trim($_POST['telefono']);
    $contrasena     = trim($_POST['contrasena']);
    $rol            = isset($_POST['rol']) ? trim($_POST['rol']) : '';
    
    // Cifrar la contraseña
    $contrasena = hash('sha512', $contrasena);
    
    // Preparamos la consulta para actualizar el registro en la tabla 'users'
    // Usamos dos parámetros: uno para el nuevo valor y otro para el valor original en la cláusula WHERE
    $consulta = "UPDATE users 
                 SET identificacion = :new_identificacion,
                     nombre = :nombre,
                     apellido = :apellido,
                     correo = :correo,
                     telefono = :telefono,
                     contrasena = :contrasena";
    // Actualizamos el rol solo si se ha enviado
    if ($rol !== '') {
        $consulta .= ", rol = :rol";
    }
    $consulta .= " WHERE identificacion = :old_identificacion";
    
    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->lastErrorMsg());
    }
    
    $stmt->bindValue(':new_identificacion', $new_identificacion, SQLITE3_TEXT);
    $stmt->bindValue(':nombre', $nombre, SQLITE3_TEXT);
    $stmt->bindValue(':apellido', $apellido, SQLITE3_TEXT);
    $stmt->bindValue(':correo', $correo, SQLITE3_TEXT);
    $stmt->bindValue(':telefono', $telefono, SQLITE3_TEXT);
    $stmt->bindValue(':contrasena', $contrasena, SQLITE3_TEXT);
    if ($rol !== '') {
        $stmt->bindValue(':rol', $rol, SQLITE3_TEXT);
    }
    $stmt->bindValue(':old_identificacion', $old_identificacion, SQLITE3_TEXT);
    
    $result = $stmt->execute();
    if ($result === false) {
        die("Error al actualizar: " . $conexion->lastErrorMsg());
    }
    
    header('Location: ../manage_users.php');
    exit;
}

function eliminar_registro() {
    global $conexion;
    $identificacion = trim($_POST['identificacion']);
    
    // Preparamos la consulta para eliminar el registro de la tabla 'users'
    $consulta = "DELETE FROM users WHERE identificacion = :identificacion";
    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->lastErrorMsg());
    }
    $stmt->bindValue(':identificacion', $identificacion, SQLITE3_TEXT);
    
    $result = $stmt->execute();
    if ($result === false) {
        die("Error al eliminar: " . $conexion->lastErrorMsg());
    }
    
    header('Location: ../manage_users.php');
    exit;
}
?>
