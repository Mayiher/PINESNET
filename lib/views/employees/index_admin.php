<?php

require '../shared/header/header.php';

// Verificamos que exista la sesión de administrador y que su rol sea "administrador"
if (!isset($_SESSION['admin']) || empty($_SESSION['admin']) || strtolower($_SESSION['admin']['rol']) !== 'administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}

$adminData = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SISTEL</title>
    <link rel="stylesheet" href="../shared/header/header.css">
</head>
<body>

    <a href="manage_admin/manage_admin.php">Gestionar administradores</a><br><br>
    <a href="manage_users/manage_users.php">Gestionar clientes</a><br><br>
    <a href="manage_sales/manage_sales.php">Ventas</a><br><br>

</body>
</html>
