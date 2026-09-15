<?php

include_once '../model/FormularioLi/FormulariosModel.php';
class FormularioLiController
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

        include_once '../view/partials/FormularioLi/registrar.php';
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            // Capturar los datos recibidos del formulario
            $codM = $_POST['coLi'] ?? '';
            $docM = $_POST['docLi'] ?? '';
            $fechaHora = $_POST['fecha_horaLi'] ?? date('Y-m-d H:i:s');
            $obser = $_POST['obserLi'] ?? '';

            // Checkboxes de tipo de limpieza -> columnas boolean reales
            $estregarParedes = isset($_POST['estregarParedes']) ? 'true' : 'false';
            $aspirar = isset($_POST['aspirar']) ? 'true' : 'false';
            $succionador = isset($_POST['succionador']) ? 'true' : 'false';


            // Campos que este formulario no captura: valores neutros por defecto
            $genero = 'Sin especificar';
            $tipoAlimento = 'Sin especificar';
            $canpez = 0;
            $muerto_Macho = 0;
            $muerto_Hembra = 0;
            $aguaCambiada = 0;

            // 1. Consultar si el codigo de seguimiento ya existe en la base de datos
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

            // 2. Guardar el detalle de la actividad de limpieza
            if ($id_seguimiento_zoo) {
                $sqlSub = "INSERT INTO sub_actividades 
               (tipo_alimento, fecha, genero, observaciones, 
                can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, 
                estregar_paredes, aspirar, succionador, adicion_nivel_agua, 
                medicion_ph, medicion_temperatura, estado_tanque, agua_cambiada, 
                id_estado, id_seguimiento_zoo, cod_seguimiento) 
               VALUES 
               ('$tipoAlimento', '$fechaHora', '$genero', '$obser', 
                '$muerto_Hembra', '$muerto_Macho', '$canpez', 
                $estregarParedes, $aspirar, $succionador, 0, 
                0, 0, 'Sin especificar', $aguaCambiada, 
                1, $id_seguimiento_zoo, '$codM')";

                $resSub = $obj->insert($sqlSub);

                if ($resSub) {
                    redirect(getUrl("FormularioLi", "FormularioLi", "getRegistrar"));
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