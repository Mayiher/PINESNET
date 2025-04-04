<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

if (isset($_POST['productos']) && isset($_POST['totalVenta'])) {

    // Decodificar el JSON de productos
    $productos = json_decode($_POST['productos'], true);
    $totalVenta = $_POST['totalVenta'];

    // Verificación de datos
    if (empty($productos)) {
        echo '<script>alert("Error: Los productos no fueron enviados correctamente. Por favor, revisa los datos.");</script>';
        exit;
    }

    if (empty($totalVenta)) {
        echo '<script>alert("Error: El total de la venta no fue enviado correctamente. Por favor, revisa el total.");</script>';
        exit;
    }

    // Validar que todos los campos estén presentes
    if (isset($_POST['id_usuario']) && strlen($_POST['id_usuario']) >= 1) {
        $id_usuario = trim(mysqli_real_escape_string($conexion, $_POST['id_usuario']));

        // Verificar que el id_usuario exista en la tabla users
        $consulta_usuario = "SELECT COUNT(*) FROM users WHERE identificacion = ?";
        if ($stmt_usuario = mysqli_prepare($conexion, $consulta_usuario)) {
            mysqli_stmt_bind_param($stmt_usuario, "s", $id_usuario);
            mysqli_stmt_execute($stmt_usuario);
            mysqli_stmt_bind_result($stmt_usuario, $count_usuario);
            mysqli_stmt_fetch($stmt_usuario);
            if ($count_usuario == 0) {
                echo '<script>alert("Error: El usuario con esta identificación no existe.");</script>';
                exit;
            }
        } else {
            echo '<script>alert("Error: No se pudo verificar el usuario.");</script>';
            exit;
        }

        // Validar campos de venta
        if (!isset($_POST['subtotal']) || !is_numeric($_POST['subtotal']) || $_POST['subtotal'] < 0) {
            echo '<script>alert("Error: El subtotal no es un número válido o falta.");</script>';
            exit;
        }
        $subtotal = intval($_POST['subtotal']);  

        if (!isset($_POST['total_iva']) || !is_numeric($_POST['total_iva']) || $_POST['total_iva'] < 0) {
            echo '<script>alert("Error: El total IVA no es un número válido o falta.");</script>';
            exit;
        }
        $total_iva = intval($_POST['total_iva']);

        if (!isset($_POST['descuento']) || !is_numeric($_POST['descuento'])) {
            echo '<script>alert("Error: El descuento no es un número válido o falta.");</script>';
            exit;
        }
        $descuento = intval($_POST['descuento']);

        if (!isset($totalVenta) || !is_numeric($totalVenta)) {
            echo '<script>alert("Error: El total de la venta no es un número válido o falta.");</script>';
            exit;
        }
        $total = intval($totalVenta);

        // Iniciar la transacción
        mysqli_begin_transaction($conexion);

        try {
            // Insertar la venta en la tabla `sales`
            $consulta_venta = "INSERT INTO sales (id_usuario, subtotal, total_iva, descuento, total)
                               VALUES (?, ?, ?, ?, ?)";
            if ($stmt_venta = mysqli_prepare($conexion, $consulta_venta)) {
                mysqli_stmt_bind_param($stmt_venta, "siiii", $id_usuario, $subtotal, $total_iva, $descuento, $total);
                if (!mysqli_stmt_execute($stmt_venta)) {
                    throw new Exception("Error al registrar la venta.");
                }
                // Obtener el id de la venta recién insertada
                $id_venta = mysqli_insert_id($conexion);

                // Insertar los detalles de los productos vendidos en la tabla `sales_details`
                $consulta_detalles = "INSERT INTO sales_details (id_venta, codigo_producto, descripcion, cantidad, precio_unitario, bruto, porcentaje_iva, iva, total)
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                foreach ($productos as $producto) {
                    // Sanear y calcular los valores del producto
                    if (empty($producto['productoCodigo']) || empty($producto['productoDescripcion']) || !isset($producto['cantidad']) || !isset($producto['precioUnitario']) || !isset($producto['ivaProducto'])) {
                        throw new Exception("Error: Falta información del producto. Verifica los campos.");
                    }
                    $codigo_producto = mysqli_real_escape_string($conexion, $producto['productoCodigo']);
                    $descripcion = mysqli_real_escape_string($conexion, $producto['productoDescripcion']);
                    $cantidad = intval($producto['cantidad']);
                    $precio_unitario = intval($producto['precioUnitario']);
                    $bruto = $cantidad * $precio_unitario;
                    $porcentaje_iva = intval($producto['ivaProducto']);
                    $iva = intval(($bruto * $porcentaje_iva) / 100);
                    $total_producto = $bruto + $iva;

                    if ($stmt_detalles = mysqli_prepare($conexion, $consulta_detalles)) {
                        mysqli_stmt_bind_param($stmt_detalles, "issiiiiii", $id_venta, $codigo_producto, $descripcion, $cantidad, $precio_unitario, $bruto, $porcentaje_iva, $iva, $total_producto);
                        if (!mysqli_stmt_execute($stmt_detalles)) {
                            throw new Exception("Error al registrar los detalles de la venta. El problema ocurrió al insertar el producto con código: $codigo_producto.");
                        }
                    } else {
                        throw new Exception("Error al preparar la consulta de detalles de productos.");
                    }
                }

                // Confirmar la transacción
                mysqli_commit($conexion);

                // Mostrar mensaje de éxito con alerta y redirigir
                echo "<script>
                        alert('Venta registrada exitosamente!');
                        window.location.href = '../admin.php';
                      </script>";
                exit();
            } else {
                throw new Exception("Error al preparar la consulta de la venta.");
            }
        } catch (Exception $e) {
            // Si ocurre algún error, revertir la transacción
            mysqli_roll_back($conexion);
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo '<script>alert("Error: El ID del usuario está vacío o no es válido.");</script>';
    }
} else {
    echo '<script>alert("Error: Los datos no fueron enviados correctamente. Por favor, inténtalo nuevamente.");</script>';
}

// Verificar si los datos llegan correctamente
if (isset($_POST['productos']) && isset($_POST['totalVenta'])) {
  echo 'Datos recibidos correctamente';
} else {
  echo 'Los datos no fueron enviados correctamente';
  echo '<pre>';
  print_r($_POST);  // Imprime los datos recibidos
  echo '</pre>';
}
exit;

?>
