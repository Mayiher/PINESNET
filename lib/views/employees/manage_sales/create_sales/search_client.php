<?php
// Incluir la conexión a la base de datos (SQLite)
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server-local.php';

// Establecer la cabecera para que el contenido sea JSON
header('Content-Type: application/json');

// Verificar si se ha recibido el parámetro 'identificacion'
if (isset($_GET['identificacion'])) {
    $identificacion = $_GET['identificacion'];

    // Verificar si el valor de identificación está vacío
    if (empty($identificacion)) {
        echo json_encode(["success" => false, "error" => "Falta la identificación en la solicitud."]);
        exit;
    }

    // Consulta para obtener la información del cliente usando un parámetro nombrado
    $sql = "SELECT nombre, apellido FROM users WHERE identificacion = :identificacion";
    $stmt = $conexion->prepare($sql);
    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => "Error en la preparación de la consulta: " . $conexion->lastErrorMsg()]);
        exit;
    }

    // Vincular el parámetro 'identificacion'
    $stmt->bindValue(':identificacion', $identificacion, SQLITE3_TEXT);

    // Ejecutar la consulta
    $result = $stmt->execute();
    if ($result === false) {
        echo json_encode(["success" => false, "error" => "Error al ejecutar la consulta: " . $conexion->lastErrorMsg()]);
        exit;
    }

    // Intentar obtener la fila de resultados
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if ($row) {
        // Cliente encontrado
        echo json_encode(["success" => true, "nombre_completo" => $row['nombre'] . ' ' . $row['apellido']]);
    } else {
        // Cliente no encontrado
        echo json_encode(["success" => false, "error" => "Cliente no encontrado."]);
    }
} else {
    // No se recibió el parámetro 'identificacion'
    echo json_encode(["success" => false, "error" => "Falta el parámetro de identificación."]);
}

// Cerrar la conexión
$conexion->close();
?>

