document.addEventListener('DOMContentLoaded', function () {
    const modalEditar = document.getElementById('modalEditar');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            document.getElementById('edit_id_usuario').value = btn.dataset.idUsuario;
            document.getElementById('primer_nombre').value = btn.dataset.primerNombre;
            document.getElementById('edit_segundo_nombre').value = btn.dataset.segundoNombre;
            document.getElementById('primer_apellido').value = btn.dataset.primerApellido;
            document.getElementById('edit_segundo_apellido').value = btn.dataset.segundoApellido;
            document.getElementById('edit_tipo_documento').value = btn.dataset.idTipoDocumento;
            document.getElementById('documento').value = btn.dataset.documento;
            document.getElementById('fecha_nacimiento').value = btn.dataset.fechaNacimiento;
            document.getElementById('correo').value = btn.dataset.correo;
            document.getElementById('edit_genero').value = btn.dataset.idGenero;
            document.getElementById('edit_rol').value = btn.dataset.idRol;
            document.getElementById('edit_rh').value = btn.dataset.idRh;
        });
    }

    const modalEstado = document.getElementById('modalEstado');
    if (modalEstado) {
        modalEstado.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            document.getElementById('estado_id_usuario').value = btn.dataset.idUsuario;
            document.getElementById('estado_id_estado_actual').value = btn.dataset.idEstadoActual;
        });
    }

    const modalEstadoH = document.getElementById('modalEstadoH');
    if (modalEstadoH) {
        modalEstadoH.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            document.getElementById('estadoH_id_usuario').value = btn.dataset.idUsuario;
            document.getElementById('estadoH_id_estado_actual').value = btn.dataset.idEstadoActual;
        });
    }
});