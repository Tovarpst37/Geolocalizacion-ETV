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


<div class="container-fluid text-center px-2">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">


  


    <div class="d-flex justify-content-end w-100">
      <div class="input-group" style="max-width: 350px;">
        <form class="input-group" action="index.php" method="GET">
          <input type="hidden" name="modulo" value="ActividadZoocriadero">
          <input type="hidden" name="controlador" value="ActividadZoocriadero">
          <input type="hidden" name="funcion" value="getBuscar">

          <input type="text" name="busqueda" placeholder="Search ..." class="form-control" />

          <button type="submit" class="btn btn-outline-secondary">
            <i class="fa fa-search"></i>
          </button>
        </form>
      </div>
    </div>


    <?php


    


    include_once '../controller/ActividadZoocriadero/ActividadZoocriaderoController.php';
    include_once '../model/ActividadZoocriadero/ActividadZoocriadero.php';

    $array = [];

    $obj2 = new ActividadZoocriaderoController();
    $result = $obj2->getDatos();


    foreach ($result as $rs) {

      $obj = new ActividadZoocriadero($rs['id_actividad_zoo'], $rs['cod_actividad'], $rs['nombre_actividad'], $rs['nombre_estado']);

      $array[] = $obj;
    }

    foreach ($array as $o) {


      $estadoA = strtolower($o->getEstado()) === 'activo';
      $badgeClass = $estadoA ? 'bg-success' : 'bg-danger';
      $id = $o->getId();



    ?>


      <!-- sesion datos -->



      <div class="col">

        <div class="card p-3 h-100 text-center flex-column d-flex align-items-center justify-content-center" style="width: 100% !important; min-width: 0 !important; ">

          <ul class="list-group list-group-flush fs-3 w-100">
            <li class="list-group-item border-0 text-center p-1 d-flex justify-content-center align-items-center">
              <span class="badge fs-5 fw-bold <?php echo $badgeClass; ?> rounded-pill"><?php echo $o->getEstado(); ?></span>
            </li>
            <li class="list-group-item border-0 text-center fw-bolder p-1 d-flex justify-content-center align-items-center "><?php echo $o->getNombre(); ?></li>
            <li class="list-group-item fs-5 border-0 text-center p-1  d-flex justify-content-center align-items-center">Codigo: <?php echo $o->getCodigo(); ?></li>


          </ul>
          <div class="card-body ">
            <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getEdit', array('id' => $o->getId())); ?>" class="btn btn-primary fs-4">
              Editar
            </a>  

            <?php if ($estadoA):  ?>
            <button type="button" class="btn btn-danger fs-4" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $o->getId() ?>">
              Inhabilitar
            </button>
            <?php else:  ?>
            <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'postHabilitar', array('id' => $o->getId())); ?>" class="btn btn-success fs-4">
              habilitar
            </a>
            <?php endif  ?>

          </div>


          <!-- sesion eliminar -->

          <div class="modal fade" id="exampleModal<?php echo $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Inhabilitar Actividad</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <p>¿Estás seguro de inhabilitar <?php echo $o->getNombre() ?></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-clouse" data-bs-dismiss="modal">Cerrar</button>
                    <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'postDelete', array('id' => $o->getId())); ?>" class="btn btn-danger" type="button">Inhabilitar</a>
                  </div>
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

?>