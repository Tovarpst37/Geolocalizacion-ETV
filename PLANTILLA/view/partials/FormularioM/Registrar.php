<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Formulario</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("FormularioM", "FormularioM", "postInsert") ?>" method="POST">

                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Codigo del Seguimiento</label>
                        <input type="text" class="form-control" id="codM" name="codM"
                            placeholder="Ingrese el codigo del seguimiento" required>
                    </div>


                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Numero de Documento</label>
                        <input type="text" class="form-control" id="docM" name="docM"
                            value="<?php echo $documentoSesion; ?>" readonly required>
                    </div>



                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Cantidad de peces nacidos</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="canpez" name="canpez"
                                placeholder="Cantidad de peces" min="0" max="100" required>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Cantidad de peces machos muertos</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="muerto_Macho" name="muerto_Macho"
                                placeholder="Ingrese el codigo del seguimiento" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Cantidad de peces hembra muertos</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="muerto_Hembra" name="muerto_Hembra"
                                placeholder="Ingrese el codigo del seguimiento" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="obM" name="obM"
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