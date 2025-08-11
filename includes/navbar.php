      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="false">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <!-- breadcrumb -->
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="text-sm leading-normal">
                <a class="text-white opacity-50" href="javascript:;">Paginas</a>
              </li>
              <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page"><?php echo $page; ?></li>
            </ol>
            <h6 class="mb-0 font-bold text-white capitalize"><?php echo $page; ?></h6>
          </nav>

          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
              <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease">
               <!--  <span class="text-sm ease leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                  <i class="fas fa-search"></i>
                </span> -->
                <!-- <input type="text" class="pl-9 text-sm focus:shadow-primary-outline ease w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow" placeholder="Type here..." /> -->
              </div>
            </div>
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
              
               <!--  -->
              <!-- VENTANA FLOTANTE PARA LOS DATOS DE PERFIL -->
              <div class="account-wrap">
                <div class="account-item js-item-menu">
                  <div class="image rounded-circle">
                    <img src="../assets/img/profile-01.png" alt="<?php echo $user_name; ?>" />
                  </div>
                  <div class="content">
                    <a class="js-acc-btn" href="#"><?php echo $user_name; ?></a>
                  </div>
                  <div class="account-dropdown js-dropdown">
                    <div class="info clearfix">
                      <div class="image rounded-circle">
                        <a href="/meta/mis_datos/">
                          <img src="../assets/img/profile-01.png" alt="<?php echo $user_name; ?>" />
                        </a>
                      </div>
                      <div class="content">
                        <h5 class="name">
                          <a href="/meta/mis_datos/"><?php echo $user_name; ?></a>
                        </h5>
                        <span class="email"><?php echo $rol_id; ?></span>
                      </div>
                    </div>
                    <div class="account-dropdown__body">
                      <div class="account-dropdown__item">
                        <a href="../pages/profile.html">
                          <i class="zmdi zmdi-account"></i>Cuenta
                        </a>
                      </div>
                  
                     
                    
                    </div>
                    <div class="account-dropdown__footer">
                      <a href="../pages/sign-in.php?logout">
                        <i class="zmdi zmdi-power"></i>Cerrar Sesión
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <!--  -->




              <li class="flex items-center pl-4 xl:hidden">
                <a href="javascript:;" class="block p-0 text-sm text-white transition-all ease-nav-brand" sidenav-trigger>
                  <div class="w-4.5 overflow-hidden">
                    <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                    <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                    <i class="ease relative block h-0.5 rounded-sm bg-white transition-all"></i>
                  </div>
                </a>
              </li>
              <!-- <li class="flex items-center px-4">
                <a href="javascript:;" class="p-0 text-sm text-white transition-all ease-nav-brand">
                  <i fixed-plugin-button-nav class="cursor-pointer fa fa-cog"></i>
                  
                </a>
              </li> -->

              <!-- notifications -->

             
            </ul>
          </div>
        </div>
      </nav>