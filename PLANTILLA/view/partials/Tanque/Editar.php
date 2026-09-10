<div class="modal show" tabindex="-1" style="display:block;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo getUrl('Tanque','Tanque','postUpdate'); ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Editar Tanque</h5>
          <button type="button" class="btn-close" onclick="window.location.href='index.php'"></button>
        </div>
        <div class="modal-body">
            <?php
                foreach($datos as $d){ 
            ?>

            <input type="hidden" name="id" value="<?php echo $d['id_tanque'];?>">

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
              <?php foreach($tiposTanque as $tipo): ?>
                <option value="<?php echo $tipo['id_tipo_tanque']; ?>">
                  <?php echo $tipo['nombre_tipo_tanque']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

            <div class="mb-3">
            <label for="id_zoocriadero" class="form-label">Zoocriadero</label>
            <select class="form-select" id="id_zoocriadero" name="id_zoocriadero" required>
              <option value="" selected disabled>Selecciona un zoocriadero</option>
              <?php foreach($zoocriaderos as $zoo): ?>
                <option value="<?php echo $zoo['id_zoocriadero']; ?>">
                  <?php echo $zoo['cod_zoocriadero']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

            <div class="mb-4">
            <label for="id_estado" class="form-label">Estado</label>
            <select class="form-select" id="id_estado" name="id_estado" required>
              <option value="" selected disabled>Selecciona un estado</option>
              <?php foreach($estados as $est): ?>
                <option value="<?php echo $est['id_estado']; ?>">
                  <?php echo $est['nombre_estado']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>


        </div>
            <?php
                };
            ?>
        <div class="modal-footer">
          <a href="<?php echo getUrl('Tanque','Tanque','getConsultar')?>" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

