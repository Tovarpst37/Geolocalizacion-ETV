<?php

include_once '../model/FormularioResi/FormulariosModel.php';

class FormularioResiController
{
    // id_actividad_terreno de "Resiembra" en actividad_terreno (AT-4)
    private const ID_ACTIVIDAD_RESIEMBRA = 4;

    public function getRegistrar()
    {
        $obj = new FormulariosModel();

        $sql10 = "SELECT cod_seguimiento FROM seguimiento_terreno WHERE id_estado = 4";
        $seguimientos = $obj->select($sql10); 

        $sql1 = "SELECT * FROM usuarios";
        $numDocumen = $obj->select($sql1);

        $sql4 = "SELECT * FROM sub_actividades_ter";
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

    // Verifica que el seguimiento de terreno tenga asignada la actividad "Resiembra" (id fijo = 4),
    // sin importar cómo esté escrito el nombre en la tabla.
    private function seguimientoTieneResiembra($obj, $id_seguimiento_terreno)
    {
        $sql = "SELECT 1
                FROM actividad_seg_terreno
                WHERE id_seguimiento_terreno = $1
                  AND id_actividad_terreno = $2
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_terreno, self::ID_ACTIVIDAD_RESIEMBRA]);

        return !empty($res);
    }

    // Verifica si ya existe un registro previo de Resiembra en sub_actividades_ter para este código
    private function yaRegistroResiembra($obj, $id_seguimiento_terreno, $codSeg)
    {
        $sql = "SELECT 1 
                FROM sub_actividades_ter 
                WHERE (id_seguimiento_terreno = $1 OR cod_seguimiento = $2)
                  AND (obser_resiembra IS NOT NULL OR fecha_resiembra IS NOT NULL OR can_peces_guppies_sembrados IS NOT NULL)
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
                } elseif ($existeSeg[0]['id_estado'] != 4) {
                    $errores[] = "Lo siento, el seguimiento no está activo.";
                } else {
                    $id_seguimiento_terreno = $existeSeg[0]['id_seguimiento_terreno'];

                    // El seguimiento debe tener asignada la actividad de Resiembra (por id)
                    if (!$this->seguimientoTieneResiembra($obj, $id_seguimiento_terreno)) {
                        $errores[] = "Este seguimiento no tiene asignada la actividad de Resiembra, por lo que no se puede registrar el formulario.";
                    }

                    // Validar que NO se haya registrado previamente este formulario para este código
                    if ($this->yaRegistroResiembra($obj, $id_seguimiento_terreno, $codSeg)) {
                        $errores[] = "Ya existe un registro de resiembra guardado para este código de seguimiento.";
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

                // La actividad siempre es Resiembra (id fijo = 4)
                $sqlBridge = "INSERT INTO actividad_ter_subactividades 
                              (id_actividad_terreno, id_sub_actividades) 
                              VALUES ($1, $2)";
                $obj->select($sqlBridge, [self::ID_ACTIVIDAD_RESIEMBRA, $id_sub_actividad]);
                 $_SESSION['mensaje_exito'] = "Formulario registrado con éxito.";
                redirect(getUrl("FormularioResi", "FormularioResi", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades_ter.";
            }
        }
    }
}
?>