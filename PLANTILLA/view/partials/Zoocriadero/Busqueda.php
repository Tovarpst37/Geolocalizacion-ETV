<div class="list-group">
    <?php foreach($zoocriaderos as $z){ ?>
        <div class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-2 border rounded">
            
            <div>
                <h6 class="mb-1"><?php echo $z['cod_zoocriadero']; ?></h6>
                <small class="text-muted"><?php echo $z['direcciom']; ?></small>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="badge <?php echo $z['id_estado'] == 1 ? 'bg-success' : 'bg-secondary'; ?>">
                    <?php echo $z['id_estado'] == 1 ? 'Activo' : 'Inactivo'; ?>
                </span>
                <a href="<?php echo getUrl("Zoocriadero","Zoocriadero","getEditar",array('id'=>$z['id_zoocriadero']))?>" class="btn btn-sm btn-primary">Editar</a>
                <a href="#" class="btn btn-sm btn-danger">Inhabilitar</a>
            </div>

        </div>
    <?php } ?>
</div>