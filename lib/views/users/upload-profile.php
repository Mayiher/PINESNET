<?php
// upload-profile.php
session_start();

// Determina userId según rol
if (!empty($_SESSION['admin']['identificacion'])) {
    $userId = $_SESSION['admin']['identificacion'];
} elseif (!empty($_SESSION['employees']['identificacion'])) {
    $userId = $_SESSION['employees']['identificacion'];
} elseif (!empty($_SESSION['users']['identificacion'])) {
    $userId = $_SESSION['users']['identificacion'];
} else {
    header('Location: profile.php?error=no-session');
    exit;
}

// Directorio propio del usuario
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/config/photos-profile/{$userId}/";
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    die('No se pudo crear directorio de usuario.');
}

// Validación básica del archivo
if (empty($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    header('Location: profile.php?error=file');
    exit;
}
$allowed = ['image/jpeg','image/png','image/gif'];
if (!in_array($_FILES['avatar']['type'], $allowed)) {
    header('Location: profile.php?error=type');
    exit;
}

// Renombra y elimina previos
$ext      = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
$filename = "avatar.{$ext}";
foreach (glob($uploadDir . 'avatar.*') as $old) {
    unlink($old);
}

// Mueve el nuevo
if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $filename)) {
    header('Location: profile.php?error=move');
    exit;
}

header('Location: profile.php?uploaded=1');
exit;
