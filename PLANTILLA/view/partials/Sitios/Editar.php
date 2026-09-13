<div class="modal show" id="modalEditar" tabindex="-1" style="display:block;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistroLabel">Editar Seguimiento</h5>
                <a href="<?php echo getUrl('SeguimientoZoocriadero', 'SeguimientoZoocriadero', 'getConsultar') ?>">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </a>
            </div>
            <div class="modal-body">
                <?php foreach ($datos as $d) { ?>
                    <form action="<?php echo getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "postUpdate") ?>" method="post">

                        <input type="hidden" name="id" value="<?php echo $d['id_seguimiento_zoo']; ?>">

                        <div class="mb-3">
                            <label for="fecha_hora" class="form-label">Fecha y hora del seguimiento <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" 
                                   value="<?php echo str_replace(' ', 'T', substr($d['fecha'], 0, 16)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="" selected disabled>Estado *</option>
                                <?php foreach ($estados as $est) {
                                    $selected = ($d['id_estado'] == $est['id_estado']) ? "selected" : "";
                                    echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                                } ?>
                            </select>
                        </div>

                        <div class="text-muted small mb-3"><span class="text-danger">*</span> Campos obligatorios</div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>