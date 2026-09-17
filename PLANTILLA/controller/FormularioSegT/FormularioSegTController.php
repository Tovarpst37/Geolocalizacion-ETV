<?php

include_once '../model/FormularioSegT/FormulariosModel.php';

class FormularioSegTController
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

        include_once '../view/partials/FormularioSegT/registrar.php';
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codSeg = $_POST['codSeg'] ?? '';
            $documen = $_POST['documen'] ?? '';
            $fechaHora = $_POST['fecha_horaSeg'] ?? date('Y-m-d H:i:s');
            $numeroVisita = $_POST['numeroVisita'] ?? 1;
            $depositoVis = ($_POST['depositoVisitado'] ?? '0') == '1' ? 'true' : 'false';
            $presenciaLarv = ($_POST['presenciaLarvas'] ?? '0') == '1' ? 'true' : 'false';
            $presenciaPec = ($_POST['presenciaPeces'] ?? '0') == '1' ? 'true' : 'false';
            $obser = $_POST['obserSeg'] ?? '';

            // 1. Consultar si el codigo de seguimiento ya existe
            $sqlExiste = "SELECT id_seguimiento_terreno, cod_seguimiento 
                      FROM seguimiento_terreno 
                      WHERE cod_seguimiento = '$codSeg'";
            $existe = $obj->select($sqlExiste);

            $id_seguimiento_terreno = null;

            if (!empty($existe)) {
                $id_seguimiento_terreno = $existe[0]['id_seguimiento_terreno'];
            } else {
                $sqlUser = "SELECT id_usuario FROM usuarios WHERE documento = '$documen'";
                $userResult = $obj->select($sqlUser);
                $id_usuario = !empty($userResult) ? $userResult[0]['id_usuario'] : 1;

                $sqlSitio = "SELECT id_sitio FROM sitio LIMIT 1";
                $sitioResult = $obj->select($sqlSitio);
                $id_sitio = !empty($sitioResult) ? $sitioResult[0]['id_sitio'] : 1;

                $sqlInsertSeg = "INSERT INTO seguimiento_terreno 
                             (cod_seguimiento, fecha, id_sitio, id_usuario, id_estado) 
                             VALUES ('$codSeg', CURRENT_DATE, $id_sitio, $id_usuario, 1) 
                             RETURNING id_seguimiento_terreno";

                $resSeg = $obj->select($sqlInsertSeg);

                if (!empty($resSeg)) {
                    $id_seguimiento_terreno = $resSeg[0]['id_seguimiento_terreno'];
                }
            }

            // 2. Guardar el detalle del seguimiento
            if ($id_seguimiento_terreno) {
                $sqlSub = "INSERT INTO sub_actividades_ter
               (fecha_seguimiento, numero_visita, deposito_agua_visitado, 
                presencia_larvas_seguimiento, presencia_peces_seguimiento, obser_seguimiento, 
                id_estado, id_seguimiento_terreno, cod_seguimiento) 
               VALUES 
               ('$fechaHora', $numeroVisita, $depositoVis, 
                $presenciaLarv, $presenciaPec, '$obser', 
                1, $id_seguimiento_terreno, '$codSeg')
               RETURNING id_sub_actividad";

                $resSub = $obj->select($sqlSub);

                if (!empty($resSub)) {
                    redirect(getUrl("FormularioSegT", "FormularioSegT", "getRegistrar"));
                } else {
                    echo "Error al guardar el detalle en sub_actividades_terreno.";
                }
            } else {
                echo "Error al procesar el código de seguimiento.";
            }
        }
    }
}
?>