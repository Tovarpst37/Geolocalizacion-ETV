const loginForm = document.getElementById('loginForm');

loginForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const documentoValido = validarDocumento();
    const passwordValido = validarPassword();

    if (!documentoValido || !passwordValido) return;

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
});

function mostrarErrorLogin(mensaje) {
    let errorBox = document.getElementById('loginError');
    if (!errorBox) {
        errorBox = document.createElement('div');
        errorBox.id = 'loginError';
        errorBox.className = 'alert alert-danger mt-3';
        loginForm.appendChild(errorBox);
    }
    errorBox.textContent = mensaje;
}