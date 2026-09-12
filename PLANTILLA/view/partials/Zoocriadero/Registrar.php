<div class="container mt-4">
  <div class="d-flex justify-content-center">
    <div class="card shadow" style="width: 100%; max-width: 700px;">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Registrar Zoocriadero  </h4>
      </div>

      <div class="card-body p-4">
        <form action="<?php echo getUrl("Zoocriadero","Zoocriadero","postRegistrar")?>" method="POST" enctype="multipart/form-data">

          <div class="mb-3">
            <label for="codigo_tanque" class="form-label">Codigo del zoocriadero</label>
            <input type="text" class="form-control" id="codigo_zoocriadero" name="codigo_zoocriadero" placeholder="Ej: ZOO-MELENDEZ-02" required>
          </div>

          

          <div class="mb-3">
            <label for="id_tipo_tanque" class="form-label">Direccion del zoocriadero</label>
            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ej: Crr28-D3#72v" required>
          </div>

          <div class="mb-4">
            <label for="id_estado" class="form-label">Coordinador Asignado</label>
            <select class="form-select" id="id_usuario" name="id_usuario" required>
              <option value="" selected disabled>Selecciona un Coordinador</option>
              <?php foreach($usuarios as $usu){  ?>
                <option value="<?php echo $usu['id_usuario']; ?>">
                  <?php echo $usu['primer_nombre']." ".$usu['segundo_nombre']." ".$usu['primer_apellido']." ".$usu['segundo_apellido'] ; ?>
                </option>
              <?php }; ?>
            </select>
          </div>


          <div class="mb-4">
            <label for="id_estado" class="form-label">Estado</label>
            <select class="form-select" id="id_estado" name="id_estado" required>
              <option value="" selected disabled>Selecciona un estado</option>
              <?php foreach($estados as $est){  ?>
                <option value="<?php echo $est['id_estado']; ?>">
                  <?php echo $est['nombre_estado']; ?>
                </option>
              <?php }; ?>
            </select>
          </div>

          

          <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Guardar zoocriadero</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>