<?php

include_once'../model/ActividadZoocriadero/ActividadZoocriaderoModel.php';

class ActividadZoocriaderoController{


public function getRegistrar(){


include_once '../view/partials/ActividadZoocriadero/Registrar.php';


}


public function postRegistrar(){

    $obj =new ActividadZoocriaderoModel();

    $codigo=$_POST['cod_actividad'];
    $nombre=$_POST['nombre_actividad'];
    $estado= 1;

    $sql="INSERT INTO actividad_zoocriadero (cod_actividad, nombre_actividad, id_estado) VALUES
    ('$codigo','$nombre','$estado')";

      $ejecutar = $obj->insert($sql);

             if($ejecutar){
                redirect(getUrl("ActividadZoocriadero","ActividadZoocriadero","getConsultar"));
             }else{
                 echo "No se pudo registrar la ciudad";
             }

    

}





}

?>