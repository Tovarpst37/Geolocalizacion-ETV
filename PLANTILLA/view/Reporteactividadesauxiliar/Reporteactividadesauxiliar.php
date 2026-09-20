<?php

$auxiliares = $auxiliares ?? [];
$generar = $generar ?? false;
$filtroAuxiliar = $filtroAuxiliar ?? '';
$filtroFecha = $filtroFecha ?? '';
$actividades = $actividades ?? [];
$mensajeVacio = $mensajeVacio ?? null;
?>
<div class="caja">
    <h2 class="titulo-pagina">Reporte de Actividades por Auxiliar</h2>
    <form method="GET">

        <input type="hidden" name="modulo" value="<?= $_GET['modulo'] ?? '' ?>">
        <input type="hidden" name="controlador" value="<?= $_GET['controlador'] ?? '' ?>">
        <input type="hidden" name="funcion" value="getReporteActividadesAuxiliar">
        <input type="hidden" name="generar" value="1">
        <div class="fila-filtros">
            <div>
                <label>Auxiliar <span class="text-danger">*</span></label>
                <select name="auxiliar" required>
                    <option value="" selected disabled>Selecciona un auxiliar</option>
                    <?php foreach ($auxiliares as $aux): ?>
                        <option value="<?= $aux['id_usuario'] ?>" <?= (($filtroAuxiliar ?? '') == $aux['id_usuario']) ? 'selected' : '' ?>>
                            <?= trim($aux['primer_nombre'] . ' ' . $aux['segundo_nombre'] . ' ' . $aux['primer_apellido'] . ' ' . $aux['segundo_apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Fecha</label>
                <input type="date" name="fecha" value="<?= $filtroFecha ?>">
            </div>
            <div>
                <button type="submit" class="btn-aplicar">Generar Reporte</button>
                <?php if ($generar && !empty($actividades)): ?>
                    <button type="button" class="btn-reportes"
                        onclick="location.href='<?= getUrl('Reporteactividadesauxiliar', 'Reporteactividadesauxiliar', 'exportarActividadesExcel') ?>&auxiliar=<?= urlencode($filtroAuxiliar) ?>&fecha=<?= urlencode($filtroFecha) ?>'">
                        Exportar a Excel
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<?php if ($generar): ?>
    <div class="caja">
        <h3>Actividades del auxiliar</h3>

        <?php if (!empty($mensajeVacio)): ?>
            <p style="text-align:center; color:#888;"><?= $mensajeVacio ?></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Auxiliar</th>
                        <th>Tipo de actividad</th>
                        <th>Fecha</th>
                        <th>Comuna</th>
                        <th>Barrio</th>
                        <th>Sitio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($actividades as $a): ?>
                        <tr>
                            <td><?= $a['nombre_auxiliar'] ?></td>
                            <td><?= $a['tipo_actividad'] ?></td>
                            <td><?= $a['fecha'] ?></td>
                            <td><?= $a['comuna'] ?></td>
                            <td><?= $a['barrio'] ?></td>
                            <td><?= $a['sitio'] ?></td>
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

    .fila-filtros select,
    .fila-filtros input[type="date"] {
        padding: 8px 12px;
        border: 1px solid #d7dbe3;
        border-radius: 8px;
        min-width: 180px;
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