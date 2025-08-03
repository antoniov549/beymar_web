<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_REQUEST);

include_once('../class/Cls_usuarios.php');
$Cls_usuarios = new Cls_usuarios();
$Cls_usuarios->checkRole(['2', '1']);
?>



<div id="contenedor-ejemplo">
	<div class="card m-b-40">
		<div class="card-body">
			
						<div class="panel panel-success">
							<div class="panel-heading">
							    <div class="btn-group pull-left">
									<?php if ($_SESSION['rol_id'] != 3){?>
										<button 
												type='button' 
												class="btn btn-info"
												id="add_usuario"
										>
												<span class="fa fa-plus-square" ></span> Nuevo Usuario
										</button> 
									<?php
										}
									?>
								</div>
							</div>
						</div>

						<div class="row">
						    <div class="col-sm-12 col-md-12 col-lg-12"  id="conteiner_usuarios" >
						        <div class="au-card m-b-30">
						            <div class="au-card-inner">
						                <div class="table-responsive">

						                </div>
						            </div>
						        </div>
						    </div>
						    <!-- TABLAS  -->
						</div>


		</div>
	</div>
</div>
 



<script type="text/javascript">
$('#loaderContainer').show();
$(document).ready(function(){
	$('#loaderContainer').hide();

	Imprime_tabla_usuarios('conteiner_usuarios');


  $('#add_usuario').on('click', function() {
	    $('#loaderContainer').show();
	    var opcion='insert';    
	    $.ajax({
	      //url: 'modal/add_trd.php',
	      url:'usuarios/modal/agregar_usuario.php',
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
function Imprime_tabla_usuarios(contenedor) {
  const $contenedor = $(`#${contenedor} .table-responsive`);
  if (!$contenedor.length) return;

  $('#loaderContainer').show();

  $.ajax({
    url: 'usuarios/ajax/Get_tabla_usuarios.php',
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
  const $tabla = $contenedor.find('.tabla_usuarios');
  const $datos = $tabla.find('.datoInterno');

  // Ocultar contenedor si solo hay un dato
  $contenedor.toggle($datos.length > 1);

  // Eliminar eventos anteriores y asignar nuevo click
  $datos.off('click').on('click', function () {
    const datos = $(this).data();
    $.post('modal/detalle_tabla_wip_meta.php', datos, function (response) {
      $('#modal_xl_full_first .modal-content').html(response);
      $('#modal_xl_full_first').modal('show');
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

</script>