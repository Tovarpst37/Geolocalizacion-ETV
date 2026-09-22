<?php
// Color del badge según la tabla estado
$clasesEstado = [
    1 => 'bg-success',
    2 => 'bg-danger',
    3 => 'bg-danger',
    4 => 'bg-info text-dark',
    5 => 'bg-success',
];

$idEstado = (int) ($seguimiento['id_estado'] ?? 0);
$claseBadge = $clasesEstado[$idEstado] ?? 'bg-secondary';
$nombreEstado = $seguimiento['nombre_estado'] ?? 'Sin estado';
?>
<style>
    .ver-page {
        --blue-primary: #2563eb;
        --blue-soft: #eff6ff;
        --blue-border: #bfdbfe;
        --ink: #1e293b;
        --muted: #64748b;
        --line: #e2e8f0;
        --bg-card: #ffffff;
        --success: #16a34a;
        --success-bg: #f0fdf4;
        --danger: #dc2626;
        --danger-bg: #fef2f2;
        --info: #2563eb;
        --info-bg: #eff6ff;
    }

    .ver-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .ver-title-group {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .ver-title-group h3 {
        color: var(--ink);
        font-weight: 700;
        margin: 0;
        font-size: 1.4rem;
    }

    .ver-title-group i {
        color: var(--blue-primary);
        font-size: 1.75rem;
    }

    .ver-page .status-pill {
        padding: .35rem .85rem;
        border-radius: 20px;
        font-size: .8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        white-space: nowrap;
    }

    .ver-page .status-pill.bg-success {
        background-color: var(--success-bg) !important;
        color: var(--success) !important;
        border: 1px solid rgba(22, 163, 74, 0.2);
    }

    .ver-page .status-pill.bg-danger {
        background-color: var(--danger-bg) !important;
        color: var(--danger) !important;
        border: 1px solid rgba(220, 38, 38, 0.2);
    }

    .ver-page .status-pill.bg-info {
        background-color: var(--info-bg) !important;
        color: var(--info) !important;
        border: 1px solid var(--blue-border);
    }

    .ver-page .status-pill.bg-secondary {
        background-color: #f1f5f9 !important;
        color: var(--muted) !important;
        border: 1px solid var(--line);
    }

    .ver-card {
        background: var(--bg-card);
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .ver-card h5 {
        color: var(--ink);
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .ver-card h5 i {
        color: var(--blue-primary);
    }

    .ver-row {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
        font-size: .9rem;
        color: var(--ink);
        padding: .5rem 0;
        border-bottom: 1px dashed var(--line);
    }

    .ver-row:last-child {
        border-bottom: none;
    }

    .ver-row .lbl {
        font-weight: 600;
        color: var(--muted);
        min-width: 220px;
    }

    .ver-empty {
        color: var(--muted);
        font-size: .875rem;
        font-style: italic;
        padding: .5rem 0;
    }

    .ver-back-btn {
        border-radius: 8px;
        font-weight: 600;
    }
</style>

<div class="ver-page container-fluid px-2 px-md-3">

    <div class="ver-header">
        <div class="ver-title-group">
            <i class="bx bx-detail"></i>
            <h3>Detalle del Seguimiento en Terreno</h3>
        </div>
        <a href="<?php echo getUrl("HistorialTerreno", "HistorialTerreno", "getConsultar"); ?>"
            class="btn btn-white ver-back-btn">
            <i class="bx bx-arrow-back"></i> Volver
        </a>
    </div>

    <!-- Datos generales -->
    <div class="ver-card">
        <h5><i class="bx bx-list-check"></i> Información general</h5>
        <div class="ver-row">
            <span class="lbl">Código de seguimiento:</span>
            <span><?php echo htmlspecialchars($seguimiento['cod_seguimiento'] ?? 'N/A'); ?></span>
        </div>
        <div class="ver-row">
            <span class="lbl">Fecha:</span>
            <span><?php echo htmlspecialchars($seguimiento['fecha'] ?? 'N/A'); ?></span>
        </div>
        <div class="ver-row">
            <span class="lbl">Sitio:</span>
            <span><?php echo htmlspecialchars($seguimiento['nombre_sitio'] ?? 'N/A'); ?></span>
        </div>
        <div class="ver-row">
            <span class="lbl">Documento usuario:</span>
            <span><?php echo htmlspecialchars($seguimiento['documento'] ?? 'N/A'); ?></span>
        </div>
        <div class="ver-row">
            <span class="lbl">Estado:</span>
            <span class="badge <?php echo $claseBadge; ?> status-pill">
                <i class="bx bxs-circle fs-6"></i>
                        <?php echo htmlspecialchars($nombreEstado); ?>
            </span>
        </div>
    </div>

    <!-- Actividades -->
      <?php foreach ($config as $slug => $cfg): ?>
            <?php if (!empty($actividadesAsignadas[$slug])): ?>
            <div class="ver-card">
                <h5><i class="bx bx-task"></i> <?php echo htmlspecialchars($cfg['titulo']); ?></h5>

                        <?php if (!empty($grupos[$slug])): ?>
                              <?php foreach ($grupos[$slug] as $i => $registro): ?>
                                    <?php if ($i > 0): ?>
                            <hr class="my-2"><?php endif; ?>
                                    <?php foreach ($cfg['campos'] as $campo => $tipo): ?>
                            <div class="ver-row">
                                <span class="lbl"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $campo))); ?>:</span>
                                <span>
                                                      <?php
                                                      $valor = $registro[$campo] ?? '';
                                                      if ($tipo === 'bool') {
                                                          echo !empty($valor) ? 'Sí' : 'No';
                                                      } else {
                                                          echo $valor !== '' && $valor !== null ? htmlspecialchars($valor) : 'N/A';
                                                      }
                                                      ?>
                                </span>
                            </div>
                                    <?php endforeach; ?>
                              <?php endforeach; ?>
                        <?php else: ?>
                    <div class="ver-empty">Sin registros para esta actividad.</div>
                        <?php endif; ?>
            </div>
            <?php endif; ?>
      <?php endforeach; ?>

</div>