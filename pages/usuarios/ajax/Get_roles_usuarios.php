<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// var_dump($_REQUEST);

include_once('../../../class/Cls_usuarios.php');
$Cls_usuarios = new Cls_usuarios();



$result = $Cls_usuarios->Get_roles_usuarios();

if ($result) {
	echo '<option selected disabled >Selecciona una opcion</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $rol_id = htmlspecialchars($row['rol_id']);
        $nombre = htmlspecialchars($row['nombre']);
        echo "<option value='$rol_id'>$nombre</option>";
    }
} else {
    echo "<option value=''>Error al obtener roles</option>";
}


?>

