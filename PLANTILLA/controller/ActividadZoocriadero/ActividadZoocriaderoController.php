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

public function getConsultar(){
    
include_once'../view/partials/ActividadZoocriadero/Consultar.php';

}


public function getDatos(){

$obj=new ActividadZoocriaderoModel();

$sql="SELECT a.id_actividad_zoo,
            a.cod_actividad,
            a.nombre_actividad,
            e.nombre_estado
            
            FROM actividad_zoocriadero a
            INNER JOIN estado e 
            ON a.id_estado=e.id_estado";

$datos= $obj ->select($sql);

return $datos;

}


}

?>