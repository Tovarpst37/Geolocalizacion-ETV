<?php

include_once '../model/FormularioAj/FormulariosModel.php';

class FormularioAjController
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

        // Documento del usuario que inició sesión
        $documentoSesion = $_SESSION['documento'] ?? '';

        include_once '../view/partials/FormularioAj/registrar.php';
    }

    public function validarRegistrar()
    {
        $obj = new FormulariosModel();

        $codAj = trim($_POST['codAj'] ?? '');
        // El documento se toma de la sesión activa
        $docAj = trim($_SESSION['documento'] ?? '');
        $nivelAgua = $_POST['nv'] ?? '';
        $ph = $_POST['ph'] ?? '';
        $temp = $_POST['tem'] ?? '';
        $obser = trim($_POST['ob'] ?? '');
        $obser = strip_tags($obser);

        $errores = [];

        // 1. Validar código de seguimiento
        if (empty($codAj)) {
            $errores[] = "El código de seguimiento es obligatorio.";
        }

        $codigo_validar = '/^[a-zA-Z0-9\-\_ ]+$/';
        if (!empty($codAj) && !preg_match($codigo_validar, $codAj)) {
            $errores[] = "El código solo puede contener letras, números, guiones y espacios.";
        }

        // 2. Validar que el seguimiento exista y esté ACTIVO (id_estado = 1)
        $id_seguimiento_zoo = null;
        if (!empty($codAj) && preg_match($codigo_validar, $codAj)) {
            $sql_validar_seg = "SELECT id_seguimiento_zoo, id_estado FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1";
            $existeSeg = $obj->select($sql_validar_seg, [$codAj]);

            if (empty($existeSeg)) {
                $errores[] = "No existe ningún seguimiento registrado con ese código.";
            } elseif ($existeSeg[0]['id_estado'] != 1) {
                $errores[] = "Lo siento, el seguimiento no está activo.";
            } else {
                $id_seguimiento_zoo = $existeSeg[0]['id_seguimiento_zoo'];
            }
        }

        // 3. Validar usuario en sesión
        if (empty($docAj)) {
            $errores[] = "El número de documento es obligatorio.";
        } else {
            $sql_validar_user = "SELECT id_usuario FROM usuarios WHERE documento = $1";
            $existeUser = $obj->select($sql_validar_user, [$docAj]);

            if (empty($existeUser)) {
                $errores[] = "No existe ningún usuario con ese número de documento.";
            }
        }

        // 4. Validar parámetros de agua
        if ($nivelAgua === '' || !is_numeric($nivelAgua) || $nivelAgua < 0) {
            $errores[] = "El nivel de agua debe ser un valor numérico válido.";
        }

        if ($ph === '' || !is_numeric($ph) || $ph < 0 || $ph > 14) {
            $errores[] = "El valor del pH debe ser un número entre 0 y 14.";
        }

        if ($temp === '' || !is_numeric($temp) || $temp < -10 || $temp > 60) {
            $errores[] = "La temperatura debe ser un valor numérico válido.";
        }

        // 5. Validar observaciones
        if (empty($obser)) {
            $errores[] = "Las observaciones son obligatorias.";
        }
        if (strlen($obser) > 250) {
            $errores[] = "Las observaciones no pueden superar los 250 caracteres.";
        }

        // Manejo de errores y retorno modal a la vista
        if (!empty($errores)) {
            $_SESSION['old_input'] = $_POST;

            $sql = "SELECT * FROM seguimiento_zoocriadero";
            $seguimientos = $obj->select($sql);

            $sql1 = "SELECT * FROM usuarios";
            $numDocumen = $obj->select($sql1);

            $sql4 = "SELECT * FROM sub_actividades";
            $observaciones = $obj->select($sql4);

            $documentoSesion = $_SESSION['documento'] ?? '';

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('FormularioAj', 'FormularioAj', 'getRegistrar'));

            return;
        }

        // Si la validación es correcta, se procede con la inserción
        $this->postInsert($id_seguimiento_zoo);
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

    public function postInsert($id_seguimiento_zoo = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codAj = trim($_POST['codAj'] ?? '');
            $nivelAgua = (float) ($_POST['nv'] ?? 0);
            $ph = (float) ($_POST['ph'] ?? 0);
            $temp = (float) ($_POST['tem'] ?? 0);
            $obser = trim($_POST['ob'] ?? '');
            $obser = strip_tags($obser);

            $fechaHora = date('Y-m-d H:i:s');

            if (empty($id_seguimiento_zoo)) {
                $sqlExiste = "SELECT id_seguimiento_zoo FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1 AND id_estado = 1";
                $existe = $obj->select($sqlExiste, [$codAj]);

                if (empty($existe)) {
                    include_once '../model/Errores/ErrorModal.php';
                    ErrorModal::verError(
                        ["Lo siento, el seguimiento no está activo."],
                        getUrl('FormularioAj', 'FormularioAj', 'getRegistrar')
                    );
                    return;
                }

                $id_seguimiento_zoo = $existe[0]['id_seguimiento_zoo'];
            }

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
                $1, $2, $3, $4, $5, 
                NULL, NULL, NULL, NULL, 
                1, $6, $7)
               RETURNING id_sub_actividad";

            $resSub = $obj->select($sqlSub, [
                $nivelAgua,
                $ph,
                $temp,
                $fechaHora,
                $obser,
                $id_seguimiento_zoo,
                $codAj
            ]);

            if (!empty($resSub)) {
                $id_sub_actividad = $resSub[0]['id_sub_actividad'];

                $id_actividad_zoo = $this->getOrCreateActividadZoo($obj, 'Ajuste de nivel', 'AJU001');
                if ($id_actividad_zoo) {
                    $obj->insert(
                        "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                        [$id_actividad_zoo, $id_sub_actividad]
                    );
                }

                redirect(getUrl("FormularioAj", "FormularioAj", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades.";
            }
        }
    }
}
?>