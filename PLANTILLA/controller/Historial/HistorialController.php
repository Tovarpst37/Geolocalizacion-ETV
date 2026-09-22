<?php

include_once '../model/Historial/HistorialModel.php';

class HistorialController
{
    private const ID_ESTADO_PENDIENTE = 3;
    private const ID_ESTADO_EN_PROCESO = 4;
    private const ID_ESTADO_FINALIZADO = 5;

    private function seguimientoEnProceso($obj, $id_seguimiento_zoo)
    {
        $sql = "SELECT id_estado FROM seguimiento_zoocriadero WHERE id_seguimiento_zoo = $1";
        $res = $obj->select($sql, [$id_seguimiento_zoo]);

        if (empty($res)) {
            return false;
        }

        return in_array($res[0]['id_estado'], [
            self::ID_ESTADO_PENDIENTE,
            self::ID_ESTADO_EN_PROCESO
        ]);
    } // Ajusta este ID si en tu tabla 'estado' el estado "Finalizado" tiene otro número

    public function getConsultar()
    {
        $obj = new HistorialModel();

        $sql = "SELECT s.id_seguimiento_zoo, s.cod_seguimiento, s.fecha, u.documento, s.id_estado, e.nombre_estado
                FROM seguimiento_zoocriadero s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                LEFT JOIN estado e ON s.id_estado = e.id_estado
                ORDER BY s.id_seguimiento_zoo DESC";

        $seguimientos = $obj->select($sql);

        include_once '../view/partials/Historial/Consultar.php';
    }

    private function getConfigActividades()
    {
        return [
            'alimentacion' => [
                'nombre' => 'Alimentacion',
                'titulo' => 'Alimentación',
                'cod' => 'ALI',
                'pattern' => 'Alimentaci_n',
                'campos' => [
                    'genero' => 'texto',
                    'tipo_alimento' => 'texto',
                    'fecha_alimentacion' => 'fecha',
                    'obser_alimentacion' => 'texto',
                ],
            ],
            'peces' => [
                'nombre' => 'Peces muertos y nacidos',
                'titulo' => 'Peces muertos y nacidos',
                'cod' => 'PEC',
                'pattern' => 'Peces muertos y nacid%',
                'campos' => [
                    'can_peces_nacido' => 'entero',
                    'can_peces_mertos_macho' => 'entero',
                    'can_peces_mertos_hembra' => 'entero',
                    'obser_canpeces' => 'texto',
                ],
            ],
            'limpieza' => [
                'nombre' => 'Limpieza',
                'titulo' => 'Limpieza',
                'cod' => 'LIM',
                'pattern' => 'Limpieza',
                'campos' => [
                    'estregar_paredes' => 'bool',
                    'aspirar' => 'bool',
                    'succionador' => 'bool',
                    'fecha_limpieza' => 'fecha',
                    'obser_limpieza' => 'texto',
                ],
            ],
            'ajuste' => [
                'nombre' => 'Ajuste de nivel',
                'titulo' => 'Ajuste de nivel',
                'cod' => 'AJU',
                'pattern' => 'Ajuste%de nivel',
                'campos' => [
                    'adicion_nivel_agua' => 'decimal',
                    'medicion_ph' => 'decimal',
                    'medicion_temperatura' => 'decimal',
                    'fecha_ajuste' => 'fecha',
                    'obser_ajuste' => 'texto',
                ],
            ],
            'lavado' => [
                'nombre' => 'Lavado',
                'titulo' => 'Lavado',
                'cod' => 'LAV',
                'pattern' => 'Lavado',
                'campos' => [
                    'estado_tanque' => 'texto',
                    'agua_cambiada' => 'decimal',
                    'fecha_lavado' => 'fecha',
                    'obser_lavado' => 'texto',
                ],
            ],
        ];
    }

    // Consulta en la BD qué actividades están asignadas a este seguimiento
    private function getActividadesAsignadas($obj, $id_seguimiento_zoo)
    {
        $idSeg = (int) $id_seguimiento_zoo;
        $config = $this->getConfigActividades();
        $asignadas = [];

        $sql = "SELECT a.nombre_actividad
                FROM actividad_seg_zoo asz
                INNER JOIN actividad_zoocriadero a ON a.id_actividad_zoo = asz.id_actividad_zoo
                WHERE asz.id_seguimiento_zoo = $1";

        $rows = $obj->select($sql, [$idSeg]);
        if (!is_array($rows)) {
            $rows = [];
        }

        foreach ($config as $slug => $cfg) {
            $asignadas[$slug] = false;
            foreach ($rows as $r) {
                $nombreBD = $r['nombre_actividad'] ?? '';
                if ($this->normalizar($nombreBD) === $this->normalizar($cfg['nombre'])) {
                    $asignadas[$slug] = true;
                    break;
                }
            }
        }

        return $asignadas;
    }

    private function esc($v)
    {
        return str_replace("'", "''", (string) $v);
    }

    private function normalizar($s)
    {
        $s = strtr(trim((string) $s), [
            'Á' => 'a',
            'É' => 'e',
            'Í' => 'i',
            'Ó' => 'o',
            'Ú' => 'u',
            'Ñ' => 'n',
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ñ' => 'n',
        ]);
        return strtolower($s);
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

    private function getOrCreateActividadZoo($obj, $nombre, $codigoDefault)
    {
        $sqlBuscar = "SELECT id_actividad_zoo FROM actividad_zoocriadero WHERE nombre_actividad = '" . $this->esc($nombre) . "'";
        $res = $obj->select($sqlBuscar);

        if (!empty($res)) {
            return $res[0]['id_actividad_zoo'];
        }

        $sqlCrear = "INSERT INTO actividad_zoocriadero (cod_actividad, nombre_actividad, id_estado) 
                     VALUES ('" . $this->esc($codigoDefault) . "', '" . $this->esc($nombre) . "', 1) 
                     RETURNING id_actividad_zoo";
        $creado = $obj->select($sqlCrear);

        return !empty($creado) ? $creado[0]['id_actividad_zoo'] : null;
    }

    private function vincularSubActividad($obj, $idSub, $nombreActividad, $codDefault, $idSeguimiento)
    {
        $idSub = (int) $idSub;
        $idSeguimiento = (int) $idSeguimiento;
        $idAct = $this->getOrCreateActividadZoo($obj, $nombreActividad, $codDefault);

        if (!$idAct || !$idSub) {
            return;
        }
        $idAct = (int) $idAct;

        $existeSub = $obj->select("SELECT 1 FROM actividad_zoo_subactividades
                                   WHERE id_actividad_zoo = $idAct AND id_sub_actividades = $idSub");
        if (empty($existeSub)) {
            $obj->insert("INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades)
                          VALUES ($idAct, $idSub)");
        }

        $existeSeg = $obj->select("SELECT 1 FROM actividad_seg_zoo
                                   WHERE id_seguimiento_zoo = $idSeguimiento AND id_actividad_zoo = $idAct");
        if (empty($existeSeg)) {
            $obj->insert("INSERT INTO actividad_seg_zoo (id_seguimiento_zoo, id_actividad_zoo)
                          VALUES ($idSeguimiento, $idAct)");
        }
    }

    private function clasificarPorColumnas($r)
    {
        $lleno = function ($c) use ($r) {
            return isset($r[$c]) && trim((string) $r[$c]) !== '';
        };

        if ($lleno('obser_alimentacion') || $lleno('fecha_alimentacion') || $lleno('tipo_alimento') || $lleno('genero')) {
            return 'alimentacion';
        }
        if ($lleno('obser_canpeces')) {
            return 'peces';
        }
        if ($lleno('obser_limpieza') || $lleno('fecha_limpieza')) {
            return 'limpieza';
        }
        if ($lleno('obser_ajuste') || $lleno('fecha_ajuste')) {
            return 'ajuste';
        }
        if ($lleno('obser_lavado') || $lleno('fecha_lavado') || $lleno('estado_tanque')) {
            return 'lavado';
        }
        return null;
    }

    private function getSubActividadesPorTipo($obj, $idSeguimiento)
    {
        $id = (int) $idSeguimiento;
        $config = $this->getConfigActividades();

        $segRow = $obj->select("SELECT cod_seguimiento FROM seguimiento_zoocriadero WHERE id_seguimiento_zoo = $id");
        $cod = trim((string) ($segRow[0]['cod_seguimiento'] ?? ''));
        $condCod = $cod !== '' ? " OR sub.cod_seguimiento = '" . $this->esc($cod) . "'" : '';

        $sql = "SELECT sub.*, az.nombre_actividad AS tipo_catalogo
                FROM sub_actividades sub
                LEFT JOIN actividad_zoo_subactividades azs ON azs.id_sub_actividades = sub.id_sub_actividad
                LEFT JOIN actividad_zoocriadero az ON az.id_actividad_zoo = azs.id_actividad_zoo
                WHERE (sub.id_seguimiento_zoo = $id $condCod)
                ORDER BY sub.id_sub_actividad";
        $rows = $obj->select($sql);
        if (!is_array($rows)) {
            $rows = [];
        }

        $grupos = [];
        $mapa = [];
        foreach ($config as $slug => $c) {
            $grupos[$slug] = [];
            $mapa[$this->normalizar($c['nombre'])] = $slug;
        }

        $camposFecha = ['fecha_alimentacion', 'fecha_limpieza', 'fecha_ajuste', 'fecha_lavado'];
        $camposBool = ['estregar_paredes', 'aspirar', 'succionador'];
        $vistos = [];

        foreach ($rows as $r) {
            $idSub = $r['id_sub_actividad'];
            if (isset($vistos[$idSub])) {
                continue;
            }

            $slug = null;
            if (!empty($r['tipo_catalogo'])) {
                $slug = $mapa[$this->normalizar($r['tipo_catalogo'])] ?? null;
            }
            if ($slug === null) {
                $slug = $this->clasificarPorColumnas($r);
            }
            if ($slug === null) {
                continue;
            }
            $vistos[$idSub] = true;

            foreach ($camposFecha as $cf) {
                $ts = !empty($r[$cf]) ? strtotime($r[$cf]) : false;
                $r[$cf . '_input'] = $ts ? date('Y-m-d\TH:i', $ts) : '';
            }

            foreach ($camposBool as $cb) {
                $r[$cb] = in_array($r[$cb] ?? null, [true, 1, '1', 't', 'true'], true);
            }

            $grupos[$slug][] = $r;
        }

        return $grupos;
    }

    public function getEditar()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $obj = new HistorialModel();

        if (!$this->seguimientoEnProceso($obj, $id)) {
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError(
                ["Lo siento, el seguimiento debe estar Pendiente o En proceso para poder editarlo."],
                getUrl('Historial', 'Historial', 'getConsultar')
            );
            return;
        }

        $sqlSeg = "SELECT id_seguimiento_zoo, cod_seguimiento, fecha, id_estado
                   FROM seguimiento_zoocriadero
                   WHERE id_seguimiento_zoo = $id";
        $segResult = $obj->select($sqlSeg);
        $seguimiento = !empty($segResult) ? $segResult[0] : null;

        $config = $this->getConfigActividades();
        $grupos = $this->getSubActividadesPorTipo($obj, $id);

        // Obtenemos qué actividades están asignadas a este seguimiento
        $actividadesAsignadas = $this->getActividadesAsignadas($obj, $id);

        $sqlEstados = "SELECT id_estado, nombre_estado, tipo_estado FROM estado ORDER BY id_estado";
        $estados = $obj->select($sqlEstados);

        include_once '../model/FormularioZ/tipoPez.php';
        include_once '../model/FormularioZ/tipoAlimen.php';

        include_once '../view/partials/Historial/Editar.php';
    }



    private function actualizarRegistro($obj, $idSub, $idSeg, $cfg, $datos, $cod)
    {
        $sets = [];
        foreach ($cfg['campos'] as $col => $tipo) {
            $sets[] = $col . ' = ' . $this->valorSql($datos[$col] ?? '', $tipo);
        }
        $sets[] = 'id_seguimiento_zoo = ' . $idSeg;
        if ($cod !== '') {
            $sets[] = "cod_seguimiento = '" . $this->esc($cod) . "'";
        }

        $permite = "id_seguimiento_zoo = $idSeg OR id_seguimiento_zoo IS NULL";
        if ($cod !== '') {
            $permite .= " OR cod_seguimiento = '" . $this->esc($cod) . "'";
        }

        $sql = "UPDATE sub_actividades SET " . implode(', ', $sets) . "
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

        $cols = ['id_estado', 'id_seguimiento_zoo', 'cod_seguimiento'];
        $vals = [$idEstado, $idSeg, "'" . $this->esc($cod) . "'"];

        foreach ($cfg['campos'] as $col => $tipo) {
            $cols[] = $col;
            $vals[] = $this->valorSql($datos[$col] ?? '', $tipo);
        }

        $sql = "INSERT INTO sub_actividades (" . implode(', ', $cols) . ")
                VALUES (" . implode(', ', $vals) . ")
                RETURNING id_sub_actividad";
        $nuevo = $obj->select($sql);

        $this->vincularSubActividad($obj, $nuevo[0]['id_sub_actividad'] ?? null, $cfg['nombre'], $cfg['cod'], $idSeg);
    }

    // CORREGIDO: Consulta directamente la base de datos actualizada para garantizar
    // que todas las actividades asignadas tengan todos sus campos diligenciados.
    private function verificarYFinalizarSeguimiento($obj, $id_seguimiento_zoo)
    {
        $idSeg = (int) $id_seguimiento_zoo;
        $actividadesAsignadas = $this->getActividadesAsignadas($obj, $idSeg);
        $config = $this->getConfigActividades();
        $grupos = $this->getSubActividadesPorTipo($obj, $idSeg);

        $todasCompletas = true;
        $tieneAlMenosUnaAsignada = false;

        foreach ($actividadesAsignadas as $slug => $asignada) {
            if ($asignada) {
                $tieneAlMenosUnaAsignada = true;

                // 1. Debe haber al menos un registro para esta actividad asignada
                if (empty($grupos[$slug])) {
                    $todasCompletas = false;
                    break;
                }

                // 2. Verificar que los campos configurados contengan valores (no vacíos)
                $camposConfig = $config[$slug]['campos'];
                $actividadCompleta = false;

                foreach ($grupos[$slug] as $registro) {
                    $registroValido = true;
                    foreach ($camposConfig as $campo => $tipo) {
                        // Para booleanos (como en limpieza) se valida existencia;
                        // para texto, números, fechas y decimales se valida que no estén vacíos.
                        if ($tipo !== 'bool') {
                            $val = isset($registro[$campo]) ? trim((string) $registro[$campo]) : '';
                            if ($val === '') {
                                $registroValido = false;
                                break;
                            }
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
        }

        // Si tiene actividades asignadas y todas están completamente llenas, cambia el estado del seguimiento a Finalizado
        if ($tieneAlMenosUnaAsignada && $todasCompletas) {
            $sqlFinalizar = "UPDATE seguimiento_zoocriadero 
                             SET id_estado = " . self::ESTADO_SEGUIMIENTO_FINALIZADO . " 
                             WHERE id_seguimiento_zoo = $idSeg";
            $obj->update($sqlFinalizar);
        }
    }

    public function postUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new HistorialModel();
            $config = $this->getConfigActividades();

            $id_seguimiento_zoo = isset($_POST['id_seguimiento_zoo']) ? (int) $_POST['id_seguimiento_zoo'] : 0;
            $cod_seguimiento = trim((string) ($_POST['cod_seguimiento'] ?? ''));
            $fecha = $_POST['fecha'] ?? '';
            $id_estado = (int) ($_POST['id_estado'] ?? 0);

            if (!$id_seguimiento_zoo) {
                echo "Error: No se proporcionó el ID del seguimiento.";
                return;
            }

            // Consultar las actividades realmente asignadas al seguimiento
            $actividadesAsignadas = $this->getActividadesAsignadas($obj, $id_seguimiento_zoo);

            if ($cod_seguimiento === '') {
                $codActual = $obj->select("SELECT cod_seguimiento FROM seguimiento_zoocriadero WHERE id_seguimiento_zoo = $id_seguimiento_zoo");
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
            $obj->update("UPDATE seguimiento_zoocriadero SET " . implode(', ', $sets) . "
                          WHERE id_seguimiento_zoo = $id_seguimiento_zoo");

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

                    $this->actualizarRegistro($obj, $idSub, $id_seguimiento_zoo, $config[$slug], $datos, $cod_seguimiento);
                }
            }

            // 3. Insertar registros nuevos SOLO si la actividad está asignada al seguimiento
            $nuevos = $_POST['nuevos'] ?? [];
            if (is_array($nuevos)) {
                foreach ($config as $slug => $cfg) {
                    if (!empty($actividadesAsignadas[$slug]) && !empty($nuevos[$slug]) && is_array($nuevos[$slug])) {
                        $this->insertarRegistro($obj, $id_seguimiento_zoo, self::ESTADO_GENERAL_ACTIVO, $cfg, $nuevos[$slug], $cod_seguimiento);
                    }
                }
            }

            // 4. Verificar si todos los datos obligatorios/editables de las actividades asignadas están completos
            $this->verificarYFinalizarSeguimiento($obj, $id_seguimiento_zoo);

            $_SESSION['mensaje_exito'] = "El registro se actualizó correctamente.";
            redirect(getUrl("Historial", "Historial", "getConsultar"));
        }
    }


}
?>