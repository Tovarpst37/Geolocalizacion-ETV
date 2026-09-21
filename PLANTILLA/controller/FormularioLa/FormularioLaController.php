<?php

include_once '../model/FormularioLa/FormulariosModel.php';

class FormularioLaController
{
    // id_actividad_zoo de "Lavado" en actividad_zoocriadero (AZ-5)
    private const ID_ACTIVIDAD_LAVADO = 5;

    public function getRegistrar()
    {
        $obj = new FormulariosModel();

        $sql = "SELECT * FROM seguimiento_zoocriadero";
        $seguimientos = $obj->select($sql);

        $sql1 = "SELECT * FROM usuarios";
        $numDocumen = $obj->select($sql1);

        $sql4 = "SELECT * FROM sub_actividades";
        $observaciones = $obj->select($sql4);

        // Documento del usuario que inició sesión, para mostrarlo fijo (no editable) en el formulario
        $documentoSesion = $_SESSION['documento'] ?? '';

        include_once '../view/partials/FormularioLa/registrar.php';
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

    // Verifica que el seguimiento tenga asignada la actividad "Lavado" (id fijo = 5),
    // sin importar cómo esté escrito el nombre en la tabla.
    private function seguimientoTieneLavado($obj, $id_seguimiento_zoo)
    {
        $sql = "SELECT 1
                FROM actividad_seg_zoo
                WHERE id_seguimiento_zoo = $1
                  AND id_actividad_zoo = $2
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_zoo, self::ID_ACTIVIDAD_LAVADO]);

        return !empty($res);
    }

    // Verifica si ya existe un registro previo de Lavado en sub_actividades para este seguimiento
    private function yaRegistroLavado($obj, $id_seguimiento_zoo, $codM)
    {
        $sql = "SELECT 1 
                FROM sub_actividades 
                WHERE (id_seguimiento_zoo = $1 OR cod_seguimiento = $2)
                  AND (obser_lavado IS NOT NULL OR fecha_lavado IS NOT NULL OR estado_tanque IS NOT NULL OR agua_cambiada IS NOT NULL)
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_zoo, $codM]);

        return !empty($res);
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codM = $this->limpiarCodigo($_POST['codLa'] ?? '');
            $docM = trim($_SESSION['documento'] ?? '');
            $fechaHora = $_POST['fecha_horaLa'] ?? '';
            $porcAgua = $_POST['porcAgua'] ?? '';
            $estadoTanque = trim($_POST['estadoTanque'] ?? '');
            $obser = trim($_POST['obLa'] ?? '');
            $obser = strip_tags($obser);

            $errores = [];

            // 1. Validar código ingresado
            if (empty($codM)) {
                $errores[] = "El código de seguimiento es obligatorio.";
            }

            $invalidos = !empty($codM) ? $this->caracteresInvalidos($codM) : [];
            if (!empty($invalidos)) {
                $errores[] = "El código contiene caracteres no permitidos: "
                    . htmlspecialchars(implode(' ', $invalidos))
                    . ". Solo se permiten letras, números, guiones, puntos, barras y espacios.";
            }

            // 2. Validar existencia, estado y actividad de Lavado del seguimiento
            $id_seguimiento_zoo = null;
            if (!empty($codM) && empty($invalidos)) {
                $sql_validar_seg = "SELECT id_seguimiento_zoo, id_estado FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1";
                $existeSeg = $obj->select($sql_validar_seg, [$codM]);

                if (empty($existeSeg)) {
                    $errores[] = "No existe ningún seguimiento registrado con ese código.";
                } elseif ($existeSeg[0]['id_estado'] != 4) {
                    $errores[] = "Lo siento, el seguimiento no está activo.";
                } else {
                    $id_seguimiento_zoo = $existeSeg[0]['id_seguimiento_zoo'];

                    // El seguimiento debe tener asignada la actividad de Lavado (por id)
                    if (!$this->seguimientoTieneLavado($obj, $id_seguimiento_zoo)) {
                        $errores[] = "Este seguimiento no tiene asignada la actividad de Lavado, por lo que no se puede registrar el formulario.";
                    }

                    // Validar que NO se haya registrado previamente este formulario para este código
                    if ($this->yaRegistroLavado($obj, $id_seguimiento_zoo, $codM)) {
                        $errores[] = "Ya existe un registro de lavado guardado para este código de seguimiento.";
                    }
                }
            }

            // 3. Validar documento de usuario
            if (empty($docM)) {
                $errores[] = "El número de documento es obligatorio.";
            } else {
                $sql_validar_user = "SELECT id_usuario FROM usuarios WHERE documento = $1";
                $existeUser = $obj->select($sql_validar_user, [$docM]);

                if (empty($existeUser)) {
                    $errores[] = "No existe ningún usuario con ese número de documento.";
                }
            }

            // 4. Validar campos del formulario
            if (empty($fechaHora)) {
                $errores[] = "La fecha y hora de lavado son obligatorias.";
            }

            if ($porcAgua === '' || !is_numeric($porcAgua)) {
                $errores[] = "El porcentaje de agua es obligatorio y debe ser un número.";
            } elseif ($porcAgua < 0 || $porcAgua > 100) {
                $errores[] = "El porcentaje de agua debe estar entre 0 y 100.";
            }

            if (empty($estadoTanque)) {
                $errores[] = "Debe indicar el estado del tanque.";
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
                ErrorModal::verError($errores, getUrl('FormularioLa', 'FormularioLa', 'getRegistrar'));
                return;
            }

            // 6. Todo válido: se procede a insertar
            $sqlSub = "INSERT INTO sub_actividades 
               (tipo_alimento, fecha_alimentacion, genero, obser_alimentacion, 
                can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, obser_canpeces, 
                estregar_paredes, aspirar, succionador, fecha_limpieza, obser_limpieza, 
                adicion_nivel_agua, medicion_ph, medicion_temperatura, fecha_ajuste, obser_ajuste, 
                estado_tanque, agua_cambiada, fecha_lavado, obser_lavado, 
                id_estado, id_seguimiento_zoo, cod_seguimiento) 
               VALUES 
               (NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, NULL, 
                $1, $2, $3, $4, 
                1, $5, $6)
               RETURNING id_sub_actividad";

            $resSub = $obj->select($sqlSub, [$estadoTanque, $porcAgua, $fechaHora, $obser, $id_seguimiento_zoo, $codM]);

            if (!empty($resSub)) {
                $id_sub_actividad = $resSub[0]['id_sub_actividad'];

                // La actividad siempre es Lavado (id fijo = 5)
                $obj->insert(
                    "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                    [self::ID_ACTIVIDAD_LAVADO, $id_sub_actividad]
                );
                 echo '<script>alert("¡Formulario registrado con exito!");</script>';
                redirect(getUrl("FormularioLa", "FormularioLa", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades.";
            }
        }
    }
}
?>