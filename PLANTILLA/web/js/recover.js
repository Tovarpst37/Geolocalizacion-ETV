const documentoR = document.getElementById('documentoRecuperacion');
const formR = document.getElementById('formR');
const errorDoc = document.getElementById('errorDoc');

    documentoR.addEventListener('keypress', (e) => {
        if (!expreN.test(e.key) || documentoR.value.length > 9) e.preventDefault();
    });

    formR.addEventListener('submit', function(e){
        e.preventDefault();
        const validador = validarDocumentoRecuperacion();

        if(!validador){
            return;
        }
        
        formR.submit();
    });

    function validarDocumentoRecuperacion() {
        const valor = documentoR.value.trim();

        if (valor.length < 8) {
            errorDoc.textContent = 'Documento minimo de 8 digitos';
            errorDoc.classList.remove('d-none');
            return false;
        }
        if(!expreNt.test(valor)){
            errorDoc.textContent = 'Formato invalido de documento';
            errorDoc.classList.remove('d-none');
            return false;
        }

        errorDoc.classList.add('d-none');
        return true;
    }
