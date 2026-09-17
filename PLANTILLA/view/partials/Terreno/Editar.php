<div class="container mt-2">
    <div class="card mx-auto" style="max-width: 700px;">
        <div class="card-body p-3">
            <?php foreach ($datos as $d) { ?>
                <form action="<?php echo getUrl("Terreno", "Terreno", "validarUpdate") ?>" method="post">

                    <div class="modal-header">
                        <h5 class="modal-title">Editar Terreno</h5>
                        <a href="<?php echo getUrl('Terreno', 'Terreno', 'getConsultar') ?>" class="btn btn-close"></a>
                    </div>

                    <div class="border-top my-4"></div>

                    <input type="hidden" name="id" value="<?php echo $d['id_sitio_deposito']; ?>">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="codigo_sitio_deposito" class="form-label">Código del sitio de depósito <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="codigo_sitio_deposito" name="codigo_sitio_deposito" placeholder="Ingresa el código del sitio de depósito" required value="<?php echo $d['codigo_sitio_deposito']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="nombre_sitio" class="form-label">Sitio <span class="text-danger">*</span></label>
                            <select class="form-select" id="nombre_sitio" name="nombre_sitio" required>
                                <option value="" selected disabled>Selecciona un sitio</option>
                                <?php foreach ($sitios as $sit) {
                                    $selected = ($d['id_sitio'] == $sit['id_sitio']) ? "selected" : "";
                                    echo "<option value='" . $sit['id_sitio'] . "' $selected>" . $sit['nombre_sitio'] . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nombre_tipo_deposito" class="form-label">Tipo de depósito <span class="text-danger">*</span></label>
                            <select class="form-select" id="nombre_tipo_deposito" name="nombre_tipo_deposito" required>
                                <option value="" selected disabled>Selecciona un tipo de depósito</option>
                                <?php foreach ($tipos_deposito as $tipo) {
                                    $selected = ($d['id_tipo_deposito'] == $tipo['id_tipo_deposito']) ? "selected" : "";
                                    echo "<option value='" . $tipo['id_tipo_deposito'] . "' $selected>" . $tipo['nombre'] . "</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="" selected disabled>Selecciona un estado</option>
                                <?php foreach ($estados as $est) {
                                    $selected = ($d['id_estado'] == $est['id_estado']) ? "selected" : "";
                                    echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ingresa una descripción del terreno"><?php echo $d['descripcion']; ?></textarea>
                    </div>

                    <div class="text-muted small mb-3"><span class="text-danger">*</span> Campos obligatorios</div>

                    <div class="modal-footer gap-2">
                        <a href="<?php echo getUrl('Terreno', 'Terreno', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>

                </form>
            <?php } ?>
        </div>
    </div>
</div>