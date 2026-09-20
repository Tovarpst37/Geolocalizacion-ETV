<?php

$zoocriaderos = $zoocriaderos ?? [];
$generar = $generar ?? false;
$filtroZoocriadero = $filtroZoocriadero ?? '';
$datos = $datos ?? [];
$mensajeVacio = $mensajeVacio ?? null;
?>
<div class="caja">
    <h2 class="titulo-pagina">Reporte de Peces Nacidos y Muertos por Tanque</h2>
    <form method="GET">

        <input type="hidden" name="modulo" value="<?= $_GET['modulo'] ?? '' ?>">
        <input type="hidden" name="controlador" value="<?= $_GET['controlador'] ?? '' ?>">
        <input type="hidden" name="funcion" value="getReportePecesNacidosMuertos">
        <input type="hidden" name="generar" value="1">
        <div class="fila-filtros">
            <div>
                <label>Zoocriadero <span class="text-danger">*</span></label>
                <select name="zoocriadero" required>
                    <option value="" selected disabled>Selecciona un zoocriadero</option>
                    <?php foreach ($zoocriaderos as $zoo): ?>
                        <option value="<?= $zoo['id_zoocriadero'] ?>" <?= (($filtroZoocriadero ?? '') == $zoo['id_zoocriadero']) ? 'selected' : '' ?>>
                            <?= $zoo['cod_zoocriadero'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <button type="submit" class="btn-aplicar">Generar Reporte</button>
                <?php if ($generar && !empty($datos)): ?>
                    <button type="button" class="btn-reportes"
                        onclick="location.href='<?= getUrl('ReportePecesNacidosMuertos', 'ReportePecesNacidosMuertos', 'exportarPecesExcel') ?>&zoocriadero=<?= urlencode($filtroZoocriadero) ?>'">
                        Exportar a Excel
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<?php if ($generar): ?>
    <div class="caja">
        <h3>Peces nacidos y muertos por tanque</h3>

        <?php if (!empty($mensajeVacio)): ?>
            <p style="text-align:center; color:#888;"><?= $mensajeVacio ?></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Tanque</th>
                        <th>Tipo de tanque</th>
                        <th>Peces nacidos</th>
                        <th>Muertos (machos)</th>
                        <th>Muertos (hembras)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $d): ?>
                        <tr>
                            <td><?= $d['codigo'] ?></td>
                            <td><?= $d['tipo_tanque'] ?></td>
                            <td><?= $d['nacidos'] ?></td>
                            <td><?= $d['muertos_macho'] ?></td>
                            <td><?= $d['muertos_hembra'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php endif; ?>

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
        min-width: 220px;
    }

    .text-danger {
        color: #e64545;
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

    table {
        width: 100%;
        border-collapse: collapse;
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
</style>