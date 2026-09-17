<?php

include_once '../model/ActividadZoocriadero/ActividadZoocriaderoModel.php';

class ActividadZoocriaderoController
{


    public function getRegistrar()
    {


        include_once '../view/partials/ActividadZoocriadero/Registrar.php';
    }

    public function validarRegistro(){

        $obj= new ActividadZoocriaderoModel();

        $cont=0;

        $id= $_POST['id']??'';
        $codigo = mb_strtoupper($_POST['cod_actividad']??'');
        $nombre = $_POST['nombre_actividad']??'';

        $errores=[];

        $sql_validar ="SELECT id_actividad_zoo FROM actividad_zoocriadero WHERE cod_actividad=$1";

        $validar_exist= $obj -> select($sql_validar,[$codigo]);

        if(count($validar_exist)>0) {
            $errores[]="Ya existe uan actividad con este codigo";
        }

        if(empty($codigo)) {
            $errores[]= "El codigo de la actividad es obligatoria";
        }

        if(empty($nombre)){
            $errores[]="El nombre de la actividad es obligatoria";
        }


        $codigo_validar = '/^[a-zA-Z0-9\-\_ ]+$/';
        if (!empty($codigo) && !preg_match($codigo_validar, $codigo)) {
            $errores[] = "El código solo puede contener letras, números, guiones y espacios.";
        }

        if(!empty($errores)){
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getRegistrar', array('id' => $id)));
            return;
        }else{
            $cont=1;
        }

        if($cont==1){
            $this ->postRegistrar($obj);
        }

    }

    public function postRegistrar(ActividadZoocriaderoModel $obj)
    {

        

        $codigo = mb_strtoupper($_POST['cod_actividad']);
        $nombre = $_POST['nombre_actividad'];
        $estado = 1;

        $sql = "INSERT INTO actividad_zoocriadero (cod_actividad, nombre_actividad, id_estado) VALUES
    ($1,$2,$3)";

        $ejecutar = $obj->insert($sql,[$codigo, $nombre, $estado]);

        if ($ejecutar) {
            redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
        } else {
            echo "No se pudo registrar la actividad";
        }
    }

    public function getConsultar()
    {

        include_once '../view/partials/ActividadZoocriadero/Consultar.php';
    }


    public function getDatos()
    {

        $obj = new ActividadZoocriaderoModel();

        $sql = "SELECT a.id_actividad_zoo,
            a.cod_actividad,
            a.nombre_actividad,
            e.nombre_estado
            
            FROM actividad_zoocriadero a
            INNER JOIN estado e 
            ON a.id_estado=e.id_estado";

        $datos = $obj->select($sql);

        return $datos;
    }

    public function postDelete()
    {

        $obj = new ActividadZoocriaderoModel();

        $id = $_GET['id'];


        $sqlEstado = "SELECT id_estado FROM actividad_zoocriadero WHERE id_actividad_zoo= $id";

        $ejecutarR = $obj->select($sqlEstado);

        foreach ($ejecutarR as $rec) {

            if ($rec['id_estado'] == 2) {
                echo '<script>alert("¡Este taque ya esta inhabilitado!");</script>';
                redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
            } else if ($rec['id_estado'] == 1) {

                $sql = "UPDATE actividad_zoocriadero SET id_estado = 2 WHERE id_actividad_zoo = $id";
                $ejecutar = $obj->delete($sql);
                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "La actividad se inhabilito correctamente.";
                    redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
                } else {
                    echo "No se pudo inhabilitar la actividad";
                }
            }
        }
    }


    public function postHabilitar()
    {

        $obj = new ActividadZoocriaderoModel();

        $id = $_GET['id'];

        $sqlEstado = "SELECT id_estado FROM actividad_zoocriadero WHERE id_actividad_zoo= $id";



        $ejecutarR = $obj->select($sqlEstado);

        foreach ($ejecutarR as $rec) {
            if ($rec['id_estado'] == 2) {

                $sql = "UPDATE actividad_zoocriadero SET id_estado = 1 WHERE id_actividad_zoo = $id";
                $ejecutar = $obj->delete($sql);
                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "La actividad se habilito correctamente.";
                    redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
                } else {
                    echo "No se pudo inhabilitar la actividad";
                }
            }
        }
    }


    public function getEditar() {

        $obj= new ActividadZoocriaderoModel();

        $id=$_GET['id'];

        $sql= "SELECT * FROM actividad_zoocriadero WHERE id_actividad_zoo=$1";
        $datos= $obj->select($sql, [$id]);
        
        include_once '../view/partials/ActividadZoocriadero/Editar.php';
    }



    public function validarUpdate(){

        $obj= new ActividadZoocriaderoModel();

        $cont=0;

        $id= $_POST['id']??'';
        $codigo = mb_strtoupper($_POST['cod_actividad']??'');
        $nombre = $_POST['nombre_actividad']??'';

        $errores=[];

        $sql_validar ="SELECT id_actividad_zoo FROM actividad_zoocriadero WHERE id_actividad_zoo=$1 
        AND cod_actividad=$2";

        $validar_exist= $obj -> select($sql_validar,[$id,$codigo]);

        if(count($validar_exist)>0) {
            $errores[]="Ya existe uan actividad con este codigo";
        }

        if(empty($codigo)) {
            $errores[]= "El codigo de la actividad es obligatoria";
        }

        if(empty($nombre)){
            $errores[]="El nombre de la actividad es obligatoria";
        }


        $codigo_validar = '/^[a-zA-Z0-9\-\_ ]+$/';
        if (!empty($codigo) && !preg_match($codigo_validar, $codigo)) {
            $errores[] = "El código solo puede contener letras, números, guiones y espacios.";
        }

        if(!empty($errores)){
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getEditar', array('id' => $id)));
            return;
        }else{
            $cont=1;
        }

        if($cont==1){
            $this ->postUpdate($obj);
        }




    }

    public function postUpdate(ActividadZoocriaderoModel $obj){

        
        $codigo = mb_strtoupper($_POST['cod_actividad']);
        $nombre = $_POST['nombre_actividad'];
        $id= $_POST['id'];

        $sql = "UPDATE actividad_zoocriadero SET cod_actividad = $1, nombre_actividad = $2 WHERE id_actividad_zoo = $3";

        $ejecutar= $obj->update($sql,[$codigo,$nombre,$id]);

        if($ejecutar){
            $_SESSION['mensaje_exito'] ="la Actividad se actualizó correctamente.";
            redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
        } else {
            echo "No se pudo Actualizar la actividad";
        }

        

    }


    public function getBuscar(){

    $tex= $_GET['busqueda']??'';
    $obj =new ActividadZoocriaderoModel();
    $busqueda= mb_strtoupper($tex);
    $valor="%$busqueda%";

    $sql = "SELECT a.id_actividad_zoo, a.cod_actividad, a.nombre_actividad,
    e.nombre_estado FROM actividad_zoocriadero a
    INNER JOIN estado e ON  a.id_estado= e.id_estado
    WHERE UPPER(a.cod_actividad) LIKE $1 
    OR UPPER(a.nombre_actividad) LIKE $1";
    
    $actividad2 = $obj ->select($sql,[$valor]);

    include_once "../view/partials/ActividadZoocriadero/Busqueda.php";
        
    }

}

?>