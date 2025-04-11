<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>PINESNET</title>
    <link rel="icon" href="/assets/images/logo.jpg" type="image/png">
    <link rel="stylesheet" href="register.css">
</head>

<body>

    <div class="register-container">
        <div class="register-box">
            <a href="/index.php">
                <img src="/assets/images/exit.png"" alt="Cerrar" class="close">
            </a>
            <h2>Iniciar sesión</h2>
            <p class="no-underline">¿Ya tienes una cuenta? <a href="../login/login.php" class="login-link">Inicia sesión</a></p>

            <form id="login-form" method="POST" action="/config/register-users-databases.php">
                <div class="textbox">
                    <label for="Identificacion">Número de identificación</label>
                    <input type="text" id="identificacion" name="identificacion" required>
                </div>
                <div class="textbox">
                    <label for="Nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="textbox">
                    <label for="Apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" required>
                </div>
                <div class="textbox">
                    <label for="correo">Correo Electronico</label>
                    <input type="email" id="correo" name="correo" required>
                </div>
                <div class="textbox">
                    <label for="telefono">Telefono</label>
                    <input type="number" id="telefono" name="telefono" required>
                </div>
                <div class="textbox">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>
                <a href="#" class="forgot no-underline">¿Olvidaste la contraseña?</a>
                <input type="submit" class="btn" value="crear una cuenta">
            </form>
        </div>
    </div>
</body>

</html>