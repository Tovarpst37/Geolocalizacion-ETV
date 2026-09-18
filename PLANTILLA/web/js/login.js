const loginForm = document.getElementById('loginForm');

loginForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const documentoValido = validarDocumento();
    const passwordValido = validarPassword();

   if (!documentoValido || !passwordValido) {
        return;
    }
    loginForm.submit();
});
