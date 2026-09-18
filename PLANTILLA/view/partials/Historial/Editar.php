<div class="modal show" tabindex="-1" style="display:block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <?php if (!$seguimiento): ?>
                <div class="modal-body">
                    <div class="alert alert-danger">No se encontró el seguimiento solicitado.</div>
                </div>
            <?php else: ?>
            <form action="<?php echo getUrl('Historial', 'Historial', 'postUpdate'); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Historial - Código: <?php echo $seguimiento['cod_seguimiento']; ?></h5>
                    <a href="<?php echo getUrl('Historial', 'Historial', 'getConsultar') ?>" class="btn-close"></a>
                </div>

                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                    <input type="hidden" name="id_seguimiento_zoo" value="<?php echo $seguimiento['id_seguimiento_zoo']; ?>">

                    <!-- Datos generales -->
                    <h6 class="text-primary">Datos generales</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Código del Seguimiento</label>
                            <input type="text" class="form-control" name="cod_seguimiento"
                                   value="<?php echo $seguimiento['cod_seguimiento']; ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="fecha"
                                   value="<?php echo $seguimiento['fecha']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="id_estado" required>
                                <?php foreach ($estados as $est) {
                                    $selected = ($seguimiento['id_estado'] == $est['id_estado']) ? "selected" : "";
                                    echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <!-- Alimentación -->
                    <h6 class="text-primary">Alimentación</h6>
                    <input type="hidden" name="id_sub_alimentacion" value="<?php echo $alimentacion['id_sub_actividad'] ?? ''; ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de Pez</label>
                            <select name="tipo_pez" class="form-select">
                                <option value="">-- No aplica --</option>
                                <?php foreach (tipoPez as $tp): ?>
                                    <option value="<?php echo $tp; ?>" <?php echo (($alimentacion['genero'] ?? '') == $tp) ? 'selected' : ''; ?>>
                                        <?php echo $tp; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de Alimentación</label>
                            <select name="tipo_alimen" class="form-select">
                                <option value="">-- No aplica --</option>
                                <?php foreach (tipoAlimen as $tA): ?>
                                    <option value="<?php echo $tA; ?>" <?php echo (($alimentacion['tipo_alimento'] ?? '') == $tA) ? 'selected' : ''; ?>>
                                        <?php echo $tA; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de alimentación</label>
                            <input type="date" class="form-control" name="fecha_alimentacion"
                                   value="<?php echo $alimentacion['fecha_alimentacion'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="obser_alimentacion"
                                   value="<?php echo $alimentacion['obser_alimentacion'] ?? ''; ?>">
                        </div>
                    </div>

                    <hr>

                    <!-- Peces muertos / nacidos -->
                    <h6 class="text-primary">Peces muertos y nacidos</h6>
                    <input type="hidden" name="id_sub_canpeces" value="<?php echo $canpeces['id_sub_actividad'] ?? ''; ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Peces nacidos</label>
                            <input type="number" class="form-control" name="canpez"
                                   value="<?php echo $canpeces['can_peces_nacido'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Machos muertos</label>
                            <input type="number" class="form-control" name="muerto_Macho"
                                   value="<?php echo $canpeces['can_peces_mertos_macho'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Hembras muertas</label>
                            <input type="number" class="form-control" name="muerto_Hembra"
                                   value="<?php echo $canpeces['can_peces_mertos_hembra'] ?? ''; ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="obser_canpeces"
                                   value="<?php echo $canpeces['obser_canpeces'] ?? ''; ?>">
                        </div>
                    </div>

                    <hr>

                    <!-- Limpieza -->
                    <h6 class="text-primary">Limpieza</h6>
                    <input type="hidden" name="id_sub_limpieza" value="<?php echo $limpieza['id_sub_actividad'] ?? ''; ?>">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="estregarParedes" id="estregarParedes"
                                    <?php echo (!empty($limpieza['estregar_paredes']) && $limpieza['estregar_paredes'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="estregarParedes">Estregar paredes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="aspirar" id="aspirar"
                                    <?php echo (!empty($limpieza['aspirar']) && $limpieza['aspirar'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="aspirar">Aspirar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="succionador" id="succionador"
                                    <?php echo (!empty($limpieza['succionador']) && $limpieza['succionador'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="succionador">Succionador</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de limpieza</label>
                            <input type="datetime-local" class="form-control" name="fecha_limpieza"
                                   value="<?php echo $limpieza['fecha_limpieza'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="obser_limpieza"
                                   value="<?php echo $limpieza['obser_limpieza'] ?? ''; ?>">
                        </div>
                    </div>

                    <hr>

                    <!-- Ajuste de nivel -->
                    <h6 class="text-primary">Ajuste de nivel</h6>
                    <input type="hidden" name="id_sub_ajuste" value="<?php echo $ajuste['id_sub_actividad'] ?? ''; ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nivel de agua adicionado</label>
                            <input type="number" class="form-control" name="nivelAgua"
                                   value="<?php echo $ajuste['adicion_nivel_agua'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">PH medido</label>
                            <input type="number" step="0.01" class="form-control" name="ph"
                                   value="<?php echo $ajuste['medicion_ph'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Temperatura</label>
                            <input type="number" step="0.01" class="form-control" name="temp"
                                   value="<?php echo $ajuste['medicion_temperatura'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de ajuste</label>
                            <input type="datetime-local" class="form-control" name="fecha_ajuste"
                                   value="<?php echo $ajuste['fecha_ajuste'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="obser_ajuste"
                                   value="<?php echo $ajuste['obser_ajuste'] ?? ''; ?>">
                        </div>
                    </div>

                    <hr>

                    <!-- Lavado -->
                    <h6 class="text-primary">Lavado</h6>
                    <input type="hidden" name="id_sub_lavado" value="<?php echo $lavado['id_sub_actividad'] ?? ''; ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estado del tanque</label>
                            <input type="text" class="form-control" name="estadoTanque"
                                   value="<?php echo $lavado['estado_tanque'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Porcentaje de agua cambiada</label>
                            <input type="number" class="form-control" name="porcAgua"
                                   value="<?php echo $lavado['agua_cambiada'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de lavado</label>
                            <input type="datetime-local" class="form-control" name="fecha_lavado"
                                   value="<?php echo $lavado['fecha_lavado'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="obser_lavado"
                                   value="<?php echo $lavado['obser_lavado'] ?? ''; ?>">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <a href="<?php echo getUrl('Historial', 'Historial', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>