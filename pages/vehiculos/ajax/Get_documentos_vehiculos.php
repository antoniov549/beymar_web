<?php
include_once('../../../class/Cls_vehiculos.php');
$Cls_vehiculos = new Cls_vehiculos();

header('Content-Type: application/json');

// Validar que se haya enviado el parámetro 'vehiculo'
if (!isset($_POST['vehiculo'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID de vehículo no recibido'
    ]);
    exit;
}

$vehiculo_id = (int)$_POST['vehiculo'];
$data = $Cls_vehiculos->Get_documentos_legales_vehiculos($vehiculo_id);

// Forzar que sea un array asociativo si viene de mysqli o PDO
if (!is_array($data)) {
    $data = json_decode(json_encode($data), true); // fuerza conversión
}

// Verificar si se obtuvo información
if (!empty($data)) {
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Vehículo no encontrado con ID: ' . $vehiculo_id
    ]);
}

?>
