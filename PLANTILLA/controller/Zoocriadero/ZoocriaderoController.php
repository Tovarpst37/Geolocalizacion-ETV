<?php

    include_once '../model/Zoocriadero/ZoocriaderoModel.php';

    Class ZoocriaderoController{


        
    public function getRegistrar(){

        $obj = new ZoocriaderoModel();

         $sql3 = "SELECT * from estado";

         $estados = $obj ->select($sql3);

         $sql = "SELECT * from usuarios WHERE id_rol = 2";

         $usuarios = $obj -> select($sql);
         

        include_once '../view/partials/Zoocriadero/Registrar.php';
    }

    public function postRegistrar(){

        $obj = new ZoocriaderoModel();

        $codigo = mb_strtoupper($_POST['codigo_zoocriadero']);
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
        $sql = "SELECT * FROM zoocriadero ORDER BY id_zoocriadero";
        $zoocriaderos = $obj -> select($sql);

        include_once '../view/partials/Zoocriadero/Consultar.php';
    
    }

    public function getEditar(){
        $id = $_GET['id'];
    $obj = new ZoocriaderoModel();

    $sql = "SELECT * from zoocriadero WHERE id_zoocriadero = $id";
    $datos = $obj -> select($sql);

     $sql1 = "SELECT * from tipo_tanque";

         $tiposTanque = $obj ->select($sql1);


         $sql3 = "SELECT * from estado";

         $estados = $obj ->select($sql3);

         $sql3 = "SELECT * from usuarios";

         $usuario = $obj ->select($sql3);


        include_once '../view/partials/Zoocriadero/Editar.php';
    }


    public function postUpdate(){



        $codigo = mb_strtoupper($_POST['cod_zoocriadero']);
        $direccion = $_POST['direccion'];
        $estado = $_POST['id_estado'];
        $id = $_POST['id'];
        $usuario = $_POST['id_usuario'];
        $obj = new ZoocriaderoModel();
        


        
            $sql = "UPDATE zoocriadero SET 
                        cod_zoocriadero = '$codigo', 
                        direcciom = '$direccion', 
                        id_usuario = '$usuario', 
                        id_estado = '$estado'
                    WHERE id_zoocriadero = '$id'";
            
            $ejecutar = $obj->update($sql);
            
                
           
            if($ejecutar){
                 $_SESSION['mensaje_exito'] = "El Zoocriadero se actualizó correctamente.";
                redirect(getUrl("Zoocriadero","zoocriadero","getConsultar"));
            }else{
                echo "No se pudo registrar la ciudad";
            };

        

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



        public function getBuscar(){

    $obj = new ZoocriaderoModel();
    $busqueda = mb_strtoupper($_GET['busqueda'] ?? '');

       $sql = "SELECT * FROM zoocriadero z
        WHERE z.cod_zoocriadero ILIKE '%$busqueda%'
        ORDER BY z.id_zoocriadero";

        $zoocriaderos= $obj ->select($sql);

    include_once "../view/partials/Zoocriadero/Busqueda.php";


            

    }

    }

?>