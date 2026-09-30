const from = document.getElementById('createUsuarios');
const selects = document.getElementsByClassName('select-validar');

from.addEventListener('submit', function (e) {
    e.preventDefault();

    const nombreOk       = validarNombre();
    const apellidoOk     = validarApellido();
    const documentoOk    = validarDocumento();
    const passOk         = validarPassword();
    const correoOk       = validarCorreo();
    const fechaOk        = validarFecha();
    const hayErrorSelect = validarSelect(selects);

    const formularioValido =
        nombreOk && apellidoOk && documentoOk && passOk &&
        correoOk && fechaOk && !hayErrorSelect;

    if (!formularioValido) {
        return;
    }

    from.submit();
});