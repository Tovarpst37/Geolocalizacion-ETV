<style>
  /* Fondo oscuro superpuesto con desenfoque (Blur) */
  .modal-backdrop-custom {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(15, 23, 42, 0.45);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 1050;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
  }

  /* Modal superpuesta */
  .modal-edit-custom {
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    background-color: #ffffff;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    width: 100%;
    max-width: 800px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
  }

  /* Encabezado fijo */
  .modal-edit-header {
    padding: 1.25rem 1.5rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #ffffff;
    flex-shrink: 0;
  }

  .modal-edit-title-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
  }

  .modal-edit-icon {
    width: 38px;
    height: 38px;
    background-color: #eff6ff;
    color: #2563eb;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
  }

  .modal-edit-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
  }

  .btn-close-custom {
    background: transparent;
    border: none;
    color: #94a3b8;
    font-size: 1.35rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.25rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .btn-close-custom:hover {
    color: #0f172a;
    background-color: #f1f5f9;
  }

  /* Cuerpo con scroll independiente contenido */
  .modal-edit-body {
    padding: 1.25rem 1.5rem;
    overflow-y: auto;
    flex-grow: 1;
  }

  .form-label-custom {
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.35rem;
  }

  .form-label-custom i {
    color: #2563eb;
    font-size: 1rem;
  }

  .form-control-custom,
  .form-select-custom {
    border-radius: 10px !important;
    border: 1px solid #cbd5e1 !important;
    padding: 0.55rem 0.85rem !important;
    font-size: 0.88rem;
    color: #0f172a;
    background-color: #ffffff;
    transition: all 0.2s ease;
    box-shadow: none !important;
    width: 100%;
  }

  .form-control-custom:focus,
  .form-select-custom:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
  }

  .form-control-custom[readonly],
  .form-control-custom[disabled] {
    background-color: #f8fafc !important;
    color: #64748b;
    border-color: #e2e8f0 !important;
    cursor: not-allowed;
  }

  /* Sección de Dirección */
  .address-section {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 1rem;
    margin-bottom: 1.25rem;
  }

  .address-separator {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    min-height: 38px;
  }

  /* Auxiliares */
  .auxiliaries-box {
    border: 1px solid #e2e8f0;
    background-color: #ffffff;
    border-radius: 12px;
    padding: 0.75rem;
    max-height: 160px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .auxiliary-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.6rem 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background-color: #ffffff;
    transition: all 0.15s ease;
  }

  .auxiliary-item:hover {
    border-color: #bfdbfe;
    background-color: #f8fafc;
  }

  .auxiliary-info {
    display: flex;
    align-items: center;
    gap: 0.65rem;
  }

  .auxiliary-item .form-check-input {
    cursor: pointer;
    border-color: #cbd5e1;
    width: 1.1rem;
    height: 1.1rem;
    margin: 0;
  }

  .auxiliary-item .form-check-input:checked {
    background-color: #2563eb;
    border-color: #2563eb;
  }

  .auxiliary-item label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #334155;
    cursor: pointer;
    margin: 0;
    user-select: none;
  }

  .assigned-badge {
    font-size: 0.75rem;
    font-weight: 600;
    color: #16a34a;
    background-color: #f0fdf4;
    border: 1px solid rgba(22, 163, 74, 0.2);
    padding: 0.2rem 0.6rem;
    border-radius: 6px;
  }

  /* Pie fijo de la modal */
  .modal-edit-footer {
    padding: 1rem 1.5rem 1.25rem;
    border-top: 1px solid #f1f5f9;
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
    justify-content: space-between;
    background-color: #ffffff;
    flex-shrink: 0;
  }

  .btn-modal-cancel {
    background-color: #ffffff;
    border: 1.5px solid #cbd5e1;
    color: #475569;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 0.55rem 1.25rem;
    border-radius: 10px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .btn-modal-cancel:hover {
    background-color: #f8fafc;
    color: #0f172a;
    border-color: #94a3b8;
  }

  .btn-modal-save {
    background-color: #2563eb;
    border: 1.5px solid #2563eb;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 0.55rem 1.25rem;
    border-radius: 10px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
  }

  .btn-modal-save:hover {
    background-color: #1d4ed8;
    border-color: #1d4ed8;
    color: #ffffff;
  }

  @media (max-width: 576px) {
    .modal-edit-footer {
      flex-direction: column-reverse;
      align-items: stretch;
    }
    .btn-modal-cancel, .btn-modal-save {
      width: 100%;
    }
  }
</style>

<!-- Contenedor con fondo opaco y efecto desenfocado (Blur) -->
<div class="modal-backdrop-custom">
  <div class="modal-edit-custom">
    
    <?php foreach ($datos as $d) { ?>
      <form action="<?php echo getUrl("Sitios", "Sitios", "validarUpdate") ?>" method="post" class="m-0 d-flex flex-column h-100 overflow-hidden">

        <!-- Encabezado Fijo -->
        <div class="modal-edit-header">
          <div class="modal-edit-title-group">
            <div class="modal-edit-icon">
              <i class="bx bx-edit-alt"></i>
            </div>
            <h5 class="modal-edit-title">Editar Sitio</h5>
          </div>
          <a href="<?php echo getUrl('Sitios', 'Sitios', 'getConsultar') ?>" class="btn-close-custom" aria-label="Cerrar">
            <i class="bx bx-x"></i>
          </a>
        </div>

        <!-- Cuerpo Desplazable -->
        <div class="modal-edit-body">

          <input type="hidden" name="id" value="<?php echo $d['id_sitio']; ?>">

          <!-- Nombre y Dirección Actual -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="nombre" class="form-label-custom">
                <i class="bx bx-building"></i> Nombre <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control form-control-custom" id="nombre" name="nombre" placeholder="Ingrese el nombre del sitio" required value="<?php echo $d['nombre_sitio']; ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label-custom">
                <i class="bx bx-pin"></i> Dirección actual
              </label>
              <input type="text" class="form-control form-control-custom" value="<?php echo $d['direccion']; ?>" disabled readonly>
            </div>
          </div>

          <!-- Coordinador Asignado -->
          <div class="mb-3">
            <label for="id_coor" class="form-label-custom">
              <i class="bx bx-user-voice"></i> Coordinador Asignado <span class="text-danger">*</span>
            </label>
            <select class="form-select form-select-custom" id="id_coor" name="id_coor">
              <option value="" <?php echo empty($coor_actual['id_usuario']) ? "selected" : ""; ?>>Selecciona un Coordinador</option>
              <?php foreach ($coord as $usu) {
                $selected = (isset($coor_actual['id_usuario']) && $coor_actual['id_usuario'] == $usu['id_usuario']) ? "selected" : "";
                echo "<option value='" . $usu['id_usuario'] . "' $selected>" .
                  $usu['primer_nombre'] . " " . $usu['segundo_nombre'] . " " .
                  $usu['primer_apellido'] . " " . $usu['segundo_apellido'] . "</option>";
              } ?>
            </select>
          </div>

          <!-- Auxiliares Asignados -->
          <div class="mb-3">
            <label class="form-label-custom">
              <i class="bx bx-group"></i> Auxiliares asignados
            </label>
            <div class="auxiliaries-box" id="auxiliares-container">
              <?php foreach ($auxi as $usu) {
                $isAssigned = in_array($usu['id_usuario'], $auxi_actuales ?? []);
                $checked = $isAssigned ? "checked" : "";
              ?>
                <div class="auxiliary-item">
                  <div class="auxiliary-info">
                    <input class="form-check-input" type="checkbox"
                      name="usuarios_asignados[]"
                      value="<?php echo $usu['id_usuario']; ?>"
                      id="user<?php echo $usu['id_usuario']; ?>"
                      <?php echo $checked; ?>>

                    <label for="user<?php echo $usu['id_usuario']; ?>">
                      <?php echo $usu['primer_nombre'] . " " .
                        $usu['segundo_nombre'] . " " .
                        $usu['primer_apellido'] . " " .
                        $usu['segundo_apellido']; ?>
                    </label>
                  </div>

                  <?php if ($isAssigned): ?>
                    <span class="assigned-badge">Asignado</span>
                  <?php endif; ?>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- Estructuración de Nueva Dirección -->
          <div class="address-section">
            <label class="form-label-custom mb-2">
              <i class="bx bx-navigation"></i> Nueva dirección
            </label>

            <!-- Fila 1 Dirección -->
            <div class="row g-2 mb-2 align-items-center">
              <div class="col-12 col-sm-6 col-md-3">
                <select class="form-select form-select-custom" id="via_principal" name="via_principal" required>
                  <option value="" disabled <?php echo empty($partes['via_principal']) ? 'selected' : ''; ?>>Vía principal *</option>
                  <?php
                  include_once '../controller/Sitios/direcciones.php';
                  foreach (VIA_PRINCIPAL as $v): ?>
                    <option value="<?php echo $v; ?>" <?php echo ($partes['via_principal'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                <select class="form-select form-select-custom" id="numero_via" name="numero_via" required>
                  <option value="" disabled <?php echo empty($partes['numero_via']) ? 'selected' : ''; ?>>Número *</option>
                  <?php foreach ($numero_de_via as $v): ?>
                    <option value="<?php echo $v; ?>" <?php echo ($partes['numero_via'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-5 col-sm-5 col-md-2">
                <select class="form-select form-select-custom" id="sufijo_via" name="sufijo_via">
                  <option value="" disabled <?php echo empty($partes['sufijo_via']) ? 'selected' : ''; ?>>Sufijo</option>
                  <?php foreach (SUFIJO_VIA as $key => $label): ?>
                    <option value="<?php echo $key; ?>" <?php echo ($partes['sufijo_via'] == $key) ? 'selected' : ''; ?>><?php echo $key; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-2 col-sm-2 col-md-1 text-center">
                <span class="address-separator">#</span>
              </div>
              <div class="col-5 col-sm-5 col-md-3">
                <select class="form-select form-select-custom" id="cruce_prefijo" name="cruce_prefijo">
                  <option value="" disabled <?php echo empty($partes['cruce_prefijo']) ? 'selected' : ''; ?>>Prefijo</option>
                  <?php foreach (CRUCE_PREFIJO as $key => $label): ?>
                    <option value="<?php echo $key; ?>" <?php echo ($partes['cruce_prefijo'] == $key) ? 'selected' : ''; ?>><?php echo $label; ?> (<?php echo $key; ?>)</option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <!-- Fila 2 Dirección -->
            <div class="row g-2 align-items-center">
              <div class="col-12 col-sm-5 col-md-4">
                <select class="form-select form-select-custom" id="via_generadora" name="via_generadora" required>
                  <option value="" disabled <?php echo empty($partes['via_generadora']) ? 'selected' : ''; ?>>Vía generadora *</option>
                  <?php foreach ($numero_de_la_via_generadora as $v): ?>
                    <option value="<?php echo $v; ?>" <?php echo ($partes['via_generadora'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-5 col-sm-5 col-md-3">
                <select class="form-select form-select-custom" id="sufijo_generadora" name="sufijo_generadora">
                  <option value="" disabled <?php echo empty($partes['sufijo_generadora']) ? 'selected' : ''; ?>>Sufijo</option>
                  <?php foreach (SUFIJO_VIA as $key => $label): ?>
                    <option value="<?php echo $key; ?>" <?php echo ($partes['sufijo_generadora'] == $key) ? 'selected' : ''; ?>><?php echo $key; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-2 col-sm-2 col-md-1 text-center">
                <span class="address-separator">-</span>
              </div>
              <div class="col-5 col-sm-12 col-md-4">
                <select class="form-select form-select-custom" id="placa" name="placa" required>
                  <option value="" disabled <?php echo empty($partes['placa']) ? 'selected' : ''; ?>>Placa *</option>
                  <?php foreach ($numero_de_placa as $v): ?>
                    <option value="<?php echo $v; ?>" <?php echo ($partes['placa'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <!-- Barrio y Estado -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="barrio" class="form-label-custom">
                <i class="bx bx-map"></i> Barrio <span class="text-danger">*</span>
              </label>
              <select class="form-select form-select-custom" id="barrio" name="barrio" required>
                <option value="" selected disabled>Barrio *</option>
                <?php foreach ($barrios as $b) {
                  $selected = ($d['id_barrio'] == $b['id_barrio']) ? "selected" : "";
                  echo "<option value='" . $b['id_barrio'] . "' $selected>" . $b['nombre_barrio'] . "</option>";
                } ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="estado" class="form-label-custom">
                <i class="bx bx-toggle-right"></i> Estado <span class="text-danger">*</span>
              </label>
              <select class="form-select form-select-custom" id="estado" name="estado" required>
                <option value="" selected disabled>Estado *</option>
                <?php foreach ($estados as $est) {
                  $selected = ($d['id_estado'] == $est['id_estado']) ? "selected" : "";
                  echo "<option value='" . $est['id_estado'] . "' $selected>" . $est['nombre_estado'] . "</option>";
                } ?>
              </select>
            </div>
          </div>

          <!-- Tipo Depósito -->
          <div class="mb-3">
            <label for="id_tipo_deposito" class="form-label-custom">
              <i class="bx bx-box"></i> Tipo de depósito <span class="text-danger">*</span>
            </label>
            <select class="form-select form-select-custom" id="id_tipo_deposito" name="id_tipo_deposito" required>
              <option value="" selected disabled>Selecciona un tipo de depósito</option>
              <?php foreach ($tipos_deposito as $td) {
                $selected = ($d['id_tipo_deposito'] == $td['id_tipo_deposito']) ? "selected" : "";
                echo "<option value='" . $td['id_tipo_deposito'] . "' $selected>" . $td['nombre'] . "</option>";
              } ?>
            </select>
          </div>

          <!-- Descripción -->
          <div class="mb-3">
            <label for="descripcion" class="form-label-custom">
              <i class="bx bx-detail"></i> Descripción
            </label>
            <textarea class="form-control form-control-custom" id="descripcion" name="descripcion" rows="3" maxlength="300" placeholder="Descripción del sitio (máx. 300 caracteres)"><?php echo $d['descripcion'] ?? ''; ?></textarea>
            <div class="form-text text-end mt-1 text-muted"><span id="contadorDescripcion">0</span>/300</div>
          </div>

        </div>

        <!-- Pie Fijo -->
        <div class="modal-edit-footer">
          <span class="text-muted small"><span class="text-danger">*</span> Campos obligatorios</span>
          <div class="d-flex gap-2 w-100 w-sm-auto justify-content-end">
            <a href="<?php echo getUrl('Sitios', 'Sitios', 'getConsultar') ?>" class="btn-modal-cancel">
              Cancelar
            </a>
            <button type="submit" class="btn-modal-save">
              <i class="bx bx-save"></i> Guardar cambios
            </button>
          </div>
        </div>

      </form>
    <?php } ?>

  </div>
</div>

<script>
  (function() {
    const textarea = document.getElementById('descripcion');
    const contador = document.getElementById('contadorDescripcion');
    if (textarea && contador) {
      const actualizar = () => contador.textContent = textarea.value.length;
      actualizar();
      textarea.addEventListener('input', actualizar);
    }
  })();
</script>