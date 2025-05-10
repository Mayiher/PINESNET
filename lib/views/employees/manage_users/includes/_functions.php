<?php
// includes/_functions.php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'editar_registro':
            editar_registro();
            break;
        case 'eliminar_registro':
            eliminar_registro();
            break;
    }
    exit;
}

function editar_registro() {
    global $conexion;

    // Original ID (campo hidden en el formulario)
    $oldId  = $_POST['identificacion_original'] ?? '';
    // Nuevos valores del formulario
    $nombre  = trim($_POST['nombre'] ?? '');
    $apellido= trim($_POST['apellido'] ?? '');
    $correo  = trim($_POST['correo'] ?? '');
    $telefono= trim($_POST['telefono'] ?? '');

    // Validaciones básicas
    if ($oldId === '' || $nombre === '' || $apellido === '' || $correo === '' || $telefono === '') {
        die('Faltan datos obligatorios.');
    }

    // Preparamos la consulta
    $sql = "UPDATE users 
            SET nombre   = ?,
                apellido = ?,
                correo   = ?,
                telefono = ?
            WHERE identificacion = ?";
    if (!$stmt = $conexion->prepare($sql)) {
        die("Error en la preparación: " . htmlspecialchars($conexion->error));
    }

    // Enlazamos parámetros y ejecutamos
    $stmt->bind_param(
        "sssss",
        $nombre,
        $apellido,
        $correo,
        $telefono,
        $oldId
    );
    if (!$stmt->execute()) {
        die("Error al actualizar: " . htmlspecialchars($stmt->error));
    }
    $stmt->close();

    // Redirigir al listado
    header('Location: ../manage_users.php');
}

function eliminar_registro() {
    global $conexion;

    // ID recibido desde el formulario
    $id = $_POST['identificacion'] ?? '';
    if ($id === '') {
        die('Identificador inválido.');
    }

    // Preparamos la consulta
    $sql = "DELETE FROM users WHERE identificacion = ?";
    if (!$stmt = $conexion->prepare($sql)) {
        die("Error en la preparación: " . htmlspecialchars($conexion->error));
    }

    $stmt->bind_param("s", $id);
    if (!$stmt->execute()) {
        die("Error al eliminar: " . htmlspecialchars($stmt->error));
    }
    $stmt->close();

    // Redirigir al listado
    header('Location: ../manage_users.php');
}
