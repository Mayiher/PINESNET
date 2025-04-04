<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesi�n</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <!-- Barra de navegaci�n -->
    <header>
        <div class="logo">
            <h1>PINESNET</h1>
        </div>
        <nav>
            <ul id="navMenu">
                <li><a href="index.html">Inicio</a></li>
                <li><a href="productos.html">Productos</a></li>
                <li><a href="perfil.html">Perfil</a></li>
                <li><a href="login.html">Iniciar Sesi�n</a></li>
            </ul>
        </nav>
    </header>

    <!-- Contenido de recuperacion de contrase�a -->
    <div class="login-container">
        <div class="login-box">
            <h2>Recuperar contrase�a</h2>

            <form id="login-form" method="POST" action="">
                <div class="textbox">
                    <label for="correo">Email</label>
                    <input type="email" id="correo" name="correo" required>
                </div>
                <input type="submit" class="btn" value="Enviar enlace de restablecimiento">
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 PINESNET</p>
    </footer>

    <script src="script.js"></script>

</body>
</html>
