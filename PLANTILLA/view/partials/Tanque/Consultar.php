  <style>
  .tank-page {
    --accent: #3b5bdb;
    --accent-dark: #2f49b5;
    --accent-soft: #edf1ff;
    --ink: #1f2937;
    --muted: #6b7280;
    --line: #dfe4ec;
    --field: #f7f9fc;
    --success: #2b8a3e;
    --success-soft: #ebfbee;
    --danger: #e03131;
    --danger-soft: #fff5f5;
  }

  /* Header & Barra Superior */
  .tank-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }
  .tank-title {
    display: flex;
    align-items: center;
    gap: .75rem;
  }
  .tank-title h3 {
    font-weight: 700;
    color: var(--ink);
    margin: 0;
  }
  .tank-title i {
    font-size: 2rem;
    color: var(--accent);
  }

  .tank-actions-bar {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    width: auto;
  }
  .search-box {
    position: relative;
    min-width: 280px;
    width: 100%;
  }
  .search-box .form-control {
    padding-left: 2.5rem;
    padding-right: 2.5rem;
    border-radius: 12px;
    border: 1.5px solid var(--line);
    background-color: #fff;
    min-height: 2.75rem;
    font-size: .95rem;
    transition: border-color .15s ease, box-shadow .15s ease;
  }
  .search-box .form-control:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(59, 91, 219, 0.16);
  }
  .search-box .search-icon {
    position: absolute;
    left: .9rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: 1.15rem;
    pointer-events: none;
    z-index: 5;
  }
  .search-box .btn-search {
    position: absolute;
    right: .3rem;
    top: 50%;
    transform: translateY(-50%);
    border: 0;
    background: transparent;
    color: var(--muted);
    padding: .35rem .6rem;
    border-radius: 8px;
    transition: color .15s ease, background .15s ease;
    z-index: 5;
  }
  .search-box .btn-search:hover {
    color: var(--accent);
    background: var(--accent-soft);
  }

  /* Tarjeta de Tanque */
  .tank-card {
    border: 0;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 10px 30px rgba(31, 41, 55, 0.06), 0 1px 3px rgba(31, 41, 55, 0.04);
    transition: transform .2s ease, box-shadow .2s ease;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  .tank-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 35px rgba(31, 41, 55, 0.12);
  }

  /* Marco de la Imagen */
  .tank-img-wrapper {
    position: relative;
    background-color: var(--field);
    padding: 1.25rem;
    display: flex;
    justify-content: center;
    align-items: center;
    border-bottom: 1px solid var(--line);
  }
  .tank-img-wrapper img {
    height: 11rem;
    width: auto;
    max-width: 100%;
    object-fit: contain;
    transition: transform .2s ease;
  }
  .tank-card:hover .tank-img-wrapper img {
    transform: scale(1.04);
  }

  .tank-img-empty {
    height: 11rem;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #eef1f8;
    border-radius: 12px;
    color: #a3acba;
  }
  .tank-img-empty i {
    font-size: 3.5rem;
  }

  /* Badge Flotante de Estado */
  .status-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: .35rem .75rem;
    border-radius: 20px;
    font-size: .78rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    z-index: 2;
  }
  .status-badge.bg-success {
    background-color: var(--success-soft) !important;
    color: var(--success) !important;
    border: 1px solid rgba(43, 138, 62, 0.2);
  }
  .status-badge.bg-danger {
    background-color: var(--danger-soft) !important;
    color: var(--danger) !important;
    border: 1px solid rgba(224, 49, 49, 0.2);
  }

  /* Cuerpo de la Tarjeta */
  .tank-card-body {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .tank-info-list {
    list-style: none;
    padding: 0;
    margin: 0 0 1.25rem 0;
    text-align: left;
  }
  .tank-info-item {
    display: flex;
    align-items: flex-start;
    gap: .5rem;
    padding: .55rem 0;
    border-bottom: 1px dashed var(--line);
    font-size: .88rem;
    color: var(--ink);
    word-break: break-word;
  }
  .tank-info-item:last-child {
    border-bottom: 0;
  }
  .tank-info-item i {
    color: var(--accent);
    font-size: 1.15rem;
    flex-shrink: 0;
    margin-top: .1rem;
  }
  .tank-info-item b {
    color: var(--muted);
    font-weight: 600;
    min-width: 85px;
    flex-shrink: 0;
  }
  .tank-info-item span {
    flex: 1;
  }

  /* Botones de Acción */
  .tank-card-actions {
    display: flex;
    gap: .5rem;
  }
  .tank-card-actions .btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .35rem;
    border-radius: 10px;
    font-size: .85rem;
    font-weight: 600;
    padding: .55rem .75rem;
    transition: transform .12s ease, box-shadow .12s ease;
    white-space: nowrap;
  }
  .tank-card-actions .btn:hover {
    transform: translateY(-1px);
  }

  /* Modales Flotantes Estilizados */
  .modal-content-custom {
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    background-color: #ffffff;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    overflow: hidden;
  }
  .modal-header-custom {
    padding: 1.25rem 1.5rem 0.75rem;
    border-bottom: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .modal-title-custom {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
  }
  .modal-icon-badge-danger {
    width: 44px;
    height: 44px;
    background-color: #fef2f2;
    color: #ef4444;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
  }
  .modal-icon-badge-success {
    width: 44px;
    height: 44px;
    background-color: #f0fdf4;
    color: #16a34a;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
  }
  .modal-body-custom {
    padding: 0.5rem 1.5rem 1.25rem;
  }
  .modal-footer-custom {
    padding: 1rem 1.5rem 1.25rem;
    border-top: 1px solid #f1f5f9;
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
  }
  .btn-modal-cancel {
    background-color: #f8fafc;
    border: 1px solid #cbd5e1;
    color: #475569;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    transition: all 0.2s ease;
  }
  .btn-modal-cancel:hover {
    background-color: #f1f5f9;
    color: #1e293b;
  }
  .btn-modal-confirm-danger {
    background-color: #ef4444;
    border: 1px solid #ef4444;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .btn-modal-confirm-danger:hover {
    background-color: #dc2626;
    border-color: #dc2626;
    color: #ffffff;
  }
  .btn-modal-confirm-success {
    background-color: #16a34a;
    border: 1px solid #16a34a;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .btn-modal-confirm-success:hover {
    background-color: #15803d;
    border-color: #15803d;
    color: #ffffff;
  }

  /* Responsive para Móviles */
  @media (max-width: 575.98px) {
    .tank-header {
      flex-direction: column;
      align-items: stretch;
    }
    .tank-actions-bar {
      width: 100%;
    }
    .search-box {
      min-width: 100%;
    }
    
    .tank-card-body {
      padding: 1rem;
    }

    .tank-info-item {
      flex-direction: column;
      gap: .15rem;
    }
    .tank-info-item i {
      display: none;
    }
    .tank-info-item b {
      min-width: auto;
      font-size: .8rem;
      text-transform: uppercase;
      letter-spacing: .03em;
    }
    
    .tank-card-actions {
      flex-direction: column;
    }
    .tank-card-actions .btn {
      width: 100%;
    }
  }
  </style>

  <?php if (!empty($_SESSION['mensaje_exito'])): ?>
    <div id="alertaExito" class="alert d-flex align-items-center border-0 shadow-sm mb-4" role="alert" style="border-left: 5px solid #198754 !important; background-color: #fff; border-radius: 12px;">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" style="color:#198754;" role="img" aria-label="Success:">
        <use xlink:href="#check-circle-fill" />
      </svg>
      <div>
        <?php echo $_SESSION['mensaje_exito']; ?>
      </div>
    </div>
    <?php unset($_SESSION['mensaje_exito']); ?>
    <script>
      setTimeout(function() {
        var alerta = document.getElementById('alertaExito');
        if (alerta) {
          alerta.style.transition = "opacity 0.5s ease";
          alerta.style.opacity = "0";
          setTimeout(function() {
            alerta.remove();
          }, 500);
        }
      }, 5000);
    </script>
  <?php endif; 

    $array = [];

    $obj2 = new TanqueController();
    $result = $obj2->getDatos();
        
    if(count($result) <= 0){
        include_once '../view/partials/Tanque/notExist.php';
    }else{
  ?>

  <div class="tank-page container-fluid px-2">

    <!-- Encabezado y buscador -->
    <div class="tank-header">
      <div class="tank-title">
        <i class="bx bx-cylinder"></i>
        <h3 class="fw-bold mb-0">Tanques</h3>
      </div>

      <div class="tank-actions-bar">
        <form class="search-box" action="index.php" method="GET">
          <input type="hidden" name="modulo" value="Tanque">
          <input type="hidden" name="controlador" value="Tanque">
          <input type="hidden" name="funcion" value="getBuscar">

          <i class="bx bx-search search-icon"></i>
          <input type="text" name="busqueda" placeholder="Buscar tanque..." class="form-control" />
          <button type="submit" class="btn-search">
            <i class="bx bx-right-arrow-alt fs-5"></i>
          </button>
        </form>
      </div>
    </div>

    <!-- Contenedor de Tarjetas -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
      <?php
      include_once '../controller/Tanque/TanqueController.php';
      include_once '../model/Tanque/Tanque.php';

      foreach ($result as $rs) {
        $obj = new Tanque($rs['id_tanque'], $rs['codigo_tanque'], $rs['img'], $rs['nombre_tipo_tanque'], $rs['cod_zoocriadero'], $rs['direcciom'], $rs['nombre_estado']);
        $array[] = $obj;
      }

      foreach ($array as $ob) {
        $estadoActivo = strtolower($ob->getEstado()) === 'activo';
        $badgeClass = $estadoActivo ? 'bg-success' : 'bg-danger';

        // --- Validación de imagen: evita el ícono de "imagen rota" cuando no hay foto ---
        $tieneImagen = !empty($ob->getImg());
        $rutaImg = "/Geolocalizacion/Geolocalizacion-ETV/PLANTILLA/web/assets/img/" . $ob->getImg();
      ?>

        <div class="col">
          <div class="tank-card">
            <!-- Banner con Imagen y Badge de Estado -->
            <div class="tank-img-wrapper">
              <span class="status-badge <?php echo $badgeClass; ?>">
                <i class="bx bxs-circle fs-6"></i> Tanque <?php echo $ob->getEstado(); ?>
              </span>
              <?php if ($tieneImagen): ?>
  <img src="<?php echo $rutaImg; ?>" alt="Tanque"
       onerror="this.parentElement.innerHTML = '<span class=\'status-badge <?php echo $badgeClass; ?>\'><i class=\'bx bxs-circle fs-6\'></i> Tanque <?php echo $ob->getEstado(); ?></span><div class=\'tank-img-empty\'><i class=\'bx bx-image-alt\'></i></div>';">
<?php else: ?>
  <div class="tank-img-empty">
    <i class="bx bx-image-alt"></i>
  </div>
<?php endif; ?>
            </div>

            <!-- Cuerpo e Información -->
            <div class="tank-card-body">
              <ul class="tank-info-list">
                <li class="tank-info-item">
                  <i class="bx bx-hash"></i>
                  <b>Código:</b>
                  <span><?php echo $ob->getNombre(); ?></span>
                </li>
                <li class="tank-info-item">
                  <i class="bx bx-category"></i>
                  <b>Tipo:</b>
                  <span><?php echo $ob->getTipo(); ?></span>
                </li>
                <li class="tank-info-item">
                  <i class="bx bxs-leaf"></i>
                  <b>Zoocriadero:</b>
                  <span><?php echo $ob->getZoocriadero(); ?></span>
                </li>
                <li class="tank-info-item">
                  <i class="bx bx-map-pin"></i>
                  <b>Dirección:</b>
                  <span><?php echo $ob->getDireccion(); ?></span>
                </li>
              </ul>

              <!-- Acciones -->
              <div class="tank-card-actions">
              <?php if (in_array('EDITAR', $_SESSION['permisos']['Tanques'] ?? [])): ?>
                <a href="<?php echo getUrl('Tanque', 'Tanque', 'getEdit', array('id' => $ob->getId())); ?>" class="btn btn-outline-primary">
                  <i class="bx bx-edit-alt"></i> Editar
                </a>
                <?php if ($estadoActivo): ?>
                  <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModalInhabilitar<?php echo $ob->getId() ?>">
                    <i class="bx bx-block"></i> Inhabilitar
                  </button>
                <?php else: ?>
                  <?php if (in_array('ELIMINAR', $_SESSION['permisos']['Tanques'] ?? [])): ?>
                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModalHabilitar<?php echo $ob->getId() ?>">
                      <i class="bx bx-check-circle"></i> Habilitar
                    </button>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endif;?>
              </div>

            </div>
          </div>
        </div>

      <?php
      }
      ?>
    </div>

    <!-- Modales fuera del loop principal para prevenir el fallo de visualización del backdrop -->
    <?php foreach ($array as $ob) { 
      $id = $ob->getId();
    ?>
      <!-- Modal Inhabilitar -->
      <div class="modal fade" id="exampleModalInhabilitar<?php echo $id ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content modal-content-custom">
            <div class="modal-header-custom">
              <h5 class="modal-title-custom">Confirmar Acción</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-custom text-start">
              <div class="modal-icon-badge-danger">
                <i class="bx bx-block"></i>
              </div>
              <h6 class="fw-bold text-dark mb-1">¿Inhabilitar tanque?</h6>
              <p class="text-secondary small mb-0">
                Esta acción cambiará el estado de <strong><?php echo $ob->getNombre(); ?></strong> a inactivo.
              </p>
            </div>
            <div class="modal-footer-custom">
              <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
              <a href="<?php echo getUrl('Tanque', 'Tanque', 'postDelete', array('id' => $ob->getId())); ?>" class="btn-modal-confirm-danger">
                Inhabilitar
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Habilitar -->
      <div class="modal fade" id="exampleModalHabilitar<?php echo $id ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content modal-content-custom">
            <div class="modal-header-custom">
              <h5 class="modal-title-custom">Confirmar Acción</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-custom text-start">
              <div class="modal-icon-badge-success">
                <i class="bx bx-check-circle"></i>
              </div>
              <h6 class="fw-bold text-dark mb-1">¿Habilitar tanque?</h6>
              <p class="text-secondary small mb-0">
                Esta acción cambiará el estado de <strong><?php echo $ob->getNombre(); ?></strong> a activo.
              </p>
            </div>
            <div class="modal-footer-custom">
              <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
              <a href="<?php echo getUrl('Tanque', 'Tanque', 'postHabilitar', array('id' => $ob->getId())); ?>" class="btn-modal-confirm-success">
                Habilitar
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

  </div>

  <?php 
  }
  ?>