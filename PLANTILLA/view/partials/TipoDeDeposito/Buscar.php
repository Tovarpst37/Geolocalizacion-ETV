
<div class="page-header">
    <h3 class="fw-bold mb-3">Tipo de Deposito</h3>

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
</div>


<div class="list-group mt-4">

  <?php 
  if(!empty($tipos)){
  foreach ($tipos as $t): ?>
    
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
  <?php endforeach; 
  }else{

    ?>
    <div class="text-center text-muted py-5 mt-5">
        <i class="fa fa-search fa-2x mb-3"></i>
        <p class="mb-3">No se encontraron resultados</p>
    </div>
    <?php
    } ?>

</div>