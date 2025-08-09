<?php
include_once('../../../class/Cls_conductores.php');
$Cls_conductores = new Cls_conductores();


$result = $cls->Get_conductores_asignados();

while ($row = $result->fetch_assoc()) {
  echo "<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700'>
          <td class='px-4 py-2'>{$row['placas']}</td>
          <td class='px-4 py-2'>{$row['conductor_nombre']} ({$row['licencia']})</td>
          <td class='px-4 py-2'>{$row['fecha_asignacion']}</td>
          <td class='px-4 py-2'>
            <button class='btn-desasignar text-red-500 hover:underline'
                    data-vehiculo='{$row['vehiculo_id']}'
                    data-conductor='{$row['conductor_id']}'>
              Desasignar
            </button>
          </td>
        </tr>";
}

?>