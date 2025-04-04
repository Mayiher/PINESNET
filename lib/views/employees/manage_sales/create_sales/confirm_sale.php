<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';
require '../../../../shared/header/header.php';

// Verificación de acceso solo para administradores
if (!isset($_SESSION['admin']) || $_SESSION['admin']['rol'] != 'Administrador') {
    echo '<script>alert("Acceso restringido. Solo los administradores pueden acceder a esta página.");</script>';
    echo '<script>window.location.href="../../index.php";</script>';
    exit;

    // Confirmar que los datos llegan correctamente
    if (isset($_POST['productos'])) {
        $productos = json_decode($_POST['productos'], true);
        echo "<pre>";
        print_r($productos);  // Imprime los productos para verificar
        echo "</pre>";
    }
    
}

// Incluir los estilos de Bootstrap
echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';
echo '<link rel="stylesheet" href="../../../../shared/header/header.css">';
echo '<link rel="stylesheet" href="../../css/fontawesome-all.min.css">';
echo '<link rel="stylesheet" href="../../css/es.css">';

// Verificar si los productos y el total fueron recibidos correctamente
if (isset($_POST['productos']) && isset($_POST['totalVenta'])) {
    $productos = json_decode($_POST['productos'], true);
    $totalVenta = $_POST['totalVenta'];
} else {
    echo '<script>alert("Los datos no fueron enviados correctamente. Por favor, inténtalo nuevamente.");</script>';
    exit;
}

// Mostrar los productos recibidos
echo '<h3>Detalles de la venta</h3>';
echo '<div class="container">';
echo '<div class="table-responsive">';
echo '<table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>Identificación Cliente</th>
                <th>Nombre Cliente</th>
                <th>Código Producto</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total sin IVA</th>
                <th>IVA</th>
                <th>Total con IVA</th>
            </tr>
        </thead>
        <tbody>';

        // Asegúrate de que los datos se reciban correctamente
        if (isset($_POST['productos'])) {
            $productos = json_decode($_POST['productos'], true);
        
            // Procesa cada producto
            foreach ($productos as $producto) {
                $clienteIdentificacion = $producto['clienteIdentificacion'];
                $clienteNombre = $producto['clienteNombre'];
                $productoCodigo = $producto['productoCodigo'];
                $productoDescripcion = $producto['productoDescripcion'];
                $cantidad = $producto['cantidad'];
                $precioUnitario = $producto['precioUnitario'];
                $totalProducto = $producto['totalProducto'];
                $ivaProducto = $producto['ivaProducto'];
                $totalConIva = $producto['totalConIva'];
        
                // Aquí puedes hacer lo necesario para almacenar la venta en la base de datos
                // Por ejemplo, inserta en la tabla de ventas y detalles de ventas
                // Ejemplo:
                // $query = "INSERT INTO ventas (cliente_identificacion, total) VALUES ('$clienteIdentificacion', '$totalConIva')";
                // Ejecuta la consulta para insertar la venta
            }
        }

echo '</tbody></table>';
echo '</div>'; // cierre de .table-responsive

// Mostrar el total de la venta
echo '<h4>Total de la venta (con IVA): $' . number_format($totalVenta, 2) . '</h4>';
echo '</div>'; // cierre de .container

// Agregar un botón para confirmar o cancelar
echo '<form method="POST" action="ventas.php">';
echo '<button type="submit" class="btn btn-secondary">Volver a la lista de ventas</button>';
echo '</form>';

echo '<form method="POST" action="../../includes/validar.php">';
echo '<button type="submit" name="confirmarVenta" class="btn btn-success">Confirmar Venta</button>';
echo '</form>';
?>
