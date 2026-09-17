const from = document.getElementById('createUsuarios');
const selects = document.querySelectorAll('.select-validar');
const primerNombre = document.getElementById('primer_nombre');
const primerApellido =document.getElementById('primer_apellido'); 
//const fechaNacimiento =document.getElementById('fecha_nacimiento');
//const correoElectronico = document.getElementById('correo');

from.addEventListener('submit', function (e) {
    e.preventDefault();

    let validar = validarSelect(selects);

    if(validar || (primerNombre.value.length < 3 || primerApellido.value.length < 3) || !documentoValido || !passwordValido){
        console.log("bien");
        return;
    }
    //from.submit();
});

