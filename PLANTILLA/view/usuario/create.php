<style>
.page-header{
  --accent:#3b5bdb;
  --accent-dark:#2f49b5;
  --accent-soft:#edf1ff;
  --ink:#1f2937;
  --muted:#6b7280;
  --line:#dfe4ec;
  --field:#f7f9fc;
}

#table{
  border:0;
  border-radius:18px;
  overflow:hidden;
  box-shadow:0 10px 30px rgba(31,41,55,.10), 0 1px 3px rgba(31,41,55,.06);
}

#createUsuarios{
  margin:0;
  padding:2rem 2.25rem 1.75rem;
}

#createUsuarios .form-intro{
  margin-bottom:1.75rem;
}
#createUsuarios .form-intro h4{
  font-weight:700;
  color:var(--ink);
  margin-bottom:.25rem !important;
}
#createUsuarios .form-intro p{
  margin:0;
  color:var(--muted);
  font-size:.92rem;
}

#createUsuarios .form-section{
  margin-bottom:1.75rem;
  padding-bottom:.25rem;
}
#createUsuarios .section-title{
  display:flex;
  align-items:center;
  gap:.65rem;
  margin-bottom:1.1rem;
  font-size:1.05rem;
  font-weight:600;
  color:var(--ink);
}
#createUsuarios .section-title .section-icon{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  width:2.1rem;
  height:2.1rem;
  border-radius:10px;
  background:var(--accent-soft);
  color:var(--accent);
  font-size:1.15rem;
}
#createUsuarios .section-title::after{
  content:"";
  flex:1;
  height:1px;
  background:var(--line);
}

#createUsuarios .form-label{
  display:flex;
  align-items:center;
  gap:.4rem;
  margin-bottom:.4rem;
  font-size:.9rem;
  font-weight:600;
  color:var(--ink);
}
#createUsuarios .form-label i.bx{
  font-size:1.05rem;
  color:var(--accent);
}
#createUsuarios .form-label .text-danger{
  margin-left:-.15rem;
}

#createUsuarios .form-control,
#createUsuarios .form-select{
  min-height:2.9rem;
  padding:.65rem .95rem;
  border:1.5px solid var(--line);
  border-radius:12px;
  background-color:var(--field);
  color:var(--ink);
  font-size:.95rem;
  transition:border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
}
#createUsuarios .form-control::placeholder{
  color:#a3acba;
}
#createUsuarios .form-control:hover,
#createUsuarios .form-select:hover{
  border-color:#c3cbd9;
}
#createUsuarios .form-control:focus,
#createUsuarios .form-select:focus{
  background-color:#fff;
  border-color:var(--accent);
  box-shadow:0 0 0 4px rgba(59,91,219,.16);
  outline:0;
}

#createUsuarios small.text-danger{
  margin:.35rem 0 .25rem !important;
  font-size:.8rem;
  font-weight:500;
}
#createUsuarios small.text-danger:empty{
  display:none !important;
}

#createUsuarios .password-help{
  margin:.85rem 0 .75rem;
  padding:.85rem 1rem;
  border-radius:12px;
  background:var(--field);
  border:1px dashed var(--line);
  font-size:.85rem;
  color:var(--muted);
}
#createUsuarios .form-check{
  display:flex;
  align-items:center;
  gap:.5rem;
  padding-left:0;
  margin-bottom:0;
}
#createUsuarios .form-check .form-check-input{
  float:none;
  margin:0;
  width:1.1rem;
  height:1.1rem;
  border:1.5px solid #b7c0cf;
  cursor:pointer;
}
#createUsuarios .form-check .form-check-input:checked{
  background-color:var(--accent);
  border-color:var(--accent);
}
#createUsuarios .form-check .form-check-input:focus{
  box-shadow:0 0 0 4px rgba(59,91,219,.16);
}
#createUsuarios .form-check-label{
  cursor:pointer;
  font-size:.88rem;
  color:var(--muted);
}

#createUsuarios .form-actions{
  margin-top:.5rem;
  padding-top:1.4rem;
  border-top:1px solid var(--line);
}
#createUsuarios .form-actions .btn{
  display:inline-flex;
  align-items:center;
  gap:.45rem;
  padding:.65rem 1.5rem;
  border-radius:12px;
  font-weight:600;
  transition:transform .12s ease, box-shadow .12s ease, background-color .12s ease;
}
#createUsuarios .form-actions .btn i.bx{
  font-size:1.15rem;
}
#createUsuarios .btn-primary{
  background-color:var(--accent);
  border-color:var(--accent);
  box-shadow:0 4px 12px rgba(59,91,219,.28);
}
#createUsuarios .btn-primary:hover,
#createUsuarios .btn-primary:focus{
  background-color:var(--accent-dark);
  border-color:var(--accent-dark);
  transform:translateY(-1px);
  box-shadow:0 6px 16px rgba(59,91,219,.34);
}
#createUsuarios .btn-primary:active{
  transform:translateY(0);
}
#createUsuarios .btn-outline-secondary{
  border-width:1.5px;
  color:var(--muted);
  border-color:var(--line);
  background:#fff;
}
#createUsuarios .btn-outline-secondary:hover{
  background:var(--field);
  color:var(--ink);
  border-color:#c3cbd9;
}

@media (max-width:767.98px){
  #createUsuarios{
    padding:1.5rem 1.25rem 1.25rem;
  }
}
@media (max-width:575.98px){

  #createUsuarios .row.row-cols-2 > *{
    width:100%;
  }
  #createUsuarios .form-actions{
    flex-direction:column-reverse;
  }
  #createUsuarios .form-actions .btn{
    justify-content:center;
    width:100%;
  }
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

      <div class="form-intro">
        <h4 class="mb-4">Datos Del usuario</h4>
        <p>Completa la informaci&oacute;n para crear un nuevo usuario. Los campos con <span class="text-danger">*</span> son obligatorios.</p>
      </div>

      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-user"></i></span>
          Datos personales
        </h5>

        <div class ="row row-cols-2">
          <div class="col mb-3">
            <label for="primer_nombre" class="form-label"><i class="bx bx-user"></i>Primer Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control letras" id="primer_nombre" name="primer_nombre" placeholder="Ej: Mar&iacute;a">
            <small id="nombreError" class="text-danger d-none mb-3 d-block"></small>
          </div>

          <div class="col mb-3">
            <label for="segundo_nombre" class="form-label"><i class="bx bx-user"></i>Segundo Nombre</label>
            <input type="text" class="form-control letras" id="segundo_nombre" name="segundo_nombre" placeholder="Opcional">
          </div>
          
          <div class="col mb-3">
            <label for="primer_apellido" class="form-label"><i class="bx bx-user-voice"></i>Primer Apellido<span class="text-danger">*</span></label>
            <input type="text" class="form-control letras" id="primer_apellido" name="primer_apellido" placeholder="Ej: G&oacute;mez">
            <small id="apellidoError" class="text-danger d-none mb-3 d-block"></small>
          </div>

          <div class="col mb-3">
            <label for="segundo_apellido" class="form-label"><i class="bx bx-user-voice"></i>Segundo Apellido</label>
            <input type="text" class="form-control letras" id="segundo_apellido" name="segundo_apellido" placeholder="Opcional">
          </div>

        </div>

        <div class="row">
          <div class="col-md-4 mb-3">
              <label for="fecha_nacimiento" class="form-label"><i class="bx bx-calendar"></i>Fecha Nacimiento<span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                     max="<?php echo date('Y-m-d', strtotime('-1 day')); ?>">
              <small id="fechaError" class="text-danger d-none mb-3 d-block"></small>
          </div>

          <div class="col-md-4 mb-3">
            <label for="id_genero" class="form-label select-validar"><i class="bx bx-male-female"></i>Genero<span class="text-danger">*</span></label>
            <select class = "form-select col mb-3 select-validar" name = "genero" id="id_genero">
              <option value="">Selecciona una opcion</option>
                <?php foreach ($genero as $item): ?>
                  <option value="<?php echo $item['id_genero']; ?>">
                    <?php echo $item['nombre_genero']; ?>
                    </option>
                    <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4 mb-3">
            <label for="id_rh" class="form-label select-validar"><i class="bx bx-droplet"></i>RH<span class="text-danger">*</span></label>
              <select class = "form-select col mb-3 select-validar" name = "rh" id="id_rh">
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

      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-id-card"></i></span>
          Documento de identidad
        </h5>

        <div class="row row-cols-2">
          <div class="col mb-3">
            <label for="tipo_documento" class="form-label"><i class="bx bx-id-card"></i>Tipo De Documento<span class="text-danger select-validar">*</span></label>
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
            <label for="documento" class="form-label"><i class="bx bx-hash"></i>Documento<span class="text-danger">*</span></label>
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
      </div>

      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-lock-alt"></i></span>
          Cuenta de acceso
        </h5>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="correo" class="form-label"><i class="bx bx-envelope"></i>Correo Electronico<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="correo" name="correo" inputmode="email" placeholder="ejemplo@correo.com">
            <small id="errorCorreo" class="text-danger d-none mb-3 d-block"></small>
          </div>

          <div class="col-md-6 mb-3">
            <label for="id_rol" class="form-label select-validar"><i class="bx bx-shield-quarter"></i>Rol<span class="text-danger">*</span></label>
              <select class = "form-select col mb-3 select-validar" name = "rol" id="id_rol">
                <option value="">Selecciona una opcion</option>
                  <?php foreach ($rol as $item): ?>
                    <option value="<?php echo $item['id_rol']; ?>">
                      <?php echo $item['nombre_rol']; ?>
                    </option>
                  <?php endforeach; ?>
              </select>
          </div>
        </div>

        <div class="mb-1">
          <label for="password" class="form-label"><i class="bx bx-key"></i>Contrase&ntilde;a<span class="text-danger">*</span></label>
          <input
            type="password"
            onpaste="return false;"
            id="password"
            name="password"
            class ="form-control"
            placeholder="Contrase&ntilde;a"
            
          >
          <small id="passwordError" class="text-danger d-none mb-3 d-block"></small>

          <div>
            <?php include_once '../view/partials/contentPassword.php';?>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="cb1" name="remember">
            <label class="form-check-label" for="cb1">Ver contrase&ntilde;a</label>
          </div>

        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 form-actions">
        <button type="reset" class="btn btn-outline-secondary"><i class="bx bx-eraser"></i>Limpiar</button>
        <button type="submit" value="Registrar" class="btn btn-primary"><i class="bx bx-save"></i>Guardar</button>
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