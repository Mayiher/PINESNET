<?php
// index_admin.php
require '../shared/header/header.php';

if (!isset($_SESSION['users']) || strtolower($_SESSION['users']['rol']) !== 'administrator') {
  echo '<script>
          alert("Debe iniciar sesión como administrador.");
          location.href="/lib/views/auth/login-register/login-register.php";
        </script>';
  exit;
}

$sections = ['Administradores','Clientes','Ventas'];
$mapTable = [
  'Administradores' => ["users", "LOWER(rol)='administrator'"],
  'Clientes'        => ["users", "LOWER(rol)='user'"],
  'Ventas'          => ["sales", null]
];

$active = $_GET['section'] ?? 'Administradores';
if (!in_array($active, $sections)) {
  $active = 'Administradores';
}

require_once $_SERVER['DOCUMENT_ROOT'].'/config/server.php';
list($table, $where) = $mapTable[$active];
$sql    = "SELECT * FROM `$table`" . ($where ? " WHERE $where" : "");
$result = $conexion->query($sql);

$fieldsConfig = [
  'Administradores' => ['identificacion','nombre','apellido','correo','telefono','genero','fecha_registro'],
  'Clientes'        => ['identificacion','nombre','apellido','correo','telefono','genero','fecha_registro'],
  'Ventas'          => ['id_venta','id_usuario','fecha','subtotal','total_iva','descuento','total']
];

$labels = [
  'identificacion' => 'Identificación','nombre'=>'Nombre','apellido'=>'Apellido',
  'correo'=>'Email','telefono'=>'Teléfono','genero'=>'Género','fecha_registro'=>'Registro',
  'id_venta'=>'ID Venta','id_usuario'=>'ID Usuario','fecha'=>'Fecha',
  'subtotal'=>'Subtotal','total_iva'=>'Total IVA','descuento'=>'Descuento','total'
];
?>
<link rel="stylesheet" href="../shared/header/header.css">
<link rel="stylesheet" href="../shared/footer/footer.css">
<link rel="stylesheet" href="css/AdminPanel.css">

<div class="admin-body">
  <aside class="admin-sidebar">
    <h5>ACCESOS BACKEND</h5>
    <ul>
      <?php foreach ($sections as $sec): ?>
        <li class="<?= $active === $sec ? 'active' : '' ?>"
            onclick="location.href='?section=<?= urlencode($sec) ?>'">
          <?= htmlspecialchars($sec) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </aside>

  <main class="admin-main">
    <div class="admin-header">
      <nav class="breadcrumb">
        <span class="bc-item">Configuración</span>
        <span class="bc-sep">/</span>
        <span class="bc-item muted"><?= htmlspecialchars($active) ?></span>
      </nav>
      <button class="btn-new" onclick="openModal(null)">Nuevo</button>
    </div>

    <div class="table-wrapper">
      <?php if (!$result): ?>
        <p>Error: <?= htmlspecialchars($conexion->error) ?></p>
      <?php elseif ($result->num_rows === 0): ?>
        <p>No hay registros en “<?= htmlspecialchars($active) ?>”.</p>
      <?php else: ?>
        <table class="users-table">
          <thead>
            <tr>
              <?php foreach ($fieldsConfig[$active] as $col): ?>
                <th><?= htmlspecialchars($labels[$col] ?? $col) ?></th>
              <?php endforeach; ?>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr data-id="<?= (int)$row[$fieldsConfig[$active][0]] ?>">
                <?php foreach ($fieldsConfig[$active] as $col): ?>
                  <td><?= htmlspecialchars($row[$col]) ?></td>
                <?php endforeach; ?>
                <td>
                  <button class="btn-action btn-edit"
                    onclick='openModal(<?= json_encode($row, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_QUOT|JSON_HEX_APOS) ?>)'>
                    Editar
                  </button>

                  <?php if ($active === 'Ventas'): ?>
                    <button class="btn-action btn-details"
                      onclick="viewDetails(<?= (int)$row['id_venta'] ?>)">
                      Detalles de venta
                    </button>
                  <?php else: ?>
                    <button class="btn-action btn-del"
                      onclick="handleDelete('<?= addslashes($active) ?>', <?= (int)$row[$fieldsConfig[$active][0]] ?>)">
                      Eliminar
                    </button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </main>
</div>

<!-- Modal para CRUD (Editar/Nuevo) -->
<div id="crudModal" class="modal-backdrop" style="display:none">
  <div class="modal">
    <h3 id="modalTitle"></h3>
    <form id="crudForm" onsubmit="return false"></form>
    <div class="modal-actions">
      <button class="btn-new" onclick="handleSave()">Guardar</button>
      <button class="btn-delete" onclick="closeModal()">Cancelar</button>
    </div>
  </div>
</div>

<!-- Modal detalles de venta -->
<div id="detailsModal" class="modal-backdrop" style="display:none">
  <div class="modal">
    <span class="close" onclick="closeDetails()">&times;</span>
    <h3>Detalles de Venta</h3>
    <div id="detailsContent">Cargando…</div>
  </div>
</div>

<script src="js/AdminPanel.js"></script>
<?php require '../shared/footer/footer.php'; ?>
