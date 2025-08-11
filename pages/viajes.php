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
     $page='viajes';
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
        <!-- Contenido -->
        <?php include('viajes/index.php') ?>
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
