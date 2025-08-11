<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//var_dump($_REQUEST);

include_once('../class/Cls_tarifas.php');
$Cls_tarifas = new Cls_tarifas();
$Cls_tarifas->checkRole(['2', '1','4', '3' ]);

?>
<style>
  #svg2 {
    width: 250px;
    height: 400px; /* Mantiene proporción */
  }
  #rango_tarifas{
    height: 480px; /* Mantiene proporción */
    overflow: auto;   /* muestra scroll si el contenido sobrepasa tamaño */
  }
  .col-search-input{
    padding: .5em;
    font-size: .9em;
  }
</style>




<!-- mini reporte -->
<div class="flex flex-wrap mt-6 -mx-3 p-b-20">
    <!--  -->
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
      <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
        
        <div id="rango_tarifas"></div>

        

      </div>
    </div>
    <!--  -->
    <!--  -->
    <div class="w-full max-w-full px-3 mt-0 lg:w-5/12 lg:flex-none">
      <div class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
        <div class="p-4 pb-0 rounded-t-4">
          <h6 class="mb-0 dark:text-white">Zonas:</h6>
        </div>
        <div class="flex-auto p-4">

            <div id="detalles_tarifa" ></div>



            <div id="svg-container" ></div>
        </div>

      </div>
    </div>
          <!--  -->
</div>
<!-- mini reporte -->



<!-- card3 -->
<div class="flex flex-wrap -mx-3">
  <div class="w-full max-w-full px-3 mb-6 sm:w-1/1 sm:flex-none xl:mb-0 xl:w-1/1">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="flex-auto p-4">
        <div class="flex flex-row -mx-3">
          <div class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-12/12 lg:w-12/12 xl:w-12/12">
          <!-- contenido -->
              

            <div class="p-t-20 table-responsive" id="tabla_tarifas"></div>

              
          <!-- contenido -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- card3 -->


<script>
  $(document).ready(function() {


    Imprime_vista_rapida_tarifas('rango_tarifas');
    Imprime_tabla_tarifas('tabla_tarifas','');
  


    $("#svg-container").load("tarifas/js/Mexico_Quintana_Roo_Bacalar_location_map.svg", function(response, status, xhr) {
      if (status === "error") {
        console.log("Error cargando SVG:", xhr.status, xhr.statusText);
      } else {
        console.log("SVG cargado correctamente");

        // Aquí añadimos eventos click a los elementos path dentro del SVG cargado
        $("#svg-container path").css("cursor", "pointer").on("click", function() {
          var regionId = $(this).attr("id") || "sin id";
          alert("Hiciste clic en la región: " + regionId);
        });
      }
    });
  });


  function Imprime_vista_rapida_tarifas(contenedor) {
  const $contenedor = $(`#${contenedor} `);
  if (!$contenedor.length) return;

  $('#loaderContainer').show();

  $.ajax({
    url: 'tarifas/ajax/Get_rango_tarifas.php',
    method: 'POST',
    success: function (html) {
       // console.log(html);
      $contenedor.html(html);
     
      inicializarEventosVistaRapida(contenedor);
    },
    error: function (xhr, status, error) {
      console.error('Error al cargar los datos:', error);
      $('#loaderContainer').hide();
    },
    complete: function () {
      $('#loaderContainer').hide();
    }
  });
}


function inicializarEventosVistaRapida(contenedor) {
  
  const $contenedor = $(`#${contenedor}`);
  const $datos = $contenedor.find('.datoInterno');
  // Eliminar eventos anteriores y asignar nuevo click
  $datos.off('click').on('click', function () {

    const datos = $(this).data();
    // console.log(datos);
    $.post('tarifas/ajax/Get_informacion_zona.php', datos, function (html) {
        // console.log(html);
        $("#svg-container").hide('slow');
        $('#detalles_tarifa').html(html);
    });

    Imprime_tabla_tarifas('tabla_tarifas', datos.zona);

  });
 
}


// 
function Imprime_tabla_tarifas(contenedor, zona) {
  const $contenedor = $(`#${contenedor}`);
  if (!$contenedor.length) return;

  $('#loaderContainer').show();

  $.ajax({
    url: `tarifas/ajax/Get_tabla_tarifas.php?zona=${zona}`,
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
function inicializarEventosTabla(contenedor) {
  
  const $contenedor = $(`#${contenedor}`);
  const $tabla = $contenedor.find('#tablaTarifas');
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
    order: [[0, 'desc']],
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
