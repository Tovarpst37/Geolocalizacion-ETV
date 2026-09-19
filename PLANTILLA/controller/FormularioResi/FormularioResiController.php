<?php

include_once '../model/FormularioResi/FormulariosModel.php';

class FormularioResiController
{
    public function getRegistrar()
    {
        $obj = new FormulariosModel();

        $sql = "SELECT * FROM seguimiento_terreno";
        $seguimientos = $obj->select($sql);

        $sql1 = "SELECT * FROM usuarios";
        $numDocumen = $obj->select($sql1);

        $sql4 = "SELECT * FROM sub_actividades_ter";
        $observaciones = $obj->select($sql4);

        // Documento del usuario que inició sesión, para mostrarlo fijo (no editable) en el formulario
        $documentoSesion = $_SESSION['documento'] ?? '';

        include_once '../view/partials/FormularioResi/registrar.php';
    }

    // Quita espacios invisibles (copiar/pegar) y espacios al inicio y al final
    private function limpiarCodigo($codigo)
    {
        $codigo = preg_replace('/[\x{00A0}\x{2007}\x{202F}]/u', ' ', (string) $codigo);
        $codigo = preg_replace('/[\x{200B}\x{200C}\x{200D}\x{FEFF}]/u', '', $codigo);
        return trim($codigo);
    }

    // Devuelve la lista de caracteres no permitidos en el código
    private function caracteresInvalidos($codigo)
    {
        preg_match_all('/[^\p{L}\p{N}\-_ .\/#]/u', $codigo, $m);
        return array_values(array_unique($m[0]));
    }

    // CORREGIDO: usa ILIKE para encontrar "Resiembra" sin importar mayúsculas
    // y así no crear una actividad duplicada
    private function getOrCreateActividadTerreno($obj, $nombre, $codigoDefault)
    {
        $sqlBuscar = "SELECT id_actividad_terreno FROM actividad_terreno WHERE nombre_actividad ILIKE $1";
        $res = $obj->select($sqlBuscar, [$nombre]);

        if (!empty($res)) {
            return $res[0]['id_actividad_terreno'];
        }

        $sqlCrear = "INSERT INTO actividad_terreno (nombre_actividad, id_estado, cod_actividad_terreno) 
                     VALUES ($1, 1, $2) 
                     RETURNING id_actividad_terreno";
        $creado = $obj->select($sqlCrear, [$nombre, $codigoDefault]);

        return !empty($creado) ? $creado[0]['id_actividad_terreno'] : null;
    }

    // NUEVO: verifica que el seguimiento de terreno tenga asignada la actividad "Resiembra"
    // (existe una fila en actividad_seg_terreno que lo relaciona con esa actividad)
    // AJUSTA: nombre de la tabla de relación y sus columnas si en tu BD son distintos
    private function seguimientoTieneResiembra($obj, $id_seguimiento_terreno)
    {
        $sql = "SELECT 1
                FROM actividad_seg_terreno ast
                INNER JOIN actividad_terreno a
                    ON a.id_actividad_terreno = ast.id_actividad_terreno
                WHERE ast.id_seguimiento_terreno = $1
                  AND a.nombre_actividad ILIKE 'Resiembra'
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_terreno]);

        return !empty($res);
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codSeg = $this->limpiarCodigo($_POST['codSeg'] ?? '');
            $documen = trim($_SESSION['documento'] ?? '');
            $fechaHora = $_POST['fecha_horaResi'] ?? '';
            $canHembras = $_POST['canHembras'] ?? '';
            $canMachos = $_POST['canMachos'] ?? '';
            $canGuppies = $_POST['canGuppies'] ?? '';
            $presenciaLarvasRaw = $_POST['presenciaLarvas'] ?? '';
            $presenciaPecesRaw = $_POST['presenciaPeces'] ?? '';
            $obser = trim($_POST['obserResi'] ?? '');
            $obser = strip_tags($obser);

            $errores = [];

            // 1. Validar código ingresado
            if (empty($codSeg)) {
                $errores[] = "El código de seguimiento es obligatorio.";
            }

            $invalidos = !empty($codSeg) ? $this->caracteresInvalidos($codSeg) : [];
            if (!empty($invalidos)) {
                $errores[] = "El código contiene caracteres no permitidos: "
                    . htmlspecialchars(implode(' ', $invalidos))
                    . ". Solo se permiten letras, números, guiones, puntos, barras y espacios.";
            }

            // 2. Validar existencia, estado y actividad de Resiembra del seguimiento
            $id_seguimiento_terreno = null;
            if (!empty($codSeg) && empty($invalidos)) {
                $sql_validar_seg = "SELECT id_seguimiento_terreno, id_estado FROM seguimiento_terreno WHERE cod_seguimiento = $1";
                $existeSeg = $obj->select($sql_validar_seg, [$codSeg]);

                if (empty($existeSeg)) {
                    $errores[] = "No existe ningún seguimiento registrado con ese código.";
                } elseif ($existeSeg[0]['id_estado'] != 1) {
                    $errores[] = "Lo siento, el seguimiento no está activo.";
                } else {
                    $id_seguimiento_terreno = $existeSeg[0]['id_seguimiento_terreno'];

                    // NUEVO: el seguimiento debe tener asignada la actividad de Resiembra
                    if (!$this->seguimientoTieneResiembra($obj, $id_seguimiento_terreno)) {
                        $errores[] = "Este seguimiento no tiene asignada la actividad de Resiembra, por lo que no se puede registrar el formulario.";
                    }
                }
            }

            // 3. Validar Documento de usuario
            if (empty($documen)) {
                $errores[] = "El número de documento es obligatorio.";
            } else {
                $sql_validar_user = "SELECT id_usuario FROM usuarios WHERE documento = $1";
                $existeUser = $obj->select($sql_validar_user, [$documen]);

                if (empty($existeUser)) {
                    $errores[] = "No existe ningún usuario con ese número de documento.";
                }
            }

            // 4. Validar campos del formulario
            if (empty($fechaHora)) {
                $errores[] = "La fecha y hora de resiembra son obligatorias.";
            }

            if ($canHembras === '' || !is_numeric($canHembras) || $canHembras < 0) {
                $errores[] = "La cantidad de hembras sembradas es obligatoria y debe ser un número válido.";
            }

            if ($canMachos === '' || !is_numeric($canMachos) || $canMachos < 0) {
                $errores[] = "La cantidad de machos sembrados es obligatoria y debe ser un número válido.";
            }

            if ($canGuppies === '' || !is_numeric($canGuppies) || $canGuppies < 0) {
                $errores[] = "La cantidad de peces guppies sembrados es obligatoria y debe ser un número válido.";
            }

            if ($presenciaLarvasRaw !== '0' && $presenciaLarvasRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de larvas de zancudos.";
            }

            if ($presenciaPecesRaw !== '0' && $presenciaPecesRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de peces.";
            }

            if (empty($obser)) {
                $errores[] = "Las observaciones son obligatorias.";
            }
            if (strlen($obser) > 250) {
                $errores[] = "Las observaciones no pueden superar los 250 caracteres.";
            }

            // 5. Manejo de errores: corta ejecución sin insertar nada
            if (!empty($errores)) {
                include_once '../model/Errores/ErrorModal.php';
                ErrorModal::verError($errores, getUrl('FormularioResi', 'FormularioResi', 'getRegistrar'));
                return;
            }

            // 6. Todo válido: se procede a insertar
            $presenciaLarv = $presenciaLarvasRaw === '1' ? 'true' : 'false';
            $presenciaPec = $presenciaPecesRaw === '1' ? 'true' : 'false';

            $sqlSub = "INSERT INTO sub_actividades_ter
               (fecha_resiembra, can_hembras_sembradas, can_machos_sembrados, can_peces_guppies_sembrados,
                presencia_larvas_resiembra, presencia_peces_resiembra, obser_resiembra, 
                id_estado, id_seguimiento_terreno, cod_seguimiento) 
               VALUES 
               ($1, $2, $3, $4,
                $5, $6, $7, 
                1, $8, $9)
               RETURNING id_sub_actividad";

            $resSub = $obj->select($sqlSub, [
                $fechaHora,
                $canHembras,
                $canMachos,
                $canGuppies,
                $presenciaLarv,
                $presenciaPec,
                $obser,
                $id_seguimiento_terreno,
                $codSeg
            ]);

            if (!empty($resSub)) {
                $id_sub_actividad = $resSub[0]['id_sub_actividad'];

                $id_actividad_terreno = $this->getOrCreateActividadTerreno($obj, 'Resiembra', 'AT-4');

                if ($id_actividad_terreno) {
                    $sqlBridge = "INSERT INTO actividad_ter_subactividades 
                                  (id_actividad_terreno, id_sub_actividades) 
                                  VALUES ($1, $2)";
                    $obj->select($sqlBridge, [$id_actividad_terreno, $id_sub_actividad]);
                }

                redirect(getUrl("FormularioResi", "FormularioResi", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades_ter.";
            }
        }
    }
}
?>