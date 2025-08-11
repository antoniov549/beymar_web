<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_REQUEST);

include_once('../../../class/Cls_tarifas.php');
$Cls_tarifas = new Cls_tarifas();

include_once('../../../class/Cls_conductores.php');
$Cls_conductores = new Cls_conductores();



/// viaje
$viaje = isset($_REQUEST['viaje']) ? trim((string)$_REQUEST['viaje']) : '';
/// vehiculo
$vehiculo = isset($_REQUEST['vehiculo']) ? trim((string)$_REQUEST['vehiculo']) : '';
/// rango
$rango = isset($_REQUEST['rango']) ? trim((string)$_REQUEST['rango']) : '';

/// zona
$zona = isset($_REQUEST['zona']) ? trim((string)$_REQUEST['zona']) : '';



// Dividir rango en mínimo y máximo
$minimo = $maximo = null;
if ($rango !== '') {
    $partes = explode('-', $rango);
    if (count($partes) === 2) {
        $minimo = $partes[0];
        $maximo = $partes[1];
    }
}

// Reemplazar "_" por espacio en zona
$zona_limpia = str_replace('_', ' ', $zona);

$result = $Cls_tarifas->Get_informacion_tarifas($zona_limpia, $vehiculo, $viaje, $minimo, $maximo);

$datos_consulta = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($fila = mysqli_fetch_assoc($result)) {
        $datos_consulta[] = $fila;
    }
}


?>



<div class="modal-header">
	<h1 class="modal-title fs-5" id="modal_ejemplo" >titulo del modal</h1>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<!--  -->
	<div class="card">
	  <div class="card-body">

		<form 
			class="form-horizontal" 
			method="post" 
			id="form-add_viaje" 
			name="form-add_viaje"
		>

		<input type="hidden" name="vehiculo" value="<?= htmlspecialchars($vehiculo) ?>" >
		<input type="hidden" name="option" >

		
		

		<div class="form-group m-b-10 ">
			<label for="cantidad_personas" class=" control-label">Cantidad de Pasajeros: </label>
			  <div class="">
			  <select class="form-control" id="cantidad_personas" name="cantidad_personas" required>
			  	<option selected>Selecciona una opcion</option>
			    <?php 
			    foreach ($datos_consulta as $fila) {
			    ?>
			    	<option value="<?= $fila['cantidad_personas'] ?>"><?= $fila['cantidad_personas'] ?></option>
			    <?php 
				}
			    ?>
			  </select>
			 </div>
		</div>

		<div class="row">
					<div class="form-group m-b-10 col-6 ">
						<label for="firstname" class=" control-label">Nombres</label>
						<div class="">
						  <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Nombres" required>
						</div>
					</div>

					<div class="form-group m-b-10 col-6">
						<label for="lastname" class=" control-label">Apellidos</label>
						<div class="">
						  <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Apellidos" required>
						</div>
					</div>
		</div>



	
		<div class="form-group m-b-10  ">
			<label for="fecha_inicio" class=" control-label">Fecha Inicial</label>
			<div class="">		  
			  <input class="form-control" type="datetime-local"  id="fecha_inicio" required >
			</div>
		</div>



		<div class="form-group m-b-10 ">
			<label for="conductores" class=" control-label">Conductor: </label>
			  <div class="">
			  <select class="form-control" id="conductores" name="conductores" disabled>
			  	<option selected>Selecciona una opcion</option>
			    
			  </select>
			 </div>
		</div>


		</form>


	  </div>
	</div>
<!--  -->
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
	<button type="button" class="btn btn-primary guardar"><i class="zmdi zmdi-delete"></i>&nbsp;BORRAR</button>
</div>	


<script type="text/javascript">
$(document).ready(function() {

///establecer el valir minimo para las fechas
setMinFecha();

///////////////////////////////////////////
$(document).on('change', '#cantidad_personas', function(event) {
    var cantidad_personas = $("#cantidad_personas option:selected").val();
    var vehiculo = $('input[name="vehiculo"]').val();
    console.log(cantidad_personas + ' ' + vehiculo);
    Imprime_conductores('conductores', vehiculo, cantidad_personas);
});


// 
$('.guardar').on('click', function () {
	// 
    const form = document.getElementById("form-add_users");
    // Valida los campos requeridos del formulario
    if (!form.checkValidity()) {
        form.reportValidity(); // Muestra mensajes de error nativos del navegador
        return; // No continúa si no pasa la validación
    }
    // 
	$('input[name="option"]').val('insert');
    // Confirmación del usuario
    let respuesta_confirmacion_envio = confirm("SE ENVIARAN LOS DATOS!!");
    if (respuesta_confirmacion_envio) {
        var formData = new FormData(form);
        EnviarDatos(formData);
    }
});
///////////////////////////////////////////


///////////////////////////////////////////
});



function setMinFecha() {

	  const inputFecha = document.getElementById('fecha_inicio');

	const now = new Date();

	// Formatear a YYYY-MM-DDTHH:mm (sin segundos)
	const year = now.getFullYear();
	const month = String(now.getMonth() + 1).padStart(2, '0');
	const day = String(now.getDate()).padStart(2, '0');
	const hours = String(now.getHours()).padStart(2, '0');
	const minutes = String(now.getMinutes()).padStart(2, '0');

	const minFecha = `${year}-${month}-${day}T${hours}:${minutes}`;
	inputFecha.min = minFecha;
}



////FUNCION PARA REDIRIGIR EL OBJETO DEL FORMULARIO A OTRO PHP Y MOSTRAR LO EN EL MODAL
function EnviarDatos( formData ){
//alert("SE ENVIARON LOS DATOS");
    // AJAX request
	  $('#loaderContainer').show();
    $.ajax({
        url: 'tarifas/aplicarMovimiento.php',
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){ 
          // Add response in Modal body
          //modal-xl_center_scrollable

          $('#modal-lg_sub').modal('hide');
          $('#modal-xl_scrollable').modal('hide');
          
          // Add response in Modal body
          $('#modal-lg .modal-content').html(response);
          // Display Modal
          $('#modal-lg').modal('show'); 
          $('#loaderContainer').hide();

        },
          error: function () {
             $('#loaderContainer').hide();
          }
    });

}
// 

// 
function Imprime_conductores(contenedor, tipo_vehiculo, cantidad_personas) {
  const $contenedor = $(`#${contenedor}`);
  if (!contenedor || $contenedor.length === 0) return;

 

  $.ajax({
    url: 'conductores/ajax/Get_conductores_disponibles.php',
    method: 'POST',
    data: {
      tipo_vehiculo: tipo_vehiculo,
      cantidad_personas: cantidad_personas
    },
    success: function (html) {
      $contenedor.html(html);
      console.log(html);
      $('#conductores').prop('disabled', false);  // Habilita el select
    },
    error: function (xhr, status, error) {
      console.error('Error al cargar los datos:', error);
    },
    complete: function () {
      $('#loaderContainer').hide();
    }
  });
}


</script>