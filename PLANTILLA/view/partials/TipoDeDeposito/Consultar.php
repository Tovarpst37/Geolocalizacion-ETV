<?php if (!empty($_SESSION['mensaje_exito'])): ?>
  <div id="alertaExito" class="alert d-flex align-items-center border-0 shadow-sm" role="alert" style="border-left: 5px solid #198754 !important; background-color: #fff;">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" style="color:#198754;" role="img" aria-label="Success:">
      <use xlink:href="#check-circle-fill" />
    </svg>
    <div>
      <?php echo $_SESSION['mensaje_exito']; ?>
    </div>
  </div>
  <?php unset($_SESSION['mensaje_exito']); ?>

  <script>
    setTimeout(function() {
      var alerta = document.getElementById('alertaExito');
      if (alerta) {
        alerta.style.transition = "opacity 0.5s ease";
        alerta.style.opacity = "0";
        setTimeout(function() {
          alerta.remove();
        }, 500);
      }
    }, 5000);
  </script>
<?php endif; ?>


<div class="d-flex justify-content-end w-100">
  <div class="input-group" style="max-width: 350px;">
    <form class="input-group" action="index.php" method="GET">
      <input type="hidden" name="modulo" value="TipoDeDeposito">
      <input type="hidden" name="controlador" value="TipoDeDeposito">
      <input type="hidden" name="funcion" value="getBuscar">

      <input type="text" name="busqueda" placeholder="Buscar tipo de depósito..." class="form-control" 
             value="<?= htmlspecialchars($palabra ?? '') ?>">

      <button type="submit" class="btn btn-outline-secondary">
        <i class="fa fa-search"></i>
      </button>
    </form>
  </div>
</div>


<div class="list-group mt-4">

  <?php foreach ($tipos as $t): ?>
    
    <div class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3 border rounded">
        
      <div>
        <h6 class="mb-1"><?= htmlspecialchars($t['nombre']) ?></h6>
        <small class="text-muted">Registro: <?= $t['id_tipo_deposito'] ?></small>
      </div>

      <div class="d-flex align-items-center gap-2">
        <a href="<?= getUrl("TipoDeDeposito", "TipoDeDeposito", "getEditar", array('id' => $t['id_tipo_deposito'])) ?>" 
           class="btn btn-primary btn-sm">
          Editar
        </a>
      </div>

    </div>
  <?php endforeach; ?>

</div>