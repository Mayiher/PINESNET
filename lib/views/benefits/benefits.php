<?php
require '../../../lib/views/shared/header/header.php';
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
  <link rel="stylesheet" href="../../../lib/views/shared/header/header.css">
  <link rel="stylesheet" href="../../../lib/views/shared/footer/footer.css">
  <link rel="stylesheet" href="benefits.css">
</head>
<body>

  <!-- ======================== HERO / CAROUSEL ======================== -->
  <section id="inicio">
    <div class="carousel">
        <!-- 
      <button class="prev" type="button">&#10094;</button>
      <button class="next" type="button">&#10095;</button>
      -->

      <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item slide-1">
          <img src="/assets/images/benefits/image1.png" alt="Imagen 1">

          <!-- Texto izquierdo -->
          <div class="hero-text">
            <h1 class="hero-text__title">PINESNET</h1>
            <p class="hero-text__subtitle">
              La plataforma más rápida y segura para comprar y recargar pines de internet al instante.
            </p>
          </div>

          <!-- Panel derecho -->
          <div class="info-panel">
            <div class="info-panel__icon">
              <img src="/assets/images/benefits/question.png" alt="Pregunta">
            </div>
            <div class="info-panel__text">
              <p>¡Sin apps, sin complicaciones!<br>
                 Solo eliges, pagas y ¡disfrutas!</p>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
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

  <section id="beneficios" class="benefits-section">
  
  <div class="benefits-header">
    <h2 class="benefits-title">Beneficios</h2>
    <p class="benefits-subtitle">¡Somos importantes para ti!</p>
  </div>

  <div class="benefits-grid">

    <div class="benefit-card">
      <img src="/assets/images/benefits/velocidad.png" alt="Velocidad Extrema">
      <div class="card-content">
        <h3 class="card-title">VELOCIDAD EXTREMA</h3>
        <p class="card-description">
          Recibe tu PIN de internet en menos de 1 minuto tras pagar.
          Recargas automáticas sin trámites ni esperas.
        </p>
      </div>
    </div>

    <div class="benefit-card">
      <img src="/assets/images/benefits/facil.png" alt="Fácil para todos">
      <div class="card-content">
        <h3 class="card-title">FÁCIL PARA TODOS</h3>
        <p class="card-description">
          Compra en 3 clics desde cualquier dispositivo.
          Sin apps necesarias: ¡Funciona directo en tu navegador!
        </p>
      </div>
    </div>

    <div class="benefit-card">
      <img src="/assets/images/benefits/transparencia.png" alt="Transparencia Total">
      <div class="card-content">
        <h3 class="card-title">TRANSPARENCIA TOTAL</h3>
        <p class="card-description">
          Historial de compras claro (siempre visible).
          Sin costos ocultos: El precio que ves es el final.
        </p>
      </div>
    </div>

  </div>
</section>

  <hr class="section-separator">

<?php require '../../../lib/views/shared/footer/footer.php'; ?>
</body>
</html>
