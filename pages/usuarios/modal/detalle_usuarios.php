<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_REQUEST);

/// option
$option = isset($_REQUEST['option']) ? trim((string)$_REQUEST['option']) : '';

/// user
$user = isset($_REQUEST['user']) ? trim((string)$_REQUEST['user']) : '';

if ($option == 'editar' ) {
	$titulo='Cambiar Contrasena';
	$boton_accion='<button type="button" class="btn btn-primary editar"><i class="fa fa-save"></i>&nbsp;Guardar</button>';
	$campos_password='
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
	';

}else{
	$titulo='Eliminar Usuario';
	$boton_accion='<button type="button" class="btn btn-danger borrar"><i class="fa fa-delete-left"></i>&nbsp;Borrar</button>';
	$campos_password='';

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
		name="form-add_users"
	>		
			<input type="hidden" id="usuario_id" name="usuario_id" value="<?php echo $user; ?>" readonly>

			<div id="resultados_ajax"></div>

				<div class="form-group m-b-10 ">
					<label for="rol_id" class=" control-label">Nivel del usuario: </label>
					  <div class="">
					  <select class="form-control" id="rol_id" name="rol_id" required>
					  </select>
					 </div>
				</div>

				

				<div class="row">
					<div class="form-group m-b-10 col-6 ">
						<label for="nombre" class=" control-label">Nombres</label>
						<div class="">
						  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombres" readonly>
						</div>
					</div>

					<div class="form-group m-b-10 col-6">
						<label for="apellido" class=" control-label">Apellidos</label>
						<div class="">
						  <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellidos" readonly>
						</div>
					</div>

					<div class="form-group m-b-10 col-6">
						<label for="user_name" class=" control-label">Nombre De Usuario:</label>
						<div class="">
						  <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Usuario"  
						  title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)" readonly>
						</div>
					</div>
					<!--  -->
					<div class="form-group m-b-10 col-6">
						<label for="correo" class=" control-label">Correo Electronico:</label>
						<div class="">
						  <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electrónico" required>
						</div>
					</div>
					

					<div class="alert alert-danger d-none" role="alert" id="password_error" >
					 	
					</div>
					<?php echo $campos_password; ?>

					

				</div>
				
				<input type="hidden" name="option">
				
		</div>

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
  const userId = $('#usuario_id').val();

  cargarRoles('#rol_id', function () {
    cargarInformacionUsuario(userId);
  });


  	$('.editar').on('click', function () {
		// 
	    const form = document.getElementById("form-add_users");
	    // Valida los campos requeridos del formulario
	    if (!form.checkValidity()) {
	        form.reportValidity(); // Muestra mensajes de error nativos del navegador
	        return; // No continúa si no pasa la validación
	    }
	    // 
	    // console.log($('#nivel_user').val());
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
		$('input[name="option"]').val('editar');

	    // Confirmación del usuario
	    let respuesta_confirmacion_envio = confirm("SE ENVIARAN LOS DATOS!!");
	    if (respuesta_confirmacion_envio) {
	        var formData = new FormData(form);
	        EnviarDatos(formData);
	    }
	});


  $('.borrar').on('click', function () {
		// 
	    const form = document.getElementById("form-add_users");
	    // Valida los campos requeridos del formulario
	    if (!form.checkValidity()) {
	        form.reportValidity(); // Muestra mensajes de error nativos del navegador
	        return; // No continúa si no pasa la validación
	    }
	    // 
	    // console.log($('#nivel_user').val());
	    // 
	    if ($('#nivel_user').val() === null) {
		  alert('Debes seleccionar un nivel de usuario');
		  $('#nivel_user').focus();
		  return;
		}
		
		$('input[name="option"]').val('borrar');

	    // Confirmación del usuario
	    let respuesta_confirmacion_envio = confirm("SE ENVIARAN LOS DATOS!!");
	    if (respuesta_confirmacion_envio) {
	        var formData = new FormData(form);
	        EnviarDatos(formData);
	    }
	});



});






// Cargar los roles en un <select>
function cargarRoles(selector, callback) {
  const $select = $(selector);
  if ($select.length === 0) return;

  $('#loaderContainer').show();

  $.ajax({
    url: 'usuarios/ajax/Get_roles_usuarios.php',
    method: 'POST',
    success: function (html) {
      $select.html(html);
      // console.log('Roles cargados:', html);
      if (typeof callback === 'function') callback();
    },
    error: function (xhr, status, error) {
      console.error('Error al cargar los roles:', error);
    },
    complete: function () {
      $('#loaderContainer').hide();
    }
  });
}

// Cargar la información del usuario por ID
function cargarInformacionUsuario(userId) {
  if (!userId) return;

  $('#loaderContainer').show();

  $.ajax({
    url: 'usuarios/ajax/Get_informacion_usuarios.php',
    method: 'POST',
    dataType: 'json',
    data: { user: userId },
    success: function (response) {
      // console.log('Usuario cargado:', response);

      if (response.success && response.data) {
        const user = response.data;
        $('#usuario_id').val(user.usuario_id);
        $('#rol_id').val(user.rol_id);
        $('#nombre').val(user.nombre);
        $('#apellido').val(user.apellido);
        $('#user_name').val(user.user_name);
        $('#correo').val(user.correo);
        // Puedes agregar más campos aquí si los necesitas
      } else {
        alert('No se encontró el usuario.');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error al cargar la información del usuario:', error);
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

</script>