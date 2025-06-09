<?php
// lib/views/users/profile.php

// 1) Iniciar sesión y mostrar <head> + nav
require '../shared/header/header.php';

// 2) Conectar BD (ahora ya no arrancamos sesión aquí)
require_once __DIR__ . '/conexion-profile.php';

// 3) Verificar sesión de usuario
if (!isset($_SESSION['users']['identificacion'])) {
    echo '<script>
            alert("Debe iniciar sesión para ver el perfil.");
            window.location.href="/lib/views/auth/login-register/login-register.php";
          </script>';
    exit;
}

// 4) Cargar datos de usuario
$userId = $_SESSION['users']['identificacion'];
$stmt = $conexion->prepare("
    SELECT id, identificacion, nombre, apellido, correo, telefono, rol, genero, fecha_registro
    FROM users
    WHERE identificacion = ?
");
$stmt->bind_param('i', $userId);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
$stmt->close();

// 5) Cargar pedidos
$stmt2 = $conexion->prepare("
    SELECT id_venta, fecha, subtotal, total_iva, descuento, total
    FROM sales
    WHERE id_usuario = ?
    ORDER BY fecha DESC
");
$stmt2->bind_param('i', $u['id']);
$stmt2->execute();
$orders = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt2->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Perfil</title>
     <link rel="stylesheet" href="../shared/header/header.css">
  <link rel="stylesheet" href="../shared/footer/footer.css">
  <link rel="stylesheet" href="css/profile.css">
</head>
<body>

<div class="profile-page">

  <!-- 1) Tarjeta perfil con preview/confirm -->
  <section class="card profile-summary">
    <h2>Perfil</h2>
    <form id="avatar-form" action="upload-profile.php" method="post" enctype="multipart/form-data">
      <div class="avatar-container">
        <img id="avatar" src="get-avatar.php" alt="Foto de perfil">
      </div>
      <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display:none">
      <div id="preview-controls" class="hidden">
        <button type="button" id="cancel-btn">Cancelar</button>
        <button type="submit" id="confirm-btn">Subir</button>
      </div>
      <button type="button" id="upload-btn">Cargar foto</button>
    </form>
  </section>

  <!-- 2) Detalles usuario -->
  <section class="card profile-details">
    <div class="field"><label>Identificación</label><div class="value"><?= htmlspecialchars($u['identificacion']) ?></div></div>
    <div class="field"><label>Nombre</label><div class="value"><?= htmlspecialchars($u['nombre']) ?></div></div>
    <div class="field"><label>Apellido</label><div class="value"><?= htmlspecialchars($u['apellido']) ?></div></div>
    <div class="field"><label>Email</label><div class="value"><?= htmlspecialchars($u['correo']) ?></div></div>
    <div class="field"><label>Teléfono</label><div class="value"><?= htmlspecialchars($u['telefono']) ?></div></div>
    <div class="field"><label>Género</label><div class="value"><?= htmlspecialchars($u['genero'] ?? '—') ?></div></div>
    <div class="field"><label>Rol</label><div class="value"><?= htmlspecialchars(ucfirst($u['rol'])) ?></div></div>
    <div class="field"><label>Registrado el</label><div class="value"><?= htmlspecialchars($u['fecha_registro']) ?></div></div>
  </section>

  <!-- 3) Pedidos -->
  <section class="card orders">
    <h2>Pedidos</h2>
    <?php if (empty($orders)): ?>
      <div class="empty">No hay pedidos por el momento</div>
    <?php else: ?>
      <table class="orders-table">
        <thead>
          <tr>
            <th>ID Venta</th><th>Fecha</th><th>Subtotal</th>
            <th>IVA</th><th>Descuento</th><th>Total</th><th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $o): ?>
          <tr>
            <td><?= $o['id_venta'] ?></td>
            <td><?= $o['fecha'] ?></td>
            <td>$<?= number_format($o['subtotal'],0,',','.') ?> COP</td>
            <td>$<?= number_format($o['total_iva'],0,',','.') ?> COP</td>
            <td>$<?= number_format($o['descuento'],0,',','.') ?> COP</td>
            <td>$<?= number_format($o['total'],0,',','.') ?> COP</td>
            <td>
              <button class="btn-details" data-id="<?= $o['id_venta'] ?>">
                Detalles de venta
              </button>
            </td>
          </tr>

          <?php
          // Pre-render detalles oculto
          $stmt3 = $conexion->prepare("
            SELECT codigo_producto, descripcion, cantidad, precio_unitario, total
            FROM sales_details
            WHERE id_venta=?
          ");
          $stmt3->bind_param('i', $o['id_venta']);
          $stmt3->execute();
          $details = $stmt3->get_result()->fetch_all(MYSQLI_ASSOC);
          $stmt3->close();
          ?>
          <tr class="details-row" id="details-<?= $o['id_venta'] ?>" style="display:none">
            <td colspan="7">
              <table class="detail-table">
                <thead>
                  <tr>
                    <th>Código</th><th>Descripción</th>
                    <th>Cant.</th><th>Precio U.</th><th>Total</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($details as $d): ?>
                  <tr>
                    <td><?= htmlspecialchars($d['codigo_producto']) ?></td>
                    <td><?= htmlspecialchars($d['descripcion']) ?></td>
                    <td><?= $d['cantidad'] ?></td>
                    <td>$<?= number_format($d['precio_unitario'],0,',','.') ?></td>
                    <td>$<?= number_format($d['total'],0,',','.') ?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </section>

</div>

<!-- Modal -->
<div id="detailsModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>Detalles de Venta</h3>
    <div id="modal-body"></div>
  </div>
</div>

<script src="js/profile.js"></script>
<?php require '../shared/footer/footer.php'; ?>
</body>
</html>