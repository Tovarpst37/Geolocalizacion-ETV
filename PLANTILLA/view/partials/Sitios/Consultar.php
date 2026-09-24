<style>
.sites-page {
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
.sites-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 1.5rem;
}
.sites-title-group {
  display: flex;
  align-items: center;
  gap: .75rem;
}
.sites-title-group h3 {
  color: var(--ink);
  font-weight: 700;
  margin: 0;
  font-size: 1.4rem;
}
.sites-title-group i {
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
.sites-list-container {
  display: flex;
  flex-direction: column;
  gap: .85rem;
  width: 100%;
}

.sites-list-item {
  background: var(--bg-card);
  border: 1px solid var(--line);
  border-radius: 16px;
  padding: 1.1rem 1.25rem;
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
  .sites-list-item {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 1.25rem;
  }
}

.sites-list-item:hover {
  border-color: var(--blue-border);
  box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
}

/* Información del ítem */
.sites-info {
  display: flex;
  flex-direction: column;
  gap: .35rem;
  flex: 1;
  min-width: 0;
}

.sites-name {
  font-size: 1.05rem;
  font-weight: 700;
  color: var(--ink);
  margin: 0;
  display: flex;
  align-items: center;
  gap: .5rem;
  word-wrap: break-word;
}
.sites-name i {
  color: var(--blue-primary);
  font-size: 1.15rem;
  flex-shrink: 0;
}

.sites-details {
  font-size: .875rem;
  color: var(--muted);
  margin: 0;
  display: flex;
  align-items: flex-start;
  gap: .4rem;
  word-break: break-word;
  line-height: 1.4;
}
.sites-details i {
  color: var(--muted);
  font-size: 1.05rem;
  flex-shrink: 0;
  margin-top: 2px;
}

.sites-details-meta {
  font-size: .825rem;
  color: var(--muted);
  margin: 0;
  display: flex;
  flex-wrap: wrap;
  gap: .5rem 1rem;
}
.sites-details-meta b {
  color: var(--ink);
}

/* Lado derecho: Estado y Botones */
.sites-actions-wrap {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: .75rem;
  width: 100%;
  border-top: 1px dashed var(--line);
  padding-top: .85rem;
}

@media (min-width: 768px) {
  .sites-actions-wrap {
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

/* Grupo de Botones */
.btn-group-custom {
  display: flex;
  flex-direction: column;
  gap: .5rem;
  width: 100%;
}

@media (min-width: 500px) {
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

@media (min-width: 500px) {
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

/* Modales Flotantes */
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
</style>
<?php include_once '../view/partials/function.php'; ?>
<?php if (!empty($_SESSION['mensaje_exito'])): ?>
    <div id="alertaExito" class="alert d-flex align-items-center border-0 shadow-sm" role="alert" style="border-left: 5px solid #198754 !important; background-color: #fff;">
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

$bj = [];
$ob2 = new SitiosController();
$resul = $ob2->data();

if (count($resul) <= 0) {
    include_once '../view/partials/Sitios/notExist.php';
} else {
?>

<div class="sites-page container-fluid px-2 px-md-3">

    <!-- Cabecera y Buscador -->
    <div class="sites-header">
        <div class="sites-title-group">
            <i class="bx bx-map-pin"></i>
            <h3>Sitios</h3>
        </div>

        <div class="search-box-wrap">
            <form action="index.php" method="GET" class="m-0">
                <input type="hidden" name="modulo" value="Sitios">
                <input type="hidden" name="controlador" value="Sitios">
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

    <?php
    include_once '../controller/Sitios/SitiosController.php';
    include_once '../model/Sitios/Sitios.php';

    foreach ($resul as $j) {
        $sitios = new Sitios($j['id_sitio'], $j['nombre_sitio'], $j['direccion'], $j['barrio'], $j['estado']);
        $bj[] = $sitios;
    }
    ?>

    <!-- Lista de Filas de Sitios -->
    <div class="sites-list-container">
        <?php foreach ($bj as $index => $i):
            $j = $resul[$index];
            $isActivo = strtolower($i->getEstado()) === 'activo';
            $statusClass = $isActivo ? 'active' : 'inactive';
        ?>

            <div class="sites-list-item">
                
                <!-- Datos Principales -->
                <div class="sites-info">
                    <h6 class="sites-name">
                        <i class="bx bx-building-house"></i>
                        <span><?php echo $i->getNombre_sitio(); ?> — ID #<?php echo $i->getId(); ?></span>
                    </h6>
                    <p class="sites-details">
                        <i class="bx bx-map"></i>
                        <span><?php echo $i->getDireccion(); ?> &nbsp;|&nbsp; <b>Barrio:</b> <?php echo $i->getBarrio(); ?></span>
                    </p>
                    <div class="sites-details-meta">
                        <span><b>Coordinador:</b> <?php echo $j['coordinador'] ?? 'Sin asignar'; ?></span>
                        <span><b>Auxiliares:</b> <?php echo $j['auxiliares'] ?? 'Sin asignar'; ?></span>
                    </div>
                </div>

                <!-- Estado y Botones -->
                <div class="sites-actions-wrap">
                    <span class="status-pill <?php echo $statusClass; ?>">
                        <i class="bx bxs-circle fs-6"></i>
                        <?php echo $i->getEstado(); ?>
                    </span>

                    <div class="btn-group-custom">

                        <?php if (condicion('EDITAR', 'Sitios')): ?>
                            <a href="<?php echo getUrl('Sitios', 'Sitios', 'getEdit', array('id' => $i->getId())); ?>" class="btn btn-blue">
                                <i class="bx bx-edit-alt"></i> Editar
                            </a>
                        <?php endif; ?>

                        <?php if (condicion('ELIMINAR', 'Sitios')): ?>
                            <?php if ($isActivo): ?>
                                <button type="button" class="btn btn-red-soft" data-bs-toggle="modal" data-bs-target="#modalInhabilitar<?php echo $i->getId(); ?>">
                                    <i class="bx bx-block"></i> Inhabilitar
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-green-soft" data-bs-toggle="modal" data-bs-target="#modalHabilitar<?php echo $i->getId(); ?>">
                                    <i class="bx bx-check-circle"></i> Habilitar
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

        <?php endforeach; ?>
    </div>

    <!-- Modales independientes fuera del contenedor -->
    <?php foreach ($bj as $i): 
        $isActivo = strtolower($i->getEstado()) === 'activo';
    ?>
        <?php if ($isActivo): ?>
            <!-- Modal Inhabilitar -->
            <div class="modal fade" id="modalInhabilitar<?php echo $i->getId(); ?>" tabindex="-1" aria-hidden="true">
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
                            <h6 class="fw-bold text-dark mb-1">¿Inhabilitar sitio?</h6>
                            <p class="text-secondary small mb-0">
                                Esta acción cambiará el estado de <strong><?php echo $i->getNombre_sitio(); ?></strong> a inactivo.
                            </p>
                        </div>
                        <div class="modal-footer-custom">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                            <a href="<?php echo getUrl('Sitios', 'Sitios', 'posDelete', array('id' => $i->getId())); ?>" class="btn-modal-confirm-danger">
                                Inhabilitar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Modal Habilitar -->
            <div class="modal fade" id="modalHabilitar<?php echo $i->getId(); ?>" tabindex="-1" aria-hidden="true">
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
                            <h6 class="fw-bold text-dark mb-1">¿Habilitar sitio?</h6>
                            <p class="text-secondary small mb-0">
                                Esta acción cambiará el estado de <strong><?php echo $i->getNombre_sitio(); ?></strong> a activo.
                            </p>
                        </div>
                        <div class="modal-footer-custom">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                            <a href="<?php echo getUrl('Sitios', 'Sitios', 'posHabilitar', array('id' => $i->getId())); ?>" class="btn-modal-confirm-success">
                                Habilitar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</div>

<?php } ?>