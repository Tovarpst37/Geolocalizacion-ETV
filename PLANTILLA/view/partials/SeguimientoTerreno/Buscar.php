

 <div class="d-flex justify-content-end w-100">
      <div class="input-group" style="max-width: 350px;">
        <form class="input-group" action="index.php" method="GET">
          <input type="hidden" name="modulo" value="SeguimientoTerreno">
          <input type="hidden" name="controlador" value="SeguimientoTerreno">
          <input type="hidden" name="funcion" value="getBuscar">

          <input type="text" name="busqueda" placeholder="Search ..." class="form-control"  value = "<?php echo $palabra; ?>"/>

          <button type="submit" class="btn btn-outline-secondary">
            <i class="fa fa-search"></i>
          </button>
        </form>
      </div>
    </div>


    

<div class="list-group mt-4">

    <?php foreach($seguimientos as $s){ ?>
    
        <div class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 mb-3  border rounded">
            
            <div>
                <h6 class="mb-1"><?php echo $s['cod_seguimiento']; ?> — Sitio <?php echo $s['nombre_sitio']; ?> — Terreno <?php echo $s['cod_terreno']; ?></h6>
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
                <a href="<?php echo getUrl("SeguimientoTerreno","SeguimientoTerreno","getEditar",array('id'=>$s['id_seguimiento_terreno']))?>" class="btn btn-primary">Editar</a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#seg<?php echo $s['id_seguimiento_terreno'] ?>">
                    Inhabilitar
                </button>
            </div>

            <div class="modal fade" id="seg<?php echo $s['id_seguimiento_terreno']?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Inhabilitar Seguimiento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de inhabilitar el seguimiento de <?php echo $s['cod_terreno']; ?> (<?php echo $s['hora_inicio']; ?> - <?php echo $s['hora_fin']; ?>)?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <a href="<?php echo getUrl('SeguimientoTerreno','SeguimientoTerreno','postDelete', array('id'=>$s['id_seguimiento_terreno'])); ?>" class="btn btn-danger" type="button">Inhabilitar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>  
    <?php } ?>
</div>