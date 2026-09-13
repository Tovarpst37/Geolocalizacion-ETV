<div class="modal show" tabindex="-1" style="display:block;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo getUrl('TipoDeDeposito', 'TipoDeDeposito', 'postUpdate'); ?>" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Editar Tipo de Depósito</h5>
          <a href="<?php echo getUrl('TipoDeDeposito', 'TipoDeDeposito', 'getConsultar') ?>" class="btn btn-close"></a>
        </div>

        <div class="modal-body">
          <?php foreach ($datos as $d) { ?>
            
            <input type="hidden" name="id" value="<?php echo $d['id_tipo_deposito']; ?>">

            <div class="mb-3">
              <label class="form-label">Nombre del Tipo de Depósito*</label>
              <input type="text" 
                     class="form-control" 
                     name="nombre" 
                     value="<?php echo htmlspecialchars($d['nombre']); ?>" 
                     required
                     maxlength="100">
            </div>

          <?php } ?>
        </div>

        <div class="modal-footer">
          <a href="<?php echo getUrl('TipoDeDeposito', 'TipoDeDeposito', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>