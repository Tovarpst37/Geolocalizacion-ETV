<?php

include_once '../model/Tanque/TanqueModel.php';


class TanqueController
{



    public function getConsultar()
    {
        
            
            include_once '../view/partials/Tanque/Consultar.php';
        

        
    }

    public function getRegistrar()
    {
        $obj = new TanqueModel();

        $sql = "SELECT * from tipo_tanque where estado = 1";
        $tiposTanque = $obj->select($sql);

        $sql4 = "SELECT MAX(id_tanque) FROM tanque";
        $id_tan = $obj->select($sql4);

        $sql2 = "SELECT * from zoocriadero";
        $zoocriaderos = $obj->select($sql2);

        $sql3 = "SELECT * from estado where tipo_estado = 'general'";
        $estados = $obj->select($sql3);

        $old = $_SESSION['old_input'] ?? [];
        unset($_SESSION['old_input']);
        

        include_once '../view/partials/Tanque/Registrar.php';
    }
               

    public function validarRegistrar()
    {
        $obj = new TanqueModel();
        $cont = 0;
        $codigo = mb_strtoupper($_POST['codigo'] ?? '');
        $tipo = $_POST['id_tipo_tanque'] ?? '';
        $zoocriadero = $_POST['id_zoocriadero'] ?? '';
        $estado = $_POST['id_estado'] ?? '';

        $errores = [];

        $sql_validar = "SELECT id_tanque FROM tanque WHERE codigo_tanque = $1 ";
        $existe = $obj->select($sql_validar,[$codigo]);

        if (!empty($existe)) {
            $errores[] = "Ya existe un tanque con ese código";

        }

        if (empty($codigo)) {
            $errores[] = "El código del tanque es obligatorio.";
        }
        if (empty($tipo)) {
            $errores[] = "Debe seleccionar el tipo de tanque.";
        }
        if (empty($zoocriadero)) {
            $errores[] = "Debe seleccionar un zoocriadero.";
        }
        if (empty($estado)) {
            $errores[] = "Debe seleccionar un estado.";
        }

        if (!empty($_FILES['img']['name']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($_FILES['img']['type'], $tiposPermitidos)) {
                $errores[] = "La imagen debe ser JPG, PNG o WEBP.";
            }
        }

       

        if (!empty($errores)) {
            $_SESSION['old_input'] = $_POST;


            $sql = "SELECT * from tipo_tanque";
            $tiposTanque = $obj->select($sql);
            $sql2 = "SELECT * from zoocriadero";
            $zoocriaderos = $obj->select($sql2);
            $sql3 = "SELECT * from estado";
            $estados = $obj->select($sql3);

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('Tanque', 'Tanque', 'getRegistrar'));

            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $this->postRegistrar($obj);
        }
    }

    public function postRegistrar(TanqueModel $obj)
    {

        $nombreArchivo = 'tanque_' . uniqid() . '.' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $carpetaDestino = __DIR__ . '/../../web/assets/img/';
        $rutaCompleta = $carpetaDestino . $nombreArchivo;
        move_uploaded_file($_FILES['img']['tmp_name'], $rutaCompleta);

        $tipo = $_POST['id_tipo_tanque'];
        $codigo = mb_strtoupper($_POST['codigo']);
        $zoocriadero = $_POST['id_zoocriadero'];
        $estado = $_POST['id_estado'];

        $sql = "INSERT INTO tanque (codigo_tanque, img, id_tipo_tanque, id_zoocriadero, id_estado)
                VALUES 
                ($1, $2, $3, $4, $5)";

        $ejecutar = $obj->insert($sql,[$codigo,$nombreArchivo,$tipo,$zoocriadero,$estado]);

        if ($ejecutar) {
            redirect(getUrl("Tanque", "Tanque", "getConsultar"));
        } else {
            echo "No se pudo registrar la ciudad";
        }
    }



    public function postDelete()
    {

        $obj = new TanqueModel();
        $id = $_GET['id'];

        $sql2 = "SELECT id_estado from tanque WHERE id_tanque = $1";
        $ejecutar2 = $obj->select($sql2,[$id]);
        foreach ($ejecutar2 as $s) {


           
                $sql = "UPDATE tanque SET id_estado = 2 WHERE id_tanque = $1";

                $ejecutar = $obj->update($sql,[$id]);
                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "El Tanque se inhabilito correctamente.";
                    redirect(getUrl("Tanque", "Tanque", "getConsultar"));
                } else {
                    echo "No se pudo inhabilitar el tanque";
                }
            }
        }
    

    public function postHabilitar()
    {

        $obj = new TanqueModel();
        $id = $_GET['id'];

        $sql2 = "SELECT id_estado from tanque WHERE id_tanque = $1";
        $ejecutar2 = $obj->select($sql2,[$id]);
        foreach ($ejecutar2 as $s) {


            
                $sql = "UPDATE tanque SET id_estado = 1 WHERE id_tanque = $1";

                $ejecutar = $obj->update($sql,[$id]);
                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "El Tanque se habilito correctamente.";
                    redirect(getUrl("Tanque", "Tanque", "getConsultar"));
                } else {
                    echo "No se pudo inhabilitar el tanque";
                }
            }
        }
    

    public function getEdit()
    {

        $id = $_GET['id'];
        $obj = new TanqueModel();

        $sql = "SELECT * from tanque WHERE id_tanque = $1";
        $datos = $obj->select($sql,[$id]);

        $sql1 = "SELECT * from tipo_tanque";
        $tiposTanque = $obj->select($sql1);

        $sql2 = "SELECT * from zoocriadero";
        $zoocriaderos = $obj->select($sql2);

        $sql3 = "SELECT * from estado where tipo_estado = 'general'";
        $estados = $obj->select($sql3);

        include_once '../view/partials/Tanque/Editar.php';
    }

    


    public function validarUpdate()
    {
        $obj = new TanqueModel();
        $cont = 0;
        $id = $_POST['id'] ?? '';
        $codigo = mb_strtoupper($_POST['codigo'] ?? '');
        $tipo = $_POST['id_tipo_tanque'] ?? '';
        $zoocriadero = $_POST['id_zoocriadero'] ?? '';
        $estado = $_POST['id_estado'] ?? '';

        $errores = [];

        $sql_validar = "SELECT id_tanque FROM tanque WHERE codigo_tanque = $1 AND id_tanque != $2";
        $existe = $obj->select($sql_validar,[$codigo,$id]);


        if(count($existe) > 0){

            $errores[] = "Ya existe un tanque con ese código";

        }
        if (empty($id)) {
            $errores[] = "No se identificó el tanque a editar.";
        }
        if (empty($codigo)) {
            $errores[] = "El código del tanque es obligatorio.";
        }
        if (empty($tipo)) {
            $errores[] = "Debe seleccionar el tipo de tanque.";
        }
        if (empty($zoocriadero)) {
            $errores[] = "Debe seleccionar un zoocriadero.";
        }
        if (empty($estado)) {
            $errores[] = "Debe seleccionar un estado.";
        }

        if (!empty($_FILES['img']['name']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($_FILES['img']['type'], $tiposPermitidos)) {
                $errores[] = "La imagen debe ser JPG, PNG o WEBP.";
            }
        }

        
        if (!empty($errores)) {


            $sql = "SELECT * from tanque WHERE id_tanque = $id";
            $datos = $obj->select($sql);

            $sql1 = "SELECT * from tipo_tanque";
            $tiposTanque = $obj->select($sql1);

            $sql2 = "SELECT * from zoocriadero";
            $zoocriaderos = $obj->select($sql2);

            $sql3 = "SELECT * from estado";
            $estados = $obj->select($sql3);

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('Tanque', 'Tanque', 'getEdit', array('id' => $id)));

            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $this->postUpdate($obj);
        }
    }

    public function postUpdate(TanqueModel $obj)
    {

        $nombreArchivo = 'tanque_' . uniqid() . '.' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $carpetaDestino = __DIR__ . '/../../web/assets/img/';
        $rutaCompleta = $carpetaDestino . $nombreArchivo;
        move_uploaded_file($_FILES['img']['tmp_name'], $rutaCompleta);

        $tipo = $_POST['id_tipo_tanque'];
        $codigo = mb_strtoupper($_POST['codigo']);
        $zoocriadero = $_POST['id_zoocriadero'];
        $estado = $_POST['id_estado'];
        $id = $_POST['id'];
        


        if ($_FILES['img']['error'] === UPLOAD_ERR_OK) {

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


        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "El Tanque se actualizó correctamente.";
            redirect(getUrl("Tanque", "Tanque", "getConsultar"));
        } else {
            echo "No se pudo registrar la ciudad";
        }
        ;
    }



    public function getDatos()
    {

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
                INNER JOIN estado est ON t.id_estado = est.id_estado ORDER BY id_tanque DESC";
        $tanque = $obj->select($sql);

        return $tanque;
    }



    public function getBuscar()
    {

        $busqueda = mb_strtoupper($_GET['busqueda'] ?? '');

        if(!empty($busqueda)){ 
        $palabra = $_GET['busqueda'];
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
                INNER JOIN estado est ON t.id_estado = est.id_estado
                WHERE t.codigo_tanque ILIKE $1";

        $tanque2 = $obj->select($sql, ['%' . $busqueda . '%']);

        include_once "../view/partials/Tanque/Busqueda.php";
        }else{
            include_once '../view/partials/Tanque/Consultar.php';
        }
    }

    public function getCant()
    {

        $obj = new TanqueModel();

        $sql = "SELECT * from tanque";

        $tanque = $obj->select($sql);

        return count($tanque);

    }

}
