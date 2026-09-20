<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Recuperar contrasena</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="" method="POST">
            <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                <p>Ingresa tu número de documento para recuperar tu contrasena.</p>
                <div class="container-input">
                    <ion-icon name="person-circle-outline"></ion-icon>
                    <input
                        type="text"
                        onpaste="return false;"
                        inputmode="numeric"
                        id="documentoRecuperacion"
                        name="documento"
                        placeholder="Numero de identificacion"
                        required
                    >
                </div>
                <small id="documentoError" class="text-danger d-none mb-3 d-block"></small>
            </div>
            <div class="modal-footer  d-flex justify-content-center align-items-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id = "close">Close</button>
                <button type="button" class="button">Recuperar</button>
            </div>
        </form>
    </div>
  </div>
</div>
<script>
    const documentoR = document.getElementById('documentoRecuperacion');

documentoR.addEventListener('keypress', (e) => {
    if (!expreN.test(e.key) || documentoR.value.length > 9) e.preventDefault();
});

function validarDocumento() {
    const valor = documentoR.value.trim();

    if (valor.length < 8) {
        documentoError.textContent = 'Dcumento minimo de 8 digitos';
        documentoError.classList.remove('d-none');
        return false;
    }
    if(!expreNt.test(valor)){
        documentoError.textContent = 'Formato invalido de documento';
        documentoError.classList.remove('d-none');
        return false;
    }

    documentoError.classList.add('d-none');
    return true;
}
</script>
