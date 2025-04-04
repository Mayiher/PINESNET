<?php

include 'server-local.php';

$identificacion = $_POST['identificacion'];
$nombre         = $_POST['nombre'];
$apellido       = $_POST['apellido'];
$correo         = $_POST['correo'];
$telefono       = $_POST['telefono'];
$contrasena     = $_POST['contrasena'];

// Verificar si algún campo está vacío
if (empty($identificacion) || empty($nombre) || empty($apellido) || empty($correo) || empty($telefono) || empty($contrasena)) {
    echo '
    <script>
        alert("Debe rellenar todos los campos");
        window.location.href = "register.php";
    </script>
    ';
    exit();
}

$contrasena = hash('sha512', $contrasena);

// Verificar si la columna fecha_registro existe en la tabla 'users'
$columnsQuery = $conexion->query("PRAGMA table_info(users)");
$hasFechaRegistro = false;
while ($column = $columnsQuery->fetchArray(SQLITE3_ASSOC)) {
    if ($column['name'] === 'fecha_registro') {
        $hasFechaRegistro = true;
        break;
    }
}
if (!$hasFechaRegistro) {
    // Agregar la columna fecha_registro si no existe
    $alterQuery = "ALTER TABLE users ADD COLUMN fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
    $conexion->exec($alterQuery);
}

// Función para verificar si ya existe un valor en una columna de la tabla 'users'
function verificarExistencia($conexion, $columna, $valor) {
    $stmt = $conexion->prepare("SELECT * FROM users WHERE $columna = ?");
    $stmt->bindValue(1, $valor, SQLITE3_TEXT);
    $resultado = $stmt->execute();
    return ($resultado->fetchArray(SQLITE3_ASSOC) !== false);
}

// Verificar duplicados en cada campo
if (verificarExistencia($conexion, 'identificacion', $identificacion)) {
    echo '
    <script>
        alert("Esta identificación ya se encuentra registrada, intente con otra diferente");
        window.location.href = "/lib/views/auth/register/register.php";
    </script>
    ';
    exit();
}

if (verificarExistencia($conexion, 'nombre', $nombre)) {
    echo '
    <script>
        alert("Este nombre ya se encuentra registrado, intente con otro diferente");
        window.location.href = "/lib/views/auth/register/register.php";
    </script>
    ';
    exit();
}

if (verificarExistencia($conexion, 'apellido', $apellido)) {
    echo '
    <script>
        alert("Este apellido ya se encuentra registrado, intente con otro diferente");
        window.location.href = "register.php";
    </script>
    ';
    exit();
}

if (verificarExistencia($conexion, 'correo', $correo)) {
    echo '
    <script>
        alert("Este correo ya se encuentra registrado, intente con otro diferente");
        window.location.href = "register.php";
    </script>
    ';
    exit();
}

if (verificarExistencia($conexion, 'telefono', $telefono)) {
    echo '
    <script>
        alert("Este teléfono ya se encuentra registrado, intente con otro diferente");
        window.location.href = "/lib/views/auth/register/register.php";
    </script>
    ';
    exit();
}

// Preparar la inserción del nuevo usuario (fecha_registro se asigna automáticamente)
$stmt = $conexion->prepare("INSERT INTO users (identificacion, nombre, apellido, correo, telefono, contrasena) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bindValue(1, $identificacion, SQLITE3_TEXT);
$stmt->bindValue(2, $nombre, SQLITE3_TEXT);
$stmt->bindValue(3, $apellido, SQLITE3_TEXT);
$stmt->bindValue(4, $correo, SQLITE3_TEXT);
$stmt->bindValue(5, $telefono, SQLITE3_TEXT);
$stmt->bindValue(6, $contrasena, SQLITE3_TEXT);

$result = $stmt->execute();

if ($result) {
    echo '
    <script>
        alert("Usuario registrado exitosamente");
        window.location.href = "/index.php";
    </script>
    ';
} else {
    echo '
    <script>
        alert("Inténtelo nuevamente, usuario no registrado");
        window.location.href = "/lib/views/auth/register/register.php";
    </script>
    ';
}

$conexion->close();
?>
