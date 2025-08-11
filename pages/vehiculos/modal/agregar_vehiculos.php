<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// var_dump($_REQUEST);
?>



<div class="modal-header">
	<h1 class="modal-title fs-5" id="modal_ejemplo" >Agregar Vehiculo</h1>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<!--  -->
	<div>
	<!--  -->
	<form 
	  class="form-horizontal" 
	  method="post" 
	  id="form-add_vehiculo" 
	  name="form-add_vehiculo"
	  enctype="multipart/form-data"
	>		

		<input type="hidden" name="option" >


		  <div class="row g-3">
			<div class="col-md-6">
			  <label for="marca" class="form-label">Marca</label>
			  <select class="form-select" id="marca" name="marca" required>
			    <option value="">Seleccione marca</option>
			    <option value="Toyota">Toyota</option>
			    <option value="Nissan">Nissan</option>
			    <option value="Chevrolet">Chevrolet</option>
			    <option value="Ford">Ford</option>
			    <option value="Volkswagen">Volkswagen</option>
			    <option value="Honda">Honda</option>
			    <option value="Hyundai">Hyundai</option>
			    <option value="Kia">Kia</option>
			    <option value="Mazda">Mazda</option>
			    <option value="Renault">Renault</option>
			    <option value="Peugeot">Peugeot</option>
			    <option value="Mercedes-Benz">Mercedes-Benz</option>
			    <option value="BMW">BMW</option>
			    <option value="Dodge">Dodge</option>
			    <option value="Jeep">Jeep</option>
			  </select>
			</div>


      <div class="col-md-6">
        <label for="modelo" class="form-label">Modelo</label>
        <input type="text" class="form-control" id="modelo" name="modelo" required>
      </div>

      <div class="col-md-4">
			  <label for="anio" class="form-label">Año</label>
			  <select class="form-select" id="anio" name="anio" required>
			    <option value="">Seleccione año</option>
			    <option value="2025">2025</option>
			    <option value="2024">2024</option>
			    <option value="2023">2023</option>
			    <option value="2022">2022</option>
			    <option value="2021">2021</option>
			    <option value="2020">2020</option>
			    <option value="2019">2019</option>
			    <option value="2018">2018</option>
			    <option value="2017">2017</option>
			    <option value="2016">2016</option>
			    <option value="2015">2015</option>
			    <option value="2014">2014</option>
			  </select>
			</div>

      <div class="col-md-4">
			  <label for="color" class="form-label">Color</label>
			  <select class="form-select" id="color" name="color" required>
			    <option value="">Seleccione color</option>
			    <option value="Blanco">Blanco</option>
			    <option value="Negro">Negro</option>
			    <option value="Gris">Gris</option>
			    <option value="Plata">Plata</option>
			    <option value="Rojo">Rojo</option>
			    <option value="Azul">Azul</option>
			    <option value="Verde">Verde</option>
			    <option value="Café">Café</option>
			    <option value="Amarillo">Amarillo</option>
			    <option value="Naranja">Naranja</option>
			    <option value="Vino">Vino</option>
			    <option value="Dorado">Dorado</option>
			    <option value="Beige">Beige</option>
			    <option value="Otro">Otro</option>
			  </select>
			</div>

      <div class="col-md-4">
        <label for="capacidad" class="form-label">Capacidad</label>
        <input type="number" class="form-control" id="capacidad" name="capacidad" min="1" required>
      </div>

      <div class="col-md-6">
        <label for="numero_serie" class="form-label">Número de Serie</label>
        <input type="text" class="form-control" id="numero_serie" name="numero_serie" required>
      </div>

      <div class="col-md-6">
        <label for="numero_motor" class="form-label">Número de Motor</label>
        <input type="text" class="form-control" id="numero_motor" name="numero_motor" required>
      </div>

      <div class="col-md-6">
        <label for="placas" class="form-label">Placas</label>
        <input type="text" class="form-control" id="placas" name="placas" required>
      </div>

      <div class="col-md-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" id="tipo" name="tipo" required>
          <option value="">Seleccione tipo</option>
          <option value="Privado">Privado</option>
          <option value="Suburban">Suburban</option>
        </select>
      </div>


      <div class="col-md-3">
        <label for="estado_vehiculo" class="form-label">Estado del Vehículo</label>
        <select class="form-select" id="estado_vehiculo" name="estado_vehiculo" required>
          <option value="Activo">Activo</option>
          <option value="Mantenimiento">Mantenimiento</option>
          <option value="En reparación">En reparación</option>
          <option value="Nuevo ingreso">Nuevo ingreso</option>
        </select>
      </div>
    </div>
    <hr class="my-4" />
   	<center><h4>Documentos Legales</h4></center>

    <!-- Registro -->
    <div class="mb-4">
    	<div class="row">
    				<div class="col-12">
					      <label class="form-label" data-bs-toggle="tooltip" data-bs-placement="right"
					             title="Documento oficial que acredita el Permiso para manejar y circular en la vía pública.">
					        Registro / Circulación <i class="bi bi-info-circle"></i>
					      </label>
					      <input class="form-control" type="file" name="documentos[registro][archivo]" accept=".pdf,.jpg,.png" required />
				    	</div>

				      <div class="col-6">
					      <label for="registro_inicio" class="form-label mt-2">Fecha Vigencia Inicio</label>
					      <input type="date" class="form-control" id="registro_inicio" name="documentos[registro][fecha_vigencia_inicio]" required />
				    	</div>

				    	<div class="col-6">
					      <label for="registro_fin" class="form-label mt-2">Fecha Vigencia Fin</label>
					      <input type="date" class="form-control" id="registro_fin" name="documentos[registro][fecha_vigencia_fin]"  required />
					    </div>
    	</div>
    </div>
   
    <!-- Póliza de Seguro -->
    <hr class="my-4" />
    <div class="mb-4">
    	<div class="row">
    	<div class="col-12">
    		<label class="form-label" data-bs-toggle="tooltip" data-bs-placement="right"
             title="Póliza de seguro vigente que cubre al vehículo contra riesgos y daños.">
        	Póliza de Seguro <i class="bi bi-info-circle"></i>
      	</label>
      	<input class="form-control" type="file" name="documentos[poliza_seguro][archivo]" accept=".pdf,.jpg,.png" required />
    	</div>

    	<div class="col-6">
    			<label for="poliza_inicio" class="form-label mt-2">Fecha Vigencia Inicio</label>
      		<input type="date" class="form-control" id="poliza_inicio" name="documentos[poliza_seguro][fecha_vigencia_inicio]" required />
    	</div>
      
    	<div class="col-6">
    		<label for="poliza_fin" class="form-label mt-2">Fecha Vigencia Fin</label>
      	<input type="date" class="form-control" id="poliza_fin" name="documentos[poliza_seguro][fecha_vigencia_fin]"  required />
    	</div>

    	</div>
    </div>

    
    <!-- Verificación -->
    <hr class="my-4" />
    <div class="mb-4">
      <div class="row">
				<div class="col-12">
					<label class="form-label" data-bs-toggle="tooltip" data-bs-placement="right"
					title="Constancia oficial de verificación vehicular, que certifica que el vehículo cumple con normas ambientales.">
					Verificación <i class="bi bi-info-circle"></i>
					</label>
					<input class="form-control" type="file" name="documentos[verificacion][archivo]" accept=".pdf,.jpg,.png" required />
				</div>

				<div class="col-6">
					<label for="verificacion_inicio" class="form-label mt-2">Fecha Vigencia Inicio</label>
					<input type="date" class="form-control" id="verificacion_inicio" name="documentos[verificacion][fecha_vigencia_inicio]" required />
				</div>

				<div class="col-6">
					<label for="verificacion_fin" class="form-label mt-2">Fecha Vigencia Fin</label>
					<input type="date" class="form-control" id="verificacion_fin" name="documentos[verificacion][fecha_vigencia_fin]"  required />
				</div>
      </div>
    </div>

    <!-- Tarjeta de Propiedad -->
    <hr class="my-4" />
    <div class="mb-4">
      <div class="row">

      		<div class="col-12">
      			<label class="form-label" data-bs-toggle="tooltip" data-bs-placement="right"
						   title="Documento que acredita la propiedad legal del vehículo a nombre del propietario registrado.">
						Tarjeta de Propiedad <i class="bi bi-info-circle"></i>
						</label>
						<input class="form-control" type="file" name="documentos[tarjeta_propiedad][archivo]" accept=".pdf,.jpg,.png" required />
      		</div>

      		<div class="col-6">
      			<label for="tarjeta_inicio" class="form-label mt-2">Fecha Vigencia Inicio</label>
  					<input type="date" class="form-control" id="tarjeta_inicio" name="documentos[tarjeta_propiedad][fecha_vigencia_inicio]" required />		
      		</div>

      		<div class="col-6">
      			<label for="tarjeta_fin" class="form-label mt-2">Fecha Vigencia Fin</label>
    				<input type="date" class="form-control" id="tarjeta_fin" name="documentos[tarjeta_propiedad][fecha_vigencia_fin]" required />
      		</div>

      </div>
    </div>

		

	</form>
	<!--  -->
	</div>
	<!--  -->
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
	<button type="button" class="btn btn-primary guardar"><i class="fa fa-save"></i>&nbsp;Guardar</button>
</div>	


<script type="text/javascript">
$(document).ready(function() {
///////////////////////////////////////////

  // Inicializar tooltips Bootstrap
  const tooltipTriggerList = [...document.querySelectorAll('[data-bs-toggle="tooltip"]')]
  tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


// 
$('.guardar').on('click', function () {
		// 
	    const form = document.getElementById("form-add_vehiculo");
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
});

////FUNCION PARA REDIRIGIR EL OBJETO DEL FORMULARIO A OTRO PHP Y MOSTRAR LO EN EL MODAL
function EnviarDatos( formData ){
//alert("SE ENVIARON LOS DATOS");
    // AJAX request
	  $('#loaderContainer').show();
    $.ajax({
        url: 'vehiculos/aplicarMovimiento.php',
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){ 
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





</script>