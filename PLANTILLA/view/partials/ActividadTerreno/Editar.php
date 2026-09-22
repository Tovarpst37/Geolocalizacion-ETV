<style>
  /* Overlay oscuro que cubre toda la pantalla */
  .modal-overlay-fix {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    background-color: rgba(15, 23, 42, 0.45) !important;
    backdrop-filter: blur(4px);
    z-index: 99999 !important;
  }

  /* Centrado absoluto en el centro de la pantalla */
  .modal-edit-custom {
    position: fixed !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    width: 90% !important;
    max-width: 480px !important;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    background-color: #ffffff;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    z-index: 100000 !important;
    margin: 0 !important;
  }

  /* Encabezado */
  .modal-edit-header {
    padding: 1.25rem 1.5rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #ffffff;
  }

  .modal-edit-title-group {
    display: flex;
    align-items: center;
    gap: 0.6rem;
  }

  .modal-edit-icon {
    width: 38px;
    height: 38px;
    background-color: #eff6ff;
    color: #2563eb;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
  }

  .modal-edit-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
  }

  .btn-close-custom {
    background: transparent;
    border: none;
    color: #94a3b8;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.25rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .btn-close-custom:hover {
    color: #0f172a;
    background-color: #f1f5f9;
  }

  /* Cuerpo del Formulario */
  .modal-edit-body {
    padding: 1.5rem;
  }

  .form-label-custom {
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.35rem;
  }

  .form-label-custom i {
    color: #2563eb;
  }

  .form-control-custom {
    border-radius: 10px !important;
    border: 1px solid #cbd5e1 !important;
    padding: 0.6rem 0.85rem !important;
    font-size: 0.9rem;
    color: #0f172a;
    background-color: #ffffff;
    transition: all 0.2s ease;
    box-shadow: none !important;
    width: 100%;
    box-sizing: border-box;
  }

  .form-control-custom:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
  }

  .form-control-custom[readonly] {
    background-color: #f8fafc !important;
    color: #64748b;
    border-color: #e2e8f0 !important;
    cursor: not-allowed;
  }

  /* Pie de la Modal */
  .modal-edit-footer {
    padding: 1rem 1.5rem 1.25rem;
    border-top: 1px solid #f1f5f9;
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    background-color: #ffffff;
  }

  .btn-modal-cancel {
    background-color: #ffffff;
    border: 1.5px solid #cbd5e1;
    color: #475569;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 0.55rem 1.25rem;
    border-radius: 10px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .btn-modal-cancel:hover {
    background-color: #f8fafc;
    color: #0f172a;
    border-color: #94a3b8;
  }

  .btn-modal-save {
    background-color: #2563eb;
    border: 1.5px solid #2563eb;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 0.55rem 1.25rem;
    border-radius: 10px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
  }

  .btn-modal-save:hover {
    background-color: #1d4ed8;
    border-color: #1d4ed8;
    color: #ffffff;
  }
</style>

<!-- Fondo oscuro independiente -->
<div class="modal-overlay-fix"></div>

<!-- Modal centrada directamente en pantalla -->
<div class="modal-edit-custom">
  <form action="<?php echo getUrl('ActividadTerreno', 'ActividadTerreno', 'validarUpdate'); ?>" method="POST" enctype="multipart/form-data" class="m-0">
    
    <!-- Encabezado -->
    <div class="modal-edit-header">
      <div class="modal-edit-title-group">
        <div class="modal-edit-icon">
          <i class="bx bx-edit-alt"></i>
        </div>
        <h5 class="modal-edit-title">Editar Actividad</h5>
      </div>
      <a href="<?php echo getUrl('ActividadTerreno', 'ActividadTerreno', 'getConsultar') ?>" class="btn-close-custom" aria-label="Cerrar">
        <i class="bx bx-x"></i>
      </a>
    </div>

    <!-- Cuerpo del Formulario -->
    <div class="modal-edit-body">
      <?php foreach ($datos as $d) { ?>

        <input type="hidden" name="id" value="<?php echo $d['id_actividad_terreno']; ?>">

        <div class="mb-3">
          <label class="form-label-custom">
            <i class="bx bx-hash"></i> Código de la actividad
          </label>
          <input type="text" class="form-control form-control-custom" name="cod_actividad_terreno" value="<?php echo htmlspecialchars($d['cod_actividad_terreno']); ?>" readonly>
        </div>

        <div class="mb-0">
          <label class="form-label-custom">
            <i class="bx bx-task"></i> Nombre de la actividad
          </label>
          <input type="text" class="form-control form-control-custom" name="nombre_actividad" value="<?php echo htmlspecialchars($d['nombre_actividad']); ?>" required>
        </div>

      <?php } ?>
    </div>

    <!-- Botones de Acción -->
    <div class="modal-edit-footer">
      <a href="<?php echo getUrl('ActividadTerreno', 'ActividadTerreno', 'getConsultar') ?>" class="btn-modal-cancel">
        Cancelar
      </a>
      <button type="submit" class="btn-modal-save">
        <i class="bx bx-save"></i> Guardar cambios
      </button>
    </div>

  </form>
</div>