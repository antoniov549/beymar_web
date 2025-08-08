<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_REQUEST);

/// option
$option = isset($_REQUEST['option']) ? trim((string)$_REQUEST['option']) : '';

/// vehiculo
$vehiculo = isset($_REQUEST['vehiculo']) ? trim((string)$_REQUEST['vehiculo']) : '';

if ($option == 'detalles' ) {
	$titulo='Detalles';
	$boton_accion='';
	
}else{
	$titulo='Eliminar vehiculo';
	$boton_accion='<button type="button" class="btn btn-danger borrar"><i class="fa fa-delete-left"></i>&nbsp;Borrar</button>';

}

?>



<div class="modal-header">
	<h1 class="modal-title fs-5" id="modal_ejemplo" ><?php echo $titulo; ?></h1>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<!--  -->
	
	<form 
		class="form-horizontal" 
		method="post" 
		id="form-add_users" 
		name="form-add_vehiculo"
	>		
		<input type="hidden" id="vehiculo_id" name="vehiculo_id" value="<?= $vehiculo ?>" readonly>
		<input type="hidden" name="option"      value="<?= $option ?>">


				
		<!--  -->
		<div class="row g-3">
			<div class="col-md-6">
			  <label for="marca" class="form-label">Marca</label>
			  <select class="form-select" id="marca" name="marca" disabled>
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
				<input type="text" class="form-control" id="modelo" name="modelo" readonly>
			</div>

			<div class="col-md-4">
			  <label for="anio" class="form-label">Año</label>
			  <select class="form-select" id="anio" name="anio" disabled>
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
			  <select class="form-select" id="color" name="color" disabled>
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
				<input type="number" class="form-control" id="capacidad" name="capacidad" min="1" readonly>
			</div>

			<div class="col-md-6">
				<label for="numero_serie" class="form-label">Número de Serie</label>
				<input type="text" class="form-control" id="numero_serie" name="numero_serie" readonly>
			</div>

			<div class="col-md-6">
				<label for="numero_motor" class="form-label">Número de Motor</label>
				<input type="text" class="form-control" id="numero_motor" name="numero_motor" readonly>
			</div>

			<div class="col-md-6">
				<label for="placas" class="form-label">Placas</label>
				<input type="text" class="form-control" id="placas" name="placas" readonly>
			</div>

			<div class="col-md-3">
				<label for="tipo" class="form-label">Tipo</label>
				<select class="form-select" id="tipo" name="tipo" disabled>
					<option value="">Seleccione tipo</option>
					<option value="Camioneta">Camioneta</option>
					<option value="Van">Van</option>
					<option value="Combi">Combi</option>
					<option value="Camión">Camión</option>
					<option value="Carga ligera">Carga ligera</option>
				</select>
			</div>


			<div class="col-md-3">
				<label for="estado_vehiculo" class="form-label">Estado del Vehículo</label>
				<select class="form-select" id="estado_vehiculo" name="estado_vehiculo" disabled>
					<option value="Activo">Activo</option>
					<option value="Mantenimiento">Mantenimiento</option>
					<option value="En reparación">En reparación</option>
					<option value="Nuevo ingreso">Nuevo ingreso</option>
				</select>
			</div>
		</div>
		<hr class="my-4" />
		<center><h4>Documentos Legales</h4></center>
		<div id="contenedor-documentos">
			
		</div>

		<!--  -->
	</form>
	<!--  -->
	</div>

<!--  -->
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
	<?php echo $boton_accion; ?>
</div>	


<script type="text/javascript">
$(document).ready(function () {
  const vehiculo_id = $('#vehiculo_id').val();
  const option = $('input[name="option"]').val();

  cargarInformacionVehiculo(vehiculo_id);
  console.log(option);
  if (option === 'detalles') {
    cargarDocumentacionVehiculo(vehiculo_id);
	}
 

 

  $('.borrar').on('click', function () {
		// 
	    const form = document.getElementById("form-add_users");
	    // Valida los campos requeridos del formulario
	    if (!form.checkValidity()) {
	        form.reportValidity(); // Muestra mensajes de error nativos del navegador
	        return; // No continúa si no pasa la validación
	    }
	    
		
		$('input[name="option"]').val('borrar');

	    // Confirmación del vehiculo
	    let respuesta_confirmacion_envio = confirm("SE ENVIARAN LOS DATOS!!");
	    if (respuesta_confirmacion_envio) {
	        var formData = new FormData(form);
	        EnviarDatos(formData);
	    }
	});



});





// Cargar la información del vehiculo por ID
function cargarInformacionVehiculo(vehiculo_id) {
  if (!vehiculo_id) return;

  $('#loaderContainer').show();

  $.ajax({
    url: 'vehiculos/ajax/Get_informacion_vehiculos.php',
    method: 'POST',
    dataType: 'json',
    data: { vehiculo: vehiculo_id },
    success: function (response) {
      //console.log('vehiculo cargado:', response);
      if (response.success && response.data) {
				const vehiculo = response.data;
				$('#marca').val(vehiculo.marca);
				$('#modelo').val(vehiculo.modelo);
				$('#anio').val(vehiculo.anio);
				$('#color').val(vehiculo.color);
				$('#capacidad').val(vehiculo.capacidad);
				$('#numero_serie').val(vehiculo.numero_serie);
				$('#numero_motor').val(vehiculo.numero_motor);
				$('#placas').val(vehiculo.placas);
				$('#tipo').val(vehiculo.tipo);
				$('#estado_vehiculo').val(vehiculo.estado_vehiculo);

      } else {
        alert('No se encontró el vehiculo.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error al cargar la información del vehiculo:', error);
    },
    complete: function () {
      $('#loaderContainer').hide();
    }
  });
}

// Cargar la información del vehiculo por ID
function cargarDocumentacionVehiculo(vehiculo_id) {
  if (!vehiculo_id) return;

  $('#loaderContainer').show();

  $.ajax({
    url: 'vehiculos/ajax/Get_documentos_vehiculos.php',
    method: 'POST',
    dataType: 'json',
    data: { vehiculo: vehiculo_id },
    success: function (response) {
      //console.log(response);

      if (response.success && response.data) {
        const documentos = response.data;
        const contenedor = $('#contenedor-documentos');
        contenedor.empty(); // Limpiar contenido anterior

        documentos.forEach((doc) => {
          const fechaFin = new Date(doc.fecha_vigencia_fin);
          const fechaInicio = new Date(doc.fecha_vigencia_inicio);
          const hoy = new Date();

          // Calcular meses restantes
          const diffMs = fechaFin - hoy;
					const diffMeses = diffMs / (1000 * 60 * 60 * 24 * 30.44); // Aproximación meses

					let alertClass = 'alert-danger';
					let mensaje = 'VENCE PRONTO';

					// Primero verifica si está vencido
					if (diffMeses < 0) {
					  alertClass = 'alert-danger';
					  mensaje = 'VENCIDO';
					} else if (diffMeses > 6) {
					  alertClass = 'alert-success';
					  mensaje = 'Vigencia larga';
					} else if (diffMeses >= 1) {
					  alertClass = 'alert-warning';
					  mensaje = 'Vigencia media';
					} else {
					  // Menos de 1 mes pero no vencido
					  alertClass = 'alert-danger';
					  mensaje = 'Vence pronto';
					}

          // Al construir los datos que retornas:
					const rutaServidor = doc.archivo_url; // viene algo como "/var/www/html/pages/vehiculos/archivos_vehiculos/..."
					const rutaPublica = rutaServidor.replace('/var/www/html', ''); // resultado: "/pages/vehiculos/archivos_vehiculos/..."
					const urlCompleta = window.location.origin + rutaPublica; // "https://tusitio.com/pages/vehiculos/archivos_vehiculos/..."
					if (doc.tipo_documento == 'registro' ) {alertClass='alert-secondary'}
					if (doc.tipo_documento == 'tarjeta_propiedad' ) {alertClass='alert-secondary'}

          const html = `
            <div class="alert ${alertClass}" role="alert">
              <h5 class="mb-1">${doc.tipo_documento}</h5>
              <p class="mb-0">
                Vigencia: ${doc.fecha_vigencia_inicio} → ${doc.fecha_vigencia_fin}<br>
                <strong>${mensaje}</strong> (${Math.floor(diffMeses)} meses restantes)
              </p>
              <a href="${rutaPublica}" target="_blank" class="btn btn-sm btn-outline-dark mt-2">Ver archivo</a>
            </div>
          `;

          contenedor.append(html);
        });

      } else {
        $('#contenedor-documentos').html(`
          <div class="alert alert-secondary" role="alert">
            No se encontró documentación para este vehículo.
          </div>
        `);
      }
    },
    error: function (xhr, status, error) {
      console.error('Error al cargar la información del vehículo:', error);
    },
    complete: function () {
      $('#loaderContainer').hide();
    }
  });
}


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
          $('#modal-xl').modal('hide');
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

</script>