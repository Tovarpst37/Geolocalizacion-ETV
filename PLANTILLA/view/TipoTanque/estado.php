<style>
#modalHabilitarTanque .modal-content,
#modalDeshabilitarTanque .modal-content {
  border: 0;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 50px rgba(15, 23, 42, .18);
}
#modalHabilitarTanque .modal-header,
#modalDeshabilitarTanque .modal-header {
  border-bottom: none;
  padding-bottom: 0;
}
#modalHabilitarTanque .modal-body,
#modalDeshabilitarTanque .modal-body {
  color: #1e293b;
}
#modalHabilitarTanque .modal-body p,
#modalDeshabilitarTanque .modal-body p {
  color: #334155;
}
#modalHabilitarTanque .modal-body .tanque-nombre-destacado,
#modalDeshabilitarTanque .modal-body .tanque-nombre-destacado {
  font-weight: 700;
  color: #0f172a;
}
#modalHabilitarTanque .modal-footer,
#modalDeshabilitarTanque .modal-footer {
  border-top: none;
  padding-top: 0;
}
</style>

<!-- Modal Habilitar -->
<div class="modal fade" id="modalHabilitarTanque" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHabilitarTanqueLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0 pb-0">
        <div class="d-flex align-items-center gap-2">
          <div class="d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 text-success" style="width:40px;height:40px;">
            <i class="bx bx-check-circle fs-5"></i>
          </div>
          <h1 class="modal-title fs-5 fw-semibold mb-0" id="modalHabilitarTanqueLabel">Habilitar Tipo De Tanque</h1>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form action="<?php echo getUrl("TipoTanque","TipoTanque","cambiar")?>" method="POST">
        <div class="modal-body pt-2">
          <p class="mb-0">
            ¿Est&aacute;s seguro que deseas habilitar
            <span class="tanque-nombre-destacado" id="habilitar_nombre_texto"></span>?
          </p>
          <input type="hidden" name="id_tipo_tanque" id="habilitar_id_tipo_tanque">
          <input type="hidden" name="estado" value="1">
        </div>
        <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success rounded-3 px-3">
              <i class="bx bx-check-circle me-1"></i>Habilitar
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Deshabilitar -->
<div class="modal fade" id="modalDeshabilitarTanque" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeshabilitarTanqueLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0 pb-0">
        <div class="d-flex align-items-center gap-2">
          <div class="d-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10 text-danger" style="width:40px;height:40px;">
            <i class="bx bx-x-circle fs-5"></i>
          </div>
          <h1 class="modal-title fs-5 fw-semibold mb-0" id="modalDeshabilitarTanqueLabel">Deshabilitar Tipo De Tanque</h1>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form action="<?php echo getUrl("TipoTanque","TipoTanque","cambiar")?>" method="POST">
        <div class="modal-body pt-2">
          <p class="mb-0">
            ¿Est&aacute;s seguro que deseas deshabilitar
            <span class="tanque-nombre-destacado" id="deshabilitar_nombre_texto"></span>?
            Podr&aacute;s volver a habilitarlo cuando lo necesites.
          </p>
          <input type="hidden" name="id_tipo_tanque" id="deshabilitar_id_tipo_tanque">
          <input type="hidden" name="estado" value="0">
        </div>
        <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger rounded-3 px-3">
              <i class="bx bx-x-circle me-1"></i>Deshabilitar
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const modalHabilitarTanque = document.getElementById('modalHabilitarTanque');
  modalHabilitarTanque.addEventListener('show.bs.modal', function (event) {
    const boton = event.relatedTarget;
    document.getElementById('habilitar_id_tipo_tanque').value = boton.getAttribute('data-id');
    document.getElementById('habilitar_nombre_texto').textContent = boton.getAttribute('data-nombre');
  });

  const modalDeshabilitarTanque = document.getElementById('modalDeshabilitarTanque');
  modalDeshabilitarTanque.addEventListener('show.bs.modal', function (event) {
    const boton = event.relatedTarget;
    document.getElementById('deshabilitar_id_tipo_tanque').value = boton.getAttribute('data-id');
    document.getElementById('deshabilitar_nombre_texto').textContent = boton.getAttribute('data-nombre');
  });
</script>