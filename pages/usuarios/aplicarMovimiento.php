<?php
include('../../includes/comprobar_logeo.php');
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//exit("ALTO MAQUINA");

include_once('../../class/Cls_usuarios.php');
$Cls_usuarios = new Cls_usuarios();

/// option
$option = isset($_REQUEST['option']) ? trim((string)$_REQUEST['option']) : '';

// nivel_user
$nivel_user = isset($_REQUEST['nivel_user']) ? trim((string)$_REQUEST['nivel_user']) : '';

// firstname
$firstname = isset($_REQUEST['firstname']) ? trim((string)$_REQUEST['firstname']) : '';

// lastname
$lastname = isset($_REQUEST['lastname']) ? trim((string)$_REQUEST['lastname']) : '';

// user_name
$user_name = isset($_REQUEST['user_name']) ? trim((string)$_REQUEST['user_name']) : '';

// user_email
$user_email = isset($_REQUEST['user_email']) ? trim((string)$_REQUEST['user_email']) : '';

// user_password_new
$user_password_new = isset($_REQUEST['user_password_new']) ? trim((string)$_REQUEST['user_password_new']) : '';

// user_password_repeat
$user_password_repeat = isset($_REQUEST['user_password_repeat']) ? trim((string)$_REQUEST['user_password_repeat']) : '';

// licencia
$licencia = isset($_REQUEST['licencia']) ? trim((string)$_REQUEST['licencia']) : '';

// telefono
$telefono = isset($_REQUEST['telefono']) ? trim((string)$_REQUEST['telefono']) : '';




// var_dump($_REQUEST);
// var_dump($_FILES);
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
					$respuesta = $Cls_usuarios->Set_new_usuarios($user_name, $firstname, $lastname, $user_email, $user_password_new , $nivel_user);

					if ($licencia) {
						if ($respuesta['success']) {
						    $respuesta = $Cls_usuarios->insertar_conductor($respuesta['id_insertado'], $licencia, $telefono, 'activo');
						}
					}

					echo $respuesta['message'];
				break;

			case 'editar':

					// usuario_id
					$usuario_id = isset($_REQUEST['usuario_id']) ? trim((string)$_REQUEST['usuario_id']) : '';
					// user_password_new
					$user_password_new = isset($_REQUEST['user_password_new']) ? trim((string)$_REQUEST['user_password_new']) : '';
			
					// 
					$respuesta = $Cls_usuarios->Update_password($usuario_id, $user_password_new);
					echo $respuesta['message'];
				break;

			case 'borrar':

					// usuario_id
					$usuario_id = isset($_REQUEST['usuario_id']) ? trim((string)$_REQUEST['usuario_id']) : '';
					$nuevo_estado='0';

					$respuesta = $Cls_usuarios->Update_estado($usuario_id, $nuevo_estado);
					echo $respuesta['message'];
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