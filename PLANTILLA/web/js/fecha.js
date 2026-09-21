const fechaNacimiento = document.getElementById('fecha_nacimiento');
const fechaError = document.getElementById('fechaError');

function validarFecha() {
    const valor = fechaNacimiento.value;

    if (!valor) {
        fechaError.textContent = 'La fecha de nacimiento es obligatoria';
        fechaError.classList.remove('d-none');
        return false;
    }

    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);
    const fechaIngresada = new Date(valor + 'T00:00:00');

    if (fechaIngresada >= hoy) {
        fechaError.textContent = 'La fecha de nacimiento debe ser anterior a hoy';
        fechaError.classList.remove('d-none');
        return false;
    }

    fechaError.classList.add('d-none');
    return true;
}