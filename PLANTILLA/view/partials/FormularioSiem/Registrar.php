<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Siembra</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("FormularioSiem", "FormularioSiem", "postInsert") ?>" method="POST">

 

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
                        <label for="fecha_horaSiem" class="form-label">Fecha y hora de siembra</label>
                        <span class="icono">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>
                        <input type="datetime-local" class="form-control" id="fecha_horaSiem" name="fecha_horaSiem"
                            min="<?php echo date('Y-m-d\T00:00', strtotime('-3 days')); ?>"
                            max="<?php echo date('Y-m-d\T23:59', strtotime('+1 day')); ?>" onkeydown="return false;"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="pecesEmpacados" class="form-label">Cantidad de peces empacados en bolsas
                            plásticas</label>
                        <input type="number" class="form-control" id="pecesEmpacados" name="pecesEmpacados"
                            placeholder="Ingrese la cantidad de peces empacados" required>
                    </div>

                    <div class="mb-3">
                        <label for="tiempoAclimat" class="form-label">Tiempo de aclimatación (minutos)</label>
                        <input type="number" class="form-control" id="tiempoAclimat" name="tiempoAclimat"
                            placeholder="Ingrese el tiempo de aclimatación" required>
                    </div>

                    <div class="mb-3">
                        <label for="hembrasSembradas" class="form-label">Cantidad de hembras sembradas</label>
                        <input type="number" class="form-control" id="hembrasSembradas" name="hembrasSembradas"
                            placeholder="Ingrese la cantidad de hembras sembradas" required>
                    </div>

                    <div class="mb-3">
                        <label for="machosSembrados" class="form-label">Cantidad de machos sembrados</label>
                        <input type="number" class="form-control" id="machosSembrados" name="machosSembrados"
                            placeholder="Ingrese la cantidad de machos sembrados" required>
                    </div>

                    <div class="mb-3">
                        <label for="litrosAgua" class="form-label">Volumen de agua utilizado (L)</label>
                        <input type="number" step="0.01" class="form-control" id="litrosAgua" name="litrosAgua"
                            placeholder="Ingrese el volumen de agua utilizado" required>
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
                        <label class="form-label d-block">Presencia de peces</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="presenciaPeces" id="pecesSi" value="1"
                                required>
                            <label class="form-check-label" for="pecesSi">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="presenciaPeces" id="pecesNo" value="0">
                            <label class="form-check-label" for="pecesNo">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="obserSiem" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="obserSiem" name="obserSiem"
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