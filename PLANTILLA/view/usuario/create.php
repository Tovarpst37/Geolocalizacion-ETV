<div class="container mt-4">
  <div class="d-flex justify-content-center">
    <div class="card shadow" style="width: 100%; max-width: 700px;">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Registro de Usuarios</h4>
      </div>

      <div class="card-body p-4">
        <form action="<?php echo getUrl("Usuario","Usuario","Usuario","postCreate");?>" method="POST">

          <h2 class="mb-0">Datos Del usuario</h2>

          <div class="mb-3">
            <label for="codigo_tanque" class="form-label">Primer Nombre</label>
            <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" required>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>