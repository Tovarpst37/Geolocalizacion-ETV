const loginForm = document.getElementById('loginForm');
const contenedor = document.getElementById('sessionError');

loginForm.addEventListener('submit', function (e) {
    let mensaje = "";
    e.preventDefault();

    const documentoValido = validarDocumento();
    const passwordValido = validarPassword();

    if (!documentoValido && documento.value.length > 7) {
        mensaje += "* Formato de documento invalido\n";
    }

    if (!passwordValido) {
        mensaje += "* Formato de contrasena invalido";
    }

    if (mensaje !== "") {
        mostrarErrorLogin(mensaje);
        return;
    }

    fetch(loginForm.getAttribute('action'), {
        method: 'POST',
        body: new FormData(loginForm)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "index.php";
        } else {
            mostrarErrorLogin(data.message);
        }
    })
    .catch(error => {
        console.error('Error en la peticion:', error);
        mostrarErrorLogin("Ocurrio un error al iniciar sesion. Intenta de nuevo.");
    });
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