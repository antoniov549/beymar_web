<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// var_dump($_REQUEST);
?>

<style>
.m-b-10{
	margin-bottom: 10px;
}

.m-b-15{
	margin-bottom: 15px;
}

.m-b-20{
	margin-bottom: 20px;
}
.m-b-25{
	margin-bottom: 25px;
}

.m-b-30{
	margin-bottom: 30px;
}
.m-b-35{
	margin-bottom: 35px;
}

.login-form .form-group label {
    display: block;
}

</style>


<div class="modal-header">
	<h1 class="modal-title fs-5" id="modal_ejemplo" >Agregar Usuario</h1>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<!--  -->
	<div>
	<!--  -->
	<form 
		class="form-horizontal" 
		method="post" 
		id="form-add_users" 
		name="form-add_users"
	>		
			<div id="resultados_ajax"></div>

				<div class="form-group m-b-10 ">
					<label for="nivel_user" class=" control-label">Nivel del usuario: </label>
					  <div class="">
					  <select class="form-control" id="nivel_user" name="nivel_user" required>
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

					<div class="form-group m-b-10 col-6">
						<label for="user_name" class=" control-label">Nombre De Usuario:</label>
						<div class="">
						  <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Usuario"  
						  title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)" required>
						</div>
					</div>
					<!--  -->
					<div class="form-group m-b-10 col-6">
						<label for="user_email" class=" control-label">Correo Electronico:</label>
						<div class="">
						  <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Correo electrónico" required>
						</div>
					</div>
					

					<div class="alert alert-danger d-none" role="alert" id="password_error" >
					 	
					</div>


					<div class="form-group m-b-10 col-6">
						<label for="user_password_new" class=" control-label">Contraseña</label>
						<div class="">
						  <input 
						  	type="password" 
						  	class="form-control" 
						  	id="user_password_new" 
						  	name="user_password_new" 
						  	placeholder="Contraseña" 
						  	pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
						</div>
				  	</div>
				  	<!--  -->
				  	<div class="form-group m-b-10 col-6">
						<label for="user_password_repeat" class=" control-label">Repite contraseña</label>
						<div class="">
						  <input 
						  	type="password" 
						  	class="form-control" 
						  	id="user_password_repeat" 
						  	name="user_password_repeat" 
						  	placeholder="Repite contraseña" 
						   	pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
						</div>
				  	</div>

				</div>
				
				<input type="hidden" name="option">

				<div id="documentacion" hidden>
					<!-- <hr> -->
					<!-- <center>
						<h5 class="center">Documentos Requeridos</h5>
					</center> -->
					<!-- Acta Constitutiva -->
					<!-- <div class="mb-3">
					  <label for="acta_constitutiva" class="form-label">Acta Constitutiva (PDF)</label>
					  <input type="file" class="form-control" name="acta_constitutiva" id="acta_constitutiva" accept=".pdf" >
					</div> -->

					<!-- Permiso de ASUR -->
					<<!-- div class="mb-3">
					  <label for="permiso_asur" class="form-label">Permiso de ASUR (PDF)</label>
					  <input type="file" class="form-control" name="permiso_asur" id="permiso_asur" accept=".pdf" >
					</div> -->

					<!-- Placas Federales -->
					<!-- <div class="mb-3">
					  <label for="placas_federales" class="form-label">Placas Federales (PDF o Imagen)</label>
					  <input type="file" class="form-control" name="placas_federales" id="placas_federales" accept=".pdf,.jpg,.jpeg,.png" >
					</div>
 					-->
					<!-- Seguro de Viajes -->
					<!-- <div class="mb-3">
					  <label for="seguro_viajes" class="form-label">Seguro de Viajes (PDF o Imagen)</label>
					  <input type="file" class="form-control" name="seguro_viajes" id="seguro_viajes" accept=".pdf,.jpg,.jpeg,.png" >
					</div> -->

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

	Imprime_roles('nivel_user');

	// $(document).on('change', '#nivel_user', function(event) { 
	// 	var nivel_user=$("#nivel_user option:selected").val();
	// 		console.log(nivel_user);

	// 	switch (nivel_user) {
	// 		case '3':
	// 			requerir_archivos(true);
	// 		break;

	// 		default:
	// 			requerir_archivos(false);
	// 		break;
	// 	}

	// });
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
	    console.log($('#nivel_user').val());
	    // 
	    if ($('#nivel_user').val() === null) {
		  alert('Debes seleccionar un nivel de usuario');
		  $('#nivel_user').focus();
		  return;
		}
	    // cvalidar pasword
	    const password1 = $('#user_password_new').val();
		const password2 = $('#user_password_repeat').val();
		if (password1 !== password2) {
		    $('#password_error').text('Las contraseñas no coinciden');
		    $('#password_error').removeClass('d-none');

		    return;
		} else {
		   
		     $('#password_error').addClass('d-none');
		}
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
// 
function requerir_archivos(boleano) {
	console.log(boleano);
    // Mostrar u ocultar el div dependiendo del valor opuesto
    $('#documentacion').attr('hidden', !boleano);

    // Hacer los campos requeridos si boleano es true
    $('#acta_constitutiva').attr('required', boleano);
    $('#permiso_asur').attr('required', boleano);
    // $('#placas_federales').attr('required', boleano);
    $('#seguro_viajes').attr('required', boleano);
}
////FUNCION PARA REDIRIGIR EL OBJETO DEL FORMULARIO A OTRO PHP Y MOSTRAR LO EN EL MODAL
function EnviarDatos( formData ){
//alert("SE ENVIARON LOS DATOS");
    // AJAX request
	  $('#loaderContainer').show();
    $.ajax({
        url: 'usuarios/aplicarMovimiento.php',
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
function Imprime_roles(contenedor) {
  const $contenedor = $(`#${contenedor}`);
  if (!contenedor || $contenedor.length === 0) return;

  $('#loaderContainer').show();

  $.ajax({
    url: 'usuarios/ajax/Get_roles_usuarios.php',
    method: 'POST',
    success: function (html) {
      $contenedor.html(html);
      console.log(html);
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