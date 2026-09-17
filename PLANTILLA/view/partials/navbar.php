<div class="main-header">
  <div class="main-header-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="index.php" class="logo">
        <img src="assets/img/Logo" alt="navbar brand" class="navbar-brand" height="20" />
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
  <!-- Navbar Header -->
  <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom lc-navbar">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <!-- Saludo fijo al usuario (sin estilo, texto normal) -->
      <div class="lc-navbar-greeting">
        <h3 class="mb-0">
          Hola, <?php echo $_SESSION['primer_nombre']; ?>
        </h3>
      </div>

      <ul class="navbar-nav topbar-nav align-items-center lc-navbar-actions">
        <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"
            aria-haspopup="true">
            <i class="fa fa-search"></i>
          </a>
          <ul class="dropdown-menu dropdown-search animated fadeIn">
            <form class="navbar-left navbar-form nav-search">
              <div class="input-group">
                <input type="text" placeholder="Search ..." class="form-control" />
              </div>
            </form>
          </ul>
        </li>

        <li class="nav-item topbar-icon dropdown hidden-caret ms-3">
          <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-envelope"></i>
          </a>
          <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
            <li>
              <div class="dropdown-title d-flex justify-content-between align-items-center">
                Mensages
                <a href="#" class="small">Marcar todos como leidos</a>
              </div>
            </li>
            <li>
              <div class="message-notif-scroll scrollbar-outer">
                <div class="notif-center">
                  <a href="#">
                    <div class="notif-content">
                      <span class="subject">Administrador</span>
                      <span class="block"> Tienes una tarea pendiente, porfavor solucionala lo antes posible</span>
                      <span class="time">5 minutes ago</span>
                    </div>
                  </a>
                </div>
              </div>
            </li>
            <li>
              <a class="see-all" href="javascript:void(0);">Mirar todos los mensajes<i class="fa fa-angle-right"></i>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item topbar-icon dropdown hidden-caret ms-3">
          <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-exclamation-triangle notif-icon"></i>
            <span class="notification">4</span>
          </a>
          <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
            <li>
              <div class="dropdown-title">
                Alertas por inclumplimiento
              </div>
            </li>
            <li>
              <div class="notif-scroll scrollbar-outer">
                <div class="notif-center">
                  <a href="#">
                    <div class="notif-icon">
                      <i class="fa fa-user-plus"></i>
                    </div>
                    <div class="notif-content">
                      <span class="block"> Falto llenar el formulario de peces muertos</span>
                      <span class="time">30 minutos</span>
                    </div>
                  </a>
                </div>
              </div>
            </li>
            <li>
              <a class="see-all" href="javascript:void(0);">Mirar todas las notificaciones<i
                  class="fa fa-angle-right"></i>
              </a>
            </li>
          </ul>
        </li>

        <!-- Botón fijo de cerrar sesión -->
        <li class="nav-item lc-logout-item ms-3">
          <a href="<?php echo getUrl("Acceso","Acceso","logout")?>" class="btn btn-outline-primary lc-logout-btn">
            <i class="fa fa-sign-out-alt me-1"></i> Cerrar Sesión
          </a>
        </li>

      </ul>
    </div>
  </nav>
  <!-- End Navbar -->

  <style>
    .lc-navbar {
      background-color: #ffffff !important;
      border-bottom: 1px solid #e6eefc !important;
    }

    .lc-logout-btn {
      border-radius: 6px;
      padding: 6px 16px;
      display: inline-flex;
      align-items: center;
    }

    @media (max-width: 991.98px) {
      .lc-navbar-actions {
        position: absolute;
        top: 100%;
        right: 0;
        left: 0;
        margin-top: 0;
        background-color: #ffffff;
        border: 1px solid #e6eefc;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.12);
        padding: 12px 16px;
        flex-direction: column;
        align-items: stretch !important;
        gap: 10px;
        z-index: 1000;
      }

      .lc-navbar-actions .nav-item {
        width: 100%;
        margin-left: 0 !important; 
      }

      .lc-navbar-actions .topbar-icon {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .lc-logout-item {
        border-top: 1px solid #e6eefc;
        padding-top: 10px;
      }

      .lc-logout-btn {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</div>