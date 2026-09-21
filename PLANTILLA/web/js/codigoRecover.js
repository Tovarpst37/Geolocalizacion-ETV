const formCodigo = document.getElementById('formCodigo');
const codigoInput = document.getElementById('codigoInput');
const errorCodigo = document.getElementById('errorCodigo');

formCodigo.addEventListener('submit', function(e){
    e.preventDefault();

    if(!validarCodigo()){
        return;
    }

    formCodigo.submit();
});

function validarCodigo(){
    const valor = codigoInput.value.trim();

    if(valor.length !== 10){
        errorCodigo.textContent = 'El codigo debe tener 10 caracteres';
        errorCodigo.classList.remove('d-none');
        return false;
    }

    errorCodigo.classList.add('d-none');
    return true;
}