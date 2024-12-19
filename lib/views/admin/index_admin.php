<?php

require '../shared/header/header.php';

if(!isset($_SESSION['admin']) || $_SESSION['admin']['rol'] != 'Administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta p�gina.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SISTEL</title>
    <link rel="stylesheet" href="../shared/header/header.css">
</head>
<body>

<a href="manage_admin/manage_admin.php">Gestionar administradores</a><br></br>
<a href="manage_users/manage_users.php">Gestionar clientes</a><br></br>
<a href="manage_sales/manage_sales.php">Ventas</a><br></br>

</body>
</html>