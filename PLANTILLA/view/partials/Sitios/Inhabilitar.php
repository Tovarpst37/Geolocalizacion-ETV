<div class="modal show" tabindex="-1" style="display:block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inhabilitar sitio</h5>
                <a href="<?php echo getUrl('Sitios', 'Sitios', 'getConsultar') ?>">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
            </div>
            <div class="modal-body">
                <p>Estas seguro que quieres Inhabilitar este sitio</p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo getUrl('Sitios', 'Sitios', 'getConsultar') ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <a href="<?php echo getUrl('Sitios', 'Sitios', 'posDelete', array('id' => $id)); ?>">
                        <button type="button" class="btn btn-primary">Inhabilitar</button>
                    </a>
            </div>
        </div>
    </div>
</div>
<?php include_once '../view/partials/Sitios/Consultar.php'; ?>