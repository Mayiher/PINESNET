<?php
// server-local.php

// Definir la constante DIRECT_EXECUTION si el archivo se está ejecutando directamente
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    define('DIRECT_EXECUTION', true);
}

try {
    // Define la ruta absoluta del archivo de base de datos en la carpeta /config
    $dbPath = $_SERVER['DOCUMENT_ROOT'] . '/config/pinesnetdatabases.db';
    // Conecta a la base de datos SQLite. Si no existe, se creará automáticamente en /config.
    $conexion = new SQLite3($dbPath);
} catch (Exception $e) {
    // Manejo de errores
    $fecha = date('Y-m-d H:i:s');
    file_put_contents('error_server_log.txt', $fecha . ' - ' . $e->getMessage() . "\n", FILE_APPEND);
    if (defined('DIRECT_EXECUTION')) {
        echo '<script>alert("No se ha podido conectar a la base de datos SQLite"); document.body.innerHTML = "";</script>';
    }
    exit;
}

// --------------------------------------------------------------------------------
// Crear la tabla 'users' si no existe
$sqlUsers = "CREATE TABLE IF NOT EXISTS users (
    identificacion TEXT NOT NULL,
    nombre TEXT NOT NULL,
    apellido TEXT NOT NULL,
    correo TEXT NOT NULL,
    telefono TEXT NOT NULL,
    contrasena TEXT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conexion->exec($sqlUsers)) {
    $fecha = date('Y-m-d H:i:s');
    file_put_contents('error_server_log.txt', $fecha . ' - Error al crear la tabla users: ' . $conexion->lastErrorMsg() . "\n", FILE_APPEND);
}

// --------------------------------------------------------------------------------
// Crear la tabla 'employees' si no existe
$sqlEmployees = "CREATE TABLE IF NOT EXISTS employees (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    identificacion TEXT,
    nombre TEXT NOT NULL,
    apellido TEXT NOT NULL,
    correo TEXT UNIQUE NOT NULL,
    telefono TEXT,
    contrasena TEXT NOT NULL,
    rol TEXT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conexion->exec($sqlEmployees)) {
    $fecha = date('Y-m-d H:i:s');
    file_put_contents('error_server_log.txt', $fecha . ' - Error al crear la tabla employees: ' . $conexion->lastErrorMsg() . "\n", FILE_APPEND);
}

// --------------------------------------------------------------------------------
// Crear la tabla 'sales' si no existe
$sqlSales = "CREATE TABLE IF NOT EXISTS sales (
    id_venta INTEGER PRIMARY KEY AUTOINCREMENT,
    id_usuario TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    subtotal INTEGER NOT NULL,
    total_iva INTEGER NOT NULL,
    descuento INTEGER DEFAULT 0,
    total INTEGER NOT NULL
)";
if (!$conexion->exec($sqlSales)) {
    $fecha = date('Y-m-d H:i:s');
    file_put_contents('error_server_log.txt', $fecha . ' - Error al crear la tabla sales: ' . $conexion->lastErrorMsg() . "\n", FILE_APPEND);
}

// --------------------------------------------------------------------------------
// Crear la tabla 'sales_details' si no existe
$sqlSalesDetails = "CREATE TABLE IF NOT EXISTS sales_details (
    id_detalle INTEGER PRIMARY KEY AUTOINCREMENT,
    id_venta INTEGER NOT NULL,
    codigo_producto TEXT NOT NULL,
    descripcion TEXT NOT NULL,
    cantidad INTEGER NOT NULL,
    precio_unitario INTEGER NOT NULL,
    bruto INTEGER NOT NULL,
    porcentaje_iva INTEGER NOT NULL,
    iva INTEGER NOT NULL,
    total INTEGER NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES sales(id_venta) ON DELETE CASCADE
)";
if (!$conexion->exec($sqlSalesDetails)) {
    $fecha = date('Y-m-d H:i:s');
    file_put_contents('error_server_log.txt', $fecha . ' - Error al crear la tabla sales_details: ' . $conexion->lastErrorMsg() . "\n", FILE_APPEND);
}

// Si se está ejecutando directamente este archivo en el navegador, muestra una alerta y redirige
if (defined('DIRECT_EXECUTION')) {
    echo '<script>
        alert("Conectado exitosamente a la base de datos SQLite y tablas creadas");
        window.onload = function() {
            setTimeout(function() {
                window.location = "/index.php";
            }, 0);
        };
    </script>';
}
?>
