<style>
.modal-backdrop-custom {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(15, 23, 42, 0.4);
  backdrop-filter: blur(4px);
  z-index: 1050;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}

.modal-content-custom {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
  width: 100%;
  max-width: 500px;
  overflow: hidden;
  animation: modalFadeIn 0.2s ease-out;
}

@keyframes modalFadeIn {
  from {
    opacity: 0;
    transform: scale(0.96) translateY(-10px);
  }
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

.modal-header-custom {
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.modal-title-custom {
  font-size: 1.2rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
  display: flex;
  align-items: center;
  gap: .5rem;
}

.modal-title-custom i {
  color: #2563eb;
}

.btn-close-custom {
  background: transparent;
  border: none;
  color: #64748b;
  font-size: 1.25rem;
  border-radius: 8px;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  transition: all 0.15s ease;
}

.btn-close-custom:hover {
  background-color: #f1f5f9;
  color: #1e293b;
}

.modal-body-custom {
  padding: 1.5rem;
}

.form-label-custom {
  font-size: .85rem;
  font-weight: 600;
  color: #475569;
  margin-bottom: .4rem;
  display: block;
}

.input-icon-group {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon-group i {
  position: absolute;
  left: .85rem;
  color: #94a3b8;
  font-size: 1.1rem;
  pointer-events: none;
  z-index: 5;
}

.input-icon-group .form-control,
.input-icon-group .form-select {
  padding-left: 2.5rem;
  border-radius: 10px;
  border: 1px solid #cbd5e1;
  font-size: .9rem;
  height: 2.65rem;
  color: #1e293b;
  transition: all 0.15s ease;
}

.input-icon-group .form-control:focus,
.input-icon-group .form-select:focus {
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.input-icon-group .form-control:disabled {
  background-color: #f8fafc;
  color: #64748b;
  cursor: not-allowed;
}

/* Custom file input */
.form-control-file {
  border-radius: 10px;
  border: 1px solid #cbd5e1;
  font-size: .85rem;
  color: #475569;
}
.form-control-file::file-selector-button {
  background-color: #eff6ff;
  color: #2563eb;
  border: none;
  border-right: 1px solid #bfdbfe;
  padding: .5rem .8rem;
  margin-right: .75rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.15s ease;
}
.form-control-file::file-selector-button:hover {
  background-color: #dbeafe;
}

.modal-footer-custom {
  padding: 1rem 1.5rem 1.25rem;
  border-top: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: .75rem;
}

.btn-cancel-custom {
  background-color: #f1f5f9;
  color: #475569;
  font-weight: 600;
  font-size: .875rem;
  padding: .5rem 1.1rem;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.15s ease;
  border: none;
}
.btn-cancel-custom:hover {
  background-color: #e2e8f0;
  color: #1e293b;
}

.btn-submit-custom {
  background-color: #2563eb;
  color: #ffffff;
  font-weight: 600;
  font-size: .875rem;
  padding: .5rem 1.25rem;
  border-radius: 8px;
  border: none;
  transition: all 0.15s ease;
}
.btn-submit-custom:hover {
  background-color: #1d4ed8;
  color: #ffffff;
}
</style>

<div class="modal-backdrop-custom">
  <div class="modal-content-custom">
    <form action="<?php echo getUrl('Tanque', 'Tanque', 'validarUpdate'); ?>" method="POST" enctype="multipart/form-data">
      
      <div class="modal-header-custom">
        <h5 class="modal-title-custom">
          <i class="bx bx-edit-alt"></i>
          Editar Tanque
        </h5>
        <a href="<?php echo getUrl('Tanque', 'Tanque', 'getConsultar') ?>" class="btn-close-custom">
          <i class="bx bx-x"></i>
        </a>
      </div>

      <div class="modal-body-custom">
        <?php foreach ($datos as $d) { ?>

          <input type="hidden" name="id" value="<?php echo $d['id_tanque']; ?>">

          <!-- Código del Tanque -->
          <div class="mb-3">
            <label class="form-label-custom">Código del tanque</label>
            <div class="input-icon-group">
              <i class="bx bx-hash"></i>
              <input type="text" class="form-control" id="codigo_tanque" name="codigo_tanque" value="<?php echo $d['codigo_tanque']; ?>" disabled>
            </div>
            <input type="hidden" name="codigo" value="<?php echo $d['codigo_tanque']; ?>">
          </div>

          <!-- Imagen del Tanque -->
          <div class="mb-3">
            <label for="img" class="form-label-custom">Imagen del tanque</label>
            <input type="file" class="form-control form-control-file" id="img" name="img" accept="image/*">
          </div>

          <!-- Tipo de Tanque -->
          <div class="mb-3">
            <label for="id_tipo_tanque" class="form-label-custom">Tipo de tanque</label>
            <div class="input-icon-group">
              <i class="bx bx-category"></i>
              <select class="form-select" id="id_tipo_tanque" name="id_tipo_tanque" required>
                <option value="" disabled>Selecciona un tipo</option>
                <?php foreach ($tiposTanque as $tipo) {
                  $selected = ($d['id_tipo_tanque'] == $tipo['id_tipo_tanque']) ? "selected" : "";
                  echo "<option value='" . $tipo['id_tipo_tanque'] . "' $selected>" . $tipo['nombre_tipo_tanque'] . "</option>";
                } ?>
              </select>
            </div>
          </div>

          <!-- Zoocriadero -->
          <div class="mb-3">
            <label for="id_zoocriadero" class="form-label-custom">Zoocriadero</label>
            <div class="input-icon-group">
              <i class="bx bx-building"></i>
              <select class="form-select" id="id_zoocriadero" name="id_zoocriadero" required>
                <option value="" disabled>Selecciona un zoocriadero</option>
                <?php foreach ($zoocriaderos as $zoo) {
                  $selected = ($d['id_zoocriadero'] == $zoo['id_zoocriadero']) ? "selected" : "";
                  echo "<option value='" . $zoo['id_zoocriadero'] . "' $selected>" . $zoo['cod_zoocriadero'] . "</option>";
                } ?>
              </select>
            </div>
          </div>

          <!-- Estado -->
          <div class="mb-2">
            <label for="id_estado" class="form-label-custom">Estado</label>
            <div class="input-icon-group">
              <i class="bx bx-toggle-left"></i>
              <select class="form-select" id="id_estado" name="id_estado" required>
                <option value="" disabled>Selecciona un estado</option>
                <?php foreach ($estados as $est) {
                  $selected = ($d['id_estado'] == $est['id_estado']) ? "selected" : "";
                  echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                } ?>
              </select>
            </div>
          </div>

        <?php } ?>
      </div>

      <div class="modal-footer-custom">
        <a href="<?php echo getUrl('Tanque', 'Tanque', 'getConsultar') ?>" class="btn-cancel-custom">Cancelar</a>
        <button type="submit" class="btn-submit-custom">Guardar cambios</button>
      </div>

    </form>
  </div>
</div>