document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formRol');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        limpiarErrores();

        let valido = true;

        const nombreInput = document.getElementById('nombre_rol');
        const nombre = nombreInput.value.trim();

        if (nombre === '') {
            mostrarError(nombreInput, 'El nombre de rol es obligatorio.');
            valido = false;
        }

        const checks = form.querySelectorAll('input[name="permisos[]"]:checked');
        const tabla = document.getElementById('table');

        if (checks.length === 0) {
            mostrarErrorTabla(tabla, 'Debe seleccionar al menos un permiso.');
            valido = false;
        }

        if (!valido) return;

        form.submit();
    });

    function mostrarError(input, mensaje) {
        input.classList.add('is-invalid');
        const feedback = document.createElement('div');
        feedback.className = 'invalid-feedback d-block error-js';
        feedback.textContent = mensaje;
        input.insertAdjacentElement('afterend', feedback);
    }

    function mostrarErrorTabla(tabla, mensaje) {
        const alerta = document.createElement('div');
        alerta.className = 'alert alert-danger error-js';
        alerta.textContent = mensaje;
        tabla.insertAdjacentElement('beforebegin', alerta);
    }

    function limpiarErrores() {
        document.querySelectorAll('.error-js').forEach(el => el.remove());
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }
});