<?php
session_start();
if (isset($_SESSION['users'])) {
    header("Location: /index.php");
    exit;
} elseif (isset($_SESSION['admin'])) {
    header("Location: ../admin/index_admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pinesnet - Login & Register</title>
  <link rel="stylesheet" href="login-register.css">
  <link rel="icon" href="/assets/images/logo.jpg" type="image/png">
</head>
<body>
  <div class="lr-container">
    <img src="/assets/images/logo_login_register.png" alt="Logo PinesNet" class="lr-logo">
    <div class="lr-box">
      <a href="/index.php">
        <img src="/assets/images/exit.png" alt="Cerrar" class="close-btn">
      </a>

      <div class="lr-header">
        <button class="tab active" onclick="showForm('login')">Inicia sesión</button>
        <button class="tab" onclick="showForm('register')">Registrarse</button>
      </div>

      <div class="lr-body">
        <!-- Login -->
        <form id="login-form" class="lr-form" method="POST" action="/config/users-databases.php">
          <h2>¡Hola de nuevo!</h2>
          <p>Nos alegra verte otra vez</p>

          <input type="email" name="correo" placeholder="Correo electrónico" required>
          <input type="password" name="contrasena" placeholder="Contraseña" required>

          <label><input type="checkbox" name="remember"> Recuérdame</label>

          <input type="submit" class="lr-btn" value="Iniciar sesión">

          <div class="or-divider">o continua con</div>

          <div class="social-login">
            <button type="button" class="facebook">Facebook</button>
            <button type="button" class="google">Google</button>
            <button type="button" class="apple">Apple</button>
          </div>
        </form>

        <!-- Registro -->
        <form id="register-form" class="lr-form hidden" method="POST" action="/config/register-users-databases.php">
          <h2>Regístrate</h2>
          <p>Crea tu cuenta gratuita</p>

          <input type="text" name="identificacion" placeholder="Número de identificación" required>
          <input type="text" name="nombre" placeholder="Nombre" required>
          <input type="text" name="apellido" placeholder="Apellido" required>
          <input type="email" name="correo" placeholder="Correo electrónico" required>
          <input type="number" name="telefono" placeholder="Teléfono" required>

          <!-- Select Género estilizado como los inputs -->
          <select name="genero" required>
            <option value="" disabled selected>Selecciona tu género</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
          </select>

          <input type="password" name="contrasena" placeholder="Contraseña" required>
          <input type="submit" class="lr-btn" value="Crear una cuenta">
        </form>
      </div>
    </div>
  </div>

  <script src="login-register.js"></script>
</body>
</html>
