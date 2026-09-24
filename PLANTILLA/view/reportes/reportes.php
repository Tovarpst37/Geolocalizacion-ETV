<?php

// al enviar el formulario por GET no se pierdan los parametros que usa index.php
$urlReporte = getUrl('Reportes', 'Reportes', 'report');
$partesUrl  = parse_url($urlReporte);
parse_str($partesUrl['query'] ?? '', $paramsRuta);

// URL del Excel con los mismos filtros que tiene la pantalla
$urlExcel = getUrl('Reportes', 'Reportes', 'exportarSeguimientosExcel');
$urlExcel .= (strpos($urlExcel, '?') === false ? '?' : '&') . http_build_query([
    'zoocriadero'  => $filtroZoocriadero,
    'actividad'    => $filtroActividad,
    'fecha_inicio' => $filtroFechaInicio
    
]);

$urlLimpiar = $urlReporte . (strpos($urlReporte, '?') === false ? '?' : '&') . 'limpiar=1';

// Solo para dibujar la barra de proporción (no modifica ninguna variable existente)
$zooTotal = (int) $totalActividades;
$zooPorcentaje = function ($n) use ($zooTotal) {
    return $zooTotal > 0 ? number_format(min(100, ((int) $n / $zooTotal) * 100), 1, '.', '') : '0.0';
};
include_once '../view/partials/function.php';
?>

<div class="zoo-wrap">

    <header class="zoo-header">
        <h2 class="zoo-titulo">Seguimiento de Actividades en los Zoocriaderos</h2>
    </header>

    <!-- Filtros -->
    <section class="zoo-card zoo-filtros">
        <h3 class="zoo-card-titulo">Filtros</h3>
        <form method="GET" action="<?= htmlspecialchars($partesUrl['path'] ?? '') ?>">
            <?php foreach ($paramsRuta as $nombre => $valor): ?>
                <input type="hidden" name="<?= htmlspecialchars($nombre) ?>" value="<?= htmlspecialchars((string) $valor) ?>">
            <?php endforeach; ?>

            <div class="zoo-campos">
                <div class="zoo-campo">
                    <label for="zoo-zoocriadero">Zoocriadero</label>
                    <select id="zoo-zoocriadero" name="zoocriadero">
                        <option value="">Todos</option>
                        <?php foreach ($zoocriaderos as $z): ?>
                            <option value="<?= $z['id_zoocriadero'] ?>"
                                <?= $filtroZoocriadero == $z['id_zoocriadero'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($z['cod_zoocriadero']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="zoo-campo">
                    <label for="zoo-actividad">Actividad</label>
                    <select id="zoo-actividad" name="actividad">
                        <option value="">Todos</option>
                        <?php foreach ($actividades as $act): ?>
                            <option value="<?= $act['id_actividad_zoo'] ?>"
                                <?= $filtroActividad == $act['id_actividad_zoo'] ? 'selected' : '' ?>>
                                <?= ($act['nombre_actividad'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="zoo-campo">
                    <label for="zoo-fecha-inicio">Fecha Inicio</label>
                    <input type="date" id="zoo-fecha-inicio" name="fecha_inicio" value="<?= ($filtroFechaInicio) ?>">
                </div>
            </div><!-- /zoo-campos -->

            <div class="zoo-acciones">
                <button type="submit" class="zoo-btn zoo-btn-primario">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 5h18l-7 8v6l-4 2v-8z"/></svg>
                    Aplicar Filtros
                </button>
                <button type="button" class="zoo-btn zoo-btn-neutro"
                        onclick="location.href='<?= $urlLimpiar ?>'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    Limpiar Filtros
                </button>
                <?php if(condicion('EXPORTAR', 'Reportes')):?>
                    <button type="button" class="zoo-btn zoo-btn-contorno zoo-btn-derecha" <?= empty($seguimientos) ? 'disabled' : '' ?>
                            onclick="location.href='<?= $urlExcel ?>'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12"/><path d="m7 10 5 5 5-5"/><path d="M5 21h14"/></svg>
                        Generar Excel
                    </button>
                <?php endif;?>
            </div>
        </form>
    </section>

    <?php if ($mensajeError): ?>
        <div class="zoo-error" role="alert">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5"/><path d="M12 16.5v.01"/></svg>
            <span><?= ($mensajeError) ?></span>
        </div>
    <?php endif; ?>

    <!-- Resumen -->
    <section class="zoo-resumen" aria-label="Resumen de actividades">
        <div class="zoo-stats">
            <div class="zoo-stat zoo-stat-verde">
                <span class="zoo-stat-numero"><?= $totalActividades ?></span>
                <p class="zoo-stat-label">Actividades Finalizadas</p>
            </div>
        </div>
    </section>

    <!-- Detalle -->
    <section class="zoo-card zoo-detalle">
        <h3 class="zoo-card-titulo">Detalles de Actividades</h3>

        <?php if (!empty($seguimientos)): ?>
            <div class="zoo-tabla-scroll">
                <table class="zoo-tabla">
                    <thead>
                        <tr>
                            <th>Actividad</th>
                            <th>Zoocriadero</th>
                            <th>Fecha Inicio</th>
                            
                            <th>Responsable</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($seguimientos as $s): ?>
                            <?php
                                $retrasada = ($s['estado'] == $pendiente || $s['estado'] == $enProceso)
                                    && $s['fecha_registro'] < $hoy;

                                if ($retrasada) {
                                    $claseBadge = 'badge-rojo';
                                    $textoEstado = 'Retrasada';
                                } elseif ($s['estado'] == $finalizado) {
                                    $claseBadge = 'badge-verde';
                                    $textoEstado = $s['estado'];
                                } elseif ($s['estado'] == $pendiente) {
                                    $claseBadge = 'badge-azul';
                                    $textoEstado = $s['estado'];
                                } else {
                                    $claseBadge = 'badge-naranja';
                                    $textoEstado = $s['estado'];
                                }

                                $fecha       = date('d/m/Y', strtotime($s['fecha_registro']));
                                $fechaInicio = date('Y-m-d H:i:s', strtotime($s['fecha_registro']));
                                $fechaFin    = $s['hora_fin'] ? $fecha . ' ' . substr($s['hora_fin'], 0, 5) : '-';
                            ?>
                           <tr data-estado="<?= $claseBadge ?>">
    <td data-label="Actividad" class="zoo-td-actividad"><?= $s['actividad'] ?? '' ?></td>
    <td data-label="Zoocriadero"><?= $s['zoocriadero'] ?? '' ?></td>
    <td data-label="Fecha Inicio" class="zoo-td-fecha"><?= $fechaInicio ?></td>
    <td data-label="Responsable"><?= $s['responsable'] ?? '' ?></td>
    <td data-label="Estado"><span class="badge <?= $claseBadge ?>"><?= $textoEstado ?? '' ?></span></td>
</tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif (!$mensajeError): ?>
            <div class="zoo-vacio">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                <p>No hay actividades para los filtros seleccionados. Cambia los filtros o límpialos para ver todas.</p>
            </div>
        <?php endif; ?>
    </section>

</div>

<style>
    .zoo-wrap {
        --zoo-fondo: #eaf1fb;
        --zoo-superficie: #ffffff;
        --zoo-tinta: #0f2b4d;
        --zoo-texto: #1f2d3d;
        --zoo-suave: #5f7188;
        --zoo-linea: #d8e2f0;
        --zoo-primario: #1f5fbf;
        --zoo-primario-hover: #184c9a;
        --zoo-verde: #2f8f5b;
        --zoo-naranja: #d98e04;
        --zoo-rojo: #c93c3c;
        --zoo-azul: #2f6fb3;

        font-family: "Segoe UI Variable Text", "Segoe UI", system-ui, -apple-system, Roboto, "Helvetica Neue", Arial, sans-serif;
        color: var(--zoo-texto);
        background-color: var(--zoo-fondo);
        border-radius: 22px;
        padding: 28px;
        max-width: 100%;
        box-sizing: border-box;
    }

    .zoo-wrap *,
    .zoo-wrap *::before,
    .zoo-wrap *::after {
        box-sizing: border-box;
    }

    /* ---------- Encabezado ---------- */
    .zoo-titulo {
        margin: 0 0 24px;
        font-size: 28px;
        font-weight: 700;
        line-height: 1.15;
        letter-spacing: -0.02em;
        color: var(--zoo-tinta);
    }

    /* ---------- Tarjetas ---------- */
    .zoo-card {
        background-color: var(--zoo-superficie);
        border-radius: 18px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .zoo-card-titulo {
        margin: 0 0 18px;
        font-size: 17px;
        font-weight: 600;
        color: var(--zoo-tinta);
    }

    /* ---------- Filtros ---------- */
    .zoo-campos {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .zoo-campo label {
        display: block;
        margin-bottom: 7px;
        font-size: 14px;
        font-weight: 500;
        color: var(--zoo-suave);
    }

    .zoo-campo select,
    .zoo-campo input[type="date"] {
        width: 100%;
        min-height: 44px;
        padding: 10px 14px;
        border: 1px solid #c3d1e6;
        border-radius: 10px;
        background-color: #f7faff;
        color: var(--zoo-texto);
        font-family: inherit;
        font-size: 14px;
        transition: border-color 0.15s, background-color 0.15s;
    }

    .zoo-campo select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 40px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%231f5fbf' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        cursor: pointer;
    }

    .zoo-campo select:hover,
    .zoo-campo input[type="date"]:hover {
        border-color: #93aacb;
    }

    .zoo-campo select:focus,
    .zoo-campo input[type="date"]:focus {
        outline: 2px solid var(--zoo-primario);
        outline-offset: 1px;
        background-color: #ffffff;
    }

    .zoo-acciones {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-top: 22px;
        padding-top: 20px;
        border-top: 1px solid var(--zoo-linea);
    }

    .zoo-btn-derecha {
        margin-left: auto;
    }

    .zoo-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 10px 18px;
        border-radius: 10px;
        border: 1px solid transparent;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background-color 0.15s, border-color 0.15s, transform 0.05s ease;
    }

    .zoo-btn svg {
        flex-shrink: 0;
    }

    .zoo-btn:active:not(:disabled) {
        transform: translateY(1px);
    }

    .zoo-btn:focus-visible {
        outline: 2px solid var(--zoo-primario);
        outline-offset: 2px;
    }

    .zoo-btn-primario {
        background-color: var(--zoo-primario);
        color: #ffffff;
    }

    .zoo-btn-primario:hover {
        background-color: var(--zoo-primario-hover);
    }

    .zoo-btn-neutro {
        background-color: transparent;
        color: var(--zoo-suave);
        border-color: #c3d1e6;
    }

    .zoo-btn-neutro:hover {
        background-color: var(--zoo-fondo);
        color: var(--zoo-tinta);
    }

    .zoo-btn-contorno {
        background-color: transparent;
        color: var(--zoo-primario);
        border-color: var(--zoo-primario);
    }

    .zoo-btn-contorno:hover:not(:disabled) {
        background-color: #e3edfb;
    }

    .zoo-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    /* ---------- Mensaje de error ---------- */
    .zoo-error {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 24px;
        padding: 16px 20px;
        border-radius: 14px;
        border-left: 5px solid var(--zoo-rojo);
        background-color: #fbe9e7;
        color: #8f2a22;
        font-weight: 600;
        line-height: 1.4;
    }

    .zoo-error svg {
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* ---------- Resumen ---------- */
    .zoo-resumen {
        margin-bottom: 28px;
    }

    .zoo-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .zoo-stat {
        padding: 0 24px;
        border-left: 1px solid #c5d3e8;
    }

    .zoo-stat:first-child {
        padding-left: 0;
        border-left: none;
    }

    .zoo-stat-numero {
        display: block;
        font-size: 46px;
        font-weight: 700;
        line-height: 1;
        letter-spacing: -0.03em;
        font-variant-numeric: tabular-nums;
    }

    .zoo-stat-label {
        margin: 8px 0 0;
        font-size: 14px;
        font-weight: 600;
        color: var(--zoo-texto);
    }

    .zoo-stat small {
        display: block;
        margin-top: 2px;
        font-size: 13px;
        color: var(--zoo-suave);
    }

    .zoo-stat-total .zoo-stat-numero  { color: var(--zoo-tinta); }
    .zoo-stat-verde .zoo-stat-numero  { color: var(--zoo-verde); }
    .zoo-stat-naranja .zoo-stat-numero { color: #b06f00; }
    .zoo-stat-rojo .zoo-stat-numero   { color: var(--zoo-rojo); }

    .zoo-barra {
        display: flex;
        gap: 3px;
        height: 12px;
        margin-top: 24px;
        border-radius: 999px;
        overflow: hidden;
        background-color: #d3def0;
    }

    .zoo-barra-seg {
        flex: 0 1 0;
        min-width: 0;
    }

    .zoo-seg-verde   { background-color: var(--zoo-verde); }
    .zoo-seg-naranja { background-color: var(--zoo-naranja); }
    .zoo-seg-rojo    { background-color: var(--zoo-rojo); }

    /* ---------- Tabla ---------- */
    .zoo-detalle {
        margin-bottom: 0;
    }

    .zoo-tabla-scroll {
        overflow-x: auto;
    }

    .zoo-tabla {
        width: 100%;
        min-width: 760px;
        border-collapse: collapse;
    }

    .zoo-tabla thead th {
        text-align: left;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        color: var(--zoo-suave);
        border-bottom: 2px solid var(--zoo-tinta);
        white-space: nowrap;
    }

    .zoo-tabla tbody td {
        padding: 15px 16px;
        font-size: 14px;
        line-height: 1.4;
        border-bottom: 1px solid var(--zoo-linea);
        vertical-align: middle;
    }

    .zoo-tabla tbody tr {
        --zoo-riel: transparent;
    }

    .zoo-tabla tbody tr[data-estado="badge-verde"]   { --zoo-riel: var(--zoo-verde); }
    .zoo-tabla tbody tr[data-estado="badge-naranja"] { --zoo-riel: var(--zoo-naranja); }
    .zoo-tabla tbody tr[data-estado="badge-rojo"]    { --zoo-riel: var(--zoo-rojo); }
    .zoo-tabla tbody tr[data-estado="badge-azul"]    { --zoo-riel: var(--zoo-azul); }

    .zoo-tabla tbody td:first-child {
        box-shadow: inset 4px 0 0 var(--zoo-riel);
        padding-left: 20px;
    }

    .zoo-tabla tbody tr:hover {
        background-color: #f5f8fd;
    }

    .zoo-tabla tbody tr:last-child td {
        border-bottom: none;
    }

    .zoo-td-actividad {
        font-weight: 600;
        color: var(--zoo-tinta);
    }

    .zoo-td-fecha {
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }

    /* ---------- Estados (badge) ---------- */
    .zoo-wrap .badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 12px 5px 10px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .zoo-wrap .badge::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: currentColor;
    }

    .zoo-wrap .badge-verde   { background-color: #e1f2e7; color: #1e6b41; }
    .zoo-wrap .badge-naranja { background-color: #fbebcb; color: #8a5300; }
    .zoo-wrap .badge-rojo    { background-color: #f8dedb; color: #a32b22; }
    .zoo-wrap .badge-azul    { background-color: #ddebf8; color: #1d5a93; }

    /* ---------- Estado vacío ---------- */
    .zoo-vacio {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 44px 16px;
        color: var(--zoo-suave);
    }

    .zoo-vacio svg {
        margin-bottom: 12px;
        color: var(--zoo-primario);
    }

    .zoo-vacio p {
        margin: 0;
        max-width: 46ch;
        font-size: 15px;
        line-height: 1.5;
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 960px) {
        .zoo-campos {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .zoo-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            row-gap: 24px;
        }

        .zoo-stat:nth-child(odd) {
            padding-left: 0;
            border-left: none;
        }
    }

    @media (max-width: 720px) {
        .zoo-wrap {
            padding: 16px;
            border-radius: 16px;
        }

        .zoo-titulo {
            font-size: 23px;
        }

        .zoo-card {
            padding: 18px;
        }

        .zoo-stat-numero {
            font-size: 38px;
        }

        .zoo-tabla {
            min-width: 0;
        }

        .zoo-tabla thead {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0 0 0 0);
        }

        .zoo-tabla,
        .zoo-tabla tbody,
        .zoo-tabla tr {
            display: block;
        }

        .zoo-tabla tbody tr {
            border: 1px solid var(--zoo-linea);
            border-left: 5px solid var(--zoo-riel);
            border-radius: 14px;
            padding: 8px 0;
            margin-bottom: 12px;
        }

        .zoo-tabla tbody td {
            display: grid;
            grid-template-columns: 110px 1fr;
            gap: 12px;
            align-items: center;
            padding: 8px 14px;
            border-bottom: none;
        }

        .zoo-tabla tbody td:first-child {
            box-shadow: none;
            padding-left: 14px;
        }

        .zoo-tabla tbody td::before {
            content: attr(data-label);
            font-size: 13px;
            color: var(--zoo-suave);
        }
    }

    @media (max-width: 560px) {
        .zoo-campos {
            grid-template-columns: 1fr;
        }

        .zoo-acciones {
            flex-direction: column;
            align-items: stretch;
        }

        .zoo-btn-derecha {
            margin-left: 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .zoo-wrap * {
            transition: none !important;
        }
    }
</style>