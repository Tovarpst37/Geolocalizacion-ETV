<div class="container mt-4">
  <div class="d-flex justify-content-center">
    <div class="card shadow" style="width: 100%; max-width: 700px;">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Registrar Tanque</h4>
      </div>

      <div class="card-body p-4">
        <form action="<?php echo getUrl("Tanque", "Tanque", "validarRegistrar") ?>" method="POST" enctype="multipart/form-data">

          <div class="mb-3">
            <label for="codigo_tanque" class="form-label">Código del tanque</label>
            <input type="text" class="form-control" id="codigo_tanque" name="codigo_tanque" placeholder="Ej: TQ-001" value="<?php echo $old['codigo_tanque'] ?? ''; ?>" required>
          </div>

          <div class="mb-3">
            <label for="img" class="form-label">Imagen del tanque</label>
            <input type="file" class="form-control" id="img" name="img" accept="image/*">
          </div>

          <div class="mb-3">
            <label for="id_tipo_tanque" class="form-label">Tipo de tanque</label>
            <select class="form-select" id="id_tipo_tanque" name="id_tipo_tanque" required>
              <option value="" selected disabled>Selecciona un tipo</option>
              <?php foreach ($tiposTanque as $tipo): ?>
                <option value="<?php echo $tipo['id_tipo_tanque']; ?>" <?php echo (($old['id_tipo_tanque'] ?? '') == $tipo['id_tipo_tanque']) ? 'selected' : ''; ?>><?php echo $tipo['nombre_tipo_tanque']; ?></option>

              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="id_zoocriadero" class="form-label">Zoocriadero</label>
            <select class="form-select" id="id_zoocriadero" name="id_zoocriadero" required>
              <option value="" selected disabled>Selecciona un zoocriadero</option>
              <?php foreach ($zoocriaderos as $zoo): ?>
                <option value="<?php echo $zoo['id_zoocriadero']; ?>" <?php echo (($old['id_zoocriadero'] ?? '') == $zoo['id_zoocriadero']) ? 'selected' : ''; ?>><?php echo $zoo['cod_zoocriadero']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-4">
            <label for="id_estado" class="form-label">Estado</label>
            <select class="form-select" id="id_estado" name="id_estado" required>
              <option value="" selected disabled>Selecciona un estado</option>
              <?php foreach ($estados as $est): ?>
                <option value="<?php echo $est['id_estado']; ?>" <?php echo (($old['id_estado'] ?? '') == $est['id_estado']) ? 'selected' : ''; ?>><?php echo $est['nombre_estado']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Guardar Tanque</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>