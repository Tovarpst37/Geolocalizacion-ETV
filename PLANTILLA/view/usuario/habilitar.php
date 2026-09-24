<!-- Modal habilitar-->
<div class="modal fade" id="modalEstadoH" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEstadoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0 pb-0">
        <div class="d-flex align-items-center gap-2">
          <div class="d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 text-success" style="width:40px;height:40px;">
            <i class="bi bi-check-circle-fill fs-5"></i>
          </div>
          <h1 class="modal-title fs-5 fw-semibold mb-0" id="modalEstadoLabel">Habilitar usuario</h1>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo getUrl("Usuario","Usuario","postCambiarEstado")?>" method="POST">
        <div class="modal-body pt-2">
          <p class="mb-0">
            ¿Estás seguro que deseas habilitar este usuario? Podrá volver a acceder al sistema con normalidad.
          </p>
          <input type="hidden" id="estadoH_id_usuario" name="id_usuario">
          <input type="hidden" id="estadoH_id_estado_actual" name="id_estado_actual">
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