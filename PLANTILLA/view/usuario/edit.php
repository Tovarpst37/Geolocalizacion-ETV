<!-- Modal Edit-->
<div class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalEditarLabel">Editar usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card-body p-4">
        <form action="<?php echo getUrl("Usuario","Usuario","postEditar")?>" method="POST">

            <input type="hidden" id="edit_id_usuario" name="id_usuario">

            <h4 class="mb-4">Datos Del usuario</h4>

            <div class ="row row-cols-2">
            <div class="col mb-3">
                <label for="edit_primer_nombre" class="form-label">Primer Nombre <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_primer_nombre" name="primer_nombre" required>
            </div>

            <div class="col mb-3">
                <label for="edit_segundo_nombre" class="form-label">Segundo Nombre</label>
                <input type="text" class="form-control" id="edit_segundo_nombre" name="segundo_nombre">
            </div>

            <div class="col mb-3">
                <label for="edit_primer_apellido" class="form-label">Primer Apellido<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_primer_apellido" name="primer_apellido" required>
            </div>

            <div class="col mb-3">
                <label for="edit_segundo_apellido" class="form-label">Segundo Apellido</label>
                <input type="text" class="form-control" id="edit_segundo_apellido" name="segundo_apellido">
            </div>
            </div>

            <div class="row row-cols-2">
            <div class="col mb-3">
                <label for="edit_tipo_documento" class="form-label">Tipo De Documento<span class="text-danger">*</span></label>
                <select class="form-select col mb-3" name="tipo_documento" id="edit_tipo_documento" required>
                <option value="">Selecciona una opcion</option>
                <?php foreach ($tipo_documento as $item): ?>
                    <option value="<?php echo $item['id_tipo_documento']; ?>">
                    <?php echo $item['nombre_documento']; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>

            <div class="col mb-3">
                <label for="edit_documento" class="form-label">Documento<span class="text-danger">*</span></label>
                <input
                type="text"
                onpaste="return false;"
                inputmode="numeric"
                class="form-control"
                id="edit_documento"
                name="documento"
                placeholder="Numero de identificacion"
                required
                >
            </div>
            </div>
            <div class="mb-3">
                <label for="edit_fecha_nacimiento" class="form-label">Fecha Nacimiento<span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="edit_fecha_nacimiento" name="fecha_nacimiento" required>
            </div>

            <div class="mb-3">
                <label for="edit_correo" class="form-label">Correo Electronico<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_correo" name="correo" required>
            </div>

            <div class="mb-3">
                <label for="edit_genero" class="form-label">Genero<span class="text-danger">*</span></label>
                <select class="form-select col mb-3" name="genero" id="edit_genero" required>
                <option value="">Selecciona una opcion</option>
                    <?php foreach ($genero as $item): ?>
                    <option value="<?php echo $item['id_genero']; ?>">
                        <?php echo $item['nombre_genero']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="edit_rol" class="form-label">Rol<span class="text-danger">*</span></label>
                <select class="form-select col mb-3" name="rol" id="edit_rol" required>
                <option value="">Selecciona una opcion</option>
                    <?php foreach ($rol as $item): ?>
                        <option value="<?php echo $item['id_rol']; ?>">
                        <?php echo $item['nombre_rol']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-0">
                <label for="edit_rh" class="form-label">RH<span class="text-danger">*</span></label>
                <select class="form-select col mb-3" name="rh" id="edit_rh" required>
                <option value="">Selecciona una opcion</option>
                    <?php foreach ($rh as $item): ?>
                    <option value="<?php echo $item['id_rh']; ?>">
                        <?php echo $item['nombre_rh']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>