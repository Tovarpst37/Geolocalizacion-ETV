<?php 

include_once '../model/MasterModel.php';



class ReportesAeguimiento extends MasterModel{


    public function getZoocriaderos(){

    return $this->select("SELECT id_zoocriadero, cod_zoocriadero FROM actividad_zoocriadero");
        
    }

    public function getActividad_zoocriadero(){

        return $this ->select("SELECT id_actividad_zoo, cod_actividad FROM actividad_zoocriadero");
    }   

    



}



