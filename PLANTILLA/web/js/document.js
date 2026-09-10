const documento = document.getElementById('documento');

documento.addEventListener('keypress',(e)=>{
   if(!expreN.test(e.key) || documento.value.length > 9) e.preventDefault();
});