<?php

include_once '../model/FormularioZ/FormulariosModel.php';
class FormularioZController
{

    public function getRegistrar()
    {
        $obj = new FormulariosModel();

        $sql = "SELECT * FROM seguimiento_zoocriadero ";
        $seguimientos = $obj->select($sql);

        $sql1 = "SELECT * FROM usuarios";
        $numDocumen = $obj->select($sql);

        include_once '../model/FormularioZ/tipoPez.php';

        include_once '../model/FormularioZ/tipoAlimen.php';

        $sql4 = "SELECT * FROM sub_actividades";
        $observaciones = $obj->select($sql);


        include_once '../view/partials/Formularioz/registrar.php';
    }

    public function postInsert(string $codigo_seguimiento, string $documen, int $fec, string $tipoPez, string $tipoAlimentacion, $observaciones, FormulariosModel $obj)
    {

        $codigo_segui = mb_strtoupper($codigo_seguimiento);
        $documento = $documen;
        $fecha = $fec;
        $tipoP = $tipoPez;
        $alimen = $tipoAlimentacion;
        $obser = $observaciones;




        $sql = "INSERT INTO  sub_actividades(fecha,  tipo_alimento, tipo_pez, observaciones) 
        VALUES ('$fecha', '$alimen', $tipoP, $obser)";

        $ejecutar = $obj->insert($sql);

        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "Se registro correctamente.";
            redirect(getUrl("Sitios", "Sitios", "getConsultar"));
        } else {
            echo "No se registro";
        }
    }



}

?>