<?php 
include_once '../view/usuario/edit.php';
include_once '../view/usuario/habilitar.php';
include_once '../view/usuario/disable.php';
?>
<div class="page-header">
    <div class="mb-3 contenedortext rounded-4">
        <br>
        <div class="d-flex align-items-center justify-content-center gap-2">
            <i class="bx bxs-user-detail" style="font-size: 2.5rem; color: #fff;"></i>
            <h1 class="fw-bold mb-0">Usuarios</h1>
        </div>
        <br>
    </div>

    <div class="d-flex justify-content-end w-100 mb-3">
    <div class="input-group" style="max-width: 350px;">
        <form class="input-group" action="index.php" method="GET">
            <input type="hidden" name="modulo" value="Usuario">
            <input type="hidden" name="controlador" value="Usuario">
            <input type="hidden" name="funcion" value="getBuscar">
            <input type="number" name="busqueda" placeholder="Search ..." class="form-control" value="<?php echo htmlspecialchars($palabra ?? ''); ?>">
            <button type="submit" class="btn btn-outline-secondary">
            <i class="fa fa-search"></i>
            </button>
        </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Primer Nombre</th>
                            <th>Segundo Nombre</th>
                            <th>Primer Apellido</th>
                            <th>Segundo Apellido</th>
                            <th>Tipo Documento</th>
                            <th>Documento</th>
                            <th>Fecha Nacimiento</th>
                            <th>Correo</th>
                            <th>Genero</th>
                            <th>Rol</th>
                            <th>Rh</th>
                            <th>Editar</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($usuarios as $usu) { ?>
                        <tr>
                            <td><?= htmlspecialchars($usu['id_usuario']) ?></td>
                            <td><?= htmlspecialchars($usu['primer_nombre']) ?></td>
                            <td><?= htmlspecialchars($usu['segundo_nombre']) ?></td>
                            <td><?= htmlspecialchars($usu['primer_apellido']) ?></td>
                            <td><?= htmlspecialchars($usu['segundo_apellido']) ?></td>
                            <td><?= htmlspecialchars($usu['tipo_documento']) ?></td>
                            <td><?= htmlspecialchars($usu['documento']) ?></td>
                            <td><?= htmlspecialchars($usu['fecha_nacimiento']) ?></td>
                            <td><?= htmlspecialchars($usu['correo']) ?></td>
                            <td><?= htmlspecialchars($usu['genero_usuario']) ?></td>
                            <td><?= htmlspecialchars($usu['rol_usuario']) ?></td>
                            <td><?= htmlspecialchars($usu['rh_usuario']) ?></td>
                            <td>
                                <?php if (in_array('EDITAR', $_SESSION['permisos']['Usuarios'] ?? [])): ?>
                                <button type="button"
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditar"
                                    data-id-usuario="<?= htmlspecialchars($usu['id_usuario']) ?>"
                                    data-primer-nombre="<?= htmlspecialchars($usu['primer_nombre']) ?>"
                                    data-segundo-nombre="<?= htmlspecialchars($usu['segundo_nombre']) ?>"
                                    data-primer-apellido="<?= htmlspecialchars($usu['primer_apellido']) ?>"
                                    data-segundo-apellido="<?= htmlspecialchars($usu['segundo_apellido']) ?>"
                                    data-id-tipo-documento="<?= htmlspecialchars($usu['id_tipo_documento']) ?>"
                                    data-documento="<?= htmlspecialchars($usu['documento']) ?>"
                                    data-fecha-nacimiento="<?= htmlspecialchars($usu['fecha_nacimiento']) ?>"
                                    data-correo="<?= htmlspecialchars($usu['correo']) ?>"
                                    data-id-genero="<?= htmlspecialchars($usu['id_genero']) ?>"
                                    data-id-rol="<?= htmlspecialchars($usu['id_rol']) ?>"
                                    data-id-rh="<?= htmlspecialchars($usu['id_rh']) ?>">
                                    Editar
                                </button>
                                <?php endif; ?>
                            </td>
                            <td>
                            <?php if ((int)$usu['id_usuario'] === (int)$_SESSION['id_usuarioU']): ?>
                                    <i class="bx bxs-x-circle" style="font-size: 32px;"></i>
                                <?php elseif (in_array('ELIMINAR', $_SESSION['permisos']['Usuarios'] ?? [])): ?>
                                    <?php if ((int)$usu['id_estado'] === 1): ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEstado"
                                            data-id-usuario="<?= htmlspecialchars($usu['id_usuario']) ?>"
                                            data-id-estado-actual="<?= htmlspecialchars($usu['id_estado']) ?>">
                                            Habilitado
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEstadoH"
                                            data-id-usuario="<?= htmlspecialchars($usu['id_usuario']) ?>"
                                            data-id-estado-actual="<?= htmlspecialchars($usu['id_estado']) ?>">
                                            Deshabilitado
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../view/usuario/js/list.js"></script>