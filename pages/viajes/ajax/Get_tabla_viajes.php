<?php
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../../../class/Cls_viajes.php');
$Cls_viajes = new Cls_viajes();


// Consultar datos
$result = $Cls_viajes->Get_tabla_viajes();
$num_filas = $result ? mysqli_num_rows($result) : 0;


$titulos = [ 
    "zona",
    "tipo_vehiculo", 
    "tipo_viaje", 
    "minimo", 
    "maximo",   
    "costo", 
    "Opciones"
];

$titulos_traductor = [ 
    "Destino",
    "Vehiculo", 
    "Tipo de viaje", 
    "Cantidad mínima", 
    "Cantidad máxima", 
    "Costo", 
    "Opciones"
];
?>

<div class="flex-auto px-0 pt-0 pb-2">
  <div class="p-0 overflow-x-auto ps">
    <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500" id="tablaViajes" >
      <thead class="align-bottom">
        
        <tr>
          <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b 
            border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid 
            tracking-none whitespace-nowrap text-slate-400 opacity-70 si_input">
            Conductor
          </th>

          <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 si_input">
            Vehiculo
          </th>

          <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 si_input">
            Status
          </th>


          <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 si_input">
            Employed
          </th>

          <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 si_input ">
            Option          
          </th>

        </tr>

      </thead>
      <tbody>

      <?php 
      while($result_row = mysqli_fetch_assoc($result)){
      ?>
        <tr>

          <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
            <div class="flex px-2 py-1">
              <div>
                <img src="../assets/img/team-2.jpg" class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl" alt="user1">
              </div>
              <div class="flex flex-col justify-center">
                <h6 class="mb-0 text-sm leading-normal dark:text-white"><?= $result_row['nombre']." ".$result_row['apellido'] ?></h6>
                <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400"><?= $result_row['correo'] ?></p>
              </div>
            </div>
          </td>

          <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
            <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= $result_row['tipo'] ?></p>
            <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400"><?= "Pasajeros:".$result_row['capacidad'] ?></p>
          </td>

          <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
            <span 
                  class="
                  bg-gradient-to-tl 
                  from-emerald-500 
                  to-teal-400 
                  px-2.5 
                  text-xs 
                  rounded-1.8 
                  py-1.4 
                  inline-block 
                  whitespace-nowrap 
                  text-center 
                  align-baseline 
                  font-bold 
                  uppercase 
                  leading-none 
                  text-white
              ">
              <?= str_replace('_', ' ', $result_row['viaje_estado']) ?>
            </span>

              <span 
                    class="
                      bg-gradient-to-tl
                      from-slate-600
                      to-slate-300
                      px-2.5
                      text-xs
                      rounded-1.8
                      py-1.4
                      inline-block
                      whitespace-nowrap
                      text-center
                      align-baseline
                      font-bold
                      uppercase
                      leading-none
                      text-white
              ">
              <?= str_replace('_', ' ', $result_row['viaje_estado']) ?>
              </span>


          </td>

          <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
            <span class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">23/04/18</span>
          </td>
          
          <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
            <a href="javascript:;" class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400"> Edit </a>
          </td>

        </tr>
        <?php 
        }
        ?>
        
      </tbody>
    </table>
  <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
</div>

