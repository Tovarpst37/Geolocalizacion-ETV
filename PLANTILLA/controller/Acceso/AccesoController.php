<?php 

include_once '../model/Acceso/AccesoModel.php';

class AccesoController{

    public function login(){
        $obj = new AccesoModel();
        $documento = $_POST['documento'];
        $password = $_POST['password'];
        echo $documento;
        echo $password;
    }

    public function logout(){

    }

}

?>