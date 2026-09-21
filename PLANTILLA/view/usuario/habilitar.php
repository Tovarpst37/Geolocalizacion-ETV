<!-- Modal habilitar-->
<div class="modal fade" id="modalEstadoH" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEstadoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalEstadoLabel">Habilitar usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo getUrl("Usuario","Usuario","postCambiarEstado")?>" method="POST">
        <div class="modal-body">
          Estas seguro que deseas Habilitar el usuario
          <input type="hidden" id="estado_id_usuario" name="id_usuario">
          <input type="hidden" id="estado_id_estado_actual" name="id_estado_actual">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Aceptar</button>
        </div>
      </form>
    </div>
  </div>
</div>