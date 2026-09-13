<?php

class ErrorModal
{
    public static function verError(array $errores, string $urlRegreso)
    {
        if (empty($errores)) {
            return;
        }
?>
        <div class="modal fade" id="modalErrores" tabindex="-1" aria-labelledby="modalErroresLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalErroresLabel">
                            <span class="fs-4">⚠️</span> Errores en el formulario
                        </h5>
                        <a href="<?php echo $urlRegreso; ?>">
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </a>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">Por favor corrige los siguientes campos antes de continuar:</p>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($errores as $error): ?>
                                <li class="list-group-item text-danger d-flex align-items-center gap-2">
                                    <span>⚠️</span> <?php echo $error; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo $urlRegreso; ?>">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Entendido</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = new bootstrap.Modal(document.getElementById('modalErrores'));
                modal.show();
            });
        </script>
<?php
    }
}
