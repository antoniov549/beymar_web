<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_REQUEST);

include_once('../class/Cls_vehiculos.php');
include_once('../class/Cls_conductores.php');

$Cls_vehiculos = new Cls_vehiculos();
$Cls_conductores = new Cls_conductores();

// Obtener listas
$vehiculos = $Cls_vehiculos->Get_vehiculos_disponibles(); // vehiculos sin asignar
$conductores = $Cls_conductores->Get_conductores_sin_vehiculo();

?>


<!-- cards -->

<!-- row 1 -->
<div class="flex flex-wrap -mx-3 p-b-20">
  <!-- card3 -->
  <div class="w-full max-w-full px-3 mb-6 sm:w-1/1 sm:flex-none xl:mb-0 xl:w-1/1">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="flex-auto p-4">
        <div class="flex flex-row -mx-3">
          <div class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-12/12 lg:w-12/12 xl:w-12/12">

            <div class="container">
              <h2 class="mb-4">Asignar Conductor a Vehículo</h2>

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

              <hr class="my-5">
            </div>
               
          
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


  

  
<!-- card3 -->
<div class="flex flex-wrap -mx-3">
  <div class="w-full max-w-full px-3 mb-6 sm:w-1/1 sm:flex-none xl:mb-0 xl:w-1/1">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

      <div class="card">
        <div class="card-body">
          <h4 class="p-b-20">Asignaciones actuales</h4>
          <div id="tablaAsignaciones"></div>
        </div>
      </div>

      
    </div>
  </div>
</div>



<script type="text/javascript">
$('#loaderContainer').show();
$(document).ready(function() {
  $('#loaderContainer').hide();
    cargarAsignaciones();

    $('#formAsignacion').submit(function(e) {
      e.preventDefault();
      $.post('conductores/ajax/asignar_conductor_vehiculo.php', $(this).serialize(), function(response) {
        alert(response.message);
        if (response.success) {
          location.reload();
        }
      }, 'json');
    });
  });

function cargarAsignaciones() {
  $.get('conductores/ajax/Get_conductores_asignados.php', function(data) {
    $('#tablaAsignaciones').html(data); // inserta tabla HTML completa

    // Ahora que la tabla ya existe, la inicializas
    $('#tabla_conductores').DataTable({
      order: [[1, 'desc']],
      lengthMenu: [[5, 10, 25, 50, 100, 200, -1], [5, 10, 25, 50, 100, 200, "Todos"]],
      pageLength: 10,
      searching: true,
      dom: 'lBfrtip',
      language: {
        url: "../vendor/dataTable/lenguajes/es-ES.json"
      },
      
    });
  });
}



  $(document).on('click', '.desasignar-btn', function () {
  const vehiculo_id = $(this).data('vehiculo');
  const conductor_id = $(this).data('conductor');

  if (!confirm('¿Estás seguro de desasignar este conductor?')) return;

  $.ajax({
    url: 'conductores/ajax/desasignar_conductor.php',
    method: 'POST',
    dataType: 'json',
    data: { vehiculo_id, conductor_id },
    success: function (response) {
      if (response.success) {
        alert(response.message);
        location.reload(); // o puedes actualizar solo la tabla
      } else {
        alert('Error: ' + response.message);
      }
    },
    error: function () {
      alert('Error en la petición AJAX.');
    }
  });
});


</script>