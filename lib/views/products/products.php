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
                <h1>Productos</h1>

                <div class="producto" data-nombre="1 Dia - Alta Velocidad" data-precio="1.000">
                    <p> 1 Dia - Alta Velocidad</p>
                    <p> ------------</p>
                    <p>Precio: $1.000</p>
                    <button class="add-to-cart">Añadir al carrito</button>
                </div>
                <div class="producto" data-nombre="7 Dia - Internet Prepagado" data-precio="7.000">
                    <p>7 Dia - Internet Prepagado</p>
                    <p> ------------</p>
                    <p>Precio: $7.000</p>
                    <button class="add-to-cart">Añadir al carrito</button>
                </div>
                <div class="producto" data-nombre="10 Dia - Seguridad Avanzada" data-precio="10.000">
                    <p>10 Dia - Seguridad Avanzada</p>
                    <p> ------------</p>
                    <p>Precio: $10.000</p>
                    <button class="add-to-cart">Añadir al carrito</button>
                </div>
                <div class="producto" data-nombre="15 Dia - Todo incluido" data-precio="15.000">
                    <p>15 Dia - Todo incluido</p>
                    <p> ------------</p>
                    <p>Precio: $15.000</p>
                    <button class="add-to-cart">Añadir al carrito</button>
                </div>
                <div class="producto" data-nombre="30 Dia - Eficiencia al limite" data-precio="30.000">
                    <p>30 Dia - Eficiencia al limite</p>
                    <p> ------------</p>
                    <p>Precio: $30.000</p>
                    <button class="add-to-cart">Añadir al carrito</button>
                </div>
            </section>

            <!-- Sección del Carrito de Compras (ahora a la derecha) -->
            <section id="carrito">
                <h2>Carrito de Compras</h2>
                <div id="lista-carrito">
                    <img src="/assets/images/vacio.png" alt="carrito vacío" class="carrito-vacio-img">
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
