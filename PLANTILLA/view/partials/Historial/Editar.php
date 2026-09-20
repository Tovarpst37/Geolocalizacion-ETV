<?php
// Escapa valores para usarlos dentro de atributos HTML
$h = function ($v) {
    return htmlspecialchars((string) ($v ?? ''), ENT_QUOTES, 'UTF-8');
};

// La columna "fecha" puede venir como timestamp; el input type="date" necesita Y-m-d
$fechaGeneral = (!empty($seguimiento['fecha'])) ? date('Y-m-d', strtotime($seguimiento['fecha'])) : '';

// Etiqueta, tipo de input y ancho de columna de cada campo de sub_actividades
$ui = [
    'genero' => ['Tipo de pez', 'select_pez', 'col-md-6'],
    'tipo_alimento' => ['Tipo de alimentación', 'select_alimen', 'col-md-6'],
    'fecha_alimentacion' => ['Fecha y hora de alimentación', 'datetime', 'col-md-6'],
    'obser_alimentacion' => ['Observaciones', 'text', 'col-md-6'],

    'can_peces_nacido' => ['Peces nacidos', 'int', 'col-md-4'],
    'can_peces_mertos_macho' => ['Machos muertos', 'int', 'col-md-4'],
    'can_peces_mertos_hembra' => ['Hembras muertas', 'int', 'col-md-4'],
    'obser_canpeces' => ['Observaciones', 'text', 'col-md-12'],

    'estregar_paredes' => ['Estregar paredes', 'check', 'col-md-4'],
    'aspirar' => ['Aspirar', 'check', 'col-md-4'],
    'succionador' => ['Succionador', 'check', 'col-md-4'],
    'fecha_limpieza' => ['Fecha y hora de limpieza', 'datetime', 'col-md-6'],
    'obser_limpieza' => ['Observaciones', 'text', 'col-md-6'],

    'adicion_nivel_agua' => ['Nivel de agua adicionado', 'decimal', 'col-md-4'],
    'medicion_ph' => ['PH medido', 'decimal', 'col-md-4'],
    'medicion_temperatura' => ['Temperatura', 'decimal', 'col-md-4'],
    'fecha_ajuste' => ['Fecha y hora de ajuste', 'datetime', 'col-md-6'],
    'obser_ajuste' => ['Observaciones', 'text', 'col-md-6'],

    'estado_tanque' => ['Estado del tanque', 'text', 'col-md-6'],
    'agua_cambiada' => ['Porcentaje de agua cambiada', 'decimal', 'col-md-6'],
    'fecha_lavado' => ['Fecha y hora de lavado', 'datetime', 'col-md-6'],
    'obser_lavado' => ['Observaciones', 'text', 'col-md-6'],
];

// Dibuja un campo. $disabled se activa cuando la actividad NO está asignada al seguimiento.
$renderCampo = function ($col, $registro, $name, $disabled = false) use ($ui, $h) {
    $label = $ui[$col][0];
    $kind = $ui[$col][1];
    $ancho = $ui[$col][2];
    $valor = $registro[$col] ?? '';
    $idInput = 'f_' . preg_replace('/[^A-Za-z0-9_]/', '_', $name);
    $disAttr = $disabled ? ' disabled' : '';

    if ($kind === 'check') {
        echo '<div class="' . $ancho . ' mb-2"><div class="form-check">';
        echo '<input class="form-check-input" type="checkbox" value="1" id="' . $idInput . '" name="' . $h($name) . '"' . (!empty($valor) ? ' checked' : '') . $disAttr . '>';
        echo '<label class="form-check-label" for="' . $idInput . '">' . $label . '</label>';
        echo '</div></div>';
        return;
    }

    echo '<div class="' . $ancho . ' mb-3">';
    echo '<label class="form-label" for="' . $idInput . '">' . $label . '</label>';

    switch ($kind) {
        case 'select_pez':
            echo '<select class="form-select" id="' . $idInput . '" name="' . $h($name) . '"' . $disAttr . '><option value="">-- No aplica --</option>';
            foreach (tipoPez as $tp) {
                echo '<option value="' . $h($tp) . '"' . ($valor == $tp ? ' selected' : '') . '>' . $h($tp) . '</option>';
            }
            echo '</select>';
            break;

        case 'select_alimen':
            echo '<select class="form-select" id="' . $idInput . '" name="' . $h($name) . '"' . $disAttr . '><option value="">-- No aplica --</option>';
            foreach (tipoAlimen as $tA) {
                echo '<option value="' . $h($tA) . '"' . ($valor == $tA ? ' selected' : '') . '>' . $h($tA) . '</option>';
            }
            echo '</select>';
            break;

        case 'datetime':
            $v = $registro[$col . '_input'] ?? '';
            echo '<input type="datetime-local" class="form-control" id="' . $idInput . '" name="' . $h($name) . '" value="' . $h($v) . '"' . $disAttr . '>';
            break;

        case 'int':
            echo '<input type="number" min="0" class="form-control" id="' . $idInput . '" name="' . $h($name) . '" value="' . $h($valor) . '"' . $disAttr . '>';
            break;

        case 'decimal':
            echo '<input type="number" step="any" class="form-control" id="' . $idInput . '" name="' . $h($name) . '" value="' . $h($valor) . '"' . $disAttr . '>';
            break;

        default:
            echo '<input type="text" class="form-control" id="' . $idInput . '" name="' . $h($name) . '" value="' . $h($valor) . '"' . $disAttr . '>';
    }

    echo '</div>';
};
?>
<div class="modal show" tabindex="-1" style="display:block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <?php if (!$seguimiento): ?>
                <div class="modal-body">
                    <div class="alert alert-danger">No se encontró el seguimiento solicitado.</div>
                </div>
            <?php else: ?>
                <form action="<?php echo getUrl('Historial', 'Historial', 'postUpdate'); ?>" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Historial - Código:
                            <?php echo $h($seguimiento['cod_seguimiento']); ?></h5>
                        <a href="<?php echo getUrl('Historial', 'Historial', 'getConsultar') ?>" class="btn-close"></a>
                    </div>

                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                        <input type="hidden" name="id_seguimiento_zoo"
                            value="<?php echo $h($seguimiento['id_seguimiento_zoo']); ?>">

                        <!-- Datos generales -->
                        <h6 class="text-primary">Datos generales</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Código del Seguimiento</label>
                                <input type="text" class="form-control" name="cod_seguimiento"
                                    value="<?php echo $h($seguimiento['cod_seguimiento']); ?>" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Fecha</label>
                                <input type="date" class="form-control" name="fecha"
                                    value="<?php echo $h($fechaGeneral); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" name="id_estado" required>
                                    <?php
                                    $estadoActualValido = false;
                                    foreach ($estados as $est) {
                                        if (($est['tipo_estado'] ?? '') === 'seguimiento' && $seguimiento['id_estado'] == $est['id_estado']) {
                                            $estadoActualValido = true;
                                        }
                                    }
                                    if (!$estadoActualValido) {
                                        echo '<option value="" selected disabled>-- Seleccione el estado --</option>';
                                    }
                                    foreach ($estados as $est) {
                                        if (($est['tipo_estado'] ?? '') !== 'seguimiento') {
                                            continue;
                                        }
                                        $selected = ($seguimiento['id_estado'] == $est['id_estado']) ? "selected" : "";
                                        echo "<option value='" . $h($est['id_estado']) . "' $selected>" . $h($est['nombre_estado']) . "</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <?php foreach ($config as $slug => $cfgAct):
                            $registros = $grupos[$slug] ?? [];
                            // Comprobar si la actividad está asignada a este seguimiento
                            $estaAsignada = !empty($actividadesAsignadas[$slug]);
                            ?>
                            <h6 class="text-primary d-flex align-items-center justify-content-between">
                                <span>
                                    <?php echo $h($cfgAct['titulo']); ?>
                                    <span class="badge bg-secondary"><?php echo count($registros); ?></span>
                                </span>
                                <?php if (!$estaAsignada): ?>
                                    <span class="badge bg-danger">Actividad No Asignada</span>
                                <?php endif; ?>
                            </h6>

                            <?php foreach ($registros as $i => $r):
                                $idSub = $r['id_sub_actividad'];
                                ?>
                                <div class="border rounded p-3 mb-3 <?php echo !$estaAsignada ? 'bg-light' : ''; ?>">
                                    <div class="small text-muted mb-2">Registro <?php echo $i + 1; ?> (ID <?php echo $h($idSub); ?>)
                                        <?php if (!$estaAsignada): ?>
                                            <strong class="text-danger">(No editable)</strong>
                                        <?php endif; ?>
                                    </div>
                                    <input type="hidden" name="registros[<?php echo $h($idSub); ?>][__tipo]"
                                        value="<?php echo $h($slug); ?>">
                                    <div class="row">
                                        <?php foreach ($cfgAct['campos'] as $col => $tipoDato) {
                                            // Se deshabilita la edición si la actividad NO está asignada al seguimiento
                                            $renderCampo($col, $r, "registros[$idSub][$col]", !$estaAsignada);
                                        } ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if (empty($registros)): ?>
                                <p class="text-muted small">Este seguimiento aún no tiene registros de
                                    <?php echo $h($cfgAct['titulo']); ?>.</p>
                            <?php endif; ?>

                            <!-- Solo permite agregar nuevos registros si la actividad pertenece al seguimiento -->
                            <?php if ($estaAsignada): ?>
                                <details class="mb-3" <?php echo empty($registros) ? 'open' : ''; ?>>
                                    <summary class="text-primary" style="cursor:pointer;">+ Agregar registro de
                                        <?php echo $h($cfgAct['titulo']); ?></summary>
                                    <div class="border rounded p-3 mt-2">
                                        <div class="row">
                                            <?php foreach ($cfgAct['campos'] as $col => $tipoDato) {
                                                $renderCampo($col, null, "nuevos[$slug][$col]", false);
                                            } ?>
                                        </div>
                                        <div class="small text-muted">Si lo dejas vacío no se guarda nada.</div>
                                    </div>
                                </details>
                            <?php else: ?>
                                <div class="alert alert-warning small py-1 px-2 mb-3">
                                    <i class="fa-solid fa-lock"></i> No puedes agregar registros a esta sección porque la actividad
                                    no está asignada a este seguimiento.
                                </div>
                            <?php endif; ?>

                            <hr>
                        <?php endforeach; ?>

                    </div>

                    <div class="modal-footer">
                        <a href="<?php echo getUrl('Historial', 'Historial', 'getConsultar') ?>"
                            class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>