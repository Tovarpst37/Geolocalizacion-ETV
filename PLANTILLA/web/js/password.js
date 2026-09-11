const password = document.getElementById('password');
const requirementsBox = document.getElementById('passwordRequirements');

//funcion para cambiar el valor para ver o no ver contrasena
function cambiar(valor){
    password.type = valor;
} 
//evento para contrasena 
password.addEventListener('keypress',(e)=>{
    if ((!expreL.test(e.key) && !expreN.test(e.key) && !expreS.test(e.key)) || password.value.length > 14)e.preventDefault();
});
//evento para aparecer el contenedor con las caracteristicas de la contrasena 
password.addEventListener('focus', function () {
    requirementsBox.classList.remove('d-none');
});
////evento para desaparecer el contenedor con las caracteristicas de la contrasena 
password.addEventListener('blur', function () {
    requirementsBox.classList.add('d-none');
});