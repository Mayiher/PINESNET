<?php

include 'server-local.php';

$identificacion = $_POST['identificacion'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contrasena = $_POST['contrasena'];

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

$contrasena = hash('sha512', $contrasena);

$query = "INSERT INTO users (identificacion, nombre, apellido, correo, telefono, contrasena)
         VALUES('$identificacion', '$nombre', '$apellido', '$correo', '$telefono', '$contrasena')";


//Verificar que los datos no se repitan en la base de datos

$verificar_identificacion = mysqli_query($conexion, "SELECT * FROM users WHERE identificacion='$identificacion' ");

if (mysqli_num_rows($verificar_identificacion) > 0) {
    echo '
 <script>
    alert("Esta identificacion ya se encuentra registrada, intente con otra diferente");
    window.location = "register.php";
    </script>
    ';
    exit();
}

    $verificar_nombre = mysqli_query($conexion, "SELECT * FROM users WHERE nombre='$nombre' ");

if (mysqli_num_rows($verificar_nombre) > 0) {
    echo '
 <script>
    alert("Este nombre ya se encuentra registrado, intente con otro diferente");
    window.location = "register.php";
    </script>
    ';
    exit();
}

$verificar_apellido = mysqli_query($conexion, "SELECT * FROM users WHERE apellido='$apellido' ");

if (mysqli_num_rows($verificar_apellido) > 0) {
    echo '
 <script>
    alert("Este nombre ya se encuentra registrado, intente con otro diferente");
    window.location = "register.php";
    </script>
    ';
    exit();
}

$verificar_correo = mysqli_query($conexion, "SELECT * FROM users WHERE correo='$correo' ");

if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
 <script>
    alert("Este correo ya se encuentra registrado, intente con otro diferente");
    window.location = "register.php";
    </script>
    ';
    exit();
}

$verificar_telefono = mysqli_query($conexion, "SELECT * FROM users WHERE telefono='$telefono' ");

if (mysqli_num_rows($verificar_telefono) > 0) {
    echo '
 <script>
    alert("Este telefono ya se encuentra registrado, intente con otro diferente");
            window.onload = function() {
        setTimeout(function() {
            window.location = "/lib/views/auth/register/register.php";
        }, 0); 
        };
            </script>
            ';
    exit();
}

$ejecutar = mysqli_query($conexion, $query);

if ($ejecutar){
    echo '
    <script>
    alert("Usuario registrado exitosamente");
window.onload = function() {
        setTimeout(function() {
            window.location = "/index.php";
        }, 0); 
        };
            </script>
    ';
}else{
    echo '
    <script>
    alert("Intentelo nuevamente, usuario no registrado");
window.onload = function() {
        setTimeout(function() {
            window.location = "/lib/views/auth/register/register.php";
        }, 0); 
        };
            </script>
    ';
}

mysqli_close($conexion);
?>