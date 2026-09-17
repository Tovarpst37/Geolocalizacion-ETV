<?php
   include_once '../model/LogicaNegocio/Hash.php';
   include_once '../model/MasterModel.php';
   include_once '../model/Usuario/UsuarioModel.php';

   class UsuarioController{

      private static int $id_estado = 1;

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
         $documento = $_POST['documento'];

         $sql = "SELECT EXISTS (SELECT 1 FROM usuarios WHERE documento = $1)";
         $existe = $obj->exists($sql, $documento);

         if ($existe) {
            echo "ya existe un usuario con ese numero de documento";
            return;
         }

         $primer_nombre        = $_POST['primer_nombre'];
         $segundo_nombre       = $_POST['segundo_nombre'] ?? '';
         $primer_apellido      = $_POST['primer_apellido'];
         $segundo_apellido     = $_POST['segundo_apellido'] ?? '';
         $tipo_documento       = $_POST['tipo_documento'];
         $fecha_nacimiento     = $_POST['fecha_nacimiento'];
         $correo_electronico   = $_POST['correo'];
         $password             = Hash::encripHash($_POST['password']);
         $genero               = $_POST['genero'];
         $rol                  = $_POST['rol'];
         $rh                   = $_POST['rh'];
         $id                   = $obj->autoincrement("usuarios", "id_usuario");

         $sql = "INSERT INTO usuarios OVERRIDING SYSTEM VALUE VALUES($id,'$primer_nombre',
            '$segundo_nombre','$primer_apellido',
            '$segundo_apellido',$tipo_documento,
            '$documento','$fecha_nacimiento',
            '$correo_electronico','$password',$genero,$rol,$rh,". self::$id_estado .")";

         $ejecutar = $obj->insert($sql);
         if ($ejecutar) {
            redirect(getUrl("Usuario", "Usuario", "getUsuario"));
         } else {
            echo "Hubo un error al momento de la insercion";
         }
      }

      public function getUsuario(){
         $obj = new UsuarioModel();

         $sql1 = "SELECT * FROM tipo_documento";
         $sql2 = "SELECT * FROM genero";
         $sql3 = "SELECT * FROM rol";
         $sql4 = "SELECT * FROM rh";
         $tipo_documento = $obj->select($sql1);
         $genero = $obj->select($sql2);
         $rol = $obj->select($sql3);
         $rh = $obj->select($sql4);

         $sql = "SELECT u.id_usuario, u.primer_nombre, u.segundo_nombre,
            u.primer_apellido, u.segundo_apellido,
            u.id_tipo_documento,
            td.nombre_documento AS tipo_documento,
            u.documento, u.fecha_nacimiento, u.correo,
            u.id_genero,
            g.nombre_genero AS genero_usuario,
            u.id_rol,
            r.nombre_rol AS rol_usuario,
            u.id_rh,
            rh.nombre_rh AS rh_usuario,
            u.id_estado
         FROM usuarios u
         INNER JOIN tipo_documento td ON u.id_tipo_documento = td.id_tipo_documento
         INNER JOIN genero g ON u.id_genero = g.id_genero
         INNER JOIN rol r ON u.id_rol = r.id_rol
         INNER JOIN rh ON u.id_rh = rh.id_rh
         ORDER BY u.id_usuario";

         $usuarios = $obj->select($sql);

         if(empty($usuarios)){
            include_once '../view/usuario/notExist.php';
         }else {
            include_once '../view/usuario/list.php';
         }

      }

      public function postEditar(){
         $obj = new UsuarioModel();

         $id_usuario          = $_POST['id_usuario'];
         $primer_nombre       = $_POST['primer_nombre'];
         $segundo_nombre      = $_POST['segundo_nombre'] ?? '';
         $primer_apellido     = $_POST['primer_apellido'];
         $segundo_apellido    = $_POST['segundo_apellido'] ?? '';
         $tipo_documento      = $_POST['tipo_documento'];
         $documento           = $_POST['documento'];
         $fecha_nacimiento    = $_POST['fecha_nacimiento'];
         $correo_electronico  = $_POST['correo'];
         $genero              = $_POST['genero'];
         $rol                 = $_POST['rol'];
         $rh                  = $_POST['rh'];


         $sql = "SELECT id_zoocriadero, id_sitio FROM usuarios WHERE id_usuario = $1";
         $sql2 = "SELECT id_rol FROM usuarios WHERE id_usuario = $1";

         $rol_actual = $obj->select($sql2,[$id_usuario]);

         $resultado = $obj->select($sql, [$id_usuario]);

         if($rol_actual[0]['id_rol'] == $rol){


         $sql = "UPDATE usuarios SET
                  primer_nombre = '$primer_nombre',
                  segundo_nombre = '$segundo_nombre',
                  primer_apellido = '$primer_apellido',
                  segundo_apellido = '$segundo_apellido',
                  id_tipo_documento = $tipo_documento,
                  documento = '$documento',
                  fecha_nacimiento = '$fecha_nacimiento',
                  correo = '$correo_electronico',
                  id_genero = $genero,
                  id_rol = $rol,
                  id_rh = $rh
               WHERE id_usuario = $id_usuario";

         $ejecutar = $obj->update($sql);

         if($ejecutar){
            redirect(getUrl("Usuario","Usuario","getUsuario"));
         }else{
            echo "Hubo un error al momento de actualizar";
         }
         }else{
         if($resultado[0]['id_zoocriadero'] == null && $resultado[0]['id_sitio'] == null){

            $sql = "UPDATE usuarios SET
                  primer_nombre = '$primer_nombre',
                  segundo_nombre = '$segundo_nombre',
                  primer_apellido = '$primer_apellido',
                  segundo_apellido = '$segundo_apellido',
                  id_tipo_documento = $tipo_documento,
                  documento = '$documento',
                  fecha_nacimiento = '$fecha_nacimiento',
                  correo = '$correo_electronico',
                  id_genero = $genero,
                  id_rol = $rol,
                  id_rh = $rh
               WHERE id_usuario = $id_usuario";

         $ejecutar = $obj->update($sql);

         if($ejecutar){
            redirect(getUrl("Usuario","Usuario","getUsuario"));
         }else{
            echo "Hubo un error al momento de actualizar";
         }
         }
         else{
            

            $errores[] = "Este usuario esta activo en un zoocriadero o sitio no puedes modificar su rol.";
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('Usuario', 'Usuario', 'getUsuario'));
         }
      }
      }

      public function postCambiarEstado(){
         $obj = new UsuarioModel();
         $id_usuario = $_POST['id_usuario'];
         $id_estado_actual = $_POST['id_estado_actual'];
         $nuevo_estado = ($id_estado_actual == 1) ? 0 : 1;
         $sql = "UPDATE usuarios SET id_estado = $nuevo_estado WHERE id_usuario = $id_usuario";
         $obj->update($sql);
         redirect(getUrl("Usuario","Usuario","getUsuario"));
      }

   }
?>