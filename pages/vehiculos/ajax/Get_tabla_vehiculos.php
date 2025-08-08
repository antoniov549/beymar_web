<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../../../class/Cls_vehiculos.php');
$Cls_vehiculos = new Cls_vehiculos();

// var_dump($_REQUEST);

$result=$Cls_vehiculos->Get_tabla_vehiculos();
$num_filas = mysqli_num_rows($result);
?>

<div class="table100 avs" style="padding: 1em; padding-right: 1em;" >
	<table class="table tabla_vehiculos" id="table-vehiculos" data-vertable="avs" >
		<thead>
			<tr class="row100 head">
			<?php 
				$titulos = [ 
					"placas",
					"marca", 
					"modelo", 
					"anio", 
					"color", 
					
					 
					 
					"capacidad", 
					"tipo", 
					"estado_vehiculo", 
					"created_at", 
					"updated_at",
					"Opciones"
				];

				$titulos_traductor = [ 
					"placas",
					"marca", 
					"modelo", 
					"anio", 
					"color", 
					
					 
					 
					"capacidad", 
					"tipo", 
					"estado_vehiculo", 
					"created_at", 
					"updated_at",
					"Opciones"
				];
				$contador=0;
				foreach ($titulos_traductor as $titulo) {
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
							                        title="detalles"
							                        data-vehiculo="'.$result_row['vehiculo_id'].'"
							                        data-option="detalles"
							                    >
							                        <i class="fa fa-clipboard-list"></i>
							                    </button>

							                     <button 
							                        class="item datoInterno" 
							                        data-toggle="tooltip" 
							                        data-placement="top" 
							                        title="Eliminar vehiculo"
							                        data-vehiculo="'.$result_row['vehiculo_id'].'"
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
