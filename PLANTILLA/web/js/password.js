const password = document.getElementById('password');
const requirementsBox = document.getElementById('passwordRequirements');

password.addEventListener('keypress', (e) => {
    if ((!expreL.test(e.key) && !expreN.test(e.key) && !expreS.test(e.key)) || password.value.length > 14) e.preventDefault();
});

password.addEventListener('focus', function () {
    requirementsBox.classList.remove('d-none');
});

password.addEventListener('input', function () {
    const valor = password.value;

    actualizarRequisito('req-length', valor.length >= 8 && valor.length <= 15);
    actualizarRequisito('req-mayuscula', expreMayuscula.test(valor));
    actualizarRequisito('req-numero', expreN.test(valor));
    actualizarRequisito('req-simbolo', expreSimbolo.test(valor));
});

function actualizarRequisito(id, cumple) {
    const icono = document.querySelector(`#${id} i`);
    icono.classList.toggle('fa-circle', !cumple);
    icono.classList.toggle('text-secondary', !cumple);
    icono.classList.toggle('fa-check-circle', cumple);
    icono.classList.toggle('text-success', cumple);
}

function validarPassword() {
    const valor = password.value;
    return valor.length >= 8 && valor.length <= 15
        && expreMayuscula.test(valor)
        && expreN.test(valor)
        && expreSimbolo.test(valor);
}