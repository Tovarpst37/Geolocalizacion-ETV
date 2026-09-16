<style>
  :root {
    --sb-dark: #000687;
    --sb-primary: #0339A6;
    --sb-accent: #0B79D9;
    --sb-secondary: #3270A6;
    --sb-light: #7AA5BF;
  }

  .sidebar {
    background: linear-gradient(180deg, var(--sb-dark) 0%, var(--sb-primary) 55%, var(--sb-secondary) 100%);
  }

  .sidebar .nav-section .text-section {
    color: var(--sb-light);
    letter-spacing: .5px;
    font-weight: 600;
  }

  .sidebar .nav-item > a {
    color: #ffffff;
  }

  .sidebar .nav-item > a i.fas {
    color: var(--sb-light);
    width: 22px;
    text-align: center;
  }

  .sidebar .nav-item > a:hover,
  .sidebar .nav-item > a:hover i.fas {
    color: #ffffff;
    background-color: var(--sb-accent);
    border-radius: 6px;
  }

  .sidebar .nav-collapse .sub-item {
    color: #dbe7f5;
  }

  .sidebar .nav-collapse a:hover .sub-item {
    color: #ffffff;
  }

  .sub-item-pending {
    opacity: .6;
  }

  .badge-pending {
    font-size: 10px;
    background: var(--sb-accent);
    color: #fff;
    border-radius: 10px;
    padding: 1px 6px;
    margin-left: 6px;
  }
</style>

<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <div class="logo-header" data-background-color="dark">
      <a href="index.php" class="logo">
        <img src="assets/img/LogoProye.png" alt="navbar brand" class="navbar-brand"
          style="width: 80px; height: 55px; border-radius: 50%; object-fit: cover; object-position: center; image-rendering: -webkit-optimize-contrast;" />
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
  </div>

  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">

        <li class="nav-item active">
          <a data-bs-toggle="collapse" href="index.php" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Inicio</p>
          </a>
        </li>

        <!-- Gestión de usuario -->
        <li class="nav-section">
          <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
          <h4 class="text-section">Gestión de usuario</h4>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#gestionUsuario">
            <i class="fas fa-user-shield"></i>
            <p>Usuarios</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="gestionUsuario">
            <ul class="nav nav-collapse">
              <li><a href="<?php echo getUrl("Usuario", "Usuario", "getCreate"); ?>"><span class="sub-item">Registrar Usuario</span></a></li>
              <li><a href="<?php echo getUrl("Usuario", "Usuario", "getUsuario"); ?>"><span class="sub-item">Consultar Usuario</span></a></li>
            </ul>
          </div>
        </li>

        <!-- Zoocriadero -->
        <li class="nav-section">
          <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
          <h4 class="text-section">Zoocriadero</h4>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#zoocriaderos">
            <i class="fas fa-fish"></i>
            <p>Zoocriadero</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="zoocriaderos">
            <ul class="nav nav-collapse">
              <li><a href="<?php echo getUrl("Zoocriadero", "Zoocriadero", "getRegistrar") ?>"><span class="sub-item">Registrar Zoocriadero</span></a></li>
              <li><a href="<?php echo getUrl("Zoocriadero", "Zoocriadero", "getConsultar") ?>"><span class="sub-item">Consultar Zoocriadero</span></a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#tanquesZoocriadero">
            <i class="fas fa-water"></i>
            <p>Tanques</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="tanquesZoocriadero">
            <ul class="nav nav-collapse">
              <li><a href="<?php echo getUrl("Tanque", "Tanque", "getRegistrar") ?>"><span class="sub-item">Registrar tanque</span></a></li>
              <li><a href="<?php echo getUrl("Tanque", "Tanque", "getConsultar") ?>"><span class="sub-item">Consultar tanque</span></a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#actividadesZoocriadero">
            <i class="fas fa-tasks"></i>
            <p>Actividades</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="actividadesZoocriadero">
            <ul class="nav nav-collapse">
              <li><a href="<?php echo getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getRegistrar") ?>"><span class="sub-item">Registrar actividad</span></a></li>
              <li><a href="<?php echo getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar") ?>"><span class="sub-item">Consultar actividad</span></a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#seguimientoZoocriadero">
            <i class="fas fa-chart-line"></i>
            <p>Seguimientos</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="seguimientoZoocriadero">
            <ul class="nav nav-collapse">
              <li><a href="<?php echo getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getRegistrar") ?>"><span class="sub-item">Registrar seguimiento</span></a></li>
              <li><a href="<?php echo getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getConsultar") ?>"><span class="sub-item">Consultar seguimiento</span></a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#fomularioZoocriadero">
            <i class="fas fa-file-alt"></i>
            <p>Formularios</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="fomularioZoocriadero">
            <ul class="nav nav-collapse">
              <li><a href="<?php echo getUrl("FormularioZ", "FormularioZ", "getRegistrar") ?>"><span class="sub-item">Registrar Alimentación</span></a></li>
              <li><a href="<?php echo getUrl("FormularioM", "FormularioM", "getRegistrar") ?>"><span class="sub-item">Registrar Peces Muertos y nacidos</span></a></li>
              <li><a href="<?php echo getUrl("FormularioLi", "FormularioLi", "getRegistrar") ?>"><span class="sub-item">Registrar Limpieza</span></a></li>
              <li><a href="<?php echo getUrl("FormularioAj", "FormularioAj", "getRegistrar") ?>"><span class="sub-item">Registrar Ajuste de Nivel</span></a></li>
              <li><a href="<?php echo getUrl("FormularioLa", "FormularioLa", "getRegistrar") ?>"><span class="sub-item">Registrar Lavado</span></a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#HistorialZoocriadero">
            <i class="fas fa-history"></i>
            <p>Historial</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="HistorialZoocriadero">
            <ul class="nav nav-collapse">
              <li><a href="<?php echo getUrl("HistorialZoocriadero", "HistorialZoocriadero", "getRegistrar") ?>"><span class="sub-item">Consultar Historial</span></a></li>

            </ul>
          </div>
        </li>
        <!-- Trabajo en terreno -->
        <li class="nav-section">
          <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
          <h4 class="text-section">Trabajo en terreno</h4>
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
          <a data-bs-toggle="collapse" href="#Terreno">
            <i class="fas fa-map-marked-alt"></i>
            <p>Terreno</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="Terreno">
            <ul class="nav nav-collapse">
              <li><a href="<?php echo getUrl("Terreno", "Terreno", "getRegistrar") ?>"><span class="sub-item">Registrar terreno</span></a></li>
              <li><a href="<?php echo getUrl("Terreno", "Terreno", "getConsultar") ?>"><span class="sub-item">Consultar terreno</span></a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">

          <a data-bs-toggle="collapse" href="#depositoTerrono">
            <i class="fas fa-layer-group"></i>
            <p>Tipo de deposito</p>

          <a data-bs-toggle="collapse" href="#sitiosTerreno">
            <i class="fas fa-map-marker-alt"></i>
            <p>Sitios</p>

            <span class="caret"></span>
          </a>
          <div class="collapse" id="depositoTerrono">
            <ul class="nav nav-collapse">

              <li>
                <a href="<?php echo getUrl("TipoDeDeposito", "TipoDeDeposito", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar tipo de depósito</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("TipoDeDeposito", "TipoDeDeposito", "getConsultar") ?>">
                  <span class="sub-item"> Consultar tipo de depósito</span>
                </a>
              </li>

              <li><a href="<?php echo getUrl("Sitios", "Sitios", "getCreate2") ?>"><span class="sub-item">Registrar sitio</span></a></li>
              <li><a href="<?php echo getUrl("Sitios", "Sitios", "getConsultar") ?>"><span class="sub-item">Consultar sitio</span></a></li>
            </ul>
          </div>
        </li>



        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#Terreno">
            <i class="fas fa-layer-group"></i>
            <p>Terreno</p>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#depositoTerrono">
            <i class="fas fa-boxes"></i>
            <p>Tipo de depósito</p>

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

              <li><a href="<?php echo getUrl("TipoDeDeposito", "TipoDeDeposito", "getRegistrar") ?>"><span class="sub-item">Registrar tipo de depósito</span></a></li>
              <li><a href="<?php echo getUrl("TipoDeDeposito", "TipoDeDeposito", "getConsultar") ?>"><span class="sub-item">Consultar tipo de depósito</span></a></li>

            </ul>
          </div>
        </li>


        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#actividadTerrono">
            <i class="fas fa-clipboard-list"></i>
            <p>Actividades</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="actividadTerrono">
            <ul class="nav nav-collapse">
              <li class="sub-item-pending"><a href="#"><span class="sub-item">Registrar actividad</span><span class="badge-pending">Próximo</span></a></li>
              <li class="sub-item-pending"><a href="#"><span class="sub-item">Consultar actividad</span><span class="badge-pending">Próximo</span></a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#seguimientoTerreno">
            <i class="fas fa-route"></i>
            <p>Seguimientos</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="seguimientoTerreno">
            <ul class="nav nav-collapse">
              <li><a href="<?php echo getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getRegistrar") ?>"><span class="sub-item">Registrar seguimiento</span></a></li>
              <li><a href="<?php echo getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getConsultar") ?>"><span class="sub-item">Consultar seguimiento</span></a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#fomularioTerreno">
            <i class="fas fa-file-signature"></i>
            <p>Formularios</p>
            <span class="caret"></span>
          </a>

          <div class="collapse" id="fomularioTerreno">
            <ul class="nav nav-collapse">

              <li>
                <a href="<?php echo getUrl("FormularioInsp", "FormularioInsp", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar Inspección</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("FormularioSiem", "FormularioSiem", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar Siembra</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("FormularioSegT", "FormularioSegT", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar Seguimiento</span>
                </a>
              </li>
              <li>
                <a href="<?php echo getUrl("FormularioResi", "FormularioResi", "getRegistrar") ?>">
                  <span class="sub-item"> Registrar Resiembra</span>
                </a>
              </li>


              <li class="sub-item-pending"><a href="#"><span class="sub-item">Registrar formulario</span><span class="badge-pending">Próximo</span></a></li>
              <li class="sub-item-pending"><a href="#"><span class="sub-item">Consultar formulario</span><span class="badge-pending">Próximo</span></a></li>

            </ul>
          </div>

        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#HistorialTerreno">
            <i class="fas fa-history"></i>
            <p>Historial</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="HistorialTerreno">
            <ul class="nav nav-collapse">
              <li><a href="<?php echo getUrl("HistorialTerreno", "HistorialTerreno", "getRegistrar") ?>"><span class="sub-item">Consultar Historial</span></a></li>
            </ul>
          </div>
        </li>

        <!-- Reportes -->
        <li class="nav-section">
          <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
          <h4 class="text-section">Reportes</h4>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#reportesTerrono">
            <i class="fas fa-chart-bar"></i>
            <p>Reportes</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="reportesTerrono">
            <ul class="nav nav-collapse">
              <li class="sub-item-pending"><a href="#"><span class="sub-item">Seguimiento de actividades</span><span class="badge-pending">Próximo</span></a></li>
              <li class="sub-item-pending"><a href="#"><span class="sub-item">Peces nacidos/muertos por tanque</span><span class="badge-pending">Próximo</span></a></li>
              <li class="sub-item-pending"><a href="#"><span class="sub-item">Tanques por zoocriadero</span><span class="badge-pending">Próximo</span></a></li>
              <li class="sub-item-pending"><a href="#"><span class="sub-item">Sitios registrados</span><span class="badge-pending">Próximo</span></a></li>
              <li class="sub-item-pending"><a href="#"><span class="sub-item">Actividades de terreno por tipo</span><span class="badge-pending">Próximo</span></a></li>
              <li class="sub-item-pending"><a href="#"><span class="sub-item">Actividades por auxiliar</span><span class="badge-pending">Próximo</span></a></li>
              <li class="sub-item-pending"><a href="#"><span class="sub-item">Tipo de depósitos</span><span class="badge-pending">Próximo</span></a></li>
              <li class="sub-item-pending"><a href="#"><i class="fas fa-file-excel"></i><span class="sub-item">Exportar a Excel</span></a></li>
            </ul>
          </div>
        </li>

      </ul>
    </div>
  </div>
</div>

<!-- Prectica git flow maria paz -->
<!-- End Sidebar -->