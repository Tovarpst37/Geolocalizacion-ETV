<?php
// Color del badge según la tabla estado
$clasesEstado = [
  1 => 'bg-success',
  2 => 'bg-danger',
  3 => 'bg-danger',
  4 => 'bg-info text-dark',
  5 => 'bg-success',
];
?>
<style>
  .seg-page {
    --blue-primary: #2563eb;
    --blue-hover: #1d4ed8;
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

  /* Header principal */
  .seg-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .seg-title-group {
    display: flex;
    align-items: center;
    gap: .75rem;
  }

  .seg-title-group h3 {
    color: var(--ink);
    font-weight: 700;
    margin: 0;
    font-size: 1.4rem;
  }

  .seg-title-group i {
    color: var(--blue-primary);
    font-size: 1.75rem;
  }

  /* Buscador */
  .seg-search-box-wrap {
    width: 100%;
  }

  @media (min-width: 576px) {
    .seg-search-box-wrap {
      width: auto;
      min-width: 280px;
    }
  }

  .seg-search-box {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
  }

  .seg-search-box .form-control {
    padding-left: 2.5rem;
    padding-right: 2.75rem;
    border-radius: 10px;
    border: 1px solid var(--line);
    background-color: #ffffff;
    height: 2.6rem;
    font-size: .9rem;
    transition: all .15s ease;
    width: 100%;
  }

  .seg-search-box .form-control:focus {
    border-color: var(--blue-primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    outline: none;
  }

  .seg-search-box .search-icon {
    position: absolute;
    left: .85rem;
    color: var(--muted);
    font-size: 1.1rem;
    pointer-events: none;
  }

  .seg-search-box .btn-search {
    position: absolute;
    right: .25rem;
    border: 0;
    background: var(--blue-soft);
    color: var(--blue-primary);
    height: 2.1rem;
    width: 2.1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .15s ease;
  }

  .seg-search-box .btn-search:hover {
    background: var(--blue-border);
  }

  /* Lista Ultra-Responsiva */
  .seg-list-container {
    display: flex;
    flex-direction: column;
    gap: .85rem;
    width: 100%;
  }

  .seg-list-item {
    background: var(--bg-card);
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 1.1rem;
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    transition: all .2s ease;
    width: 100%;
    min-width: 0;
    overflow: hidden;
  }

  @media (min-width: 768px) {
    .seg-list-item {
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 1.25rem;
      gap: 1.25rem;
    }
  }

  .seg-list-item:hover {
    border-color: var(--blue-border);
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
  }

  /* Información del ítem */
  .seg-info {
    display: flex;
    flex-direction: column;
    gap: .35rem;
    flex: 1;
    min-width: 0;
  }

  .seg-code {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--ink);
    margin: 0;
    display: flex;
    align-items: center;
    gap: .5rem;
    word-wrap: break-word;
  }

  .seg-code i {
    color: var(--blue-primary);
    font-size: 1.15rem;
    flex-shrink: 0;
  }

  .seg-detail {
    font-size: .875rem;
    color: var(--muted);
    margin: 0;
    display: flex;
    align-items: flex-start;
    gap: .4rem;
    word-break: break-word;
    line-height: 1.4;
  }

  .seg-detail i {
    color: var(--muted);
    font-size: 1.05rem;
    flex-shrink: 0;
    margin-top: 2px;
  }

  /* Lado derecho: Estado y Botón */
  .seg-actions-wrap {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: .75rem;
    width: 100%;
    border-top: 1px dashed var(--line);
    padding-top: .85rem;
  }

  @media (min-width: 768px) {
    .seg-actions-wrap {
      width: auto;
      border-top: none;
      padding-top: 0;
      flex-direction: row;
      align-items: center;
      justify-content: flex-end;
    }
  }

  /* Badges de estado -> convertidos a pill, sin tocar las clases bg-* originales */
  .seg-page .status-pill {
    padding: .35rem .85rem;
    border-radius: 20px;
    font-size: .8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    white-space: nowrap;
  }

  .seg-page .status-pill.bg-success {
    background-color: var(--success-bg) !important;
    color: var(--success) !important;
    border: 1px solid rgba(22, 163, 74, 0.2);
  }

  .seg-page .status-pill.bg-danger {
    background-color: var(--danger-bg) !important;
    color: var(--danger) !important;
    border: 1px solid rgba(220, 38, 38, 0.2);
  }

  .seg-page .status-pill.bg-info {
    background-color: var(--info-bg) !important;
    color: var(--info) !important;
    border: 1px solid var(--blue-border);
  }

  .seg-page .status-pill.bg-secondary {
    background-color: #f1f5f9 !important;
    color: var(--muted) !important;
    border: 1px solid var(--line);
  }

  /* Grupo de Botones adaptable */
  .seg-btn-group-custom {
    display: flex;
    flex-direction: column;
    gap: .5rem;
    width: 100%;
  }

  @media (min-width: 400px) {
    .seg-btn-group-custom {
      flex-direction: row;
    }
  }

  @media (min-width: 768px) {
    .seg-btn-group-custom {
      width: auto;
    }
  }

  .seg-btn-group-custom .btn {
    font-size: .85rem;
    font-weight: 600;
    padding: .45rem .9rem;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .35rem;
    transition: all .15s ease;
    width: 100%;
    white-space: nowrap;
    box-sizing: border-box;
  }

  @media (min-width: 400px) {
    .seg-btn-group-custom .btn {
      flex: 1;
    }
  }

  @media (min-width: 768px) {
    .seg-btn-group-custom .btn {
      flex: initial;
      width: auto;
    }
  }

  .seg-page .btn-blue {
    background-color: var(--blue-primary);
    color: #ffffff;
    border: none;
  }

  .seg-page .btn-blue:hover {
    background-color: var(--blue-hover);
    color: #ffffff;
  }
</style>

<div class="seg-page container-fluid px-2 px-md-3">

  <!-- Cabecera y Buscador -->
  <div class="seg-header">
    <div class="seg-title-group">
      <i class="bx bx-list-check"></i>
      <h3 style="color: #ffffff">Seguimientos Zoocriadero</h3>
    </div>

    <div class="seg-search-box-wrap">
      <form class="m-0" action="index.php" method="GET">
        <input type="hidden" name="modulo" value="SeguimientoZoocriadero">
        <input type="hidden" name="controlador" value="SeguimientoZoocriadero">
        <input type="hidden" name="funcion" value="getBuscar">

        <div class="seg-search-box">
          <i class="bx bx-search search-icon"></i>
          <input type="text" name="busqueda" placeholder="Buscar por código..." class="form-control" value="<?php echo htmlspecialchars($palabra ?? ''); ?>" />
          <button type="submit" class="btn-search" aria-label="Buscar">
            <i class="bx bx-right-arrow-alt fs-5"></i>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Lista de Filas -->
  <div class="seg-list-container">
    <?php if (!empty($seguimientos)): ?>
      <?php foreach ($seguimientos as $s): ?>
        <?php
        $idEstado = (int) ($s['id_estado'] ?? 0);
        $claseBadge = $clasesEstado[$idEstado] ?? 'bg-secondary';
        $nombreEstado = $s['nombre_estado'] ?? 'Sin estado';
        ?>
        <div class="seg-list-item">

          <!-- Datos Principales -->
          <div class="seg-info">
            <h6 class="seg-code">
              <i class="bx bx-list-check"></i>
              <span>Código Seguimiento: <?php echo htmlspecialchars($s['cod_seguimiento'] ?? 'N/A'); ?></span>
            </h6>
            <p class="seg-detail">
              <i class="bx bx-calendar"></i>
              <span>Fecha: <?php echo !empty($s['fecha']) ? date('d/m/Y h:i A', strtotime($s['fecha'])) : 'N/A'; ?></span>
            </p>
            <p class="seg-detail">
              <i class="bx bx-id-card"></i>
              <span>Documento Usuario: <?php echo htmlspecialchars($s['documento'] ?? 'N/A'); ?></span>
            </p>
          </div>

          <!-- Estado y Botón -->
          <div class="seg-actions-wrap">
            <span class="badge <?php echo $claseBadge; ?> status-pill">
              <i class="bx bxs-circle fs-6"></i>
              <?php echo htmlspecialchars($nombreEstado); ?>
            </span>

            <div class="seg-btn-group-custom">
              <a href="<?php echo getUrl("Historial", "Historial", "getVer", array('id' => $s['id_seguimiento_zoo'])); ?>"
                class="btn btn-white">
                <i class="bx bx-edit-alt"></i> ver más
              </a>
            </div>

          </div>

        </div>
      <?php endforeach; ?>
    <?php else: ?>

<div class="w-100 text-center empty-state">
    <div class="empty-state-icon">
      <i class="bx bx-search-alt"></i>
    </div>
    <h5 class="fw-bold text-dark mb-1">Sin resultados</h5>
    <p class="text-muted mb-0">No se encontraron tanques que coincidan con "<strong><?php echo htmlspecialchars($palabra); ?></strong>".</p>
  </div>    <?php endif; ?>
  </div>

</div>