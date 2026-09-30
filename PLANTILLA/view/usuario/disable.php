<style>
  .modal-content p,
  .modal-content h1,
  .modal-content h2,
  .modal-content h3 {
    color: #0a0a0a !important;
  }
</style>

<!-- Modal Disable-->
<div class="modal fade" id="modalEstado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEstadoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0 pb-0">
        <div class="d-flex align-items-center gap-2">
          <div class="d-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-10 text-warning" style="width:40px;height:40px;">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
          </div>
          <h1 class="modal-title fs-5 fw-semibold mb-0" id="modalEstadoLabel">Deshabilitar usuario</h1>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo getUrl("Usuario","Usuario","postCambiarEstado")?>" method="POST">
        <div class="modal-body pt-2">
          <p class="mb-0">
            ¿Estás seguro que deseas deshabilitar este usuario? Podrás volver a habilitarlo cuando lo necesites.
          </p>
          <input type="hidden" id="estado_id_usuario" name="id_usuario">
          <input type="hidden" id="estado_id_estado_actual" name="id_estado_actual">
        </div>
        <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary rounded-3 px-3">
              <i class="bi bi-check2-circle me-1"></i>Aceptar
            </button>
        </div>
      </form>
    </div>
  </div>
</div>
