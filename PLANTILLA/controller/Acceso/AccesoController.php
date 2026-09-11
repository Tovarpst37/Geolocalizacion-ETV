<?php 

include_once '../model/Acceso/AccesoModel.php';

class AccesoController{

    public function login(){
        $obj = new AccesoModel();
        $documento = $_POST['documento'];
        $password = $_POST['password'];
        echo $documento;
        echo $password;
        $data = "todo melo";
        echo "<script>console.log('$data');</script>";
        /*$sql = "SELECT * FROM usuarios WHERE documento = '$documento' AND contrasena = '$password'";
        $usuario = $obj-> select($sql);
        if(pg_num_rows($usuario) > 0){
            echo "excelente socio";
            $_SESSION[''] = $usu[''];
        }else{
            $SESSION['error'] = "usuario o contrasena incorrectos";
            echo "paila socio";
        }
        */
    }

    public function logout(){

    }

}

?>