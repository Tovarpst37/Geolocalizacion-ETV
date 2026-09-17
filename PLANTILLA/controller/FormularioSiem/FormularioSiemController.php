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

        include_once '../view/partials/FormularioSiem/registrar.php';
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codSeg = $_POST['codSeg'] ?? '';
            $documen = $_POST['documen'] ?? '';
            $fechaHora = $_POST['fecha_horaSiem'] ?? date('Y-m-d H:i:s');
            $pecesEmpacados = $_POST['pecesEmpacados'] ?? 0;
            $tiempoAclimat = $_POST['tiempoAclimat'] ?? 0;
            $hembrasSembradas = $_POST['hembrasSembradas'] ?? 0;
            $machosSembrados = $_POST['machosSembrados'] ?? 0;
            $litrosAgua = $_POST['litrosAgua'] ?? 0;
            $presenciaLarv = ($_POST['presenciaLarvas'] ?? '0') == '1' ? 'true' : 'false';
            $presenciaPec = ($_POST['presenciaPeces'] ?? '0') == '1' ? 'true' : 'false';
            $obser = $_POST['obserSiem'] ?? '';

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

            // 2. Guardar el detalle de la siembra
            if ($id_seguimiento_terreno) {
                $sqlSub = "INSERT INTO sub_actividades_ter
               (fecha_siembra, can_peces_empacados, tiempo_aclimatacion, 
                can_hembras_sembradas, can_machos_sembrados, litros_utilizados, 
                presencia_larvas_siembra, presencia_peces_siembra, obser_siembra, 
                id_estado, id_seguimiento_terreno, cod_seguimiento) 
               VALUES 
               ('$fechaHora', $pecesEmpacados, $tiempoAclimat, 
                $hembrasSembradas, $machosSembrados, $litrosAgua, 
                $presenciaLarv, $presenciaPec, '$obser', 
                1, $id_seguimiento_terreno, '$codSeg')
               RETURNING id_sub_actividad";

                $resSub = $obj->select($sqlSub);

                if (!empty($resSub)) {
                    redirect(getUrl("FormularioSiem", "FormularioSiem", "getRegistrar"));
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