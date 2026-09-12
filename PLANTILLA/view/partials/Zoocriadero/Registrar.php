<div class="container mt-4">
  <div class="d-flex justify-content-center">
    <div class="card shadow" style="width: 100%; max-width: 700px;">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Registrar Zoocriadero</h4>
      </div>

      <div class="card-body p-4">
        <form action="<?php echo getUrl("Zoocriadero", "Zoocriadero", "validarRegistrar") ?>" method="POST">

          <div class="mb-3">
            <label for="codigo_zoocriadero" class="form-label">Código del zoocriadero <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="codigo_zoocriadero" name="codigo_zoocriadero" placeholder="Ej: ZOO-MELENDEZ-02" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Dirección</label>
            <div class="container">
              <div class="row row-cols-1">

                <label for="via_principal" class="form-label mt-2">Vía principal <span class="text-danger">*</span></label>
                <select class="form-select col mb-3" id="via_principal" name="via_principal" required>
                  <option value="" selected disabled>Seleccione la vía principal</option>
                  <?php foreach (VIA_PRINCIPAL as $v): ?>
                    <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>

                <label for="numero_via" class="form-label">Número de la vía <span class="text-danger">*</span></label>
                <select class="form-select col mb-3" id="numero_via" name="numero_via" required>
                  <option value="" selected disabled>Seleccione el número</option>
                  <?php foreach ($numero_de_via as $v): ?>
                    <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>

                <label for="sufijo_via" class="form-label">Sufijo de la vía</label>
                <select class="form-select col mb-3" id="sufijo_via" name="sufijo_via">
                  <option value="" selected disabled>Sin sufijo</option>
                  <?php foreach (SUFIJO_VIA as $key => $label): ?>
                    <option value="<?php echo $key; ?>"><?php echo $label; ?> (<?php echo $key; ?>)</option>
                  <?php endforeach; ?>
                </select>

                <label for="cruce_prefijo" class="form-label">Prefijo de cruce</label>
                <select class="form-select col mb-3" id="cruce_prefijo" name="cruce_prefijo">
                  <option value="" selected disabled>Sin prefijo</option>
                  <?php foreach (CRUCE_PREFIJO as $key => $label): ?>
                    <option value="<?php echo $key; ?>"><?php echo $label; ?> (<?php echo $key; ?>)</option>
                  <?php endforeach; ?>
                </select>

                <label for="via_generadora" class="form-label">Número de la vía generadora <span class="text-danger">*</span></label>
                <select class="form-select col mb-3" id="via_generadora" name="via_generadora" required>
                  <option value="" selected disabled>Seleccione el número</option>
                  <?php foreach ($numero_de_la_via_generadora as $v): ?>
                    <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>

                <label for="sufijo_generadora" class="form-label">Sufijo de la vía generadora</label>
                <select class="form-select col mb-3" id="sufijo_generadora" name="sufijo_generadora">
                  <option value="" selected disabled>Sin sufijo</option>
                  <?php foreach (SUFIJO_VIA as $key => $label): ?>
                    <option value="<?php echo $key; ?>"><?php echo $label; ?> (<?php echo $key; ?>)</option>
                  <?php endforeach; ?>
                </select>

                <label for="placa" class="form-label">Número de placa <span class="text-danger">*</span></label>
                <select class="form-select col" id="placa" name="placa" required>
                  <option value="" selected disabled>Seleccione la placa</option>
                  <?php foreach ($numero_de_placa as $v): ?>
                    <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>

              </div>
              <div class="form-text mt-2">Ej: Avenida 6N # 28N-10 — los campos sin * son opcionales.</div>
            </div>
          </div>

          <div class="mb-4">
            <label for="id_usuario" class="form-label">Coordinador Asignado <span class="text-danger">*</span></label>
            <select class="form-select" id="id_usuario" name="id_usuario" required>
              <option value="" selected disabled>Selecciona un Coordinador</option>
              <?php foreach ($usuarios as $usu): ?>
                <option value="<?php echo $usu['id_usuario']; ?>">
                  <?php echo $usu['primer_nombre'] . " " . $usu['segundo_nombre'] . " " . $usu['primer_apellido'] . " " . $usu['segundo_apellido']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-4">
            <label for="id_estado" class="form-label">Estado <span class="text-danger">*</span></label>
            <select class="form-select" id="id_estado" name="id_estado" required>
              <option value="" selected disabled>Selecciona un estado</option>
              <?php foreach ($estados as $est): ?>
                <option value="<?php echo $est['id_estado']; ?>">
                  <?php echo $est['nombre_estado']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="text-muted small mb-3"><span class="text-danger">*</span> Campos obligatorios</div>

          <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Guardar zoocriadero</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>