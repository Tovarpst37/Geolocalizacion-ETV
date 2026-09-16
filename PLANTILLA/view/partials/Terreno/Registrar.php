<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="width: 100%; max-width: 700px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Terreno</h4>
            </div>

            <div class="card-body p-4">
                <form action="<?php echo getUrl("Terrenos", "Terrenos", "validarRegistrar") ?>" method="POST">

                    <div class="mb-3">
                        <label for="codigo_sitio_deposito" class="form-label">Código del sitio de depósito <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="codigo_sitio_deposito" name="codigo_sitio_deposito" placeholder="Ingresa el código del sitio de depósito" value="<?php echo $old['codigo_sitio_deposito'] ?? ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                        <select class="form-select" id="direccion" name="direccion" required>
                            <option value="" selected disabled>Selecciona una dirección</option>
                            <?php foreach ($direcciones as $dir): ?>
                                <option value="<?php echo $dir['id_direccion']; ?>" <?php echo (($old['direccion'] ?? '') == $dir['id_direccion']) ? 'selected' : ''; ?>><?php echo $dir['direccion_completa']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_tipo_deposito" class="form-label">Tipo de depósito <span class="text-danger">*</span></label>
                        <select class="form-select" id="nombre_tipo_deposito" name="nombre_tipo_deposito" required>
                            <option value="" selected disabled>Selecciona un tipo de depósito</option>
                            <?php foreach ($tipos_deposito as $tipo): ?>
                                <option value="<?php echo $tipo['id_tipo_deposito']; ?>" <?php echo (($old['nombre_tipo_deposito'] ?? '') == $tipo['id_tipo_deposito']) ? 'selected' : ''; ?>><?php echo $tipo['nombre_tipo_deposito']; ?></option>
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