<?php
// Ruta de esta misma pantalla. Se separa en "action" + campos ocultos para que
// al enviar el formulario por GET no se pierdan los parametros que usa index.php
$urlReporte = getUrl('Reportes', 'Reportes', 'report');
$partesUrl  = parse_url($urlReporte);
parse_str($partesUrl['query'] ?? '', $paramsRuta);

// URL del Excel con los mismos filtros que tiene la pantalla
$urlExcel = getUrl('Reportes', 'Reportes', 'exportarSeguimientosExcel');
$urlExcel .= (strpos($urlExcel, '?') === false ? '?' : '&') . http_build_query([
    'zoocriadero'  => $filtroZoocriadero,
    'actividad'    => $filtroActividad,
    'fecha_inicio' => $filtroFechaInicio,
    'fecha_fin'    => $filtroFechaFin,
]);
?>

<div class="caja">
    <h2 class="titulo-pagina">Seguimiento de Actividades en los Zoocriaderos</h2>
    <h3>Filtros</h3>
    <form method="GET" action="<?= htmlspecialchars($partesUrl['path'] ?? '') ?>">
        <?php foreach ($paramsRuta as $nombre => $valor): ?>
            <input type="hidden" name="<?= htmlspecialchars($nombre) ?>" value="<?= htmlspecialchars((string) $valor) ?>">
        <?php endforeach; ?>

        <div class="fila-filtros">
            <div>
                <label>Zoocriadero</label>
                <select name="zoocriadero">
                    <option value="">Todos</option>
                    <?php foreach ($zoocriaderos as $z): ?>
                        <option value="<?= $z['id_zoocriadero'] ?>"
                            <?= $filtroZoocriadero == $z['id_zoocriadero'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($z['cod_zoocriadero']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Actividad</label>
                <select name="actividad">
                    <option value="">Todos</option>
                    <?php foreach ($actividades as $act): ?>
                        <option value="<?= $act['id_actividad_zoo'] ?>"
                            <?= $filtroActividad == $act['id_actividad_zoo'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($act['nombre_actividad']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Fecha Inicio</label>
                <input type="date" name="fecha_inicio" value="<?= htmlspecialchars($filtroFechaInicio) ?>">
            </div>
            <div>
                <label>Fecha Fin</label>
                <input type="date" name="fecha_fin" value="<?= htmlspecialchars($filtroFechaFin) ?>">
            </div>
            <div>
                <button type="submit" class="btn-aplicar">Aplicar Filtros</button>
                <button type="button" class="btn-limpiar"
                        onclick="location.href='<?= htmlspecialchars($urlReporte) ?>'">Limpiar Filtros</button>
                <button type="button" class="btn-reportes"
                        onclick="location.href='<?= htmlspecialchars($urlExcel) ?>'">Generar Reportes</button>
            </div>
        </div>
    </form>
</div>

<?php if ($mensajeError): ?>
    <div class="caja mensaje-error"><?= htmlspecialchars($mensajeError) ?></div>
<?php endif; ?>

<div class="caja tarjetas">
    <div class="tarjeta">
        <div class="icono icono-azul">📋</div>
        <div>
            <p>Actividades Totales</p>
            <span class="numero azul"><?= $totalActividades ?></span>
        </div>
    </div>
    <div class="tarjeta">
        <div class="icono icono-verde">✔</div>
        <div>
            <p>Actividades Completas</p>
            <span class="numero verde"><?= $totalCompletas ?></span>
        </div>
    </div>
    <div class="tarjeta">
        <div class="icono icono-naranja">⏱</div>
        <div>
            <p>En Progreso</p>
            <span class="numero naranja"><?= $totalEnProgreso ?></span>
        </div>
    </div>
    <div class="tarjeta">
        <div class="icono icono-rojo">✖</div>
        <div>
            <p>Retrasadas</p>
            <span class="numero rojo"><?= $totalRetrasadas ?></span>
        </div>
    </div>
</div>

<div class="caja">
    <h3>Detalles de Actividades</h3>
    <table>
        <thead>
            <tr>
                <th>Actividad</th>
                <th>Zoocriadero</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Responsable</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($seguimientos as $s): ?>
                <?php
                    // Color del badge según el estado
                    if ($s['estado'] == $finalizado) {
                        $claseBadge = 'badge-verde';
                    } elseif ($s['estado'] == $enProceso) {
                        $claseBadge = 'badge-naranja';
                    } else {
                        $claseBadge = 'badge-rojo';
                    }

                    $fechaInicio = date('d/m/Y', strtotime($s['fecha_inicio']));
                    $fechaFin    = $s['fecha_fin'] ? date('d/m/Y', strtotime($s['fecha_fin'])) : '-';
                ?>
                <tr>
                    <td><?= htmlspecialchars($s['actividad']) ?></td>
                    <td><?= htmlspecialchars($s['zoocriadero']) ?></td>
                    <td><?= $fechaInicio ?></td>
                    <td><?= $fechaFin ?></td>
                    <td><?= htmlspecialchars($s['responsable']) ?></td>
                    <td><span class="badge <?= $claseBadge ?>"><?= htmlspecialchars($s['estado']) ?></span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    .caja {
        background-color: #ffffff;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.34);
        font-family: Arial, Helvetica, sans-serif;
    }

    .titulo-pagina {
        text-align: center;
        font-size: 22px;
        margin-top: 0;
        margin-bottom: 24px;
    }

    .caja h3 {
        margin-top: 0;
        margin-bottom: 16px;
    }

    .mensaje-error {
        background-color: #fde6e6;
        color: #e64545;
        font-weight: bold;
    }

    .fila-filtros {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 20px;
    }

    .fila-filtros label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
    }

    .fila-filtros select,
    .fila-filtros input[type="date"] {
        padding: 8px 12px;
        border: 1px solid #d7dbe3;
        border-radius: 8px;
        min-width: 160px;
    }

    .btn-aplicar {
        background-color: #2f7dfa;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-reportes {
        background-color: #ffffff;
        color: #2f7dfa;
        border: 1px solid #2f7dfa;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        margin-left: 8px;
    }

    .btn-limpiar {
        background-color: #eef1f8;
        color: #555555;
        border: 1px solid #d7dbe3;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        margin-left: 8px;
    }

    .tarjetas {
        display: flex;
        gap: 20px;
    }

    .tarjeta {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .icono {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .icono-azul    { background-color: #e5f0ff; color: #2f7dfa; }
    .icono-verde   { background-color: #e3f9ec; color: #21a666; }
    .icono-naranja { background-color: #fff3df; color: #e0952d; }
    .icono-rojo    { background-color: #fde6e6; color: #e64545; }

    .tarjeta p {
        margin: 0 0 4px 0;
        color: #666;
        font-size: 14px;
    }

    .numero { font-size: 26px; font-weight: bold; }
    .azul    { color: #2f7dfa; }
    .verde   { color: #21a666; }
    .naranja { color: #e0952d; }
    .rojo    { color: #e64545; }

    table { width: 100%; border-collapse: collapse; }

    th {
        text-align: left;
        padding: 12px;
        color: #555;
        border-bottom: 2px solid #eef1f8;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #eef1f8;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        color: #ffffff;
        font-size: 13px;
        font-weight: bold;
    }

    .badge-verde   { background-color: #2ecc71; }
    .badge-naranja { background-color: #f5a623; }
    .badge-rojo    { background-color: #e74c3c; }
</style>