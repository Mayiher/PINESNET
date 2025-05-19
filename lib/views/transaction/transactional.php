<?php
// transactional.php

require '../shared/header/header.php';

// 2) Obtener el precio desde GET (en COP)
$price = isset($_GET['price']) ? intval($_GET['price']) : 0;

// 3) Función para generar un Invoice ID aleatorio de 10 caracteres (A–Z0–9)
function generarInvoiceId($length = 10) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $id = '';
    for ($i = 0; $i < $length; $i++) {
        $id .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $id;
}
$invoiceId = generarInvoiceId(10);

// 4) Fecha y hora actual para “Next payment”
date_default_timezone_set('America/Bogota');
$nextPayment = date('d F, Y H:i'); // Ej. 19 May, 2025 14:35

// 5) Calcular total (precio + comisión fija de 1.99)
$commission = 1.99;
$total = $price + $commission;
?>

<!-- Incluir el CSS específico para esta página -->
<link rel="stylesheet" href="../shared/header/header.css">
<link rel="stylesheet" href="transactional.css">

<div class="wrapper">

  <!-- PANEL RESUMEN -->
  <div class="summary-panel">
    <div class="amount">$<?php echo number_format($price, 0, ',', '.'); ?>,00</div>
    <div class="line">
      <span class="label">Commission</span>
      <span class="value">$<?php echo number_format($commission, 2, ',', '.'); ?></span>
    </div>
    <div class="line">
      <span class="label">Total</span>
      <span class="value total">$<?php echo number_format($total, 2, ',', '.'); ?></span>
    </div>
    <hr>
    <div class="info-item">
      <i class="far fa-file-alt"></i>
      <div class="info-text-block">
        <span class="small-label">Invoice ID:</span>
        <span class="info-text"><?php echo $invoiceId; ?></span>
      </div>
    </div>
    <div class="info-item">
      <i class="far fa-calendar-alt"></i>
      <div class="info-text-block">
        <span class="small-label">Next payment:</span>
        <span class="info-text"><?php echo $nextPayment; ?></span>
      </div>
    </div>
    <div class="support">
      <div>
        <span>Customer Support:</span><br>
        <span>online chat 24/7</span>
      </div>
      <button class="chat-btn"><i class="fas fa-comment-dots"></i></button>
    </div>
  </div>

  <!-- PANEL DE PAGO -->
  <div class="payment-panel">
    <div class="header">
      <h2>Payment methods</h2>
      <i class="fas fa-bars menu-icon"></i>
    </div>
    <div class="tabs">
      <button class="tab active" data-target="credit">Credit Card</button>
      <button class="tab" data-target="mobile">Mobile Payment</button>
      <a href="#" class="more">+ More</a>
    </div>
    <div class="tab-content">
      <!-- Crédito -->
      <div id="credit" class="content active">
        <div class="card-selection">
          <button class="circle-btn"><i class="fas fa-plus"></i></button>
          <button class="circle-btn selected">5949</button>
          <button class="circle-btn">3894</button>
        </div>

        <label class="field-label">Credit Card</label>
        <div class="input-group">
          <input type="text" placeholder="5136 1845 5468 3894">
          <img src="/assets/icons/mastercard.png" alt="MC" class="card-icon">
        </div>

        <div class="two-col">
          <div class="input-group small">
            <label class="field-label">Expiration Date</label>
            <input type="text" placeholder="MM/YY">
            <i class="far fa-calendar-alt"></i>
          </div>
          <div class="input-group small">
            <label class="field-label">Code CVV</label>
            <input type="password" placeholder="•••">
            <i class="fas fa-lock"></i>
          </div>
        </div>

        <div class="input-group">
          <label class="field-label">Name</label>
          <input type="text" placeholder="VALDIMIR BEREZOVKIY">
          <i class="fas fa-user"></i>
        </div>

        <button class="pay-btn">Pay $<?php echo number_format($total, 2, ',', '.'); ?></button>
      </div>

      <!-- Móvil -->
      <div id="mobile" class="content">
        <p>Mobile payment form here…</p>
      </div>
    </div>
  </div>

</div>

<!-- Incluir el JS de tabs -->
<script src="transactional.js"></script>

<?php
// 6) Incluir el footer (cierra </body></html>)
require '../shared/footer/footer.php';
?>
