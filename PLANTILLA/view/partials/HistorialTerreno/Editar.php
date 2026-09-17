<div class="modal show" tabindex="-1" style="display:block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <?php if (!$seguimiento): ?>
                <div class="modal-body">
                    <div class="alert alert-danger">No se encontró el seguimiento solicitado.</div>
                </div>
            <?php else: ?>
            <form action="<?php echo getUrl('HistorialTerreno', 'HistorialTerreno', 'postUpdate'); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Historial - Código: <?php echo $seguimiento['cod_seguimiento']; ?></h5>
                    <a href="<?php echo getUrl('HistorialTerreno', 'HistorialTerreno', 'getConsultar') ?>" class="btn-close"></a>
                </div>

                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                    <input type="hidden" name="id_seguimiento_terreno" value="<?php echo $seguimiento['id_seguimiento_terreno']; ?>">

                    <!-- Datos generales -->
                    <h6 class="text-primary">Datos generales</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Código del Seguimiento</label>
                            <input type="text" class="form-control" name="cod_seguimiento"
                                   value="<?php echo $seguimiento['cod_seguimiento']; ?>" required>
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

                    <!-- Inspección -->
                    <h6 class="text-primary">Inspección</h6>
                    <input type="hidden" name="id_sub_inspeccion" value="<?php echo $inspeccion['id_sub_actividad'] ?? ''; ?>">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="depositoDetectado" id="depositoDetectado"
                                    <?php echo (!empty($inspeccion['deposito_agua_detectado']) && $inspeccion['deposito_agua_detectado'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="depositoDetectado">Depósito de agua detectado</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="presenciaLarvasInsp" id="presenciaLarvasInsp"
                                    <?php echo (!empty($inspeccion['presencia_larvas_inspeccion']) && $inspeccion['presencia_larvas_inspeccion'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="presenciaLarvasInsp">Presencia de larvas</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Temperatura</label>
                            <input type="number" step="0.01" class="form-control" name="temperatura"
                                   value="<?php echo $inspeccion['temperatura'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">PH medido</label>
                            <input type="number" step="0.01" class="form-control" name="phMedido"
                                   value="<?php echo $inspeccion['ph_medido'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha de inspección</label>
                            <input type="datetime-local" class="form-control" name="fecha_inspeccion"
                                   value="<?php echo $inspeccion['fecha_inspeccion'] ?? ''; ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="obser_inspeccion"
                                   value="<?php echo $inspeccion['obser_inspeccion'] ?? ''; ?>">
                        </div>
                    </div>

                    <hr>

                    <!-- Siembra -->
                    <h6 class="text-primary">Siembra</h6>
                    <input type="hidden" name="id_sub_siembra" value="<?php echo $siembra['id_sub_actividad'] ?? ''; ?>">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="presenciaLarvasSiembra" id="presenciaLarvasSiembra"
                                    <?php echo (!empty($siembra['presencia_larvas_siembra']) && $siembra['presencia_larvas_siembra'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="presenciaLarvasSiembra">Presencia de larvas</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="presenciaPecesSiembra" id="presenciaPecesSiembra"
                                    <?php echo (!empty($siembra['presencia_peces_siembra']) && $siembra['presencia_peces_siembra'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="presenciaPecesSiembra">Presencia de peces</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tiempo de aclimatación (min)</label>
                            <input type="number" class="form-control" name="tiempoAclimatacion"
                                   value="<?php echo $siembra['tiempo_aclimatacion'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Peces empacados</label>
                            <input type="number" class="form-control" name="canEmpacados"
                                   value="<?php echo $siembra['can_peces_empacados'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Litros utilizados</label>
                            <input type="number" step="0.01" class="form-control" name="litrosUtilizados"
                                   value="<?php echo $siembra['litros_utilizados'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Hembras sembradas</label>
                            <input type="number" class="form-control" name="canHembrasSiembra"
                                   value="<?php echo $siembra['can_hembras_sembradas'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Machos sembrados</label>
                            <input type="number" class="form-control" name="canMachosSiembra"
                                   value="<?php echo $siembra['can_machos_sembrados'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Guppies sembrados</label>
                            <input type="number" class="form-control" name="canGuppiesSiembra"
                                   value="<?php echo $siembra['can_peces_guppies_sembrados'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de siembra</label>
                            <input type="datetime-local" class="form-control" name="fecha_siembra"
                                   value="<?php echo $siembra['fecha_siembra'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="obser_siembra"
                                   value="<?php echo $siembra['obser_siembra'] ?? ''; ?>">
                        </div>
                    </div>

                    <hr>

                    <!-- Seguimiento -->
                    <h6 class="text-primary">Seguimiento</h6>
                    <input type="hidden" name="id_sub_seguimiento" value="<?php echo $seguimientoDetalle['id_sub_actividad'] ?? ''; ?>">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="depositoVisitado" id="depositoVisitado"
                                    <?php echo (!empty($seguimientoDetalle['deposito_agua_visitado']) && $seguimientoDetalle['deposito_agua_visitado'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="depositoVisitado">Depósito de agua visitado</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="presenciaLarvasSeg" id="presenciaLarvasSeg"
                                    <?php echo (!empty($seguimientoDetalle['presencia_larvas_seguimiento']) && $seguimientoDetalle['presencia_larvas_seguimiento'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="presenciaLarvasSeg">Presencia de larvas</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="presenciaPecesSeg" id="presenciaPecesSeg"
                                    <?php echo (!empty($seguimientoDetalle['presencia_peces_seguimiento']) && $seguimientoDetalle['presencia_peces_seguimiento'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="presenciaPecesSeg">Presencia de peces</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Número de visita</label>
                            <select class="form-control" name="numeroVisita">
                                <option value="1" <?php echo (($seguimientoDetalle['numero_visita'] ?? '') == 1) ? 'selected' : ''; ?>>1ra visita</option>
                                <option value="2" <?php echo (($seguimientoDetalle['numero_visita'] ?? '') == 2) ? 'selected' : ''; ?>>2da visita</option>
                            </select>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Fecha de seguimiento</label>
                            <input type="datetime-local" class="form-control" name="fecha_seguimiento"
                                   value="<?php echo $seguimientoDetalle['fecha_seguimiento'] ?? ''; ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="obser_seguimiento"
                                   value="<?php echo $seguimientoDetalle['obser_seguimiento'] ?? ''; ?>">
                        </div>
                    </div>

                    <hr>

                    <!-- Resiembra -->
                    <h6 class="text-primary">Resiembra</h6>
                    <input type="hidden" name="id_sub_resiembra" value="<?php echo $resiembra['id_sub_actividad'] ?? ''; ?>">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="presenciaLarvasResi" id="presenciaLarvasResi"
                                    <?php echo (!empty($resiembra['presencia_larvas_resiembra']) && $resiembra['presencia_larvas_resiembra'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="presenciaLarvasResi">Presencia de larvas</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="presenciaPecesResi" id="presenciaPecesResi"
                                    <?php echo (!empty($resiembra['presencia_peces_resiembra']) && $resiembra['presencia_peces_resiembra'] !== 'f') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="presenciaPecesResi">Presencia de peces</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Hembras sembradas</label>
                            <input type="number" class="form-control" name="canHembrasResi"
                                   value="<?php echo $resiembra['can_hembras_sembradas'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Machos sembrados</label>
                            <input type="number" class="form-control" name="canMachosResi"
                                   value="<?php echo $resiembra['can_machos_sembrados'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Guppies sembrados</label>
                            <input type="number" class="form-control" name="canGuppiesResi"
                                   value="<?php echo $resiembra['can_peces_guppies_sembrados'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de resiembra</label>
                            <input type="datetime-local" class="form-control" name="fecha_resiembra"
                                   value="<?php echo $resiembra['fecha_resiembra'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="obser_resiembra"
                                   value="<?php echo $resiembra['obser_resiembra'] ?? ''; ?>">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <a href="<?php echo getUrl('HistorialTerreno', 'HistorialTerreno', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>