
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
          <input type="hidden" name="modulo" value="SeguimientoZoocriadero">
          <input type="hidden" name="controlador" value="SeguimientoZoocriadero">
          <input type="hidden" name="funcion" value="getBuscar">

          <input type="text" name="busqueda" placeholder="Search ..." class="form-control" />

          <button type="submit" class="btn btn-outline-secondary">
            <i class="fa fa-search"></i>
          </button>
        </form>
      </div>
    </div>


    

<div class="list-group mt-4">

    <?php foreach($seguimientos as $s){ ?>
    
        <div class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4  border rounded">
            
            <div>
                <h6 class="mb-1"><?php echo $s['cod_zoocriadero']; ?> — Tanque <?php echo $s['codigo_tanque']; ?></h6>
                <small class="text-muted">
                    <?php echo $s['hora_inicio']; ?> - <?php echo $s['hora_fin']; ?> 
                    &nbsp;|&nbsp; Auxiliar: <?php echo $s['primer_nombre']." ".$s['primer_apellido']; ?>
                </small>
                <small class="text-muted">
                    &nbsp;|&nbsp;
                    <b>Actividades:</b> <?php echo $s['actividades'] ?? 'Sin actividades asignadas'; ?>
                </small>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="badge <?php echo $s['id_estado'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo $s['id_estado'] == 1 ? 'Activo' : 'Inactivo'; ?>
                </span>
                <a href="<?php echo getUrl("SeguimientoZoocriadero","SeguimientoZoocriadero","getEditar",array('id'=>$s['id_seguimiento_zoo']))?>" class="btn btn-primary">Editar</a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#seg<?php echo $s['id_seguimiento_zoo'] ?>">
                    Inhabilitar
                </button>
            </div>

            <div class="modal fade" id="seg<?php echo $s['id_seguimiento_zoo']?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Inhabilitar Seguimiento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de inhabilitar el seguimiento de <?php echo $s['cod_zoocriadero']; ?> (<?php echo $s['hora_inicio']; ?> - <?php echo $s['hora_fin']; ?>)?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <a href="<?php echo getUrl('SeguimientoZoocriadero','SeguimientoZoocriadero','postDelete', array('id'=>$s['id_seguimiento_zoo'])); ?>" class="btn btn-danger" type="button">Inhabilitar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php } ?>
</div>