function validarSelect(array) {

    let valor = false;

    Array.from(array).forEach(element => {
        if (element.selectedIndex === 0) {
            element.style.borderColor = 'red';
            if(!valor)valor = true;
        }
    });

    return valor;
}