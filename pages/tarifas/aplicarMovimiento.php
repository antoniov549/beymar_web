<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_REQUEST);

include('../../includes/comprobar_logeo.php');

include_once('../../class/Cls_viajes.php');
$Cls_viajes = new Cls_viajes();

include_once('../../class/Cls_conductores.php');
$Cls_conductores = new Cls_conductores();


/// option
$option = isset($_REQUEST['option']) ? trim((string)$_REQUEST['option']) : '';
/// vehiculo
$vehiculo = isset($_REQUEST['vehiculo']) ? trim((string)$_REQUEST['vehiculo']) : '';
/// cantidad_personas
$cantidad_personas = isset($_REQUEST['cantidad_personas']) ? trim((string)$_REQUEST['cantidad_personas']) : '';
/// firstname
$firstname = isset($_REQUEST['firstname']) ? trim((string)$_REQUEST['firstname']) : '';
/// lastname
$lastname = isset($_REQUEST['lastname']) ? trim((string)$_REQUEST['lastname']) : '';
/// conductores
$conductores = isset($_REQUEST['conductores']) ? trim((string)$_REQUEST['conductores']) : '';
/// fecha_inicio
$fecha_inicio = isset($_REQUEST['fecha_inicio']) ? trim((string)$_REQUEST['fecha_inicio']) : '';

/// tarifa_id
$tarifa_id = isset($_REQUEST['tarifa_id']) ? trim((string)$_REQUEST['tarifa_id']) : '';

$pasajero=$firstname." ".$lastname;


$date = new DateTime($fecha_inicio);
$fecha_mysql = $date->format('Y-m-d H:i:s');


?>

<div class="modal-header">
	<h1 class="modal-title fs-5" id="modal_ejemplo" >resultado: <?php echo $option; ?></h1>
	<button type="button" class="btn-close btn_alert" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

	<div>
	<?php 
		switch ($option) {
			case 'insert':
					$respuesta=$Cls_viajes->insertar_viaje( $conductores, $tarifa_id, $pasajero, $fecha_mysql, 'Inicio_viaje' );
					
					if ($respuesta['success']) {
						$respuesta=$Cls_conductores->Update_estado_conductor('activo', $conductores);
						echo $respuesta['message'];
					}else{
						echo $respuesta['message'];
					}

				break;

			
			default:
				echo '	<div class="alert alert-warning" role="alert">
						  Opcion no valida!!
					    </div>';
				break;
		}
     	
	 ?>
	</div>


</div>
<div class="modal-footer">
	<button type="button" class="btn btn-success btn_alert"  data-bs-dismiss="modal">OK</button>
</div>	


<script type="text/javascript">
$(document).ready(function() {
///////////////////////////////////////////



$('.btn_alert').on('click', function() {
	window.location.href = location.href;
});



// setTimeout(function(){
// 	window.location.href = location.href;
// }, 11000);


document.body.addEventListener("keydown", function(event) {
	//console.log(event.code, event.keyCode);
	if (event.code === 'Escape' || event.keyCode === 27) {
	// Aqui la lógica para el caso de Escape ...
	window.location.href = location.href;

	}
});



///////////////////////////////////////////
});
</script>