<?php include_once '../view/partials/formulari/headFormulari.php';?>
    <h2 class="mb-0 ">CREAR ROL</h2>
<?php include_once '../view/partials/formulari/body.php';?>           
    <form action="<?php echo getUrl("Roles","Roles","postCreate")?>" method="POST">

        <div class ="mb-2">
            <div class=" mb-3">
                <label for="segundo_apellido" class="form-label">Nombre de rol</label>
                <input type="text" class="form-control" id="segundo_apellido" name="nombre_rol" required>
            </div>
        </div>
        <h4 class="mb-0">Modulos</h4>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
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
                                                <?php if (isset($mapa[$modu['id_modulo']][$acc['id_permiso']])): ?>
                                                    <input type="checkbox"
                                                           name="permisos[]"
                                                           value="<?php echo $mapa[$modu['id_modulo']][$acc['id_permiso']]; ?>">
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" value="Registrar" class="btn btn-primary">Guardar</button>
        </div>

    </form>
<?php include_once '../view/partials/formulari/footer.php';?>