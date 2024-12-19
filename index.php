
<?php
require 'lib/views/shared/header/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PINESNET</title>
  <link rel="stylesheet" href="lib/views/shared/header/header.css">
  <link rel="stylesheet" href="lib/views/shared/footer/footer.css">
  <link rel="stylesheet" href="lib/views/home/styles.css">

</head>
<body>

    <section id="inicio">
        <div class="carousel">
            <div class="carousel-inner">
                <img class="active" alt="Imagen 1" src="assets/images/imagen1.webp" />
                <img alt="Imagen 2" src="assets/images/imagen2.jpg" />
                <img alt="Imagen 3" src="assets/images/imagen3.jpg" />
                <img alt="Imagen 4" src="assets/images/imagen4.jpg" />
            </div>
            <button class="prev" onclick="prevSlide()">&#10094;</button>
            <button class="next" onclick="nextSlide()">&#10095;</button>
        </div>
    </section>

    <section id="informacion">
        <div class="info">
            <h2>Alta Velocidad</h2>
            <p>Descripción de alta velocidad...</p>
        </div>
        <div class="info">
            <h2>Internet Prepagado</h2>
            <p>Descripción de internet prepagado...</p>
        </div>
        <div class="info">
            <h2>Seguridad</h2>
            <p>Descripción de seguridad...</p>
        </div>
    </section>

    <?php
    require 'lib/views/shared/footer/footer.php';
    ?>  
    
  <script src="lib/views/home/script.js"></script>
</body>
</html>

