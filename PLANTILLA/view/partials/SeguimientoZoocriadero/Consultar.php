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