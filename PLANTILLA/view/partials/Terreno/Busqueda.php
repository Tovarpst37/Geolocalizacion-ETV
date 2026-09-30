<div class="page-header">
    <h3 class="fw-bold mb-3">Terrenos</h3>
<div class="d-flex justify-content-end w-100">
    <div class="input-group" style="max-width: 350px;">
<form class="input-group" action="index.php" method="GET">
    <input type="hidden" name="modulo" value="Terreno">
    <input type="hidden" name="controlador" value="Terreno">
    <input type="hidden" name="funcion" value="getBuscar">
    
    <input type="text" name="busqueda" placeholder="Buscar por codigo..." class="form-control" value="<?php echo $palabra; ?>"/>
    
    <button type="submit" class="btn btn-outline-secondary">
        <i class="fa fa-search"></i>
    </button>
</form>
</div>
</div>
</div>




<div class="container-fluid text-center px-2 mt-5">

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

    <?php

    include_once '../controller/Terreno/TerrenoController.php';
    include_once '../model/Terreno/Terreno.php';


    $bj = [];
    $ob2 = new TerrenoController();


    foreach ($datos as $j) {
      $terreno = new Terreno($j['id_sitio_deposito'], $j['codigo_sitio_deposito'], $j['sitio'], $j['estado'], $j['descripcion'], $j['tipo_deposito']);
      $bj[] = $terreno;
    }


if (!empty($bj)) {
    foreach ($bj as $i) {

        $badgeClass = strtolower($i->getEstado()) === 'activo' ? 'bg-success' : 'bg-danger';

?>

        <div class="col">
            <div class="card p-3 h-100" style="width: 100% !important; min-width: 0 !important;">
                <div class="card-body pb-2 text-start">
                    <div class="mb-2">
                        <span class="badge <?php echo $badgeClass ?> rounded-pill"><?php echo $i->getEstado() ?></span>
                    </div>
                    <h5 class="card-title mb-0"><?php echo $i->getCodigo_sitio_deposito() ?></h5>
                    <small class="text-muted">ID <?php echo $i->getId() ?></small>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $i->getDireccion() ?></li>
                    <li class="list-group-item"><?php echo $i->getNombre_tipo_deposito() ?></li>
                </ul>

                <div class="card-body d-flex gap-2 pt-3">
                    <a href="<?php echo getUrl('Terreno', 'Terreno', 'getEdit', array('id' => $i->getId())); ?>" class="btn btn-primary btn-sm flex-fill">
                        Editar
                    </a>
                    <button type="button" class="btn btn-danger btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#modalInhabilitar<?php echo $i->getId() ?>">
                        Inhabilitar
                    </button>
                </div>
            </div>

            <div class="modal fade" id="modalInhabilitar<?php echo $i->getId() ?>" tabindex="-1" aria-labelledby="modalInhabilitarLabel<?php echo $i->getId() ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalInhabilitarLabel<?php echo $i->getId() ?>">Inhabilitar terreno</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro que quieres inhabilitar el terreno <strong><?php echo $i->getCodigo_sitio_deposito() ?></strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <a href="<?php echo getUrl('Terreno', 'Terreno', 'posDelete', array('id' => $i->getId())); ?>" class="btn btn-danger">
                                Inhabilitar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }

    ?>
  </div>
</div>

<?php
} else { ?>
    <div class="w-100 d-flex flex-column align-items-center justify-content-center text-muted py-5 mt-5">
        <i class="fa fa-search fa-2x mb-3"></i>
        <p class="mb-3">No se encontraron resultados</p>
    </div>
</div>
</div>

<?php } ?>