<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Recuperar contrasena</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="<?php echo getUrl("RecuperarContrasena","RecuperarContrasena","recuperar",false,"ajax"); ?>" method="POST" id="formR">
            <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                <p>Ingresa tu número de documento para recuperar tu contrasena.</p>
                <div class="container-input">
                    <ion-icon name="person-circle-outline"></ion-icon>
                    <input
                        type="text"
                        onpaste="return false;"
                        inputmode="numeric"
                        id="documentoRecuperacion"
                        name="documentoR"
                        placeholder="Numero de identificacion"
                        required
                    >
                </div>
                <small id="errorDoc" class="text-danger d-none mb-3 d-block"></small>
            </div>
            <div class="modal-footer  d-flex justify-content-center align-items-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id = "close">Close</button>
                <button type="submit" class="button">Recuperar</button>
            </div>
        </form>
    </div>
  </div>
</div>
<script src="../web/js/recover.js"></script>
