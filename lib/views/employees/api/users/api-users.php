<?php
// api/users/api-users.php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'].'/config/server.php';

$method = $_SERVER['REQUEST_METHOD'];
$id     = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;
$input  = json_decode(file_get_contents('php://input'), true) ?: [];

try {
  switch ($method) {
    case 'GET':
      if ($id !== null) {
        $stmt = $conexion->prepare("
          SELECT id, identificacion, nombre, apellido, correo, telefono, rol, genero, fecha_registro
          FROM users
          WHERE identificacion = ?
        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo json_encode($stmt->get_result()->fetch_assoc() ?: []);
      } else {
        $res = $conexion->query("
          SELECT id, identificacion, nombre, apellido, correo, telefono, rol, genero, fecha_registro
          FROM users
        ");
        echo json_encode($res->fetch_all(MYSQLI_ASSOC));
      }
      break;

    case 'POST':
      if ($id) {
        // ─── UPDATE ───────────────────────────────────────────
        // Mapeo campo JS -> columna BD
        $map = [
          'nombre'   => 'nombre',
          'apellido' => 'apellido',
          'correo'   => 'correo',
          'telefono' => 'telefono',
          'genero'   => 'genero'
        ];

        // CORRECTO: $fields array, $types string, $values array
        $fields = [];
        $types  = '';
        $values = [];

        foreach ($map as $jsKey => $col) {
          if (isset($input[$jsKey])) {
            $fields[]  = "$col = ?";
            $types    .= 's';
            $values[]  = $input[$jsKey];
          }
        }
        if (!empty($input['password'])) {
          $fields[]  = "contrasena = ?";
          $types    .= 's';
          $values[]  = password_hash($input['password'], PASSWORD_DEFAULT);
        }

        if (empty($fields)) {
          http_response_code(400);
          exit(json_encode(['error'=>'Nada para actualizar']));
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE identificacion = ?";
        $stmt = $conexion->prepare($sql);

        // añadir el tipo 'i' para el identificador
        $types   .= 'i';
        $values[] = $id;
        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
          echo json_encode(['id'=>$id]);
        } else {
          http_response_code(400);
          echo json_encode(['error'=>$stmt->error]);
        }
      } else {
        // ─── INSERT ───────────────────────────────────────────
        foreach (['identificacion','nombre','apellido','correo','telefono','rol','genero','password'] as $f) {
          if (empty($input[$f])) {
            http_response_code(400);
            exit(json_encode(['error'=>"Falta campo $f"]));
          }
        }
        $passHash = password_hash($input['password'], PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("
          INSERT INTO users
            (identificacion,nombre,apellido,correo,telefono,contrasena,rol,genero)
          VALUES (?,?,?,?,?,?,?,?)
        ");
        $stmt->bind_param(
          'isssssss',
          $input['identificacion'],
          $input['nombre'],
          $input['apellido'],
          $input['correo'],
          $input['telefono'],
          $passHash,
          $input['rol'],
          $input['genero']
        );
        if ($stmt->execute()) {
          echo json_encode(['id'=>$conexion->insert_id]);
        } else {
          http_response_code(400);
          echo json_encode(['error'=>$stmt->error]);
        }
      }
      break;

    case 'DELETE':
      if (!$id) {
        http_response_code(400);
        exit(json_encode(['error'=>'ID no proporcionado']));
      }
      $stmt = $conexion->prepare("DELETE FROM users WHERE identificacion = ?");
      $stmt->bind_param('i', $id);
      if ($stmt->execute()) {
        echo json_encode(['id'=>$id]);
      } else {
        http_response_code(400);
        echo json_encode(['error'=>$stmt->error]);
      }
      break;

    default:
      http_response_code(405);
      echo json_encode(['error'=>'Método no permitido']);
  }
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['error'=>$e->getMessage()]);
}
$conexion->close();
