<?php 
require '../../../shared/header/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro de Administrador</title>
    <link rel="stylesheet" href="../../../shared/header/header.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/es.css">
</head>
<body id="page-top">

<form action="../includes/validar.php" method="POST">
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <br>
                        <br>
                        <h3 class="text-center">Registro de nuevo administrador</h3>
                        <div class="form-group">
                            <label for="identificacion">Identificación *</label><br>
                            <input type="number" name="identificacion" id="identificacion" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido" class="form-label">Apellido *</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="correo" class="form-label">Correo *</label>
                            <input type="email" id="correo" name="correo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono *</label><br>
                            <input type="number" name="telefono" id="telefono" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena" class="form-label">Contraseña *</label>
                            <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                        </div>
                        <!-- Campo de rol de solo lectura, asignado por defecto a "Administrador" -->
                        <div class="form-group">
                            <label for="rol" class="form-label">Rol de usuario *</label>
                            <input type="text" id="rol" name="rol" class="form-control" value="administrador" readonly>
                        </div>
                        <br>
                        <div class="mb-3">
                            <input type="submit" value="Guardar" class="btn btn-success" name="registrar">
                            <a href="../../index_admin.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</body>
</html>
