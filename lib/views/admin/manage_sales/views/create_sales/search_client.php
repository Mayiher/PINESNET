<?php

// Incluir la conexión a la base de datos
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

// Establecemos la cabecera para que el contenido sea JSON
header('Content-Type: application/json');

// Verificamos si se ha recibido el parámetro 'identificacion'
if (isset($_GET['identificacion'])) {
    $identificacion = $_GET['identificacion'];

    // Verificamos si el valor de identificación está vacío
    if (empty($identificacion)) {
        echo json_encode(["success" => false, "error" => "Falta la identificación en la solicitud."]);
        exit;
    }

    // Consulta a la base de datos para obtener la información del cliente
    $sql = "SELECT nombre, apellido FROM users WHERE identificacion = ?";
    $stmt = $conexion->prepare($sql);  // Usamos $conexion (de server.php) en lugar de $conn

    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => "Error en la preparación de la consulta."]);
        exit;
    }

    // Vinculamos el parámetro 'identificacion' a la consulta
    $stmt->bind_param("s", $identificacion);

    // Ejecutamos la consulta
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "error" => "Error al ejecutar la consulta."]);
        exit;
    }

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El cliente fue encontrado
        $stmt->bind_result($nombre, $apellido);
        $stmt->fetch();

        // Devolvemos los datos del cliente
        echo json_encode(["success" => true, "nombre_completo" => $nombre . ' ' . $apellido]);
    } else {
        // El cliente no fue encontrado
        echo json_encode(["success" => false, "error" => "Cliente no encontrado."]);
    }

    // Cerramos el statement
    $stmt->close();
} else {
    // Si no se ha recibido el parámetro 'identificacion'
    echo json_encode(["success" => false, "error" => "Falta el parámetro de identificación."]);
}

// Cerramos la conexión
$conexion->close();
?>
