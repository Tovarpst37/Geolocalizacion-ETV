<?php

include_once '../model/FormularioM/FormulariosModel.php';
class FormularioMController
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

        include_once '../view/partials/FormularioM/registrar.php';
    }
    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            // Capturar los datos recibidos del formulario
            $codM = $_POST['codM'] ?? '';
            $docM = $_POST['docM'] ?? '';
            $canpez = $_POST['canpez'] ?? 0;
            $muerto_Macho = $_POST['muerto_Macho'] ?? 0;
            $muerto_Hembra = $_POST['muerto_Hembra'] ?? 0;
            $ob = $_POST['obM'] ?? '';   // <-- corregido: era 'ob'

            // Valores por defecto: no vienen del formulario
            $fecha = date('Y-m-d');
            $tipoAlimento = 'Sin especificar';
            $genero = 'Sin especificar';

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

                // Ojo: se quitó la coma sobrante antes del paréntesis de cierre
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

            // 2. Guardar el detalle de la actividad
            if ($id_seguimiento_zoo) {
                $sqlSub = "INSERT INTO sub_actividades 
           (tipo_alimento, fecha, genero, observaciones, 
            can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, 
            estregar_paredes, aspirar, succionador, adicion_nivel_agua, 
            medicion_ph, medicion_temperatura, estado_tanque, agua_cambiada, 
            id_estado, id_seguimiento_zoo, cod_seguimiento) 
           VALUES 
           ('$tipoAlimento', '$fecha', '$genero', '$ob', 
            '$muerto_Hembra', '$muerto_Macho', '$canpez', 
            false, false, false, 0, 
            0, 0, 'Sin especificar', 0, 
            1, $id_seguimiento_zoo, '$codM')";

                $resSub = $obj->insert($sqlSub);

                if ($resSub) {
                    redirect(getUrl("FormularioM", "FormularioM", "getRegistrar"));
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