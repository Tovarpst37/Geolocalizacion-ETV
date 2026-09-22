<?php

include_once '../model/HistorialTerreno/FormulariosModel.php';

class HistorialTerrenoController
{
    const ESTADO_GENERAL_ACTIVO = 1;
    // Ajusta estos IDs si en tu tabla 'estado' los estados de seguimiento tienen otro número
    const ESTADO_SEGUIMIENTO_EN_PROCESO = 4;
    const ESTADO_SEGUIMIENTO_FINALIZADO = 5;

    public function getConsultar()
    {
        $obj = new FormulariosModel();

        $sql = "SELECT s.id_seguimiento_terreno, s.cod_seguimiento, s.fecha, u.documento, s.id_estado, si.nombre_sitio
                FROM seguimiento_terreno s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                LEFT JOIN sitio si ON s.id_sitio = si.id_sitio
                ORDER BY s.id_seguimiento_terreno DESC";

        $seguimientos = $obj->select($sql);

        include_once '../view/partials/HistorialTerreno/Consultar.php';
    }

    // Cada actividad se identifica por su id en actividad_terreno (no por el nombre).
    // Los campos de tipo 'bool' van primero para que la vista los muestre arriba.
    private function getConfigActividades()
    {
        return [
            'inspeccion' => [
                'id' => 1,
                'titulo' => 'Inspección',
                'campos' => [
                    'deposito_agua_detectado' => 'bool',
                    'presencia_larvas_inspeccion' => 'bool',
                    'temperatura' => 'decimal',
                    'ph_medido' => 'decimal',
                    'fecha_inspeccion' => 'fecha',
                    'obser_inspeccion' => 'texto',
                ],
            ],
            'siembra' => [
                'id' => 2,
                'titulo' => 'Siembra',
                'campos' => [
                    'presencia_larvas_siembra' => 'bool',
                    'presencia_peces_siembra' => 'bool',
                    'tiempo_aclimatacion' => 'entero',
                    'can_peces_empacados' => 'entero',
                    'litros_utilizados' => 'decimal',
                    'can_hembras_sembradas' => 'entero',
                    'can_machos_sembrados' => 'entero',
                    'can_peces_guppies_sembrados' => 'entero',
                    'fecha_siembra' => 'fecha',
                    'obser_siembra' => 'texto',
                ],
            ],
            'seguimiento' => [
                'id' => 3,
                'titulo' => 'Seguimiento',
                'campos' => [
                    'deposito_agua_visitado' => 'bool',
                    'presencia_larvas_seguimiento' => 'bool',
                    'presencia_peces_seguimiento' => 'bool',
                    'numero_visita' => 'entero',
                    'fecha_seguimiento' => 'fecha',
                    'obser_seguimiento' => 'texto',
                ],
            ],
            'resiembra' => [
                'id' => 4,
                'titulo' => 'Resiembra',
                'campos' => [
                    'presencia_larvas_resiembra' => 'bool',
                    'presencia_peces_resiembra' => 'bool',
                    'can_hembras_sembradas' => 'entero',
                    'can_machos_sembrados' => 'entero',
                    'can_peces_guppies_sembrados' => 'entero',
                    'fecha_resiembra' => 'fecha',
                    'obser_resiembra' => 'texto',
                ],
            ],
        ];
    }

    // Consulta en la BD qué actividades están asignadas a este seguimiento (por id)
    private function getActividadesAsignadas($obj, $id_seguimiento_terreno)
    {
        $idSeg = (int) $id_seguimiento_terreno;
        $config = $this->getConfigActividades();
        $asignadas = [];

        $rows = $obj->select("SELECT id_actividad_terreno FROM actividad_seg_terreno WHERE id_seguimiento_terreno = $1", [$idSeg]);
        if (!is_array($rows)) {
            $rows = [];
        }

        $ids = array_map('intval', array_column($rows, 'id_actividad_terreno'));

        foreach ($config as $slug => $cfg) {
            $asignadas[$slug] = in_array($cfg['id'], $ids, true);
        }

        return $asignadas;
    }

    private function esc($v)
    {
        return str_replace("'", "''", (string) $v);
    }

    private function fechaSql($valor)
    {
        $valor = trim((string) $valor);
        return $valor === '' ? 'NULL' : "'" . $this->esc($valor) . "'";
    }

    private function valorSql($valor, $tipo)
    {
        if (is_array($valor)) {
            $valor = '';
        }
        $valor = trim((string) $valor);

        switch ($tipo) {
            case 'bool':
                return in_array($valor, ['1', 'on', 't', 'true'], true) ? 'true' : 'false';
            case 'entero':
                return is_numeric($valor) ? (string) (int) $valor : '0';
            case 'decimal':
                return is_numeric($valor) ? $valor : '0';
            case 'fecha':
                return $this->fechaSql($valor);
            default:
                return "'" . $this->esc($valor) . "'";
        }
    }

    // Enlaza el registro con su actividad en la tabla puente (si aún no está enlazado)
    private function vincularSubActividad($obj, $idSub, $idActividad)
    {
        $idSub = (int) $idSub;
        $idAct = (int) $idActividad;

        if (!$idAct || !$idSub) {
            return;
        }

        $existe = $obj->select("SELECT 1 FROM actividad_ter_subactividades
                                WHERE id_actividad_terreno = $idAct AND id_sub_actividades = $idSub");
        if (empty($existe)) {
            $obj->insert("INSERT INTO actividad_ter_subactividades (id_actividad_terreno, id_sub_actividades)
                          VALUES ($idAct, $idSub)");
        }
    }

    // Si un registro no está enlazado en la tabla puente, se deduce por sus columnas propias
    private function clasificarPorColumnas($r)
    {
        $lleno = function ($c) use ($r) {
            return isset($r[$c]) && trim((string) $r[$c]) !== '';
        };

        if ($lleno('obser_inspeccion') || $lleno('fecha_inspeccion') || $lleno('ph_medido') || $lleno('temperatura')) {
            return 'inspeccion';
        }
        if ($lleno('obser_siembra') || $lleno('fecha_siembra') || $lleno('can_peces_empacados') || $lleno('tiempo_aclimatacion')) {
            return 'siembra';
        }
        if ($lleno('obser_seguimiento') || $lleno('fecha_seguimiento') || $lleno('numero_visita')) {
            return 'seguimiento';
        }
        if ($lleno('obser_resiembra') || $lleno('fecha_resiembra')) {
            return 'resiembra';
        }
        return null;
    }

    // Agrupa los registros de sub_actividades_ter del seguimiento por tipo de actividad
    private function getSubActividadesPorTipo($obj, $idSeguimiento)
    {
        $id = (int) $idSeguimiento;
        $config = $this->getConfigActividades();

        $segRow = $obj->select("SELECT cod_seguimiento FROM seguimiento_terreno WHERE id_seguimiento_terreno = $id");
        $cod = trim((string) ($segRow[0]['cod_seguimiento'] ?? ''));
        $condCod = $cod !== '' ? " OR sub.cod_seguimiento = '" . $this->esc($cod) . "'" : '';

        $sql = "SELECT sub.*, ats.id_actividad_terreno AS tipo_catalogo_id
                FROM sub_actividades_ter sub
                LEFT JOIN actividad_ter_subactividades ats ON ats.id_sub_actividades = sub.id_sub_actividad
                WHERE (sub.id_seguimiento_terreno = $id $condCod)
                ORDER BY sub.id_sub_actividad";
        $rows = $obj->select($sql);
        if (!is_array($rows)) {
            $rows = [];
        }

        $grupos = [];
        $mapaId = [];
        foreach ($config as $slug => $c) {
            $grupos[$slug] = [];
            $mapaId[(int) $c['id']] = $slug;
        }

        $vistos = [];

        foreach ($rows as $r) {
            $idSub = $r['id_sub_actividad'];
            if (isset($vistos[$idSub])) {
                continue;
            }

            $slug = null;
            if (!empty($r['tipo_catalogo_id'])) {
                $slug = $mapaId[(int) $r['tipo_catalogo_id']] ?? null;
            }
            if ($slug === null) {
                $slug = $this->clasificarPorColumnas($r);
            }
            if ($slug === null) {
                continue;
            }
            $vistos[$idSub] = true;

            // Formato que necesitan los inputs datetime-local y los checkboxes
            foreach ($config[$slug]['campos'] as $col => $tipo) {
                if ($tipo === 'fecha') {
                    $ts = !empty($r[$col]) ? strtotime($r[$col]) : false;
                    $r[$col . '_input'] = $ts ? date('Y-m-d\TH:i', $ts) : '';
                } elseif ($tipo === 'bool') {
                    $r[$col] = in_array($r[$col] ?? null, [true, 1, '1', 't', 'true'], true);
                }
            }

            $grupos[$slug][] = $r;
        }

        return $grupos;
    }

    public function getEditar()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $obj = new FormulariosModel();

        if (!$this->seguimientoEnProceso($obj, $id)) {
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError(
                ["Lo siento, el seguimiento no está en proceso, por lo que no se puede editar."],
                getUrl('HistorialTerreno', 'HistorialTerreno', 'getConsultar')
            );
            return;
        }

        $sqlSeg = "SELECT id_seguimiento_terreno, cod_seguimiento, fecha, id_estado
                   FROM seguimiento_terreno
                   WHERE id_seguimiento_terreno = $id";
        $segResult = $obj->select($sqlSeg);
        $seguimiento = !empty($segResult) ? $segResult[0] : null;

        $config = $this->getConfigActividades();
        $grupos = $this->getSubActividadesPorTipo($obj, $id);

        // Actividades asignadas a este seguimiento
        $actividadesAsignadas = $this->getActividadesAsignadas($obj, $id);

        $sqlEstados = "SELECT id_estado, nombre_estado, tipo_estado FROM estado ORDER BY id_estado";
        $estados = $obj->select($sqlEstados);

        include_once '../view/partials/HistorialTerreno/Editar.php';
    }

    private function seguimientoEnProceso($obj, $id_seguimiento_terreno)
    {
        $sql = "SELECT 1 FROM seguimiento_terreno
                WHERE id_seguimiento_terreno = $1 AND id_estado = $2";
        $res = $obj->select($sql, [$id_seguimiento_terreno, self::ESTADO_SEGUIMIENTO_EN_PROCESO]);

        return !empty($res);
    }

    private function actualizarRegistro($obj, $idSub, $idSeg, $cfg, $datos, $cod)
    {
        $sets = [];
        foreach ($cfg['campos'] as $col => $tipo) {
            $sets[] = $col . ' = ' . $this->valorSql($datos[$col] ?? '', $tipo);
        }
        $sets[] = 'id_seguimiento_terreno = ' . $idSeg;
        if ($cod !== '') {
            $sets[] = "cod_seguimiento = '" . $this->esc($cod) . "'";
        }

        $permite = "id_seguimiento_terreno = $idSeg OR id_seguimiento_terreno IS NULL";
        if ($cod !== '') {
            $permite .= " OR cod_seguimiento = '" . $this->esc($cod) . "'";
        }

        $sql = "UPDATE sub_actividades_ter SET " . implode(', ', $sets) . "
                WHERE id_sub_actividad = $idSub AND ($permite)";
        $obj->update($sql);
    }

    private function tieneDatos($cfg, $datos)
    {
        foreach ($cfg['campos'] as $col => $tipo) {
            $v = $datos[$col] ?? '';
            if (is_array($v)) {
                continue;
            }
            if ($tipo === 'bool') {
                if (!empty($v)) {
                    return true;
                }
            } elseif (trim((string) $v) !== '') {
                return true;
            }
        }
        return false;
    }

    private function insertarRegistro($obj, $idSeg, $idEstado, $cfg, $datos, $cod)
    {
        if (!$this->tieneDatos($cfg, $datos)) {
            return;
        }

        $cols = ['id_estado', 'id_seguimiento_terreno', 'cod_seguimiento'];
        $vals = [$idEstado, $idSeg, "'" . $this->esc($cod) . "'"];

        foreach ($cfg['campos'] as $col => $tipo) {
            $cols[] = $col;
            $vals[] = $this->valorSql($datos[$col] ?? '', $tipo);
        }

        $sql = "INSERT INTO sub_actividades_ter (" . implode(', ', $cols) . ")
                VALUES (" . implode(', ', $vals) . ")
                RETURNING id_sub_actividad";
        $nuevo = $obj->select($sql);

        $this->vincularSubActividad($obj, $nuevo[0]['id_sub_actividad'] ?? null, $cfg['id']);
    }

    // Consulta la BD ya actualizada: si todas las actividades asignadas tienen al menos
    // un registro con todos sus campos diligenciados, el seguimiento pasa a Finalizado.
    private function verificarYFinalizarSeguimiento($obj, $id_seguimiento_terreno)
    {
        $idSeg = (int) $id_seguimiento_terreno;
        $actividadesAsignadas = $this->getActividadesAsignadas($obj, $idSeg);
        $config = $this->getConfigActividades();
        $grupos = $this->getSubActividadesPorTipo($obj, $idSeg);

        $todasCompletas = true;
        $tieneAlMenosUnaAsignada = false;

        foreach ($actividadesAsignadas as $slug => $asignada) {
            if (!$asignada) {
                continue;
            }
            $tieneAlMenosUnaAsignada = true;

            // 1. Debe haber al menos un registro para esta actividad asignada
            if (empty($grupos[$slug])) {
                $todasCompletas = false;
                break;
            }

            // 2. Algún registro debe tener todos los campos (excepto los booleanos) con valor
            $actividadCompleta = false;

            foreach ($grupos[$slug] as $registro) {
                $registroValido = true;
                foreach ($config[$slug]['campos'] as $campo => $tipo) {
                    if ($tipo === 'bool') {
                        continue;
                    }
                    $val = isset($registro[$campo]) ? trim((string) $registro[$campo]) : '';
                    if ($val === '') {
                        $registroValido = false;
                        break;
                    }
                }

                if ($registroValido) {
                    $actividadCompleta = true;
                    break;
                }
            }

            if (!$actividadCompleta) {
                $todasCompletas = false;
                break;
            }
        }

        if ($tieneAlMenosUnaAsignada && $todasCompletas) {
            $obj->update("UPDATE seguimiento_terreno
                          SET id_estado = " . self::ESTADO_SEGUIMIENTO_FINALIZADO . "
                          WHERE id_seguimiento_terreno = $idSeg");
        }
    }
    public function getVer()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $obj = new FormulariosModel();

        $sqlSeg = "SELECT s.id_seguimiento_terreno, s.cod_seguimiento, s.fecha, s.id_estado,
                      e.nombre_estado, u.documento, si.nombre_sitio
               FROM seguimiento_terreno s
               LEFT JOIN estado e ON s.id_estado = e.id_estado
               LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
               LEFT JOIN sitio si ON s.id_sitio = si.id_sitio
               WHERE s.id_seguimiento_terreno = $id";
        $segResult = $obj->select($sqlSeg);
        $seguimiento = !empty($segResult) ? $segResult[0] : null;

        if (!$seguimiento) {
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError(
                ["Lo siento, el seguimiento solicitado no existe."],
                getUrl('HistorialTerreno', 'HistorialTerreno', 'getConsultar')
            );
            return;
        }

        $config = $this->getConfigActividades();
        $grupos = $this->getSubActividadesPorTipo($obj, $id);
        $actividadesAsignadas = $this->getActividadesAsignadas($obj, $id);

        include_once '../view/partials/HistorialTerreno/Ver.php';
    }

    public function postUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();
            $config = $this->getConfigActividades();

            $id_seguimiento_terreno = isset($_POST['id_seguimiento_terreno']) ? (int) $_POST['id_seguimiento_terreno'] : 0;
            $cod_seguimiento = trim((string) ($_POST['cod_seguimiento'] ?? ''));
            $fecha = $_POST['fecha'] ?? '';
            $id_estado = (int) ($_POST['id_estado'] ?? 0);

            if (!$id_seguimiento_terreno) {
                echo "Error: No se proporcionó el ID del seguimiento.";
                return;
            }

            // Actividades realmente asignadas al seguimiento
            $actividadesAsignadas = $this->getActividadesAsignadas($obj, $id_seguimiento_terreno);

            if ($cod_seguimiento === '') {
                $codActual = $obj->select("SELECT cod_seguimiento FROM seguimiento_terreno WHERE id_seguimiento_terreno = $id_seguimiento_terreno");
                $cod_seguimiento = trim((string) ($codActual[0]['cod_seguimiento'] ?? ''));
            }

            // 1. Datos generales del seguimiento
            $sets = ['fecha = ' . $this->fechaSql($fecha)];

            if ($id_estado > 0) {
                $estadoValido = $obj->select("SELECT 1 FROM estado WHERE id_estado = $id_estado AND tipo_estado = 'seguimiento'");
                if (!empty($estadoValido)) {
                    $sets[] = 'id_estado = ' . $id_estado;
                }
            }
            if ($cod_seguimiento !== '') {
                $sets[] = "cod_seguimiento = '" . $this->esc($cod_seguimiento) . "'";
            }
            $obj->update("UPDATE seguimiento_terreno SET " . implode(', ', $sets) . "
                          WHERE id_seguimiento_terreno = $id_seguimiento_terreno");

            // 2. Actualizar registros existentes SOLO si la actividad está asignada al seguimiento
            $registros = $_POST['registros'] ?? [];
            if (is_array($registros)) {
                foreach ($registros as $idSub => $datos) {
                    $idSub = (int) $idSub;
                    $slug = is_array($datos) ? ($datos['__tipo'] ?? '') : '';

                    if (!$idSub || !isset($config[$slug])) {
                        continue;
                    }

                    // Si la actividad NO está asignada a este seguimiento, se omiten sus cambios
                    if (empty($actividadesAsignadas[$slug])) {
                        continue;
                    }

                    $this->actualizarRegistro($obj, $idSub, $id_seguimiento_terreno, $config[$slug], $datos, $cod_seguimiento);
                }
            }

            // 3. Insertar registros nuevos SOLO si la actividad está asignada al seguimiento
            $nuevos = $_POST['nuevos'] ?? [];
            if (is_array($nuevos)) {
                foreach ($config as $slug => $cfg) {
                    if (!empty($actividadesAsignadas[$slug]) && !empty($nuevos[$slug]) && is_array($nuevos[$slug])) {
                        $this->insertarRegistro($obj, $id_seguimiento_terreno, self::ESTADO_GENERAL_ACTIVO, $cfg, $nuevos[$slug], $cod_seguimiento);
                    }
                }
            }

            // 4. Si todas las actividades asignadas están completas, se finaliza el seguimiento
            $this->verificarYFinalizarSeguimiento($obj, $id_seguimiento_terreno);

            $_SESSION['mensaje_exito'] = "El registro se actualizó correctamente.";
            redirect(getUrl("HistorialTerreno", "HistorialTerreno", "getConsultar"));
        }
    }
}
?>