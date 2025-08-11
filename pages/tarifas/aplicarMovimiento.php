<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../includes/comprobar_logeo.php');

include_once('../../class/Cls_viajes.php');
$Cls_viajes = new Cls_viajes();


/// zona
$zona = isset($_REQUEST['zona']) ? trim((string)$_REQUEST['zona']) : '';
var_dump($_REQUEST);

?>

<div class="modal-header">
	<h1 class="modal-title fs-5" id="modal_ejemplo" >resultado: <?php echo $opcion; ?></h1>
	<button type="button" class="btn-close btn_alert" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

	<div>
	<?php 
      //echo $mensaje;
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