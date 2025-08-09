<?php
include_once('../../../class/Cls_conductores.php');
$Cls_conductores = new Cls_conductores();

if (!isset($_POST['vehiculo_id'], $_POST['conductor_id'])) {
  echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
  exit;
}


$respuesta = $Cls_conductores->desasignarConductor($_POST['vehiculo_id'], $_POST['conductor_id']);
echo json_encode($respuesta);
?>