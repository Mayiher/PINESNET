<?php

include 'server.php';

$identificacion = mysqli_real_escape_string($conexion, $_POST['identificacion']);
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
$telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

// Verificar si algún campo está vacío
if (empty($identificacion) || empty($nombre) || empty($apellido) || empty($correo) || empty($telefono) || empty($contrasena)) {
    echo '
    <script>
    alert("Debe rellenar todos los campos");
    window.location = "register.php";
    </script>
    ';
    exit();
}

// Encriptar la contraseña
$contrasena = hash('sha512', $contrasena);

// Verificar si los datos ya existen en la base de datos (en una sola consulta)
$query_verificar = "SELECT * FROM users WHERE identificacion='$identificacion' OR correo='$correo' OR telefono='$telefono'";
$resultado_verificar = mysqli_query($conexion, $query_verificar);

if (mysqli_num_rows($resultado_verificar) > 0) {
    echo '
    <script>
    alert("La identificación, correo o teléfono ya están registrados, intente con otra diferente.");
    window.location = "register.php";
    </script>
    ';
    exit();
}

// Preparar la consulta para insertar el nuevo usuario
$query_insert = "INSERT INTO users (identificacion, nombre, apellido, correo, telefono, contrasena)
                 VALUES('$identificacion', '$nombre', '$apellido', '$correo', '$telefono', '$contrasena')";

// Ejecutar la consulta de inserción
$ejecutar = mysqli_query($conexion, $query_insert);

if ($ejecutar) {
    echo '
    <script>
    alert("Usuario registrado exitosamente");
    window.location = "/index.php";
    </script>
    ';
} else {
    echo '
    <script>
    alert("Intentelo nuevamente, usuario no registrado");
    window.location = "register.php";
    </script>
    ';
}

// Cerrar la conexión
mysqli_close($conexion);

?>
