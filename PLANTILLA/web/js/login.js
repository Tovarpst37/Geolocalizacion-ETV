const loginForm = document.getElementById('loginForm');
const contenedor = document.getElementById('sessionError');

loginForm.addEventListener('submit', function (e) {
    e.preventDefault();

    let mensaje = "";
    const documentoValido = validarDocumento();
    const passwordValido = validarPassword();

    if (!documentoValido) {
        mensaje += "Formato de documento invalido\n";
    }

    if (!passwordValido) {
        mensaje += "Formato de contrasena invalido";
    }

    if (mensaje !== "") {
        mostrarErrorLogin(mensaje);
        return;
    }

    loginForm.submit();
});

function mostrarErrorLogin(mensaje) {
    if (!contenedor) return;

    let alertBox = contenedor.querySelector('.alert-danger');

    if (!alertBox) {
        alertBox = document.createElement('div');
        alertBox.className = 'alert alert-danger';
        contenedor.appendChild(alertBox);
    }

    alertBox.innerText = mensaje;
}