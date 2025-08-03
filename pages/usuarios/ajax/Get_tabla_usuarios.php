<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../../../class/Cls_usuarios.php');
$Cls_usuarios = new Cls_usuarios();

// var_dump($_REQUEST);

$result=$Cls_usuarios->Get_tabla_usuarios();
$num_filas = mysqli_num_rows($result);
?>

<div class="table100 avs" style="padding: 1em; padding-right: 1em;" >
	<table class="table tabla_usuarios" id="table-usuairos" data-vertable="avs" >
		<thead>
			<tr class="row100 head">
			<?php 
				$titulos = [ 
						 "user_name", "nombre", "apellido", "correo", "rol_id", "estado", "created_at", "updated_at", "Opciones"
				];
				$contador=0;
				foreach ($titulos as $titulo) {
					echo '<th class="column100 column'.$contador.'" data-column="column'.$contador.'">'.$titulo.'</th>';
					$contador++;
				}
			?>		
			</tr>
		</thead>
		<tbody>
			<?php 
			 	 	while($result_row=mysqli_fetch_array($result)){
			 	 		 echo '<tr class="row100">';
					    	$contador=0;
						    foreach ($titulos as $titulo) {

						    	switch ($titulo) {
						    		case 'Opciones':
						    			echo '
						    			 <td class="column100 column13" data-column="column13">
							                <div class="table-data-feature noti__item js-item-menu">
							                    <button 
							                        class="item datoInterno" 
							                        data-toggle="tooltip" 
							                        data-placement="top" 
							                        title="Historico TRD"
							                       
							                        data-trd_id=""
							                        data-his_id=""
							                        data-serial=""
							                        data-opcion="cantidad_trd"
							                    >
							                        <i class="zmdi zmdi-view-list-alt"></i>
							                        <span class="quantity">1</span>
							                    </button>

							                  

							                </div>
							            </td>

						    			';
						    				
						    			break;
						    		default:
						    			echo '<td class="column100 column'.$contador.'" data-column="column'.$contador.'" >'.$result_row[$titulo].'</td>';
						    			break;
						    	}

						    
						        
						        $contador++;
						    }
					    echo '</tr>';
			 	 	}
				 ?>
		</tbody>
	</table>
</div>


<script type="text/javascript">
$('#loaderContainer').show();
$(document).ready(function(){
	$('#loaderContainer').hide();
});
</script>