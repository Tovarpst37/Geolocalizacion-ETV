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
    <input type="hidden" name="modulo" value="Sitios">
    <input type="hidden" name="controlador" value="Sitios">
    <input type="hidden" name="funcion" value="getBuscar">
    
    <input type="text" name="busqueda" placeholder="Search ..." class="form-control" />
    
    <button type="submit" class="btn btn-outline-secondary">
        <i class="fa fa-search"></i>
    </button>
</form>
</div>
</div>




<div class="container-fluid text-center px-2 mt-5">

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

    <?php

    include_once '../controller/Sitios/SitiosController.php';
    include_once '../model/Sitios/Sitios.php';


    $bj = [];
    $ob2 =  new SitiosController();
    $resul = $ob2->data();


    foreach ($resul as $j) {
      $sitios = new Sitios($j['id_sitio'], $j['nombre_sitio'], $j['direccion'], $j['barrio'], $j['estado']);
      $bj[] = $sitios;
    }



    foreach ($bj as $i) {
      
        $badgeClass = strtolower($i->getEstado()) === 'activo' ? 'bg-success' : 'bg-danger';
        
?>

        <div class="col">
            <div class="card p-3 h-100" style="width: 100% !important; min-width: 0 !important;">
                <div class="card-body pb-2 text-start">
                    <div class="mb-2">
                        <span class="badge <?php echo $badgeClass ?> rounded-pill"><?php echo $i->getEstado() ?></span>
                    </div>
                    <h5 class="card-title mb-0"><?php echo $i->getNombre_sitio() ?></h5>
                    <small class="text-muted">ID <?php echo $i->getId() ?></small>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $i->getDireccion() ?></li>
                    <li class="list-group-item"><?php echo $i->getBarrio() ?></li>
                </ul>

                <div class="card-body d-flex gap-2 pt-3">
                    <a href="<?php echo getUrl('Sitios', 'Sitios', 'getEdit', array('id' => $i->getId())); ?>" class="btn btn-primary btn-sm flex-fill">
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
                            <h5 class="modal-title" id="modalInhabilitarLabel<?php echo $i->getId() ?>">Inhabilitar sitio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro que quieres inhabilitar <strong><?php echo $i->getNombre_sitio() ?></strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <a href="<?php echo getUrl('Sitios', 'Sitios', 'posDelete', array('id' => $i->getId())); ?>" class="btn btn-danger">
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