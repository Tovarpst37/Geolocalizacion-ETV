<div class="modal fade" id="modalCodigo" tabindex="-1" aria-labelledby="modalCodigoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalCodigoLabel">Ingresa el codigo</h1>
      </div>
        <form action="<?php echo getUrl("RecuperarContrasena","RecuperarContrasena","validarCodigo",false,"ajax"); ?>" method="POST" id="formCodigo">
            <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                <p>Revisa tu correo, te enviamos un codigo de verificacion.</p>
                <div class="container-input">
                    <ion-icon name="key-outline"></ion-icon>
                    <input
                        type="text"
                        id="codigoInput"
                        name="codigo"
                        placeholder="Codigo de verificacion"
                        required
                    >
                </div>
                <small id="errorCodigo" class="text-danger d-none mb-3 d-block"></small>
            </div>
            <div class="modal-footer d-flex justify-content-center align-items-center">
                <a href="<?php echo getUrl("RecuperarContrasena","RecuperarContrasena","cancelarRecuperacion",false,"ajax"); ?>" class="btn btn-secondary"  id = "close">Cancelar</a>
                <button type="submit" class="button">Validar</button>
            </div>
        </form>
    </div>
  </div>
</div>