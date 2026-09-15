<div class="container mt-4">
    <!-- Buscador -->
    <div class="d-flex justify-content-end w-100 mb-4">
        <div class="input-group" style="max-width: 350px;">
            <form class="input-group" action="index.php" method="GET">
                <input type="hidden" name="modulo" value="FormularioZ">
                <input type="hidden" name="controlador" value="FormularioZ">
                <input type="hidden" name="funcion" value="getBuscar">

                <input type="text" name="busqueda" placeholder="Buscar por código..." class="form-control" />
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de Seguimientos / Formularios Registrados -->
    <div class="list-group">
        <?php if (!empty($seguimientos)): ?>
            <?php foreach ($seguimientos as $s): ?>
                <div class="list-group-item d-flex flex-column mb-3 border rounded shadow-sm p-3">

                    <!-- Encabezado de la Tarjeta -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div>
                            <h6 class="mb-1 text-primary">
                                <strong>Código Seguimiento:</strong> <?php echo $s['cod_seguimiento']; ?>[cite: 2]
                            </h6>
                            <small class="text-muted d-block">
                                <strong>Fecha:</strong> <?php echo $s['fecha'] ?? 'N/A'; ?>[cite: 2] |
                                <strong>Documento Usuario:</strong> <?php echo $s['documento'] ?? 'N/A'; ?>[cite: 2]
                            </small>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge <?php echo ($s['id_estado'] ?? 1) == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo ($s['id_estado'] ?? 1) == 1 ? 'Activo' : 'Inactivo'; ?>[cite: 2]
                            </span>

                            <!-- Botón para expandir detalle de Alimentación -->
                            <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="collapse"
                                data-bs-target="#detalle-<?php echo $s['id_seguimiento_zoo']; ?>">
                                Ver Detalle
                            </button>

                            <a href="<?php echo getUrl("Historial", "Historial", "getEditar", array('id' => $s['id_seguimiento_zoo'])); ?>"
                                class="btn btn-sm btn-primary">Editar</a>
                        </div>
                    </div>

                    <!-- Detalle colapsable con los datos del Formulario de Alimentación -->
                    <div class="collapse mt-3" id="detalle-<?php echo $s['id_seguimiento_zoo']; ?>">
                        <div class="card card-body bg-light border-0">
                            <h6 class="border-bottom pb-2 text-secondary">Registro de Alimentación / Subactividad</h6>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <strong>Tipo de Pez / Género:</strong>
                                    <p class="mb-0 text-dark">
                                        <?php echo !empty($s['genero']) ? $s['genero'] : 'No registrado'; ?>
                                    </p>[cite: 2]
                                </div>
                                <div class="col-md-4 mb-2">
                                    <strong>Tipo de Alimentación:</strong>
                                    <p class="mb-0 text-dark">
                                        <?php echo !empty($s['tipo_alimento']) ? $s['tipo_alimento'] : 'No registrado'; ?>
                                    </p>
                                    [cite: 2]
                                </div>
                                <div class="col-md-4 mb-2">
                                    <strong>Observaciones:</strong>
                                    <p class="mb-0 text-dark">
                                        <?php echo !empty($s['observaciones']) ? $s['observaciones'] : 'Sin observaciones'; ?>
                                    </p>[cite: 2]
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning text-center">No hay registros de seguimiento disponibles.</div>
        <?php endif; ?>
    </div>
</div>