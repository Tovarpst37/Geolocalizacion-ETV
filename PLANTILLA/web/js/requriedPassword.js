const requirementsBox = document.getElementById('passwordRequirements');
//aqui se desplega la lista de considciones de la contrasena
password.addEventListener('focus', function () {
    requirementsBox.classList.remove('d-none');
});

//validaciones en tiempo real pra que elusuario pueda
password.addEventListener('input', function () {
    const valor = password.value;

    actualizarRequisito('req-length', valor.length >= 8 && valor.length <= 15);
    actualizarRequisito('req-mayuscula', expreMayuscula.test(valor));
    actualizarRequisito('req-numero', expreN.test(valor));
    actualizarRequisito('req-simbolo', expreSimbolo.test(valor));
});

//function par actualizar icono pa ver que se cumple con las condiciones de la contrasena
function actualizarRequisito(id, cumple) {
    const icono = document.querySelector(`#${id} i`);
    icono.classList.toggle('fa-circle', !cumple);
    icono.classList.toggle('text-secondary', !cumple);
    icono.classList.toggle('fa-check-circle', cumple);
    icono.classList.toggle('text-success', cumple);
}