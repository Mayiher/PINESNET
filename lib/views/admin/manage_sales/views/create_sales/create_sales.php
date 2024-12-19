<?php 
// Incluir la conexión a la base de datos
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

// Verificación de acceso solo para administradores
require '../../../../shared/header/header.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin']['rol'] != 'Administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../../../../shared/header/header.css">
    <link rel="stylesheet" href="../../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../css/es.css">
    <title>Registro de Venta</title>
</head>
<body id="page-top">

<div class="container">
    <h2>Bienvenido Administrador <?php echo htmlspecialchars($_SESSION['admin']['nombre']) . ' ' . htmlspecialchars($_SESSION['admin']['apellido']); ?></h2>
</div>

<!-- Formulario para registrar la venta -->
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
                            <input type="text" id="cliente_identificacion" name="cliente_identificacion" class="form-control" required>
                            <button type="button" class="btn btn-primary" id="consultarIdentificacion">Consultar Identificación</button>
                            <small id="cliente_error" class="text-danger" style="display: none;">Cliente no encontrado.</small>
                        </div>

                        <div class="form-group">
                            <label for="Nombrecliente">Nombre del Cliente *</label>
                            <input type="text" id="Nombrecliente" name="Nombrecliente" class="form-control" required>
                        </div>

                        <!-- Campo Apellido Cliente (Oculto inicialmente) -->
                        <div class="form-group" id="apellidoClienteDiv" style="display: none;">
                            <label for="apellidoCliente">Apellido del Cliente *</label>
                            <input type="text" id="apellidoCliente" name="apellidoCliente" class="form-control" required>
                        </div>

                        <div class="form-group" id="registrarClienteButtonDiv" style="display: none;">
                            <button type="button" class="btn btn-success" id="guardarCliente">Registrar Cliente</button>
                        </div>

                        <!-- Datos del producto -->
                        <div class="form-group">
                            <label for="producto_codigo">Código del Producto *</label>
                            <input type="text" id="producto_codigo" name="producto_codigo" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="producto_descripcion">Descripción del Producto *</label>
                            <input type="text" id="producto_descripcion" name="producto_descripcion" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="cantidad">Cantidad *</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="precio_unitario">Precio Unitario *</label>
                            <input type="number" id="precio_unitario" name="precio_unitario" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-info" id="agregarProducto">Agregar Producto</button>
                        </div>

                        <!-- Tabla de productos -->
                        <div class="table-responsive">
                            <table id="tablaProductos" class="table">
                                <thead>
                                    <tr>
                                        <th>Identificación Cliente</th>
                                        <th>Nombre Cliente</th>
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
                                    <!-- Aquí se agregarán dinámicamente las filas con JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" id="total" name="total" class="form-control" required readonly>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="registrar" class="btn btn-success" id="registrarVenta">Registrar Venta</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Cargar archivos JS al final del body -->
<script src="create_sales_table.js"></script>
<script src="search_client.js"></script>

</body>
</html>
