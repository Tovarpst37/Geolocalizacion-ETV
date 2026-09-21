<?php
    include_once '../model/LogicaNegocio/Hash.php';
    include_once '../model/MasterModel.php';

class CambiarContrasenaController{

    public function vsUpdatePassword(){
        include_once '../view/CambiarContrasena/CambiarContrasena.php';
    }

    public function updatePassword(){
        $obj = new MasterModel();
        $nuevaContrasena = Hash::encripHash($_POST['password']);
        $id_usuario = $_SESSION['id_usuario'];
        $sql = "UPDATE usuarios SET contraseña = '$nuevaContrasena' WHERE id_usuario = $id_usuario";
        $update = $obj->update($sql);
        if ($update) {
            echo "<script>alert('Se actualizó la contraseña correctamente');</script>";
        } else {
            echo "<script>alert('No se pudo actualizar la contraseña correctamente');</script>";
        }
        redirect("index.php");
    }
}
?>