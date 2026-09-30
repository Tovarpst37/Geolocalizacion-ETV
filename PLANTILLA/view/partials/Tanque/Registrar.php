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

#createTanque{
  margin:0;
  padding:2rem 2.25rem 1.75rem;
}

#createTanque .form-intro{
  margin-bottom:1.75rem;
}
#createTanque .form-intro h4{
  font-weight:700;
  color:var(--ink);
  margin-bottom:.25rem !important;
}
#createTanque .form-intro p{
  margin:0;
  color:var(--muted);
  font-size:.92rem;
}

#createTanque .form-section{
  margin-bottom:1.75rem;
  padding-bottom:.25rem;
}
#createTanque .section-title{
  display:flex;
  align-items:center;
  gap:.65rem;
  margin-bottom:1.1rem;
  font-size:1.05rem;
  font-weight:600;
  color:var(--ink);
}
#createTanque .section-title .section-icon{
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
#createTanque .section-title::after{
  content:"";
  flex:1;
  height:1px;
  background:var(--line);
}

#createTanque .form-label{
  display:flex;
  align-items:center;
  gap:.4rem;
  margin-bottom:.4rem;
  font-size:.9rem;
  font-weight:600;
  color:var(--ink);
}
#createTanque .form-label i.bx{
  font-size:1.05rem;
  color:var(--accent);
}
#createTanque .form-label .text-danger{
  margin-left:-.15rem;
}

#createTanque .form-control,
#createTanque .form-select{
  min-height:2.9rem;
  padding:.65rem .95rem;
  border:1.5px solid var(--line);
  border-radius:12px;
  background-color:var(--field);
  color:var(--ink);
  font-size:.95rem;
  transition:border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
}
#createTanque .form-control::placeholder{
  color:#a3acba;
}
#createTanque .form-control:hover,
#createTanque .form-select:hover{
  border-color:#c3cbd9;
}
#createTanque .form-control:focus,
#createTanque .form-select:focus{
  background-color:#fff;
  border-color:var(--accent);
  box-shadow:0 0 0 4px rgba(59,91,219,.16);
  outline:0;
}
#createTanque .form-control:disabled{
  background-color:#e9ecef;
  opacity:0.8;
}

#createTanque .form-actions{
  margin-top:.5rem;
  padding-top:1.4rem;
  border-top:1px solid var(--line);
}
#createTanque .form-actions .btn{
  display:inline-flex;
  align-items:center;
  gap:.45rem;
  padding:.65rem 1.5rem;
  border-radius:12px;
  font-weight:600;
  transition:transform .12s ease, box-shadow .12s ease, background-color .12s ease;
}
#createTanque .form-actions .btn i.bx{
  font-size:1.15rem;
}
#createTanque .btn-primary{
  background-color:var(--accent);
  border-color:var(--accent);
  box-shadow:0 4px 12px rgba(59,91,219,.28);
}
#createTanque .btn-primary:hover,
#createTanque .btn-primary:focus{
  background-color:var(--accent-dark);
  border-color:var(--accent-dark);
  transform:translateY(-1px);
  box-shadow:0 6px 16px rgba(59,91,219,.34);
}
#createTanque .btn-primary:active{
  transform:translateY(0);
}
#createTanque .btn-outline-secondary{
  border-width:1.5px;
  color:var(--muted);
  border-color:var(--line);
  background:#fff;
}
#createTanque .btn-outline-secondary:hover{
  background:var(--field);
  color:var(--ink);
  border-color:#c3cbd9;
}

@media (max-width:767.98px){
  #createTanque{
    padding:1.5rem 1.25rem 1.25rem;
  }
}
@media (max-width:575.98px){
  #createTanque .form-actions{
    flex-direction:column-reverse;
  }
  #createTanque .form-actions .btn{
    justify-content:center;
    width:100%;
  }
}
</style>

<div class="page-header">
  <div class="mb-3 contenedortext rounded-4">
      <br>
      <div class="d-flex align-items-center justify-content-center gap-2">
          <i class="bx bx-water" style="font-size: 2.5rem; color: #fff;"></i>
          <h1 class="fw-bold mb-0">Registro de Tanques</h1>
      </div>
      <br>
  </div>

  <div class="card" id="table">
    <form action="<?php echo getUrl("Tanque", "Tanque", "validarRegistrar") ?>" method="POST" enctype="multipart/form-data" id="createTanque">

      <div class="form-intro">
        <h4 class="mb-4">Datos del Tanque</h4>
        <p>Completa la informaci&oacute;n para registrar un nuevo tanque. Los campos con <span class="text-danger">*</span> son obligatorios.</p>
      </div>

      <!-- ============ Información General ============ -->
      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-info-circle"></i></span>
          Informaci&oacute;n General
        </h5>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="codigo_tanque" class="form-label"><i class="bx bx-hash"></i>C&oacute;digo del tanque <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="codigo_tanque" name="codigo_tanque" value="TANQUE#<?php echo $id_tan[0]['max'] + 1;  ?>" disabled>
            <input type="hidden" name="codigo" value="TANQUE#<?php echo $id_tan[0]['max'] + 1;  ?>">
          </div>

          <div class="col-md-6 mb-3">
            <label for="img" class="form-label"><i class="bx bx-image-add"></i>Porfavor ingresa una foto del tanque que vas a registrar</label>
            <input type="file" class="form-control" id="img" name="img" accept="image/*">
          </div>
        </div>
      </div>

      <!-- ============ Especificaciones e Instalación ============ -->
      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-cog"></i></span>
          Asignaci&oacute;n y Estado
        </h5>

        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="id_tipo_tanque" class="form-label"><i class="bx bx-category"></i>Tipo de tanque <span class="text-danger">*</span></label>
            <select class="form-select" id="id_tipo_tanque" name="id_tipo_tanque" required>
              <option value="" selected disabled>Selecciona un tipo</option>
              <?php foreach ($tiposTanque as $tipo): ?>
                <option value="<?php echo $tipo['id_tipo_tanque']; ?>" <?php echo (($old['id_tipo_tanque'] ?? '') == $tipo['id_tipo_tanque']) ? 'selected' : ''; ?>><?php echo $tipo['nombre_tipo_tanque']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4 mb-3">
            <label for="id_zoocriadero" class="form-label"><i class="bx bxs-leaf"></i>Zoocriadero <span class="text-danger">*</span></label>
            <select class="form-select" id="id_zoocriadero" name="id_zoocriadero" required>
              <option value="" selected disabled>Selecciona un zoocriadero</option>
              <?php foreach ($zoocriaderos as $zoo): ?>
                <option value="<?php echo $zoo['id_zoocriadero']; ?>" <?php echo (($old['id_zoocriadero'] ?? '') == $zoo['id_zoocriadero']) ? 'selected' : ''; ?>><?php echo $zoo['cod_zoocriadero']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4 mb-3">
            <label for="id_estado" class="form-label"><i class="bx bx-toggle-left"></i>Estado <span class="text-danger">*</span></label>
            <select class="form-select" id="id_estado" name="id_estado" required>
              <option value="" selected disabled>Selecciona un estado</option>
              <?php foreach ($estados as $est): ?>
                <option value="<?php echo $est['id_estado']; ?>" <?php echo (($old['id_estado'] ?? '') == $est['id_estado']) ? 'selected' : ''; ?>><?php echo $est['nombre_estado']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 form-actions">
        <button type="reset" class="btn btn-outline-secondary"><i class="bx bx-eraser"></i>Limpiar</button>
        <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i>Guardar Tanque</button>
      </div>

    </form>
  </div>
</div>