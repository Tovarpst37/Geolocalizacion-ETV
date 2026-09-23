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

#createActividadTerreno{
  margin:0;
  padding:2rem 2.25rem 1.75rem;
}

#createActividadTerreno .form-intro{
  margin-bottom:1.75rem;
}
#createActividadTerreno .form-intro h4{
  font-weight:700;
  color:var(--ink);
  margin-bottom:.25rem !important;
}
#createActividadTerreno .form-intro p{
  margin:0;
  color:var(--muted);
  font-size:.92rem;
}

#createActividadTerreno .form-section{
  margin-bottom:1.75rem;
  padding-bottom:.25rem;
}
#createActividadTerreno .section-title{
  display:flex;
  align-items:center;
  gap:.65rem;
  margin-bottom:1.1rem;
  font-size:1.05rem;
  font-weight:600;
  color:var(--ink);
}
#createActividadTerreno .section-title .section-icon{
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
#createActividadTerreno .section-title::after{
  content:"";
  flex:1;
  height:1px;
  background:var(--line);
}

#createActividadTerreno .form-label{
  display:flex;
  align-items:center;
  gap:.4rem;
  margin-bottom:.4rem;
  font-size:.9rem;
  font-weight:600;
  color:var(--ink);
}
#createActividadTerreno .form-label i.bx{
  font-size:1.05rem;
  color:var(--accent);
}
#createActividadTerreno .form-label .text-danger{
  margin-left:-.15rem;
}

#createActividadTerreno .form-control{
  min-height:2.9rem;
  padding:.65rem .95rem;
  border:1.5px solid var(--line);
  border-radius:12px;
  background-color:var(--field);
  color:var(--ink);
  font-size:.95rem;
  transition:border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
}
#createActividadTerreno .form-control::placeholder{
  color:#a3acba;
}
#createActividadTerreno .form-control:hover{
  border-color:#c3cbd9;
}
#createActividadTerreno .form-control:focus{
  background-color:#fff;
  border-color:var(--accent);
  box-shadow:0 0 0 4px rgba(59,91,219,.16);
  outline:0;
}
#createActividadTerreno .form-control:disabled{
  background-color:#e9ecef;
  opacity:0.8;
}

#createActividadTerreno .form-actions{
  margin-top:.5rem;
  padding-top:1.4rem;
  border-top:1px solid var(--line);
}
#createActividadTerreno .form-actions .btn{
  display:inline-flex;
  align-items:center;
  gap:.45rem;
  padding:.65rem 1.5rem;
  border-radius:12px;
  font-weight:600;
  transition:transform .12s ease, box-shadow .12s ease, background-color .12s ease;
}
#createActividadTerreno .form-actions .btn i.bx{
  font-size:1.15rem;
}
#createActividadTerreno .btn-primary{
  background-color:var(--accent);
  border-color:var(--accent);
  box-shadow:0 4px 12px rgba(59,91,219,.28);
}
#createActividadTerreno .btn-primary:hover,
#createActividadTerreno .btn-primary:focus{
  background-color:var(--accent-dark);
  border-color:var(--accent-dark);
  transform:translateY(-1px);
  box-shadow:0 6px 16px rgba(59,91,219,.34);
}
#createActividadTerreno .btn-primary:active{
  transform:translateY(0);
}
#createActividadTerreno .btn-outline-secondary{
  border-width:1.5px;
  color:var(--muted);
  border-color:var(--line);
  background:#fff;
}
#createActividadTerreno .btn-outline-secondary:hover{
  background:var(--field);
  color:var(--ink);
  border-color:#c3cbd9;
}

@media (max-width:767.98px){
  #createActividadTerreno{
    padding:1.5rem 1.25rem 1.25rem;
  }
}
@media (max-width:575.98px){
  #createActividadTerreno .form-actions{
    flex-direction:column-reverse;
  }
  #createActividadTerreno .form-actions .btn{
    justify-content:center;
    width:100%;
  }
}
</style>

<div class="page-header">
  <div class="mb-3 contenedortext rounded-4">
      <br>
      <div class="d-flex align-items-center justify-content-center gap-2">
          <i class="bx bx-map-pin" style="font-size: 2.5rem; color: #fff;"></i>
          <h1 class="fw-bold mb-0">Registrar Actividades de Terreno</h1>
      </div>
      <br>
  </div>

  <div class="card" id="table">
    <form action="<?php echo getUrl("ActividadTerreno", "ActividadTerreno", "postRegistrar") ?>" method="POST" id="createActividadTerreno">

      <div class="form-intro">
        <h4 class="mb-4">Datos de la Actividad de Terreno</h4>
        <p>Completa la informaci&oacute;n para registrar una nueva actividad en terreno. Los campos con <span class="text-danger">*</span> son obligatorios.</p>
      </div>

      <!-- ============ Detalle de la Actividad ============ -->
      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-landscape"></i></span>
          Informaci&oacute;n General
        </h5>

        <?php
        // Catálogo maestro: los 4 procesos del mapa de Trabajo de Terreno
        $actividades_proceso_terreno = ["INSPECCION", "SIEMBRA", "SEGUIMIENTO", "RESIEMBRA"];

        // Traer los nombres ya registrados en actividad_terreno
        $sql3 = "SELECT nombre_actividad FROM actividad_terreno WHERE id_estado = 1 ORDER BY id_actividad_terreno";
        $registradas = $obj->select($sql3);

        // Normalizar a mayúsculas y sin espacios extra para comparar bien
        $nombres_registrados = array_map(function($n) {
            return trim(mb_strtoupper($n['nombre_actividad'], 'UTF-8'));
        }, $registradas);

        // Filtrar: dejar solo las que NO están registradas
        $actividades_faltantes = array_diff($actividades_proceso_terreno, $nombres_registrados);
        ?>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="codigo_Actividad" class="form-label"><i class="bx bx-hash"></i>C&oacute;digo de la actividad <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="codigo_Actividad" name="codigo_Actividad" value="AT-<?php echo $id_seg[0]['max'] + 1; ?>" disabled>
            <input type="hidden" name="codigo" value="AT-<?php echo $id_seg[0]['max'] + 1; ?>">
          </div>

          <div class="col-md-6 mb-3">
            <label for="nombre_actividad" class="form-label"><i class="bx bx-rename"></i>Nombre de la actividad <span class="text-danger">*</span></label>
            <select class="form-select" id="nombre_actividad" name="nombre_actividad" required>
              <?php if (count($actividades_faltantes) > 0): ?>
                <option value="" selected disabled>Seleccione una actividad</option>
                <?php foreach ($actividades_faltantes as $nombre): ?>
                  <option value="<?= htmlspecialchars($nombre) ?>"><?= htmlspecialchars(ucwords(strtolower($nombre))) ?></option>
                <?php endforeach; ?>
              <?php else: ?>
                <option value="" selected disabled>Todas las actividades ya están registradas</option>
              <?php endif; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 form-actions">
        <button type="reset" class="btn btn-outline-secondary"><i class="bx bx-eraser"></i>Limpiar</button>
        <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i>Guardar Actividad</button>
      </div>

    </form>
  </div>
</div>