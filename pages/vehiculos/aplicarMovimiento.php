<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//exit("ALTO MAQUINA");
include('../../includes/comprobar_logeo.php');
include_once('../../class/Cls_vehiculos.php');
$Cls_vehiculos = new Cls_vehiculos();

// var_dump($_REQUEST);
// var_dump($_FILES);

/// option
$option = isset($_POST['option']) ? trim((string)$_POST['option']) : '';

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
					try {
					    $fecha_actual = date('Y-m-d H:i:s');

					    // DATOS DEL VEHÍCULO
					    $dataVehiculo = [
					        'marca' => isset($_POST['marca']) ? trim((string)$_POST['marca']) : '',
					        'modelo' => isset($_POST['modelo']) ? trim((string)$_POST['modelo']) : '',
					        'anio' => isset($_POST['anio']) ? trim((string)$_POST['anio']) : '',
					        'color' => isset($_POST['color']) ? trim((string)$_POST['color']) : '',
					        'numero_serie' => isset($_POST['numero_serie']) ? trim((string)$_POST['numero_serie']) : '',
					        'numero_motor' => isset($_POST['numero_motor']) ? trim((string)$_POST['numero_motor']) : '',
					        'placas' => isset($_POST['placas']) ? trim((string)$_POST['placas']) : '',
					        'capacidad' => isset($_POST['capacidad']) ? trim((string)$_POST['capacidad']) : '',
					        'tipo' => isset($_POST['tipo']) ? trim((string)$_POST['tipo']) : '',
					        'estado' => isset($_POST['estado']) ? trim((string)$_POST['estado']) : 1,
					        'estado_vehiculo' => isset($_POST['estado_vehiculo']) ? trim((string)$_POST['estado_vehiculo']) : '',
					        'created_at' => $fecha_actual,
					        'updated_at' => $fecha_actual,
					    ];

					    // INSERTAR VEHÍCULO
					    $vehiculo_id = $Cls_vehiculos->insertarVehiculo($dataVehiculo);
					    echo "<div class='alert alert-success'>Vehículo registrado con ID: $vehiculo_id</div>";

					    // DEBUG ARCHIVOS
					    // echo "<pre>ARCHIVOS RECIBIDOS:\n";
					    // print_r($_FILES);
					    // echo "</pre>";

					    // TIPOS DE DOCUMENTO
					    $tipos_documento = ['registro', 'poliza_seguro', 'verificacion', 'tarjeta_propiedad'];

						foreach ($tipos_documento as $tipo) {
						    echo "<b>Procesando documento..:</b> $tipo<br>";

						    // Verifica si el archivo fue enviado sin errores
						    if (
						        isset($_FILES['documentos']['error'][$tipo]['archivo']) &&
						        $_FILES['documentos']['error'][$tipo]['archivo'] === 0
						    ) {
						        // Extrae el nombre y archivo temporal
						        $archivo_nombre = $_FILES['documentos']['name'][$tipo]['archivo'];
						        $archivo_tmp = $_FILES['documentos']['tmp_name'][$tipo]['archivo'];

						        // Define directorio de destino
						        $directorio = __DIR__ . "/archivos_vehiculos/$tipo/";
						        if (!file_exists($directorio)) {
						            mkdir($directorio, 0755, true);
						        }

						        // Define ruta final
						        $nombre_final = uniqid($tipo . "_") . "_" . basename($archivo_nombre);
						        $ruta_final = $directorio . $nombre_final;

						        // Mueve el archivo
						        if (move_uploaded_file($archivo_tmp, $ruta_final)) {
						            // echo "✔️ Archivo '$archivo_nombre' guardado correctamente en '$ruta_final'<br>";

						            // Extrae fechas de vigencia
						            $fecha_inicio = $_POST['documentos'][$tipo]['fecha_vigencia_inicio'] ?? null;
						            $fecha_fin    = $_POST['documentos'][$tipo]['fecha_vigencia_fin'] ?? null;

						            // Inserta en la base de datos
						            $Cls_vehiculos->insertarDocumentoLegal(
						                $vehiculo_id,
						                $tipo,
						                $ruta_final,
						                $fecha_inicio,
						                $fecha_fin
						            );
						            // echo " Documento '$tipo' registrado en la base de datos.<br><br>";
						        } else {

						        	echo '
						        	<div class="alert alert-danger" role="alert">
										 Error al mover el archivo '.$archivo_nombre.'
									</div>
									';
						        }
						    } else {

						    	echo '
						        	<div class="alert alert-danger" role="alert">
										  Archivo '.$tipo.' no enviado o con error
									</div>
								';
						    }
						}

					    echo "<div class='alert alert-success'>Proceso completado.</div>";

					} catch (Exception $e) {
					    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
					}
					
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