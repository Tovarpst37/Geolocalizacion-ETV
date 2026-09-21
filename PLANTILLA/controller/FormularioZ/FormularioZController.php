<?php

include_once '../model/FormularioZ/FormulariosModel.php';

class FormularioZController
{
    // id_actividad_zoo de "Alimentación" en actividad_zoocriadero (AZ-1)
    private const ID_ACTIVIDAD_ALIMENTACION = 1;

    public function getRegistrar()
    {
        $obj = new FormulariosModel();

        $sql10 = "SELECT cod_seguimiento FROM seguimiento_zoocriadero WHERE id_estado = 4";
        $seguimientos = $obj->select($sql10); 

        $sql1 = "SELECT * FROM usuarios";
        $numDocumen = $obj->select($sql1);

        include_once '../model/FormularioZ/tipoPez.php';
        include_once '../model/FormularioZ/tipoAlimen.php';

        $sql4 = "SELECT * FROM sub_actividades";
        $observaciones = $obj->select($sql4);

        // Documento del usuario que inició sesión, para mostrarlo fijo (no editable) en el formulario
        $documentoSesion = $_SESSION['documento'] ?? '';
         if (!empty($_SESSION['mensaje_exito'])): ?>
        <div id="alertaExito" class="alert d-flex align-items-center border-0 shadow-sm" role="alert" style="border-left: 5px solid #198754 !important; background-color: #fff;">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" style="color:#198754;">
            <use xlink:href="#check-circle-fill" />
            </svg>
            <div>
            <?php echo $_SESSION['mensaje_exito']; ?>
            </div>
        </div>
        <?php unset($_SESSION['mensaje_exito']); ?>

        <script>
            setTimeout(function() {
            var alerta = document.getElementById('alertaExito');
            if (alerta) {
                alerta.style.transition = "opacity 0.5s ease";
                alerta.style.opacity = "0";
                setTimeout(function() { alerta.remove(); }, 500);
            }
            }, 5000);
        </script>
        <?php endif;

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
                $errores[] = "Lo siento, el seguimiento no está activo.";
            } else {
                $id_seguimiento_zoo = $existeSeg[0]['id_seguimiento_zoo'];

                // El seguimiento debe tener asignada la actividad de Alimentación (por id)
                if (!$this->seguimientoTieneAlimentacion($obj, $id_seguimiento_zoo)) {
                    $errores[] = "Este seguimiento no tiene asignada la actividad de Alimentación, por lo que no se puede registrar el formulario.";
                }

                // Validar que NO se haya registrado previamente este formulario para este código
                if ($this->yaRegistroAlimentacion($obj, $id_seguimiento_zoo, $codigose)) {
                    $errores[] = "Ya existe un registro de alimentación guardado para este código de seguimiento.";
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

    // Verifica que el seguimiento tenga asignada la actividad "Alimentación" (id fijo = 1),
    // sin importar cómo esté escrito el nombre en la tabla.
    private function seguimientoTieneAlimentacion($obj, $id_seguimiento_zoo)
    {
        $sql = "SELECT 1
                FROM actividad_seg_zoo
                WHERE id_seguimiento_zoo = $1
                  AND id_actividad_zoo = $2
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_zoo, self::ID_ACTIVIDAD_ALIMENTACION]);

        return !empty($res);
    }

    // Verifica si ya existe un registro previo de Alimentación en sub_actividades para este seguimiento
    private function yaRegistroAlimentacion($obj, $id_seguimiento_zoo, $codigose)
    {
        $sql = "SELECT 1 
                FROM sub_actividades 
                WHERE (id_seguimiento_zoo = $1 OR cod_seguimiento = $2)
                  AND (obser_alimentacion IS NOT NULL OR fecha_alimentacion IS NOT NULL OR tipo_alimento IS NOT NULL)
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_zoo, $codigose]);

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

            // Si el seguimiento no tiene la actividad de Alimentación, no deja hacer el post
            if (!$this->seguimientoTieneAlimentacion($obj, $id_seguimiento_zoo)) {
                include_once '../model/Errores/ErrorModal.php';
                ErrorModal::verError(
                    ["Este seguimiento no tiene asignada la actividad de Alimentación, por lo que no se puede registrar el formulario."],
                    getUrl('FormularioZ', 'FormularioZ', 'getRegistrar')
                );
                return;
            }

            // Verifica si ya fue registrado previamente antes de insertar en BD
            if ($this->yaRegistroAlimentacion($obj, $id_seguimiento_zoo, $codigose)) {
                include_once '../model/Errores/ErrorModal.php';
                ErrorModal::verError(
                    ["Ya existe un registro de alimentación guardado para este código de seguimiento."],
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

                // La actividad siempre es Alimentación (id fijo = 1)
                $obj->insert(
                    "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                    [self::ID_ACTIVIDAD_ALIMENTACION, $id_sub_actividad]
                );
                
               $_SESSION['mensaje_exito'] = "Formulario registrado con éxito.";
                
                redirect(getUrl("FormularioZ", "FormularioZ", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades.";
            }
        }
    }
}
?>