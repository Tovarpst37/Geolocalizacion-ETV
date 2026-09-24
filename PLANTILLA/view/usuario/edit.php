<style>
    .negro{
        color:black;
    }
</style>
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
        <form action="<?php echo getUrl("Usuario","Usuario","postEditar")?>" method="POST" id = "modalEdit">

            <input type="hidden" id="edit_id_usuario" name="id_usuario">

            <h4 class="mb-4 negro">Datos Del usuario</h4>

            <div class ="row row-cols-2">
            <div class="col mb-3">
                <label for="primer_nombre" class="form-label">Primer Nombre <span class="text-danger">*</span></label>
                <input type="text" class="form-control letras" id="primer_nombre" name="primer_nombre">
                <small id="nombreError" class="text-danger d-none mb-3 d-block"></small>
            </div>

            <div class="col mb-3">
                <label for="edit_segundo_nombre" class="form-label">Segundo Nombre</label>
                <input type="text" class="form-control letras" id="edit_segundo_nombre" name="segundo_nombre">
            </div>

            <div class="col mb-3">
                <label for="primer_apellido" class="form-label">Primer Apellido<span class="text-danger">*</span></label>
                <input type="text" class="form-control letras" id="primer_apellido" name="primer_apellido">
                <small id="apellidoError" class="text-danger d-none mb-3 d-block"></small>
            </div>

            <div class="col mb-3">
                <label for="edit_segundo_apellido" class="form-label">Segundo Apellido</label>
                <input type="text" class="form-control letras" id="edit_segundo_apellido" name="segundo_apellido">
            </div>
            </div>

            <div class="row row-cols-2">
            <div class="col mb-3">
                <label for="edit_tipo_documento" class="form-label">Tipo De Documento<span class="text-danger">*</span></label>
                <select class="form-select col mb-3 select-validar" name="tipo_documento" id="edit_tipo_documento">
                <option value="">Selecciona una opcion</option>
                <?php foreach ($tipo_documento as $item): ?>
                    <option value="<?php echo $item['id_tipo_documento']; ?>">
                    <?php echo $item['nombre_documento']; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>

            <div class="col mb-3">
                <label for="documento" class="form-label">Documento<span class="text-danger">*</span></label>
                <input
                type="text"
                onpaste="return false;"
                inputmode="numeric"
                class="form-control"
                id="documento"
                name="documento"
                placeholder="Numero de identificacion"
                required
                >
                <small id="documentoError" class="text-danger d-none mb-3 d-block"></small>  
            </div>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento<span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                 <small id="fechaError" class="text-danger d-none mb-3 d-block"></small>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electronico<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="correo" name="correo" required>
                <small id="errorCorreo" class="text-danger d-none mb-3 d-block"></small>
            </div>

            <div class="mb-3">
                <label for="edit_genero" class="form-label">Genero<span class="text-danger">*</span></label>
                <select class="form-select col mb-3 select-validar" name="genero" id="edit_genero">
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
                <select class="form-select col mb-3 select-validar" name="rol" id="edit_rol">
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
                <select class="form-select col mb-3 select-validar" name="rh" id="edit_rh">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>
<script src="js/expre/letras.js"></script>
<script src="js/expre/numeros.js"></script>
<script src="js/expre/correo.js"></script>
<script src="js/document.js"></script>
<script src="js/soloLetras.js"></script>
<script src="js/selectCompleto.js"></script>
<script src="js/fecha.js"></script>
<script src="js/nombre.js"></script>
<script src="../view/usuario/js/edit.js"></script>