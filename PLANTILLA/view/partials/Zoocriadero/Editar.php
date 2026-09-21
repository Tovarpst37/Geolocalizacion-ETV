<style>
.custom-form-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(15, 23, 42, 0.4);
  backdrop-filter: blur(4px);
  z-index: 1050;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}

.custom-card {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
  width: 100%;
  max-width: 680px;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  overflow: hidden; /* Evita que los elementos sobresalgan de la tarjeta */
  animation: cardFadeIn 0.2s ease-out;
}

@keyframes cardFadeIn {
  from {
    opacity: 0;
    transform: scale(0.96) translateY(-10px);
  }
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

.custom-card-form {
  display: flex;
  flex-direction: column;
  max-height: 90vh;
  width: 100%;
  margin: 0;
}

.custom-card-header {
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #ffffff;
  flex-shrink: 0;
}

.custom-card-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
  display: flex;
  align-items: center;
  gap: .5rem;
}

.custom-card-title i {
  color: #2563eb;
}

.btn-close-custom {
  background: transparent;
  border: none;
  color: #64748b;
  font-size: 1.25rem;
  border-radius: 8px;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  transition: all 0.15s ease;
}

.btn-close-custom:hover {
  background-color: #f1f5f9;
  color: #1e293b;
}

.custom-card-body {
  padding: 1.5rem;
  overflow-y: auto; /* Permite el scroll interno únicamente en los campos */
  flex-grow: 1;
}

.form-label-custom {
  font-size: .85rem;
  font-weight: 600;
  color: #475569;
  margin-bottom: .4rem;
  display: block;
}

.input-icon-group {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon-group i {
  position: absolute;
  left: .85rem;
  color: #94a3b8;
  font-size: 1.1rem;
  pointer-events: none;
  z-index: 5;
}

.input-icon-group .form-control,
.input-icon-group .form-select {
  padding-left: 2.5rem;
  border-radius: 10px;
  border: 1px solid #cbd5e1;
  font-size: .9rem;
  height: 2.65rem;
  color: #1e293b;
  transition: all 0.15s ease;
}

.input-icon-group .form-control:focus,
.input-icon-group .form-select:focus {
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.input-icon-group .form-control:disabled {
  background-color: #f8fafc;
  color: #64748b;
  cursor: not-allowed;
}

/* Sección de Auxiliares */
.auxiliaries-box {
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  padding: .75rem;
  max-height: 150px;
  overflow-y: auto;
  background-color: #f8fafc;
}

.auxiliary-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: .5rem .75rem;
  border-radius: 8px;
  background-color: #ffffff;
  border: 1px solid #e2e8f0;
  margin-bottom: .5rem;
}

.auxiliary-item:last-child {
  margin-bottom: 0;
}

.badge-assigned {
  background-color: #dcfce7;
  color: #166534;
  font-size: .75rem;
  padding: .2rem .5rem;
  border-radius: 6px;
  font-weight: 600;
}

/* Sección de Dirección */
.address-section {
  background-color: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 1rem;
}

.address-section .form-select {
  border-radius: 8px;
  border: 1px solid #cbd5e1;
  font-size: .85rem;
  height: 2.5rem;
}

.address-separator {
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  color: #64748b;
  font-size: 1.1rem;
}

.custom-card-footer {
  padding: 1rem 1.5rem;
  border-top: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: .75rem;
  background: #ffffff;
  flex-shrink: 0; /* Mantiene el footer fijo abajo */
}

.btn-cancel-custom {
  background-color: #f1f5f9;
  color: #475569;
  font-weight: 600;
  font-size: .875rem;
  padding: .5rem 1.1rem;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.15s ease;
}

.btn-cancel-custom:hover {
  background-color: #e2e8f0;
  color: #1e293b;
}

.btn-submit-custom {
  background-color: #2563eb;
  color: #ffffff;
  font-weight: 600;
  font-size: .875rem;
  padding: .5rem 1.25rem;
  border-radius: 8px;
  border: none;
  transition: all 0.15s ease;
}

.btn-submit-custom:hover {
  background-color: #1d4ed8;
}
</style>

<div class="custom-form-wrapper">
  <div class="custom-card">
    <form class="custom-card-form" action="<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'validarUpdate'); ?>" method="POST" enctype="multipart/form-data">
      
      <!-- Card Header -->
      <div class="custom-card-header">
        <h5 class="custom-card-title">
          <i class="bx bx-edit-alt"></i>
          Editar Zoocriadero
        </h5>
        <a href="<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'getConsultar') ?>" class="btn-close-custom">
          <i class="bx bx-x"></i>
        </a>
      </div>

      <!-- Card Body -->
      <div class="custom-card-body">
        <?php foreach ($datos as $d) { ?>

          <input type="hidden" name="id" value="<?php echo $d['id_zoocriadero']; ?>">

          <!-- Código del Zoocriadero -->
          <div class="mb-3">
            <label class="form-label-custom">Código del Zoocriadero</label>
            <div class="input-icon-group">
              <i class="bx bx-hash"></i>
              <input type="text" class="form-control" id="cod_zoocriadero" name="codigo_zoocriadero" value="<?php echo $d['cod_zoocriadero']; ?>" disabled>
            </div>
            <input type="hidden" name="codigo" value="<?php echo $d['cod_zoocriadero']; ?>">
          </div>

          <?php
            $todosCoordinadores = array_unique(array_merge($coord, $coordS), SORT_REGULAR);
            $idCoordinadorActual = !empty($coordS) ? $coordS[0]['id_usuario'] : null;
          ?>

          <!-- Coordinador Asignado -->
          <div class="mb-3">
            <label for="id_usuario" class="form-label-custom">Coordinador Asignado <span class="text-danger">*</span></label>
            <div class="input-icon-group">
              <i class="bx bx-user-pin"></i>
              <select class="form-select" id="id_usuario" name="id_coor" required>
                <option value="" disabled <?= empty($idCoordinadorActual) ? 'selected' : '' ?>>
                  Selecciona un Coordinador
                </option>
                <?php foreach ($todosCoordinadores as $usu): 
                  $nombreCompleto = trim($usu['primer_nombre'] . " " . $usu['segundo_nombre'] . " " . $usu['primer_apellido'] . " " . $usu['segundo_apellido']);
                  $isSelected = ($usu['id_usuario'] == $idCoordinadorActual);
                ?>
                  <option value="<?php echo $usu['id_usuario']; ?>" <?php echo $isSelected ? 'selected' : ''; ?>>
                    <?php echo $nombreCompleto . ($isSelected ? ' (Actualmente asignado)' : ''); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Auxiliares Asignados -->
          <div class="mb-3">
            <label class="form-label-custom">Auxiliares asignados</label>
            <div class="auxiliaries-box">
              <?php
                $todosAuxiliares = array_unique(array_merge($auxi, $auxiS), SORT_REGULAR);
                $idsAsignados = array_column($auxiS, 'id_usuario');
              ?>
              <?php foreach ($todosAuxiliares as $usu): 
                $nombreAux = trim($usu['primer_nombre'] . " " . $usu['segundo_nombre'] . " " . $usu['primer_apellido'] . " " . $usu['segundo_apellido']);
                $isAuxAsignado = in_array($usu['id_usuario'], $idsAsignados);
              ?>
                <div class="auxiliary-item">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox"
                          name="usuarios_asignados[]"
                          value="<?php echo $usu['id_usuario']; ?>"
                          id="user<?php echo $usu['id_usuario']; ?>"
                          <?php echo $isAuxAsignado ? 'checked' : ''; ?>>
                    <label class="form-check-label text-dark fw-medium ms-1" for="user<?php echo $usu['id_usuario']; ?>">
                      <?php echo $nombreAux; ?>
                    </label>
                  </div>
                  <?php if ($isAuxAsignado): ?>
                    <span class="badge-assigned">Asignado</span>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Nueva Dirección -->
          <div class="mb-3">
            <label class="form-label-custom">Nueva dirección</label>
            <div class="address-section">
              <div class="row g-2 mb-2 align-items-center">
                <div class="col-md-3">
                  <select class="form-select" id="via_principal" name="via_principal" required>
                    <option value="" disabled <?php echo empty($partes['via_principal']) ? 'selected' : ''; ?>>Vía principal *</option>
                    <?php
                    include_once '../controller/Sitios/direcciones.php';
                    foreach (VIA_PRINCIPAL as $v): ?>
                      <option value="<?php echo $v; ?>" <?php echo ($partes['via_principal'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-3">
                  <select class="form-select" id="numero_via" name="numero_via" required>
                    <option value="" disabled <?php echo empty($partes['numero_via']) ? 'selected' : ''; ?>>Número *</option>
                    <?php foreach ($numero_de_via as $v): ?>
                      <option value="<?php echo $v; ?>" <?php echo ($partes['numero_via'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-2">
                  <select class="form-select" id="sufijo_via" name="sufijo_via">
                    <option value="" disabled <?php echo empty($partes['sufijo_via']) ? 'selected' : ''; ?>>Sufijo</option>
                    <?php foreach (SUFIJO_VIA as $key => $label): ?>
                      <option value="<?php echo $key; ?>" <?php echo ($partes['sufijo_via'] == $key) ? 'selected' : ''; ?>><?php echo $key; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-1 address-separator">#</div>

                <div class="col-md-3">
                  <select class="form-select" id="cruce_prefijo" name="cruce_prefijo">
                    <option value="" disabled <?php echo empty($partes['cruce_prefijo']) ? 'selected' : ''; ?>>Prefijo</option>
                    <?php foreach (CRUCE_PREFIJO as $key => $label): ?>
                      <option value="<?php echo $key; ?>" <?php echo ($partes['cruce_prefijo'] == $key) ? 'selected' : ''; ?>><?php echo $label; ?> (<?php echo $key; ?>)</option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="row g-2 mb-2 align-items-center">
                <div class="col-md-4">
                  <select class="form-select" id="via_generadora" name="via_generadora" required>
                    <option value="" disabled <?php echo empty($partes['via_generadora']) ? 'selected' : ''; ?>>Vía generadora *</option>
                    <?php foreach ($numero_de_la_via_generadora as $v): ?>
                      <option value="<?php echo $v; ?>" <?php echo ($partes['via_generadora'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-3">
                  <select class="form-select" id="sufijo_generadora" name="sufijo_generadora">
                    <option value="" disabled <?php echo empty($partes['sufijo_generadora']) ? 'selected' : ''; ?>>Sufijo</option>
                    <?php foreach (SUFIJO_VIA as $key => $label): ?>
                      <option value="<?php echo $key; ?>" <?php echo ($partes['sufijo_generadora'] == $key) ? 'selected' : ''; ?>><?php echo $key; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-1 address-separator">-</div>

                <div class="col-md-4">
                  <select class="form-select" id="placa" name="placa" required>
                    <option value="" disabled <?php echo empty($partes['placa']) ? 'selected' : ''; ?>>Placa *</option>
                    <?php foreach ($numero_de_placa as $v): ?>
                      <option value="<?php echo $v; ?>" <?php echo ($partes['placa'] == $v) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="row g-2">
                <div class="col-12">
                  <select class="form-select" id="barrio" name="barrio" required>
                    <option value="" selected disabled>Barrio *</option>
                    <?php foreach ($barrios as $b) {
                      $selected = ($d['id_barrio'] == $b['id_barrio']) ? "selected" : "";
                      echo "<option value='" . $b['id_barrio'] . "' $selected>" . $b['nombre_barrio'] . "</option>";
                    } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Estado -->
<div class="mb-2">
  <label for="id_estado" class="form-label-custom">Estado</label>
  <div class="input-icon-group">
    <i class="bx bx-toggle-left"></i>
    <select class="form-select" id="id_estado" name="id_estado" required>
      <option value="" disabled <?php echo empty($d['id_estado']) ? 'selected' : ''; ?>>Selecciona un estado</option>
      <?php foreach ($estados as $est): 
        // Usamos trim() y la comparación no estricta (==) para evitar problemas de tipos de datos
        $isSelected = (isset($d['id_estado']) && trim($d['id_estado']) == trim($est['id_estado'])) ? "selected" : "";
      ?>
        <option value="<?php echo $est['id_estado']; ?>" <?php echo $isSelected; ?>>
          <?php echo $est['nombre_estado']; ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

        <?php } ?>
      </div>

      <!-- Card Footer (Permanece fijo en la base del modal) -->
      <div class="custom-card-footer">
        <a href="<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'getConsultar') ?>" class="btn-cancel-custom">Cancelar</a>
        <button type="submit" class="btn-submit-custom">Guardar cambios</button>
      </div>

    </form>
  </div>
</div>