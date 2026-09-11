<div class="modal show" id="modalEditar" tabindex="-1" style="display:block;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistroLabel">Editar Sitio</h5>
                <a href="<?php echo getUrl('Sitios', 'Sitios', 'getConsultar') ?>">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </a>
            </div>
            <div class="modal-body">
                <?php foreach ($datos as $d) { ?>
                    <form action="<?php echo getUrl("Sitios", "Sitios", "postUpdate") ?>" method="post">

                        <input type="hidden" name="id" value="<?php echo $d['id_sitio']; ?>">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre completo" required value="<?php echo $d['nombre_sitio']; ?>">
                            <div class="invalid-feedback">Por favor ingrese el nombre.</div>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ej: Calle 10 # 5-20" required value="<?php echo $d['direccion']; ?>">
                            <div class="invalid-feedback">Por favor ingrese la dirección.</div>
                        </div>

                        <div class="mb-3">
                            <label for="barrio" class="form-label">Barrio</label>
                            <select class="form-select" id="barrio" name="barrio" required>
                                <option value="" selected disabled>Seleccione un barrio</option>
                                <?php foreach ($barrios as $b) {
                                    if ($d['id_barrio'] == $b['id_barrio']) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option value='" . $b['id_barrio'] . "' $selected>" . $b['nombre_barrio'] . "</option>";
                                } ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione un barrio.</div>
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="" selected disabled>Seleccione un estado</option>
                                <?php foreach ($estados as $est) {
                                    if ($d['id_estado'] == $est['id_estado']) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                                } ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione un estado.</div>
                        </div>

                        <div class="d-grid">
                            <a href="<?php echo getUrl('Sitio', 'Sitio', 'postUpdate') ?>">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </a>
                        </div>

                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

