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
                redirect(getUrl("Zoocriadero","Zoocriadero","getConsultar"));
            }else{
                echo "No se pudo registrar la ciudad";
            };

        

    }

    public function getConsultar(){

        $obj = new ZoocriaderoModel();
        $sql = "SELECT * from zoocriadero";
        $zoocriaderos = $obj -> select($sql);

        include_once '../view/partials/Zoocriadero/Consultar.php';
    
    }

    public function getEditar(){

        include_once '../view/partials/Zoocriadero/Editar.php';
    }

    public function postDelete(){

        $obj = new ZoocriaderoModel();
        $id = $_GET['id'];

        $sql2 = "SELECT id_estado from zoocriadero WHERE id_zoocriadero = $id";
        $ejecutar2 = $obj->select($sql2);
        foreach($ejecutar2 as $s){
            
        
        if($s['id_estado'] == 2){
                
                echo '<script>alert("¡Este zoocriadero ya esta inhabilitado!");</script>';
                redirect(getUrl("Zoocriadero","Zoocriadero","getConsultar"));
            
        }else if($s['id_estado'] == 1){
            $sql = "UPDATE zoocriadero SET id_estado = 2 WHERE id_zoocriadero = $id";

        $ejecutar = $obj->delete($sql);
         if ($ejecutar){
            $_SESSION['mensaje_exito'] = "El Zoocriadero se inhabilito correctamente.";
                redirect(getUrl("Zoocriadero","Zoocriadero","getConsultar"));
            }else{
                echo "No se pudo inhabilitar el tanque";
            }
        }
        }

        

            

            
        }

    }

?>