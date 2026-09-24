<style>
.zoo-page {
  --blue-primary: #2563eb;
  --blue-hover: #1d4ed8;
  --blue-soft: #eff6ff;
  --blue-border: #bfdbfe;
  --ink: #1e293b;
  --muted: #64748b;
  --line: #e2e8f0;
  --bg-card: #ffffff;
  --success: #16a34a;
  --success-bg: #f0fdf4;
  --danger: #dc2626;
  --danger-bg: #fef2f2;
}

/* Header principal */
.zoo-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 1.5rem;
}
.zoo-title-group {
  display: flex;
  align-items: center;
  gap: .75rem;
}
.zoo-title-group h3 {
  color: var(--ink);
  font-weight: 700;
  margin: 0;
  font-size: 1.4rem;
}
.zoo-title-group i {
  color: var(--blue-primary);
  font-size: 1.75rem;
}

/* Buscador */
.search-box-wrap {
  width: 100%;
}
@media (min-width: 576px) {
  .search-box-wrap {
    width: auto;
    min-width: 280px;
  }
}

.search-box {
  position: relative;
  display: flex;
  align-items: center;
  width: 100%;
}
.search-box .form-control {
  padding-left: 2.5rem;
  padding-right: 2.75rem;
  border-radius: 10px;
  border: 1px solid var(--line);
  background-color: #ffffff;
  height: 2.6rem;
  font-size: .9rem;
  transition: all .15s ease;
  width: 100%;
}
.search-box .form-control:focus {
  border-color: var(--blue-primary);
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}
.search-box .search-icon {
  position: absolute;
  left: .85rem;
  color: var(--muted);
  font-size: 1.1rem;
  pointer-events: none;
}
.search-box .btn-search {
  position: absolute;
  right: .25rem;
  border: 0;
  background: var(--blue-soft);
  color: var(--blue-primary);
  height: 2.1rem;
  width: 2.1rem;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background .15s ease;
}
.search-box .btn-search:hover {
  background: var(--blue-border);
}

/* Lista Ultra-Responsiva */
.zoo-list-container {
  display: flex;
  flex-direction: column;
  gap: .85rem;
  width: 100%;
}

.zoo-list-item {
  background: var(--bg-card);
  border: 1px solid var(--line);
  border-radius: 16px;
  padding: 1.1rem;
  display: flex;
  flex-direction: column;
  gap: 0.85rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
  transition: all .2s ease;
  width: 100%;
  min-width: 0;
  overflow: hidden;
}

@media (min-width: 768px) {
  .zoo-list-item {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    gap: 1.25rem;
  }
}

.zoo-list-item:hover {
  border-color: var(--blue-border);
  box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
}

/* Información del ítem */
.zoo-info {
  display: flex;
  flex-direction: column;
  gap: .35rem;
  flex: 1;
  min-width: 0;
}

.zoo-code {
  font-size: 1.05rem;
  font-weight: 700;
  color: var(--ink);
  margin: 0;
  display: flex;
  align-items: center;
  gap: .5rem;
  word-wrap: break-word;
}
.zoo-code i {
  color: var(--blue-primary);
  font-size: 1.15rem;
  flex-shrink: 0;
}

.zoo-address {
  font-size: .875rem;
  color: var(--muted);
  margin: 0;
  display: flex;
  align-items: flex-start;
  gap: .4rem;
  word-break: break-word;
  line-height: 1.4;
}
.zoo-address i {
  color: var(--muted);
  font-size: 1.05rem;
  flex-shrink: 0;
  margin-top: 2px;
}

/* Lado derecho: Estado y Botones */
.zoo-actions-wrap {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: .75rem;
  width: 100%;
  border-top: 1px dashed var(--line);
  padding-top: .85rem;
}

@media (min-width: 768px) {
  .zoo-actions-wrap {
    width: auto;
    border-top: none;
    padding-top: 0;
    flex-direction: row;
    align-items: center;
    justify-content: flex-end;
  }
}

/* Badges de estado */
.status-pill {
  padding: .35rem .85rem;
  border-radius: 20px;
  font-size: .8rem;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .4rem;
  white-space: nowrap;
}

.status-pill.active {
  background-color: var(--success-bg);
  color: var(--success);
  border: 1px solid rgba(22, 163, 74, 0.2);
}
.status-pill.inactive {
  background-color: var(--danger-bg);
  color: var(--danger);
  border: 1px solid rgba(220, 38, 38, 0.2);
}

/* Grupo de Botones adaptable */
.btn-group-custom {
  display: flex;
  flex-direction: column;
  gap: .5rem;
  width: 100%;
}

@media (min-width: 400px) {
  .btn-group-custom {
    flex-direction: row;
  }
}

@media (min-width: 768px) {
  .btn-group-custom {
    width: auto;
  }
}

.btn-group-custom .btn {
  font-size: .85rem;
  font-weight: 600;
  padding: .45rem .9rem;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .35rem;
  transition: all .15s ease;
  width: 100%;
  white-space: nowrap;
  box-sizing: border-box;
}

@media (min-width: 400px) {
  .btn-group-custom .btn {
    flex: 1;
  }
}

@media (min-width: 768px) {
  .btn-group-custom .btn {
    flex: initial;
    width: auto;
  }
}

.btn-blue {
  background-color: var(--blue-primary);
  color: #ffffff;
  border: none;
}
.btn-blue:hover {
  background-color: var(--blue-hover);
  color: #ffffff;
}
.btn-red-soft {
  background-color: var(--danger-bg);
  color: var(--danger);
  border: 1px solid rgba(220, 38, 38, 0.2);
}
.btn-red-soft:hover {
  background-color: var(--danger);
  color: #ffffff;
}

.btn-green-soft {
  background-color: var(--success-bg);
  color: var(--success);
  border: 1px solid rgba(22, 163, 74, 0.2);
}
.btn-green-soft:hover {
  background-color: var(--success);
  color: #ffffff;
}

/* Modales Flotantes Unificados */
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


/* ============ Modal "Ver más" — Información del Zoocriadero ============ */
.info-modal-content {
  border: 0;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.08);
}
.info-modal-header {
  background: linear-gradient(135deg, var(--blue-primary), var(--blue-hover));
  padding: 1.5rem 1.5rem 1.35rem;
  display: flex;
  align-items: center;
  gap: 1rem;
}
.info-modal-avatar {
  width: 52px;
  height: 52px;
  background: rgba(255, 255, 255, 0.18);
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  font-size: 1.6rem;
  flex-shrink: 0;
}
.info-modal-title-group {
  flex: 1;
  min-width: 0;
}
.info-modal-title {
  color: #ffffff;
  font-weight: 700;
  font-size: 1.1rem;
  margin: 0;
  line-height: 1.3;
}
.info-modal-subtitle {
  color: rgba(255, 255, 255, 0.85);
  font-size: .85rem;
  font-weight: 500;
  display: block;
}
.status-pill-modal {
  padding: .35rem .8rem;
  border-radius: 20px;
  font-size: .75rem;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: .35rem;
  white-space: nowrap;
  background: rgba(255, 255, 255, 0.22);
  color: #ffffff;
  flex-shrink: 0;
}
.status-pill-modal.inactive {
  background: rgba(0, 0, 0, 0.22);
}
.info-modal-header .btn-close {
  filter: invert(1) brightness(2);
  opacity: .85;
  flex-shrink: 0;
}
.info-modal-header .btn-close:hover {
  opacity: 1;
}

.info-modal-body {
  padding: 1.5rem 1.75rem;
  max-height: 65vh;
  overflow-y: auto;
}

.info-section {
  padding-bottom: 1.25rem;
  margin-bottom: 1.25rem;
  border-bottom: 1px dashed var(--line);
}
.info-section:last-child {
  border-bottom: 0;
  margin-bottom: 0;
  padding-bottom: 0;
}
.info-section-title {
  display: flex;
  align-items: center;
  gap: .5rem;
  font-size: .78rem;
  font-weight: 700;
  color: var(--blue-primary);
  text-transform: uppercase;
  letter-spacing: .04em;
  margin-bottom: 1.1rem;
}
.info-section-title i {
  font-size: 1rem;
}

.info-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.1rem 1.5rem;
}
@media (min-width: 576px) {
  .info-grid {
    grid-template-columns: 1fr 1fr;
  }
}
.info-field.full {
  grid-column: 1 / -1;
}
.info-label {
  font-size: .72rem;
  font-weight: 600;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: .03em;
  display: block;
  margin-bottom: .3rem;
}
.info-value {
  font-size: .95rem;
  font-weight: 600;
  color: var(--ink);
  display: block;
  word-break: break-word;
}

.info-map-link {
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  color: var(--blue-primary);
  font-size: .85rem;
  font-weight: 600;
  text-decoration: none;
  margin-top: .65rem;
}
.info-map-link:hover {
  text-decoration: underline;
  color: var(--blue-hover);
}

.info-modal-footer {
  padding: 1rem 1.75rem 1.5rem;
  border-top: 1px solid #f1f5f9;
  display: flex;
  justify-content: flex-end;
}

</style>

<?php include_once '../view/partials/function.php'; ?>

<div class="zoo-page container-fluid px-2 px-md-3">

  <?php if (!empty($_SESSION['mensaje_exito'])): ?>
    <div id="alertaExito" class="alert d-flex align-items-center border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid var(--success) !important; background-color: #ffffff; border-radius: 10px;">
      <i class="bx bx-check-circle fs-4 me-2" style="color: var(--success);"></i>
      <div class="fw-medium text-dark">
        <?php echo $_SESSION['mensaje_exito']; ?>
      </div>
    </div>
    <?php unset($_SESSION['mensaje_exito']); ?>

    <script>
      setTimeout(function() {
        var alerta = document.getElementById('alertaExito');
        if (alerta) {
          alerta.style.transition = "opacity 0.4s ease";
          alerta.style.opacity = "0";
          setTimeout(function() {
            alerta.remove();
          }, 400);
        }
      }, 5000);
    </script>
  <?php endif; ?>

  <!-- Cabecera y Buscador -->
  <div class="zoo-header">
    <div class="zoo-title-group">
      <i class="bx bxs-leaf"></i>
      <h3>Zoocriaderos</h3>
    </div>

    <div class="search-box-wrap">
      <form action="index.php" method="GET" class="m-0">
        <input type="hidden" name="modulo" value="Zoocriadero">
        <input type="hidden" name="controlador" value="Zoocriadero">
        <input type="hidden" name="funcion" value="getBuscar">

        <div class="search-box">
          <i class="bx bx-search search-icon"></i>
          <input type="text" name="busqueda" placeholder="Buscar por codigo..." class="form-control" />
          <button type="submit" class="btn-search" aria-label="Buscar">
            <i class="bx bx-right-arrow-alt fs-5"></i>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Lista de Filas -->
  <div class="zoo-list-container">
    <?php foreach($zoocriaderos as $z){ 
      $isActivo = ($z['id_estado'] == 1);
    ?>
      <div class="zoo-list-item">
        
        <!-- Datos Principales -->
        <div class="zoo-info">
          <h6 class="zoo-code">
            <i class="bx bx-building"></i>
            <span><?php echo $z['cod_zoocriadero']; ?></span>
          </h6>
          <p class="zoo-address">
            <i class="bx bx-map"></i>
            <span><?php echo $z['direcciom']; ?></span>
          </p>
        </div>
        <!-- Estado y Botones -->
        <div class="zoo-actions-wrap">
          <span class="status-pill <?php echo $isActivo ? 'active' : 'inactive'; ?>">
            <i class="bx bxs-circle fs-6"></i>
            <?php echo $isActivo ? 'Activo' : 'Inactivo'; ?>
          </span>

          <div class="btn-group-custom">

            <?php if (condicion('EDITAR', 'Zoocriadero')): ?>
              <a href="<?php echo getUrl("Zoocriadero","Zoocriadero","getEditar",array('id'=>$z['id_zoocriadero']))?>" class="btn btn-blue">
                <i class="bx bx-edit-alt"></i> Editar
              </a>
            <?php endif; ?>

            
            <button type="button" class="btn btn-gray-soft" data-bs-toggle="modal" data-bs-target="#modalVerMas<?php echo $z['id_zoocriadero']; ?>">
              <i class="bx bx-show"></i> Ver más
            </button>

            <?php if (condicion('ELIMINAR', 'Zoocriadero')): ?>
              <?php if ($isActivo): ?>
                <button type="button" class="btn btn-red-soft" data-bs-toggle="modal" data-bs-target="#modalInhabilitar<?php echo $z['id_zoocriadero']; ?>">
                  <i class="bx bx-block"></i> Inhabilitar
                </button>
              <?php else: ?>
                <button type="button" class="btn btn-green-soft" data-bs-toggle="modal" data-bs-target="#modalHabilitar<?php echo $z['id_zoocriadero']; ?>">
                  <i class="bx bx-check-circle"></i> Habilitar
                </button>
              <?php endif; ?>
            <?php endif; ?>

          </div>
        </div>

      </div>
    <?php } ?>
  </div>

  <!-- Modal Ver Más -->
    <div class="modal fade" id="modalVerMas<?php echo $z['id_zoocriadero']; ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content info-modal-content">

          <div class="info-modal-header">
            <div class="info-modal-avatar">
              <i class="bx bxs-leaf"></i>
            </div>
            <div class="info-modal-title-group">
              <h5 class="info-modal-title">Información del Zoocriadero</h5>
              <span class="info-modal-subtitle"><?php echo $z['cod_zoocriadero']; ?></span>
            </div>
            <span class="status-pill-modal <?php echo $isActivo ? '' : 'inactive'; ?>">
              <i class="bx bxs-circle fs-6"></i>
              <?php echo $isActivo ? 'Activo' : 'Inactivo'; ?>
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body info-modal-body">

            <div class="info-section">
              <h6 class="info-section-title"><i class="bx bx-info-circle"></i> Información General</h6>
              <div class="info-grid">
                <div class="info-field">
                  <span class="info-label">Código</span>
                  <span class="info-value"><?php echo $z['cod_zoocriadero']; ?></span>
                </div>
                <div class="info-field">
                  <span class="info-label">Estado</span>
                  <span class="info-value"><?php echo $isActivo ? 'Activo' : 'Inactivo'; ?></span>
                </div>
                <div class="info-field full">
                  <span class="info-label">Dirección</span>
                  <span class="info-value"><?php echo $z['direcciom']; ?></span>
                  
                </div>
              </div>
            </div>

            <div class="info-section">
              <h6 class="info-section-title"><i class="bx bx-user"></i> Coordinador Responsable</h6>
              <div class="info-grid">
                <div class="info-field">
                  <span class="info-label">Persona a cargo</span>
                  <span class="info-value"><?php echo $z['nombre'] ?? 'No registrado'; ?></span>
                </div>
                <div class="info-field">
                  <span class="info-label">Documento</span>
                  <span class="info-value"><?php echo $z['documento'] ?? 'No registrado'; ?></span>
                </div>
              </div>
            </div>

          </div>

          <div class="modal-footer info-modal-footer">
            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cerrar</button>
          </div>

        </div>
      </div>
    </div>
    
  <!-- Modales fuera del contenedor -->
  <?php foreach($zoocriaderos as $z){ 
    $isActivo = ($z['id_estado'] == 1);
  ?>
    <?php if ($isActivo): ?>
      <!-- Modal Inhabilitar -->
      <div class="modal fade" id="modalInhabilitar<?php echo $z['id_zoocriadero']; ?>" tabindex="-1" aria-hidden="true">
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
              <h6 class="fw-bold text-dark mb-1">¿Inhabilitar zoocriadero?</h6>
              <p class="text-secondary small mb-0">
                Esta acción cambiará el estado de <strong><?php echo $z['cod_zoocriadero']; ?></strong> a inactivo.
              </p>
            </div>
            <div class="modal-footer-custom">
              <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
              <a href="<?php echo getUrl('Zoocriadero','Zoocriadero','postDelete', array('id'=>$z['id_zoocriadero'])); ?>" class="btn-modal-confirm-danger">
                Inhabilitar
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php else: ?>

        

      <!-- Modal Habilitar -->
      <div class="modal fade" id="modalHabilitar<?php echo $z['id_zoocriadero']; ?>" tabindex="-1" aria-hidden="true">
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
              <h6 class="fw-bold text-dark mb-1">¿Habilitar zoocriadero?</h6>
              <p class="text-secondary small mb-0">
                Esta acción cambiará el estado de <strong><?php echo $z['cod_zoocriadero']; ?></strong> a activo.
              </p>
            </div>
            <div class="modal-footer-custom">
              <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
              <a href="<?php echo getUrl('Zoocriadero','Zoocriadero','postHabilitar', array('id'=>$z['id_zoocriadero'])); ?>" class="btn-modal-confirm-success">
                Habilitar
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php } ?>

</div>