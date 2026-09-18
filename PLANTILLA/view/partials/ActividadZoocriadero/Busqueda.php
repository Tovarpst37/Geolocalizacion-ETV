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
        if (!empty($actividad2)) {
            $array = [];

            foreach ($actividad2 as $rs) {

                $obj = new ActividadZoocriadero($rs['id_actividad_zoo'], $rs['cod_actividad'], $rs['nombre_actividad'], $rs['nombre_estado']);

                $array[] = $obj;
            }
            foreach ($array as $o) {

                // se guarda falso o verdadero si es igual a activo
                $estadoA = strtolower($o->getEstado()) === 'activo';

                // se crea otra variable para preguntar el estado cual es?
                $badgeClass = $estadoA ? 'bg-success' : 'bg-danger';

                $id = $o->getId();



        ?>


                <!-- sesion datos -->


<div class="col">
          <div class="card p-4 h-70 border-0 shadow rounded-4 text-start " style="max-width: 360px;">

            <!-- Badge de Estado -->
            <div class="mb-2">
              <span class="badge <?php echo $badgeClass; ?> rounded-pill px-3 py-2 fw-normal">
                <?php echo ucfirst($o->getEstado()); ?>
              </span>
            </div>

            <!-- Código e ID -->
            <div class="mb-3">
              <h4 class="fw-bold text-dark mb-0"><?php echo $o->getNombre(); ?></h4>
              <small class="text-muted fw-semibold">ID <?php echo $o->getId(); ?></small>
            </div>

            <!-- Lista de datos con divisores -->
            <ul class="list-group list-group-flush mb-4">
              <li class="list-group-item px-1 py-2 border-top text-dark fw-medium" style="border-color: #e0e0e0 !important;">
              Codigo: <?php echo $o->getCodigo(); ?>
              </li>
              <!-- Puedes agregar más elementos de lista si los requieres -->
            </ul>

            <!-- Botones de Acción -->
            <div class="mt-auto d-flex gap-2">
              <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getEditar', array('id' => $o->getId())); ?>"
                class="btn btn-primary w-50 py-2 fw-semibold">
                Editar
              </a>

              <?php if ($estadoA): ?>
                <button type="button" class="btn btn-danger w-50 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $o->getId(); ?>">
                  Inhabilitar
                </button>
              <?php else: ?>
                <button type="button" class="btn btn-success w-50 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModalHabilitar<?php echo $o->getId(); ?>">
                  Habilitar
                </button>
              <?php endif; ?>
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
                    <p>¿Estás seguro de inhabilitar? <?php echo $o->getNombre() ?></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-clouse" data-bs-dismiss="modal">Cerrar</button>
                    <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'postDelete', array('id' => $o->getId())); ?>" class="btn btn-danger" type="button">Inhabilitar</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- sesion habilitar -->

            <div class="modal fade" id="exampleModalHabilitar<?php echo $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">habilitar Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <p>¿Estás seguro de habilitar? <?php echo $o->getNombre() ?></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-clouse" data-bs-dismiss="modal">Cerrar</button>
                    <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'postHabilitar', array('id' => $o->getId())); ?>" class="btn btn-danger" type="button">Inhabilitar</a>
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

        } else { ?>
    <div class="w-100 d-flex flex-column align-items-center justify-content-center text-muted py-5 mt-5">
        <i class="fa fa-search fa-2x mb-3"></i>
        <p class="mb-3">No se encontraron resultados</p>
    </div>
    </div>
    </div>

<?php } ?>