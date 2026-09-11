<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Formulario</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("FormularioZ", "FormularioZ", "postInsert") ?>" method="POST">

                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Codigo</label>
                        <input type="text" class="form-control" id="formularioz" name="formularioz"
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

fomularioZoocriadero