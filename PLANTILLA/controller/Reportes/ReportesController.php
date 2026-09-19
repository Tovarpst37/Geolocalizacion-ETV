<?php

include_once '../model/Reportes/ReporteSeguimientoModel.php';


class ReportesController{

    public function report(){
        
        
            $obj=new ReporteSeguimientoModel();


        $zoocriadero= $obj ->select("SELECT id_zoocriadero, cod_zoocriadero FROM
        zoocriadero ORDER BY cod_zoocriadero");

        
        $actividades= $obj ->select("SELECT id_actividad_zoo, cod_actividad FROM
        actividad_zoocriadero ORDER BY cod_actividad");




        //name de los input del formularios
        $filtroZoo= $_GET['zoocriadero'] ?? '';
        $filtroActividad= $_GET['actividad'] ?? '';
        $filtroFechaIni= $_GET['fecha_inicio'] ?? '';
        $filtroFechaFin= $_GET['zoocrfecha_fin'] ?? '';


        // llama al metodo de validar fechas
        $errores =$this ->validarFiltros($filtroFechaIni,$filtroFechaFin);


        if(!empty($errores)){

            //si hay errores no se consulta

            $seguimientos=[];
            

        }else{
            $seguimientos= $this->consultarSeguimiento(
               $obj, $filtroZoo, $filtroActividad, $filtroFechaIni, $filtroFechaFin  
            );



            if(empty($seguimientos)){

                $errores[]= "No se encontraron registro con los filtros de busqueda
                seleccionados";
            }


            $mensajeError=!empty($errores) ? implode('', $errores) : null



        }





        include_once '../view/reportes/reportes.php';
    }
}






?>