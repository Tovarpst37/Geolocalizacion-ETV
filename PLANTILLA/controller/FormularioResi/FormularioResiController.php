<?php

include_once '../model/FormularioResi/FormulariosModel.php';

class FormularioResiController
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

        include_once '../view/partials/FormularioResi/registrar.php';
    }

    // Busca la actividad por nombre en actividad_terreno; si no existe, la crea.
    private function getOrCreateActividadTerreno($obj, $nombre)
    {
        $sqlBuscar = "SELECT id_actividad_terreno FROM actividad_terreno WHERE nombre_actividad = '$nombre'";
        $res = $obj->select($sqlBuscar);

        if (!empty($res)) {
            return $res[0]['id_actividad_terreno'];
        }

        $sqlCrear = "INSERT INTO actividad_terreno (nombre_actividad, id_estado) 
                     VALUES ('$nombre', 1) 
                     RETURNING id_actividad_terreno";
        $creado = $obj->select($sqlCrear);

        return !empty($creado) ? $creado[0]['id_actividad_terreno'] : null;
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codSeg = $_POST['codSeg'] ?? '';
            $documen = $_POST['documen'] ?? '';
            $fechaHora = $_POST['fecha_horaResi'] ?? date('Y-m-d H:i:s');
            $canHembras = $_POST['canHembras'] ?? 0;
            $canMachos = $_POST['canMachos'] ?? 0;
            $canGuppies = $_POST['canGuppies'] ?? 0;
            $presenciaLarv = ($_POST['presenciaLarvas'] ?? '0') == '1' ? 'true' : 'false';
            $presenciaPec = ($_POST['presenciaPeces'] ?? '0') == '1' ? 'true' : 'false';
            $obser = $_POST['obserResi'] ?? '';

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

            // 2. Guardar el detalle de la resiembra
            if ($id_seguimiento_terreno) {
                $sqlSub = "INSERT INTO sub_actividades_ter
               (fecha_resiembra, can_hembras_sembradas, can_machos_sembrados, can_peces_guppies_sembrados,
                presencia_larvas_resiembra, presencia_peces_resiembra, obser_resiembra, 
                id_estado, id_seguimiento_terreno, cod_seguimiento) 
               VALUES 
               ('$fechaHora', $canHembras, $canMachos, $canGuppies,
                $presenciaLarv, $presenciaPec, '$obser', 
                1, $id_seguimiento_terreno, '$codSeg')
               RETURNING id_sub_actividad";

                $resSub = $obj->select($sqlSub);

                if (!empty($resSub)) {
                    $id_sub_actividad = $resSub[0]['id_sub_actividad'];

                    // 3. Enlazar esta fila con la actividad "Resiembra" en la tabla puente
                    $id_actividad_terreno = $this->getOrCreateActividadTerreno($obj, 'Resiembra');

                    if ($id_actividad_terreno) {
                        $sqlBridge = "INSERT INTO actividad_ter_subactividades 
                                      (id_actividad_terreno, id_sub_actividades) 
                                      VALUES ($id_actividad_terreno, $id_sub_actividad)";
                        $obj->select($sqlBridge);
                    }

                    redirect(getUrl("FormularioResi", "FormularioResi", "getRegistrar"));
                } else {
                    echo "Error al guardar el detalle en sub_actividades_ter.";
                }
            } else {
                echo "Error al procesar el código de seguimiento.";
            }
        }
    }
}
?>