<div class="page-header">
    <div class="mb-3 contenedortext rounded-4">
        <br>
        <div>
            <h1 class="fw-bold text-center ">Roles</h1>
        </div>
        <br>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Id Rol</th>
                            <th>Nombre Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($roles as $rol): ?>
                        <tr>
                            <td><?php echo $rol['id_rol']; ?></td>
                            <td><?php echo $rol['nombre_rol']; ?></td>
                            <td>
                                <a href="<?php echo getUrl("Roles","Roles","getEdit") . "&id_rol=" . $rol['id_rol']; ?>"
                                   class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>