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
					echo '<th class="column100 column'.$contador.'" data-column="column'.$contador.'" >'.$titulo.'</th>';
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
							                <div class="table-data-feature noti-wrap  ">
							                    <button 
							                        class="item datoInterno" 
							                        data-toggle="tooltip" 
							                        data-placement="top" 
							                        title="Cambiar Contraseña"
							                        data-user="'.$result_row['usuario_id'].'"
							                        data-option="editar"
							                    >
							                        <i class="fa fa-user-edit"></i>
							                    </button>

							                     <button 
							                        class="item datoInterno" 
							                        data-toggle="tooltip" 
							                        data-placement="top" 
							                        title="Eliminar Usuario"
							                        data-user="'.$result_row['usuario_id'].'"
							                        data-option="eliminar"
							                    >
							                        <i class="fa fa-delete-left"></i>
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

