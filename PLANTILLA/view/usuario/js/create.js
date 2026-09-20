const from = document.getElementById('createUsuarios');
const selects = document.getElementsByClassName('select-validar');
const primerNombre = document.getElementById('primer_nombre');
const primerApellido =document.getElementById('primer_apellido'); 

//falta validar el calendario o mejor dicho bloquear en el calendario las fechas menores a la acual.
from.addEventListener('submit', function (e) {

    e.preventDefault();

    const nombre = primerNombre.value;
    const apellido = primerApellido.value;
    const document = validarDocumento();
    const pass = validarPassword();
    const corr = validarCorreo();
    const select = validarSelect(selects);

    if((nombre.length < 3 || apellido.length < 3) || !document || !pass || !corr || select){
        
        return;
    }

    from.submit();
});

