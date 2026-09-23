<?php
include_once '../model/TipoTanque/TipoTanqueModel.php';

class TipoTanqueController{

    public function getCreate(){
        include_once '../view/TipoTanque/create.php';
    }

    public function postCreate(){
        $obj = new TipoTanqueModel();
        $nombre_tanque = $_POST['nombre_tipo_tanque'];
        $descripcion = $_POST['descripcion_tipo_tanque'] ?? '';
        $id = $obj->autoincrement("tipo_tanque", "id_tipo_tanque");
    
        $sql = "INSERT INTO tipo_tanque (id_tipo_tanque,nombre_tipo_tanque,descripcion) OVERRIDING SYSTEM VALUE
        VALUES ($id,'$nombre_tanque','$descripcion')";

        $ejecutable = $obj->insert($sql);
        
    }

    public function getTipoTanque(){
        
      
    }

    public function getList(){
        $obj = new TipoTanqueModel();
        $sql = "SELECT * FROM tipo_tanque ORDER BY id_tipo_tanque;";
        $tipo_tanque = $obj->select($sql);
        
        if(empty($tipo_tanque)){
            include_once '../view/TipoTanque/notExist.php';
        }else{
            include_once '../view/TipoTanque/list.php';
        }
    }

    public function cambiar(){

    }

    public function editar(){
        $obj = new TipoTanqueModel();

        $id = $_POST['id_tipo_tanque'];
        $nombre_tanque = $_POST['nombre_tipo_tanque'];
        $descripcion = $_POST['descripcion_tipo_tanque'] ?? '';

        $sql = "UPDATE tipo_tanque
                SET nombre_tipo_tanque = '$nombre_tanque',
                    descripcion = '$descripcion'
                WHERE id_tipo_tanque = $id";

        $ejecutable = $obj->update($sql);

        header("Location: " . getUrl("TipoTanque","TipoTanque","getList"));
        exit;
    }
}

?>