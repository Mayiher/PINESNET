<?php
// transactional.php

require '../shared/header/header.php';

// 1) Configurar zona horaria
date_default_timezone_set('America/Bogota');

// 2) Obtener el precio y el plan desde GET
$precioBase = isset($_GET['price']) ? intval($_GET['price']) : 0;
$planKey    = isset($_GET['plan'])  ? $_GET['plan']        : '';

// 3) Generar ID de factura
function generarInvoiceId($length = 10) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $id = '';
    for ($i = 0; $i < $length; $i++) {
        $id .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $id;
}
$invoiceId = generarInvoiceId(10);

// 4) Fecha y hora para “Fecha de compra”
$fechaCompra = date('d F, Y H:i'); // instante de la compra

// 5) Detalles de planes y cálculo de fecha de expiración
$planes = [
    'premium'  => ['nombre'=>'Premium','gb'=>'18 GB','vigencia'=>'30 días','precio'=>30000],
    'pro'      => ['nombre'=>'Pro','gb'=>'8.5 GB','vigencia'=>'15 días','precio'=>15000],
    'avanzado' => ['nombre'=>'Avanzado','gb'=>'3.5 GB','vigencia'=>'10 días','precio'=>10000],
    'esencial' => ['nombre'=>'Esencial','gb'=>'2 GB','vigencia'=>'7 días','precio'=>7000],
    'basico'   => ['nombre'=>'Básico','gb'=>'200 MB','vigencia'=>'1 día','precio'=>1000],
];
$detallePlan = $planes[$planKey] ?? null;

if ($detallePlan) {
    // Extraer la cantidad de días de la cadena "X días"
    $vigenciaDias = intval($detallePlan['vigencia']);
    // Calcular fecha de expiración sumando esos días a la fecha actual
    $fechaExpiracion = date('d F, Y H:i', strtotime("+{$vigenciaDias} days"));
} else {
    $fechaExpiracion = '';
}

// 6) Calcular total
$comision = 1.99;
$total    = $precioBase + $comision;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resumen de Pago</title>
  <link rel="stylesheet" href="../shared/header/header.css">
  <link rel="stylesheet" href="../shared/footer/footer.css">
  <link rel="stylesheet" href="transactional.css">

  <!-- jsPDF y AutoTable (para PDF en cliente) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

  <!-- Datos que usará transactional.js -->
  <script>
    window.paymentData = {
      plan:             "<?php echo addslashes($detallePlan['nombre']   ?? ''); ?>",
      gb:               "<?php echo addslashes($detallePlan['gb']       ?? ''); ?>",
      vigencia:         "<?php echo addslashes($detallePlan['vigencia'] ?? ''); ?>",
      precioPlan:       <?php echo $detallePlan['precio']            ?? 0; ?>,
      precioBase:       <?php echo $precioBase; ?>,
      comision:         <?php echo $comision; ?>,
      total:            <?php echo $total; ?>,
      invoiceId:        "<?php echo $invoiceId; ?>",
      fechaCompra:      "<?php echo addslashes($fechaCompra); ?>",
      fechaExpiracion:  "<?php echo addslashes($fechaExpiracion); ?>"
    };
  </script>
</head>
<body>

<div class="wrapper">

  <!-- PANEL RESUMEN -->
  <div class="summary-panel">
    <?php if ($detallePlan): ?>
      <div class="plan-summary">
        <div class="plan-name"><?php echo htmlspecialchars($detallePlan['nombre']); ?></div>
        <ul class="plan-details">
          <li>Datos incluidos: <?php echo htmlspecialchars($detallePlan['gb']); ?></li>
          <li>Vigencia: <?php echo htmlspecialchars($detallePlan['vigencia']); ?></li>
          <li>Precio plan: $<?php echo number_format($detallePlan['precio'],0,',','.'); ?> COP</li>
        </ul>
        <hr>
      </div>
    <?php endif; ?>

    <div class="amount">$<?php echo number_format($precioBase,0,',','.'); ?> COP</div>
    <div class="line">
      <span class="label">Comisión</span>
      <span class="value">$<?php echo number_format($comision,2,',','.'); ?> COP</span>
    </div>
    <div class="line">
      <span class="label">Total a pagar</span>
      <span class="value total">$<?php echo number_format($total,2,',','.'); ?> COP</span>
    </div>
    <hr>
    <div class="info-item">
      <i class="far fa-file-alt"></i>
      <div class="info-text-block">
        <span class="small-label">ID de factura:</span>
        <span class="info-text"><?php echo $invoiceId; ?></span>
      </div>
    </div>
    <div class="info-item">
      <i class="far fa-calendar-alt"></i>
      <div class="info-text-block">
        <span class="small-label">Fecha de compra:</span>
        <span class="info-text"><?php echo $fechaCompra; ?></span>
      </div>
    </div>
    <div class="info-item">
      <i class="far fa-calendar-alt"></i>
      <div class="info-text-block">
        <span class="small-label">Fecha de expiración:</span>
        <span class="info-text"><?php echo $fechaExpiracion; ?></span>
      </div>
    </div>
    <div class="support">
      <div>
        <span>Soporte al cliente:</span><br>
        <span>chat en línea 24/7</span>
      </div>
      <button class="chat-btn"><i class="fas fa-comment-dots"></i></button>
    </div>
  </div>

  <!-- PANEL DE PAGO -->
  <div class="payment-panel">
    <div class="header">
      <h2>Métodos de pago</h2>
      <i class="fas fa-bars menu-icon"></i>
    </div>
    <div class="tabs">
      <button class="tab active" data-target="credit">Tarjeta de crédito</button>
      <button class="tab" data-target="mobile">Pago móvil</button>
      <a href="#" class="more">+ Más</a>
    </div>
    
    <div class="tab-content">
      <div id="credit" class="content active">
        <form id="paymentForm">
          <label class="field-label">Número de tarjeta</label>
          <div class="input-group">
            <input 
              type="text" 
              placeholder="5136 1845 5468 3894" 
              required 
              pattern="\d{4}\s?\d{4}\s?\d{4}\s?\d{4}" 
              title="Ingresa 16 dígitos de tu tarjeta" 
            >
            <img src="/assets/icons/mastercard.png" alt="MC" class="card-icon">
          </div>

          <div class="two-col">
            <div class="input-group small">
              <label class="field-label">Fecha de expiración</label>
              <input 
                type="text" 
                placeholder="MM/AA" 
                required 
                pattern="(0[1-9]|1[0-2])\/\d{2}" 
                title="Formato MM/AA" 
              >
              <i class="far fa-calendar-alt"></i>
            </div>
            <div class="input-group small">
              <label class="field-label">Código CVV</label>
              <input 
                type="password" 
                placeholder="•••" 
                required 
                pattern="\d{3,4}" 
                title="3 o 4 dígitos" 
              >
              <i class="fas fa-lock"></i>
            </div>
          </div>

          <div class="input-group">
            <label class="field-label">Titular</label>
            <input 
              type="text" 
              placeholder="NOMBRE COMPLETO" 
              required 
              minlength="3"
            >
            <i class="fas fa-user"></i>
          </div>

          <button type="submit" class="pay-btn">
            Pagar $<?php echo number_format($total, 2, ',', '.'); ?> COP
          </button>
        </form>
      </div>

      <div id="mobile" class="content">
        <p>Formulario de pago móvil…</p>
      </div>
    </div>
  </div>

</div>

<script src="transactional.js"></script>
<?php require '../shared/footer/footer.php'; ?>
