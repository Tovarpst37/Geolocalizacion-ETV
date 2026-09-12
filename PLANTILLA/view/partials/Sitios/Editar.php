<div class="modal show" id="modalEditar" tabindex="-1" style="display:block;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistroLabel">Editar Sitio</h5>
                <a href="<?php echo getUrl('Sitios', 'Sitios', 'getConsultar') ?>">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </a>
            </div>
            <div class="modal-body">
                <?php foreach ($datos as $d) { ?>
                    <form action="<?php echo getUrl("Sitios", "Sitios", "validarUpdate") ?>" method="post">

                        <input type="hidden" name="id" value="<?php echo $d['id_sitio']; ?>">

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del sitio" required value="<?php echo $old['nombre'] ?? $d['nombre_sitio']; ?>">

                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Dirección actual</label>
                                <input type="text" class="form-control" value="<?php echo $d['direccion']; ?>" disabled readonly>
                            </div>

                            <label class="form-label">Nueva dirección</label>
                            <div class="row g-2 mb-3 align-items-center">
                                <div class="col-md-3">
                                    <select class="form-select" id="via_principal" name="via_principal" required>
                                        <option value="" disabled <?php echo empty($partes['via_principal']) ? 'selected' : ''; ?>>Vía principal *</option>
                                        <?php
                                        include_once '../controller/Sitios/direcciones.php';
                                        foreach (VIA_PRINCIPAL as $v): ?>
                                            <option value="<?php echo $v; ?>" <?php echo (($old['via_principal'] ?? $partes['via_principal']) == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="numero_via" name="numero_via" required>
                                        <option value="" disabled <?php echo empty($partes['numero_via']) ? 'selected' : ''; ?>>Número *</option>
                                        <?php foreach ($numero_de_via as $v): ?>
                                            <option value="<?php echo $v; ?>" <?php echo (($old['numero_via'] ?? $partes['numero_via']) == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" id="sufijo_via" name="sufijo_via">
                                        <option value="" disabled <?php echo empty($partes['sufijo_via']) ? 'selected' : ''; ?>>Sufijo</option>
                                        <?php foreach (SUFIJO_VIA as $key => $label): ?>
                                            <option value="<?php echo $key; ?>" <?php echo (($old['sufijo_via'] ?? $partes['sufijo_via']) == $key) ? 'selected' : ''; ?>><?php echo $key; ?></option>
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
                                            <option value="<?php echo $key; ?>" <?php echo (($old['cruce_prefijo'] ?? $partes['cruce_prefijo']) == $key) ? 'selected' : ''; ?>><?php echo $label; ?> (<?php echo $key; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>


                            <div class="row g-2 mb-3 align-items-center">
                                <div class="col-md-4">
                                    <select class="form-select" id="via_generadora" name="via_generadora" required>
                                        <option value="" disabled <?php echo empty($partes['via_generadora']) ? 'selected' : ''; ?>>Vía generadora *</option>
                                        <?php foreach ($numero_de_la_via_generadora as $v): ?>
                                            <option value="<?php echo $v; ?>" <?php echo (($old['via_generadora'] ?? $partes['via_generadora']) == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="sufijo_generadora" name="sufijo_generadora">
                                        <option value="" disabled <?php echo empty($partes['sufijo_generadora']) ? 'selected' : ''; ?>>Sufijo</option>
                                        <?php foreach (SUFIJO_VIA as $key => $label): ?>
                                            <option value="<?php echo $key; ?>" <?php echo (($old['sufijo_generadora'] ?? $partes['sufijo_generadora']) == $key) ? 'selected' : ''; ?>><?php echo $key; ?></option>
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
                                            <option value="<?php echo $v; ?>" <?php echo (($old['placa'] ?? $partes['placa']) == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <select class="form-select" id="barrio" name="barrio" required>
                                        <option value="" selected disabled>Barrio *</option>
                                        <?php foreach ($barrios as $b) {
                                            $selected = (($old['barrio'] ?? $d['id_barrio']) == $b['id_barrio']) ? "selected" : "";
                                            echo "<option value='" . $b['id_barrio'] . "' $selected>" . $b['nombre_barrio'] . "</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="" selected disabled>Estado *</option>
                                        <?php foreach ($estados as $est) {
                                            $selected = (($old['estado'] ?? $d['id_estado']) == $est['id_estado']) ? "selected" : "";
                                            echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="text-muted small mb-3"><span class="text-danger">*</span> Campos obligatorios</div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>

                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>