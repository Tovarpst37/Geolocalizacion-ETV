<?php

include_once '../model/FormularioInsp/FormulariosModel.php';

class FormularioInspController
{
    // id_actividad_terreno de "Inspección" en actividad_terreno (AT-1)
    private const ID_ACTIVIDAD_INSPECCION = 1;

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

        include_once '../view/partials/FormularioInsp/registrar.php';
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

    // Verifica que el seguimiento de terreno tenga asignada la actividad "Inspección" (id fijo = 1),
    // sin importar cómo esté escrito el nombre en la tabla.
    private function seguimientoTieneInspeccion($obj, $id_seguimiento_terreno)
    {
        $sql = "SELECT 1
                FROM actividad_seg_terreno
                WHERE id_seguimiento_terreno = $1
                  AND id_actividad_terreno = $2
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_terreno, self::ID_ACTIVIDAD_INSPECCION]);

        return !empty($res);
    }

    // Verifica si ya existe un registro previo de Inspección en sub_actividades_ter para este seguimiento
    private function yaRegistroInspeccion($obj, $id_seguimiento_terreno, $codSeg)
    {
        $sql = "SELECT 1 
                FROM sub_actividades_ter 
                WHERE (id_seguimiento_terreno = $1 OR cod_seguimiento = $2)
                  AND (obser_inspeccion IS NOT NULL OR fecha_inspeccion IS NOT NULL OR ph_medido IS NOT NULL OR temperatura IS NOT NULL)
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_terreno, $codSeg]);

        return !empty($res);
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codSeg = $this->limpiarCodigo($_POST['codSeg'] ?? '');
            $documen = trim($_SESSION['documento'] ?? '');
            $fechaHora = $_POST['fecha_horaInsp'] ?? '';
            $depositoDetRaw = $_POST['depositoDetectado'] ?? '';
            $phMedido = $_POST['phMedido'] ?? '';
            $temperatura = $_POST['temperatura'] ?? '';
            $presenciaLarvasRaw = $_POST['presenciaLarvas'] ?? '';
            $obser = trim($_POST['obserInsp'] ?? '');
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

            // 2. Validar existencia, estado y actividad de Inspección del seguimiento
            $id_seguimiento_terreno = null;
            if (!empty($codSeg) && empty($invalidos)) {
                $sql_validar_seg = "SELECT id_seguimiento_terreno, id_estado FROM seguimiento_terreno WHERE cod_seguimiento = $1";
                $existeSeg = $obj->select($sql_validar_seg, [$codSeg]);

                if (empty($existeSeg)) {
                    $errores[] = "No existe ningún seguimiento registrado con ese código.";
                } elseif ($existeSeg[0]['id_estado'] != 4) {
                    $errores[] = "Lo siento, el seguimiento no está activo.";
                } else {
                    $id_seguimiento_terreno = $existeSeg[0]['id_seguimiento_terreno'];

                    // El seguimiento debe tener asignada la actividad de Inspección (por id)
                    if (!$this->seguimientoTieneInspeccion($obj, $id_seguimiento_terreno)) {
                        $errores[] = "Este seguimiento no tiene asignada la actividad de Inspección, por lo que no se puede registrar el formulario.";
                    }

                    // Validar que NO se haya registrado previamente este formulario para este código
                    if ($this->yaRegistroInspeccion($obj, $id_seguimiento_terreno, $codSeg)) {
                        $errores[] = "Ya existe un registro de inspección guardado para este código de seguimiento.";
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
                $errores[] = "La fecha y hora de inspección son obligatorias.";
            }

            if ($depositoDetRaw !== '0' && $depositoDetRaw !== '1') {
                $errores[] = "Debe indicar si se detectaron depósitos permanentes de agua.";
            }

            if ($phMedido === '' || !is_numeric($phMedido)) {
                $errores[] = "El PH medido es obligatorio y debe ser un número válido.";
            } elseif ($phMedido < 0 || $phMedido > 14) {
                $errores[] = "El PH medido debe estar entre 0 y 14.";
            }

            if ($temperatura === '' || !is_numeric($temperatura)) {
                $errores[] = "La temperatura medida es obligatoria y debe ser un número válido.";
            }

            if ($presenciaLarvasRaw !== '0' && $presenciaLarvasRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de larvas de zancudos.";
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
                ErrorModal::verError($errores, getUrl('FormularioInsp', 'FormularioInsp', 'getRegistrar'));
                return;
            }

            // 6. Todo válido: se procede a insertar
            $depositoDet = $depositoDetRaw === '1' ? 'true' : 'false';
            $presenciaLarv = $presenciaLarvasRaw === '1' ? 'true' : 'false';

            $sqlSub = "INSERT INTO sub_actividades_ter
               (fecha_inspeccion, deposito_agua_detectado, ph_medido, temperatura, 
                presencia_larvas_inspeccion, obser_inspeccion, 
                id_estado, id_seguimiento_terreno, cod_seguimiento) 
               VALUES 
               ($1, $2, $3, $4, 
                $5, $6, 
                1, $7, $8)
               RETURNING id_sub_actividad";

            $resSub = $obj->select($sqlSub, [
                $fechaHora,
                $depositoDet,
                $phMedido,
                $temperatura,
                $presenciaLarv,
                $obser,
                $id_seguimiento_terreno,
                $codSeg
            ]);

            if (!empty($resSub)) {
                $id_sub_actividad = $resSub[0]['id_sub_actividad'];

                // La actividad siempre es Ajustes de Nivel (id fijo = 4)
                $obj->insert(
                    "INSERT INTO actividad_ter_subactividades (id_actividad_terreno, id_sub_actividades) VALUES ($1, $2)",
                    [self::ID_ACTIVIDAD_INSPECCION, $id_sub_actividad]
                );
                 echo '<script>alert("¡Formulario registrado con exito!");</script>';
                redirect(getUrl("FormularioInsp", "FormularioInsp", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades_terreno.";
            }
        }
    }
}
?>