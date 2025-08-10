<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

var_dump($_REQUEST);
?>



<div class="modal-header">
	<h1 class="modal-title fs-5" id="modal_ejemplo" >titulo del modal</h1>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

	<div>
	<?php 
      echo "conenido del modal";
	 ?>
	</div>


</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
	<button type="button" class="btn btn-danger accion"><i class="zmdi zmdi-delete"></i>&nbsp;BORRAR</button>
</div>	


<script type="text/javascript">
$(document).ready(function() {
///////////////////////////////////////////



//$(".table-resultados").stickyTableHeaders();
$('.accion').on('click', function() {
	alert(`esto es el alert`);
});


///////////////////////////////////////////
});
</script>