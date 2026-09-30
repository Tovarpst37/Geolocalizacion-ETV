const fechaNacimiento = document.getElementById('fecha_nacimiento');
const fechaError = document.getElementById('fechaError');

function validarFecha() {
    
    const valor = fechaNacimiento.value;
    
    if (!valor) {
        fechaError.textContent = 'La fecha de nacimiento es obligatoria';
        fechaError.classList.remove('d-none');
        return false;
    }

    const edadActual = edad();

    if(edadActual == -1){
        fechaError.textContent = 'Fcha invalida';
        fechaError.classList.remove('d-none');
        return;
    }

    if(edadActual < 18){
        fechaError.textContent = 'Eres menor de edad';
        fechaError.classList.remove('d-none');
        return false;
    }

    fechaError.classList.add('d-none');
    return true;
}

function edad(valor) {
    const fecha = fechaNacimiento.value.split('-');
    const nacAnio = parseInt(fecha[0], 10);
    const nacMes = parseInt(fecha[1], 10);
    const nacDia = parseInt(fecha[2], 10);

    const hoy = new Date();
    const anioActual = hoy.getFullYear();
    const mesActual = hoy.getMonth() + 1; 
    const diaActual = hoy.getDate();

    if(nacAnio > anioActual){
        return -1;
    }
    let edad = anioActual - nacAnio;

    if (mesActual < nacMes || (mesActual === nacMes && diaActual < nacDia)) {
        edad--;
    }

    return edad;
}