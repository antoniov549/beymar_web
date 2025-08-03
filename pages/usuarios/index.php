<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

var_dump($_REQUEST);
?>



<div id="contenedor-ejemplo">
	<div class="card m-b-40">
		<div class="card-body">
				<!-- <div class="container"> -->
						<div class="panel panel-success">
							<div class="panel-heading">
							    <div class="btn-group pull-left">
									<?php if ($_SESSION['nivel'] == 1){?>
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

								<h4><i class='zmdi zmdi-search'></i> Buscar Usuario</h4>
							</div>
							<div class="panel-body">
							
								<form class="form-horizontal" role="form" id="datos_cotizacion">

											<div class="form-group row m-b-10">
												<label for="q" class="col-md-2 control-label">Name:</label>
												<div class="col-md-5">
													<input type="text" class="form-control" id="q" placeholder="Name" onkeyup='load(1);'>
												</div>



												<div class="col-md-3">
													<button type="button" class="btn btn-light" onclick='load(1);'>
														<span class="zmdi zmdi-search" ></span> Search</button>
													<span id="loader"></span>
												</div>

											</div>



								</form>
								<div id="resultados"></div><!-- Carga los datos ajax -->
								<div class='outer_div'></div><!-- Carga los datos ajax -->

							</div>
						</div>
				</div>



		<!-- </div> -->
	</div>
</div>
 



<script type="text/javascript">
$('#loaderContainer').show();
$(document).ready(function(){
	$('#loaderContainer').hide();


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
</script>