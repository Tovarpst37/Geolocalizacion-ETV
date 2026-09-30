const primerNombre = document.getElementById('primer_nombre');
const primerApellido = document.getElementById('primer_apellido');
const nombreError = document.getElementById('nombreError');
const apellidoError = document.getElementById('apellidoError');

function validarNombre() {
    const valor = primerNombre.value.trim();
    if (valor.length < 3) {
        nombreError.textContent = 'El primer nombre debe tener minimo 3 caracteres';
        nombreError.classList.remove('d-none');
        return false;
    }
    nombreError.classList.add('d-none');
    return true;
}

function validarApellido() {
    const valor = primerApellido.value.trim();
    if (valor.length < 3) {
        apellidoError.textContent = 'El primer apellido debe tener minimo 3 caracteres';
        apellidoError.classList.remove('d-none');
        return false;
    }
    apellidoError.classList.add('d-none');
    return true;
}