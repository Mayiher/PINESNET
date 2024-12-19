<?php

require '../../../shared/header/header.php';

// Verificar que el usuario tiene el rol de administrador
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
    <link rel="stylesheet" href="../../../shared/header/header.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/es.css">
</head>
<body id="page-top">

<form action="../includes/_functions.php" method="POST">
<div id="login">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">

<?php
// Incluir el archivo server.php
include $_SERVER['DOCUMENT_ROOT'] . '/config/server.php';

// Verificar si se ha pasado un id por GET (en este caso, 'identificacion')
if (isset($_GET['identificacion'])) {
    $identificacion = $_GET['identificacion']; // Usar 'identificacion' en lugar de 'id'

    // Usar consulta preparada para evitar inyección SQL
    $SQL = "SELECT * FROM users WHERE identificacion = ?";
    $stmt = mysqli_prepare($conexion, $SQL);
    
    // Vincular el parámetro y ejecutar la consulta
    mysqli_stmt_bind_param($stmt, "s", $identificacion); // 's' para string, ya que 'identificacion' es VARCHAR
    mysqli_stmt_execute($stmt);
    
    // Obtener el resultado
    $resultado = mysqli_stmt_get_result($stmt);
    
    // Verificar si se encontró el usuario
    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
    } else {
        echo '<script>alert("No se encontró el usuario con ese identificador.");</script>';
        echo '<script>window.location.href="../../index_admin.php";</script>';
        exit;
    }
} else {
    echo '<script>alert("Identificación no proporcionada.");</script>';
    echo '<script>window.location.href="../../index_admin.php";</script>';
    exit;
}
?>

<h3 class="text-center">Editar usuario</h3>

<div class="form-group">
    <label for="identificacion" class="form-label">Identificación *</label>
    <input type="text" id="identificacion" name="identificacion" class="form-control" value="<?php echo htmlspecialchars($usuario['identificacion']); ?>" required>
</div>
<div class="form-group">
    <label for="nombre" class="form-label">Nombre *</label>
    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
</div>
<div class="form-group">
    <label for="apellido" class="form-label">Apellido *</label>
    <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
</div>
<div class="form-group">
    <label for="correo">Correo *:</label><br>
    <input type="email" name="correo" id="correo" class="form-control" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
</div>
<div class="form-group">
    <label for="telefono" class="form-label">Teléfono *</label>
    <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
</div>

<!-- No se incluye el campo de contraseña para edición -->
<input type="hidden" name="accion" value="editar_registro">
<input type="hidden" name="identificacion" value="<?php echo htmlspecialchars($usuario['identificacion']); ?>">

<button type="submit" class="btn btn-primary">Guardar cambios</button>
</form>

<br>
<div class="mb-3">
    <a href="../../index_admin.php" class="btn btn-danger">Cancelar</a>
</div>

</div>
</div>
</div>
</div>
</div>
</form>
</body>
</html>
