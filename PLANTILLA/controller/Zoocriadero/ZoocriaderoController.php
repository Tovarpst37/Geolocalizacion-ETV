<?php

    include_once '../model/Zoocriadero/ZoocriaderoModel.php';

    Class ZoocriaderoController{


        
    public function getRegistrar(){

        $obj = new ZoocriaderoModel();

         $sql3 = "SELECT * from estado";

         $estados = $obj ->select($sql3);

         $sql = "SELECT * from usuarios WHERE id_rol = 3";

         $usuarios = $obj -> select($sql);
         

        include_once '../view/partials/Zoocriadero/Registrar.php';
    }

    public function postRegistrar(){

        $obj = new ZoocriaderoModel();

        $codigo = $_POST['codigo_zoocriadero'];
        $direccion = $_POST['direccion'];
        $usuario = $_POST['id_usuario'];
        $estado = $_POST['id_estado'];

        $sql = "INSERT into zoocriadero (cod_zoocriadero,direcciom,id_usuario,id_estado) VALUES ('$codigo','$direccion','$usuario','$estado')";
        $ejecutar  = $obj -> update($sql);

        if($ejecutar){
                redirect(getUrl("Tanque","Tanque","getConsultar"));
            }else{
                echo "No se pudo registrar la ciudad";
            };

        

    }

    }

?>