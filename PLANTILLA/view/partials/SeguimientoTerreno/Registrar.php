<?php
if (!function_exists('terreno_normalizar')) {
  function terreno_normalizar($texto)
  {
    $texto = mb_strtolower($texto, 'UTF-8');
    $acentos = ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n'];
    return strtr($texto, $acentos);
  }
}
if (!function_exists('terreno_tipoActividad')) {
  function terreno_tipoActividad($nombre)
  {
    $n = terreno_normalizar($nombre);
    if (strpos($n, 'inspecc') !== false)
      return 'inspeccion';
    // IMPORTANTE: 'resiembra' se valida ANTES que 'siembra' porque "resiembra" contiene "siembra"
    if (strpos($n, 'resiembra') !== false)
      return 'resiembra';
    if (strpos($n, 'siembra') !== false)
      return 'siembra';
    if (strpos($n, 'seguimiento') !== false)
      return 'seguimiento_act';
    return null;
  }
}
?>
<style>
  .terreno-seg-form {
    --accent: #3b5bdb;
    --accent-dark: #2f49b5;
    --accent-soft: #edf1ff;
    --ink: #1f2937;
    --muted: #6b7280;
    --line: #dfe4ec;
    --field: #f7f9fc;
  }

  .terreno-seg-form #table {
    border: 0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(31, 41, 55, .10), 0 1px 3px rgba(31, 41, 55, .06);
    background: #fff;
    padding: 2rem 2.25rem 1.75rem;
  }

  .terreno-seg-form .form-section {
    margin-bottom: 1.75rem;
  }

  .terreno-seg-form .section-title {
    display: flex;
    align-items: center;
    gap: .65rem;
    margin-bottom: 1.1rem;
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--ink);
  }

  .terreno-seg-form .section-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.1rem;
    height: 2.1rem;
    border-radius: 10px;
    background: var(--accent-soft);
    color: var(--accent);
    font-size: 1.15rem;
  }

  .terreno-seg-form .section-title::after {
    content: "";
    flex: 1;
    height: 1px;
    background: var(--line);
  }

  .terreno-seg-form .form-label {
    display: flex;
    align-items: center;
    gap: .4rem;
    margin-bottom: .4rem;
    font-size: .9rem;
    font-weight: 600;
    color: var(--ink);
  }

  .terreno-seg-form .form-control,
  .terreno-seg-form .form-select {
    min-height: 2.9rem;
    padding: .65rem .95rem;
    border: 1.5px solid var(--line);
    border-radius: 12px;
    background-color: var(--field);
    color: var(--ink);
    font-size: .95rem;
    transition: border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
  }

  .terreno-seg-form .form-control::placeholder {
    color: #a3acba;
  }

  .terreno-seg-form .form-control:hover,
  .terreno-seg-form .form-select:hover {
    border-color: #c3cbd9;
  }

  .terreno-seg-form .form-control:focus,
  .terreno-seg-form .form-select:focus {
    background-color: #fff;
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(59, 91, 219, .16);
    outline: 0;
  }

  .terreno-seg-form .form-control:disabled,
  .terreno-seg-form .form-select:disabled {
    background-color: #eef0f4;
    color: var(--muted);
    cursor: not-allowed;
  }

  .terreno-seg-form .form-actions {
    margin-top: .5rem;
    padding-top: 1.4rem;
    border-top: 1px solid var(--line);
    display: flex;
    justify-content: flex-end;
    gap: .5rem;
  }

  .terreno-seg-form .btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .65rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: transform .12s ease, box-shadow .12s ease, background-color .12s ease;
  }

  .terreno-seg-form .btn-primary {
    background-color: var(--accent);
    border-color: var(--accent);
    box-shadow: 0 4px 12px rgba(59, 91, 219, .28);
  }

  .terreno-seg-form .btn-primary:hover {
    background-color: var(--accent-dark);
    border-color: var(--accent-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(59, 91, 219, .34);
  }

  .terreno-seg-form .btn-outline-secondary {
    border-width: 1.5px;
    color: var(--muted);
    border-color: var(--line);
    background: #fff;
  }

  .terreno-seg-form .btn-outline-secondary:hover {
    background: var(--field);
    color: var(--ink);
    border-color: #c3cbd9;
  }

  .terreno-seg-form .activity-item {
    margin-bottom: .9rem;
  }

  .terreno-seg-form .activity-item > .form-check {
    padding: .75rem 1rem;
    border: 1.5px solid var(--line);
    border-radius: 12px;
    background: var(--field);
    display: flex;
    align-items: center;
    gap: .5rem;
    transition: border-color .15s ease, background-color .15s ease;
  }

  .terreno-seg-form .form-check-label {
    font-weight: 600;
    color: var(--ink);
    cursor: pointer;
  }

  .terreno-seg-form .activity-edit-card {
    display: none;
    margin: .6rem 0 1.25rem .5rem;
    padding: 1.25rem 1.5rem;
    border: 1px solid var(--line);
    border-left: 3px solid var(--accent);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 6px 18px rgba(31, 41, 55, .06);
  }

  .terreno-seg-form .activity-edit-card.is-open {
    display: block;
  }

  .terreno-seg-form .section-title.small-title {
    font-size: .92rem;
    margin-bottom: .75rem;
  }

  .terreno-seg-form .activity-edit-card .form-check {
    margin-bottom: .4rem;
  }

  .terreno-seg-form .activity-edit-card .form-check .form-check-label {
    font-weight: 500;
  }

  .terreno-seg-form .form-check-inline {
    margin-right: 1.25rem;
    padding-left: 0;
  }

  .terreno-seg-form .form-check-inline .form-check-input {
    margin-right: 0.4rem;
  }
</style>

<div class="page-header terreno-seg-form">
  <div class="mb-3 contenedortext rounded-4">
    <br>
    <div class="d-flex align-items-center justify-content-center gap-2">
      <i class="bx bxs-map" style="font-size: 2.5rem; color: #fff;"></i>
      <h1 class="fw-bold mb-0">Registrar Seguimiento Terreno</h1>
    </div>
    <br>
  </div>

  <div class="card" id="table">
    <form action="<?php echo getUrl("SeguimientoTerreno", "SeguimientoTerreno", "postRegistrar") ?>" method="POST"
      enctype="multipart/form-data">

      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-info-circle"></i></span>
          Información del seguimiento
        </h5>
        <div class="mb-3">
          <label for="codigo_tanque" class="form-label">Codigo del Seguimiento</label>
          <input type="text" class="form-control" id="codigo_tanque" name="codigo_tanque"
            value="SEGUIMIENTO#<?php echo $id_seg[0]['max'] + 1; ?>" disabled>
          <input type="hidden" name="codigo" value="SEGUIMIENTO#<?php echo $id_seg[0]['max'] + 1; ?>">
        </div>
        <div class="mb-4">
          <label for="select_ter" class="form-label">Sitio*</label>
          <select class="form-select" id="select_ter" name="select_ter" required>
            <option value="" selected disabled>Selecciona un Sitio</option>
            <?php foreach ($sitio as $zoo) { ?>
              <option value="<?php echo $zoo['id_sitio']; ?>">
                <?php echo $zoo['nombre_sitio']; ?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-group"></i></span>
          Asignación
        </h5>
        <div class="mb-4">
          <label for="selectTerreno" class="form-label">Deposito*</label>
          <select class="form-select" id="selectTerreno" name="selectTerreno" required disabled>
            <option value="" selected disabled>Primero selecciona un Sitio</option>
          </select>
        </div>
        <div class="mb-4">
          <label for="selectUsuarios" class="form-label">Auxiliar Asignado*</label>
          <select class="form-select" id="selectUsuarios" name="selectUsuarios" required disabled>
            <option value="" selected>Primero selecciona un Sitio</option>
          </select>
        </div>
      </div>

      <?php
// Orden fijo según el mapa de proceso de Trabajo de Terreno
$orden_proceso_terreno = [
  'inspeccion'      => 1,
  'siembra'         => 2,
  'seguimiento_act' => 3,
  'resiembra'       => 4,
];

usort($actividades, function ($a, $b) use ($orden_proceso_terreno) {
  $tipoA = terreno_tipoActividad($a['nombre_actividad']);
  $tipoB = terreno_tipoActividad($b['nombre_actividad']);

  $ordenA = $orden_proceso_terreno[$tipoA] ?? 999;
  $ordenB = $orden_proceso_terreno[$tipoB] ?? 999;

  return $ordenA <=> $ordenB;
});
?>
      

      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-list-check"></i></span>
          Actividades a realizar
        </h5>
        <?php if (empty($actividades)): ?>
          <p class="text-muted">No hay actividades disponibles</p>
        <?php else: ?>
          <?php foreach ($actividades as $act):
            $tipo = terreno_tipoActividad($act['nombre_actividad']);
          ?>
            <div class="activity-item">
              <div class="form-check">
                <input class="form-check-input activity-checkbox" type="checkbox" name="actividades[]"
                  style="width: 1.5em; height: 1.5em;" value="<?php echo $act['id_actividad_terreno']; ?>"
                  id="act<?php echo $act['id_actividad_terreno']; ?>"
                  data-panel="panel-<?php echo $act['id_actividad_terreno']; ?>">
                <label class="form-check-label" for="act<?php echo $act['id_actividad_terreno']; ?>">
                  <?php echo $act['nombre_actividad']; ?>
                </label>
              </div>
              <?php if ($tipo): ?>
                <div class="activity-edit-card" id="panel-<?php echo $act['id_actividad_terreno']; ?>">
                  <h6 class="section-title small-title">
                    <span class="section-icon"><i class="bx bx-edit"></i></span>
                    <?php echo $act['nombre_actividad']; ?>
                  </h6>
                  <?php if ($tipo === 'inspeccion'): ?>
                    <div class="mb-3">
                      <label class="form-label d-block">Depósitos permanentes de agua detectados*</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="depositoDetectado" id="depositoSi"
                          value="1" required>
                        <label class="form-check-label" for="depositoSi">Sí</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="depositoDetectado" id="depositoNo"
                          value="0">
                        <label class="form-check-label" for="depositoNo">No</label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="phMedido" class="form-label">PH medido*</label>
                      <input type="number" step="0.01" class="form-control" id="phMedido" name="phMedido"
                        placeholder="Ingrese el PH medido" required>
                    </div>
                    <div class="mb-3">
                      <label for="temperatura" class="form-label">Temperatura (T) medida*</label>
                      <input type="number" step="0.01" class="form-control" id="temperatura" name="temperatura"
                        placeholder="Ingrese la temperatura" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label d-block">Presencia de larvas de zancudos*</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaLarvas" id="larvasSi"
                          value="1" required>
                        <label class="form-check-label" for="larvasSi">Sí</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaLarvas" id="larvasNo"
                          value="0">
                        <label class="form-check-label" for="larvasNo">No</label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="obserInsp" class="form-label">Observaciones</label>
                      <input type="text" class="form-control" id="obserInsp" name="obserInsp"
                        placeholder="Ingrese las observaciones">
                    </div>
                  <?php elseif ($tipo === 'siembra'): ?>
                    <div class="mb-3">
                      <label for="pecesEmpacados" class="form-label">Cantidad de peces empacados en bolsas
                        plásticas*</label>
                      <input type="number" class="form-control" id="pecesEmpacados" name="pecesEmpacados"
                        placeholder="Ingrese la cantidad de peces empacados" required>
                    </div>
                    <div class="mb-3">
                      <label for="tiempoAclimat" class="form-label">Tiempo de aclimatación (minutos)*</label>
                      <input type="number" class="form-control" id="tiempoAclimat" name="tiempoAclimat"
                        placeholder="Ingrese el tiempo de aclimatación" required>
                    </div>
                    <div class="mb-3">
                      <label for="hembrasSembradas" class="form-label">Cantidad de hembras sembradas*</label>
                      <input type="number" class="form-control" id="hembrasSembradas" name="hembrasSembradas"
                        placeholder="Ingrese la cantidad de hembras sembradas" required>
                    </div>
                    <div class="mb-3">
                      <label for="machosSembrados" class="form-label">Cantidad de machos sembrados*</label>
                      <input type="number" class="form-control" id="machosSembrados" name="machosSembrados"
                        placeholder="Ingrese la cantidad de machos sembrados" required>
                    </div>
                    <div class="mb-3">
                      <label for="litrosAgua" class="form-label">Volumen de agua utilizado (L)*</label>
                      <input type="number" step="0.01" class="form-control" id="litrosAgua" name="litrosAgua"
                        placeholder="Ingrese el volumen de agua utilizado" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label d-block">Presencia de larvas de zancudos*</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaLarvasSiem"
                          id="larvasSiSiem" value="1" required>
                        <label class="form-check-label" for="larvasSiSiem">Sí</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaLarvasSiem"
                          id="larvasNoSiem" value="0">
                        <label class="form-check-label" for="larvasNoSiem">No</label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label d-block">Presencia de peces*</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaPecesSiem" id="pecesSiSiem"
                          value="1" required>
                        <label class="form-check-label" for="pecesSiSiem">Sí</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaPecesSiem" id="pecesNoSiem"
                          value="0">
                        <label class="form-check-label" for="pecesNoSiem">No</label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="obserSiem" class="form-label">Observaciones</label>
                      <input type="text" class="form-control" id="obserSiem" name="obserSiem"
                        placeholder="Ingrese las observaciones">
                    </div>
                  <?php elseif ($tipo === 'seguimiento_act'): ?>
                    <div class="mb-3">
                      <label for="numeroVisita" class="form-label">Número de visita de seguimiento*</label>
                      <select class="form-control" id="numeroVisita" name="numeroVisita" required>
                        <option value="1">1ra visita</option>
                        <option value="2">2da visita</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label d-block">Depósitos permanentes con agua visitados*</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="depositoVisitado" id="depVisSi"
                          value="1" required>
                        <label class="form-check-label" for="depVisSi">Sí</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="depositoVisitado" id="depVisNo"
                          value="0">
                        <label class="form-check-label" for="depVisNo">No</label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label d-block">Presencia de larvas de zancudos*</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaLarvasSeg"
                          id="larvasSiSeg" value="1" required>
                        <label class="form-check-label" for="larvasSiSeg">Sí</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaLarvasSeg"
                          id="larvasNoSeg" value="0">
                        <label class="form-check-label" for="larvasNoSeg">No</label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label d-block">Presencia de peces*</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaPecesSeg" id="pecesSiSeg"
                          value="1" required>
                        <label class="form-check-label" for="pecesSiSeg">Sí</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaPecesSeg" id="pecesNoSeg"
                          value="0">
                        <label class="form-check-label" for="pecesNoSeg">No</label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="obserSeg" class="form-label">Observaciones</label>
                      <input type="text" class="form-control" id="obserSeg" name="obserSeg"
                        placeholder="Ingrese las observaciones">
                    </div>
                  <?php elseif ($tipo === 'resiembra'): ?>
                    <div class="mb-3">
                      <label for="canHembras" class="form-label">Cantidad de hembras sembradas*</label>
                      <input type="number" class="form-control" id="canHembras" name="canHembras" min="0"
                        placeholder="Ingrese la cantidad de hembras" required>
                    </div>
                    <div class="mb-3">
                      <label for="canMachos" class="form-label">Cantidad de machos sembrados*</label>
                      <input type="number" class="form-control" id="canMachos" name="canMachos" min="0"
                        placeholder="Ingrese la cantidad de machos" required>
                    </div>
                    <div class="mb-3">
                      <label for="canGuppies" class="form-label">Cantidad de peces guppies sembrados*</label>
                      <input type="number" class="form-control" id="canGuppies" name="canGuppies" min="0"
                        placeholder="Ingrese la cantidad de guppies" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label d-block">Presencia de larvas de zancudos*</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaLarvasResi"
                          id="larvasSiResi" value="1" required>
                        <label class="form-check-label" for="larvasSiResi">Sí</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaLarvasResi"
                          id="larvasNoResi" value="0">
                        <label class="form-check-label" for="larvasNoResi">No</label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label d-block">Presencia de peces*</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaPecesResi" id="pecesSiResi"
                          value="1" required>
                        <label class="form-check-label" for="pecesSiResi">Sí</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presenciaPecesResi" id="pecesNoResi"
                          value="0">
                        <label class="form-check-label" for="pecesNoResi">No</label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="obserResi" class="form-label">Observaciones</label>
                      <input type="text" class="form-control" id="obserResi" name="obserResi"
                        placeholder="Ingrese las observaciones">
                    </div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <div class="form-actions">
        <button type="reset" class="btn btn-outline-secondary"><i class="bx bx-eraser"></i>Limpiar</button>
        <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i>Guardar seguimiento</button>
      </div>
    </form>
  </div>
    <!-- Modal: actividad requerida -->
  <div class="modal fade" id="modalActividadRequerida" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border: 0; border-radius: 16px; overflow: hidden; box-shadow: 0 12px 40px rgba(31,41,55,.15);">
        <div class="modal-body text-center p-4">
          <div style="width: 56px; height: 56px; border-radius: 14px; background: #edf1ff; color: #3b5bdb; display: inline-flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 1rem;">
            <i class="bx bx-error-circle"></i>
          </div>
          <h5 style="font-weight: 700; color: #1f2937; margin-bottom: .5rem;">Actividad requerida</h5>
          <p style="color: #6b7280; margin-bottom: 1.5rem;">Debes seleccionar al menos una actividad para continuar.</p>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="border-radius: 10px; padding: .55rem 1.4rem; font-weight: 600;">
            Entendido
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.querySelector('#select_ter').addEventListener('change', function (e) {
    const idsitio = e.target.value;
    fetch('ajax.php?modulo=SeguimientoTerreno&controlador=SeguimientoTerreno&funcion=getSitios&id_sitio=' + idsitio)
      .then(response => response.json())
      .then(data => {
        const selectTerreno = document.querySelector('#selectTerreno');
        if (data.terreno.length === 0) {
          selectTerreno.innerHTML = '<option value="">No hay terreno disponibles</option>';
          selectTerreno.disabled = true;
        } else {
          let opcionesTerreno = '';
          data.terreno.forEach(terreno => {
            opcionesTerreno += `<option value="${terreno.id_tipo_deposito}">${terreno.nombre}</option>`;
          });
          selectTerreno.innerHTML = opcionesTerreno;
          selectTerreno.disabled = false;
        }
        const selectUsuarios = document.querySelector('#selectUsuarios');
        if (data.usuarios.length === 0) {
          selectUsuarios.innerHTML = '<option value="">No hay auxiliares disponibles</option>';
          selectUsuarios.disabled = true;
        } else {
          let opcionesUsuarios = '';
          data.usuarios.forEach(usuario => {
            opcionesUsuarios += `<option value="${usuario.id_usuario}">${usuario.primer_nombre} ${usuario.primer_apellido}</option>`;
          });
          selectUsuarios.innerHTML = opcionesUsuarios;
          selectUsuarios.disabled = false;
        }
      });
  });

 (function () {
  const checks = document.querySelectorAll('.activity-checkbox');

  function setPanel(checkbox, abierto, enfocar) {
    const panel = document.getElementById(checkbox.dataset.panel);
    if (!panel) return;
    const campos = panel.querySelectorAll('input, select, textarea');
    panel.classList.toggle('is-open', abierto);
    
    campos.forEach(campo => {
      campo.disabled = !abierto;
    });

    if (abierto && enfocar && campos[0]) campos[0].focus();
  }

  checks.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      setPanel(this, this.checked, true);
    });
  });

  const form = document.querySelector('.terreno-seg-form form');
  if (form) {
    // Limpiar: cerrar paneles
    form.addEventListener('reset', function () {
      setTimeout(function () {
        checks.forEach(cb => setPanel(cb, false, false));
      }, 0);
    });

    // Validar y asegurar envío de datos
    form.addEventListener('submit', function (e) {
      const algunaMarcada = document.querySelectorAll('.activity-checkbox:checked').length > 0;
      
      if (!algunaMarcada) {
        e.preventDefault();
        const modal = new bootstrap.Modal(document.getElementById('modalActividadRequerida'));
        modal.show();
        return false;
      }

      // ASEGURAR QUE LOS CAMPOS DE PANELES ACTIVOS NO ESTÉN DISABLED
      checks.forEach(cb => {
        if (cb.checked) {
          const panel = document.getElementById(cb.dataset.panel);
          if (panel) {
            panel.querySelectorAll('input, select, textarea').forEach(campo => {
              campo.disabled = false;
            });
          }
        }
      });
    });
  }

  // Estado inicial
  checks.forEach(cb => setPanel(cb, cb.checked, false));
})();
</script>