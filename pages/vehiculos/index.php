<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//var_dump($_REQUEST);

include_once('../class/Cls_usuarios.php');
$Cls_usuarios = new Cls_usuarios();
$Cls_usuarios->checkRole(['2', '1','4', '3' ]);

?>
<!-- mini reporte -->
<div class="flex flex-wrap mt-6 -mx-3 p-b-20">
    <!--  -->
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
      <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
        <div id="sin_conductor">
          
        </div>
        
      </div>
    </div>
    <!--  -->
    <!--  -->
    <div class="w-full max-w-full px-3 mt-0 lg:w-5/12 lg:flex-none">
      <div class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
        <div id="documentos_vencidos">
          
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
            <div class="panel panel-success">
              <div class="panel-heading">
                  <div class="btn-group pull-left">
                  <?php if ($_SESSION['rol_id'] != 3){?>
                    <button 
                        type='button' 
                        class="btn btn-info"
                        id="add_veiculo"
                    >
                        <span class="fa fa-plus-square" ></span> Nuevo Vehiculo
                    </button> 
                  <?php
                    }
                  ?>
                </div>
              </div>
            </div>
            <!-- TABLAS  -->  
            <div class="col-sm-12 col-md-12 col-lg-12"  id="conteiner_vehiculos" >
               
                <div class="table-responsive">

                </div>

            </div>
            <!-- TABLAS  -->    
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
	Imprime_tabla_vehiculos('conteiner_vehiculos');
  Imprime_vehiculos_sin_conductor('sin_conductor');
  Imprime_documentacion_vencida('documentos_vencidos');


	$('#add_veiculo').on('click', function() {
	    $('#loaderContainer').show();
	    var opcion='insert';    
	    $.ajax({
	      //url: 'modal/add_trd.php',
	      url:'vehiculos/modal/agregar_vehiculos.php',
	      type: 'post',
	      data: {
	      opcion : opcion  
	    },
	    success: function(response){ 
	      // Add response in Modal body
	      $('#modal-lg .modal-content').html(response); 
	      $('#modal-lg').modal('show');
	      // Display Modal
	      $('#loaderContainer').hide(); 
	    },
	    error: function () {
	       $('#loaderContainer').hide();
	    }

	    });
	});

});

// 
function Imprime_tabla_vehiculos(contenedor) {
  const $contenedor = $(`#${contenedor} .table-responsive`);
  if (!$contenedor.length) return;

  $('#loaderContainer').show();

  $.ajax({
    url: 'vehiculos/ajax/Get_tabla_vehiculos.php',
    method: 'POST',
    success: function (html) {
       // console.log(html);
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
  const $tabla = $contenedor.find('.tabla_vehiculos');
  const $datos = $tabla.find('.datoInterno');

  // Ocultar contenedor si solo hay un dato
  // $contenedor.toggle($datos.length > 1);

  // Eliminar eventos anteriores y asignar nuevo click
  $datos.off('click').on('click', function () {
    const datos = $(this).data();
    $.post('vehiculos/modal/detalle_tabla_vehiculos.php', datos, function (response) {
      $('#modal-lg .modal-content').html(response);
      $('#modal-lg').modal('show');
    });
  });

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
  $tabla.DataTable({
    order: [[1, 'desc']],
    lengthMenu: [[5, 10, 25, 50, 100, 200, -1], [5, 10, 25, 50, 100, 200, "All"]],
    pageLength: 10,
    searching: true,
    dom: 'lBfrtip',
    language: {
    url: "../vendor/dataTable/lenguajes/es-ES.json"
  },
  });

  // Efecto hover en columnas
  $tabla.find('.column100').off('mouseover mouseout').on('mouseover mouseout', function (event) {
    const $celda = $(this);
    const $fila = $celda.closest('tr');
    const $tabla = $celda.closest('table');
    const vertable = $tabla.data('vertable') || '';
    const column = $celda.data('column') || '';
    const accion = event.type === 'mouseover' ? 'addClass' : 'removeClass';

    $fila.find(`.${column}`)[accion](`hov-column-${vertable}`);
    $tabla.find(`.row100.head .${column}`)[accion](`hov-column-head-${vertable}`);
  });
}



// 
function Imprime_vehiculos_sin_conductor(contenedor) {
  const $contenedor = $(`#${contenedor} `);
  if (!$contenedor.length) return;

  $('#loaderContainer').show();

  $.ajax({
    url: 'vehiculos/ajax/Get_vehiculos_sin_conductor.php',
    method: 'POST',
    success: function (html) {
       // console.log(html);
      $contenedor.html(html);
     
      // inicializarEventosTabla(contenedor);
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
// 
function Imprime_documentacion_vencida(contenedor) {
  const $contenedor = $(`#${contenedor} `);
  if (!$contenedor.length) return;

  $('#loaderContainer').show();

  $.ajax({
    url: 'vehiculos/ajax/Get_documentacion_vencida.php',
    method: 'POST',
    success: function (html) {
       // console.log(html);
      $contenedor.html(html);
     
      // inicializarEventosTabla(contenedor);
    },
    error: function (xhr, status, error) {
      console.error('Error al cargar los datos:', error);
    },
    complete: function () {
      $('#loaderContainer').hide();
    }
  });
}






</script>