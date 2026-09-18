<div class="container mt-2">
    <div class="card mx-auto" style="max-width: 700px;">
        <div class="card-body p-3">
            <?php foreach ($datos as $d) { ?>
                <form action="<?php echo getUrl("Sitios", "Sitios", "validarUpdate") ?>" method="post">

                    <div class="modal-header">
                        <h5 class="modal-title">Editar Sitio</h5>
                        <a href="<?php echo getUrl('Sitios', 'Sitios', 'getConsultar') ?>" class="btn btn-close"></a>
                    </div>

                    <div class="border-top my-4"></div>

                    <input type="hidden" name="id" value="<?php echo $d['id_sitio']; ?>">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del sitio" required value="<?php echo $d['nombre_sitio']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dirección actual</label>
                            <input type="text" class="form-control" value="<?php echo $d['direccion']; ?>" disabled readonly>
                        </div>
                    </div>

                    <label class="form-label">Nueva dirección</label>
                    <div class="row g-2 mb-3 align-items-center">
                        <div class="col-md-3">
                            <select class="form-select" id="via_principal" name="via_principal" required>
                                <option value="" disabled <?php echo empty($partes['via_principal']) ? 'selected' : ''; ?>>Vía principal *</option>
                                <?php
                                include_once '../controller/Sitios/direcciones.php';
                                foreach (VIA_PRINCIPAL as $v): ?>
                                    <option value="<?php echo $v; ?>" <?php echo ($partes['via_principal'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="numero_via" name="numero_via" required>
                                <option value="" disabled <?php echo empty($partes['numero_via']) ? 'selected' : ''; ?>>Número *</option>
                                <?php foreach ($numero_de_via as $v): ?>
                                    <option value="<?php echo $v; ?>" <?php echo ($partes['numero_via'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="sufijo_via" name="sufijo_via">
                                <option value="" disabled <?php echo empty($partes['sufijo_via']) ? 'selected' : ''; ?>>Sufijo</option>
                                <?php foreach (SUFIJO_VIA as $key => $label): ?>
                                    <option value="<?php echo $key; ?>" <?php echo ($partes['sufijo_via'] == $key) ? 'selected' : ''; ?>><?php echo $key; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-1 text-center">
                            <span class="fs-4 fw-bold">#</span>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="cruce_prefijo" name="cruce_prefijo">
                                <option value="" disabled <?php echo empty($partes['cruce_prefijo']) ? 'selected' : ''; ?>>Prefijo</option>
                                <?php foreach (CRUCE_PREFIJO as $key => $label): ?>
                                    <option value="<?php echo $key; ?>" <?php echo ($partes['cruce_prefijo'] == $key) ? 'selected' : ''; ?>><?php echo $label; ?> (<?php echo $key; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3 align-items-center">
                        <div class="col-md-4">
                            <select class="form-select" id="via_generadora" name="via_generadora" required>
                                <option value="" disabled <?php echo empty($partes['via_generadora']) ? 'selected' : ''; ?>>Vía generadora *</option>
                                <?php foreach ($numero_de_la_via_generadora as $v): ?>
                                    <option value="<?php echo $v; ?>" <?php echo ($partes['via_generadora'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="sufijo_generadora" name="sufijo_generadora">
                                <option value="" disabled <?php echo empty($partes['sufijo_generadora']) ? 'selected' : ''; ?>>Sufijo</option>
                                <?php foreach (SUFIJO_VIA as $key => $label): ?>
                                    <option value="<?php echo $key; ?>" <?php echo ($partes['sufijo_generadora'] == $key) ? 'selected' : ''; ?>><?php echo $key; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-1 text-center">
                            <span class="fs-4 fw-bold">-</span>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="placa" name="placa" required>
                                <option value="" disabled <?php echo empty($partes['placa']) ? 'selected' : ''; ?>>Placa *</option>
                                <?php foreach ($numero_de_placa as $v): ?>
                                    <option value="<?php echo $v; ?>" <?php echo ($partes['placa'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <select class="form-select" id="barrio" name="barrio" required>
                                <option value="" selected disabled>Barrio *</option>
                                <?php foreach ($barrios as $b) {
                                    $selected = ($d['id_barrio'] == $b['id_barrio']) ? "selected" : "";
                                    echo "<option value='" . $b['id_barrio'] . "' $selected>" . $b['nombre_barrio'] . "</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="" selected disabled>Estado *</option>
                                <?php foreach ($estados as $est) {
                                    $selected = ($d['id_estado'] == $est['id_estado']) ? "selected" : "";
                                    echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>

                 
                    <div class="mb-3">
                        <label for="id_tipo_deposito" class="form-label">Tipo de depósito <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_tipo_deposito" name="id_tipo_deposito" required>
                            <option value="" selected disabled>Selecciona un tipo de depósito</option>
                            <?php foreach ($tipos_deposito as $td) {
                                $selected = ($d['id_tipo_deposito'] == $td['id_tipo_deposito']) ? "selected" : "";
                                echo "<option value='" . $td['id_tipo_deposito'] . "' $selected>" . $td['nombre'] . "</option>";
                            } ?>
                        </select>
                    </div>

                    <!-- AGREGADO: descripción (máx. 300 caracteres) -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="300" placeholder="Descripción del sitio (máx. 300 caracteres)"><?php echo $d['descripcion'] ?? ''; ?></textarea>
                        <div class="form-text text-end"><span id="contadorDescripcion">0</span>/300</div>
                    </div>

                    <div class="mb-3">
                        <label for="id_coor" class="form-label">Coordinador asignado</label>
                        <select class="form-select" id="id_coor" name="id_coor">
                            <option value="" <?php echo empty($coor_actual['id_usuario']) ? "selected" : ""; ?>>Ninguno</option>
                            <?php foreach ($coord as $usu) {
                                $selected = (isset($coor_actual['id_usuario']) && $coor_actual['id_usuario'] == $usu['id_usuario']) ? "selected" : "";
                                echo "<option value='" . $usu['id_usuario'] . "' $selected>" .
                                    $usu['primer_nombre'] . " " . $usu['segundo_nombre'] . " " .
                                    $usu['primer_apellido'] . " " . $usu['segundo_apellido'] . "</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Auxiliares asignados</label>
                        <div class="border rounded p-3 overflow-auto" id="auxiliares-container" style="max-height: 250px;">
                            <?php foreach ($auxi as $usu) {
                                $checked = in_array($usu['id_usuario'], $auxi_actuales ?? []) ? "checked" : "";
                            ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="usuarios_asignados[]"
                                        value="<?php echo $usu['id_usuario']; ?>"
                                        id="user<?php echo $usu['id_usuario']; ?>"
                                        <?php echo $checked; ?>>

                                    <label class="form-check-label" for="user<?php echo $usu['id_usuario']; ?>">
                                        <?php echo $usu['primer_nombre'] . " " .
                                            $usu['segundo_nombre'] . " " .
                                            $usu['primer_apellido'] . " " .
                                            $usu['segundo_apellido']; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="text-muted small mb-3"><span class="text-danger">*</span> Campos obligatorios</div>

                    <div class="modal-footer gap-2">
                        <a href="<?php echo getUrl('Sitios', 'Sitios', 'getConsultar') ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>

                </form>
            <?php } ?>
        </div>
    </div>
</div>

<!-- AGREGADO: contador en vivo de caracteres de la descripción -->
<script>
    (function() {
        const textarea = document.getElementById('descripcion');
        const contador = document.getElementById('contadorDescripcion');
        if (textarea && contador) {
            const actualizar = () => contador.textContent = textarea.value.length;
            actualizar();
            textarea.addEventListener('input', actualizar);
        }
    })();
</script>