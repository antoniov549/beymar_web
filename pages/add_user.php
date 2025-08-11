<?php 
  include('../includes/comprobar_logeo.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <?php 
      include('../includes/head.php');
    ?>
  </head>
  <!--  -->
  <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
     <div class="absolute bg-y-50 w-full top-0 bg-[url('/assets/img/profile-layout-header.jpg')] min-h-75">
      <span class="absolute top-0 left-0 w-full h-full bg-blue-500 opacity-60"></span>
    </div>
    <!-- sidenav  -->
    <?php 
     $page='Usuarios';
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
                  <div class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-12/12 lg:w-12/12 xl:w-12/12">

                    <?php include('usuarios/index.php') ?>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- modals -->
        <?php  include('../includes/modals.php'); ?>
        <!-- modals -->

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
