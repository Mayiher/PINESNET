<?php

include 'server.php';

// Capturar y sanitizar todos los campos, incluido género
$identificacion = mysqli_real_escape_string($conexion, $_POST['identificacion']);
$nombre         = mysqli_real_escape_string($conexion, $_POST['nombre']);
$apellido       = mysqli_real_escape_string($conexion, $_POST['apellido']);
$correo         = mysqli_real_escape_string($conexion, $_POST['correo']);
$telefono       = mysqli_real_escape_string($conexion, $_POST['telefono']);
$genero         = mysqli_real_escape_string($conexion, $_POST['genero']);
$contrasena     = mysqli_real_escape_string($conexion, $_POST['contrasena']);

// Verificar si algún campo está vacío
if (
    empty($identificacion) || empty($nombre) || empty($apellido) ||
    empty($correo) || empty($telefono) || empty($genero) || empty($contrasena)
) {
    echo '
    <script>
      alert("Debe rellenar todos los campos");
      window.location = "register.php";
    </script>
    ';
    exit();
}

// Encriptar la contraseña con SHA-256
$contrasena_hash = hash('sha256', $contrasena);

// Verificar si la identificación, correo o teléfono ya existen
$query_verificar = "SELECT * FROM users WHERE identificacion=? OR correo=? OR telefono=?";
$stmt_verificar  = $conexion->prepare($query_verificar);
$stmt_verificar->bind_param("iss", $identificacion, $correo, $telefono);
$stmt_verificar->execute();
$resultado_verificar = $stmt_verificar->get_result();

if ($resultado_verificar->num_rows > 0) {
    echo '
    <script>
      alert("La identificación, correo o teléfono ya están registrados, intente con otra diferente.");
      window.location = "register.php";
    </script>
    ';
    exit();
}

// Preparar la consulta para insertar el nuevo usuario, incluyendo género
$query_insert = "
  INSERT INTO users
    (identificacion, nombre, apellido, correo, telefono, genero, contrasena, rol)
  VALUES
    (?, ?, ?, ?, ?, ?, ?, 'user')
";
$stmt_insert = $conexion->prepare($query_insert);
$stmt_insert->bind_param(
    "issssss",
    $identificacion,
    $nombre,
    $apellido,
    $correo,
    $telefono,
    $genero,
    $contrasena_hash
);

// Ejecutar la inserción
if ($stmt_insert->execute()) {
    echo '
    <script>
      alert("Usuario registrado exitosamente");
      window.location = "/index.php";
    </script>
    ';
} else {
    echo '
    <script>
      alert("Inténtelo nuevamente, usuario no registrado");
      window.location = "register.php";
    </script>
    ';
}

// Cerrar la conexión
$conexion->close();
?>
