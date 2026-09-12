<div class="modal show" tabindex="-1" style="display:block;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'postUpdate'); ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Editar Zoocriadero</h5>
          <a href="<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'getConsultar') ?>" class="btn btn-close"></a>
        </div>
        <div class="modal-body">
          <?php
          foreach ($datos as $d) {
          ?>

            <input type="hidden" name="id" value="<?php echo $d['id_zoocriadero']; ?>">

            <div class="mb-3">
              <label class="form-label">Código del Zoocriadero</label>
              <input type="text" class="form-control" name="cod_zoocriadero" value="<?php echo $d['cod_zoocriadero']; ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Direccion Zoocriadero</label>
              <input type="text" class="form-control" name="direccion" value="<?php echo $d['direcciom']; ?>">
            </div>


            

            <div class="mb-3">  
              <label for="id_zoocriadero" class="form-label">Zoocriadero</label>
              <select class="form-select" id="id_zoocriadero" name="id_zoocriadero" required>
                <option value="" selected disabled>Selecciona un zoocriadero</option>
                <?php foreach ($zoocriaderos as $zoo) {
                  if ($d['id_zoocriadero'] == $zoo['id_zoocriadero']) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
                  print_r($d);
                  echo "<option value='" . $zoo['id_zoocriadero'] . "' $selected>" . $zoo['cod_zoocriadero'] . "</option>";
                }; ?>
              </select>
            </div>

            <div class="mb-4">
              <label for="id_estado" class="form-label">Estado</label>
              <select class="form-select" id="id_estado" name="id_estado" required>
                <option value="">Selecciona un estado</option>
                <?php foreach ($estados as $est) {
                  if ($d['id_estado'] == $est['id_estado']) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
                  print_r($d);
                  echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                }; ?>
              </select>
            </div>


        </div>
      <?php
          };
      ?>
      <div class="modal-footer">
        <a href="<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
      </div>
      </form>
    </div>
  </div>
</div>