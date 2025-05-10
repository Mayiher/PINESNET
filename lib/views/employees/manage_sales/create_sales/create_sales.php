<?php
// create_sales.php

// 1) Incluir sesión y header (que a su vez hace session_start())
require '../../../shared/header/header.php';

// 2) Verificar que el usuario sea administrador
if (
    !isset($_SESSION['admin']) ||
    empty($_SESSION['admin']) ||
    strtolower($_SESSION['admin']['rol']) !== 'administrador'
) {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}

// 3) Datos del administrador
$nombre   = $_SESSION['admin']['nombre'];
$apellido = $_SESSION['admin']['apellido'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Registro de Venta</title>
  <link rel="stylesheet" href="../../../shared/header/header.css">
  <link rel="stylesheet" href="../css/fontawesome-all.min.css">
  <link rel="stylesheet" href="../css/es.css">
</head>
<body id="page-top">

  <div class="container">
    <h2>Bienvenido Administrador <?php echo htmlspecialchars("$nombre $apellido"); ?></h2>
  </div>

  <form id="formularioVenta" action="confirm_sale.php" method="POST">
    <div id="login">
      <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
          <div id="login-column" class="col-md-8">
            <div id="login-box" class="col-md-12">
              <br><br>
              <h3 class="text-center">Formulario de Venta</h3>

              <!-- Datos del cliente -->
              <div class="form-group">
                <label for="cliente_identificacion">Número de Identificación *</label>
                <div class="input-group">
                  <input
                    type="text"
                    id="cliente_identificacion"
                    name="cliente_identificacion"
                    class="form-control"
                    required
                  >
                  <div class="input-group-append">
                    <button
                      type="button"
                      class="btn btn-primary"
                      id="consultarIdentificacion"
                    >Consultar</button>
                  </div>
                </div>
                <small
                  id="cliente_error"
                  class="text-danger"
                  style="display: none;"
                >Cliente no encontrado.</small>
              </div>

              <div class="form-group">
                <label for="Nombrecliente">Nombre del Cliente *</label>
                <input
                  type="text"
                  id="Nombrecliente"
                  name="Nombrecliente"
                  class="form-control"
                  required
                >
              </div>

              <!-- Apellido y botón registrar cliente, mostrados por JS si necesario -->
              <div class="form-group" id="apellidoClienteDiv" style="display: none;">
                <label for="apellidoCliente">Apellido del Cliente *</label>
                <input
                  type="text"
                  id="apellidoCliente"
                  name="apellidoCliente"
                  class="form-control"
                  required
                >
              </div>
              <div class="form-group" id="registrarClienteButtonDiv" style="display: none;">
                <button
                  type="button"
                  class="btn btn-success"
                  id="guardarCliente"
                >Registrar Cliente</button>
              </div>

              <!-- Datos del producto -->
              <div class="form-group">
                <label for="producto_codigo">Código del Producto *</label>
                <input
                  type="text"
                  id="producto_codigo"
                  name="producto_codigo"
                  class="form-control"
                  required
                >
              </div>
              <div class="form-group">
                <label for="producto_descripcion">Descripción del Producto *</label>
                <input
                  type="text"
                  id="producto_descripcion"
                  name="producto_descripcion"
                  class="form-control"
                  required
                >
              </div>
              <div class="form-group">
                <label for="cantidad">Cantidad *</label>
                <input
                  type="number"
                  id="cantidad"
                  name="cantidad"
                  class="form-control"
                  required
                  min="1"
                >
              </div>
              <div class="form-group">
                <label for="precio_unitario">Precio Unitario *</label>
                <input
                  type="number"
                  id="precio_unitario"
                  name="precio_unitario"
                  class="form-control"
                  required
                  min="0.01"
                  step="0.01"
                >
              </div>
              <div class="form-group">
                <button
                  type="button"
                  class="btn btn-info"
                  id="agregarProducto"
                >Agregar Producto</button>
              </div>

              <!-- Tabla de productos -->
              <div class="table-responsive">
                <table id="tablaProductos" class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Cantidad</th>
                      <th>Precio Unitario</th>
                      <th>Total</th>
                      <th>IVA</th>
                      <th>Total con IVA</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Filas dinámicas por JS -->
                  </tbody>
                </table>
              </div>

              <!-- Total general -->
              <div class="form-group">
                <label for="total">Total</label>
                <input
                  type="text"
                  id="total"
                  name="total"
                  class="form-control"
                  readonly
                  required
                >
              </div>

              <!-- ID de usuario (rellenado vía JS al consultar/crear cliente) -->
              <input
                type="hidden"
                name="id_usuario"
                id="id_usuario"
                value=""
              >

              <div class="form-group text-center">
                <button
                  type="submit"
                  name="registrar"
                  class="btn btn-success"
                  id="registrarVenta"
                >Registrar Venta</button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Scripts JS -->
  <script src="create_sales_table.js"></script>
  <script src="search_client.js"></script>
</body>
</html>
