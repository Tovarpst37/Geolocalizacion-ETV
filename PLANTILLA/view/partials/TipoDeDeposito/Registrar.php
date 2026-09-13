<div class="container mt-4">
  <div class="d-flex justify-content-center">
    <div class="card shadow" style="width: 100%; max-width: 700px;">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Registrar Tipo de Depósito</h4>
      </div>

      <div class="card-body p-4">
        <form action="<?php echo getUrl("TipoDeDeposito", "TipoDeDeposito", "postRegistrar") ?>" method="POST">

          <div class="mb-4">
            <label for="nombre" class="form-label">Nombre del Tipo de Depósito*</label>
            <input type="text" 
                   class="form-control" 
                   id="nombre" 
                   name="nombre" 
                   placeholder="Ej: Tanque de Cuarentena, Estanque, Llanta..." 
                   required
                   maxlength="100">
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Guardar Tipo de Depósito</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>