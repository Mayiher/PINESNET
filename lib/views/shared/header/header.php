<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PINESNET</title>
    <link rel="icon" href="/assets/images/logo.jpg" type="image/png">
    <link rel="stylesheet" href="header.css">
</head>
<body>

    <!-- Barra superior -->
    <div class="top-bar">
        <!-- Logo y barra de búsqueda -->
        <div class="logo-search-container">
            <img src="/assets/images/logo.jpg" alt="Logo" class="logo">
        </div>

        <!-- Iconos a la derecha -->
        <div class="icons">
            <?php
            // Inicializamos variables
            $isAdmin = false;
            $nombre = '';
            $apellido = '';
            $cartCount = 0; // Inicializamos el contador del carrito

            // Verificamos si el usuario es administrador
            if (isset($_SESSION['admin'])) {
                $isAdmin = $_SESSION['admin']['rol'] == 'Administrador';
                $nombre = isset($_SESSION['admin']['nombre']) ? $_SESSION['admin']['nombre'] : '';
                $apellido = isset($_SESSION['admin']['apellido']) ? $_SESSION['admin']['apellido'] : '';
            }
            // Verificamos si el usuario es normal
            elseif (isset($_SESSION['users'])) {
                $nombre = isset($_SESSION['users']['nombre']) ? $_SESSION['users']['nombre'] : '';
                $apellido = isset($_SESSION['users']['apellido']) ? $_SESSION['users']['apellido'] : '';
                // Si el usuario tiene un carrito guardado en sesión, calculamos el número de productos
                $cartCount = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
            }

            // Si es un administrador
            if ($isAdmin) {
            ?>
                <div class="dropdown-users">
                    <a href="#"><span class="icon"><img src="/assets/images/usuario.png" alt=""></span> <?php echo $nombre . ' ' . $apellido; ?></a>
                    <div class="dropdown-content-users">
                        <a href="/lib/views/users/perfil.php">Perfil</a>
                        <a href="/lib/views/users/sign-out.php">Cerrar sesión</a>
                    </div>
                </div>
                <a href="/lib/views/admin/index_admin.php"><span class="icon"><img src="/assets/images/admin.png" alt=""></span> Administración</a>
            <?php
            } else {
                // Si no es administrador, mostramos el nombre de usuario y opciones
                if (!empty($nombre)) {
            ?>
                <div class="dropdown-users">
                    <a href="#"><span class="icon"><img src="/assets/images/usuario.png" alt=""></span> <?php echo $nombre . ' ' . $apellido; ?></a>
                    <div class="dropdown-content-users">
                        <a href="/lib/views/users/perfil.php">Perfil</a>
                        <a href="/lib/views/users/sign-out.php">Cerrar sesión</a>
                    </div>
                </div>
            <?php
                } else {
                    // Si no hay usuario, mostramos el enlace de "Entrar"
            ?>
                <a href="/lib/views/auth/login/login.php"><span class="icon"><img src="/assets/images/usuario.png" alt=""></span> Entrar</a>
            <?php
                }

                // Mostramos el carrito para usuarios no administradores
                if (!$isAdmin) {
            ?>
                <a href="/src/carrito.php"><span class="icon"><img src="/assets/images/carrito-de-compras.png" alt=""></span> Carrito (<?php echo $cartCount; ?>)</a>
            <?php
                }

                // Enlace de favoritos solo para usuarios normales
                if (!$isAdmin) {
            ?>
                <a href="#"><span class="icon"><img src="/assets/images/favorito.png" alt=""></span> Favoritos</a>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Menú de navegación -->
    <ul class="nav-menu">
        <li><a href="/index.php">Inicio</a></li>
        <li><a href="/lib/views/products/products.php">Productos</a></li>
    </ul>

</body>
</html>
