<?php

include_once'../model/ActividadTerreno/ActividadTerrenoModel.php';

class ActividadTerrenoController{


public function getRegistrar(){


include_once '../view/partials/ActividadTerreno/Registrar.php';


}


public function postRegistrar(){

    $obj =new ActividadTerrenoModel();

    $codigo=$_POST['cod_actividad_terreno'];
    $nombre=$_POST['nombre_actividad'];
    $estado= 1;

    $sql="INSERT INTO actividad_Terreno (cod_actividad_terreno, nombre_actividad, id_estado) VALUES
    ('$codigo','$nombre','$estado')";

      $ejecutar = $obj->insert($sql);

             if($ejecutar){
                redirect(getUrl("ActividadTerreno","ActividadTerreno","getConsultar"));
             }else{
                 echo "No se pudo registrar la actividad de terreno";
             }

    

}

public function getConsultar(){
    
include_once'../view/partials/ActividadTerreno/Consultar.php';

}


public function getDatos(){

$obj=new ActividadTerrenoModel();

$sql="SELECT a.id_actividad_Terreno,
            a.cod_actividad_terreno,
            a.nombre_actividad,
            e.nombre_estado
            
            FROM actividad_Terreno a
            INNER JOIN estado e 
            ON a.id_estado=e.id_estado";

$datos= $obj ->select($sql);

return $datos;

}


}

?>