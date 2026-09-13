<div class="container mt-4">
  <div class="d-flex justify-content-center">
    <div class="card shadow" style="width: 100%; max-width: 700px;">
      <div class="card-header bg-primary text-white">
        <h2 class="mb-0 ">Registro de Usuarios</h2>
      </div>

      <div class="card-body p-4">
        <form action="<?php echo getUrl("Usuario","Usuario","postCreate")?>" method="POST">

        <h4 class="mb-4">Datos Del usuario</h4>

        <div class ="row row-cols-2">
          <div class="col mb-3">
            <label for="codigo_tanque" class="form-label">Primer Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="primer_nombre" name="primer_nombre">
          </div>

          <div class="col mb-3">
            <label for="codigo_tanque" class="form-label">Segundo Nombre</label>
            <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre">
          </div>
        
          <div class="col mb-3">
            <label for="codigo_tanque" class="form-label">Primer Apellido<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="primer_apellido" name="primer_apellido">
          </div>

          <div class="col mb-3">
            <label for="codigo_tanque" class="form-label">Segundo Apellido</label>
            <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido">
          </div>
        </div>

        <div class="row row-cols-2">
          <div class="col mb-3">
            <label for="codigo_tanque" class="form-label">Tipo De Documento<span class="text-danger">*</span></label>
            <select class = "form-select col mb-3" name = "tipo_documento" id="tipo_documento">
              <option value="">Selecciona una opcion</option>
              <?php foreach ($tipo_documento as $item): ?>
                <option value="<?php echo $item['id_tipo_documento']; ?>">
                  <?php echo $item['nombre_documento']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col mb-3">
            <label for="codigo_tanque" class="form-label">Documento<span class="text-danger">*</span></label>
            <input
              type="text"
              onpaste="return false;"
              inputmode="numeric"
              class="form-control"
              id="documento"
              name="documento"
              placeholder="Numero de identificacion"
              >
          </div>
        </div>
          <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento<span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
          </div>

          <div class="mb-3">
            <label for="codigo_tanque" class="form-label">Correo Electronico<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="correo" name="correo">
          </div>

          <div class="mb-1">
            <label for="codigo_tanque" class="form-label">Contrasena<span class="text-danger">*</span></label>
            <input
              type="password"
              onpaste="return false;"
              class="form-control"
              id="password"
              name="password"
              placeholder="Contraseña"
              >

            <?php include_once '../view/partials/contentPassword.php';?>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="cb1" name="remember">
              <label class="form-check-label" for="cb1">Ver contrasena</label>
            </div>

          </div>
          
          <div class="mb-3">
            <label for="codigo_tanque" class="form-label">Genero<span class="text-danger">*</span></label>
             <select class = "form-select col mb-3" name = "genero"id="id_genero" >
              <option value="">Selecciona una opcion</option>
                <?php foreach ($genero as $item): ?>
                  <option value="<?php echo $item['id_genero']; ?>">
                    <?php echo $item['nombre_genero']; ?>
                  </option>
                <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="codigo_tanque" class="form-label">Rol<span class="text-danger">*</span></label>
             <select class = "form-select col mb-3" name = "rol" id="id_rol" >
              <option value="">Selecciona una opcion</option>
                  <?php foreach ($rol as $item): ?>
                    <option value="<?php echo $item['id_rol']; ?>">
                      <?php echo $item['nombre_rol']; ?>
                    </option>
                  <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="codigo_tanque" class="form-label">RH<span class="text-danger">*</span></label>
             <select class = "form-select col mb-3" name = "rh" id="id_rh" >
              <option value="">Selecciona una opcion</option>
                <?php foreach ($rh as $item): ?>
                  <option value="<?php echo $item['id_rh']; ?>">
                    <?php echo $item['nombre_rh']; ?>
                  </option>
                <?php endforeach; ?>
            </select>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="submit" value="Registrar" class="btn btn-primary">Guardar</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<script src="js/expre/letras.js"></script>
<script src="js/expre/numeros.js"></script>
<script src="js/expre/simbolos.js"></script>
<script src="js/document.js"></script>
<script src="js/password.js"></script>
<script src="js/checkbox.js"></script>