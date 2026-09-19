<?php

include_once '../model/FormularioZ/FormulariosModel.php';

class FormularioZController
{
    public function getRegistrar()
    {
        $obj = new FormulariosModel();

        $sql = "SELECT * FROM seguimiento_zoocriadero";
        $seguimientos = $obj->select($sql);

        $sql1 = "SELECT * FROM usuarios";
        $numDocumen = $obj->select($sql1);

        include_once '../model/FormularioZ/tipoPez.php';
        include_once '../model/FormularioZ/tipoAlimen.php';

        $sql4 = "SELECT * FROM sub_actividades";
        $observaciones = $obj->select($sql4);

        // Documento del usuario que inició sesión, para mostrarlo fijo (no editable) en el formulario
        $documentoSesion = $_SESSION['documento'] ?? '';

        include_once '../view/partials/Formularioz/registrar.php';
    }

    public function validarRegistrar()
    {
        $obj = new FormulariosModel();

        $codigose = trim($_POST['codigose'] ?? '');
        $documen = trim($_SESSION['documento'] ?? '');
        $fecha_hora = $_POST['fecha_hora'] ?? '';
        $tipo_pez = $_POST['tipo_pez'] ?? '';
        $tipo_alimen = $_POST['tipo_alimen'] ?? '';
        $ob = trim($_POST['ob'] ?? '');
        $ob = strip_tags($ob);

        $errores = [];

        // 1. Validar código ingresado
        if (empty($codigose)) {
            $errores[] = "El código de seguimiento es obligatorio.";
        }

        $codigo_validar = '/^[a-zA-Z0-9\-\_ ]+$/';
        if (!empty($codigose) && !preg_match($codigo_validar, $codigose)) {
            $errores[] = "El código solo puede contener letras, números, guiones y espacios.";
        }

        // 2. Validar existencia, estado y actividad de Alimentación del seguimiento
        $id_seguimiento_zoo = null;
        if (!empty($codigose) && preg_match($codigo_validar, $codigose)) {
            $sql_validar_seg = "SELECT id_seguimiento_zoo, id_estado FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1";
            $existeSeg = $obj->select($sql_validar_seg, [$codigose]);

            if (empty($existeSeg)) {
                $errores[] = "No existe ningún seguimiento registrado con ese código.";
            } elseif ($existeSeg[0]['id_estado'] != 4) {
                // Mensaje exacto cuando no está activo:
                $errores[] = "Lo siento, el seguimiento no está activo.";
            } else {
                $id_seguimiento_zoo = $existeSeg[0]['id_seguimiento_zoo'];

                // NUEVO: el seguimiento debe tener asignada la actividad de Alimentación
                if (!$this->seguimientoTieneAlimentacion($obj, $id_seguimiento_zoo)) {
                    $errores[] = "Este seguimiento no tiene asignada la actividad de Alimentación, por lo que no se puede registrar el formulario.";
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
        if (empty($fecha_hora)) {
            $errores[] = "La fecha y hora son obligatorias.";
        }

        if (empty($tipo_pez)) {
            $errores[] = "Debe seleccionar el tipo de pez.";
        }

        if (empty($tipo_alimen)) {
            $errores[] = "Debe seleccionar el tipo de alimentación.";
        }

        if (empty($ob)) {
            $errores[] = "Las observaciones son obligatorias.";
        }
        if (strlen($ob) > 250) {
            $errores[] = "Las observaciones no pueden superar los 250 caracteres.";
        }

        // 5. Manejo de errores y redirección a la vista registrar
        if (!empty($errores)) {
            $_SESSION['old_input'] = $_POST;

            $sql = "SELECT * FROM seguimiento_zoocriadero";
            $seguimientos = $obj->select($sql);

            $sql1 = "SELECT * FROM usuarios";
            $numDocumen = $obj->select($sql1);

            include_once '../model/FormularioZ/tipoPez.php';
            include_once '../model/FormularioZ/tipoAlimen.php';

            $sql4 = "SELECT * FROM sub_actividades";
            $observaciones = $obj->select($sql4);

            $documentoSesion = $_SESSION['documento'] ?? '';

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('FormularioZ', 'FormularioZ', 'getRegistrar'));

            return; // Detiene la ejecución aquí para no insertar datos
        }

        // Si no hay errores, procede con la inserción
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

    // NUEVO: verifica que el seguimiento tenga asignada la actividad "Alimentación"
    // (existe una fila en actividad_seg_zoo que lo relaciona con esa actividad)
    private function seguimientoTieneAlimentacion($obj, $id_seguimiento_zoo)
    {
        // ILIKE 'Alimentaci_n' coincide con "Alimentacion" y "Alimentación"
        $sql = "SELECT 1
                FROM actividad_seg_zoo asz
                INNER JOIN actividad_zoocriadero a
                    ON a.id_actividad_zoo = asz.id_actividad_zoo
                WHERE asz.id_seguimiento_zoo = $1
                  AND a.nombre_actividad ILIKE 'Alimentaci_n'
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_zoo]);

        return !empty($res);
    }

    public function postInsert($id_seguimiento_zoo = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codigose = trim($_POST['codigose'] ?? '');
            $tipo_pez = $_POST['tipo_pez'] ?? '';
            $tipo_alimen = $_POST['tipo_alimen'] ?? '';
            $ob = trim($_POST['ob'] ?? '');
            $ob = strip_tags($ob);
            $fecha_hora = $_POST['fecha_hora'] ?? '';

            $fecha_array = explode(" ", $fecha_hora);
            $fecha = !empty($fecha_array[0]) ? $fecha_array[0] : date('Y-m-d');

            if (empty($id_seguimiento_zoo)) {
                $sqlExiste = "SELECT id_seguimiento_zoo FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1 AND id_estado = 4";
                $existe = $obj->select($sqlExiste, [$codigose]);

                if (empty($existe)) {
                    include_once '../model/Errores/ErrorModal.php';
                    ErrorModal::verError(
                        ["Lo siento, el seguimiento no está activo."],
                        getUrl('FormularioZ', 'FormularioZ', 'getRegistrar')
                    );
                    return;
                }

                $id_seguimiento_zoo = $existe[0]['id_seguimiento_zoo'];
            }

            // NUEVO: si el seguimiento no tiene la actividad de Alimentación, no deja hacer el post
            if (!$this->seguimientoTieneAlimentacion($obj, $id_seguimiento_zoo)) {
                include_once '../model/Errores/ErrorModal.php';
                ErrorModal::verError(
                    ["Este seguimiento no tiene asignada la actividad de Alimentación, por lo que no se puede registrar el formulario."],
                    getUrl('FormularioZ', 'FormularioZ', 'getRegistrar')
                );
                return;
            }

            $sqlSub = "INSERT INTO sub_actividades 
               (tipo_alimento, fecha_alimentacion, genero, obser_alimentacion, 
                can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, obser_canpeces, 
                estregar_paredes, aspirar, succionador, fecha_limpieza, obser_limpieza, 
                adicion_nivel_agua, medicion_ph, medicion_temperatura, fecha_ajuste, obser_ajuste, 
                estado_tanque, agua_cambiada, fecha_lavado, obser_lavado, 
                id_estado, id_seguimiento_zoo, cod_seguimiento) 
               VALUES 
               ($1, $2, $3, $4, 
                NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, 
                1, $5, $6)
               RETURNING id_sub_actividad";

            $resSub = $obj->select($sqlSub, [$tipo_alimen, $fecha, $tipo_pez, $ob, $id_seguimiento_zoo, $codigose]);

            if (!empty($resSub)) {
                $id_sub_actividad = $resSub[0]['id_sub_actividad'];

                $id_actividad_zoo = $this->getOrCreateActividadZoo($obj, 'Alimentacion', 'ALI001');
                if ($id_actividad_zoo) {
                    $obj->insert(
                        "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                        [$id_actividad_zoo, $id_sub_actividad]
                    );
                }

                redirect(getUrl("FormularioZ", "FormularioZ", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades.";
            }
        }
    }
}
?>