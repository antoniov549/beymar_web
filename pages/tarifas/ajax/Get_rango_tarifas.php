<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../../../class/Cls_tarifas.php');
$Cls_tarifas = new Cls_tarifas();

// var_dump($_REQUEST);

$result=$Cls_tarifas->Get_zonas_disponibles();
$num_filas = mysqli_num_rows($result);
?>


<div class="p-4 pb-0 rounded-t-4">
  <h6 class="mb-0 dark:text-white">Lista de Zonas Disponibles: [ <?= $num_filas ?> ]</h6>
</div>
<div class="flex-auto p-4">

  <ul class="flex flex-col pl-0 mb-0 rounded-lg">


  <?php 
  while($result_row=mysqli_fetch_array($result)){
    // Quitar la parte del path físico del servidor
      
  ?>
    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-lg rounded-xl text-inherit">
      <div class="flex items-center">
        <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
          <i class="text-white fa fa-clipboard-list relative top-0.75 "></i>
        </div>
        <div class="flex flex-col">
          <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white"><?= $result_row['zona'] ?></h6>
          <span class="text-xs leading-tight dark:text-white/80">Costo Minimo : <?= $result_row['costo_minimo'] ?>,
          <span class="font-semibold">Costo Maximo : <?= $result_row['costo_max'] ?></span></span>
        </div>
      </div>
      <div class="flex">
        <a 
          data-zona="<?=$result_row['zona'] ?>"
          class="group ease-in leading-pro text-xs rounded-3.5xl p-1.2 h-6.5 w-6.5 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white datoInterno">
          <i class="ni ease-bounce text-2xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i>
        </a>
      </div>
    </li>
  <?php 
  }
  ?>

    
   
  </ul>
</div>