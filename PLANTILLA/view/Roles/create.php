<style>
#table{
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    background-color: #fff;
    border: 1px solid #dee2e6;
}

#table table {
    border-collapse: collapse;
}

#table thead th {
    text-transform: uppercase;
    font-size: 0.78rem;
    letter-spacing: .04em;
    color: #6c757d;
    font-weight: 600;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    border-right: 1px solid #e9ecef;
}

#table thead th:last-child {
    border-right: none;
}

#table tbody th {
    font-weight: 500;
    color: #212529;
    background-color: #f8f9fa;
    border-right: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
}

#table tbody td {
    border-right: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
}

#table tbody td:last-child {
    border-right: none;
}

#table tbody tr:last-child th,
#table tbody tr:last-child td {
    border-bottom: none;
}

#table td {
    text-align: center;
    vertical-align: middle;
}

#table tbody tr:hover {
    background-color: #f1f6fb;
}

#table input[type="checkbox"] {
    width: 1.2rem;
    height: 1.2rem;
    cursor: pointer;
    border: 2px solid #adb5bd;
    border-radius: 4px;
    accent-color: #4095BF;
    background-color: #fff;
}

#table input[type="checkbox"]:hover {
    border-color: #4095BF;
}

#formRol .card {
    border: 0;
    border-radius: 1rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
}
</style>

<div class="page-header">
    <div class="mb-3 contenedortext rounded-4">
        <br>
        <div class="d-flex align-items-center justify-content-center gap-2">
            <i class="bx bxs-user-detail" style="font-size: 2.5rem; color: #fff;"></i>
            <h1 class="fw-bold mb-0">Crear Rol</h1>
        </div>
        <br>
    </div>
    <form action="<?php echo getUrl("Roles","Roles","postCreate")?>" method="POST" id="formRol">
        <div class="card mb-4">
            <div class="card-body p-4">
                <label for="nombre_rol" class="form-label fw-semibold">Nombre de rol</label>
                <input type="text" class="form-control form-control-lg rounded-3" id="nombre_rol" name="nombre_rol" placeholder="Ej: Administrador, Supervisor...">
            </div>
        </div>

        <h6 class="fw-semibold text-body-secondary mb-2">Permisos por módulo</h6>

        <div class="table-responsive rounded-4 mb-3" id="table">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4 py-3">Módulos</th>
                        <?php foreach($acciones as $acc): ?>
                            <th class="py-3"><?php echo $acc['nombre_permiso']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($modulos as $modu): ?>
                    <tr>
                        <th class="ps-4 py-3"><?php echo $modu['nombre_modulo']; ?></th>
                        <?php foreach($acciones as $acc): ?>
                            <td class="py-3">
                                <?php if (isset($mapa[$modu['id_modulo']][$acc['id_permiso']])): ?>
                                    <input type="checkbox"
                                        class="form-check-input"
                                        name="permisos[]"
                                        value="<?php echo $mapa[$modu['id_modulo']][$acc['id_permiso']]; ?>">
                                <?php else: ?>
                                    <span class="text-body-tertiary">—</span>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary rounded-3 px-4">
                <i class="bi bi-save2 me-1"></i>Guardar
            </button>
        </div>
    </form>
</div>

<script src="../web/assets/js/roles-form.js"></script>