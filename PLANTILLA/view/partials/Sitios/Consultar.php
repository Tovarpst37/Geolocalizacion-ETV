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
                }, 500);
            }
        }, 5000);
    </script>
<?php endif;

$bj = [];
$ob2 = new SitiosController();
$resul = $ob2->data();

if (count($resul) <= 0) {
    include_once '../view/partials/Sitios/notExist.php';
} else {
?>
<div class="page-header">
    <h3 class="fw-bold mb-3">Sitios</h3>
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
    </div>

    <?php
    include_once '../controller/Sitios/SitiosController.php';
    include_once '../model/Sitios/Sitios.php';

    foreach ($resul as $j) {
        $sitios = new Sitios($j['id_sitio'], $j['nombre_sitio'], $j['direccion'], $j['barrio'], $j['estado']);
        $bj[] = $sitios;
    }
    ?>

    <div class="list-group mt-4">

        <?php foreach ($bj as $index => $i):

            $j = $resul[$index];
            $badgeClass = strtolower($i->getEstado()) === 'activo' ? 'bg-success' : 'bg-danger';
        ?>

            <div class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 mb-3 border rounded">

                <div>
                    <h6 class="mb-1"><?php echo $i->getNombre_sitio(); ?> — ID <?php echo $i->getId(); ?></h6>
                    <small class="text-muted">
                        <?php echo $i->getDireccion(); ?>
                        &nbsp;|&nbsp; Barrio: <?php echo $i->getBarrio(); ?>
                    </small>
                    <small class="text-muted">
                        &nbsp;|&nbsp;
                        <b>Coordinador:</b> <?php echo $j['coordinador'] ?? 'Sin asignar'; ?>
                        &nbsp;|&nbsp;
                        <b>Auxiliares:</b> <?php echo $j['auxiliares'] ?? 'Sin asignar'; ?>
                    </small>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="badge <?php echo $badgeClass; ?>">
                        <?php echo $i->getEstado(); ?>
                    </span>
                    <a href="<?php echo getUrl('Sitios', 'Sitios', 'getEdit', array('id' => $i->getId())); ?>" class="btn btn-primary">Editar</a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalInhabilitar<?php echo $i->getId(); ?>">
                        Inhabilitar
                    </button>
                </div>

                <div class="modal fade" id="modalInhabilitar<?php echo $i->getId(); ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Inhabilitar sitio</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro que quieres inhabilitar <strong><?php echo $i->getNombre_sitio(); ?></strong>?</p>
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
        <?php endforeach; ?>
    </div>

<?php } ?>