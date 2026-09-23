<?php
// Ubicación: view/ReporteSitios/ReporteSitios.php

$h = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

// al enviar el formulario por GET no se pierdan los parametros que usa index.php
$urlReporte = getUrl('ReporteSitios', 'ReporteSitios', 'getReporteSitios');
$partesUrl  = parse_url($urlReporte);
parse_str($partesUrl['query'] ?? '', $paramsRuta);

// URL del Excel con los mismos filtros que tiene la pantalla
$urlExcel = getUrl('ReporteSitios', 'ReporteSitios', 'exportarSitiosExcel');
$urlExcel .= (strpos($urlExcel, '?') === false ? '?' : '&') . http_build_query([
    'comuna'        => $filtroComuna,
    'barrio'        => $filtroBarrio,
    'tipo_deposito' => $filtroDeposito,
    'hallazgo'      => $filtroHallazgo,
]);

$urlLimpiar = $urlReporte . (strpos($urlReporte, '?') === false ? '?' : '&') . 'limpiar=1';

$opcionesHallazgo = [
    'todas'       => 'Todas las etapas',
    'inspeccion'  => 'Inspección',
    'siembra'     => 'Siembra',
    'seguimiento' => 'Seguimiento',
    'resiembra'   => 'Resiembra',
];

?>

<div class="caja">
    <h2 class="titulo-pagina">Reporte de Sitios Registrados</h2>
    <h3>Filtros</h3>
    <form method="GET" action="<?= $h($partesUrl['path'] ?? '') ?>">
        <?php foreach ($paramsRuta as $nombre => $valor): ?>
            <input type="hidden" name="<?= $h($nombre) ?>" value="<?= $h($valor) ?>">
        <?php endforeach; ?>


    
    <div class="caja2">
                <div class="fila-filtros">
                    <div>
                        <label>Comuna</label>
                        <select name="comuna">
                            <option value="">Todas</option>
                            <?php foreach ($comunas as $c): ?>
                                <option value="<?= (int) $c['id_comuna'] ?>"
                                    <?= (string) $filtroComuna === (string) $c['id_comuna'] ? 'selected' : '' ?>>
                                    <?= $h($c['nombre_comuna']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Barrio</label>
                        <select name="barrio">
                            <option value="">Todos</option>
                            <?php foreach ($barrios as $b): ?>
                                <option value="<?= (int) $b['id_barrio'] ?>"
                                        data-comuna="<?= (int) $b['id_comuna'] ?>"
                                    <?= (string) $filtroBarrio === (string) $b['id_barrio'] ? 'selected' : '' ?>>
                                    <?= $h($b['nombre_barrio']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Tipo de Depósito</label>
                        <select name="tipo_deposito">
                            <option value="">Todos</option>
                            <?php foreach ($tiposDeposito as $t): ?>
                                <option value="<?= (int) $t['id_tipo_deposito'] ?>"
                                    <?= (string) $filtroDeposito === (string) $t['id_tipo_deposito'] ? 'selected' : '' ?>>
                                    <?= $h($t['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Hallazgo de Larvas</label>
                        <select name="hallazgo">
                            <option value="">Todos</option>
                            <?php foreach ($opcionesHallazgo as $valor => $texto): ?>
                                <option value="<?= $valor ?>" <?= $filtroHallazgo === $valor ? 'selected' : '' ?>>
                                    <?= $texto ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="botones-filtros">
                        <button type="submit" class="btn-aplicar">Aplicar Filtros</button>
                        <button type="button" class="btn-limpiar"
                                onclick="location.href='<?= $urlLimpiar ?>'">Limpiar Filtros</button>
                        <button type="button" class="btn-reportes" <?= empty($sitios) ? 'disabled' : '' ?>
                                onclick="location.href='<?= $urlExcel ?>'">Generar Reportes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


<?php if ($mensajeError): ?>
    <div class="caja mensaje-error"><?= $h($mensajeError) ?></div>
<?php endif; ?>

<div class="caja ">


        <div class="tarjetas">
            <div class="tarjeta tarjeta-azul">
                <div class="icono icono-azul">📍</div>
                <div>
                    <p>Sitios Totales</p>
                    <span class="numero azul"><?= (int) $totalSitios ?></span>
                </div>
            </div>
            <div class="tarjeta tarjeta-indigo">
                <div class="icono ">💧</div>
                <div>
                    <p>Deposito</p>
                    <span class="numero"><?= (int) $totalDepositos ?></span>
                </div>
            </div>
            <div class="tarjeta tarjeta-verde">
                <div class="icono icono-verde">✔</div>
                <div>
                    <p>Sin Larvas</p>
                    <span class="numero verde"><?= (int) $totalSinLarvas ?></span>
                </div>
            </div>
            <div class="tarjeta tarjeta-naranja">
                <div class="icono icono-naranja">✖️</div>
                <div>
                    <p>Sin Registros</p>
                    <span class="numero naranja"><?= (int) $totalSinRegistros ?></span>
                </div>
            </div>
            <div class="tarjeta tarjeta-rojo">
                <div class="icono icono-rojo">🦟</div>
                <div>
                    <p>Con Larvas</p>
                    <span class="numero rojo"><?= (int) $totalConLarvas ?></span>
                </div>
            </div>
        </div>    


    <h3>Detalles de Sitios</h3>

        <div class="tabla-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Sitio</th>
                        <th>Dirección</th>
                        <th>Barrio</th>
                        <th>Comuna</th>
                        <th>Tipo de Depósito</th>
                        <th>Hallazgo de Larvas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sitios as $f): ?>
                        <?php
                            // Color del badge según el hallazgo
                            if ((int) $f['num_registros'] === 0) {
                                $claseBadge = 'badge-gris';
                                $textoBadge = 'Sin registros';
                            } elseif ((int) $f['con_larvas'] === 1) {
                                $claseBadge = 'badge-rojo';
                                $textoBadge = 'Con larvas';
                            } else {
                                $claseBadge = 'badge-verde';
                                $textoBadge = 'Sin larvas';
                            }
                        ?>
                        <tr>
                            <td><?= $h($f['nombre_sitio'] ?? '') ?></td>
                            <td><?= $h($f['direccion'] ?? '') ?></td>
                            <td><?= $h($f['nombre_barrio'] ?? '') ?></td>
                            <td><?= $h($f['nombre_comuna'] ?? '') ?></td>
                            <td><?= $h($f['tipo_deposito'] ?? 'Sin depósito') ?></td>
                            <td><span class="badge <?= $claseBadge ?>"><?= $textoBadge ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>    
</div>

<script>
// El select de barrio solo muestra los barrios de la comuna elegida
const selComuna = document.querySelector('select[name="comuna"]');
const selBarrio = document.querySelector('select[name="barrio"]');

function filtrarBarrios() {
    const c = selComuna.value;
    selBarrio.querySelectorAll('option[data-comuna]').forEach(o => {
        const visible = c === '' || o.dataset.comuna === c;
        o.hidden = !visible;
        o.disabled = !visible;
        if (!visible && o.selected) selBarrio.value = '';
    });
}
selComuna.addEventListener('change', filtrarBarrios);
filtrarBarrios();
</script>

<style>



    .tarjeta-indigo{
      background: linear-gradient(135deg, #3f5f9e, #6f8fd0);  
    }                    

    .caja {
        background-color: #ffffff;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.34);
        font-family: Arial, Helvetica, sans-serif;
    }

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

    .fila-filtros select {
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
       
    }

    .btn-limpiar {
        background-color: #eef1f8;
        color: #555555;
        border: 1px solid #d7dbe3;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        
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
.tarjeta-naranja { background: linear-gradient(135deg, #5AA86A, #86a5c7); }  /* Sin Registros */
.tarjeta-rojo    { background: linear-gradient(135deg, #5E5F1B, #BEDD38); }  /* Con Larvas */

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
        white-space: nowrap;
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

    .badge-verde { background-color: #2ecc71; }
    .badge-rojo  { background-color: #e74c3c; }
    .badge-gris  { background-color: #95a5a6; }
</style>