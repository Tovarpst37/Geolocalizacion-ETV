<div class="modal show" tabindex="-1" style="display:block;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo getUrl('Tanque', 'Tanque', 'validarUpdate'); ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Editar Tanque</h5>
          <a href="<?php echo getUrl('Tanque', 'Tanque', 'getConsultar') ?>" class="btn btn-close"></a>
        </div>
        <div class="modal-body">
          <?php
          foreach ($datos as $d) {
          ?>

            <input type="hidden" name="id" value="<?php echo $d['id_tanque']; ?>">

            <div class="mb-3">
              <label for="img" class="form-label">Imagen del tanque</label>
              <input type="file" class="form-control" id="img" name="img" accept="image/*">
            </div>

            <div class="mb-3">
              <label class="form-label">Código del tanque</label>
              <input type="text" class="form-control" name="codigo_tanque" value="<?php echo $d['codigo_tanque']; ?>">
            </div>


            <div class="mb-3">
              <label for="id_tipo_tanque" class="form-label">Tipo de tanque</label>
              <select class="form-select" id="id_tipo_tanque" name="id_tipo_tanque" required>
                <option value="" selected disabled>Selecciona un tipo</option>
                <?php foreach ($tiposTanque as $tipo) {
                  if ($d['id_tipo_tanque'] == $tipo['id_tipo_tanque']) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
                  print_r($d);
                  echo "<option value='" . $tipo['id_tipo_tanque'] . "' $selected>" . $tipo['nombre_tipo_tanque'] . "</option>";
                } ?>
              </select>
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
        <a href="<?php echo getUrl('Tanque', 'Tanque', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
      </div>
      </form>
    </div>
  </div>
</div>