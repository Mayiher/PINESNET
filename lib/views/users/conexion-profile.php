<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

if (!isset($conexion) || $conexion->connect_errno) {
    die('Error al conectar con la base de datos: ' 
        . ($conexion->connect_error ?? 'Conexión no inicializada'));
}
