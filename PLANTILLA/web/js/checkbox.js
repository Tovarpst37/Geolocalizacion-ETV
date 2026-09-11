const checkbox = document.getElementById('cb1');

function cambiar(valor) {
    password.type = valor;
}

checkbox.addEventListener('change', function () {
    cambiar(this.checked ? 'text' : 'password');
});