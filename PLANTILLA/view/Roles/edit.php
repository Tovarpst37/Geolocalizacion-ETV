<style>
#table{
    box-shadow: 0 0 10px rgba(0 0 0 / 30%);
}
</style>
<div class="page-header">
    <div class="mb-3 contenedortext rounded-4">
        <br>
        <div>
            <h1 class="fw-bold text-center ">EDITAR ROL</h1>
        </div>
        <br>
    </div>
    <form action="<?php echo getUrl("Roles","Roles","postEdit")?>" method="POST" id="formRol">
        <input type="hidden" name="id_rol" value="<?php echo $rol['id_rol']; ?>">
        <div class="card">
            <div class="card-body">
                <label for="nombre_rol" class="form-label">Nombre de rol</label>
                <input type="text" class="form-control" id="nombre_rol" name="nombre_rol"
                       value="<?php echo htmlspecialchars($rol['nombre_rol']); ?>">
            </div>
        </div>
        <div class="table-responsive rounded-4 mb-3" id="table">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>Modulos</th>
                        <?php foreach($acciones as $acc): ?>
                            <th><?php echo $acc['nombre_permiso']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($modulos as $modu): ?>
                    <tr>
                        <th><?php echo $modu['nombre_modulo']; ?></th>
                        <?php foreach($acciones as $acc): ?>
                            <td>
                                <?php if (isset($mapa[$modu['id_modulo']][$acc['id_permiso']])):
                                    $idModuloPermiso = $mapa[$modu['id_modulo']][$acc['id_permiso']];
                                    $marcado = in_array($idModuloPermiso, $permisosMarcados);
                                ?>
                                    <input type="checkbox"
                                        name="permisos[]"
                                        value="<?php echo $idModuloPermiso; ?>"
                                        <?php echo $marcado ? 'checked' : ''; ?>>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>

<script src="/assets/js/roles-form.js"></script>