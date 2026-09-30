<style>
  /* Contenedor Principal */
  .consult-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem 0.5rem;
    box-sizing: border-box;
  }

  /* Alerta de éxito con borde lateral verde */
  .alert-original-custom {
    background-color: #ffffff;
    border: none;
    border-left: 5px solid #059669;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    color: #1e293b;
    font-size: 0.95rem;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  /* Encabezado */
  .header-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  @media (min-width: 640px) {
    .header-section {
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
    }
  }

  .header-title-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .header-icon {
    color: #2563eb;
    font-size: 1.8rem;
    display: flex;
    align-items: center;
  }

  .header-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
  }

  /* Buscador tipo cápsula */
  .search-form {
    margin: 0;
    width: 100%;
  }

  @media (min-width: 640px) {
    .search-form {
      width: auto;
    }
  }

  .search-box-wrapper {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 50px;
    padding: 0.35rem 0.5rem 0.35rem 1rem;
    display: flex;
    align-items: center;
    width: 100%;
    box-sizing: border-box;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    transition: all 0.2s ease;
  }

  @media (min-width: 640px) {
    .search-box-wrapper {
      width: 320px;
    }
  }

  .search-box-wrapper:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
  }

  .search-box-wrapper i.search-icon {
    color: #94a3b8;
    font-size: 1.15rem;
    margin-right: 0.5rem;
  }

  .search-input {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    background: transparent;
    font-size: 0.88rem;
    color: #1e293b;
    width: 100%;
    min-width: 0;
  }

  .search-btn {
    background-color: #eff6ff;
    border: none;
    color: #2563eb;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }

  .search-btn:hover {
    background-color: #2563eb;
    color: #ffffff;
  }

  /* Grid de Tarjetas */
  .cards-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1.25rem;
  }

  @media (min-width: 640px) {
    .cards-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 1024px) {
    .cards-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  /* Tarjeta */
  .act-card {
    background-color: #ffffff;
    border-radius: 20px;
    border: 1px solid #f1f5f9;
    padding: 1.25rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .act-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
  }

  /* Insignia de Estado */
  .badge-status-container {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 0.75rem;
  }

  .badge-active-custom {
    background-color: #f0fdf4;
    color: #16a34a;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.35rem 0.85rem;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
  }

  .badge-active-custom::before {
    content: "";
    width: 7px;
    height: 7px;
    background-color: #16a34a;
    border-radius: 50%;
  }

  .badge-inactive-custom {
    background-color: #fef2f2;
    color: #dc2626;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.35rem 0.85rem;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
  }

  .badge-inactive-custom::before {
    content: "";
    width: 7px;
    height: 7px;
    background-color: #dc2626;
    border-radius: 50%;
  }

  /* Título e Info */
  .act-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 1.25rem;
  }

  .act-info-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.88rem;
    padding: 0.4rem 0;
  }

  .act-info-label {
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 0.4rem;
  }

  .act-info-label i {
    color: #2563eb;
  }

  .act-info-value {
    color: #0f172a;
    font-weight: 700;
  }

  .act-divider {
    border-top: 1px dashed #e2e8f0;
    margin: 0.5rem 0 1.25rem 0;
  }

  /* Botones de Tarjeta */
  .act-actions-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.6rem;
  }

  .btn-outline-edit {
    background-color: #ffffff;
    border: 1px solid #bfdbfe;
    color: #2563eb;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-outline-edit:hover {
    background-color: #eff6ff;
    color: #1d4ed8;
  }

  .btn-outline-disable {
    background-color: #ffffff;
    border: 1px solid #fca5a5;
    color: #ef4444;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .btn-outline-disable:hover {
    background-color: #fef2f2;
    color: #dc2626;
  }

  .btn-outline-enable {
    background-color: #ffffff;
    border: 1px solid #86efac;
    color: #16a34a;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .btn-outline-enable:hover {
    background-color: #f0fdf4;
    color: #15803d;
  }

  /* ESTILOS DE LA MODAL SEGÚN TU IMAGEN DE REFERENCIA */
  .exact-ref-modal {
    border-radius: 28px !important;
    border: none !important;
    padding: 1.5rem !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
  }

  .modal-header-ref {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 1rem;
    border: none;
  }

  .modal-title-ref {
    font-weight: 700;
    font-size: 1.15rem;
    color: #0f172a;
    margin: 0;
  }

  .btn-close-ref {
    background: none;
    border: none;
    font-size: 1.25rem;
    color: #64748b;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s ease;
  }

  .btn-close-ref:hover {
    color: #0f172a;
  }

  .modal-icon-ref-red {
    width: 46px;
    height: 46px;
    background-color: #fef2f2;
    color: #f87171;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    margin-bottom: 1.25rem;
  }

  .modal-icon-ref-green {
    width: 46px;
    height: 46px;
    background-color: #f0fdf4;
    color: #16a34a;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    margin-bottom: 1.25rem;
  }

  .modal-question-ref {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.5rem;
  }

  .modal-text-ref {
    color: #6366f1;
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: 1.75rem;
  }

  .modal-footer-ref {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 0.75rem;
    border: none;
    padding: 0;
  }

  .btn-ref-cancel {
    background-color: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    font-weight: 600;
    padding: 0.55rem 1.35rem;
    border-radius: 14px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .btn-ref-cancel:hover {
    background-color: #f8fafc;
    color: #1e293b;
  }

  .btn-ref-confirm-red {
    background-color: #f87171;
    border: none;
    color: #ffffff;
    font-weight: 600;
    padding: 0.55rem 1.35rem;
    border-radius: 14px;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-ref-confirm-red:hover {
    background-color: #ef4444;
    color: #ffffff;
  }

  .btn-ref-confirm-green {
    background-color: #16a34a;
    border: none;
    color: #ffffff;
    font-weight: 600;
    padding: 0.55rem 1.35rem;
    border-radius: 14px;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-ref-confirm-green:hover {
    background-color: #15803d;
    color: #ffffff;
  }
</style>
<?php include_once '../view/partials/function.php'; ?>

<div class="consult-container">

  <!-- Mensaje de éxito -->
  <?php if (!empty($_SESSION['mensaje_exito'])): ?>
    <div id="alertaExito" class="alert-original-custom" role="alert">
      <span><?php echo $_SESSION['mensaje_exito']; ?></span>
      <button type="button" class="btn-close ms-3" onclick="document.getElementById('alertaExito').remove();" aria-label="Cerrar"></button>
    </div>
    <?php unset($_SESSION['mensaje_exito']); ?>

    <script>
      setTimeout(function() {
        var alerta = document.getElementById('alertaExito');
        if (alerta) {
          alerta.style.transition = "opacity 0.4s ease, transform 0.4s ease";
          alerta.style.opacity = "0";
          alerta.style.transform = "translateY(-10px)";
          setTimeout(function() { alerta.remove(); }, 400);
        }
      }, 4000);
    </script>
  <?php endif; ?>

  <?php
  include_once '../controller/ActividadTerreno/ActividadTerrenoController.php';
  include_once '../model/ActividadTerreno/ActividadTerreno.php';

  $obj2 = new ActividadTerrenoController();
  $result = $obj2->getDatos();

  if (count($result) <= 0):
      include_once '../view/partials/ActividadTerreno/notExist.php';
  else:
      $array = [];
      foreach ($result as $rs) {
        $obj = new ActividadTerreno($rs['id_actividad_terreno'], $rs['cod_actividad_terreno'], $rs['nombre_actividad'], $rs['nombre_estado']);
        $array[] = $obj;
      }
  ?>

    <!-- Encabezado -->
    <div class="header-section">
      <div class="header-title-group">
        <div class="header-icon">
          <i class="bx bx-checkbox-checked"></i>
        </div>
        <h3 class="header-title">Actividades de Terreno</h3>
      </div>

      <form action="index.php" method="GET" class="search-form">
        <input type="hidden" name="modulo" value="ActividadTerreno">
        <input type="hidden" name="controlador" value="ActividadTerreno">
        <input type="hidden" name="funcion" value="getBuscar">

        <div class="search-box-wrapper">
          <i class="bx bx-search search-icon"></i>
          <input type="text" name="busqueda" placeholder="Buscar por nombre de actividad..." class="search-input" value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>">
          <button type="submit" class="search-btn" title="Buscar">
            <i class="bx bx-right-arrow-alt fs-5"></i>
          </button>
        </div>
      </form>
    </div>

    <!-- Grid de Tarjetas -->
    <div class="cards-grid">
      <?php foreach ($array as $o) {
        $estadoA = strtolower($o->getEstado()) === 'activo'; 
        $id = $o->getId();
      ?>
        <div class="act-card">
          <div>
            <div class="badge-status-container">
              <?php if ($estadoA): ?>
                <span class="badge-active-custom">Actividad Activo</span>
              <?php else: ?>
                <span class="badge-inactive-custom">Actividad Inactivo</span>
              <?php endif; ?>
            </div>

            <div class="act-title">
              <?= htmlspecialchars($o->getNombre()); ?>
            </div>

            <div class="act-info-row">
              <span class="act-info-label">
                <i class="bx bx-hash"></i> Código:
              </span>
              <span class="act-info-value"><?= htmlspecialchars($o->getCodigo()); ?></span>
            </div>

            <div class="act-divider"></div>

            <div class="act-info-row">
              <span class="act-info-label">
                <i class="bx bx-id-card"></i> ID Actividad:
              </span>
              <span class="act-info-value">#<?= $o->getId(); ?></span>
            </div>
          </div>

          <!-- Botones de Acción -->
          <div class="act-actions-group mt-3">

            <?php if (condicion('EDITAR', 'Actividades Terreno')): ?>
              <a href="<?= getUrl('ActividadTerreno', 'ActividadTerreno', 'getEditar', array('id' => $o->getId())); ?>" class="btn-outline-edit">
                <i class="bx bx-edit-alt"></i> Editar
              </a>
            <?php endif; ?>

            <?php if (condicion('ELIMINAR', 'Actividades Terreno')): ?>
              <?php if ($estadoA): ?>
                <button type="button" class="btn-outline-disable" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $o->getId() ?>">
                  <i class="bx bx-block"></i> Inhabilitar
                </button>
              <?php else: ?>
                <button type="button" class="btn-outline-enable" data-bs-toggle="modal" data-bs-target="#exampleModalHabilitar<?= $o->getId() ?>">
                  <i class="bx bx-check-circle"></i> Habilitar
                </button>
              <?php endif; ?>
            <?php endif; ?>

          </div>
        </div>
      <?php } ?>
    </div>

    <!-- MODALES EXACTAS A LA IMAGEN DE REFERENCIA -->
    <?php foreach ($array as $o) {
      $id = $o->getId();
    ?>
      <!-- Modal Inhabilitar -->
      <div class="modal fade" id="exampleModal<?= $id ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content exact-ref-modal">
            
            <div class="modal-header-ref">
              <h5 class="modal-title-ref">Confirmar Acción</h5>
              <button type="button" class="btn-close-ref" data-bs-dismiss="modal" aria-label="Close">
                <i class="bx bx-x fs-3"></i>
              </button>
            </div>

            <div class="modal-body p-0">
              <div class="modal-icon-ref-red">
                <i class="bx bx-block"></i>
              </div>

              <div class="modal-question-ref">¿Inhabilitar actividad?</div>
              <div class="modal-text-ref">
                Esta acción cambiará el estado de <strong><?= htmlspecialchars($o->getNombre()) ?></strong> a inactivo.
              </div>
            </div>

            <div class="modal-footer-ref">
              <button type="button" class="btn btn-ref-cancel" data-bs-dismiss="modal">Cancelar</button>
              <a href="<?= getUrl('ActividadTerreno', 'ActividadTerreno', 'postDelete', array('id' => $o->getId())); ?>" class="btn btn-ref-confirm-red">
                Inhabilitar
              </a>
            </div>

          </div>
        </div>
      </div>

      <!-- Modal Habilitar -->
      <div class="modal fade" id="exampleModalHabilitar<?= $id ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content exact-ref-modal">
            
            <div class="modal-header-ref">
              <h5 class="modal-title-ref">Confirmar Acción</h5>
              <button type="button" class="btn-close-ref" data-bs-dismiss="modal" aria-label="Close">
                <i class="bx bx-x fs-3"></i>
              </button>
            </div>

            <div class="modal-body p-0">
              <div class="modal-icon-ref-green">
                <i class="bx bx-check-circle"></i>
              </div>

              <div class="modal-question-ref">¿Habilitar actividad?</div>
              <div class="modal-text-ref">
                Esta acción cambiará el estado de <strong><?= htmlspecialchars($o->getNombre()) ?></strong> a activo.
              </div>
            </div>

            <div class="modal-footer-ref">
              <button type="button" class="btn btn-ref-cancel" data-bs-dismiss="modal">Cancelar</button>
              <a href="<?= getUrl('ActividadTerreno', 'ActividadTerreno', 'postHabilitar', array('id' => $o->getId())); ?>" class="btn btn-ref-confirm-green">
                Habilitar
              </a>
            </div>

          </div>
        </div>
      </div>
    <?php } ?>

  <?php endif; ?>
</div>