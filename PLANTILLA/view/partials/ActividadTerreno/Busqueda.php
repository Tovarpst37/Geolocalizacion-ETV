<div class="container-fluid text-center px-2">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">





        <div class="d-flex justify-content-end w-100">
            <div class="input-group" style="max-width: 350px;">
                <form class="input-group" action="index.php" method="GET">
                    <input type="hidden" name="modulo" value="ActividadTerreno">
                    <input type="hidden" name="controlador" value="ActividadTerreno">
                    <input type="hidden" name="funcion" value="getBuscar">

                    <input type="text" name="busqueda" placeholder="Search ..." class="form-control" />

                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>


        <?php





        include_once '../controller/ActividadTerreno/ActividadTerrenoController.php';
        include_once '../model/ActividadTerreno/ActividadTerreno.php';
        if (!empty($actividad2)) {
            $array = [];

            foreach ($actividad2 as $rs) {

                $obj = new ActividadTerreno($rs['id_actividad_terreno'], $rs['cod_actividad_terreno'], $rs['nombre_actividad'], $rs['nombre_estado']);

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

                    <div class="card p-3 h-100 text-center flex-column d-flex align-items-center justify-content-center" style="width: 100% !important; min-width: 0 !important; ">

                        <ul class="list-group list-group-flush fs-3 w-100">
                            <li class="list-group-item border-0 text-center p-1 d-flex justify-content-center align-items-center">
                                <span class="badge fs-5 fw-bold <?php echo $badgeClass; ?> rounded-pill"><?php echo $o->getEstado(); ?></span>
                            </li>
                            <li class="list-group-item border-0 text-center fw-bolder p-1 d-flex justify-content-center align-items-center "><?php echo $o->getNombre(); ?></li>
                            <li class="list-group-item fs-5 border-0 text-center p-1  d-flex justify-content-center align-items-center">Codigo: <?php echo $o->getCodigo(); ?></li>


                        </ul>
                        <div class="card-body ">
                            <a href="<?php echo getUrl('ActividadTerreno', 'ActividadTerreno', 'getEditar', array('id' => $o->getId())); ?>" class="btn btn-primary fs-4">
                                Editar
                            </a>

                            <?php if ($estadoA):  ?>
                                <button type="button" class="btn btn-danger fs-4" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $o->getId() ?>">
                                    Inhabilitar
                                </button>
                            <?php else:  ?>
                                <button type="button" class="btn btn-success fs-4" data-bs-toggle="modal" data-bs-target="#exampleModalHabilitar<?php echo $o->getId() ?>">
                                    habilitar
                                </button>
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
                                        <p>¿Estás seguro de inhabilitar?<?php echo $o->getNombre() ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-clouse" data-bs-dismiss="modal">Cerrar</button>
                                        <a href="<?php echo getUrl('ActividadTerreno', 'ActividadTerreno', 'postDelete', array('id' => $o->getId())); ?>" class="btn btn-danger" type="button">Inhabilitar</a>
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
                                        <a href="<?php echo getUrl('ActividadTerreno', 'ActividadTerreno', 'postHabilitar', array('id' => $o->getId())); ?>" class="btn btn-danger" type="button">Inhabilitar</a>
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