<?php

include_once '../model/FormularioInsp/FormulariosModel.php';

class FormularioInspController
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

        include_once '../view/partials/FormularioInsp/registrar.php';
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codSeg = trim($_POST['codSeg'] ?? '');
            $documen = trim($_SESSION['documento'] ?? '');
            $fechaHora = $_POST['fecha_horaInsp'] ?? '';
            $depositoDetRaw = $_POST['depositoDetectado'] ?? '';
            $phMedido = $_POST['phMedido'] ?? '';
            $temperatura = $_POST['temperatura'] ?? '';
            $presenciaLarvasRaw = $_POST['presenciaLarvas'] ?? '';
            $obser = trim($_POST['obserInsp'] ?? '');
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
                $errores[] = "La fecha y hora de inspección son obligatorias.";
            }

            if ($depositoDetRaw !== '0' && $depositoDetRaw !== '1') {
                $errores[] = "Debe indicar si se detectaron depósitos permanentes de agua.";
            }

            if ($phMedido === '' || !is_numeric($phMedido)) {
                $errores[] = "El PH medido es obligatorio y debe ser un número válido.";
            } elseif ($phMedido < 0 || $phMedido > 14) {
                $errores[] = "El PH medido debe estar entre 0 y 14.";
            }

            if ($temperatura === '' || !is_numeric($temperatura)) {
                $errores[] = "La temperatura medida es obligatoria y debe ser un número válido.";
            }

            if ($presenciaLarvasRaw !== '0' && $presenciaLarvasRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de larvas de zancudos.";
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
                ErrorModal::verError($errores, getUrl('FormularioInsp', 'FormularioInsp', 'getRegistrar'));
                return;
            }

            // 6. Todo válido: se procede a insertar
            $depositoDet = $depositoDetRaw === '1' ? 'true' : 'false';
            $presenciaLarv = $presenciaLarvasRaw === '1' ? 'true' : 'false';

            $sqlSub = "INSERT INTO sub_actividades_ter
               (fecha_inspeccion, deposito_agua_detectado, ph_medido, temperatura, 
                presencia_larvas_inspeccion, obser_inspeccion, 
                id_estado, id_seguimiento_terreno, cod_seguimiento) 
               VALUES 
               ($1, $2, $3, $4, 
                $5, $6, 
                1, $7, $8)
               RETURNING id_sub_actividad";

            $resSub = $obj->select($sqlSub, [
                $fechaHora,
                $depositoDet,
                $phMedido,
                $temperatura,
                $presenciaLarv,
                $obser,
                $id_seguimiento_terreno,
                $codSeg
            ]);

            if (!empty($resSub)) {
                redirect(getUrl("FormularioInsp", "FormularioInsp", "getRegistrar"));
            } else {
                echo "Error al guardar el detalle en sub_actividades_terreno.";
            }
        }
    }
}
?>