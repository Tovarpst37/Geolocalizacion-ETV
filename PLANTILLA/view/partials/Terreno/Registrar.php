<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Terreno</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("Terreno", "Terreno", "validarRegistrar") ?>" method="POST">

                    <div class="mb-3">
                        <label for="codigo_sitio_deposito" class="form-label">Código de terreno <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="codigo_sitio_deposito" name="codigo_sitio_deposito" placeholder="Ingresa el código del terreno" value="<?php echo $old['codigo_sitio_deposito'] ?? ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_sitio" class="form-label">Sitio <span class="text-danger">*</span></label>
                        <select class="form-select" id="nombre_sitio" name="nombre_sitio" required>
                            <option value="" selected disabled>Selecciona un sitio</option>
                            <?php foreach ($sitios as $sit): ?>
                                <option value="<?php echo $sit['id_sitio']; ?>" <?php echo (($old['nombre_sitio'] ?? '') == $sit['id_sitio']) ? 'selected' : ''; ?>><?php echo $sit['nombre_sitio']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_tipo_deposito" class="form-label">Tipo de depósito <span class="text-danger">*</span></label>
                        <select class="form-select" id="nombre_tipo_deposito" name="nombre_tipo_deposito" required>
                            <option value="" selected disabled>Selecciona un tipo de depósito</option>
                            <?php foreach ($tipos_deposito as $tipo): ?>
                                <option value="<?php echo $tipo['id_tipo_deposito']; ?>" <?php echo (($old['nombre'] ?? '') == $tipo['id_tipo_deposito']) ? 'selected' : ''; ?>><?php echo $tipo['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="" selected disabled>Selecciona un estado</option>
                            <?php foreach ($estados as $est): ?>
                                <option value="<?php echo $est['id_estado']; ?>" <?php echo (($old['estado'] ?? '') == $est['id_estado']) ? 'selected' : ''; ?>><?php echo $est['nombre_estado']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ingresa una descripción del terreno"><?php echo $old['descripcion'] ?? ''; ?></textarea>
                    </div>

                    <div class="text-muted small mb-3"><span class="text-danger">*</span> Campos obligatorios</div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
                        <button type="submit" class="btn btn-primary">Guardar Terreno</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>