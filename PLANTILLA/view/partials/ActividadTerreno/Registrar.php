<div class="container mt-4">
  <div class="d-flex justify-content-center">
    <div class="card shadow" style="width: 100%; max-width: 700px;">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Registrar Actividades de Terreno</h4>
      </div>

      <div class="card-body p-4">
        <form action="<?php echo getUrl("ActividadTerreno", "ActividadTerreno", "postRegistrar") ?>" method="POST">

          <div class="mb-3">
            <label for="Codigo Actividad" class="form-label">Codigo de la actividad</label>
            <input type="text" class="form-control" id="codigo_Actividad" name="codigo_Actividad"
              value="AT- <?php echo $id_seg[0]['max'] + 1; ?>" disabled>
            <input type="hidden" name="codigo" value="AT-<?php echo $id_seg[0]['max'] + 1; ?>">

          </div>



          <div class="mb-3">
            <label for="Nombre Actividad" class="form-label">Nombre de la actividad</label>
            <input type="text" class="form-control" id="Nombre Actividad" name="nombre_actividad"
              placeholder="Ingrese una actividad nueva" required>
          </div>



          <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Guardar Actividad</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>