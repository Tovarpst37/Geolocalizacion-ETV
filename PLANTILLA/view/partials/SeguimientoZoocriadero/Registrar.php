<?php
// [CAMBIO] Se protegen las funciones para que no falle si la vista se incluye más de una vez
if (!function_exists('zoo_normalizar')) {
  function zoo_normalizar($texto)
  {
    $texto = mb_strtolower($texto, 'UTF-8');
    $acentos = ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n'];
    return strtr($texto, $acentos);
  }
}

if (!function_exists('zoo_tipoActividad')) {
  function zoo_tipoActividad($nombre)
  {
    $n = zoo_normalizar($nombre);
    if (strpos($n, 'aliment') !== false)
      return 'alimentacion';
    if (strpos($n, 'muert') !== false || strpos($n, 'nacid') !== false)
      return 'muertos_nacidos';
    if (strpos($n, 'limpi') !== false)
      return 'limpieza';
    // [CAMBIO] "nive" en lugar de "nivel": tolera nombres mal escritos como "Ajustes de Nive"
    if (strpos($n, 'nive') !== false)
      return 'ajuste_nivel';
    if (strpos($n, 'lavad') !== false)
      return 'lavado';
    return null;
  }
}
?>
<style>
  .zoo-seg-form {
    --accent: #3b5bdb;
    --accent-dark: #2f49b5;
    --accent-soft: #edf1ff;
    --ink: #1f2937;
    --muted: #6b7280;
    --line: #dfe4ec;
    --field: #f7f9fc;
  }

  .zoo-seg-form #table {
    border: 0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(31, 41, 55, .10), 0 1px 3px rgba(31, 41, 55, .06);
    background: #fff;
    padding: 2rem 2.25rem 1.75rem;
  }

  .zoo-seg-form .form-section {
    margin-bottom: 1.75rem;
  }

  .zoo-seg-form .section-title {
    display: flex;
    align-items: center;
    gap: .65rem;
    margin-bottom: 1.1rem;
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--ink);
  }

  .zoo-seg-form .section-icon {
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

  .zoo-seg-form .section-title::after {
    content: "";
    flex: 1;
    height: 1px;
    background: var(--line);
  }

  .zoo-seg-form .form-label {
    display: flex;
    align-items: center;
    gap: .4rem;
    margin-bottom: .4rem;
    font-size: .9rem;
    font-weight: 600;
    color: var(--ink);
  }

  .zoo-seg-form .form-control,
  .zoo-seg-form .form-select {
    min-height: 2.9rem;
    padding: .65rem .95rem;
    border: 1.5px solid var(--line);
    border-radius: 12px;
    background-color: var(--field);
    color: var(--ink);
    font-size: .95rem;
    transition: border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
  }

  .zoo-seg-form .form-control::placeholder {
    color: #a3acba;
  }

  .zoo-seg-form .form-control:hover,
  .zoo-seg-form .form-select:hover {
    border-color: #c3cbd9;
  }

  .zoo-seg-form .form-control:focus,
  .zoo-seg-form .form-select:focus {
    background-color: #fff;
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(59, 91, 219, .16);
    outline: 0;
  }

  .zoo-seg-form .form-control:disabled,
  .zoo-seg-form .form-select:disabled {
    background-color: #eef0f4;
    color: var(--muted);
    cursor: not-allowed;
  }

  .zoo-seg-form .form-actions {
    margin-top: .5rem;
    padding-top: 1.4rem;
    border-top: 1px solid var(--line);
    display: flex;
    justify-content: flex-end;
    gap: .5rem;
  }

  .zoo-seg-form .btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .65rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: transform .12s ease, box-shadow .12s ease, background-color .12s ease;
  }

  .zoo-seg-form .btn-primary {
    background-color: var(--accent);
    border-color: var(--accent);
    box-shadow: 0 4px 12px rgba(59, 91, 219, .28);
  }

  .zoo-seg-form .btn-primary:hover {
    background-color: var(--accent-dark);
    border-color: var(--accent-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(59, 91, 219, .34);
  }

  .zoo-seg-form .btn-outline-secondary {
    border-width: 1.5px;
    color: var(--muted);
    border-color: var(--line);
    background: #fff;
  }

  .zoo-seg-form .btn-outline-secondary:hover {
    background: var(--field);
    color: var(--ink);
    border-color: #c3cbd9;
  }

  .zoo-seg-form .activity-item {
    margin-bottom: .9rem;
  }

  /* [CAMBIO] ">" para que el estilo de "pastilla" solo aplique al check de la actividad
     y NO a los checks internos del panel (p. ej. los tipos de limpieza) */
  .zoo-seg-form .activity-item>.form-check {
    padding: .75rem 1rem;
    border: 1.5px solid var(--line);
    border-radius: 12px;
    background: var(--field);
    display: flex;
    align-items: center;
    gap: .5rem;
    transition: border-color .15s ease, background-color .15s ease;
  }

  .zoo-seg-form .form-check-label {
    font-weight: 600;
    color: var(--ink);
    cursor: pointer;
  }

  .zoo-seg-form .activity-edit-card {
    display: none;
    margin: .6rem 0 1.25rem .5rem;
    padding: 1.25rem 1.5rem;
    border: 1px solid var(--line);
    border-left: 3px solid var(--accent);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 6px 18px rgba(31, 41, 55, .06);
  }

  .zoo-seg-form .activity-edit-card.is-open {
    display: block;
  }

  .zoo-seg-form .section-title.small-title {
    font-size: .92rem;
    margin-bottom: .75rem;
  }

  /* [CAMBIO] Los tipos de limpieza dentro del panel: aspecto simple y legible */
  .zoo-seg-form .activity-edit-card .form-check {
    margin-bottom: .4rem;
  }

  .zoo-seg-form .activity-edit-card .form-check .form-check-label {
    font-weight: 500;
  }
</style>
<div class="page-header zoo-seg-form">
  <div class="mb-3 contenedortext rounded-4">
    <br>
    <div class="d-flex align-items-center justify-content-center gap-2">
      <i class="bx bxs-user-detail" style="font-size: 2.5rem; color: #fff;"></i>
      <h1 class="fw-bold mb-0">Registar Seguimiento de zoocreadero</h1>
    </div>
    <br>
  </div>

  <div class="card" id="table">
    <form action="<?php echo getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "postRegistrar") ?>"
      method="POST" enctype="multipart/form-data">

      <div class="form-section">
        <h5 class="section-title">
          <span class="section-icon"><i class="bx bx-info-circle"></i></span>

        </h5>

        <div class="mb-3">
          <label for="codigo_tanque" class="form-label">Codigo del Seguimiento</label>
          <input type="text" class="form-control" id="codigo_Seguimiento" name="codigo_Seguimiento"
            value="SEGUIMIENTO#<?php echo $id_seg[0]['max'] + 1; ?>" disabled>
          <input type="hidden" name="codigo" value="SEGUIMIENTO#<?php echo $id_seg[0]['max'] + 1; ?>">
        </div>

        <div class="mb-4">
          <label for="id_estado" class="form-label">Zoocriadero*</label>
          <select class="form-select" id="select_zoo" name="select_zoo" required>
            <option value="" selected disabled>Selecciona un Zoocriadero</option>
            <?php foreach ($zoocriaderos as $zoo) { ?>
              <option value="<?php echo $zoo['id_zoocriadero']; ?>">
                <?php echo $zoo['cod_zoocriadero']; ?>
              </option>
            <?php }; ?>
          </select>
        </div>



        <div class="form-section">
          <h5 class="section-title">
            <span class="section-icon"><i class="bx bx-group"></i></span>
            Asignación
          </h5>

          <div class="mb-4">
            <label for="id_estado" class="form-label">Tanque*</label>
            <select class="form-select" id="selectTanques" name="selectTanques" required disabled>
              <option value="" selected disabled>Primero selecciona un zoocriadero</option>
            </select>
          </div>

          <div class="mb-4">
            <label for="id_estado" class="form-label">Auxiliar Asignado*</label>
            <select class="form-select" id="selectUsuarios" name="selectUsuarios" required disabled>
              <option value="" selected>Primero selecciona un zoocriadero</option>
            </select>
          </div>

        </div>

        <?php
// [NUEVO] Orden fijo según el mapa de proceso del Zoocriadero (imagen de referencia)
$orden_proceso = [
  'alimentacion'      => 1,
  'muertos_nacidos'   => 2, // Recolección de peces muertos y nacidos
  'limpieza'          => 3,
  'ajuste_nivel'      => 4,
  'lavado'            => 5,
];

usort($actividades, function ($a, $b) use ($orden_proceso) {
  $tipoA = zoo_tipoActividad($a['nombre_actividad']);
  $tipoB = zoo_tipoActividad($b['nombre_actividad']);

  // Si el tipo no está en el mapa de proceso (actividad nueva/desconocida), se manda al final
  $ordenA = $orden_proceso[$tipoA] ?? 999;
  $ordenB = $orden_proceso[$tipoB] ?? 999;

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
              $tipo = zoo_tipoActividad($act['nombre_actividad']);
            ?>
              <div class="activity-item">
                <div class="form-check">
                  <input class="form-check-input activity-checkbox" type="checkbox" name="actividades[]"
                    style="width: 1.5em; height: 1.5em;" value="<?php echo $act['id_actividad_zoo']; ?>"
                    id="act<?php echo $act['id_actividad_zoo']; ?>"
                    data-panel="panel-<?php echo $act['id_actividad_zoo']; ?>">
                  <label class="form-check-label" for="act<?php echo $act['id_actividad_zoo']; ?>">
                    <?php echo $act['nombre_actividad']; ?>
                  </label>
                </div>

                <?php if ($tipo): ?>
                  <div class="activity-edit-card" id="panel-<?php echo $act['id_actividad_zoo']; ?>">
                    <h6 class="section-title small-title">
                      <span class="section-icon"><i class="bx bx-edit"></i></span>
                      <?php echo $act['nombre_actividad']; ?>
                    </h6>

                    <?php if ($tipo === 'alimentacion'): ?>

                      <div class="mb-3">
                        <label for="tipo_pez" class="form-label">Tipo de peces</label>
                        <select name="tipo_pez" id="tipo_pez" class="form-control">
                          <?php
                          include_once '../model/Formularioz/tipoPez.php';
                          foreach (tipoPez as $tp): ?>
                            <option value="<?php echo $tp; ?>" <?php echo (($old['tipo_pez'] ?? '') == $tp) ? 'selected' : ''; ?>>
                              <?php echo $tp; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>


                      <div class="mb-3">
                        <label for="tipo_alimen" class="form-label">Tipo de Alimentación</label>
                        <select name="tipo_alimen" id="tipo_alimen" class="form-control">
                          <?php
                          include_once '../model/Formularioz/tipoAlimen.php';
                          foreach (tipoAlimen as $tA): ?>
                            <option value="<?php echo $tA; ?>" <?php echo (($old['tipo_alimen'] ?? '') == $tA) ? 'selected' : ''; ?>>
                              <?php echo $tA; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>


                      </div>



                      <div class="mb-3">
                        <label for="ob" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="ob" name="ob" placeholder="Ingrese las observaciones"
                          required>
                      </div>




                    <?php elseif ($tipo === 'muertos_nacidos'): ?>
                      <div class="mb-3">
                        <label for="canpez" class="form-label">Cantidad de peces nacidos</label>
                        <div class="input-group">
                          <input type="number" class="form-control" id="canpez" name="canpez" placeholder="Cantidad de peces"
                            min="0" max="100" required>
                        </div>
                      </div>


                      <div class="mb-3">
                        <label for="muerto_Macho" class="form-label">Cantidad de peces machos muertos</label>
                        <div class="input-group">
                          <input type="number" class="form-control" id="muerto_Macho" name="muerto_Macho"
                            placeholder="Cantidad de machos muertos" min="0" max="100" required>
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="muerto_Hembra" class="form-label">Cantidad de peces hembra muertos</label>
                        <div class="input-group">
                          <input type="number" class="form-control" id="muerto_Hembra" name="muerto_Hembra"
                            placeholder="Cantidad de hembras muertas" min="0" max="100" required>
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="obM" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="obM" name="obM"
                          placeholder="Ingrese las observaciones" required>
                      </div>

                    <?php elseif ($tipo === 'limpieza'): ?>

                      <div class="mb-3">
                        <label class="form-label">Tipo de Limpieza</label>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="estregarParedes" name="estregarParedes" value="1">
                          <label class="form-check-label" for="estregarParedes">Sí, estregar paredes</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="aspirar" name="aspirar" value="1">
                          <label class="form-check-label" for="aspirar">Sí, aspirar</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="succionador" name="succionador" value="1">
                          <label class="form-check-label" for="succionador">Sí, succionador</label>
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="obserLi" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="obserLi" name="obserLi"
                          placeholder="Ingrese las observaciones" required>
                      </div>

                    <?php elseif ($tipo === 'ajuste_nivel'): ?>
                      <div class="mb-3">
                        <label for="nv" class="form-label">Nivel de agua adicionado</label>
                        <div class="input-group">
                          <input type="number" class="form-control" id="nv" name="nv" placeholder="Nivel de agua" min="0"
                            max="100" required>
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="ph" class="form-label">PH medido</label>
                        <div class="input-group">
                          <input type="number" class="form-control" id="ph" name="ph" placeholder="Ingrese el Ph del tanque"
                            min="0" max="14" required>
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="tem" class="form-label">Temperatura</label>
                        <div class="input-group">
                          <input type="number" class="form-control" id="tem" name="tem" placeholder="Ingrese la temperatura"
                            required>
                        </div>
                      </div>


                      <div class="mb-3">
                        <!-- [CORREGIDO] id/name cambiados de "ob" a "obAj" para que coincida con $_POST['obAj'] en postRegistrar().
                             Antes chocaba con el campo "ob" del bloque de Alimentación (mismo id/name duplicado en el DOM). -->
                        <label for="obAj" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="obAj" name="obAj" placeholder="Ingrese las observaciones">
                      </div>

                    <?php elseif ($tipo === 'lavado'): ?>


                      <div class="mb-3">
                        <label for="porcAgua" class="form-label">Porcentaje de agua cambiada</label>
                        <div class="input-group">
                          <input type="number" class="form-control" id="porcAgua" name="porcAgua" placeholder="Ej. 20" min="0"
                            max="100" required>
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="estadoTanque" class="form-label">Estado del tanque</label>
                        <input type="text" class="form-control" id="estadoTanque" name="estadoTanque"
                          placeholder="Ingrese el estado del tanque" required>
                      </div>

                      <div class="mb-3">
                        <label for="obLa" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="obLa" name="obLa" placeholder="Ingrese las observaciones"
                          required>
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
          <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i>Guardar zoocriadero</button>
        </div>

    </form>
  </div>
</div>

<script>
  document.querySelector('#select_zoo').addEventListener('change', function(e) {

    const idZoocriadero = e.target.value;

    fetch('ajax.php?modulo=SeguimientoZoocriadero&controlador=SeguimientoZoocriadero&funcion=getTanquesPorZoo&id_zoocriadero=' + idZoocriadero)
      .then(response => response.json())
      .then(data => {

        const selectTanques = document.querySelector('#selectTanques');

        if (data.tanques.length === 0) {
          selectTanques.innerHTML = '<option value="">No hay tanques disponibles</option>';
          selectTanques.disabled = true;
        } else {
          let opcionesTanques = '';
          data.tanques.forEach(tanque => {
            opcionesTanques += `<option value="${tanque.id_tanque}">${tanque.codigo_tanque}</option>`;
          });
          selectTanques.innerHTML = opcionesTanques;
          selectTanques.disabled = false;
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

  /* [CAMBIO] La lógica de abrir/cerrar paneles se movió a una función para reutilizarla
     al marcar el check, al pulsar "Limpiar" y al recargar la página. */
  (function() {
    const checks = document.querySelectorAll('.activity-checkbox');

    function setPanel(checkbox, abierto, enfocar) {
      const panel = document.getElementById(checkbox.dataset.panel);
      if (!panel) return;

      const campos = panel.querySelectorAll('input, select, textarea');
      panel.classList.toggle('is-open', abierto);
      campos.forEach(campo => campo.disabled = !abierto);

      if (abierto && enfocar && campos[0]) campos[0].focus();
    }

    // Marcar / desmarcar una actividad
    checks.forEach(function(checkbox) {
      checkbox.addEventListener('change', function() {
        setPanel(this, this.checked, true);
      });
    });

    // "Limpiar": el reset no dispara "change", así que se cierran los paneles a mano.
    // (Sin esto los campos obligatorios quedarían activos y bloquearían el envío)
    const form = document.querySelector('.zoo-seg-form form');
    if (form) {
      form.addEventListener('reset', function() {
        setTimeout(function() {
          checks.forEach(cb => setPanel(cb, false, false));
        }, 0);
      });
    }

    // Al cargar: el navegador puede restaurar checks marcados (por ejemplo, al recargar);
    // se sincroniza cada panel con el estado real del check.
    checks.forEach(cb => setPanel(cb, cb.checked, false));
  })();
</script>