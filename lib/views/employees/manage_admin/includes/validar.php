<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/server-local.php';

if (isset($_POST['registrar'])) {

    if (
        strlen($_POST['nombre']) >= 1 &&
        strlen($_POST['apellido']) >= 1 &&
        strlen($_POST['correo']) >= 1 &&
        strlen($_POST['telefono']) >= 1 &&
        strlen($_POST['contrasena']) >= 1 &&
        strlen($_POST['rol']) >= 1 &&
        strlen($_POST['identificacion']) >= 1
    ) {

        $identificacion = trim($_POST['identificacion']);
        $nombre         = trim($_POST['nombre']);
        $apellido       = trim($_POST['apellido']);
        $correo         = trim($_POST['correo']);
        $telefono       = trim($_POST['telefono']);
        $contrasena     = trim($_POST['contrasena']);
        $rol            = trim($_POST['rol']);

        // Se genera el hash de la contraseña
        $contrasena = hash('sha512', $contrasena);

        // Insertar en la tabla employees, ya que los administradores se guardan allí
        $consulta = "INSERT INTO employees (identificacion, nombre, apellido, correo, telefono, contrasena, rol)
                     VALUES (:identificacion, :nombre, :apellido, :correo, :telefono, :contrasena, :rol)";
        $stmt = $conexion->prepare($consulta);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conexion->lastErrorMsg());
        }

        // Se enlazan los parámetros
        $stmt->bindValue(':identificacion', $identificacion, SQLITE3_TEXT);
        $stmt->bindValue(':nombre', $nombre, SQLITE3_TEXT);
        $stmt->bindValue(':apellido', $apellido, SQLITE3_TEXT);
        $stmt->bindValue(':correo', $correo, SQLITE3_TEXT);
        $stmt->bindValue(':telefono', $telefono, SQLITE3_TEXT);
        $stmt->bindValue(':contrasena', $contrasena, SQLITE3_TEXT);
        $stmt->bindValue(':rol', $rol, SQLITE3_TEXT);

        $result = $stmt->execute();

        if ($result) {
            header('Location: ../../index_admin.php');
            exit;
        } else {
            echo '
            <script>
                alert("Inténtelo nuevamente, usuario no registrado");
                window.location.href = "/lib/views/auth/register/register.php";
            </script>
            ';
            exit;
        }
    }
}
?>
