const documento = document.getElementById('documento');
const documentoError = document.getElementById('documentoError');

documento.addEventListener('keypress', (e) => {
    if (!expreN.test(e.key) || documento.value.length > 9) e.preventDefault();
});

function validarDocumento() {
    const valor = documento.value.trim();

    if (valor.length < 8) {
        documentoError.textContent = 'El documento debe tener minimo 8 digitos';
        documentoError.classList.remove('d-none');
        return false;
    }

    documentoError.classList.add('d-none');
    return true;
}