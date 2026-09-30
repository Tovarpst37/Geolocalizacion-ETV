<?php
$usuarios = $usuarios ?? [];
$modulosDisponibles = $modulosDisponibles ?? [];
$registros = $registros ?? [];
$filtroUsuario = $filtroUsuario ?? '';
$filtroModulo = $filtroModulo ?? '';
$filtroFecha = $filtroFecha ?? '';
?>
<div class="caja">
    <h2 class="titulo-pagina">Auditoría del Sistema</h2>
    <form action="<?php echo getUrl("Auditoria","Auditoria","getConsultar") ?>" method="POST">
        <input type="hidden" name="modulo" value="<?= $_GET['modulo'] ?? '' ?>">
        <input type="hidden" name="controlador" value="<?= $_GET['controlador'] ?? '' ?>">
        <input type="hidden" name="funcion" value="getConsultar">
        <div class="fila-filtros">
            <div class="campo-filtro">
                <label>Usuario</label>
                <div class="container-input">
                    <ion-icon name="person-circle-outline"></ion-icon>
                        <input
                            type="text"
                            onpaste = "false return"
                            inputmode="numeric"
                            name="usuario"
                            id = "documento"
                            placeholder="Numero de identificacion"
                            class = "campoInput">
                        </div>
            </div>
            <div class="campo-filtro">
                <label>Módulo</label>
                <select name="modulo_filtro">
                    <option value="">Todos</option>
                    <?php foreach ($modulosDisponibles as $m): ?>
                        <option value="<?= $m['modulo'] ?>" <?= ($filtroModulo == $m['modulo']) ? 'selected' : '' ?>>
                            <?= $m['modulo'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo-filtro">
                <label>Fecha</label>
                <input type="date" name="fecha" value="<?= $filtroFecha ?>">
            </div>
            <div class="campo-filtro campo-botones">
                <button type="submit" class="btn-aplicar">Filtrar</button>

                <?php if (!empty($registros)): ?>
                    <button type="button" class="btn-reportes" onclick="exportarExcel()">
                        Exportar a Excel
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<div class="caja">
    <h3>Registros</h3>
    <?php if (empty($registros)): ?>
        <p style="text-align:center; color:#888;">No hay registros de auditoría con los filtros seleccionados.</p>
    <?php else: ?>
        <div class="tabla-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Fecha y hora</th>
                        <th>Usuario</th>
                        <th>Módulo</th>
                        <th>Acción</th>
                        <th>Tabla afectada</th>
                        <th>ID registro</th>
                        <th>Descripción</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $r): ?>
                        <tr>
                            <td data-label="Fecha y hora"><?= $r['fecha_hora'] ?></td>
                            <td data-label="Usuario"><?= $r['nombre_usuario'] ?: 'Desconocido' ?></td>
                            <td data-label="Módulo"><?= $r['modulo'] ?></td>
                            <td data-label="Acción"><?= $r['accion'] ?></td>
                            <td data-label="Tabla afectada"><?= $r['tabla_afectada'] ?></td>
                            <td data-label="ID registro"><?= $r['id_registro'] ?? '—' ?></td>
                            <td data-label="Descripción"><?= $r['descripcion'] ?></td>
                            <td data-label="Resultado"><?= $r['resultado'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<script>
function exportarExcel() {
    const form = document.querySelector('form');
    const accionOriginal = form.action;
    form.action = "<?php echo getUrl('Auditoria', 'Auditoria', 'exportarAuditoriaExcel') ?>";
    form.target = '_blank'; // así no pierdes la tabla filtrada al descargar
    form.submit();
    form.action = accionOriginal;
    form.target = '';
}
</script>
<script src = "../web/js/expre/numeros.js"></script>
<script src = "../web/js/document.js"></script>

<style>
    * {
        box-sizing: border-box;
    }

    .caja {
        background-color: #ffffff;
        color: #1f2430;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        font-family: Arial, Helvetica, sans-serif;
        max-width: 100%;
        overflow: hidden;
    }

    .titulo-pagina {
        text-align: center;
        font-size: 22px;
        margin-top: 0;
        margin-bottom: 24px;
        color: #1f2430;
    }

    .caja h3 {
        margin-top: 0;
        margin-bottom: 16px;
        color: #1f2430;
    }

    .fila-filtros {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 16px;
    }

    .campo-filtro {
        flex: 1 1 180px;
        min-width: 0;
    }

    .campo-filtro label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        font-size: 14px;
        color: #1f2430;
    }
    .campoInput{
        padding: 8px 12px;
        border: 1px solid #d7dbe3;
        border-radius: 8px;
        font-size: 14px;
        background-color: #ffffff;
        color: #1f2430;
    }
    .fila-filtros select,
    .fila-filtros input[type="date"] {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d7dbe3;
        border-radius: 8px;
        min-width: 0;
        font-size: 14px;
        background-color: #ffffff;
        color: #1f2430;
    }

    .campo-botones {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        flex: 1 1 auto;
    }

    .btn-aplicar {
        background-color: #2f7dfa;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        white-space: nowrap;
    }

    .btn-reportes {
        background-color: #ffffff;
        color: #2f7dfa;
        border: 1px solid #2f7dfa;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        white-space: nowrap;
    }

    /* Contenedor con scroll horizontal: evita que la tabla desborde la página */
    .tabla-scroll {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        min-width: 720px;
        border-collapse: collapse;
        font-size: 14px;
    }

    th {
        text-align: left;
        padding: 10px;
        color: #555;
        border-bottom: 2px solid #eef1f8;
        white-space: nowrap;
        background-color: #ffffff;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #eef1f8;
        word-break: break-word;
        overflow-wrap: break-word;
        vertical-align: top;
        color: #1f2430;
        background-color: #ffffff;
    }

    /* Tablets: filtros en 2 columnas */
    @media (max-width: 768px) {
        .caja {
            padding: 18px;
        }

        .campo-filtro {
            flex: 1 1 45%;
        }

        .campo-botones {
            flex: 1 1 100%;
            justify-content: flex-start;
        }
    }

    /* Móvil: filtros apilados y tabla en formato tarjeta */
    @media (max-width: 560px) {
        .titulo-pagina {
            font-size: 18px;
        }

        .campo-filtro {
            flex: 1 1 100%;
        }

        .btn-aplicar,
        .btn-reportes {
            flex: 1 1 auto;
            text-align: center;
        }

        .tabla-scroll {
            overflow-x: visible;
        }

        table {
            min-width: 0;
        }

        thead {
            display: none;
        }

        table,
        tbody,
        tr,
        td {
            display: block;
            width: 100%;
        }

        tr {
            border: 1px solid #eef1f8;
            border-radius: 10px;
            margin-bottom: 12px;
            padding: 8px 12px;
        }

        td {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #f5f6fa;
            padding: 8px 0;
            text-align: right;
        }

        td:last-child {
            border-bottom: none;
        }

        td::before {
            content: attr(data-label);
            font-weight: bold;
            color: #555;
            text-align: left;
            flex-shrink: 0;
        }
    }
</style>