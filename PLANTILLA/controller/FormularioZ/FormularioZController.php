<?php

include_once '../model/FormularioZ/FormulariosModel.php';

class FormularioZController
{
    public function getRegistrar()
    {
        $obj = new FormulariosModel();

        $sql = "SELECT * FROM seguimiento_zoocriadero";
        $seguimientos = $obj->select($sql);

        $sql1 = "SELECT * FROM usuarios";
        $numDocumen = $obj->select($sql1);

        include_once '../model/FormularioZ/tipoPez.php';
        include_once '../model/FormularioZ/tipoAlimen.php';

        $sql4 = "SELECT * FROM sub_actividades";
        $observaciones = $obj->select($sql4);

        include_once '../view/partials/Formularioz/registrar.php';
    }

    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            // Capturar los datos recibidos del formulario
            $codigose = $_POST['codigose'] ?? '';
            $documen = $_POST['documen'] ?? '';
            $fecha_hora = $_POST['fecha_hora'] ?? '';
            $tipo_pez = $_POST['tipo_pez'] ?? '';
            $tipo_alimen = $_POST['tipo_alimen'] ?? '';
            $ob = $_POST['ob'] ?? '';

            // Formatear la fecha
            $fecha_array = explode(" ", $fecha_hora);
            $fecha = !empty($fecha_array[0]) ? $fecha_array[0] : date('Y-m-d');
            $hora = !empty($fecha_array[1]) ? $fecha_array[1] : date('H:i:s');

            // 1. Consultar si el codigo de seguimiento ya existe en la base de datos
            $sqlExiste = "SELECT id_seguimiento_zoo, cod_seguimiento 
                      FROM seguimiento_zoocriadero 
                      WHERE cod_seguimiento = '$codigose'";
            $existe = $obj->select($sqlExiste);

            $id_seguimiento_zoo = null;

            if (!empty($existe)) {
                // SI EXISTE: Tomamos el ID del seguimiento encontrado
                $id_seguimiento_zoo = $existe[0]['id_seguimiento_zoo'];
            } else {
                // NO EXISTE: Buscamos usuario y tanque por defecto para registrarlo[cite: 2]
                $sqlUser = "SELECT id_usuario FROM usuarios WHERE documento = '$documen'";
                $userResult = $obj->select($sqlUser);
                $id_usuario = !empty($userResult) ? $userResult[0]['id_usuario'] : 1;

                $sqlTanque = "SELECT id_tanque FROM tanque LIMIT 1";
                $tanqueResult = $obj->select($sqlTanque);
                $id_tanque = !empty($tanqueResult) ? $tanqueResult[0]['id_tanque'] : 1;

                // Creamos el nuevo registro en seguimiento_zoocriadero[cite: 2]
                $sqlInsertSeg = "INSERT INTO seguimiento_zoocriadero 
                             (cod_seguimiento, fecha, id_tanque, id_usuario, id_estado, hora_inicio) 
                             VALUES ('$codigose', '$fecha', $id_tanque, $id_usuario, 1, '$hora') 
                             RETURNING id_seguimiento_zoo";

                $resSeg = $obj->insert($sqlInsertSeg);

                if ($resSeg) {
                    // En PostgreSQL RETURNING o la consulta nos da el id insertado
                    $nuevoSeg = $obj->select("SELECT id_seguimiento_zoo FROM seguimiento_zoocriadero WHERE cod_seguimiento = '$codigose'");
                    $id_seguimiento_zoo = $nuevoSeg[0]['id_seguimiento_zoo'];
                }
            }

            // 2. Guardar el detalle de la actividad asociando el codigo de seguimiento existente/creado[cite: 2]
            if ($id_seguimiento_zoo) {
                // Definimos solo los campos recibidos y completamos los requeridos NOT NULL de la base de datos con valores por defecto neutros
                $sqlSub = "INSERT INTO sub_actividades 
               (tipo_alimento, fecha, genero, observaciones, 
                can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, 
                estregar_paredes, aspirar, succionador, adicion_nivel_agua, 
                medicion_ph, medicion_temperatura, estado_tanque, agua_cambiada, 
                id_estado, id_seguimiento_zoo, cod_seguimiento) 
               VALUES 
               ('$tipo_alimen', '$fecha', '$tipo_pez', '$ob', 
                0, 0, 0, 
                false, false, false, 0, 
                0, 0, 'Sin especificar', 0, 
                1, $id_seguimiento_zoo, '$codigose')";

                $resSub = $obj->insert($sqlSub);

                if ($resSub) {
                    redirect(getUrl("FormularioZ", "FormularioZ", "getRegistrar"));
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