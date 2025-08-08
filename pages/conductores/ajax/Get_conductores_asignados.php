<?php 
include_once('../../../class/Cls_conductores.php');
$Cls_conductores = new Cls_conductores();

$respuesta = $Cls_conductores->obtenerConductoresAsignados();

if ($respuesta['success']) {
  $datos = $respuesta['data'];

echo "<table id='tabla_conductores' class='table table-bordered'>";
echo "<thead>
  <tr>
    <th>Vehículo</th>
    <th>Conductor</th>
    <th>Fecha asignación</th>
    <th>Acción</th>
  </tr>
</thead><tbody>";

foreach ($datos as $row) {
  echo "<tr>
          <td>{$row['placas']}</td>
          <td>{$row['conductor_nombre']} ({$row['licencia']})</td>
          <td>{$row['fecha_asignacion']}</td>
          <td>
            <button 
              class='btn btn-danger btn-sm desasignar-btn'
              data-vehiculo='{$row['vehiculo_id']}'
              data-conductor='{$row['conductor_id']}'>
              Desasignar
            </button>
          </td>
        </tr>";
}

echo "</tbody></table>";
} else {
  echo "<div class='alert alert-danger'>Error: {$respuesta['message']}</div>";
}



?>