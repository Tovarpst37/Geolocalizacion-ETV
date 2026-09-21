<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Inspección</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("FormularioInsp", "FormularioInsp", "postInsert") ?>" method="POST">

                    <div class="mb-3">
                        <label for="codSeg" class="form-label">Código del seguimiento</label>
                        <select class="form-select" id="codSeg" name="codSeg" required>
                            <option value="" selected disabled>Selecciona un seguimiento</option>
                            <?php foreach ($seguimientos as $seg): ?>
                                <option value="<?php echo $seg['cod_seguimiento']; ?>">
                                    <?php echo $seg['cod_seguimiento']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="documen" class="form-label">Número de documento</label>
                        <input type="text" class="form-control" id="documen" name="documen"
                            value="<?php echo $documentoSesion; ?>" readonly required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_horaInsp" class="form-label">Fecha y hora de inspección</label>
                        <span class="icono">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>
                        <input type="datetime-local" class="form-control" id="fecha_horaInsp" name="fecha_horaInsp"
                            min="<?php echo date('Y-m-d\T00:00', strtotime('-3 days')); ?>"
                            max="<?php echo date('Y-m-d\T23:59', strtotime('+1 day')); ?>" onkeydown="return false;"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Depósitos permanentes de agua detectados</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="depositoDetectado" id="depositoSi"
                                value="1" required>
                            <label class="form-check-label" for="depositoSi">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="depositoDetectado" id="depositoNo"
                                value="0">
                            <label class="form-check-label" for="depositoNo">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phMedido" class="form-label">PH medido</label>
                        <input type="number" step="0.01" class="form-control" id="phMedido" name="phMedido"
                            placeholder="Ingrese el PH medido" required>
                    </div>

                    <div class="mb-3">
                        <label for="temperatura" class="form-label">Temperatura (T) medida</label>
                        <input type="number" step="0.01" class="form-control" id="temperatura" name="temperatura"
                            placeholder="Ingrese la temperatura" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Presencia de larvas de zancudos</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="presenciaLarvas" id="larvasSi" value="1"
                                required>
                            <label class="form-check-label" for="larvasSi">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="presenciaLarvas" id="larvasNo" value="0">
                            <label class="form-check-label" for="larvasNo">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="obserInsp" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="obserInsp" name="obserInsp"
                            placeholder="Ingrese las observaciones" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary">Cancelar registro</button>
                        <button type="submit" class="btn btn-primary">Guardar registro</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>