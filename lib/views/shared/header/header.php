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

<?php
    $loggedIn = isset($_SESSION['users']) || isset($_SESSION['employees']) || isset($_SESSION['admin']);
?>
<script>
    const isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
</script>

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
            $isEmployee = false;  // Indicará si se ha iniciado sesión como empleado
            $isAdmin = false;     // Indicará si el empleado tiene rol de administrador
            $nombre = '';
            $apellido = '';
            $cartCount = 0;       // Contador del carrito

            // Revisamos si existe sesión para empleado en 'employees' o 'admin'
            if (isset($_SESSION['employees']) && !empty($_SESSION['employees'])) {
                $sessionData = $_SESSION['employees'];
                $isEmployee = true;
            } elseif (isset($_SESSION['admin']) && !empty($_SESSION['admin'])) {
                $sessionData = $_SESSION['admin'];
                $isEmployee = true;
            } elseif (isset($_SESSION['users']) && !empty($_SESSION['users'])) {
                $sessionData = $_SESSION['users'];
            } else {
                $sessionData = [];
            }

            if (!empty($sessionData)) {
                $nombre = $sessionData['nombre'] ?? '';
                $apellido = $sessionData['apellido'] ?? '';
                if ($isEmployee) {
                    // Verificamos el rol del empleado (convertimos a minúsculas para evitar problemas)
                    $isAdmin = (isset($sessionData['rol']) && strtolower($sessionData['rol']) === 'administrador');
                } else {
                    // Si es usuario normal, obtenemos el contador del carrito
                    $cartCount = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
                }
            }

            // Si se detecta un empleado, se muestra su nombre y, si es administrador, el enlace de administración
            if ($isEmployee) {
            ?>
                <div class="dropdown-users">
                    <a href="#">
                        <span class="icon"><img src="/assets/images/usuario.png" alt=""></span>
                        <?php echo $nombre . ' ' . $apellido; ?>
                    </a>
                    <div class="dropdown-content-users">
                        <a href="/lib/views/users/perfil.php">Perfil</a>
                        <a href="/lib/views/users/sign-out.php">Cerrar sesión</a>
                    </div>
                </div>
                <?php if ($isAdmin): ?>
                    <a href="/lib/views/employees/index_admin.php">
                        <span class="icon"><img src="/assets/images/admin.png" alt=""></span> Administración
                    </a>
                <?php endif; ?>
            <?php
            } else {
                // Si es usuario normal o no hay sesión
                if (!empty($nombre)) {
            ?>
                <div class="dropdown-users">
                    <a href="#">
                        <span class="icon"><img src="/assets/images/usuario.png" alt=""></span>
                        <?php echo $nombre . ' ' . $apellido; ?>
                    </a>
                    <div class="dropdown-content-users">
                        <a href="/lib/views/users/perfil.php">Perfil</a>
                        <a href="/lib/views/users/sign-out.php">Cerrar sesión</a>
                    </div>
                </div>
            <?php
                } else {
            ?>
                <a href="/lib/views/auth/login/login.php">
                    <span class="icon"><img src="/assets/images/usuario.png" alt=""></span> Entrar
                </a>
            <?php
                }
            ?>
                <a href="/src/carrito.php">
                    <span class="icon"><img src="/assets/images/carrito-de-compras.png" alt=""></span> Carrito (<?php echo $cartCount; ?>)
                </a>
                <a href="#">
                    <span class="icon"><img src="/assets/images/favorito.png" alt=""></span> Favoritos
                </a>
            <?php
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
