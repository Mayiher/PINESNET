<?php
// get-avatar.php
session_start();
$default = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/default-avatar.png';

// Sin sesión válida → defecto
if (empty($_SESSION['admin']['identificacion'])
 && empty($_SESSION['employees']['identificacion'])
 && empty($_SESSION['users']['identificacion'])) {
    $path = $default;
} else {
    // Determina userId
    if (!empty($_SESSION['admin'])) {
        $userId = $_SESSION['admin']['identificacion'];
    } elseif (!empty($_SESSION['employees'])) {
        $userId = $_SESSION['employees']['identificacion'];
    } else {
        $userId = $_SESSION['users']['identificacion'];
    }
    // Busca avatar en su carpeta
    $dir   = $_SERVER['DOCUMENT_ROOT'] . "/config/photos-profile/{$userId}/";
    $found = false;
    foreach (['jpg','jpeg','png','gif'] as $ext) {
        $file = $dir . "avatar.{$ext}";
        if (file_exists($file)) {
            $path  = $file;
            $mime  = mime_content_type($file);
            $found = true;
            break;
        }
    }
    if (!$found) {
        $path = $default;
    }
}

// Envía headers y contenido
if (!isset($mime)) {
    $mime = mime_content_type($path);
}
header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($path));
readfile($path);
exit;
