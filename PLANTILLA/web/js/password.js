const password = document.getElementById('password');
const passwordError = document.getElementById('passwordError');

//validaciones a medida que escribe
password.addEventListener('keypress', (e) => {
    if ((!expreL.test(e.key) && !expreN.test(e.key) && !expreS.test(e.key)) || password.value.length > 14) e.preventDefault();
});

//validar pasword al enviar
function validarPassword() {
    const valor = password.value;
    if (valor.length >= 8 && valor.length <= 15
        && expreMayuscula.test(valor)
        && expreN.test(valor)
        && expreSimbolo.test(valor)){

            passwordError.classList.add('d-none');
            return true;

    }else{
        passwordError.textContent = 'Formato de contraseña invalido';
        passwordError.classList.remove('d-none');
        return false;
    }
}