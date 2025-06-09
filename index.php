<?php
require 'lib/views/shared/header/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PINESNET</title>

  <!-- Fuente Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">

  <!-- Estilos -->
  <link rel="stylesheet" href="lib/views/shared/header/header.css">
  <link rel="stylesheet" href="lib/views/shared/footer/footer.css">
  <link rel="stylesheet" href="lib/views/home/styles.css">
</head>
<body>

  <!-- ======================== HERO / CAROUSEL ======================== -->
  <section id="inicio">
    <div class="carousel">
      <button class="prev" type="button">&#10094;</button>
      <button class="next" type="button">&#10095;</button>

      <div class="carousel-inner">
        <div class="carousel-item slide-1">
          <img src="assets/images/imagen1.png" alt="Imagen 1">
          <div class="slide-content">
            <h2>Bienvenida</h2>
            <p>Evita la falta de acceso a internet y disfruta nuestros servicios.</p>
            <a href="#informacion" class="btn-slide">Conócenos</a>
          </div>
        </div>

        <div class="carousel-item slide-2">
          <img src="assets/images/imagen2.png" alt="Imagen 2">
          <div class="slide-content">
            <h2>Oferta Especial</h2>
            <p>Internet prepagado a tu medida.</p>
            <a href="#ofertas" class="btn-slide">Ver ofertas</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <hr class="section-separator">

  <!-- ============ SECCIÓN “¿Qué ofrecemos?” ============ -->
  <section id="informacion">
    <h2 class="titulo-ofertas">¿Qué ofrecemos?</h2>
    <div class="offer-container">
      <div class="offer-item altavel">
        <img src="assets/images/alta-velocidad.png" alt="Ícono Alta Velocidad" class="offer-icon">
        <span class="offer-text">Alta velocidad</span>
      </div>
      <div class="offer-item internet">
        <img src="assets/images/internet.png" alt="Ícono Internet Prepagado" class="offer-icon">
        <span class="offer-text">Internet prepagado</span>
      </div>
      <div class="offer-item seguridad">
        <img src="assets/images/seguridad.png" alt="Ícono Seguridad" class="offer-icon">
        <span class="offer-text">Seguridad</span>
      </div>
    </div>
  </section>

  <?php require 'lib/views/shared/footer/footer.php'; ?>
  <script src="lib/views/home/script.js"></script>
</body>
</html>
