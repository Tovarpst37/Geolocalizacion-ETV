<div class="modal show " tabindex="-1" style="display:block;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <form action="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'validarUpdate'); ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Editar Actividad de Zoocriadero</h5>
          <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getConsultar') ?>" class="btn btn-close"></a>
        </div>
        <div class="modal-body">
          <?php
          foreach ($datos as $d) {
          ?>

            <input type="hidden" name="id" value="<?php echo $d['id_actividad_zoo']; ?>">

           

            <div class="mb-3">
              <label class="form-label">Código de la actividad</label>
              <input type="text" class="form-control" name="cod_actividad" value="<?php echo $d['cod_actividad']; ?>"readonly>
            </div>

             <div class="mb-3">
              <label class="form-label">Nombre de la actividad</label>
              <input type="text" class="form-control" name="nombre_actividad" value="<?php echo $d['nombre_actividad']; ?>">
            </div>
            

        </div>
      <?php
          };
      ?>
      <div class="modal-footer">
        <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getConsultar') ?>" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
      </div>
      </form>
    </div >
  </div>
</div>

