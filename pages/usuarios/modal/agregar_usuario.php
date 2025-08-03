<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

var_dump($_REQUEST);
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
	<form class="form-horizontal" method="post" id="guardar_usuario" name="guardar_usuario">		
			<div id="resultados_ajax"></div>

				<div class="form-group m-b-10 ">
					<label for="nivel_user" class=" control-label">Nivel del usuario: </label>
					  <div class="">
					  <select class="form-control" id="nivel_user" name="nivel_user">
					  	<option value="0" selected disabled >Selecciona una opcion</option>
					    <option value="1">Gerente</option>
					    <option value="2">Administracion</option>
					    <option value="3">Chofer</option>
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
					<!--  -->
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
				
				<div id="documentacion">
					<hr>
					<center>
						<h5 class="center">Documentos Requeridos</h5>
					</center>
					<!-- Acta Constitutiva -->
					<div class="mb-3">
					  <label for="acta_constitutiva" class="form-label">Acta Constitutiva (PDF)</label>
					  <input type="file" class="form-control" name="acta_constitutiva" id="acta_constitutiva" accept=".pdf" required>
					</div>

					<!-- Permiso de ASUR -->
					<div class="mb-3">
					  <label for="permiso_asur" class="form-label">Permiso de ASUR (PDF)</label>
					  <input type="file" class="form-control" name="permiso_asur" id="permiso_asur" accept=".pdf" required>
					</div>

					<!-- Placas Federales -->
					<div class="mb-3">
					  <label for="placas_federales" class="form-label">Placas Federales (PDF o Imagen)</label>
					  <input type="file" class="form-control" name="placas_federales" id="placas_federales" accept=".pdf,.jpg,.jpeg,.png" required>
					</div>

					<!-- Seguro de Viajes -->
					<div class="mb-3">
					  <label for="seguro_viajes" class="form-label">Seguro de Viajes (PDF o Imagen)</label>
					  <input type="file" class="form-control" name="seguro_viajes" id="seguro_viajes" accept=".pdf,.jpg,.jpeg,.png" required>
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
	<button type="button" class="btn btn-danger accion"><i class="zmdi zmdi-delete"></i>&nbsp;BORRAR</button>
</div>	


<script type="text/javascript">
$(document).ready(function() {
///////////////////////////////////////////

 $(document).on('change', '#nivel_user', function(event) { 
 	var nivel_user=$("#nivel_user option:selected").val();
 	console.log(nivel_user);
 });

//$(".table-resultados").stickyTableHeaders();
$('.accion').on('click', function() {
	alert(`esto es el alert`);
});


 document.querySelectorAll('input[type="file"]').forEach(function(input) {
 	
    input.addEventListener('change', function(event) {
      const fileName = event.target.files[0]?.name || "Ningún archivo seleccionado";
      event.target.nextElementSibling && (event.target.nextElementSibling.textContent = fileName);
    });
  });

///////////////////////////////////////////
});
</script>