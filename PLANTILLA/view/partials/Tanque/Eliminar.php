<div class="modal show" tabindex="-1" style="display:block;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminar Tanque</h5>
        <button type="button" class="btn-close" onclick="window.location.href='index.php'"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de eliminar este tanque?</p>
      </div>
      <div class="modal-footer">
        <a href="<?php echo getUrl('Tanque','Tanque','getConsultar')?>" class="btn btn-primary">Cancelar</a>
        <a href="<?php echo getUrl('Tanque','Tanque','postDelete', array('id'=>$id)); ?>" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>

<?php include_once '../view/partials/Tanque/Consultar.php';?>