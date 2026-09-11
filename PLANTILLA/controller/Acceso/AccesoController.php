<?php 

include_once '../model/Acceso/AccesoModel.php';

class AccesoController{

    public function login(){

        $obj = new AccesoModel();

        $documento = $_POST['documento'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM usuarios WHERE documento = '$documento' AND contrasena = '$password'";
        $usuario = $obj-> select($sql);

        if(pg_num_rows($usuario) > 0){
            while(pg_num_rows($usuario)){
                $_SESSION[''] = $usu[''];
                $_SESSION[''] = $usu[''];
                $_SESSION[''] = $usu[''];
            }
            redirect("index.php");
        }else{
            $_SESSION['error'] = "Usuario o contrasena incorrectos";
            redirect("login.php");
        }
        
    }

    public function logout(){

    }

}

?>