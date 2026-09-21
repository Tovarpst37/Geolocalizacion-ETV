const formRecuperar = document.getElementById('formRecuperar');

formRecuperar.addEventListener("submit",function(e){
    e.preventDefault();

    const passwordValido = validarPassword();

    if (!passwordValido) {
        return;
    }
    formRecuperar.submit();
});
