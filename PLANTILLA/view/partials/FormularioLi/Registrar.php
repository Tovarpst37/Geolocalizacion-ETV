<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Formulario</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("FormularioLi", "FormularioLi", "postInsert") ?>" method="POST">

                    <div class="mb-3">
                        <label for="coLi" class="form-label">Codigo del seguimiento</label>
                        <input type="text" class="form-control" id="coLi" name="coLi"
                            placeholder="Ingrese el codigo del seguimiento" required>
                    </div>

                    <div class="mb-3">
                        <label for="docLi" class="form-label">Numero de documento</label>
                        <input type="text" class="form-control" id="docLi" name="docLi"
                            placeholder="Ingrese el numero de documento" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_horaLi" class="form-label">Fecha y hora de Limpieza</label>
                        <span class="icono">
                            <i class="fa-solid fa-calendar"></i>
                        </span>
                        <input type="datetime-local" class="form-control" id="fecha_horaLi" name="fecha_horaLi"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de Limpieza</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="estregarParedes" name="estregarParedes"
                                value="1">
                            <label class="form-check-label" for="estregarParedes">Sí, estregar paredes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="aspirar" name="aspirar" value="1">
                            <label class="form-check-label" for="aspirar">Sí, aspirar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="succionador" name="succionador"
                                value="1">
                            <label class="form-check-label" for="succionador">Sí, succionador</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="obserLi" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="obserLi" name="obserLi"
                            placeholder="Ingrese las observaciones" required>
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