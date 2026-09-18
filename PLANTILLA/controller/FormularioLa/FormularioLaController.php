<?php

include_once '../model/FormularioLa/FormulariosModel.php';

class FormularioLaController
{
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

    private function getOrCreateActividadZoo($obj, $nombre, $codigoDefault)
    {
        $sqlBuscar = "SELECT id_actividad_zoo FROM actividad_zoocriadero WHERE nombre_actividad = $1";
        $res = $obj->select($sqlBuscar, [$nombre]);

        if (!empty($res)) {
            return $res[0]['id_actividad_zoo'];
        }

        $sqlCrear = "INSERT INTO actividad_zoocriadero (cod_actividad, nombre_actividad, id_estado) 
                     VALUES ($1, $2, 1) 
                     RETURNING id_actividad_zoo";
        $creado = $obj->select($sqlCrear, [$codigoDefault, $nombre]);

        return !empty($creado) ? $creado[0]['id_actividad_zoo'] : null;
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codM = trim($_POST['codLa'] ?? '');
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

            $codigo_validar = '/^[a-zA-Z0-9\-\_ ]+$/';
            if (!empty($codM) && !preg_match($codigo_validar, $codM)) {
                $errores[] = "El código solo puede contener letras, números, guiones y espacios.";
            }

            // 2. Validar existencia y estado del seguimiento en BD
            $id_seguimiento_zoo = null;
            if (!empty($codM) && preg_match($codigo_validar, $codM)) {
                $sql_validar_seg = "SELECT id_seguimiento_zoo, id_estado FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1";
                $existeSeg = $obj->select($sql_validar_seg, [$codM]);

                if (empty($existeSeg)) {
                    $errores[] = "No existe ningún seguimiento registrado con ese código.";
                } elseif ($existeSeg[0]['id_estado'] != 1) {
                    $errores[] = "Lo siento, el seguimiento no está activo.";
                } else {
                    $id_seguimiento_zoo = $existeSeg[0]['id_seguimiento_zoo'];
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

                $id_actividad_zoo = $this->getOrCreateActividadZoo($obj, 'Lavado', 'LAV001');
                if ($id_actividad_zoo) {
                    $obj->insert(
                        "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                        [$id_actividad_zoo, $id_sub_actividad]
                    );
                }

                redirect(getUrl("FormularioLa", "FormularioLa", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades.";
            }
        }
    }
}
?>