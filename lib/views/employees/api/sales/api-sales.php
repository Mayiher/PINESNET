<?php
// api/sales/api-sales.php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'].'/config/server.php';

$method=$_SERVER['REQUEST_METHOD'];
$id    =isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):null;
$in    =json_decode(file_get_contents('php://input'),true)?:[];

try {
  switch($method){
    case 'GET':
      if($id!==null){
        $s=$conexion->prepare("SELECT * FROM sales WHERE id_venta=?");
        $s->bind_param('i',$id); $s->execute();
        echo json_encode($s->get_result()->fetch_assoc()?:[]);
      } else {
        echo json_encode($conexion->query("SELECT * FROM sales")->fetch_all(MYSQLI_ASSOC));
      }
      break;
    case 'POST':
      if($id){
        $st=$conexion->prepare("
          UPDATE sales SET
            id_usuario=?,fecha=?,subtotal=?,total_iva=?,descuento=?,total=?
          WHERE id_venta=?
        ");
        $st->bind_param(
          'isiiiii',
          $in['id_usuario'],$in['fecha'],
          $in['subtotal'],$in['total_iva'],
          $in['descuento'],$in['total'],
          $id
        );
        if($st->execute()) echo json_encode(['id_venta'=>$id]);
        else{ http_response_code(400); echo json_encode(['error'=>$st->error]); }
      } else {
        $st=$conexion->prepare("
          INSERT INTO sales
            (id_usuario,fecha,subtotal,total_iva,descuento,total)
          VALUES (?,?,?,?,?,?)
        ");
        $st->bind_param(
          'isiiii',
          $in['id_usuario'],$in['fecha'],
          $in['subtotal'],$in['total_iva'],
          $in['descuento'],$in['total']
        );
        if($st->execute()) echo json_encode(['id_venta'=>$conexion->insert_id]);
        else{ http_response_code(400); echo json_encode(['error'=>$st->error]); }
      }
      break;
    case 'DELETE':
      if(!$id){ http_response_code(400); exit(json_encode(['error'=>'ID no enviado'])); }
      $st=$conexion->prepare("DELETE FROM sales WHERE id_venta=?");
      $st->bind_param('i',$id);
      if($st->execute()) echo json_encode(['id_venta'=>$id]);
      else{ http_response_code(400); echo json_encode(['error'=>$st->error]); }
      break;
    default:
      http_response_code(405);
      echo json_encode(['error'=>'Método no permitido']);
  }
} catch(Exception $e){
  http_response_code(500);
  echo json_encode(['error'=>$e->getMessage()]);
}
$conexion->close();
