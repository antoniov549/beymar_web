<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// var_dump($_REQUEST);


include_once('../class/Cls_inicio.php');
$Cls_inicio = new Cls_inicio();

$result=$Cls_inicio->Get_obtner_costos_por_dia ('2');
$dias_dinero=array();
while($result_row = mysqli_fetch_assoc($result)){
    $dias_dinero[] = $result_row;
}
$cambio_dinero=$Cls_inicio->cambioDesdeAyer($dias_dinero[1]['total_costo'], $dias_dinero[0]['total_costo']);
// 
$result=$Cls_inicio->Get_obtner_usuarios_por_dia ('2');
$dias_usuario=array();
while($result_row = mysqli_fetch_assoc($result)){
    $dias_usuario[] = $result_row;
}
$cambio_usuarios=$Cls_inicio->cambioDesdeAyer($dias_usuario[1]['total_users'], $dias_usuario[0]['total_users']);
// 


// 
$result=$Cls_inicio->Get_viajes_solicitadospor_dia ('2');
$dias_viaje =array();
while($result_row = mysqli_fetch_assoc($result)){
    $dias_viaje[] = $result_row;
}
$cambio_viajes=$Cls_inicio->cambioDesdeAyer($dias_viaje[1]['total_viajes'], $dias_viaje[0]['total_viajes']);


$result=$Cls_inicio->Get_viajes_finalizados_dia ('2','Finalizado');
$dias_finalizado =array();
while($result_row = mysqli_fetch_assoc($result)){
    $dias_finalizado[] = $result_row;
}
$cambio_finalizado=$Cls_inicio->cambioDesdeAyer($dias_finalizado[1]['total_viajes'], $dias_finalizado[0]['total_viajes']);
print_r($dias_finalizado);





//echo " HOLA";
?>

  <!-- cards -->
      <div class="w-full px-6 py-6 mx-auto">
        <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">El dinero de hoy</p>
                      <h5 class="mb-2 font-bold dark:text-white">$<?= $dias_dinero[0]['total_costo'] ?></h5>
                      <p class="mb-0 dark:text-white dark:opacity-60">

                        <span class="text-sm font-bold leading-normal <?= $cambio_dinero['clase_texto'] ?>"><?= $cambio_dinero['signo'].$cambio_dinero['porcentaje'] ?></span>
                       desde ayer
                      </p>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                      <i class="ni leading-none ni-money-coins text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card2 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Usuarios de hoy</p>
                      <h5 class="mb-2 font-bold dark:text-white"><?= $dias_usuario[0]['total_users'] ?></h5>
                      <p class="mb-0 dark:text-white dark:opacity-60">
                        <span class="text-sm font-bold leading-normal <?= $cambio_usuarios['clase_texto'] ?>"><?= $cambio_usuarios['signo'].$cambio_usuarios['porcentaje'] ?></span>
                       desde ayer
                      </p>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                      <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card3 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">VIAJES DE HOY</p>
                      
                      <h5 class="mb-2 font-bold dark:text-white"><?= $dias_viaje[0]['total_viajes'] ?></h5>


                      <p class="mb-0 dark:text-white dark:opacity-60">
                        <span class="text-sm font-bold leading-normal <?= $cambio_viajes['clase_texto'] ?>"><?= $cambio_viajes['signo'].$cambio_viajes['porcentaje'] ?></span>
                       desde ayer
                      </p>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                      <i class="ni leading-none ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card4 -->
          <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Viajes Hechos</p>
                      <h5 class="mb-2 font-bold dark:text-white"><?= $dias_finalizado[0]['total_viajes'] ?></h5>
                      <p class="mb-0 dark:text-white dark:opacity-60">
                        <span class="text-sm font-bold leading-normal <?= $cambio_finalizado['clase_texto'] ?>"><?= $cambio_viajes['signo'].$cambio_viajes['porcentaje'] ?></span>
                        desde ayer
                      </p>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                      <i class="ni leading-none ni-cart text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- cards row 2 -->

        <div class="flex flex-wrap mt-6 -mx-3">
          <!--  -->
          <div class="w-full max-w-full px-3 mt-0 lg:w-7/12 lg:flex-none">
            <div class="border-black/12.5 dark:bg-slate-850 dark:shadow-dark-xl shadow-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid p-6 pt-4 pb-0">
                <h6 class="capitalize dark:text-white">Descripción general de ventas</h6>
                <p class="mb-0 text-sm leading-normal dark:text-white dark:opacity-60">
                  <i class="fa fa-arrow-up text-emerald-500"></i>
                  <span class="font-semibold">4% mas</span> in 2024
                </p>
              </div>
              <div class="flex-auto p-4">
                <div>
                  <canvas id="chart-line" height="300"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!--  -->

          <!--  -->
          <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-5/12 lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
              <div class="p-4 pb-0 mb-0 rounded-t-4">
                <div class="flex justify-between">
                  <h6 class="mb-2 dark:text-white">Viajes por Municipio</h6>
                </div>
              </div>
              <div class="overflow-x-auto">
                <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
                  <tbody>
                    <!-- Benito Juárez (Cancún) -->
                    <tr>
                      <td class="p-2 align-middle bg-transparent border-b w-3/10 whitespace-nowrap dark:border-white/40">
                        <div class="flex items-center px-2 py-1">
                          
                          <div class="ml-6">
                            <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Municipio:</p>
                            <h6 class="mb-0 text-sm leading-normal dark:text-white">Benito Juárez</h6>
                          </div>
                        </div>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Viajes:</p>
                        <h6 class="mb-0 text-sm leading-normal dark:text-white">48</h6>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Valor:</p>
                        <h6 class="mb-0 text-sm leading-normal dark:text-white">$12500</h6>
                      </td>
                      <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Crecimiento:</p>
                        <h6 class="mb-0 text-sm leading-normal dark:text-white">8.3%</h6>
                      </td>
                    </tr>

                    <!-- Isla Mujeres -->
                    <tr>
                      <td class="p-2 align-middle bg-transparent border-b w-3/10 whitespace-nowrap dark:border-white/40">
                        <div class="flex items-center px-2 py-1">
                         
                          <div class="ml-6">
                            <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Municipio:</p>
                            <h6 class="mb-0 text-sm leading-normal dark:text-white">Isla Mujeres</h6>
                          </div>
                        </div>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Viajes:</p>
                        <h6 class="mb-0 text-sm leading-normal dark:text-white">12</h6>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Valor:</p>
                        <h6 class="mb-0 text-sm leading-normal dark:text-white">$4300</h6>
                      </td>
                      <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Crecimiento:</p>
                        <h6 class="mb-0 text-sm leading-normal dark:text-white">12.7%</h6>
                      </td>
                    </tr>

                    <!-- Puerto Morelos -->
                    <tr>
                      <td class="p-2 align-middle bg-transparent border-0 w-3/10 whitespace-nowrap">
                        <div class="flex items-center px-2 py-1">
                         
                          <div class="ml-6">
                            <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Municipio:</p>
                            <h6 class="mb-0 text-sm leading-normal dark:text-white">Puerto Morelos</h6>
                          </div>
                        </div>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-0 whitespace-nowrap">
                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Viajes:</p>
                        <h6 class="mb-0 text-sm leading-normal dark:text-white">9</h6>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-0 whitespace-nowrap">
                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Valor:</p>
                        <h6 class="mb-0 text-sm leading-normal dark:text-white">$2200</h6>
                      </td>
                      <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-0 whitespace-nowrap">
                        <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Crecimiento:</p>
                        <h6 class="mb-0 text-sm leading-normal dark:text-white">5.1%</h6>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!--  -->
         


        </div>
        <!-- cards row 2 -->

        <!-- cards row 3 -->
        <!-- <div class="flex flex-wrap mt-6 -mx-3"> -->
          <!--  -->
          <!-- <div class="w-full max-w-full px-3 mt-0 lg:w-5/12 lg:flex-none">
            <div class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="p-4 pb-0 rounded-t-4">
                <h6 class="mb-0 dark:text-white">Categories</h6>
              </div>
              <div class="flex-auto p-4">
                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                  <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-lg rounded-xl text-inherit">
                    <div class="flex items-center">
                      <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
                        <i class="text-white ni ni-mobile-button relative top-0.75 text-xxs"></i>
                      </div>
                      <div class="flex flex-col">
                        <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">Devices</h6>
                        <span class="text-xs leading-tight dark:text-white/80">250 in stock, <span class="font-semibold">346+ sold</span></span>
                      </div>
                    </div>
                    <div class="flex">
                      <button class="group ease-in leading-pro text-xs rounded-3.5xl p-1.2 h-6.5 w-6.5 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white"><i class="ni ease-bounce text-2xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i></button>
                    </div>
                  </li>
                  <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-xl text-inherit">
                    <div class="flex items-center">
                      <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
                        <i class="text-white ni ni-tag relative top-0.75 text-xxs"></i>
                      </div>
                      <div class="flex flex-col">
                        <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">Tickets</h6>
                        <span class="text-xs leading-tight dark:text-white/80">123 closed, <span class="font-semibold">15 open</span></span>
                      </div>
                    </div>
                    <div class="flex">
                      <button class="group ease-in leading-pro text-xs rounded-3.5xl p-1.2 h-6.5 w-6.5 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white"><i class="ni ease-bounce text-2xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i></button>
                    </div>
                  </li>
                  <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-b-lg rounded-xl text-inherit">
                    <div class="flex items-center">
                      <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
                        <i class="text-white ni ni-box-2 relative top-0.75 text-xxs"></i>
                      </div>
                      <div class="flex flex-col">
                        <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">Error logs</h6>
                        <span class="text-xs leading-tight dark:text-white/80">1 is active, <span class="font-semibold">40 closed</span></span>
                      </div>
                    </div>
                    <div class="flex">
                      <button class="group ease-in leading-pro text-xs rounded-3.5xl p-1.2 h-6.5 w-6.5 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white"><i class="ni ease-bounce text-2xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i></button>
                    </div>
                  </li>
                  <li class="relative flex justify-between py-2 pr-4 border-0 rounded-b-lg rounded-xl text-inherit">
                    <div class="flex items-center">
                      <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
                        <i class="text-white ni ni-satisfied relative top-0.75 text-xxs"></i>
                      </div>
                      <div class="flex flex-col">
                        <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">Happy users</h6>
                        <span class="text-xs leading-tight dark:text-white/80"><span class="font-semibold">+ 430 </span></span>
                      </div>
                    </div>
                    <div class="flex">
                      <button class="group ease-in leading-pro text-xs rounded-3.5xl p-1.2 h-6.5 w-6.5 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white"><i class="ni ease-bounce text-2xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i></button>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div> -->
          <!--  -->
        <!-- </div> -->
         <!-- cards row 3 -->



        <!-- footer -->
        <?php  include('../includes/footer.php'); ?>
        <!-- footer -->
      </div>
      <!-- end cards -->

<script type="text/javascript">
$('#loaderContainer').show();
$(document).ready(function(){
	$('#loaderContainer').hide();
});
</script>