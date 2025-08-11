<?php
include_once('../../../class/Cls_conductores.php');
$Cls_conductores = new Cls_conductores();

// Obtener conductores asignados
$respuesta = $Cls_conductores->obtenerConductoresAsignados();

if (!$respuesta['success']) {
  echo "<div class='alert alert-danger'>Error: {$respuesta['message']}</div>";
  exit;
}

$datos = $respuesta['data'];

?>

<?php foreach ($datos as $row): ?>
  <tr>
    <td class='px-4 py-2' ><?= htmlspecialchars($row['placas']) ?></td>
    <td class='px-4 py-2' ><?= htmlspecialchars($row['conductor_nombre']) ?> (<?= htmlspecialchars($row['licencia']) ?>)</td>
    <td class='px-4 py-2' ><?= htmlspecialchars($row['fecha_asignacion']) ?> (<?= htmlspecialchars($row['vehiculo_tipo']) ?>) </td>
    <td class='px-4 py-2' >
      <button
        class='btn-desasignar text-red-500 hover:underline'
        data-vehiculo="<?= htmlspecialchars($row['vehiculo_id']) ?>"
        data-conductor="<?= htmlspecialchars($row['conductor_id']) ?>">
        Desasignar
      </button>
    </td>
  </tr>
<?php endforeach; ?>
