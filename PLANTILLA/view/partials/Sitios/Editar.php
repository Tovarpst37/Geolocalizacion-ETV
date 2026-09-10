<div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistroLabel">Formulario de Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo getUrl("Sitios", "Sitios", "postUpdate") ?>" method="post">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre completo" required>
                        <div class="invalid-feedback">Por favor ingrese el nombre.</div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ej: Calle 10 # 5-20" required>
                        <div class="invalid-feedback">Por favor ingrese la dirección.</div>
                    </div>

                    <div class="mb-3">
                        <label for="barrio" class="form-label">Barrio</label>
                        <input type="text" class="form-control" id="barrio" name="barrio" placeholder="Ingrese el barrio" required>
                        <div class="invalid-feedback">Por favor ingrese el barrio.</div>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="" selected disabled>Seleccione un estado</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="pendiente">Pendiente</option>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione un estado.</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once '../view/partials/Sitios/Consultar.php'; ?>