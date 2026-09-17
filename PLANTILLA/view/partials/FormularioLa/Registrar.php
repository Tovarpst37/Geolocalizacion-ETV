<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Formulario</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("FormularioLa", "FormularioLa", "postInsert") ?>" method="POST">

                    <div class="mb-3">
                        <label for="codLa" class="form-label">Código del tanque</label>
                        <input type="text" class="form-control" id="codLa" name="codLa"
                            placeholder="Ingrese el codigo del tanque" required>
                    </div>

                    <div class="mb-3">
                        <label for="docLa" class="form-label">Número de documento</label>
                        <input type="text" class="form-control" id="docLa" name="docLa"
                            placeholder="Ingrese el numero de documento" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_horaLa" class="form-label">Fecha y hora de lavado</label>
                        <span class="icono">
                            <i class="fa-solid fa-calendar"></i>
                        </span>
                        <input type="datetime-local" class="form-control" id="fecha_horaLa" name="fecha_horaLa"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="porcAgua" class="form-label">Porcentaje de agua cambiada</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="porcAgua" name="porcAgua" placeholder="Ej. 20"
                                min="0" max="100" required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="estadoTanque" class="form-label">Estado del tanque</label>
                        <input type="text" class="form-control" id="estadoTanque" name="estadoTanque"
                            placeholder="Ingrese el estado del tanque" required>
                    </div>

                    <div class="mb-3">
                        <label for="obLa" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="obLa" name="obLa"
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