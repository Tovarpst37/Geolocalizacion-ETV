<?php

include_once '../model/Reportes/ReportesAeguimiento.php';


class ReportesController{

    public function report(){
        
        $obj= new ReportesAeguimiento();
        $zoocriaderos = $obj->getZoocriaderos();
        $actividades = $obj->getActividad_zoocriadero();
        $getFechaInicio = $obj -> getFechaInicio();

        include_once '../view/reportes/reportes.php';
    }
}






?>