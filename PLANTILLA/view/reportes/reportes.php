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
    'fecha_inicio' => $filtroFechaInicio,
    'fecha_fin'    => $filtroFechaFin,
]);

$urlLimpiar = $urlReporte . (strpos($urlReporte, '?') === false ? '?' : '&') . 'limpiar=1';

?>

<div class="caja">

         
            <h2 class="titulo-pagina">Seguimiento de Actividades en los Zoocriaderos</h2>

        
            <h3>Filtros</h3>
            <form method="GET" action="<?= htmlspecialchars($partesUrl['path'] ?? '') ?>">
                <?php foreach ($paramsRuta as $nombre => $valor): ?>
                    <input type="hidden" name="<?= htmlspecialchars($nombre) ?>" value="<?= htmlspecialchars((string) $valor) ?>">
                <?php endforeach; ?>


        <div class="caja2">    
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
                                        <?= ($act['nombre_actividad'] ?? '') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label>Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" value="<?= ($filtroFechaInicio) ?>">
                        </div>
                        <div>
                            <label>Fecha Fin</label>
                            <input type="date" name="fecha_fin" value="<?= ($filtroFechaFin) ?>">
                        </div>
                        <div class="botones-filtros">
                            <button type="submit" class="btn-aplicar">Aplicar Filtros</button>
                            <button type="button" class="btn-limpiar"
                                    onclick="location.href='<?= $urlLimpiar ?>'">Limpiar Filtros</button>
                            <button type="button" class="btn-reportes"<?= empty($seguimientos) ? 'disabled' : '' ?>
                                    onclick="location.href='<?= $urlExcel ?>'">Generar Reportes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> 
        

<?php if ($mensajeError): ?>
    <div class="caja mensaje-error"><?= ($mensajeError) ?></div>
<?php endif; ?>

<div class="caja ">

    <div class="tarjetas">
            <div class="tarjeta tarjeta-azul">
                <div class="icono icono-azul">📋</div>
                <div>
                    <p>Actividades Totales</p>
                    <span class="numero azul"><?= $totalActividades ?></span>
                </div>
            </div>
            <div class="tarjeta tarjeta-verde">
                <div class="icono icono-verde">✔</div>
                <div>
                    <p>Actividades Completas</p>
                    <span class="numero verde"><?= $totalCompletas ?></span>
                </div>
            </div>
            <div class="tarjeta tarjeta-naranja">
                <div class="icono icono-naranja">⏱</div>
                <div>
                    <p>En Progreso</p>
                    <span class="numero naranja"><?= $totalEnProgreso ?></span>
                </div>
            </div>
            <div class="tarjeta tarjeta-rojo">
                <div class="icono icono-rojo">✖</div>
                <div>
                    <p>Retrasadas</p>
                    <span class="numero rojo"><?= $totalRetrasadas ?></span>
                </div>
            </div>
    </div>


    <h3>Detalles de Actividades</h3>
            
        <div class="tabla-scroll">
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
                            $retrasada = ($s['estado']== $pendiente || $s['estado'] ==$enProceso)
                            && $s['fecha_registro']< $hoy;

                            if($retrasada) {
                                $claseBadge = 'badge-rojo';
                                $textoEstado = 'Retrasada';

                            }elseif ($s['estado']== $finalizado) {
                                 $claseBadge = 'badge-verde';
                                $textoEstado = $s['estado']; 
                            }elseif($s['estado']== $pendiente){
                                 $claseBadge = 'badge-azul';
                                $textoEstado = $s['estado']; 
                            }else{
                                 $claseBadge = 'badge-naranja';
                                $textoEstado = $s['estado']; 
                            }






                            $fecha       = date('d/m/Y', strtotime($s['fecha_registro']));
                            $fechaInicio = $fecha . ($s['hora_inicio'] ? ' ' . substr($s['hora_inicio'], 0, 5) : '');
                            $fechaFin    = $s['hora_fin'] ? $fecha . ' ' . substr($s['hora_fin'], 0, 5) : '-';
                        ?>
                        <tr>
                            <td><?= $s['actividad'] ?? '' ?></td>
                            <td><?= $s['zoocriadero'] ?? ''?></td>
                            <td><?= $fechaInicio ?></td>
                            <td><?= $fechaFin ?></td>
                            <td><?= $s['responsable'] ?? ''?></td>
                            <td><span class="badge <?= $claseBadge ?>"><?= $textoEstado ?? '' ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>    
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
    .badge-retrasada { background-color: #b71c1c; }

    .badge-azul { background-color: #219aca; }

    .caja2 {
        background-color: #f8fafc;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: none;
    border: 2px solid #e2e8f0;
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

                 .botones-filtros{
         display: flex;
    flex-wrap: wrap;
    gap: 10px;
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
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        margin-bottom: 20px;
    }

    .tarjeta {
        flex: 1 1 150px;
        display: flex;
        align-items: flex-start;
        justify-content: flex-start;
        gap: 10px;
        padding: 14px 14px;
        border-radius: 10px;
    }

    .icono {
       
        font-size: 20px;
        flex-shrink: 0;
    }

   .tarjeta-azul    { background: linear-gradient(135deg, #2b5a8c, #4a86bd); }  /* Sitios Totales */
.tarjeta-verde   { background: linear-gradient(135deg, #2f7dfa, #5b9bff); }  /* Sin Larvas */
.tarjeta-naranja { background: linear-gradient(135deg, #5a7fa8, #86a5c7); }  /* Sin Registros */
.tarjeta-rojo    { background: linear-gradient(135deg, #1b3b5f, #2f6690); }  /* Con Larvas */

.tarjeta p,
.tarjeta .numero,
.tarjeta .icono {
    color: #ffffff;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);
}

    table { width: 100%; border-collapse: collapse; }

    .tabla-scroll{
        overflow-x: auto;
    }

    .tabla-scroll table{
        min-width: 720px;
    }

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