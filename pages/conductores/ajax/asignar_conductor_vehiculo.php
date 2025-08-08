<?php
include_once('../../../class/Cls_conductores.php');
$Cls_conductores = new Cls_conductores();


if (!isset($_POST['vehiculo_id'], $_POST['conductor_id'])) {
  echo json_encode(['success' => false, 'message' => 'Faltan datos']);
  exit;
}

$vehiculo_id = (int)$_POST['vehiculo_id'];
$conductor_id = (int)$_POST['conductor_id'];

$response = $Cls_conductores->asignarConductorAVehiculo($vehiculo_id, $conductor_id);
echo json_encode($response);

?>