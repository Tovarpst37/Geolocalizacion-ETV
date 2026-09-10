<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="index.php" class="logo">
        <img
          src="assets/img/kaiadmin/logo_light.svg"
          alt="navbar brand"
          class="navbar-brand"
          height="20" />

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
          <a
            data-bs-toggle="collapse"
            href="#dashboard"
            class="collapsed"
            aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Inicio</p>
            <!--   <span class="caret"></span> -->

          </a>

        </li>

        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">GESTIÓN DE USUARIOS</h4>
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
                  <span class="sub-item">Solicitudes de registro</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Lista de usuarios</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Asignar / editar rol</span>
                </a>
              </li>

              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Cambiar estado (activo/inactivo)</span>
                </a>
              </li>
            </ul>
          </div>

        </li>



        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Actividades Zoocriadero</h4>
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
          <a data-bs-toggle="collapse" href="#tanquesZoocriadero">
            <i class="fas fa-layer-group"></i>
            <p>Tanques</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="tanquesZoocriadero">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php echo getUrl("Tanque","Tanque","getRegistrar")?>">
                  <span class="sub-item"> Registrar tanque</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("Tanque","Tanque","getConsultar")?>">
                  <span class="sub-item"> Consultar tanque</span>
                </a>
              </li>

            </ul>
          </div>
        </li>






        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Actividades Trabajo de Terreno</h4>
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
                <a href="components/avatars.html">
                  <span class="sub-item"> Registrar sitio</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
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
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#actividadTerrono">
            <i class="fas fa-layer-group"></i>
            <p> Actividad de Terreno</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="actividadTerrono">
            <ul class="nav nav-collapse">
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item"> Registrar actividad</span>
                </a>
              </li>
              <li>
                <a href="components/avatars.html">
                  <span class="sub-item">Consultar actividad</span>
                </a>
              </li>
            </ul>
          </div>
        </li>


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