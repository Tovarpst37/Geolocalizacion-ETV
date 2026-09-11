const loginForm = document.getElementById('loginForm');
const contenedor = document.getElementById('sessionError');

loginForm.addEventListener('submit', function (e) {
    let mensaje = "";
    e.preventDefault();//detiene el envio normal por PHP

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

    const formData = new FormData(this);
    const url = this.getAttribute('action');

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        window.location.href = "index.php"; 
    })
    .catch(error => {
        console.error('Error en la petición:', error);
    });
});

/*
    fetch(loginForm.action, {
        method: 'POST',
        body: new FormData(loginForm)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                mostrarErrorLogin(data.message);
            }
        })
        .catch(() => {
            mostrarErrorLogin('Ocurrió un error al iniciar sesión, intenta de nuevo');
        });
*/

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