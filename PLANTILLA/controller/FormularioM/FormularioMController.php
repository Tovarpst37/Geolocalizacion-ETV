<?php

include_once '../model/FormularioM/FormulariosModel.php';

class FormularioMController
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

        // Documento del usuario que inició sesión para el campo fijo
        $documentoSesion = $_SESSION['documento'] ?? '';

        include_once '../view/partials/FormularioM/registrar.php';
    }

    public function validarRegistrar()
    {
        $obj = new FormulariosModel();

        $codM = trim($_POST['codM'] ?? '');
        // El documento siempre sale de la sesión activa
        $docM = trim($_SESSION['documento'] ?? '');
        $canpez = $_POST['canpez'] ?? '';
        $muerto_Macho = $_POST['muerto_Macho'] ?? '';
        $muerto_Hembra = $_POST['muerto_Hembra'] ?? '';
        $ob = trim($_POST['obM'] ?? '');
        $ob = strip_tags($ob);

        $errores = [];

        // 1. Validar código de seguimiento
        if (empty($codM)) {
            $errores[] = "El código de seguimiento es obligatorio.";
        }

        $codigo_validar = '/^[a-zA-Z0-9\-\_ ]+$/';
        if (!empty($codM) && !preg_match($codigo_validar, $codM)) {
            $errores[] = "El código solo puede contener letras, números, guiones y espacios.";
        }

        // 2. Validar que el seguimiento exista, esté ACTIVO y tenga la actividad asignada
        $id_seguimiento_zoo = null;
        if (!empty($codM) && preg_match($codigo_validar, $codM)) {
            $sql_validar_seg = "SELECT id_seguimiento_zoo, id_estado FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1";
            $existeSeg = $obj->select($sql_validar_seg, [$codM]);

            if (empty($existeSeg)) {
                $errores[] = "No existe ningún seguimiento registrado con ese código.";
            } elseif ($existeSeg[0]['id_estado'] != 4) {
                $errores[] = "Lo siento, el seguimiento no está activo.";
            } else {
                $id_seguimiento_zoo = $existeSeg[0]['id_seguimiento_zoo'];

                // NUEVO: el seguimiento debe tener asignada la actividad de Peces muertos y nacidos
                if (!$this->seguimientoTienePecesMuertosNacidos($obj, $id_seguimiento_zoo)) {
                    $errores[] = "Este seguimiento no tiene asignada la actividad de Peces muertos y nacidos, por lo que no se puede registrar el formulario.";
                }
            }
        }

        // 3. Validar usuario en sesión
        if (empty($docM)) {
            $errores[] = "El número de documento es obligatorio.";
        } else {
            $sql_validar_user = "SELECT id_usuario FROM usuarios WHERE documento = $1";
            $existeUser = $obj->select($sql_validar_user, [$docM]);

            if (empty($existeUser)) {
                $errores[] = "No existe ningún usuario con ese número de documento.";
            }
        }

        // 4. Validar cantidades numéricas
        if ($canpez === '' || !is_numeric($canpez) || $canpez < 0) {
            $errores[] = "La cantidad de peces nacidos debe ser un número mayor o igual a 0.";
        }

        if ($muerto_Macho === '' || !is_numeric($muerto_Macho) || $muerto_Macho < 0) {
            $errores[] = "La cantidad de machos muertos debe ser un número mayor o igual a 0.";
        }

        if ($muerto_Hembra === '' || !is_numeric($muerto_Hembra) || $muerto_Hembra < 0) {
            $errores[] = "La cantidad de hembras muertas debe ser un número mayor o igual a 0.";
        }

        // 5. Validar observaciones
        if (empty($ob)) {
            $errores[] = "Las observaciones son obligatorias.";
        }
        if (strlen($ob) > 250) {
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
            ErrorModal::verError($errores, getUrl('FormularioM', 'FormularioM', 'getRegistrar'));

            return;
        }

        // Si no hay errores, insertar
        $this->postInsert($id_seguimiento_zoo);
    }

    // CORREGIDO: ahora usa ILIKE para encontrar "Peces Muertos y Nacidos" sin importar mayúsculas
    // y así no crear una actividad duplicada
    private function getOrCreateActividadZoo($obj, $nombre, $codigoDefault)
    {
        $sqlBuscar = "SELECT id_actividad_zoo FROM actividad_zoocriadero WHERE nombre_actividad ILIKE $1";
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

    // NUEVO: verifica que el seguimiento tenga asignada la actividad "Peces muertos y nacidos"
    // (existe una fila en actividad_seg_zoo que lo relaciona con esa actividad)
    private function seguimientoTienePecesMuertosNacidos($obj, $id_seguimiento_zoo)
    {
        // ILIKE 'Peces muertos y nacid%' coincide sin importar mayúsculas
        $sql = "SELECT 1
                FROM actividad_seg_zoo asz
                INNER JOIN actividad_zoocriadero a
                    ON a.id_actividad_zoo = asz.id_actividad_zoo
                WHERE asz.id_seguimiento_zoo = $1
                  AND a.nombre_actividad ILIKE 'Peces muertos y nacid%'
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_zoo]);

        return !empty($res);
    }

    public function postInsert($id_seguimiento_zoo = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codM = trim($_POST['codM'] ?? '');
            $canpez = (int) ($_POST['canpez'] ?? 0);
            $muerto_Macho = (int) ($_POST['muerto_Macho'] ?? 0);
            $muerto_Hembra = (int) ($_POST['muerto_Hembra'] ?? 0);
            $ob = trim($_POST['obM'] ?? '');
            $ob = strip_tags($ob);

            if (empty($id_seguimiento_zoo)) {
                $sqlExiste = "SELECT id_seguimiento_zoo FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1 AND id_estado = 4";
                $existe = $obj->select($sqlExiste, [$codM]);

                if (empty($existe)) {
                    include_once '../model/Errores/ErrorModal.php';
                    ErrorModal::verError(
                        ["Lo siento, el seguimiento no está activo."],
                        getUrl('FormularioM', 'FormularioM', 'getRegistrar')
                    );
                    return;
                }

                $id_seguimiento_zoo = $existe[0]['id_seguimiento_zoo'];
            }

            // NUEVO: si el seguimiento no tiene la actividad de Peces muertos y nacidos, no deja hacer el post
            if (!$this->seguimientoTienePecesMuertosNacidos($obj, $id_seguimiento_zoo)) {
                include_once '../model/Errores/ErrorModal.php';
                ErrorModal::verError(
                    ["Este seguimiento no tiene asignada la actividad de Peces muertos y nacidos, por lo que no se puede registrar el formulario."],
                    getUrl('FormularioM', 'FormularioM', 'getRegistrar')
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
               (NULL, NULL, NULL, NULL, 
                $1, $2, $3, $4, 
                NULL, NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, NULL, 
                NULL, NULL, NULL, NULL, 
                1, $5, $6)
               RETURNING id_sub_actividad";

            $resSub = $obj->select($sqlSub, [
                $muerto_Hembra,
                $muerto_Macho,
                $canpez,
                $ob,
                $id_seguimiento_zoo,
                $codM
            ]);

            if (!empty($resSub)) {
                $id_sub_actividad = $resSub[0]['id_sub_actividad'];

                $id_actividad_zoo = $this->getOrCreateActividadZoo($obj, 'Peces muertos y nacidos', 'AZ-2');
                if ($id_actividad_zoo) {
                    $obj->insert(
                        "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                        [$id_actividad_zoo, $id_sub_actividad]
                    );
                }

                redirect(getUrl("FormularioM", "FormularioM", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades.";
            }
        }
    }
}
?>