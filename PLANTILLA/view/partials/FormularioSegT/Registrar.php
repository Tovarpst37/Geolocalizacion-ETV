<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Seguimiento</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("FormularioSegT", "FormularioSegT", "postInsert") ?>" method="POST">

                    <div class="mb-3">
                        <label for="codSeg" class="form-label">Código de seguimiento</label>
                        <input type="text" class="form-control" id="codSeg" name="codSeg"
                            placeholder="Ingrese el codigo de seguimiento" required>
                    </div>

                    <div class="mb-3">
                        <label for="documen" class="form-label">Número de documento</label>
                        <input type="text" class="form-control" id="documen" name="documen"
                            value="<?php echo $documentoSesion; ?>" readonly required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_horaSeg" class="form-label">Fecha y hora de seguimiento</label>
                        <span class="icono">
                            <i class="fa-solid fa-calendar"></i>
                        </span>
                        <input type="datetime-local" class="form-control" id="fecha_horaSeg" name="fecha_horaSeg"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="numeroVisita" class="form-label">Número de visita de seguimiento</label>
                        <select class="form-control" id="numeroVisita" name="numeroVisita" required>
                            <option value="1">1ra visita</option>
                            <option value="2">2da visita</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Depósitos permanentes con agua visitados</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="depositoVisitado" id="depVisSi" value="1"
                                required>
                            <label class="form-check-label" for="depVisSi">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="depositoVisitado" id="depVisNo"
                                value="0">
                            <label class="form-check-label" for="depVisNo">No</label>
                        </div>
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
                        <label for="obserSeg" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="obserSeg" name="obserSeg"
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