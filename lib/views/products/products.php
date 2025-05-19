<?php
require '../shared/header/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecciona tu plan</title>
    <!-- Tu CSS de header, footer y el de los planes -->
    <link rel="stylesheet" href="../shared/header/header.css">
    <link rel="stylesheet" href="../shared/footer/footer.css">
    <link rel="stylesheet" href="products.css">

<script>
  window.isLoggedIn = <?php echo isset($_SESSION['users']) || isset($_SESSION['employees']) || isset($_SESSION['admin']) ? 'true' : 'false'; ?>;
</script>
<script src="actions.js"></script>
</head>
<body>

  <!-- CONTENIDO PRINCIPAL: selección de planes -->
  <div id="main-content" class="planes-container">
    <h2 class="planes-title">Elige tu plan</h2>
    <div class="planes">
      <!-- PREMIUM -->
      <label class="plan-card plan-card--popular">
        <input type="radio" name="plan" value="premium" />
        <div class="plan-header">
          <h3>Premium</h3>
          <p>18 GB</p>
          <span class="checkmark">✔</span>
        </div>
        <ul class="plan-features">
          <li><strong>Precio mensual:</strong> $30.000 COP</li>
          <li><strong>Vigencia de:</strong> 30 dias</li>
          <li><strong>Navegación:</strong> 18 GB</li>
        </ul>
      </label>

      <!-- PRO -->
      <label class="plan-card">
        <input type="radio" name="plan" value="pro" />
        <div class="plan-header">
          <h3>Pro</h3>
          <p>8.5 GB</p>
          <span class="checkmark">✔</span>
        </div>
        <ul class="plan-features">
          <li><strong>Precio mensual:</strong> $15.000 COP</li>
          <li><strong>Vigencia de:</strong> 15 dias</li>
          <li><strong>Navegación:</strong> 8.5 GB</li>
        </ul>
      </label>

      <!-- AVANZADO -->
      <label class="plan-card">
        <input type="radio" name="plan" value="avanzado" />
        <div class="plan-header">
          <h3>Avanzado</h3>
          <p>3.5 GB</p>
          <span class="checkmark">✔</span>
        </div>
        <ul class="plan-features">
          <li><strong>Precio mensual:</strong> 10.000 COP</li>
          <li><strong>Vigencia de:</strong> 10 dias</li>
          <li><strong>Navegación:</strong> 3.5 GB</li>
        </ul>
      </label>

      <!-- ESENCIAL -->
      <label class="plan-card">
        <input type="radio" name="plan" value="esencial" />
        <div class="plan-header">
          <h3>Esencial</h3>
          <p>2 GB</p>
          <span class="checkmark">✔</span>
        </div>
        <ul class="plan-features">
          <li><strong>Precio semanal:</strong> $7.000 COP</li>
          <li><strong>Vigencia de:</strong> 7 dias</li>
          <li><strong>Navegación:</strong> 2 GB</li>
        </ul>
      </label>

      <!-- BÁSICO -->
      <label class="plan-card">
        <input type="radio" name="plan" value="basico" />
        <div class="plan-header">
          <h3>Básico</h3>
          <p>200 MEGAS</p>
          <span class="checkmark">✔</span>
        </div>
        <ul class="plan-features">
          <li><strong>Precio diario:</strong> $1.000 COP</li>
          <li><strong>Vigencia de:</strong> 1 dia</li>
          <li><strong>Navegación:</strong> 200 MEGAS </li>
        </ul>
      </label>
    </div>
  </div>

  <!-- Sección informativa + botón -->
<div class="planes-footer">
  <p class="nota">
    La disponibilidad del contenido en HD (720p), Full HD (1080p), Ultra HD (4K) y HDR depende de tu servicio de internet y del dispositivo en uso. No todo el contenido está disponible en todas las resoluciones. Consulta nuestros <a href="#">Términos de uso</a> para obtener más información.
  </p>
  <p class="nota">
    Solo las personas que vivan contigo pueden usar tu cuenta. Puedes ver Netflix en 4 dispositivos al mismo tiempo con el plan Premium, en 2 con el plan Estándar y en 1 con el plan Básico.
  </p>
  <p class="nota">
    Los eventos en vivo se incluyen en todos los planes de Netflix y contienen anuncios.
  </p>

<div class="boton-siguiente-container">
  <button id="btn-siguiente" class="boton-siguiente">
    Siguiente
  </button>
</div>

</div>
</div>

<?php
require '../shared/footer/footer.php';
?>
</body>
</html>
