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
        $cont = 0;

        $codigose = trim($_POST['codigose'] ?? '');
        $documen = trim($_SESSION['documento'] ?? '');
        $fecha_hora = $_POST['fecha_hora'] ?? '';
        $tipo_pez = $_POST['tipo_pez'] ?? '';
        $tipo_alimen = $_POST['tipo_alimen'] ?? '';
        $ob = trim($_POST['ob'] ?? '');

        $errores = [];

        if (empty($codigose)) {
            $errores[] = "El código de seguimiento es obligatorio.";
        } else {
            // Validar que el código solo tenga caracteres válidos
            $codigo_validar = '/^[a-zA-Z0-9\-\_ ]+$/';
            if (!preg_match($codigo_validar, $codigose)) {
                $errores[] = "El código solo puede contener letras, números, guiones y espacios.";
            } else {
                
                $sql_validar_seg = "SELECT id_estado FROM seguimiento_zoocriadero WHERE cod_seguimiento = '$1'";
                $segExiste = $obj->select($sql_validar_seg, [$codigose]);

                if (empty($segExiste)) {
                    $errores[] = "El código de seguimiento no existe. No se puede crear uno nuevo desde este formulario.";
                } elseif ($segExiste[0]['id_estado'] != 1) {
                    $errores[] = "El seguimiento existe pero no se encuentra en estado ACTIVO.";
                }
            }
        }

        if (empty($documen)) {
            $errores[] = "El número de documento es obligatorio.";
        } else {
            $sql_validar_user = "SELECT id_usuario FROM usuarios WHERE documento = $1";
            $existeUser = $obj->select($sql_validar_user, [$documen]);

            if (empty($existeUser)) {
                $errores[] = "No existe ningún usuario con ese número de documento.";
            }
        }

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

            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $this->postInsert();
        }
    }

    private function getOrCreateActividadZoo($obj, $nombre, $codigoDefault)
    {
        $sqlBuscar = "SELECT id_actividad_zoo FROM actividad_zoocriadero WHERE nombre_actividad = '$nombre'";
        $res = $obj->select($sqlBuscar);

        if (!empty($res)) {
            return $res[0]['id_actividad_zoo'];
        }

        $sqlCrear = "INSERT INTO actividad_zoocriadero (cod_actividad, nombre_actividad, id_estado) 
                     VALUES ('$codigoDefault', '$nombre', 1) 
                     RETURNING id_actividad_zoo";
        $creado = $obj->select($sqlCrear);

        return !empty($creado) ? $creado[0]['id_actividad_zoo'] : null;
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codigose = $_POST['codigose'] ?? '';
            $documen = $_SESSION['documento'] ?? '';
            $fecha_hora = $_POST['fecha_hora'] ?? '';
            $tipo_pez = $_POST['tipo_pez'] ?? '';
            $tipo_alimen = $_POST['tipo_alimen'] ?? '';
            $ob = $_POST['ob'] ?? '';

            $fecha_array = explode(" ", $fecha_hora);
            $fecha = !empty($fecha_array[0]) ? $fecha_array[0] : date('Y-m-d');
            $hora = !empty($fecha_array[1]) ? $fecha_array[1] : date('H:i:s');

            $sqlExiste = "SELECT id_seguimiento_zoo, cod_seguimiento 
                      FROM seguimiento_zoocriadero 
                      WHERE cod_seguimiento = '$codigose'";
            $existe = $obj->select($sqlExiste);

            $id_seguimiento_zoo = null;

            if (!empty($existe)) {
                $id_seguimiento_zoo = $existe[0]['id_seguimiento_zoo'];
            } else {
                $sqlUser = "SELECT id_usuario FROM usuarios WHERE documento = '$documen'";
                $userResult = $obj->select($sqlUser);
                $id_usuario = !empty($userResult) ? $userResult[0]['id_usuario'] : 1;

                $sqlTanque = "SELECT id_tanque FROM tanque LIMIT 1";
                $tanqueResult = $obj->select($sqlTanque);
                $id_tanque = !empty($tanqueResult) ? $tanqueResult[0]['id_tanque'] : 1;

                $sqlInsertSeg = "INSERT INTO seguimiento_zoocriadero 
                             (cod_seguimiento, fecha, id_tanque, id_usuario, id_estado, hora_inicio) 
                             VALUES ('$codigose', '$fecha', $id_tanque, $id_usuario, 1, '$hora') 
                             RETURNING id_seguimiento_zoo";

                $resSeg = $obj->insert($sqlInsertSeg);

                if ($resSeg) {
                    $nuevoSeg = $obj->select("SELECT id_seguimiento_zoo FROM seguimiento_zoocriadero WHERE cod_seguimiento = '$codigose'");
                    $id_seguimiento_zoo = $nuevoSeg[0]['id_seguimiento_zoo'];
                }
            }

            if ($id_seguimiento_zoo) {
                $sqlSub = "INSERT INTO sub_actividades 
               (tipo_alimento, fecha_alimentacion, genero, obser_alimentacion, 
                can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, obser_canpeces, 
                estregar_paredes, aspirar, succionador, fecha_limpieza, obser_limpieza, 
                adicion_nivel_agua, medicion_ph, medicion_temperatura, fecha_ajuste, obser_ajuste, 
                estado_tanque, agua_cambiada, fecha_lavado, obser_lavado, 
                id_estado, id_seguimiento_zoo, cod_seguimiento) 
               VALUES 
               ('$tipo_alimen', '$fecha', '$tipo_pez', '$ob', 
                NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, 
                1, $id_seguimiento_zoo, '$codigose')
               RETURNING id_sub_actividad";

                $resSub = $obj->select($sqlSub);

                if (!empty($resSub)) {
                    $id_sub_actividad = $resSub[0]['id_sub_actividad'];

                    // Vincular con el catálogo de tipos de actividad
                    $id_actividad_zoo = $this->getOrCreateActividadZoo($obj, 'Alimentacion', 'ALI001');
                    if ($id_actividad_zoo) {
                        $obj->insert("INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) 
                                      VALUES ($id_actividad_zoo, $id_sub_actividad)");
                    }

                    redirect(getUrl("FormularioZ", "FormularioZ", "getRegistrar"));
                } else {
                    echo "Error al guardar el detalle en sub_actividades.";
                }
            } else {
                echo "Error al procesar el código de seguimiento.";
            }
        }
    }



}
?>