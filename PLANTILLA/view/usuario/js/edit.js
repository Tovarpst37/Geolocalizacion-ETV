const modalEdit = document.getElementById('modalEdit');
const selects = document.getElementsByClassName('select-validar');

modalEdit.addEventListener('submit',function(e){

    e.preventDefault();

    const nombreOk       = validarNombre();
    const apellidoOk     = validarApellido();
    const documentoOk    = validarDocumento();
    const correoOk       = validarCorreo();
    const fechaOk        = validarFecha();
    const hayErrorSelect = validarSelect(selects);
    
    const formularioValido =
        nombreOk && apellidoOk && documentoOk &&
        correoOk && fechaOk && !hayErrorSelect;

    if(!formularioValido){
        return;
    }
    
    modalEdit.submit();
});