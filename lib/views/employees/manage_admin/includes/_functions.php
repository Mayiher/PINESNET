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
    
    // Extraer variables de $_POST (se recomienda validar y sanitizar en producción)
    $id = $_POST['id'];
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];
    
    // Cifrar la contraseña antes de actualizar
    $contrasena = hash('sha512', $contrasena);
    
    // Preparamos la consulta con marcadores de posición
    $consulta = "UPDATE employees 
                 SET identificacion = :identificacion, 
                     nombre = :nombre, 
                     apellido = :apellido, 
                     correo = :correo, 
                     telefono = :telefono, 
                     contrasena = :contrasena, 
                     rol = :rol 
                 WHERE id = :id";
    
    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->lastErrorMsg());
    }
    
    // Enlazamos los parámetros
    $stmt->bindValue(':identificacion', $identificacion, SQLITE3_TEXT);
    $stmt->bindValue(':nombre', $nombre, SQLITE3_TEXT);
    $stmt->bindValue(':apellido', $apellido, SQLITE3_TEXT);
    $stmt->bindValue(':correo', $correo, SQLITE3_TEXT);
    $stmt->bindValue(':telefono', $telefono, SQLITE3_TEXT);
    $stmt->bindValue(':contrasena', $contrasena, SQLITE3_TEXT);
    $stmt->bindValue(':rol', $rol, SQLITE3_TEXT);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    
    $result = $stmt->execute();
    if ($result === false) {
        die("Error al ejecutar la consulta: " . $conexion->lastErrorMsg());
    }
    
    header('Location: /lib/views/employees/manage_admin/manage_admin.php');
    exit;
}

function eliminar_registro() {
    global $conexion;
    $id = intval($_POST['id']);
    $consulta = "DELETE FROM employees WHERE id = :id";
    
    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->lastErrorMsg());
    }
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    
    $result = $stmt->execute();
    if ($result === false) {
        die("Error al ejecutar la consulta: " . $conexion->lastErrorMsg());
    }
    
    header('Location: ../../index_admin.php');
    exit;
}
?>
