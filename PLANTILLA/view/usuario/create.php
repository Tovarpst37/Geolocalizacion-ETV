<style>
#table{
    box-shadow: 0 0 10px rgba(0 0 0 / 30%);
}
#createUsuarios{
  margin:30px;
}
</style>
<div class="page-header">
  <div class="mb-3 contenedortext rounded-4">
      <br>
      <div class="d-flex align-items-center justify-content-center gap-2">
          <i class="bx bxs-user-detail" style="font-size: 2.5rem; color: #fff;"></i>
          <h1 class="fw-bold mb-0">Registro de Usuarios</h1>
      </div>
      <br>
  </div>
  <div class="card" id="table">
    <form action="<?php echo getUrl("Usuario","Usuario","postCreate")?>" method="POST" id="createUsuarios">

      <h4 class="mb-4">Datos Del usuario</h4>

        <div class ="row row-cols-2">
          <div class="col mb-3">
            <label for="primer_nombre" class="form-label">Primer Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control letras" id="primer_nombre" name="primer_nombre">
            <small id="nombreError" class="text-danger d-none mb-3 d-block"></small>
          </div>

          <div class="col mb-3">
            <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
            <input type="text" class="form-control letras" id="segundo_nombre" name="segundo_nombre">
          </div>
          
          <div class="col mb-3">
            <label for="primer_apellido" class="form-label">Primer Apellido<span class="text-danger">*</span></label>
            <input type="text" class="form-control letras" id="primer_apellido" name="primer_apellido">
            <small id="apellidoError" class="text-danger d-none mb-3 d-block"></small>
          </div>

          <div class="col mb-3">
            <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
            <input type="text" class="form-control letras" id="segundo_apellido" name="segundo_apellido">
          </div>

        </div>

        <div class="row row-cols-2">
          <div class="col mb-3">
            <label for="tipo_documento" class="form-label">Tipo De Documento<span class="text-danger select-validar">*</span></label>
            <select class = "form-select col mb-3 select-validar" name = "tipo_documento" id="tipo_documento">
              <option value="">Selecciona una opcion</option>
              <?php foreach ($tipo_documento as $item): ?>
                <option value="<?php echo $item['id_tipo_documento']; ?>">
                  <?php echo $item['nombre_documento']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col">
            <label for="documento" class="form-label">Documento<span class="text-danger">*</span></label>
            <div>
              <input
                type="text"
                onpaste="return false;"
                inputmode="numeric"
                id="documento"
                name="documento"
                class ="form-control"
                placeholder="Numero de identificacion"
              > 
              <small id="documentoError" class="text-danger d-none mb-3 d-block"></small>  
            </div>
          </div>
          
        </div>

        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento<span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                   max="<?php echo date('Y-m-d', strtotime('-1 day')); ?>">
            <small id="fechaError" class="text-danger d-none mb-3 d-block"></small>
        </div>

        <div class="mb-3">
          <label for="correo" class="form-label">Correo Electronico<span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="correo" name="correo">
          <small id="errorCorreo" class="text-danger d-none mb-3 d-block"></small>
        </div>

        <div class="mb-1">
          <label for="password" class="form-label">Contrasena<span class="text-danger">*</span></label>
          <input
            type="password"
            onpaste="return false;"
            id="password"
            name="password"
            class ="form-control"
            placeholder="Contrasena"
            
          >
          <small id="passwordError" class="text-danger d-none mb-3 d-block"></small>

          <?php include_once '../view/partials/contentPassword.php';?>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="cb1" name="remember">
            <label class="form-check-label" for="cb1">Ver contrasena</label>
          </div>

        </div>
            
        <div class="mb-3">
          <label for="id_genero" class="form-label select-validar">Genero<span class="text-danger">*</span></label>
          <select class = "form-select col mb-3 select-validar" name = "genero" id="id_genero">
            <option value="">Selecciona una opcion</option>
              <?php foreach ($genero as $item): ?>
                <option value="<?php echo $item['id_genero']; ?>">
                  <?php echo $item['nombre_genero']; ?>
                  </option>
                  <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="id_rol" class="form-label select-validar">Rol<span class="text-danger">*</span></label>
            <select class = "form-select col mb-3 select-validar" name = "rol" id="id_rol">
              <option value="">Selecciona una opcion</option>
                <?php foreach ($rol as $item): ?>
                  <option value="<?php echo $item['id_rol']; ?>">
                    <?php echo $item['nombre_rol']; ?>
                  </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
          <label for="id_rh" class="form-label select-validar">RH<span class="text-danger">*</span></label>
            <select class = "form-select col mb-3 select-validar" name = "rh" id="id_rh">
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
<script src="js/expre/letras.js"></script>
<script src="js/expre/numeros.js"></script>
<script src="js/expre/simbolos.js"></script>
<script src="js/expre/correo.js"></script>
<script src="js/document.js"></script>
<script src="js/password.js"></script>
<script src="js/checkbox.js"></script>
<script src="js/soloLetras.js"></script>
<script src="js/selectCompleto.js"></script>
<script src="js/fecha.js"></script>
<script src="js/nombre.js"></script>
<script src="../view/usuario/js/create.js"></script>