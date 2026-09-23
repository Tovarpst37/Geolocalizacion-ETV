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

#createZoocriadero{
  margin:0;
  padding:2rem 2.25rem 1.75rem;
}

#createZoocriadero .form-intro{
  margin-bottom:1.75rem;
}
#createZoocriadero .form-intro h4{
  font-weight:700;
  color:var(--ink);
  margin-bottom:.25rem !important;
}
#createZoocriadero .form-intro p{
  margin:0;
  color:var(--muted);
  font-size:.92rem;
}

#createZoocriadero .form-section{
  margin-bottom:1.75rem;
  padding-bottom:.25rem;
}
#createZoocriadero .section-title{
  display:flex;
  align-items:center;
  gap:.65rem;
  margin-bottom:1.1rem;
  font-size:1.05rem;
  font-weight:600;
  color:var(--ink);
}
#createZoocriadero .section-title .section-icon{
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
#createZoocriadero .section-title::after{
  content:"";
  flex:1;
  height:1px;
  background:var(--line);
}

#createZoocriadero .form-label{
  display:flex;
  align-items:center;
  gap:.4rem;
  margin-bottom:.4rem;
  font-size:.9rem;
  font-weight:600;
  color:var(--ink);
}
#createZoocriadero .form-label i.bx{
  font-size:1.05rem;
  color:var(--accent);
}
#createZoocriadero .form-label .text-danger{
  margin-left:-.15rem;
}

#createZoocriadero .form-control,
#createZoocriadero .form-select{
  min-height:2.9rem;
  padding:.65rem .95rem;
  border:1.5px solid var(--line);
  border-radius:12px;
  background-color:var(--field);
  color:var(--ink);
  font-size:.95rem;
  transition:border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
}
#createZoocriadero .form-control::placeholder{
  color:#a3acba;
}
#createZoocriadero .form-control:hover,
#createZoocriadero .form-select:hover{
  border-color:#c3cbd9;
}
#createZoocriadero .form-control:focus,
#createZoocriadero .form-select:focus{
  background-color:#fff;
  border-color:var(--accent);
  box-shadow:0 0 0 4px rgba(59,91,219,.16);
  outline:0;
}
#createZoocriadero .form-control:disabled,
#createZoocriadero .form-select:disabled{
  background-color:#e9ecef;
  opacity:0.8;
}

#createZoocriadero .aux-container{
  border:1.5px solid var(--line) !important;
  border-radius:12px !important;
  background-color:var(--field);
  padding:.75rem 1rem !important;
  max-height:180px;
  overflow-y:auto;
}

#createZoocriadero .form-check{
  display:flex;
  align-items:center;
  gap:.5rem;
  padding-left:0;
  margin-bottom:.5rem;
}
#createZoocriadero .form-check:last-child{
  margin-bottom:0;
}
#createZoocriadero .form-check .form-check-input{
  float:none;
  margin:0;
  width:1.1rem;
  height:1.1rem;
  border:1.5px solid #b7c0cf;
  cursor:pointer;
}
#createZoocriadero .form-check .form-check-input:checked{
  background-color:var(--accent);
  border-color:var(--accent);
}
#createZoocriadero .form-check .form-check-input:focus{
  box-shadow:0 0 0 4px rgba(59,91,219,.16);
}
#createZoocriadero .form-check-label{
  cursor:pointer;
  font-size:.88rem;
  color:var(--ink);
}

#createZoocriadero .form-actions{
  margin-top:.5rem;
  padding-top:1.4rem;
  border-top:1px solid var(--line);
}
#createZoocriadero .form-actions .btn{
  display:inline-flex;
  align-items:center;
  gap:.45rem;
  padding:.65rem 1.5rem;
  border-radius:12px;
  font-weight:600;
  transition:transform .12s ease, box-shadow .12s ease, background-color .12s ease;
}
#createZoocriadero .form-actions .btn i.bx{
  font-size:1.15rem;
}
#createZoocriadero .btn-primary{
  background-color:var(--accent);
  border-color:var(--accent);
  box-shadow:0 4px 12px rgba(59,91,219,.28);
}
#createZoocriadero .btn-primary:hover,
#createZoocriadero .btn-primary:focus{
  background-color:var(--accent-dark);
  border-color:var(--accent-dark);
  transform:translateY(-1px);
  box-shadow:0 6px 16px rgba(59,91,219,.34);
}
#createZoocriadero .btn-primary:active{
  transform:translateY(0);
}
#createZoocriadero .btn-outline-secondary{
  border-width:1.5px;
  color:var(--muted);
  border-color:var(--line);
  background:#fff;
}
#createZoocriadero .btn-outline-secondary:hover{
  background:var(--field);
  color:var(--ink);
  border-color:#c3cbd9;
}

.address-example-box{
  background:#f7f9fc;
  border:1.5px dashed #c3cbd9;
  border-radius:12px;
  padding:1rem 1.25rem;
  margin-bottom:1.5rem;
}
.address-example-box .example-title{
  display:flex;
  align-items:center;
  gap:.5rem;
  margin-bottom:.5rem;
  font-weight:700;
  color:var(--ink);
}
.address-example-box .example-title i.bx{
  color:#f5b301;
  font-size:1.2rem;
}
.address-breakdown{
  display:flex;
  flex-wrap:wrap;
  align-items:center;
  gap:.4rem;
  font-size:.85rem;
  margin-top:.5rem;
}
.address-breakdown .chip{
  padding:.2rem .55rem;
  border-radius:8px;
  font-weight:700;
}
.address-breakdown .chip-blue{ background:#e0e7ff; color:#3b5bdb; }
.address-breakdown .chip-green{ background:#e6f4ea; color:#1e7e34; }
.address-breakdown .chip-orange{ background:#fff1e0; color:#c2650a; }
.address-breakdown .chip-purple{ background:#f2e6ff; color:#7b2fbd; }
.address-breakdown .chip-label{ color:var(--muted); margin-right:.6rem; }

.live-preview{
  display:flex;
  align-items:center;
  gap:.5rem;
  background:var(--accent-soft);
  border:1.5px solid #c7d2fe;
  border-radius:12px;
  padding:.75rem 1rem;
  font-weight:600;
  color:var(--accent-dark);
  margin-top:1rem;
}
.live-preview i.bx{ font-size:1.2rem; }

@media (max-width:767.98px){
  #createZoocriadero{
    padding:1.5rem 1.25rem 1.25rem;
  }
}
@media (max-width:575.98px){
  #createZoocriadero .row.row-cols-2 > *{
    width:100%;
  }
  #createZoocriadero .form-actions{
    flex-direction:column-reverse;
  }
  #createZoocriadero .form-actions .btn{
    justify-content:center;
    width:100%;
  }
}
</style>

<div class="page-header">
  <div class="mb-3 contenedortext rounded-4">
      <br>
      <div class="d-flex align-items-center justify-content-center gap-2">
          <i class="bx bxs-leaf" style="font-size: 2.5rem; color: #fff;"></i>
          <h1 class="fw-bold mb-0">Registro de Zoocriaderos</h1>
      </div>
      <br>
  </div>

  <div class="card" id="table">
    <form action="<?php echo getUrl("Zoocriadero", "Zoocriadero", "validarRegistrar") ?>" method="POST" id="createZoocriadero">

      <div class="form-intro">
        <h4 class="mb-4">Datos del Zoocriadero</h4>
        <p>Completa la informaci&oacute;n para registrar un nuevo zoocriadero. Los campos con <span class="text-danger">*</span> son obligatorios.</p>
      </div>

      <!-- ============ Identificación ============ -->
      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-barcode"></i></span>
          Identificaci&oacute;n del Zoocriadero
        </h5>

        <div class="mb-3">
          <label for="codigo_zoocriadero" class="form-label"><i class="bx bx-hash"></i>C&oacute;digo del Zoocriadero <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="codigo_zoocriadero" name="codigo_zoocriadero" value="ZOOCRIADERO#<?php echo $id_zoo[0]['max'] + 1; ?>" disabled>
          <input type="hidden" name="codigo" value="ZOOCRIADERO#<?php echo $id_zoo[0]['max'] + 1; ?>">
        </div>
      </div>

      <!-- ============ Dirección ============ -->
      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-map-pin"></i></span>
          Direcci&oacute;n
        </h5>

        <div class="address-example-box">
          <div class="example-title">
            <i class="bx bx-bulb"></i>
            <span>&iquest;C&oacute;mo se arma una direcci&oacute;n?</span>
          </div>
          <p class="mb-0 text-muted" style="font-size:.9rem;">
            Ejemplo: <strong>Calle 5A Sur # 20B-15</strong>
          </p>
          <div class="address-breakdown">
            <span class="chip chip-blue">Calle 5</span><span class="chip-label">V&iacute;a donde queda el sitio</span>
            <span class="chip chip-blue">A</span><span class="chip-label">Sufijo de esa v&iacute;a (si tiene letra)</span>
            <span class="chip chip-blue">Sur</span><span class="chip-label">Prefijo de cruce (zona de la v&iacute;a que cruza)</span>
            <span class="chip chip-blue">20</span><span class="chip-label">V&iacute;a generadora: la m&aacute;s cercana que cruza</span>
            <span class="chip chip-blue">B</span><span class="chip-label">Sufijo de la v&iacute;a generadora (si tiene letra)</span>
            <span class="chip chip-blue">-15</span><span class="chip-label">Placa: metros desde la esquina</span>
          </div>
        </div>

        <div class="row row-cols-2">
          <div class="col mb-3">
            <label for="via_principal" class="form-label"><i class="bx bx-navigation"></i>V&iacute;a principal <span class="text-danger">*</span></label>
            <select class="form-select" id="via_principal" name="via_principal" required>
              <option value="" selected disabled>Seleccione la v&iacute;a principal</option>
              <?php foreach (VIA_PRINCIPAL as $v): ?>
                <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col mb-3">
            <label for="numero_via" class="form-label"><i class="bx bx-hash"></i>N&uacute;mero de la v&iacute;a <span class="text-danger">*</span></label>
            <select class="form-select" id="numero_via" name="numero_via" required>
              <option value="" selected disabled>Seleccione el n&uacute;mero</option>
              <?php foreach ($numero_de_via as $v): ?>
                <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col mb-3">
            <label for="sufijo_via" class="form-label"><i class="bx bx-font"></i>Sufijo de la v&iacute;a</label>
            <select class="form-select" id="sufijo_via" name="sufijo_via">
              <option value="" selected disabled>Sin sufijo</option>
              <?php foreach (SUFIJO_VIA as $key => $label): ?>
                <option value="<?php echo $key; ?>"><?php echo $label; ?> (<?php echo $key; ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col mb-3">
            <label for="cruce_prefijo" class="form-label"><i class="bx bx-map-alt"></i>Prefijo de cruce</label>
            <select class="form-select" id="cruce_prefijo" name="cruce_prefijo">
              <option value="" selected disabled>Sin prefijo</option>
              <?php foreach (CRUCE_PREFIJO as $key => $label): ?>
                <option value="<?php echo $key; ?>"><?php echo $label; ?> (<?php echo $key; ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col mb-3">
            <label for="via_generadora" class="form-label"><i class="bx bx-directions"></i>N&uacute;mero de la v&iacute;a generadora <span class="text-danger">*</span></label>
            <select class="form-select" id="via_generadora" name="via_generadora" required>
              <option value="" selected disabled>Seleccione el n&uacute;mero</option>
              <?php foreach ($numero_de_la_via_generadora as $v): ?>
                <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col mb-3">
            <label for="sufijo_generadora" class="form-label"><i class="bx bx-font"></i>Sufijo de la v&iacute;a generadora</label>
            <select class="form-select" id="sufijo_generadora" name="sufijo_generadora">
              <option value="" selected disabled>Sin sufijo</option>
              <?php foreach (SUFIJO_VIA as $key => $label): ?>
                <option value="<?php echo $key; ?>"><?php echo $label; ?> (<?php echo $key; ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="mb-1">
          <label for="placa" class="form-label"><i class="bx bx-home-alt"></i>N&uacute;mero de placa <span class="text-danger">*</span></label>
          <select class="form-select" id="placa" name="placa" required>
            <option value="" selected disabled>Seleccione la placa</option>
            <?php foreach ($numero_de_placa as $v): ?>
              <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="live-preview" id="direccionPreview">
          <i class="bx bx-map-pin"></i>
          <span id="direccionPreviewTexto">La direcci&oacute;n aparecer&aacute; aqu&iacute; a medida que la completas...</span>
        </div>
      </div>

      <!-- ============ Personal Asignado y Estado ============ -->
      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-group"></i></span>
          Personal Asignado y Estado
        </h5>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="id_usuario" class="form-label"><i class="bx bx-user-check"></i>Coordinador asignado <span class="text-danger">*</span></label>
            <?php if (empty($coord)): ?>
              <select class="form-select" disabled>
                <option value="" selected>No hay coordinadores disponibles</option>
              </select>
              <input type="hidden" name="id_coor" value="">
            <?php else: ?>
              <select class="form-select" id="id_usuario" name="id_coor" required>
                <option value="" selected disabled>Selecciona un Coordinador</option>
                <?php foreach ($coord as $usu): ?>
                  <option value="<?php echo $usu['id_usuario']; ?>">
                    <?php echo $usu['primer_nombre'] . " " . $usu['segundo_nombre'] . " " . $usu['primer_apellido'] . " " . $usu['segundo_apellido']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            <?php endif; ?>
          </div>

          <div class="col-md-6 mb-3">
            <label for="id_estado" class="form-label"><i class="bx bx-toggle-left"></i>Estado <span class="text-danger">*</span></label>
            <select class="form-select" id="id_estado" name="id_estado" required>
              <option value="" selected disabled>Selecciona un estado</option>
              <?php foreach ($estados as $est): ?>
                <option value="<?php echo $est['id_estado']; ?>">
                  <?php echo $est['nombre_estado']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label"><i class="bx bx-user-voice"></i>Auxiliares asignados <span class="text-danger">*</span></label>
          <div class="aux-container">
            <?php if (empty($auxi)) { ?>
              <p class="text-muted mb-0">No hay auxiliares disponibles</p>
            <?php } else { ?>
              <?php foreach ($auxi as $usu) { ?>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox"
                         name="usuarios_asignados[]"
                         value="<?php echo $usu['id_usuario']; ?>"
                         id="user<?php echo $usu['id_usuario']; ?>">

                  <label class="form-check-label" for="user<?php echo $usu['id_usuario']; ?>">
                    <?php echo $usu['primer_nombre'] . " " .
                               $usu['segundo_nombre'] . " " .
                               $usu['primer_apellido'] . " " .
                               $usu['segundo_apellido']; ?>
                  </label>
                </div>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 form-actions">
        <button type="reset" class="btn btn-outline-secondary"><i class="bx bx-eraser"></i>Limpiar</button>
        <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i>Guardar</button>
      </div>

    </form>
  </div>
</div>

<script>
  (function() {
    const campos = ['via_principal', 'numero_via', 'sufijo_via', 'cruce_prefijo', 'via_generadora', 'sufijo_generadora', 'placa'];
    const preview = document.getElementById('direccionPreviewTexto');
    const textoOriginal = 'La dirección aparecerá aquí a medida que la completas...';

    function textoDe(select) {
      if (!select.value) return '';
      const opt = select.options[select.selectedIndex];
      return opt ? opt.textContent.replace(/\s*\(.*\)$/, '').trim() : '';
    }

    function actualizarPreview() {
      const via = document.getElementById('via_principal');
      const num = document.getElementById('numero_via');
      const sufVia = document.getElementById('sufijo_via');
      const prefCruce = document.getElementById('cruce_prefijo');
      const viaGen = document.getElementById('via_generadora');
      const sufGen = document.getElementById('sufijo_generadora');
      const placa = document.getElementById('placa');

      if (!via || !num || !viaGen || !placa) return;

      if (!via.value || !num.value || !viaGen.value || !placa.value) {
        preview.textContent = textoOriginal;
        return;
      }

      const parteVia = `${textoDe(via)} ${num.value}${sufVia && sufVia.value ? sufVia.value : ''}`;
      const parteCruce = `${prefCruce && prefCruce.value ? textoDe(prefCruce) + ' ' : ''}${viaGen.value}${sufGen && sufGen.value ? sufGen.value : ''}`;
      const direccion = `${parteVia} # ${parteCruce}-${placa.value}`;

      preview.textContent = direccion;
    }

    campos.forEach(id => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('change', actualizarPreview);
    });
  })();
</script>