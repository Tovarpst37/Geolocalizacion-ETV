<div class="modal show" tabindex="-1" style="display:block;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo getUrl('SeguimientoZoocriadero', 'SeguimientoZoocriadero', 'postUpdate'); ?>" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Editar Seguimiento</h5>
          <a href="<?php echo getUrl('SeguimientoZoocriadero', 'SeguimientoZoocriadero', 'getConsultar') ?>" class="btn btn-close"></a>
        </div>
        <div class="modal-body">
          <?php
          foreach ($datos as $d) {
            $horarioActual = substr($d['hora_inicio'], 0, 5) . '-' . substr($d['hora_fin'], 0, 5);
          ?>
          

            <input type="hidden" name="id" value="<?php echo $d['id_seguimiento_zoo']; ?>">

            <div class="mb-3">
              <label class="form-label">Fecha del seguimiento</label>
              <input type="date" class="form-control" name="fecha" 
                    value="<?php echo $d['fecha']; ?>" 
                    min="<?php echo date('Y-m-d'); ?>" 
                    required>
            </div>

            <div class="mb-3">
              <label class="form-label">Horario</label>
              <select class="form-select" name="horario" required>
                <option value="" disabled>Selecciona un horario</option>
                <option value="06:00-12:00" <?php echo ($horarioActual == '06:00-12:00') ? 'selected' : ''; ?>>6:00AM - 12:00PM</option>
                <option value="12:00-17:00" <?php echo ($horarioActual == '12:00-17:00') ? 'selected' : ''; ?>>12:00PM - 5:00PM</option>
              </select>
            </div>

            <div class="mb-4">
              <label for="id_estado" class="form-label">Estado</label>
              <select class="form-select" id="id_estado" name="id_estado" required>
                <option value="">Selecciona un estado</option>
                <?php foreach ($estados as $est) {
                  $selected = ($d['id_estado'] == $est['id_estado']) ? "selected" : "";
                  echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                }; ?>
              </select>
            </div>

          <?php
          };
          ?>
        </div>
        <div class="modal-footer">
          <a href="<?php echo getUrl('SeguimientoZoocriadero', 'SeguimientoZoocriadero', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>