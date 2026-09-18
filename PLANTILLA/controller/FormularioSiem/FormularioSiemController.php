<?php

include_once '../model/FormularioSiem/FormulariosModel.php';

class FormularioSiemController
{
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

        include_once '../view/partials/FormularioSiem/registrar.php';
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codSeg = trim($_POST['codSeg'] ?? '');
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

            $codigo_validar = '/^[a-zA-Z0-9\-\_ ]+$/';
            if (!empty($codSeg) && !preg_match($codigo_validar, $codSeg)) {
                $errores[] = "El código solo puede contener letras, números, guiones y espacios.";
            }

            // 2. Validar existencia y estado del seguimiento en BD
            $id_seguimiento_terreno = null;
            if (!empty($codSeg) && preg_match($codigo_validar, $codSeg)) {
                $sql_validar_seg = "SELECT id_seguimiento_terreno, id_estado FROM seguimiento_terreno WHERE cod_seguimiento = $1";
                $existeSeg = $obj->select($sql_validar_seg, [$codSeg]);

                if (empty($existeSeg)) {
                    $errores[] = "No existe ningún seguimiento registrado con ese código.";
                } elseif ($existeSeg[0]['id_estado'] != 1) {
                    $errores[] = "Lo siento, el seguimiento no está activo.";
                } else {
                    $id_seguimiento_terreno = $existeSeg[0]['id_seguimiento_terreno'];
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
                redirect(getUrl("FormularioSiem", "FormularioSiem", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades_terreno.";
            }
        }
    }
}
?>