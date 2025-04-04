<?php
require '../shared/header/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="../shared/header/header.css">
    <link rel="stylesheet" href="../shared/footer/footer.css">
    <link rel="stylesheet" href="products.css">
</head>
<body>

        <!-- Contenedor principal -->
        <div id="main-content">
            <!-- Sección de Productos (ahora a la izquierda) -->
            <section id="productos">
                <h2>Productos</h2>
                <div class="producto" data-nombre="Paquete 1 - Alta Velocidad" data-precio="100">
                    <p>Paquete 1 - Alta Velocidad</p>
                    <p>Precio: $100</p>
                    <button class="add-to-cart">Añadir al carrito</button>
                </div>
                <div class="producto" data-nombre="Paquete 2 - Internet Prepagado" data-precio="200">
                    <p>Paquete 2 - Internet Prepagado</p>
                    <p>Precio: $200</p>
                    <button class="add-to-cart">Añadir al carrito</button>
                </div>
                <div class="producto" data-nombre="Paquete 3 - Seguridad Avanzada" data-precio="300">
                    <p>Paquete 3 - Seguridad Avanzada</p>
                    <p>Precio: $300</p>
                    <button class="add-to-cart">Añadir al carrito</button>
                </div>
            </section>

            <!-- Sección del Carrito de Compras (ahora a la derecha) -->
            <section id="carrito">
                <h2>Carrito de Compras</h2>
                <div id="lista-carrito">
                    <p>Tu carrito está vacío.</p>
                </div>
                <div id="total-carrito">
                    <p>Total: $0</p>
                    <button id="pagar">Pagar</button>
                </div>
            </section>
        </div>

    <?php
    require '../shared/footer/footer.php';
    ?>  
        <script src="carrito.js"></script>
    </body>
</html>
