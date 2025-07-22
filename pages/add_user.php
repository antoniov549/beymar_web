<!DOCTYPE html>
<html>
  <head>
    <?php 
      include('../includes/head.php');
    ?>
  </head>
  <!--  -->
  <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>
    <!-- sidenav  -->
    <?php 
     $page='Add User';
      include('../includes/sidenav.php');
    ?>
    <!-- end sidenav -->

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
      <!-- Navbar -->
      <?php
        include('../includes/navbar.php');
      ?>
      <!-- end Navbar -->

      <!-- cards -->
      <div class="w-full px-6 py-6 mx-auto">
        <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
          <!-- card3 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/1 sm:flex-none xl:mb-0 xl:w-1/1">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
                    
                    <div class="relative z-0 flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                      <div class="p-6 mb-0 text-center bg-white border-b-0 rounded-t-2xl">
                        <h5>Register user</h5>
                      </div>
                      
                      <div class="flex-auto p-6">
                        <form action="procesar_registro.php" method="POST" enctype="multipart/form-data" role="form text-left">

  <!-- Nombre completo -->
  <div class="mb-4">
    <input type="text" name="nombre" required
      class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:outline-none"
      placeholder="Nombre completo" aria-label="Nombre" />
  </div>

  <!-- Email -->
  <div class="mb-4">
    <input type="email" name="email" required
      class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:outline-none"
      placeholder="Correo electrónico" aria-label="Email" />
  </div>

  <!-- Teléfono -->
  <div class="mb-4">
    <input type="tel" name="telefono" required
      class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:outline-none"
      placeholder="Teléfono" aria-label="Teléfono" />
  </div>

  <h3 class="mb-2 text-sm font-semibold text-slate-700">Documentos Requeridos</h3>

  <!-- Acta Constitutiva -->
  <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Acta Constitutiva (PDF)</label>
    <input type="file" name="acta_constitutiva" accept=".pdf" required
      class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-slate-100 hover:file:bg-slate-200" />
  </div>

  <!-- Permiso de ASUR -->
  <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Permiso de ASUR (PDF)</label>
    <input type="file" name="permiso_asur" accept=".pdf" required
      class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-slate-100 hover:file:bg-slate-200" />
  </div>

  <!-- Placas Federales -->
  <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Placas Federales (PDF o Imagen)</label>
    <input type="file" name="placas_federales" accept=".pdf,.jpg,.jpeg,.png" required
      class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-slate-100 hover:file:bg-slate-200" />
  </div>

  <!-- Seguro de Viajes -->
  <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Seguro de Viajes (PDF o Imagen)</label>
    <input type="file" name="seguro_viajes" accept=".pdf,.jpg,.jpeg,.png" required
      class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-slate-100 hover:file:bg-slate-200" />
  </div>

  <!-- Botón de enviar -->
  <div class="text-center">
    <button type="submit"
      class="inline-block w-full px-5 py-2.5 mt-6 mb-2 font-bold text-center text-white transition-all bg-gradient-to-tl from-zinc-800 to-zinc-700 rounded-lg shadow-md hover:bg-slate-700 hover:shadow-xs">
      Agregar Usuario
    </button>
  </div>

  <!-- Enlace para login -->
  <p class="mt-4 mb-0 leading-normal text-sm">
    ¿Ya tienes una cuenta? <a href="../pages/sign-in.html" class="font-bold text-slate-700">Iniciar sesión</a>
  </p>
</form>

                      </div>
                    </div>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div>
        
       

        <!-- cards row 3 -->

       
        <!-- footer -->
        <?php  include('../includes/footer.php'); ?>
        <!-- footer -->
      </div>
      <!-- end cards -->
    </main>
   
  </body>
  <!-- plugin for charts  -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!-- plugin for scrollbar  -->
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <!-- main script file  -->
  <script src="../assets/js/argon-dashboard-tailwind.js?v=1.0.1"></script>
  <!-- <script src="../assets/js/carousel.js></script> -->
</html>
