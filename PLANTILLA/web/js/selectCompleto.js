function validarSelect(array) {
    let hayError = false;

    Array.from(array).forEach(element => {
        if (element.selectedIndex === 0) {
            element.style.borderColor = 'red';
            hayError = true;
        } else {
            element.style.borderColor = '';
        }
    });

    return hayError;
}


document.addEventListener('DOMContentLoaded', function () {
    const selectsValidar = document.getElementsByClassName('select-validar');
    Array.from(selectsValidar).forEach(element => {
        element.addEventListener('change', function () {
            if (element.selectedIndex !== 0) {
                element.style.borderColor = '';
            }
        });
    });
});