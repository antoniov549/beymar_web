<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la configuración y constantes de conexión a la base de datos
require_once '../config/db.php';

// Incluir la clase Login
require_once '../class/login.php';

// Crear una instancia de la clase Login (maneja login/logout automáticamente)
$login = new Login();

// Verificar si el usuario está autenticado
if ($login->isUserLoggedIn()) {
    // Redirigir al área principal si el usuario ha iniciado sesión
    header("Location: home.php");
    exit;
}

// Si el usuario no está autenticado, puedes redirigirlo o mostrar el formulario de login aquí
// Por ahora, el bloque else está vacío. Puedes eliminarlo o manejarlo según tu lógica.
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <title>Beymar Travel</title>
    <!--     Fonts and icons     -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" /> -->
      <link href="../assets/css/googleapis.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Main Styling -->
    <link href="../assets/css/argon-dashboard-tailwind.css?v=1.0.1" rel="stylesheet" />
  </head>

  <body class="m-0 font-sans antialiased font-normal bg-white text-start text-base leading-default text-slate-500">
 
    <main class="mt-0 transition-all duration-200 ease-in-out">
      <section>
        <div class="relative flex items-center min-h-screen p-0 overflow-hidden bg-center bg-cover">
          <div class="container z-1">
            <div class="flex flex-wrap -mx-3">
              <div class="flex flex-col w-full max-w-full px-3 mx-auto lg:mx-0 shrink-0 md:flex-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
                <div class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none lg:py4 dark:bg-gray-950 rounded-2xl bg-clip-border">
                  <div class="p-6 pb-0 mb-0">
                    <h4 class="font-bold">Iniciar Seccion</h4>
                    <!-- Error and Success Messages -->
                    <?php if (isset($login)) { ?>
                        <?php if ($login->errors) { ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>Error! </strong>
                            <?php foreach ($login->errors as $error) { echo $error; } ?>
                        </div>
                        <?php } ?>
                        <?php if ($login->messages) { ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <strong>Noticia! </strong>
                            <?php foreach ($login->messages as $message) { echo $message; } ?>
                        </div>
                        <?php } ?>
                    <?php } ?>
                  </div>
                  <div class="flex-auto p-6">
                    <!-- form -->
                    <form 
                        method="post" action="sign-in.php" name="loginform" autocomplete="off" class="form-login"
                    >
                      <div class="mb-4">
                        <input 
                            placeholder="Usuario" name="user_name" type="text" value="" autofocus required 
                            class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                        />
                      </div>
                      <div class="mb-4">
                        <input 
                            placeholder="Contraseña" name="user_password" type="password" value="" autocomplete="off" required 
                            class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                      </div>
                      
                      <div class="flex items-center pl-12 mb-0.5 text-left min-h-6">
                        <input id="rememberMe" class="mt-0.5 rounded-10 duration-250 ease-in-out after:rounded-circle after:shadow-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-zinc-700/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-blue-500/95 checked:bg-blue-500/95 checked:bg-none checked:bg-right" type="checkbox" />
                        <label class="ml-2 font-normal cursor-pointer select-none text-sm text-slate-700" for="rememberMe">Recuerda me</label>
                      </div>
                      <div class="text-center">
                        <button
                            type="submit" name="login" id="submit"
                            class="inline-block w-full px-16 py-3.5 mt-6 mb-0 font-bold leading-normal text-center text-white align-middle transition-all bg-blue-500 border-0 rounded-lg cursor-pointer hover:-translate-y-px active:opacity-85 hover:shadow-xs text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25"
                        >Iniciar Seccion
                        </button>
                      </div>
                    </form>


                  </div>
                  <!-- <div class="border-black/12.5 rounded-b-2xl border-t-0 border-solid p-6 text-center pt-0 px-1 sm:px-6">
                    <p class="mx-auto mb-6 leading-normal text-sm">Don't have an account? <a href="../pages/sign-up.html" class="font-semibold text-transparent bg-clip-text bg-gradient-to-tl from-blue-500 to-violet-500">Sign up</a></p>
                  </div> -->
                </div>
              </div>
              <!--  -->
              <!-- <div class="absolute top-0 right-0 flex-col justify-center hidden w-6/12 h-full max-w-full px-3 pr-0 my-auto text-center flex-0 lg:flex">

                <div 
                    class="relative flex flex-col justify-center h-full bg-cover px-24 m-4 overflow-hidden rounded-xl"
                    style="background-image: url('/assets/img/logos/logo_beymar.png'); background-size: contain; background-repeat: no-repeat; background-position: center;"
                > 
                </div>
                
              
              </div> -->

               <div class="absolute top-0 right-0 flex-col justify-center hidden w-6/12 h-full max-w-full px-3 pr-0 my-auto text-center flex-0 lg:flex">
                <div class="relative flex flex-col justify-center h-full bg-cover px-24 m-4 overflow-hidden bg-signin-ill rounded-xl ">
                  <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-blue-500 to-violet-500 opacity-60"></span>
                  <h4 class="z-20 mt-12r font-bold text-white">"La atención es la nueva moneda"</h4>
                  <p class="z-20 text-white "></p>
                </div>
              </div>
              <!--  -->
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php  include('../includes/footer.php'); ?>
  </body>
  <!-- plugin for scrollbar  -->
  <script src="../assets/js/plugins/perfect-scrollbar.min.js" async></script>
  <!-- main script file  -->
  <script src="../assets/js/argon-dashboard-tailwind.js?v=1.0.1" async></script>
</html>
