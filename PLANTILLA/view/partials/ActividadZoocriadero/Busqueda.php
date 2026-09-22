<style>
  /* Contenedor blanco principal */
  .main-module-container {
    background-color: #ffffff;
    border-radius: 24px;
    padding: 1.25rem 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid #e2e8f0;
    width: 100%;
  }

  @media (min-width: 768px) {
    .main-module-container {
      padding: 2rem;
    }
  }

  /* Encabezado del Módulo */
  .module-header-title {
    font-size: clamp(1.1rem, 2.5vw, 1.4rem);
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin: 0;
  }

  .module-header-title i {
    color: #2563eb;
    font-size: 1.4rem;
  }

  /* Buscador estilo píldora */
  .search-pill-container {
    position: relative;
    width: 100%;
  }

  @media (min-width: 576px) {
    .search-pill-container {
      max-width: 320px;
    }
  }

  .search-pill-input {
    border-radius: 50rem !important;
    padding: 0.55rem 2.5rem 0.55rem 2.5rem !important;
    border: 1px solid #cbd5e1 !important;
    font-size: 0.9rem;
    box-shadow: none !important;
    background-color: #ffffff;
    color: #1e293b;
    width: 100%;
  }

  .search-pill-input:focus {
    border-color: #2563eb !important;
  }

  .search-icon-left {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    font-size: 0.9rem;
    pointer-events: none;
    z-index: 5;
  }

  .search-btn-right {
    position: absolute;
    right: 0.4rem;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: transparent;
    color: #2563eb;
    padding: 0.25rem 0.5rem;
    border-radius: 50%;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Tarjeta estilo Tanques */
  .card-activity-item {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
    min-width: 0;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    overflow: hidden;
  }

  .card-activity-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.08);
  }

  /* Cabecera para la badge de estado */
  .card-header-status {
    background-color: #f8fafc;
    padding: 0.85rem 1rem;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    border-bottom: 1px solid #f1f5f9;
  }

  .badge-status-dot {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.35rem 0.85rem;
    border-radius: 50rem;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    white-space: nowrap;
  }

  .badge-status-dot::before {
    content: "";
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
  }

  .badge-status-active {
    background-color: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
  }
  .badge-status-active::before { background-color: #22c55e; }

  .badge-status-inactive {
    background-color: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
  }
  .badge-status-inactive::before { background-color: #ef4444; }

  /* Cuerpo de la tarjeta */
  .card-body-activity {
    padding: 1.1rem;
    flex-grow: 1;
    min-width: 0;
  }

  .activity-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.85rem;
    line-height: 1.3;
    word-wrap: break-word;
    overflow-wrap: break-word;
  }

  /* Filas de datos */
  .data-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    padding: 0.55rem 0;
    border-bottom: 1px dashed #e2e8f0;
    font-size: 0.875rem;
    gap: 0.25rem 0.5rem;
  }

  .data-row:last-child {
    border-bottom: none;
  }

  .data-label {
    color: #475569;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    white-space: nowrap;
  }

  .data-label i {
    color: #2563eb;
    font-size: 1.05rem;
  }

  .data-value {
    color: #1e293b;
    font-weight: 600;
    word-break: break-all;
    margin-left: auto;
  }

  /* Pie de tarjeta con botones */
  .card-footer-activity {
    padding: 0.85rem 1rem 1.1rem;
    background: #ffffff;
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }

  .btn-outline-custom-blue,
  .btn-outline-custom-red,
  .btn-outline-custom-green {
    flex: 1 1 100%;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    text-align: center;
    white-space: nowrap;
    box-sizing: border-box;
    background: transparent;
  }

  @media (min-width: 380px) {
    .btn-outline-custom-blue,
    .btn-outline-custom-red,
    .btn-outline-custom-green {
      flex: 1 1 calc(50% - 0.25rem);
    }
  }

  .btn-outline-custom-blue {
    border: 1.5px solid #2563eb;
    color: #2563eb;
  }
  .btn-outline-custom-blue:hover {
    background-color: #2563eb;
    color: #ffffff;
  }

  .btn-outline-custom-red {
    border: 1.5px solid #ef4444;
    color: #ef4444;
  }
  .btn-outline-custom-red:hover {
    background-color: #ef4444;
    color: #ffffff;
  }

  .btn-outline-custom-green {
    border: 1.5px solid #16a34a;
    color: #16a34a;
  }
  .btn-outline-custom-green:hover {
    background-color: #16a34a;
    color: #ffffff;
  }

  /* Estilos para Modales */
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

  /* Estado Vacío */
  .empty-state-icon {
    width: 54px;
    height: 54px;
    background-color: #eff6ff;
    color: #2563eb;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    margin-bottom: 0.75rem;
  }
</style>

<div class="container-fluid px-2 px-md-3 py-2">
  
  <!-- Encabezado superior -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
    <h2 class="module-header-title">
      <i class="bx bx-task"></i> Actividades
    </h2>

    <div class="search-pill-container">
      <form action="index.php" method="GET" class="m-0">
        <input type="hidden" name="modulo" value="ActividadZoocriadero">
        <input type="hidden" name="controlador" value="ActividadZoocriadero">
        <input type="hidden" name="funcion" value="getBuscar">

        <i class="fa fa-search search-icon-left"></i>
        <input type="text" name="busqueda" value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>" placeholder="Buscar..." class="form-control search-pill-input" />
        
        <button type="submit" class="search-btn-right" aria-label="Buscar">
          <i class="fa fa-arrow-right"></i>
        </button>
      </form>
    </div>
  </div>

  <!-- Contenedor blanco principal -->
  <div class="main-module-container">

    <?php
    include_once '../controller/ActividadZoocriadero/ActividadZoocriaderoController.php';
    include_once '../model/ActividadZoocriadero/ActividadZoocriadero.php';

    if (!empty($actividad2)):
      $array = [];

      foreach ($actividad2 as $rs) {
        $obj = new ActividadZoocriadero($rs['id_actividad_zoo'], $rs['cod_actividad'], $rs['nombre_actividad'], $rs['nombre_estado']);
        $array[] = $obj;
      }
    ?>

      <!-- Grid de Tarjetas -->
      <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3 g-md-4">
        <?php
        foreach ($array as $o) {
          $estadoA = strtolower($o->getEstado()) === 'activo';
          $badgeClass = $estadoA ? 'badge-status-active' : 'badge-status-inactive';
          $estadoTexto = $estadoA ? 'Activo' : 'Inactivo';
        ?>

          <div class="col">
            <div class="card-activity-item">
              
              <div class="card-header-status">
                <span class="badge-status-dot <?php echo $badgeClass; ?>">
                  Actividad <?php echo $estadoTexto; ?>
                </span>
              </div>

              <div class="card-body-activity">
                <h5 class="activity-title">
                  <?php echo $o->getNombre(); ?>
                </h5>

                <div class="data-row">
                  <span class="data-label"><i class="bx bx-hash"></i> Código:</span>
                  <span class="data-value"><?php echo $o->getCodigo(); ?></span>
                </div>

                <div class="data-row">
                  <span class="data-label"><i class="bx bx-id-card"></i> ID Actividad:</span>
                  <span class="data-value">#<?php echo $o->getId(); ?></span>
                </div>
              </div>

              <div class="card-footer-activity">
                <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getEditar', array('id' => $o->getId())); ?>" class="btn-outline-custom-blue">
                  <i class="bx bx-edit-alt"></i> Editar
                </a>

                <?php if ($estadoA): ?>
                  <button type="button" class="btn-outline-custom-red" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $o->getId(); ?>">
                    <i class="bx bx-block"></i> Inhabilitar
                  </button>
                <?php else: ?>
                  <button type="button" class="btn-outline-custom-green" data-bs-toggle="modal" data-bs-target="#exampleModalHabilitar<?php echo $o->getId(); ?>">
                    <i class="bx bx-check-circle"></i> Habilitar
                  </button>
                <?php endif; ?>
              </div>

            </div>
          </div>

        <?php } ?>
      </div>

      <!-- Modales fuera del grid para prevenir desbordamientos por CSS transform -->
      <?php foreach ($array as $o) { 
        $estadoA = strtolower($o->getEstado()) === 'activo';
        $id = $o->getId();
      ?>
        <?php if ($estadoA): ?>
          <!-- Modal Inhabilitar -->
          <div class="modal fade" id="exampleModal<?php echo $id ?>" tabindex="-1" aria-hidden="true">
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
                  <h6 class="fw-bold text-dark mb-1">¿Inhabilitar actividad?</h6>
                  <p class="text-secondary small mb-0">
                    Esta acción cambiará el estado de <strong><?php echo $o->getNombre(); ?></strong> a inactivo.
                  </p>
                </div>
                <div class="modal-footer-custom">
                  <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                  <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'postDelete', array('id' => $o->getId())); ?>" class="btn-modal-confirm-danger">
                    Inhabilitar
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php else: ?>
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
                  <h6 class="fw-bold text-dark mb-1">¿Habilitar actividad?</h6>
                  <p class="text-secondary small mb-0">
                    Esta acción cambiará el estado de <strong><?php echo $o->getNombre(); ?></strong> a activo nuevamente.
                  </p>
                </div>
                <div class="modal-footer-custom">
                  <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                  <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'postHabilitar', array('id' => $o->getId())); ?>" class="btn-modal-confirm-success">
                    Habilitar
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php } ?>

    <?php else: ?>
      <!-- Estado sin resultados -->
      <div class="d-flex flex-column align-items-center justify-content-center py-5 text-center">
        <div class="empty-state-icon">
          <i class="fa fa-search"></i>
        </div>
        <h5 class="fw-bold text-dark mb-1">Sin resultados</h5>
        <p class="text-secondary small mb-0">
          <?php 
            $term = isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '';
            echo $term !== '' ? 'No se encontraron actividades que coincidan con "' . $term . '".' : 'No hay actividades registradas por el momento.';
          ?>
        </p>
      </div>
    <?php endif; ?>

  </div>
</div>