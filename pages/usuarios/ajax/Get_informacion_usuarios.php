<?php
include_once('../../../class/Cls_usuarios.php');
$Cls_usuarios = new Cls_usuarios();

header('Content-Type: application/json');

if (!isset($_POST['user'])) {
    echo json_encode(['success' => false, 'message' => 'ID de usuario no recibido']);
    exit;
}

$user_id = (int)$_POST['user'];
$data = $Cls_usuarios->Get_usuario_por_id($user_id);

if ($data) {
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
}
?>
