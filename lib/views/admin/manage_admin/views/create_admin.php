<?php

require '../../../shared/header/header.php';

if(!isset($_SESSION['admin']) || $_SESSION['admin']['rol'] != 'Administrador') {
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
<body>

<body id="page-top">

<form  action="../includes/validar.php" method="POST">
<div id="login" >
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                    
                            <br>
                            <br>
                            <h3 class="text-center">Registro de nuevo usuario</h3>
                            <div class="form-group">
                                <label for="identificacion">Identificacion *</label><br>
                                <input type="number" name="identificacion" id="identificacion" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text"  id="nombre" name="nombre" class="form-control" required>
                            </div>
                             <div class="form-group">
                            <label for="apellido" class="form-label">Apellido *</label>
                            <input type="text"  id="apellido" name="apellido" class="form-control" required>
                            </div>
                             <div class="form-group">
                            <label for="correo" class="form-label">Correo *</label>
                            <input type="email"  id="correo" name="correo" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono" class="form-label">Telefono *</label><br>
                                <input type="number" name="telefono" id="telefono" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                  <label for="contrasena" class="form-label">Contraseña *</label>
                                <input type="password"  id="contrasena" name="contrasena" class="form-control" required>
                            
                            <div class="form-group">
                                  <label for="rol" class="form-label">Rol de usuario *</label>
                                 <select id="rol" name="rol" class="form-control" required>
                                 <option value="">Selecciona un rol...</option>
                                 <option value="Administrador">Administrador</option>
                                 </select>
                                 </div>
                           <br>

                                <div class="mb-3">
                                    
                               <input type="submit" value="Guardar"class="btn btn-success" 
                               name="registrar">
                               <a href="../../index_admin.php" class="btn btn-danger">Cancelar</a>
                               
                            </div>
                            </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</body>
</html>