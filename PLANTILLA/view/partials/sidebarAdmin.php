<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="index.php" class="logo">
        <a href="index.php" class="logo">
          <img src="assets/img/LogoProye.png" alt="navbar brand" class="navbar-brand"
            style="width: 80px; height: 55px; border-radius: 50%; object-fit: cover; object-position: center; image-rendering: -webkit-optimize-contrast;" />

        </a>
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->



  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <li class="nav-item active">
          <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Inicio</p>
            <!--   <span class="caret"></span> -->

          </a>

        </li>

        <!-- Modulo de usuario -->
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Gestión de usuario</h4>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#gestionUsuario">
            <i class="fas fa-layer-group"></i>
            <p>Usuarios</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="gestionUsuario">
            <ul class="nav nav-collapse">
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Registrar Usuario</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Consultar Usuario</span>
                </a>
              </li>

            </ul>
          </div>

        </li>



        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Zoocriadero</h4>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#zoocriaderos">
            <i class="fas fa-layer-group"></i>
            <p>Zoocriadero</p>
            <span class="caret"></span>
          </a>

          <div class="collapse" id="zoocriaderos">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php echo getUrl("Zoocriadero", "Zoocriadero", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar Zoocriadero</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("Zoocriadero", "Zoocriadero", "getConsultar") ?>">
                  <span class="sub-item"> Consultar Zoocriadero</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#tanquesZoocriadero">
            <i class="fas fa-layer-group"></i>
            <p>Tanques</p>
            <span class="caret"></span>
          </a>

          <div class="collapse" id="tanquesZoocriadero">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php echo getUrl("Tanque", "Tanque", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar tanque</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("Tanque", "Tanque", "getConsultar") ?>">
                  <span class="sub-item"> Consultar tanque</span>
                </a>
              </li>

            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#actividadesZoocriadero">
            <i class="fas fa-layer-group"></i>
            <p>Actividades</p>
            <span class="caret"></span>
          </a>

          <div class="collapse" id="actividadesZoocriadero">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php echo getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar actividad</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar") ?>">
                  <span class="sub-item"> Consultar actividad</span>
                </a>
              </li>

            </ul>
          </div>
        </li>



        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#seguimientoZoocriadero">
            <i class="fas fa-layer-group"></i>
            <p>Seguimientos</p>
            <span class="caret"></span>
          </a>

          <div class="collapse" id="seguimientoZoocriadero">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php echo getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar seguimiento</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getConsultar") ?>">
                  <span class="sub-item"> Consultar seguimiento</span>
                </a>
              </li>

            </ul>
          </div>
        </li>


        

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#fomularioZoocriadero">
            <i class="fas fa-layer-group"></i>
            <p>Fomularios</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="fomularioZoocriadero">
            <ul class="nav nav-collapse">
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item"> Registrar formulario</span>
                </a>
              </li>
              <li>
                <a href="components/buttons.html">
                  <span class="sub-item">Consultar formulario</span>
                </a>
              </li>


            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#HistorialZoocriadero">
            <i class="fas fa-layer-group"></i>
            <p>Historial</p>
            <span class="caret"></span>
          </a>

          <div class="collapse" id="HistorialZoocriadero">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php echo getUrl("HistorialZoocriadero", "HistorialZoocriadero", "getRegistrar") ?>">
                  <span class="sub-item"> Consultar Historial</span>
                </a>
              </li>

            </ul>
          </div>
        </li>






        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Trabajo en terreno</h4>
        </li>


        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#Terreno">
            <i class="fas fa-layer-group"></i>
            <p>Terreno</p>
            <span class="caret"></span>
          </a>

          <div class="collapse" id="Terreno">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php echo getUrl("Terreno", "Terreno", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar terreno</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("Terreno", "Terreno", "getConsultar") ?>">
                  <span class="sub-item"> Consultar terreno</span>
                </a>
              </li>

            </ul>
          </div>
        </li>



        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#sitiosTerreno">
            <i class="fas fa-layer-group"></i>
            <p>Sitios</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="sitiosTerreno">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php echo getUrl("Sitios", "Sitios", "getCreate2") ?>">
                  <span class="sub-item"> Registrar sitio</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("Sitios", "Sitios", "getConsultar") ?>">
                  <span class="sub-item"> Consultar sitio</span>
                </a>
              </li>
            </ul>
          </div>
        </li>








        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#depositoTerrono">
            <i class="fas fa-layer-group"></i>
            <p>Tipo de deposito</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="depositoTerrono">
            <ul class="nav nav-collapse">
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item"> Registrar tipo de depósito</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item"> Consultar tipo de depósito</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <!-- Modulos -->
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#actividadTerrono">
            <i class="fas fa-layer-group"></i>
            <p> Actividades</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="actividadTerrono">
            <ul class="nav nav-collapse">
              <!-- sub Modulos -->
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item"> Registrar actividad</span>
                </a>
              </li>
              <li>
                <a href="">
                  <span class="sub-item">Consultar actividad</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#seguimientoTerreno">
            <i class="fas fa-layer-group"></i>
            <p>Seguimientos</p>
            <span class="caret"></span>
          </a>

          <div class="collapse" id="seguimientoTerreno">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php echo getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar seguimiento</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getConsultar") ?>">
                  <span class="sub-item"> Consultar seguimiento</span>
                </a>
              </li>

            </ul>
          </div>
        </li>


        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#fomularioTerreno">
            <i class="fas fa-layer-group"></i>
            <p>Fomularios</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="fomularioTerreno">
            <ul class="nav nav-collapse">
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item"> Registrar formulario</span>
                </a>
              </li>
              <li>
                <a href="components/buttons.html">
                  <span class="sub-item">Consultar formulario</span>
                </a>
              </li>


            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#HistorialTerreno">
            <i class="fas fa-layer-group"></i>
            <p>Historial</p>
            <span class="caret"></span>
          </a>

          <div class="collapse" id="HistorialTerreno">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php echo getUrl("HistorialTerreno", "HistorialTerreno", "getRegistrar") ?>">
                  <span class="sub-item"> Consultar Historial</span>
                </a>
              </li>

            </ul>
          </div>
        </li>




        <!-- titulo de modulo -->
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">REPORTES</h4>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#reportesTerrono">
            <i class="fas fa-layer-group"></i>
            <p> Reportes</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="reportesTerrono">
            <ul class="nav nav-collapse">
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item"> Seguimiento de actividades</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item"> Peces nacidos/muertos por tanque</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Tanques por zoocriadero</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Sitios registrados</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item"> Actividades de terreno por tipo</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Actividades por auxiliar</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Tipo de depósitos</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Exportar a Excel</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->