<?php

        include_once '../model/Tanque/TanqueModel.php';
        

    class TanqueController{

    

    public function getConsultar(){

        include_once '../view/partials/Tanque/Consultar.php';
        
        

    }

    public function getRegistrar(){

         $obj = new TanqueModel();

         $sql = "SELECT * from tipo_tanque";

         $tiposTanque = $obj ->select($sql);

         $sql2 = "SELECT * from zoocriadero";

         $zoocriaderos = $obj ->select($sql2);

         $sql3 = "SELECT * from estado";

         $estados = $obj ->select($sql3);

        


        include_once '../view/partials/Tanque/Registrar.php';

    }

    public function postRegistrar(){

        $nombreArchivo = 'tanque_' . uniqid() . '.' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $carpetaDestino = __DIR__ . '/../../web/assets/img/';
        $rutaCompleta = $carpetaDestino . $nombreArchivo;
        move_uploaded_file($_FILES['img']['tmp_name'], $rutaCompleta);

        $tipo = $_POST['id_tipo_tanque'];
        $codigo = $_POST['codigo_tanque'];
        $zoocriadero = $_POST['id_zoocriadero'];
        $estado = $_POST['id_estado'];

        $obj = new TanqueModel();

         $sql = "INSERT INTO tanque (codigo_tanque, img, id_tipo_tanque, id_zoocriadero, id_estado)
                VALUES 
                ('$codigo', '$nombreArchivo', '$tipo', '$zoocriadero', '$estado')";

        $ejecutar = $obj->insert($sql);

            if($ejecutar){
                redirect(getUrl("Tanque","Tanque","getConsultar"));
            }else{
                echo "No se pudo registrar la ciudad";
            }

        

    }

    public function getDelete(){

        $id = $_GET['id'];
            include_once '../view/partials/Tanque/Eliminar.php';
        }

    public function postDelete(){

        $obj = new TanqueModel();
        $id = $_GET['id'];

        $sql2 = "SELECT id_estado from tanque WHERE id_tanque = $id";
        $ejecutar2 = $obj->select($sql2);
        foreach($ejecutar2 as $s){
            
        
        if($s['id_estado'] == 2){
                
                echo '<script>alert("¡Este tanque ya esta inhabilitado!");</script>';
                redirect(getUrl("Tanque","Tanque","getConsultar"));
            
        }else if($s['id_estado'] == 1){
            $sql = "UPDATE tanque SET id_estado = 2 WHERE id_tanque = $id";

        $ejecutar = $obj->delete($sql);
         if ($ejecutar){
                redirect(getUrl("Tanque","Tanque","getConsultar"));
            }else{
                echo "No se pudo inhabilitar el tanque";
            }
        }
        }

        

            

            
        }

    public function getEdit(){

    $id = $_GET['id'];
    $obj = new TanqueModel();

    $sql = "SELECT * from tanque WHERE id_tanque = $id";
    $datos = $obj -> select($sql);

     $sql1 = "SELECT * from tipo_tanque";

         $tiposTanque = $obj ->select($sql1);

         $sql2 = "SELECT * from zoocriadero";

         $zoocriaderos = $obj ->select($sql2);

         $sql3 = "SELECT * from estado";

         $estados = $obj ->select($sql3);
    
    include_once '../view/partials/Tanque/Editar.php';
}

public function postUpdate(){

        $nombreArchivo = 'tanque_' . uniqid() . '.' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $carpetaDestino = __DIR__ . '/../../web/assets/img/';
        $rutaCompleta = $carpetaDestino . $nombreArchivo;
        move_uploaded_file($_FILES['img']['tmp_name'], $rutaCompleta);

        $tipo = $_POST['id_tipo_tanque'];
        $codigo = $_POST['codigo_tanque'];
        $zoocriadero = $_POST['id_zoocriadero'];
        $estado = $_POST['id_estado'];
        $id = $_POST['id'];
        $obj = new TanqueModel();
        

        if($_FILES['img']['error'] === UPLOAD_ERR_OK){
            
            $sql2 = "UPDATE tanque SET 
                        codigo_tanque = '$codigo', 
                        img = '$nombreArchivo', 
                        id_tipo_tanque = '$tipo', 
                        id_zoocriadero = '$zoocriadero', 
                        id_estado = '$estado'
                    WHERE id_tanque = '$id'";
            
            $ejecutar = $obj->update($sql2);

            } else {
        
            $sql = "UPDATE tanque SET 
                        codigo_tanque = '$codigo', 
                        id_tipo_tanque = '$tipo', 
                        id_zoocriadero = '$zoocriadero', 
                        id_estado = '$estado'
                    WHERE id_tanque = '$id'";
            
            $ejecutar = $obj->update($sql);
            }
                

            if($ejecutar){
                redirect(getUrl("Tanque","Tanque","getConsultar"));
            }else{
                echo "No se pudo registrar la ciudad";
            };

        

}

        
        
    
    

    public function getDatos(){

        $obj = new TanqueModel();

       

        
        $sql = "SELECT 
                t.id_tanque,
                t.codigo_tanque,
                t.img,
                ti.nombre_tipo_tanque,
                z.cod_zoocriadero,
                z.direcciom,
                est.nombre_estado
                FROM tanque t
                INNER JOIN tipo_tanque ti ON t.id_tipo_tanque = ti.id_tipo_tanque
                INNER JOIN zoocriadero z ON t.id_zoocriadero = z.id_zoocriadero
                INNER JOIN estado est ON t.id_estado = est.id_estado";
        $tanque = $obj ->select($sql);

            return $tanque;
        

    }



    public function getBuscar(){

    $obj = new TanqueModel();
    $busqueda = $_GET['busqueda'] ?? '';

        $sql = "SELECT 
            t.id_tanque,
            t.codigo_tanque,
            t.img,
            ti.nombre_tipo_tanque,
            z.cod_zoocriadero,
            z.direcciom,
            est.nombre_estado
            FROM tanque t
            INNER JOIN tipo_tanque ti ON t.id_tipo_tanque = ti.id_tipo_tanque
            INNER JOIN zoocriadero z ON t.id_zoocriadero = z.id_zoocriadero
            INNER JOIN estado est ON t.id_estado = est.id_estado
            WHERE t.codigo_tanque ILIKE '%$busqueda%'";

        $tanque2 = $obj ->select($sql);

    include_once "../view/partials/Tanque/Busqueda.php";


            

    }

    public function getCant(){

        $obj = new TanqueModel();

        $sql = "SELECT * from tanque";
        $tanque = $obj ->select($sql);
        
        return count($tanque);

    }

    


    }

?>
