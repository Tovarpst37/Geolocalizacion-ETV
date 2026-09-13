<?php
     include_once '../model/MasterModel.php';
     include_once '../model/Usuario/UsuarioModel.php';

     class UsuarioController{

      public function getCreate(){
         $obj = new MasterModel();
         $sql1 = "SELECT * FROM tipo_documento";
         $sql2 = "SELECT * FROM genero";
         $sql3 = "SELECT * FROM rol";
         $sql4 = "SELECT * FROM rh";
         $tipo_documento = $obj->select($sql1);
         $genero = $obj->select($sql2);
         $rol = $obj->select($sql3);
         $rh = $obj->select($sql4);
         include_once '../view/usuario/create.php';
      }

     public function postCreate(){

         $obj = new UsuarioModel();
         $primer_nombre = $_POST['primer_nombre'];
         $segundo_nombre = $_POST['segundo_nombre'];
         $primer_apellido = $_POST['primer_apellido'];
         $segundo_apellido = $_POST['segundo_apellido'];
         $tipo_documento = $_POST['tipo_documento'];
         $documento = $_POST['documento'];
         $fecha_nacimiento = $_POST['fecha_nacimiento'];
         $correo_electronico = $_POST['correo'];
         $password = $_POST['password'];
         $genero = $_POST['genero'];
         $rol = $_POST['rol'];
         $rh = $_POST['rh'];
         $id_estado = 1;

         $id = $obj->autoincrement("usuarios","id_usuario");
         $sql = "INSERT INTO usuarios VALUES($id,'$primer_nombre',
         '$segundo_nombre','$primer_apellido',
         '$segundo_apellido','$tipo_documento',
         '$documento','$fecha_nacimiento',
         '$correo_electronico','$password','$genero','$rol','$id_estado','$rh')";
      
         $ejecutar = $obj->insert($sql);

         if($ejecutar){
            redirect(getUrl("Usuario","Usuario","getUsuario"));
         }else{
            echo "Hubo un error al momento de la insercion";
         }

      }

     public function getUsuario(){
         $obj = new UsuarioModel();
         $sql = "SELECT * FROM usuarios";
         $usuarios = $obj->select($sql);
         include_once '../view/usuario/list.php';
     }

     }
?>