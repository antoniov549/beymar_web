<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

var_dump($_REQUEST);
?>



<!-- card3 -->
<div class="flex flex-wrap -mx-3">
  <div class="w-full max-w-full px-3 mb-6 sm:w-1/1 sm:flex-none xl:mb-0 xl:w-1/1">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="flex-auto p-4">
        <div class="flex flex-row -mx-3">
          <div class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-12/12 lg:w-12/12 xl:w-12/12">
          <!-- contenido -->
              

            <div class="p-t-20 table-responsive" id="tabla_viajes"></div>

            
              
          <!-- contenido -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- card3 -->
<script type="text/javascript">
$('#loaderContainer').show();
$(document).ready(function(){
	$('#loaderContainer').hide();

	Imprime_tabla_tarifas('tabla_viajes');
});

// 
function Imprime_tabla_tarifas(contenedor) {
  const $contenedor = $(`#${contenedor}`);
  if (!$contenedor.length) return;

  $('#loaderContainer').show();

  $.ajax({
    url: `viajes/ajax/Get_tabla_viajes.php`,
    method: 'POST',
    success: function (html) {
      $contenedor.html(html);
      inicializarEventosTabla(contenedor);
    },
    error: function (xhr, status, error) {
      console.error('Error al cargar los datos:', error);
    },
    complete: function () {
      $('#loaderContainer').hide();
    }
  });
}
//
function inicializarEventosTabla(contenedor) {
  
  const $contenedor = $(`#${contenedor}`);
  const $tabla = $contenedor.find('#tablaViajes');
  const $datos = $tabla.find('.datoInterno');

  // Destruir DataTable si ya existe
  if ($.fn.DataTable.isDataTable($tabla)) {
    $tabla.DataTable().destroy();
  }

  // Encabezados con campo de búsqueda
  $tabla.find('thead th.si_input').each(function () {
    const titulo = $(this).text();
    $(this).html(`
      ${titulo}
      <div><input type="text" class="col-search-input form-control" placeholder="Buscar" /></div>
    `);
  });

  // Inicializar DataTable
  const tablaDT = $tabla.DataTable({
    order: [[1, 'desc']],
    lengthMenu: [[5, 10, 25, 50, 100, 200, -1], [5, 10, 25, 50, 100, 200, "All"]],
    pageLength: 10,
    searching: true,
    dom: 'lBfrtip',
    language: {
      url: "../vendor/dataTable/lenguajes/es-ES.json"
    },
  });

  // Activar búsqueda por columna
  tablaDT.columns().every(function () {
    const that = this;
    $('input', this.header()).on('keyup change', function () {
      if (that.search() !== this.value) {
        that.search(this.value).draw();
      }
    });
  });


  //activa el modal
   // Eliminar eventos anteriores y asignar nuevo click
  $datos.off('click').on('click', function () {
    const datos = $(this).data();
    // console.log(datos);
    $.post('tarifas/modal/Set_viaje.php', datos, function (html) {
        // console.log(html);
          $('#modal-lg .modal-content').html(html);
          $('#modal-lg').modal('show');
    });



  });


}




</script>