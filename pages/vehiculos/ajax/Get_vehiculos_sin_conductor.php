<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../../../class/Cls_vehiculos.php');
$Cls_vehiculos = new Cls_vehiculos();

// var_dump($_REQUEST);

$result=$Cls_vehiculos->Get_vehiculos_sin_conductor();
$num_filas = mysqli_num_rows($result);
?>
<div class="p-4 pb-0 mb-0 rounded-t-4">
  <div class="flex justify-between">
    <h6 class="mb-2 dark:text-white">Vehiculos Sin Condutor: [ <?= $num_filas ?> ]</h6>
  </div>
</div>
<div class="overflow-x-auto">
  <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
    <tbody>
		<?php 
			while($result_row=mysqli_fetch_array($result)){
			// Quitar la parte del path físico del servidor
		?>
		<tr>
	        <td class="p-2 align-middle bg-transparent border-b w-3/10 whitespace-nowrap dark:border-white/40">
	          <div class="flex items-center px-2 py-1">
	            <div>
	              <i class="text-black fa fa-car-on relative top-0.75 "></i>
	            </div>
	            <div class="ml-6">
	              <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Marca:</p>
	              <h6 class="mb-0 text-sm leading-normal dark:text-white"><?= $result_row['marca'] ?></h6>
	            </div>
	          </div>
	        </td>
	        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
	          <div class="text-center">
	            <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Placas:</p>
	            <h6 class="mb-0 text-sm leading-normal dark:text-white"><?= $result_row['placas'] ?></h6>
	          </div>
	        </td>
	        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
	          <div class="text-center">
	            <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Capacidad:</p>
	            <h6 class="mb-0 text-sm leading-normal dark:text-white"><?= $result_row['capacidad'] ?></h6>
	          </div>
	        </td>
	        <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
	          <div class="flex-1 text-center">
	            <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Estatus:</p>
	            <h6 class="mb-0 text-sm leading-normal dark:text-white"><?= $result_row['estado_vehiculo'] ?></h6>
	          </div>
	        </td>
     	</tr>
		<?php
		}
		?>
    </tbody>
  </table>
</div>
</div>
