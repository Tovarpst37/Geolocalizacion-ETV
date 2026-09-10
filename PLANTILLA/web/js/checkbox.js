const checkbox = document.getElementById('cb1');

//funcion para cambiar el valor para ver o no ver contrasena
function cambiar(valor){
    password.type = valor;
}

//evento del checkbox  para cambiar el metodo de vista del password
checkbox.addEventListener('change', function() {
    if(this.checked){
        cambiar('text');
    }else{
        cambiar('password');
    }
});