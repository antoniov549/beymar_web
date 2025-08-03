<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//exit("ALTO MAQUINA");
include('../../includes/comprobar_logeo.php');

include_once('../../class/Cls_usuarios.php');
$Cls_usuarios = new Cls_usuarios();


////////////////////////
$replace= array(" ", "'", "''");
$replace2= array("'", "''", "\"" );

/// option
$option = isset($_REQUEST["option"]) ? $_REQUEST["option"] : null;
$option = str_replace($replace2,"", trim($option));

// nivel_user
$nivel_user = isset($_REQUEST["nivel_user"]) ? $_REQUEST["nivel_user"] : null;
$nivel_user = str_replace($replace2,"", trim($nivel_user));

// firstname
$firstname = isset($_REQUEST["firstname"]) ? $_REQUEST["firstname"] : null;
$firstname = str_replace($replace2,"", trim($firstname));


// lastname
$lastname = isset($_REQUEST["lastname"]) ? $_REQUEST["lastname"] : null;
$lastname = str_replace($replace2,"", trim($lastname));


// user_name
$user_name = isset($_REQUEST["user_name"]) ? $_REQUEST["user_name"] : null;
$user_name = str_replace($replace2,"", trim($user_name));

// user_email
$user_email = isset($_REQUEST["user_email"]) ? $_REQUEST["user_email"] : null;
$user_email = str_replace($replace2,"", trim($user_email));

// user_password_new
$user_password_new = isset($_REQUEST["user_password_new"]) ? $_REQUEST["user_password_new"] : null;
$user_password_new =  trim($user_password_new);

// user_password_repeat
$user_password_repeat = isset($_REQUEST["user_password_repeat"]) ? $_REQUEST["user_password_repeat"] : null;
$user_password_repeat =  trim($user_password_repeat);

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