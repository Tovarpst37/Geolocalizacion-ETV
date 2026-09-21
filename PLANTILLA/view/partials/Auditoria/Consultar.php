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
    <form method="GET">
        <input type="hidden" name="modulo" value="<?= $_GET['modulo'] ?? '' ?>">
        <input type="hidden" name="controlador" value="<?= $_GET['controlador'] ?? '' ?>">
        <input type="hidden" name="funcion" value="getConsultar">
        <div class="fila-filtros">
            <div>
                <label>Usuario</label>
                <select name="usuario">
                    <option value="">Todos</option>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?= $u['id_usuario'] ?>" <?= ($filtroUsuario == $u['id_usuario']) ? 'selected' : '' ?>>
                            <?= $u['primer_nombre'] . ' ' . $u['primer_apellido'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
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
            <div>
                <label>Fecha</label>
                <input type="date" name="fecha" value="<?= $filtroFecha ?>">
            </div>
            <div>
                <button type="submit" class="btn-aplicar">Filtrar</button>
                <?php if (!empty($registros)): ?>
                    <button type="button" class="btn-reportes"
                        onclick="location.href='<?= getUrl('Auditoria', 'Auditoria', 'getConsultar') ?>&usuario=<?= urlencode($filtroUsuario) ?>&modulo_filtro=<?= urlencode($filtroModulo) ?>&fecha=<?= urlencode($filtroFecha) ?>'">
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
                        <td><?= $r['fecha_hora'] ?></td>
                        <td><?= $r['nombre_usuario'] ?: 'Desconocido' ?></td>
                        <td><?= $r['modulo'] ?></td>
                        <td><?= $r['accion'] ?></td>
                        <td><?= $r['tabla_afectada'] ?></td>
                        <td><?= $r['id_registro'] ?? '—' ?></td>
                        <td><?= $r['descripcion'] ?></td>
                        <td><?= $r['resultado'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
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

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    th {
        text-align: left;
        padding: 10px;
        color: #555;
        border-bottom: 2px solid #eef1f8;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #eef1f8;
    }
</style>