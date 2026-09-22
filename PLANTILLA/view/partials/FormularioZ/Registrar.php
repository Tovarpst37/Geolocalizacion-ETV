<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Formulario</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("FormularioZ", "FormularioZ", "postInsert") ?>" method="POST">

                    <div class="mb-3">
                        <label for="codigose" class="form-label">Código del seguimiento</label>
                        <select class="form-select" id="codigose" name="codigose" required>
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
                        <label for="fecha_hora" class="form-label">Fecha y hora de alimentación</label>
                        <span class="icono">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>
                        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora"
                            min="<?php echo date('Y-m-d\T00:00', strtotime('-3 days')); ?>"
                            max="<?php echo date('Y-m-d\T23:59', strtotime('+1 day')); ?>" onkeydown="return false;"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="formulariopez" class="form-label">Tipo de peces</label>
                        <select name="tipo_pez" id="tipo_pez" class="form-control">
                            <?php
                            include_once '../model/Formularioz/tipoPez.php';
                            foreach (tipoPez as $tp): ?>
                                <option value="<?php echo $tp; ?>" <?php echo (($old['tipo_pez'] ?? '') == $tp) ? 'selected' : ''; ?>><?php echo $tp; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="formularioAli" class="form-label">Tipo de Alimentación</label>
                        <select name="tipo_alimen" id="tipo_alimen" class="form-control">
                            <?php
                            include_once '../model/Formularioz/tipoAlimen.php';
                            foreach (tipoAlimen as $tA): ?>
                                <option value="<?php echo $tA; ?>" <?php echo (($old['tipo_alimen'] ?? '') == $tA) ? 'selected' : ''; ?>><?php echo $tA; ?></option>
                            <?php endforeach; ?>
                        </select>
                       

                    </div>

                    <div class="mb-3">
                        <label for="alimenObser" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="ob" name="ob"
                            placeholder="Ingrese el codigo del seguimiento" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
                        <button type="submit" class="btn btn-primary">Guardar Sitio</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>