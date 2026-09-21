<?php

include_once '../model/FormularioSiem/FormulariosModel.php';

class FormularioSiemController
{
    // id_actividad_terreno de "Siembra" en actividad_terreno (AT-2)
    private const ID_ACTIVIDAD_SIEMBRA = 2;

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

        include_once '../view/partials/FormularioSiem/registrar.php';
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

    // Verifica que el seguimiento de terreno tenga asignada la actividad "Siembra" (id fijo = 2),
    // sin importar cómo esté escrito el nombre en la tabla.
    private function seguimientoTieneSiembra($obj, $id_seguimiento_terreno)
    {
        $sql = "SELECT 1
                FROM actividad_seg_terreno
                WHERE id_seguimiento_terreno = $1
                  AND id_actividad_terreno = $2
                LIMIT 1";

        $res = $obj->select($sql, [$id_seguimiento_terreno, self::ID_ACTIVIDAD_SIEMBRA]);

        return !empty($res);
    }

    // Verifica si ya existe un registro previo de Siembra en sub_actividades_ter para este seguimiento
    private function yaRegistroSiembra($obj, $id_seguimiento_terreno, $codSeg)
    {
        $sql = "SELECT 1 
                FROM sub_actividades_ter 
                WHERE (id_seguimiento_terreno = $1 OR cod_seguimiento = $2)
                  AND (obser_siembra IS NOT NULL OR fecha_siembra IS NOT NULL OR can_peces_empacados IS NOT NULL OR can_hembras_sembradas IS NOT NULL OR can_machos_sembrados IS NOT NULL)
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
            $fechaHora = $_POST['fecha_horaSiem'] ?? '';
            $pecesEmpacados = $_POST['pecesEmpacados'] ?? '';
            $tiempoAclimat = $_POST['tiempoAclimat'] ?? '';
            $hembrasSembradas = $_POST['hembrasSembradas'] ?? '';
            $machosSembrados = $_POST['machosSembrados'] ?? '';
            $litrosAgua = $_POST['litrosAgua'] ?? '';
            $presenciaLarvasRaw = $_POST['presenciaLarvas'] ?? '';
            $presenciaPecesRaw = $_POST['presenciaPeces'] ?? '';
            $obser = trim($_POST['obserSiem'] ?? '');
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

            // 2. Validar existencia, estado y actividad de Siembra del seguimiento
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

                    // El seguimiento debe tener asignada la actividad de Siembra (por id)
                    if (!$this->seguimientoTieneSiembra($obj, $id_seguimiento_terreno)) {
                        $errores[] = "Este seguimiento no tiene asignada la actividad de Siembra, por lo que no se puede registrar el formulario.";
                    }

                    // Validar que NO se haya registrado previamente este formulario para este código
                    if ($this->yaRegistroSiembra($obj, $id_seguimiento_terreno, $codSeg)) {
                        $errores[] = "Ya existe un registro de siembra guardado para este código de seguimiento.";
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
                $errores[] = "La fecha y hora de siembra son obligatorias.";
            }

            if ($pecesEmpacados === '' || !is_numeric($pecesEmpacados) || $pecesEmpacados < 0) {
                $errores[] = "La cantidad de peces empacados es obligatoria y debe ser un número válido.";
            }

            if ($tiempoAclimat === '' || !is_numeric($tiempoAclimat) || $tiempoAclimat < 0) {
                $errores[] = "El tiempo de aclimatación es obligatorio y debe ser un número válido.";
            }

            if ($hembrasSembradas === '' || !is_numeric($hembrasSembradas) || $hembrasSembradas < 0) {
                $errores[] = "La cantidad de hembras sembradas es obligatoria y debe ser un número válido.";
            }

            if ($machosSembrados === '' || !is_numeric($machosSembrados) || $machosSembrados < 0) {
                $errores[] = "La cantidad de machos sembrados es obligatoria y debe ser un número válido.";
            }

            if ($litrosAgua === '' || !is_numeric($litrosAgua) || $litrosAgua < 0) {
                $errores[] = "El volumen de agua utilizado es obligatorio y debe ser un número válido.";
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
                ErrorModal::verError($errores, getUrl('FormularioSiem', 'FormularioSiem', 'getRegistrar'));
                return;
            }

            // 6. Todo válido: se procede a insertar
            $presenciaLarv = $presenciaLarvasRaw === '1' ? 'true' : 'false';
            $presenciaPec = $presenciaPecesRaw === '1' ? 'true' : 'false';

            $sqlSub = "INSERT INTO sub_actividades_ter
               (fecha_siembra, can_peces_empacados, tiempo_aclimatacion, 
                can_hembras_sembradas, can_machos_sembrados, litros_utilizados, 
                presencia_larvas_siembra, presencia_peces_siembra, obser_siembra, 
                id_estado, id_seguimiento_terreno, cod_seguimiento) 
               VALUES 
               ($1, $2, $3, 
                $4, $5, $6, 
                $7, $8, $9, 
                1, $10, $11)
               RETURNING id_sub_actividad";

            $resSub = $obj->select($sqlSub, [
                $fechaHora,
                $pecesEmpacados,
                $tiempoAclimat,
                $hembrasSembradas,
                $machosSembrados,
                $litrosAgua,
                $presenciaLarv,
                $presenciaPec,
                $obser,
                $id_seguimiento_terreno,
                $codSeg
            ]);

            if (!empty($resSub)) {
                $id_sub_actividad = $resSub[0]['id_sub_actividad'];

               
                $obj->insert(
                    "INSERT INTO actividad_ter_subactividades (id_actividad_terreno, id_sub_actividades) VALUES ($1, $2)",
                    [self::ID_ACTIVIDAD_SIEMBRA, $id_sub_actividad]
                );
                 $_SESSION['mensaje_exito'] = "Formulario registrado con éxito.";
                redirect(getUrl("FormularioSiem", "FormularioSiem", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades_terreno.";
            }
        }
    }
}
?>