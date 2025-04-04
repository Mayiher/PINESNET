<?php

session_start();

if(isset($_SESSION['users'])){
    header("location: /index.php");
} elseif(isset($_SESSION['admin'])){
    header("location: ../admin/index_admin.php");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PINESNET</title>
    <link rel="icon" href="/assets/images/logo.jpg" type="image/png">
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="login-container">
        <div class="login-box">
            <a href="/index.php">
                <img src="/assets/images/exit.png" alt="Cerrar" class="close">
            </a>

            <h2>Iniciar sesión</h2>
            <p class="register-link">¿Eres nuevo en este sitio? <a href="../register/register.php" class="no-underline">Regístrate</a></p>
            
            <form id="login-form" method="POST" action="/config/users-databases-local.php">
                <div class="textbox">
                    <label for="correo">Email</label>
                    <input type="email" id="correo" name="correo" required>
                </div>
                <div class="textbox">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>
                <a href="../recovery_password/recovery_password.php" class="forgot no-underline">¿Olvidaste la contraseña?</a>
                <input type="submit" class="btn" value="Iniciar sesión">
            </form>
        </div>
    </div>
</body>
</html>
