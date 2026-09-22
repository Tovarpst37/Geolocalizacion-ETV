<!-- Modal Ver más -->
<div class="modal fade" id="modalVerMas" tabindex="-1" aria-labelledby="modalVerMasLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0 pb-0">
        <div class="d-flex align-items-center gap-2">
          <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary" style="width:40px;height:40px;">
            <i class="bi bi-person-lines-fill fs-5"></i>
          </div>
          <h1 class="modal-title fs-5 fw-semibold mb-0" id="modalVerMasLabel">Información del usuario</h1>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body pt-3">
        <div class="row g-3">

          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">Primer nombre</span>
            <p class="mb-0 fw-medium" id="vm_primer_nombre">-</p>
          </div>
          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">Segundo nombre</span>
            <p class="mb-0 fw-medium" id="vm_segundo_nombre">-</p>
          </div>

          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">Primer apellido</span>
            <p class="mb-0 fw-medium" id="vm_primer_apellido">-</p>
          </div>
          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">Segundo apellido</span>
            <p class="mb-0 fw-medium" id="vm_segundo_apellido">-</p>
          </div>

          <div class="col-12"><hr class="my-1"></div>

          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">Tipo de documento</span>
            <p class="mb-0 fw-medium" id="vm_tipo_documento">-</p>
          </div>
          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">Número de documento</span>
            <p class="mb-0 fw-medium" id="vm_documento">-</p>
          </div>

          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">Fecha de nacimiento</span>
            <p class="mb-0 fw-medium" id="vm_fecha_nacimiento">-</p>
          </div>
          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">Género</span>
            <p class="mb-0 fw-medium" id="vm_genero">-</p>
          </div>

          <div class="col-12"><hr class="my-1"></div>

          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">Correo</span>
            <p class="mb-0 fw-medium" id="vm_correo">-</p>
          </div>
          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">Rol</span>
            <p class="mb-0 fw-medium" id="vm_rol">-</p>
          </div>

          <div class="col-md-6">
            <span class="text-uppercase small fw-semibold text-body-secondary">RH</span>
            <p class="mb-0 fw-medium" id="vm_rh">-</p>
          </div>

        </div>
      </div>

      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
  #modalVerMas .modal-content p,
  #modalVerMas .modal-content h1 {
    color: #0a0a0a !important;
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalVerMas = document.getElementById('modalVerMas');
    if (!modalVerMas) return;

    modalVerMas.addEventListener('show.bs.modal', function (event) {
        var boton = event.relatedTarget;
        if (!boton) return;

        document.getElementById('vm_primer_nombre').textContent    = boton.getAttribute('data-vm-primer-nombre') || '-';
        document.getElementById('vm_segundo_nombre').textContent   = boton.getAttribute('data-vm-segundo-nombre') || '-';
        document.getElementById('vm_primer_apellido').textContent  = boton.getAttribute('data-vm-primer-apellido') || '-';
        document.getElementById('vm_segundo_apellido').textContent = boton.getAttribute('data-vm-segundo-apellido') || '-';
        document.getElementById('vm_tipo_documento').textContent   = boton.getAttribute('data-vm-tipo-documento') || '-';
        document.getElementById('vm_documento').textContent        = boton.getAttribute('data-vm-documento') || '-';
        document.getElementById('vm_fecha_nacimiento').textContent = boton.getAttribute('data-vm-fecha-nacimiento') || '-';
        document.getElementById('vm_correo').textContent           = boton.getAttribute('data-vm-correo') || '-';
        document.getElementById('vm_genero').textContent           = boton.getAttribute('data-vm-genero') || '-';
        document.getElementById('vm_rol').textContent              = boton.getAttribute('data-vm-rol') || '-';
        document.getElementById('vm_rh').textContent               = boton.getAttribute('data-vm-rh') || '-';
    });
});
</script>