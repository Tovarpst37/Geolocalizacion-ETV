<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h5 class="card-title mb-3">Registrar Sitio</h5>

                <form action="<?php echo getUrl("Sitios", "Sitios", "postInsert") ?>" method="post">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del sitio" required>
                        <div class="invalid-feedback">Por favor ingrese el nombre.</div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ej: Calle 10 # 5-20" required>
                        <div class="invalid-feedback">Por favor ingrese la dirección.</div>
                    </div>

                    <div class="mb-3">
                        <label for="barrio" class="form-label">Barrio</label>
                        <select class="form-select" id="barrio" name="barrio" required>
                            <option value="" selected disabled>Seleccione un barrio</option>
                            <?php foreach ($barrios as $b) {
                                echo "<option value='" . $b['id_barrio'] . "'>" . $b['nombre_barrio'] . "</option>";
                            } ?>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione un barrio.</div>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="" selected disabled>Seleccione un estado</option>
                            <?php foreach ($estados as $est) {
                                echo "<option value='" . $est['id_estado'] . "'>" . $est['nombre_estado'] . "</option>";
                            } ?>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione un estado.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?php echo getUrl('Sitios', 'Sitios', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
                        
                        <a href="<?php echo getUrl('Sitios', 'Sitios', 'postInsert') ?>"><button type="submit" class="btn btn-primary">Guardar</button></a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>