<?php
require '../../../lib/views/shared/header/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PINESNET</title>

  <!-- Fuente Inter y Instrument Sans -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.example.com/fonts/instrument-sans.css" rel="stylesheet">

  <!-- Estilos -->
  <link rel="stylesheet" href="../../../lib/views/shared/header/header.css">
  <link rel="stylesheet" href="../../../lib/views/shared/footer/footer.css">
  <link rel="stylesheet" href="products.css">

    <script src="actions.js"></script>
</head>
<body>

  <!-- HERO / CAROUSEL -->
  <section id="inicio">
    <div class="carousel">
      <div class="carousel-inner">
        <div class="carousel-item slide-1 active">
          <img src="/assets/images/banner-activar-pin.png" alt="Imagen 1">
        </div>
      </div>
    </div>
  </section>

  <hr class="section-separator">

  <!-- SELECCIÓN DE PLANES -->
  <div id="main-content" class="planes-container">
    <h2 class="planes-title">Elige tu plan preferido</h2>
    <div class="planes">
      <!-- Premium -->
      <label class="plan-card plan-card--premium">
        <input type="radio" name="plan" value="premium" />
        <div class="plan-header plan-header--premium">
          <h3>Premium</h3><p>18 GB</p><span class="checkmark">✔</span>
        </div>
        <ul class="plan-features">
          <li><strong>Precio mensual:</strong> $30.000 COP</li>
          <li><strong>Vigencia:</strong> 30 días</li>
          <li><strong>Navegación:</strong> 18 GB</li>
        </ul>
      </label>
      <!-- Pro -->
      <label class="plan-card plan-card--pro">
        <input type="radio" name="plan" value="pro" />
        <div class="plan-header plan-header--pro">
          <h3>Pro</h3><p>8.5 GB</p><span class="checkmark">✔</span>
        </div>
        <ul class="plan-features">
          <li><strong>Precio mensual:</strong> $15.000 COP</li>
          <li><strong>Vigencia:</strong> 15 días</li>
          <li><strong>Navegación:</strong> 8.5 GB</li>
        </ul>
      </label>
      <!-- Avanzado -->
      <label class="plan-card plan-card--avanzado">
        <input type="radio" name="plan" value="avanzado" />
        <div class="plan-header plan-header--avanzado">
          <h3>Avanzado</h3><p>3.5 GB</p><span class="checkmark">✔</span>
        </div>
        <ul class="plan-features">
          <li><strong>Precio mensual:</strong> $10.000 COP</li>
          <li><strong>Vigencia:</strong> 10 días</li>
          <li><strong>Navegación:</strong> 3.5 GB</li>
        </ul>
      </label>
      <!-- Esencial -->
      <label class="plan-card plan-card--esencial">
        <input type="radio" name="plan" value="esencial" />
        <div class="plan-header plan-header--esencial">
          <h3>Esencial</h3><p>2 GB</p><span class="checkmark">✔</span>
        </div>
        <ul class="plan-features">
          <li><strong>Precio semanal:</strong> $7.000 COP</li>
          <li><strong>Vigencia:</strong> 7 días</li>
          <li><strong>Navegación:</strong> 2 GB</li>
        </ul>
      </label>
      <!-- Básico -->
      <label class="plan-card plan-card--basico">
        <input type="radio" name="plan" value="basico" />
        <div class="plan-header plan-header--basico">
          <h3>Básico</h3><p>200 MB</p><span class="checkmark">✔</span>
        </div>
        <ul class="plan-features">
          <li><strong>Precio diario:</strong> $1.000 COP</li>
          <li><strong>Vigencia:</strong> 1 día</li>
          <li><strong>Navegación:</strong> 200 MB</li>
        </ul>
      </label>
    </div>
  </div>

  <!-- TÉRMINOS Y BOTÓN SIGUIENTE -->
  <div class="planes-footer">
    <div class="terminos-container">
      <a href="#" class="terminos-link">Términos y condiciones</a>
    </div>
    <div class="boton-siguiente-container">
      <button id="btn-siguiente" class="boton-siguiente">Siguiente</button>
    </div>
  </div>

<?php
require '../../../lib/views/shared/footer/footer.php';
?>
</body>
</html>
