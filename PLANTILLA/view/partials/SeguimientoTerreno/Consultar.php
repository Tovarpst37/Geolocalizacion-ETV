<?php
$clasesEstado = [
  1 => 'bg-success',
  2 => 'bg-danger',
  3 => 'bg-danger',
  4 => 'bg-info text-dark',
  5 => 'bg-success',
];

$nombresEstado = [
  1 => 'Activo',
  2 => 'Inactivo',
  3 => 'Pendiente',
  4 => 'En proceso',
  5 => 'Finalizado',
];
?>


<div class="container mt-4">
  <!-- Buscador -->
  <div class="d-flex justify-content-end w-100 mb-4">
    <div class="input-group" style="max-width: 350px;">
      <form class="input-group" action="index.php" method="GET">
        <input type="hidden" name="modulo" value="HistorialTerreno">
        <input type="hidden" name="controlador" value="HistorialTerreno">
        <input type="hidden" name="funcion" value="getBuscar">

        <input type="text" name="busqueda" placeholder="Buscar por código..." class="form-control" />
        <button type="submit" class="btn btn-outline-secondary">
          <i class="fa fa-search"></i>
        </button>
      </form>
    </div>
  </div>

  <div class="list-group">
    <?php if (!empty($seguimientos)): ?>
      <?php foreach ($seguimientos as $s): ?>
        <?php
        $idEstado = (int) ($s['id_estado'] ?? 0);
        $claseBadge = $clasesEstado[$idEstado] ?? 'bg-secondary';
        $nombreEstado = $s['nombre_estado'] ?? $nombresEstado[$idEstado] ?? 'Sin estado';
        ?>
        <div class="list-group-item d-flex flex-column mb-3 border rounded shadow-sm p-3">

          <!-- Encabezado de la Tarjeta -->
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div>
              <h6 class="mb-1 text-primary">
                <strong>Código Seguimiento:</strong>
                <?php echo htmlspecialchars($s['cod_seguimiento']); ?>
              </h6>
              <small class="text-muted d-block">
                <strong>Fecha:</strong>
                <?php echo htmlspecialchars($s['fecha'] ?? 'N/A'); ?>
                <strong>Sitio:</strong>
                <?php echo htmlspecialchars($s['nombre_sitio'] ?? 'N/A'); ?>
                <strong>Documento Usuario:</strong>
                <?php echo htmlspecialchars($s['documento'] ?? 'N/A'); ?>
              </small>
            </div>

            <div class="d-flex align-items-center gap-2">
              <span class="badge <?php echo $claseBadge; ?>">
                <?php echo htmlspecialchars($nombreEstado); ?>
              </span>

              <a href="<?php echo getUrl("HistorialTerreno", "HistorialTerreno", "getEditar", array('id' => $s['id_seguimiento_terreno'])); ?>"
                class="btn btn-sm btn-primary">Editar</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-warning text-center">No hay registros de seguimiento disponibles.</div>
    <?php endif; ?>
  </div>
</div>