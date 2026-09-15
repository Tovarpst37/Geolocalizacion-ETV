<div class="modal show" tabindex="-1" style="display:block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="<?php echo getUrl('Historial', 'Historial', 'postUpdate'); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Formulario de Seguimiento</h5>
                    <a href="<?php echo getUrl('Historial', 'Historial', 'getConsultar') ?>" class="btn-close"></a>
                </div>
                
                <div class="modal-body">
                    <?php foreach ($datos as $d) { ?>
                        <!-- IDs ocultos necesarios para la actualización -->
                        <input type="hidden" name="id_seguimiento_zoo" value="<?php echo $d['id_seguimiento_zoo']; ?>">
                        <input type="hidden" name="id_sub_actividad" value="<?php echo $d['id_sub_actividad'] ?? ''; ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Código del Seguimiento</label>
                                <input type="text" class="form-control" name="cod_seguimiento" 
                                       value="<?php echo $d['cod_seguimiento']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha</label>
                                <input type="date" class="form-control" name="fecha" 
                                       value="<?php echo $d['fecha']; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo de Pez</label>
                                <select name="tipo_pez" class="form-select" required>
                                    <?php foreach (tipoPez as $tp): ?>
                                        <option value="<?php echo $tp; ?>" <?php echo ($d['tipo_pez'] == $tp) ? 'selected' : ''; ?>>
                                            <?php echo $tp; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo de Alimentación</label>
                                <select name="tipo_alimen" class="form-select" required>
                                    <?php foreach (tipoAlimen as $tA): ?>
                                        <option value="<?php echo $tA; ?>" <?php echo ($d['tipo_alimento'] == $tA) ? 'selected' : ''; ?>>
                                            <?php echo $tA; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="observaciones" 
                                   value="<?php echo $d['observaciones']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_estado" class="form-label">Estado</label>
                            <select class="form-select" id="id_estado" name="id_estado" required>
                                <?php foreach ($estados as $est) { 
                                    $selected = ($d['id_estado'] == $est['id_estado']) ? "selected" : "";
                                    echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                                } ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>

                <div class="modal-footer">
                    <a href="<?php echo getUrl('Historial', 'Historial', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>