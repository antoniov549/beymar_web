<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// var_dump($_REQUEST);

include_once('../../../class/Cls_conductores.php');
$Cls_conductores = new Cls_conductores();

/// tipo_vehiculo
$tipo_vehiculo = isset($_REQUEST['tipo_vehiculo']) ? trim((string)$_REQUEST['tipo_vehiculo']) : '';

/// cantidad_personas
$cantidad_personas = isset($_REQUEST['cantidad_personas']) ? trim((string)$_REQUEST['cantidad_personas']) : '';


$result=$Cls_conductores->Get_conductores_por_estado_vehiculo('libre',$tipo_vehiculo, $cantidad_personas );


if ($result) {
	echo '<option selected disabled >Selecciona una opcion</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $conductor_id = htmlspecialchars($row['conductor_id']);
        $nombre = htmlspecialchars($row['nombre']." ".$row['apellido'] );
        echo "<option value='$rol_id'>$nombre</option>";
    }
} else {
    echo "<option value=''>Error al obtener Conductores</option>";
}


?>

