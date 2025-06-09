<?php
session_start();

// 1) ¿Hay usuario logueado?
$isLogged = isset($_SESSION['users']) && !empty($_SESSION['users']);

// 2) Datos por defecto
$nombre   = '';
$apellido = '';
$isAdmin  = false;

// 3) Si hay sesión, extraemos datos y rol
if ($isLogged) {
    $sessionData = $_SESSION['users'];
    $nombre      = $sessionData['nombre']   ?? '';
    $apellido    = $sessionData['apellido'] ?? '';
    $rolRaw      = $sessionData['rol']      ?? '';

    // Normalizamos a minúsculas y comprobamos
    $rol = strtolower($rolRaw);
    if ($rol === 'administrator') {
        $isAdmin = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PINESNET</title>
    <link rel="icon" href="/assets/images/logo2.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/header.css">
    <script>
        window.isLoggedIn = <?php echo $isLogged ? 'true' : 'false'; ?>;
    </script>
</head>
<body>
    <header class="main-header">

        <!-- IZQUIERDA: Logo -->
        <div class="header-left">
            <a href="/index.php">
                <img src="/assets/images/logo.png" alt="Pinesnet Logo" class="logo">
            </a>
        </div>

        <!-- CENTRO: Menú -->
        <nav class="nav-center">
            <ul class="nav-menu">
                <li><a href="/index.php" class="nav-link">Inicio</a></li>
                <li><a href="/lib/views/benefits/benefits.php" class="nav-link">Beneficios</a></li>
                <li><a href="/lib/views/products/products.php" class="nav-link">Pines o paquetes</a></li>
            </ul>
        </nav>

        <!-- DERECHA: Acceder / Usuario -->
        <div class="header-right">
            <?php if (!$isLogged): ?>
                <a href="/lib/views/auth/login-register/login-register.php" class="btn-login">
                    <img src="/assets/images/logo-login.png" alt="Icono Usuario" class="btn-icon">
                    <span class="btn-text">Acceder</span>
                </a>
            <?php else: ?>
                <?php if ($isAdmin): ?>
                    <!-- Solo administrador ve ajustes -->
                    <a href="/lib/views/employees/index_admin.php" class="settings-link">
                        <img src="/assets/images/admin.png" alt="Admin" class="icon-img-logged">
                    </a>
                <?php endif; ?>

                <div class="dropdown-users-logged">
                    <div class="user-link-logged">
                        <img src="/assets/images/usuario.png" alt="Usuario" class="user-icon-logged">
                        <span class="user-name"><?php echo htmlspecialchars("$nombre $apellido"); ?></span>
                    </div>
                    <div class="dropdown-content-users-logged">
                        <a href="/lib/views/users/profile.php">Perfil</a>
                        <a href="/lib/views/users/sign-out.php">Cerrar sesión</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </header>
</body>
</html>
