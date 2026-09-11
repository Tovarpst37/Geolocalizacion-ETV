<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Sitio</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("Sitios", "Sitios", "postInsert") ?>" method="POST">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del sitio" required>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ej: Calle 10 # 5-20" required>
                    </div>

                    <div class="mb-3">
                        <label for="barrio" class="form-label">Barrio</label>
                        <select class="form-select" id="barrio" name="barrio" required>
                            <option value="" selected disabled>Selecciona un barrio</option>
                            <?php foreach ($barrios as $b): ?>
                                <option value="<?php echo $b['id_barrio']; ?>">
                                    <?php echo $b['nombre_barrio']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="" selected disabled>Selecciona un estado</option>
                            <?php foreach ($estados as $est): ?>
                                <option value="<?php echo $est['id_estado']; ?>">
                                    <?php echo $est['nombre_estado']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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