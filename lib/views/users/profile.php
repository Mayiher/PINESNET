<?php
// profile.php
require '../shared/header/header.php';
require_once __DIR__ . '/conexion-profile.php';

// 1) Verificamos que haya usuario en sesión
if (!isset($_SESSION['users']['identificacion'])) {
    echo '<script>alert("Debe iniciar sesión para ver el perfil.");location="/lib/views/auth/login-register/login-register.php";</script>';
    exit;
}

// 2) Obtenemos la identificación
$userId = $_SESSION['users']['identificacion'];

// 3) Consultamos la BD por ese usuario
$stmt = $conexion->prepare(
    "SELECT identificacion, nombre, apellido, correo, telefono, rol, genero, fecha_registro 
     FROM users 
     WHERE identificacion = ?"
);
$stmt->bind_param('i', $userId);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    die('Usuario no encontrado.');
}
$u = $res->fetch_assoc();
$stmt->close();
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
      <input type="file"
             id="avatar-input"
             name="avatar"
             accept="image/*"
             style="display:none">
      <div id="preview-controls" class="hidden">
        <button type="button" id="cancel-btn">Cancelar</button>
        <button type="submit" id="confirm-btn">Subir</button>
      </div>
      <button type="button" id="upload-btn">Cargar foto</button>
    </form>
  </section>

  <!-- 2) Detalles -->
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
    <div class="empty">No hay pedidos por el momento</div>
  </section>

</div>

<script src="js/profile.js"></script>
<?php require '../shared/footer/footer.php'; ?>
</body>
</html>
