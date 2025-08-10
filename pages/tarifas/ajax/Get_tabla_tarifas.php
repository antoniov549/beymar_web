<?php
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../../../class/Cls_tarifas.php');
$Cls_tarifas = new Cls_tarifas();

// Obtener la zona buscada (por POST o GET)
$zona = isset($_REQUEST['zona']) ? trim((string)$_REQUEST['zona']) : '';


// Consultar datos
$result = $Cls_tarifas->Get_rango_de_tarifas_por($zona);
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
    "tipo de vaije", 
    "Cantidad de personas minimo", 
    "Cantidad de personas maxima", 
    "costo", 
    "Opciones"
];
?>
<div class="flex-auto px-0 pt-0 pb-2 ">
    <div class="p-0 overflow-x-auto ">
      <table id="tablaTarifas" class="items-center justify-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
        
        <thead class="align-bottom">
          <tr>
            <?php 
                $titulos_traductor = [ 
                    "Destino",
                    "Vehiculo", 
                    "Tipo de viaje", 
                    "Cantidad mínima", 
                    "Cantidad máxima", 
                    "Costo", 
                    "Opciones"
                ];
                foreach ($titulos_traductor as $titulo) {
                    echo '<th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 si_input">'.$titulo.'</th>';
                }
            ?>
          </tr>
        </thead>

        <tbody class="border-t">
        <?php 
            while($result_row = mysqli_fetch_assoc($result)){
                echo '<tr>';
                    foreach ($titulos as $titulo) {
                        switch ($titulo) {
                            case 'Opciones':
                                echo '
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                      <button class="inline-block px-5 py-2.5 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none leading-normal text-sm ease-in bg-150 tracking-tight-rem bg-x-25 text-slate-400 
                                        datoInterno
                                        data-zona="'.$result_row['zona'].'"
                                        data-rango="'.$result_row['minimo'].'-'.$result_row['maximo'].'"
                                        data-vehiculo="'.$result_row['tipo_vehiculo'].'"
                                        data-viaje="'.$result_row['tipo_viaje'].'"



                                      ">
                                        <i class="text-xs leading-tight fa fa-ellipsis-v dark:text-white dark:opacity-60"></i>
                                      </button>
                                    </td>
                                ';
                                break;
                            case 'Destino':
                                echo '
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2">
                                            <div class="my-auto">
                                              <h6 class="mb-0 text-sm leading-normal dark:text-white">'.$result_row['zona'].'</h6>
                                            </div>
                                        </div>
                                    </td>
                                ';
                                break;
                            default:
                                echo '
                                    <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                      <p class="mb-0 text-sm font-semibold leading-normal dark:text-white dark:opacity-60">'.$result_row[strtolower(str_replace(' ', '_', $titulo))].'</p>
                                    </td>
                                ';
                                break;
                        }
                    }
                echo '</tr>';
            }
         ?> 
        </tbody>
      </table>
    </div>
</div>
