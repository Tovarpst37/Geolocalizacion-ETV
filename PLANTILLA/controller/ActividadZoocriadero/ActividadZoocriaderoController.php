<?php

include_once '../model/ActividadZoocriadero/ActividadZoocriaderoModel.php';

class ActividadZoocriaderoController
{


    public function getRegistrar()
    {


        include_once '../view/partials/ActividadZoocriadero/Registrar.php';
    }


    public function postRegistrar()
    {

        $obj = new ActividadZoocriaderoModel();

        $codigo = $_POST['cod_actividad'];
        $nombre = $_POST['nombre_actividad'];
        $estado = 1;

        $sql = "INSERT INTO actividad_zoocriadero (cod_actividad, nombre_actividad, id_estado) VALUES
    ('$codigo','$nombre','$estado')";

        $ejecutar = $obj->insert($sql);

        if ($ejecutar) {
            redirect(getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getConsultar"));
        } else {
            echo "No se pudo registrar la ciudad";
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

}
