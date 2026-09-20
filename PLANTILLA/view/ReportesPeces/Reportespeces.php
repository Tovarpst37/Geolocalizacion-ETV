    <?php
    // AGREGADO: valores por defecto para que la vista no truene si se carga sin pasar por el controlador
    // (esto es un parche temporal — lo ideal es que el controlador SIEMPRE defina estas variables antes del include)
    $zoocriaderos = $zoocriaderos ?? [];
    $generar = $generar ?? false;
    $filtroZoocriadero = $filtroZoocriadero ?? '';
    $tanques = $tanques ?? [];
    $totalTanques = $totalTanques ?? 0;
    $encargado = $encargado ?? null;
    $mensajeVacio = $mensajeVacio ?? null;
    ?>
    <div class="caja">
        <h2 class="titulo-pagina">Reporte de Tanques según Zoocriadero</h2>
        <form method="GET">
            <!-- AGREGADO: sin estos campos, al enviar el formulario por GET se pierde la info de
                enrutamiento (modulo/controlador/funcion) y la página cae al index -->
            <input type="hidden" name="modulo" value="<?= $_GET['modulo'] ?? '' ?>">
            <input type="hidden" name="controlador" value="<?= $_GET['controlador'] ?? '' ?>">
            <input type="hidden" name="funcion" value="getReporteTanques">
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
                    <?php if ($generar && !empty($tanques)): ?>
                        <button type="button" class="btn-reportes"
                            onclick="location.href='<?= getUrl('ReportesTanquesZoocriadero', 'ReportesTanquesZoocriadero', 'exportarTanquesExcel') ?>&zoocriadero=<?= urlencode($filtroZoocriadero) ?>'">
                            Exportar a Excel
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <?php if ($generar && empty($mensajeVacio)): ?>
        <div class="caja tarjetas">
            <div class="tarjeta">
                <div class="icono icono-azul">🛢️</div>
                <div>
                    <p>Cantidad de tanques</p>
                    <span class="numero azul"><?= $totalTanques ?></span>
                </div>
            </div>
            <div class="tarjeta">
                <div class="icono icono-verde">👤</div>
                <div>
                    <p>Encargado del zoocriadero</p>
                    <span class="numero verde" style="font-size:16px;">
                        <?php
                        if ($encargado) {
                            echo trim($encargado['primer_nombre'] . ' ' . $encargado['segundo_nombre'] . ' ' . $encargado['primer_apellido'] . ' ' . $encargado['segundo_apellido']);
                        } else {
                            echo 'Sin asignar';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($generar): ?>
        <div class="caja">
            <h3>Tanques del zoocriadero</h3>

            <?php if (!empty($mensajeVacio)): ?>
                <p style="text-align:center; color:#888;"><?= $mensajeVacio ?></p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Código del tanque</th>
                            <th>Tipo de tanque</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tanques as $t): ?>
                            <tr>
                                <td><?= $t['codigo'] ?></td>
                                <td><?= $t['tipo_tanque'] ?></td>
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

        .icono-azul {
            background-color: #e5f0ff;
            color: #2f7dfa;
        }

        .icono-verde {
            background-color: #e3f9ec;
            color: #21a666;
        }

        .tarjeta p {
            margin: 0 0 4px 0;
            color: #666;
            font-size: 14px;
        }

        .numero {
            font-size: 26px;
            font-weight: bold;
        }

        .azul {
            color: #2f7dfa;
        }

        .verde {
            color: #21a666;
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