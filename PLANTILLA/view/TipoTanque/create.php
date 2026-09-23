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

#createTipoTanque{
  margin:0;
  padding:2rem 2.25rem 1.75rem;
}

#createTipoTanque .form-intro{
  margin-bottom:1.75rem;
}
#createTipoTanque .form-intro h4{
  font-weight:700;
  color:var(--ink);
  margin-bottom:.25rem !important;
}
#createTipoTanque .form-intro p{
  margin:0;
  color:var(--muted);
  font-size:.92rem;
}

#createTipoTanque .form-section{
  margin-bottom:1.75rem;
  padding-bottom:.25rem;
}
#createTipoTanque .section-title{
  display:flex;
  align-items:center;
  gap:.65rem;
  margin-bottom:1.1rem;
  font-size:1.05rem;
  font-weight:600;
  color:var(--ink);
}
#createTipoTanque .section-title .section-icon{
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
#createTipoTanque .section-title::after{
  content:"";
  flex:1;
  height:1px;
  background:var(--line);
}

#createTipoTanque .form-label{
  display:flex;
  align-items:center;
  gap:.4rem;
  margin-bottom:.4rem;
  font-size:.9rem;
  font-weight:600;
  color:var(--ink);
}
#createTipoTanque .form-label i.bx{
  font-size:1.05rem;
  color:var(--accent);
}
#createTipoTanque .form-label .text-danger{
  margin-left:-.15rem;
}

#createTipoTanque .form-control{
  padding:.65rem .95rem;
  border:1.5px solid var(--line);
  border-radius:12px;
  background-color:var(--field);
  color:var(--ink);
  font-size:.95rem;
  transition:border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
}
#createTipoTanque .form-control{
  min-height:2.9rem;
}
#createTipoTanque textarea.form-control{
  min-height:180px;
  resize:vertical;
}
#createTipoTanque .form-control::placeholder{
  color:#a3acba;
}
#createTipoTanque .form-control:hover{
  border-color:#c3cbd9;
}
#createTipoTanque .form-control:focus{
  background-color:#fff;
  border-color:var(--accent);
  box-shadow:0 0 0 4px rgba(59,91,219,.16);
  outline:0;
}

#createTipoTanque small.text-danger{
  margin:.35rem 0 .25rem !important;
  font-size:.8rem;
  font-weight:500;
}
#createTipoTanque small.text-danger:empty{
  display:none !important;
}

#createTipoTanque .form-actions{
  margin-top:.5rem;
  padding-top:1.4rem;
  border-top:1px solid var(--line);
}
#createTipoTanque .form-actions .btn{
  display:inline-flex;
  align-items:center;
  gap:.45rem;
  padding:.65rem 1.5rem;
  border-radius:12px;
  font-weight:600;
  transition:transform .12s ease, box-shadow .12s ease, background-color .12s ease;
}
#createTipoTanque .form-actions .btn i.bx{
  font-size:1.15rem;
}
#createTipoTanque .btn-primary{
  background-color:var(--accent);
  border-color:var(--accent);
  box-shadow:0 4px 12px rgba(59,91,219,.28);
}
#createTipoTanque .btn-primary:hover,
#createTipoTanque .btn-primary:focus{
  background-color:var(--accent-dark);
  border-color:var(--accent-dark);
  transform:translateY(-1px);
  box-shadow:0 6px 16px rgba(59,91,219,.34);
}
#createTipoTanque .btn-primary:active{
  transform:translateY(0);
}
#createTipoTanque .btn-outline-secondary{
  border-width:1.5px;
  color:var(--muted);
  border-color:var(--line);
  background:#fff;
}
#createTipoTanque .btn-outline-secondary:hover{
  background:var(--field);
  color:var(--ink);
  border-color:#c3cbd9;
}

@media (max-width:767.98px){
  #createTipoTanque{
    padding:1.5rem 1.25rem 1.25rem;
  }
}
@media (max-width:575.98px){
  #createTipoTanque .form-actions{
    flex-direction:column-reverse;
  }
  #createTipoTanque .form-actions .btn{
    justify-content:center;
    width:100%;
  }
}
</style>

<div class="page-header">
  <div class="mb-3 contenedortext rounded-4">
      <br>
      <div class="d-flex align-items-center justify-content-center gap-2">
          <i class="bx bxs-category" style="font-size: 2.5rem; color: #fff;"></i>
          <h1 class="fw-bold mb-0">Registro de Tipo de Tanque</h1>
      </div>
      <br>
  </div>

  <div class="card" id="table">
    <form action="<?php echo getUrl("TipoTanque","TipoTanque","postCreate")?>" method="POST" id="createTipoTanque">

      <div class="form-intro">
        <h4 class="mb-4">Datos del tipo de tanque</h4>
        <p>Completa la informaci&oacute;n para crear un nuevo tipo de tanque.
         Los campos con <span class="text-danger">*</span> son obligatorios.</p>
      </div>

      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-water"></i></span>
          Informaci&oacute;n general
        </h5>

        <div class="mb-3">
          <label for="nombre_tipo_tanque" class="form-label"><i class="bx bx-tag"></i>Nombre<span class="text-danger">*</span></label>
          <input
            type="text"
            class="form-control letras"
            id="nombre_tipo_tanque"
            name="nombre_tipo_tanque"
            placeholder="Ej: Tanque de reproducci&oacute;n"
          >
          <small id="nombreTipoTanqueError" class="text-danger d-none mb-3 d-block"></small>
        </div>

        <div class="mb-1">
          <label for="descripcion_tipo_tanque" class="form-label"><i class="bx bx-align-left"></i>Descripci&oacute;n<span class="text-danger">*</span></label>
          <textarea
            class="form-control"
            id="descripcion_tipo_tanque"
            name="descripcion_tipo_tanque"
            placeholder="Describe las caracter&iacute;sticas, uso u observaciones de este tipo de tanque"
          ></textarea>
          <small id="descripcionTipoTanqueError" class="text-danger d-none mb-3 d-block"></small>
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
<script src="js/soloLetras.js"></script>