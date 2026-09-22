<style>
  .terreno-list {
    --accent: #3b5bdb;
    --accent-dark: #2f49b5;
    --accent-soft: #edf1ff;
    --ink: #1f2937;
    --muted: #6b7280;
    --line: #dfe4ec;
    --field: #f7f9fc;
  }

  .terreno-list .page-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.75rem;
  }

  .terreno-list .page-header h4 {
    font-weight: 700;
    color: var(--ink);
    letter-spacing: -0.02em;
    margin: 0;
  }

  .terreno-list .search-box {
    max-width: 360px;
    width: 100%;
  }

  .terreno-list .search-box .input-group {
    border: 1.5px solid var(--line);
    border-radius: 12px;
    overflow: hidden;
    background: var(--field);
    transition: border-color .15s ease, box-shadow .15s ease;
  }

  .terreno-list .search-box .input-group:focus-within {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(59, 91, 219, .16);
    background: #fff;
  }

  .terreno-list .search-box .form-control {
    border: 0;
    background: transparent;
    min-height: 2.75rem;
    padding: .6rem 1rem;
    font-size: .95rem;
    color: var(--ink);
    box-shadow: none !important;
  }

  .terreno-list .search-box .form-control::placeholder {
    color: #a3acba;
  }

  .terreno-list .search-box .btn {
    border: 0;
    background: transparent;
    color: var(--muted);
    padding: 0 1rem;
    transition: color .15s ease;
  }

  .terreno-list .search-box .btn:hover {
    color: var(--accent);
  }

  .terreno-list .seg-card {
    background: #fff;
    border: 1.5px solid var(--line);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 14px rgba(31, 41, 55, .05);
    transition: border-color .15s ease, box-shadow .15s ease;
  }

  .terreno-list .seg-card:hover {
    border-color: #c3cbd9;
    box-shadow: 0 8px 22px rgba(31, 41, 55, .08);
  }

  .terreno-list .seg-card h6 {
    font-weight: 700;
    color: var(--ink);
    margin-bottom: .35rem;
    font-size: 1rem;
  }

  .terreno-list .seg-meta {
    font-size: .875rem;
    color: var(--muted);
    line-height: 1.5;
  }

  .terreno-list .seg-actions {
    display: flex;
    align-items: center;
    gap: .5rem;
    flex-wrap: wrap;
  }

  .terreno-list .badge {
    font-weight: 600;
    font-size: .78rem;
    padding: .4rem .75rem;
    border-radius: 8px;
  }

  .terreno-list .btn {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .5rem 1.1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: .88rem;
    transition: transform .12s ease, box-shadow .12s ease;
  }

  .terreno-list .btn-primary {
    background-color: var(--accent);
    border-color: var(--accent);
  }

  .terreno-list .btn-primary:hover {
    background-color: var(--accent-dark);
    border-color: var(--accent-dark);
    transform: translateY(-1px);
  }

  .terreno-list .btn-danger {
    border-radius: 10px;
  }

  .terreno-list .empty-state {
    text-align: center;
    padding: 4rem 1rem;
    color: var(--muted);
  }

  .terreno-list .empty-state i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    opacity: .5;
  }

  .terreno-list .empty-state p {
    font-size: 1.05rem;
    margin: 0;
  }
</style>

<div class="terreno-list">
  <div class="page-header">
    <h4>Seguimiento Terreno</h4>

    <div class="search-box">
      <form class="input-group" action="index.php" method="GET">
        <input type="hidden" name="modulo" value="SeguimientoTerreno">
        <input type="hidden" name="controlador" value="SeguimientoTerreno">
        <input type="hidden" name="funcion" value="getBuscar">

        <input type="text" name="busqueda" placeholder="Buscar seguimiento..." class="form-control"
          value="<?php echo $palabra; ?>" />

        <button type="submit" class="btn">
          <i class="fa fa-search"></i>
        </button>
      </form>
    </div>
  </div>

  <div class="mt-2">
    <?php if (!empty($seguimientos)) {
      foreach ($seguimientos as $s) { ?>

        <div class="seg-card d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

          <div>
            <h6><?php echo $s['cod_seguimiento']; ?> — Sitio <?php echo $s['nombre_sitio']; ?> — Deposito <?php echo $s['cod_terreno']; ?></h6>
            <div class="seg-meta">
              <?php echo $s['hora_inicio']; ?> - <?php echo $s['hora_fin']; ?>
              &nbsp;|&nbsp; Auxiliar: <?php echo $s['primer_nombre'] . " " . $s['primer_apellido']; ?>
            </div>
            <div class="seg-meta">
              <b>Actividades:</b> <?php echo $s['actividades'] ?? 'Sin actividades asignadas'; ?>
            </div>
          </div>

          <div class="seg-actions">
            <span class="badge <?php echo $s['id_estado'] == 3 ? 'bg-danger' : ($s['id_estado'] == 4 ? 'bg-primary' : ($s['id_estado'] == 5 ? 'bg-success' : '')); ?>">
              <?php
              switch ($s['id_estado']) {
                case 3: echo 'Pendiente'; break;
                case 4: echo 'En proceso'; break;
                case 5: echo 'Finalizado'; break;
              }
              ?>
            </span>

            <a href="<?php echo getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getEditar", array('id' => $s['id_seguimiento_terreno'])) ?>"
              class="btn btn-primary">
              <i class="bx bx-edit"></i> Editar
            </a>

            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
              data-bs-target="#seg<?php echo $s['id_seguimiento_terreno'] ?>">
              <i class="bx bx-trash"></i> Inhabilitar
            </button>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="seg<?php echo $s['id_seguimiento_terreno'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Inhabilitar Seguimiento</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <p>¿Estás seguro de inhabilitar el seguimiento de <?php echo $s['cod_terreno']; ?>
                    (<?php echo $s['hora_inicio']; ?> - <?php echo $s['hora_fin']; ?>)?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  <a href="<?php echo getUrl('SeguimientoTerreno', 'SeguimientoTerreno', 'postDelete', array('id' => $s['id_seguimiento_terreno'])); ?>"
                    class="btn btn-danger">Inhabilitar</a>
                </div>
              </div>
            </div>
          </div>

        </div>

      <?php }
    } else { ?>

      <div class="empty-state">
        <i class="fa fa-search"></i>
        <p>No se encontraron resultados</p>
      </div>

    <?php } ?>
  </div>
</div>