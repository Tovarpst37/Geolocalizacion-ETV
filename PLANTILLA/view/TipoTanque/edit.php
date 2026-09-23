<style>
#modalEditarTanque .modal-dialog{
  max-width: 540px;
}
#modalEditarTanque .modal-content {
  border: 0;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 50px rgba(15, 23, 42, .22);
}

/* Header */
#modalEditarTanque .modal-header {
  background: linear-gradient(135deg, #2563eb, #1d4ed8);
  border-bottom: none;
  padding: 1.5rem 1.75rem;
  align-items: center;
  gap: .9rem;
}
#modalEditarTanque .modal-header-icon{
  display: flex;
  align-items: center;
  justify-content: center;
  width: 3rem;
  height: 3rem;
  border-radius: 14px;
  background: rgba(255,255,255,.18);
  color: #ffffff;
  font-size: 1.5rem;
  flex-shrink: 0;
}
#modalEditarTanque .modal-title-group{
  display: flex;
  flex-direction: column;
  gap: .1rem;
}
#modalEditarTanque .modal-title {
  font-weight: 700;
  color: #ffffff;
  font-size: 1.15rem;
  margin: 0;
}
#modalEditarTanque .modal-subtitle{
  font-size: .82rem;
  color: rgba(255,255,255,.85);
  margin: 0;
}
#modalEditarTanque .btn-close{
  margin-left: auto;
  align-self: flex-start;
  filter: brightness(0) invert(1);
  opacity: .85;
}
#modalEditarTanque .btn-close:hover{
  opacity: 1;
}

/* Body: fondo gris claro para que los inputs blancos resalten */
#modalEditarTanque .modal-body {
  padding: 1.75rem;
  background-color: #f1f5f9;
}

#modalEditarTanque .modal-id-chip{
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  background: #ffffff;
  color: #2563eb;
  border: 1.5px solid #bfdbfe;
  border-radius: 999px;
  padding: .3rem .8rem;
  font-size: .78rem;
  font-weight: 700;
  margin-bottom: 1.4rem;
}

#modalEditarTanque .form-label {
  display: flex;
  align-items: center;
  gap: .4rem;
  margin-bottom: .5rem;
  font-size: .9rem;
  font-weight: 700;
  color: #1e293b;
}
#modalEditarTanque .form-label i.bx {
  font-size: 1.05rem;
  color: #2563eb;
}

/* Campos: fondo blanco + borde marcado para contraste real contra el body gris */
#modalEditarTanque .form-control {
  padding: .75rem 1rem;
  border: 1.5px solid #cbd5e1;
  border-radius: 12px;
  background-color: #ffffff;
  color: #0f172a;
  font-size: .95rem;
  box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
  transition: border-color .15s ease, box-shadow .15s ease;
}
#modalEditarTanque .form-control::placeholder{
  color: #94a3b8;
}
#modalEditarTanque .field-group{
  margin-bottom: 1.25rem;
}
#modalEditarTanque .field-group:last-child{
  margin-bottom: 0;
}
#modalEditarTanque textarea.form-control {
  min-height: 150px;
  resize: vertical;
}
#modalEditarTanque .form-control:hover {
  border-color: #94a3b8;
}
#modalEditarTanque .form-control:focus {
  background-color: #ffffff;
  border-color: #2563eb;
  box-shadow: 0 0 0 4px rgba(37, 99, 235, .18);
  outline: 0;
}

/* Footer */
#modalEditarTanque .modal-footer {
  border-top: 1px solid #e2e8f0;
  background-color: #ffffff;
  padding: 1.25rem 1.75rem;
  gap: .5rem;
}
#modalEditarTanque .modal-footer .btn{
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  padding: .6rem 1.4rem;
  border-radius: 12px;
  font-weight: 600;
}
#modalEditarTanque .btn-primary{
  background-color: #2563eb;
  border-color: #2563eb;
  box-shadow: 0 4px 12px rgba(37, 99, 235, .3);
}
#modalEditarTanque .btn-primary:hover,
#modalEditarTanque .btn-primary:focus{
  background-color: #1d4ed8;
  border-color: #1d4ed8;
}
#modalEditarTanque .btn-outline-secondary{
  border-width: 1.5px;
  color: #64748b;
  border-color: #cbd5e1;
  background: #ffffff;
}
#modalEditarTanque .btn-outline-secondary:hover{
  background: #f1f5f9;
  color: #1e293b;
  border-color: #94a3b8;
}
</style>

<!-- Modal Editar Tipo de Tanque -->
<div class="modal fade" id="modalEditarTanque" tabindex="-1" aria-labelledby="modalEditarTanqueLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo getUrl("TipoTanque", "TipoTanque", "editar") ?>" method="POST" id="formEditarTanque">

        <div class="modal-header">
          <div class="modal-header-icon">
            <i class="bx bx-edit-alt"></i>
          </div>
          <div class="modal-title-group">
            <h5 class="modal-title" id="modalEditarTanqueLabel">Editar Tipo de Tanque</h5>
            <p class="modal-subtitle">Actualiza el nombre y la descripci&oacute;n del registro</p>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id_tipo_tanque" id="edit_id_tipo_tanque">

          <span class="modal-id-chip">
            <i class="bx bx-hash"></i>
            <span id="edit_id_chip_texto">ID: --</span>
          </span>

          <div class="field-group">
            <label for="edit_nombre_tipo_tanque" class="form-label"><i class="bx bx-tag"></i>Nombre<span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control letras"
              id="edit_nombre_tipo_tanque"
              name="nombre_tipo_tanque"
              placeholder="Ej: Tanque de reproducci&oacute;n"
            >
          </div>

          <div class="field-group">
            <label for="edit_descripcion_tipo_tanque" class="form-label"><i class="bx bx-align-left"></i>Descripci&oacute;n</label>
            <textarea
              class="form-control"
              id="edit_descripcion_tipo_tanque"
              name="descripcion_tipo_tanque"
              placeholder="Describe las caracter&iacute;sticas, uso u observaciones de este tipo de tanque"
            ></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bx bx-x"></i>Cancelar</button>
          <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i>Guardar cambios</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
  const modalEditarTanque = document.getElementById('modalEditarTanque');
  modalEditarTanque.addEventListener('show.bs.modal', function (event) {
    const boton = event.relatedTarget;

    const id = boton.getAttribute('data-id');
    const nombre = boton.getAttribute('data-nombre');
    const descripcion = boton.getAttribute('data-descripcion');

    document.getElementById('edit_id_tipo_tanque').value = id;
    document.getElementById('edit_nombre_tipo_tanque').value = nombre;
    document.getElementById('edit_descripcion_tipo_tanque').value = descripcion;
    document.getElementById('edit_id_chip_texto').textContent = 'ID: ' + id;
  });
</script>