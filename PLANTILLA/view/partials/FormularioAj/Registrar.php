<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Formulario</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("FormularioAj", "FormularioAj", "postInsert") ?>" method="POST">

                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Codigo del seguimiento</label>
                        <input type="text" class="form-control" id="codAj" name="codAj"
                            placeholder="Ingrese el codigo del seguimiento" required>
                    </div>


                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Numero de documento</label>
                        <input type="text" class="form-control" id="num" name="num"
                            placeholder="Ingrese el numero de documento" required>
                    </div>



                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Nivel de agua adicionado</label>
                        <input type="text" class="form-control" id="nv" name="nv"
                            placeholder="Ingrese la adicción proporcionada al tanque" required>
                    </div>

                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">PH medido</label>
                        <input type="text" class="form-control" id="ph" name="ph" placeholder="Ingrese el Ph del tanque"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Temperatura</label>
                        <input type="text" class="form-control" id="tem" name="tem" placeholder="Ingrese la temperatura"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="formulariocod" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="ob" name="ob"
                            placeholder="Ingrese las observaciones" required>
                    </div>



                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary">Lavado</button>
                        <button type="submit" class="btn btn-primary">Guardar Sitio</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>