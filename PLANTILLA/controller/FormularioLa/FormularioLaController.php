<?php

include_once '../model/FormularioLa/FormulariosModel.php';
class FormularioLaController
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

        include_once '../view/partials/FormularioLa/registrar.php';
    }

    private function getOrCreateActividadZoo($obj, $nombre, $codigoDefault)
    {
        $sqlBuscar = "SELECT id_actividad_zoo FROM actividad_zoocriadero WHERE nombre_actividad = '$nombre'";
        $res = $obj->select($sqlBuscar);

        if (!empty($res)) {
            return $res[0]['id_actividad_zoo'];
        }

        $sqlCrear = "INSERT INTO actividad_zoocriadero (cod_actividad, nombre_actividad, id_estado) 
                     VALUES ('$codigoDefault', '$nombre', 1) 
                     RETURNING id_actividad_zoo";
        $creado = $obj->select($sqlCrear);

        return !empty($creado) ? $creado[0]['id_actividad_zoo'] : null;
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $codM = $_POST['codLa'] ?? '';
            $docM = $_POST['docLa'] ?? '';
            $fechaHora = $_POST['fecha_horaLa'] ?? date('Y-m-d H:i:s');
            $porcAgua = $_POST['porcAgua'] ?? 0;
            $estadoTanque = $_POST['estadoTanque'] ?? '';
            $obser = $_POST['obLa'] ?? '';

            $sqlExiste = "SELECT id_seguimiento_zoo, cod_seguimiento 
                      FROM seguimiento_zoocriadero 
                      WHERE cod_seguimiento = '$codM'";
            $existe = $obj->select($sqlExiste);

            $id_seguimiento_zoo = null;

            if (!empty($existe)) {
                $id_seguimiento_zoo = $existe[0]['id_seguimiento_zoo'];
            } else {
                $sqlUser = "SELECT id_usuario FROM usuarios WHERE documento = '$docM'";
                $userResult = $obj->select($sqlUser);
                $id_usuario = !empty($userResult) ? $userResult[0]['id_usuario'] : 1;

                $sqlTanque = "SELECT id_tanque FROM tanque LIMIT 1";
                $tanqueResult = $obj->select($sqlTanque);
                $id_tanque = !empty($tanqueResult) ? $tanqueResult[0]['id_tanque'] : 1;

                $sqlInsertSeg = "INSERT INTO seguimiento_zoocriadero 
                             (cod_seguimiento, id_tanque, id_usuario, id_estado) 
                             VALUES ('$codM', $id_tanque, $id_usuario, 1) 
                             RETURNING id_seguimiento_zoo";

                $resSeg = $obj->insert($sqlInsertSeg);

                if ($resSeg) {
                    $nuevoSeg = $obj->select("SELECT id_seguimiento_zoo FROM seguimiento_zoocriadero WHERE cod_seguimiento = '$codM'");
                    $id_seguimiento_zoo = $nuevoSeg[0]['id_seguimiento_zoo'];
                }
            }

            if ($id_seguimiento_zoo) {
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
                NULL, NULL, NULL, NULL, NULL, 
                '$estadoTanque', $porcAgua, '$fechaHora', '$obser', 
                1, $id_seguimiento_zoo, '$codM')
               RETURNING id_sub_actividad";

                $resSub = $obj->select($sqlSub);

                if (!empty($resSub)) {
                    $id_sub_actividad = $resSub[0]['id_sub_actividad'];

                    $id_actividad_zoo = $this->getOrCreateActividadZoo($obj, 'Lavado', 'LAV001');
                    if ($id_actividad_zoo) {
                        $obj->insert("INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) 
                                      VALUES ($id_actividad_zoo, $id_sub_actividad)");
                    }

                    redirect(getUrl("FormularioLa", "FormularioLa", "getRegistrar"));
                } else {
                    echo "Error al guardar el detalle en sub_actividades.";
                }
            } else {
                echo "Error al procesar el código de seguimiento.";
            }
        }
    }
}
?>