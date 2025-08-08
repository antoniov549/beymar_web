<?php
include_once('../../../class/Cls_vehiculos.php');
$Cls_vehiculos = new Cls_vehiculos();

header('Content-Type: application/json');

if (!isset($_POST['vehiculo'])) {
    echo json_encode(['success' => false, 'message' => 'ID de vahiculo no recibido']);
    exit;
}

$vehiculo_id = (int)$_POST['vehiculo'];
$data = $Cls_vehiculos->Get_vahiculo_por_id($vehiculo_id);

if ($data) {
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'vahiculo no encontrado '.$vehiculo_id]);
}
?>
