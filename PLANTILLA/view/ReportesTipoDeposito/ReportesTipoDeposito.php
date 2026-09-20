<?php
$tipoDeposito = $tipoDeposito ?? [];
$generar = $generar ?? false;
$filtroTipoDeposito = $filtroTipoDeposito ?? '';
$datosReporte = $datosReporte ?? [];
$mensajeVacio = $mensajeVacio ?? null;
?>
<div class="caja">
    <h2 class="titulo-pagina">Reporte de sitios por tipo de depósito</h2>

    <form method="GET">
        <input type="hidden" name="modulo" value="<?= $_GET['modulo'] ?? '' ?>">
        <input type="hidden" name="controlador" value="<?= $_GET['controlador'] ?? '' ?>">
        <input type="hidden" name="funcion" value="getReporteTipoDeposito">
        <input type="hidden" name="generar" value="1">

        <div class="filtro-moderno">
            <div class="selector-zoocriadero">
                <label>Tipo de Deposito <span class="text-danger">*</span></label>
                <div class="select-wrapper">
                    <span class="icono-select">🪣</span>
                    <select name="tipo_deposito" required>
                        <option value="" selected disabled>Selecciona un tipo de depósito</option>
                        <?php foreach ($tipoDeposito as $tipo): ?>
                            <option value="<?= $tipo['id_tipo_deposito'] ?>" <?= (($filtroTipoDeposito ?? '') == $tipo['id_tipo_deposito']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tipo['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="botones-accion">
                <button type="submit" class="btn-aplicar">Generar Reporte</button>
                <?php if ($generar && !empty($datosReporte)): ?>
                    <button type="button" class="btn-reportes"
                        onclick="location.href='<?= getUrl('ReportesTipoDeposito', 'ReportesTipoDeposito', 'exportarTipoDepositoExcel') ?>&tipo_deposito=<?= urlencode($filtroTipoDeposito) ?>'">
                        Exportar a Excel
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>


<?php if ($generar): ?>
    <div class="caja">
        <h3>Sitios por tipo de deposito</h3>

        <?php if (!empty($mensajeVacio)): ?>
            <p style="text-align:center; color:#888;"><?= $mensajeVacio ?></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID tipo de depósito</th>
                        <th>Tipo de depósito</th>
                        <th>Cantidad de sitios</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datosReporte as $dato): ?>
                        <tr>
                            <td><?= htmlspecialchars($dato['id_tipo_deposito']) ?></td>
                            <td><?= htmlspecialchars($dato['tipo_deposito']) ?></td>
                            <td><?= htmlspecialchars($dato['cantidad']) ?></td>
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
        margin-bottom: 28px;
        color: #1e293b;
    }

    .caja h3 {
        margin-top: 0;
        margin-bottom: 16px;
    }

    .filtro-moderno {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 24px;
        background: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .selector-zoocriadero {
        flex: 1;
        min-width: 260px;
    }

    .selector-zoocriadero label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #334155;
        font-size: 14px;
    }

    .select-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .icono-select {
        position: absolute;
        left: 14px;
        font-size: 18px;
        pointer-events: none;
        z-index: 1;
    }

    .select-wrapper select {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        background-color: #ffffff;
        font-size: 15px;
        color: #1e293b;
        appearance: none;
        cursor: pointer;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .select-wrapper select:focus {
        outline: none;
        border-color: #2f7dfa;
        box-shadow: 0 0 0 3px rgba(47, 125, 250, 0.15);
    }

    .botones-accion {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .text-danger {
        color: #e64545;
    }

    .btn-aplicar {
        background-color: #2f7dfa;
        color: #ffffff;
        border: none;
        padding: 12px 22px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: background-color 0.2s;
    }

    .btn-aplicar:hover {
        background-color: #1d6fe0;
    }

    .btn-reportes {
        background-color: #ffffff;
        color: #2f7dfa;
        border: 1.5px solid #2f7dfa;
        padding: 12px 22px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-reportes:hover {
        background-color: #eff6ff;
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