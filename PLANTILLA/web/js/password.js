const password = document.getElementById('password');

//funcion para cambiar el valor para ver o no ver contrasena
function cambiar(valor){
    password.type = valor;
} 

//evento para contrasena 
password.addEventListener('keypress',(e)=>{
    if ((!expreL.test(e.key) && !expreN.test(e.key) && !expreS.test(e.key)) || password.value.length > 14)e.preventDefault();
});
