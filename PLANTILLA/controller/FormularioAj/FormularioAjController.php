<?php

include_once '../model/FormularioAj/FormulariosModel.php';

class FormularioAjController
{
    // id_actividad_zoo de "Ajustes de Nivel" en actividad_zoocriadero (AZ-4)
    private const ID_ACTIVIDAD_AJUSTES_NIVEL = 4;

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

        include_once '../view/partials/FormularioAj/registrar.php';
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

    // Verifica que el seguimiento tenga asignada la actividad "Ajustes de Nivel" (id fijo = 4),
    // sin importar cómo esté escrito el nombre en la tabla.
    private function seguimientoTieneAjuste($obj, $id_seguimiento_zoo)
    {
        $sql = "SELECT 1
                FROM actividad_seg_zoo
                WHERE id_seguimiento_zoo = $1
                  AND id_actividad_zoo = $2
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_zoo, self::ID_ACTIVIDAD_AJUSTES_NIVEL]);

        return !empty($res);
    }

    // Verifica si ya existe un registro previo de Ajustes de Nivel en sub_actividades para este seguimiento
    private function yaRegistroAjuste($obj, $id_seguimiento_zoo, $codAj)
    {
        $sql = "SELECT 1 
                FROM sub_actividades 
                WHERE (id_seguimiento_zoo = $1 OR cod_seguimiento = $2)
                  AND (obser_ajuste IS NOT NULL OR fecha_ajuste IS NOT NULL OR adicion_nivel_agua IS NOT NULL OR medicion_ph IS NOT NULL OR medicion_temperatura IS NOT NULL)
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_zoo, $codAj]);

        return !empty($res);
    }

    public function validarRegistrar()
    {
        $obj = new FormulariosModel();

        $codAj = $this->limpiarCodigo($_POST['codAj'] ?? '');
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

        $invalidos = !empty($codAj) ? $this->caracteresInvalidos($codAj) : [];
        if (!empty($invalidos)) {
            $errores[] = "El código contiene caracteres no permitidos: "
                . htmlspecialchars(implode(' ', $invalidos))
                . ". Solo se permiten letras, números, guiones, puntos, barras y espacios.";
        }

        // 2. Validar existencia, estado y actividad de Ajustes de Nivel del seguimiento
        $id_seguimiento_zoo = null;
        if (!empty($codAj) && empty($invalidos)) {
            $sql_validar_seg = "SELECT id_seguimiento_zoo, id_estado FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1";
            $existeSeg = $obj->select($sql_validar_seg, [$codAj]);

            if (empty($existeSeg)) {
                $errores[] = "No existe ningún seguimiento registrado con ese código.";
            } elseif ($existeSeg[0]['id_estado'] != 4) {
                $errores[] = "Lo siento, el seguimiento no está activo.";
            } else {
                $id_seguimiento_zoo = $existeSeg[0]['id_seguimiento_zoo'];

                // El seguimiento debe tener asignada la actividad de Ajustes de Nivel (por id)
                if (!$this->seguimientoTieneAjuste($obj, $id_seguimiento_zoo)) {
                    $errores[] = "Este seguimiento no tiene asignada la actividad de Ajustes de Nivel, por lo que no se puede registrar el formulario.";
                }

                // Validar que NO se haya registrado previamente este formulario para este código
                if ($this->yaRegistroAjuste($obj, $id_seguimiento_zoo, $codAj)) {
                    $errores[] = "Ya existe un registro de ajustes de nivel guardado para este código de seguimiento.";
                }
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

    public function postInsert($id_seguimiento_zoo = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codAj = $this->limpiarCodigo($_POST['codAj'] ?? '');
            $nivelAgua = (float) ($_POST['nv'] ?? 0);
            $ph = (float) ($_POST['ph'] ?? 0);
            $temp = (float) ($_POST['tem'] ?? 0);
            $obser = trim($_POST['ob'] ?? '');
            $obser = strip_tags($obser);

            $fechaHora = date('Y-m-d H:i:s');

            if (empty($id_seguimiento_zoo)) {
                $sqlExiste = "SELECT id_seguimiento_zoo FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1 AND id_estado = 4";
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

            // Si el seguimiento no tiene la actividad de Ajustes de Nivel, no deja hacer el post
            if (!$this->seguimientoTieneAjuste($obj, $id_seguimiento_zoo)) {
                include_once '../model/Errores/ErrorModal.php';
                ErrorModal::verError(
                    ["Este seguimiento no tiene asignada la actividad de Ajustes de Nivel, por lo que no se puede registrar el formulario."],
                    getUrl('FormularioAj', 'FormularioAj', 'getRegistrar')
                );
                return;
            }

            // Verifica si ya fue registrado previamente antes de insertar en BD
            if ($this->yaRegistroAjuste($obj, $id_seguimiento_zoo, $codAj)) {
                include_once '../model/Errores/ErrorModal.php';
                ErrorModal::verError(
                    ["Ya existe un registro de ajustes de nivel guardado para este código de seguimiento."],
                    getUrl('FormularioAj', 'FormularioAj', 'getRegistrar')
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

                // La actividad siempre es Ajustes de Nivel (id fijo = 4)
                $obj->insert(
                    "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                    [self::ID_ACTIVIDAD_AJUSTES_NIVEL, $id_sub_actividad]
                );
                  $_SESSION['mensaje_exito'] = "Formulario registrado con éxito.";
                redirect(getUrl("FormularioAj", "FormularioAj", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades.";
            }
        }
    }
}
?>