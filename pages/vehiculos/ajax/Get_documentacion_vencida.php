<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../../../class/Cls_vehiculos.php');
$Cls_vehiculos = new Cls_vehiculos();

// var_dump($_REQUEST);

$result=$Cls_vehiculos->Get_documentos_por_vencer();
$num_filas = mysqli_num_rows($result);
?>


<div class="p-4 pb-0 rounded-t-4">
  <h6 class="mb-0 dark:text-white">Documentos Por Vencer: [ <?= $num_filas ?> ]</h6>
</div>
<div class="flex-auto p-4">

  <ul class="flex flex-col pl-0 mb-0 rounded-lg">


  <?php 
  while($result_row=mysqli_fetch_array($result)){
    // Quitar la parte del path físico del servidor
      $rutaPublica = str_replace('/var/www/html', '', $result_row['archivo_url']);
  ?>
    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-lg rounded-xl text-inherit">
      <div class="flex items-center">
        <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
          <i class="text-white fa fa-clipboard-list relative top-0.75 "></i>
        </div>
        <div class="flex flex-col">
          <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white"><?= $result_row['tipo_documento'] ?></h6>
          <span class="text-xs leading-tight dark:text-white/80">Placas: <?= $result_row['placas'] ?>,
          <span class="font-semibold">Dias restantes: <?= $result_row['dias_restantes'] ?></span></span>
        </div>
      </div>
      <div class="flex">

        <a 
          href="<?= $rutaPublica ?>" target="_blank"
        class="dark:text-white inline-block px-0 py-2.5 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer ease-in bg-150 text-sm active:opacity-85 hover:-translate-y-px tracking-tight-rem bg-x-25 text-slate-700">
        <i class="mr-1 text-lg leading-none fas fa-file-pdf"></i>  </a>

      </div>
    </li>
  <?php 
  }
  ?>

    
   
  </ul>
</div>