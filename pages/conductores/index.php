<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../class/Cls_vehiculos.php');
include_once('../class/Cls_conductores.php');

$Cls_vehiculos = new Cls_vehiculos();
$Cls_conductores = new Cls_conductores();

$vehiculos   = $Cls_vehiculos->Get_vehiculos_disponibles();
$conductores = $Cls_conductores->Get_conductores_sin_vehiculo();
?>

<!-- Formulario de asignación -->
<div class="flex flex-wrap -mx-3 pb-5">
  <div class="w-full px-3 mb-6 xl:mb-0">
    <div class="relative flex flex-col bg-white shadow-xl rounded-2xl p-4">
      <h2 class="text-xl font-semibold mb-4">Asignar Conductor a Vehículo</h2>

      <form id="formAsignacion">
        <div class="row mb-3">
          <div class="col">
            <label for="vehiculo" class="form-label">Vehículo</label>
            <select class="form-select" name="vehiculo_id" required>
              <option value="">-- Selecciona --</option>
              <?php foreach ($vehiculos as $v): ?>
                <option value="<?= $v['vehiculo_id'] ?>">
                  <?= $v['placas'] ?> - <?= $v['marca'] ?> <?= $v['modelo'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col">
            <label for="conductor" class="form-label">Conductor</label>
            <select class="form-select" name="conductor_id" required>
              <option value="">-- Selecciona --</option>
              <?php foreach ($conductores as $c): ?>
                <option value="<?= $c['conductor_id'] ?>">
                  <?= $c['licencia'] ?> - <?= $c['user_name'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <button class="btn btn-primary" type="submit">Asignar</button>
      </form>
    </div>
  </div>
</div>

<!-- Tabla de asignaciones -->
<div class="w-full px-4 py-4">
  <div class="overflow-x-auto rounded-lg shadow bg-white p-4">
    <h2 class="text-lg font-semibold mb-3">Conductores Asignados</h2>

    <table id="tablaAsignaciones" class="w-full text-sm text-left text-gray-500">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
          <th class="px-4 py-2">Vehículo</th>
          <th class="px-4 py-2">Conductor</th>
          <th class="px-4 py-2">Fecha asignación</th>
          <th class="px-4 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<script>
$(document).ready(function () {
  $('#loaderContainer').hide();

  // Cargar tabla al inicio
  cargarAsignaciones();

  // Envío del formulario
  $('#formAsignacion').submit(function (e) {
    e.preventDefault();

    $.post('conductores/ajax/asignar_conductor_vehiculo.php', $(this).serialize(), function (response) {
      alert(response.message);
      if (response.success) {
        location.reload(); // Puedes cambiar por: cargarAsignaciones();
      }
    }, 'json');
  });

  // Delegar evento de desasignar
  $(document).on('click', '.btn-desasignar', function () {
    const vehiculo_id = $(this).data('vehiculo');
    const conductor_id = $(this).data('conductor');

    if (confirm('¿Deseas desasignar este conductor?')) {
      $.post('conductores/ajax/desasignar_conductor.php', {
        vehiculo_id,
        conductor_id
      }, function (resp) {
        const res = JSON.parse(resp);
        alert(res.message);
        if (res.success) location.reload();
      });
    }
  });
});

// Función para cargar la tabla vía AJAX
function cargarAsignaciones() {
  $.get('conductores/ajax/Get_conductores_asignados.php', function (html) {
    // Destruir instancia previa del DataTable
    if ($.fn.DataTable.isDataTable('#tablaAsignaciones')) {
      $('#tablaAsignaciones').DataTable().destroy();
    }

    // Reemplazar contenido del tbody
    $('#tablaAsignaciones tbody').html(html);

    // Inicializar DataTable
    $('#tablaAsignaciones').DataTable({
      order: [[2, 'desc']],
      pageLength: 10,
      lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"]],
      dom: 'lBfrtip',
      language: {
        url: "../vendor/dataTable/lenguajes/es-ES.json"
      }
    });
  });
}
</script>
