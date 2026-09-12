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
        }, 500); // espera a que termine el fade antes de quitarlo del DOM
      }
    }, 5000); // 5 segundos visible
  </script>
<?php endif; ?>



<div class="d-flex justify-content-end w-100">
    <div class="input-group" style="max-width: 350px;">
<form class="input-group" action="index.php" method="GET">
    <input type="hidden" name="modulo" value="Zoocriadero">
    <input type="hidden" name="controlador" value="Zoocriadero">
    <input type="hidden" name="funcion" value="getBuscar">
    
    <input type="text" name="busqueda" placeholder="Search ..." class="form-control" />
    
    <button type="submit" class="btn btn-outline-secondary">
        <i class="fa fa-search"></i>
    </button>
</form>
</div>
</div>





<div class="list-group mt-4">
    <?php foreach($zoocriaderos as $z){ ?>
    
        <div class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-0 mb-4 border rounded">
            
            <div>
                <h6 class="mb-1"><?php echo $z['cod_zoocriadero']; ?></h6>
                <small class="text-muted"><?php echo $z['direcciom']; ?></small>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="badge <?php echo $z['id_estado'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo $z['id_estado'] == 1 ? 'Activo' : 'Inactivo'; ?>
                </span>
                <a href="<?php echo getUrl("Zoocriadero","Zoocriadero","getEditar",array('id'=>$z['id_zoocriadero']))?>" class="btn btn-primary">Editar</a>
                          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#zoo<?php echo $z['id_zoocriadero'] ?>">
                            Inhabilitar
                            </button>
               
            </div>

            <div class="modal fade" id="zoo<?php echo $z['id_zoocriadero']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Inhabilitar Zoocriadero</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de Inhabilitar <?php echo $z['cod_zoocriadero'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-clouse" data-bs-dismiss="modal">Cerrar</button>
                                <a href="<?php echo getUrl('Zoocriadero','Zoocriadero','postDelete', array('id'=>$z['id_zoocriadero'])); ?>"class="btn btn-danger" type="button">Inhabilitar</a>
                            </div>
                            </div>
                        </div>
                        </div>

        </div>
    <?php } ?>
</div>