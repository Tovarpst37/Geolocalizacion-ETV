<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Formulario</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("FormularioLi", "FormularioLi", "postInsert") ?>" method="POST">

                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Codigo del seguimiento</label>
                        <input type="text" class="form-control" id="coLi" name="coLi"
                            placeholder="Ingrese el codigo del seguimiento" required>
                    </div>

                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Numero de dociumento</label>
                        <input type="text" class="form-control" id="docLi" name="docLi"
                            placeholder="Ingrese el numero de documento" required>
                    </div>


                    <div class="mb-3">
                        <label for="fecha_hora" class="form-label">Fecha y hora de Limpieza</label>
                        <span class="icono">
                            <i class="fa-solid fa-calender">
                            </i>
                        </span>
                        <input type="datetime-local" class="form-control" id="fecha_horaLi" name="fecha_horaLi"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="formulariopez" class="form-label">Tipo de Limpieza</label>

                        <select class="form-control" id="limpieza" name="limpieza[]">

                            <option value="esponja">Esponja</option>
                            <option value="aspirar">aspirar con manguera</option>
                            <option value="succionador">Succionador</option>

                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="formularioAli" class="form-label">Tipo de Alimentación</label>
                        <select name="tipo_alimen" id="tipo_alimen" class="form-control"></select>
                        <option value=""></option>
                    </div>


                    <div class="mb-3">
                        <label for="obser" class="form-label">Observaciones</label>
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