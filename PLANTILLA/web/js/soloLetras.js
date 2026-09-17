const campos = document.getElementsByClassName('letras');

Array.from(campos).forEach(element => {
    element.addEventListener('keypress', (e) => {
        if (!expreL.test(e.key)) e.preventDefault();
    });
});