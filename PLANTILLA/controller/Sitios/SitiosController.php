<?php
include_once '../model/Sitios/SitiosModel.php';
class SitiosController
{




    public function setDelete()
    {
        $id = $_GET['id'];
        include_once '../view/partials/Sitios/Inhabilitar.php';
    }

    public function posDelete()
    {
        $id = $_GET['id'];
        $obj = new SitiosModel();
        $sql = "UPDATE  sitio set id_estado = 2 WHERE id_sitio = $id";

        $ejecutar = $obj->update($sql);
        $sql2 = "SELECT id_estado from sitio WHERE id_sitio = $id";
        $validacion =  $obj->select($sql2);
        foreach ($validacion as $j) {

            if ($j['id_estado'] == 2) {
                echo '<script>alert("¡Este tanque ya esta inhabilitado!");</script>';
                redirect(getUrl("Sitios", "Sitios", "getConsultar"));
            } else {
                if ($ejecutar) {
                    redirect(getUrl("Sitios", "Sitios", "getConsultar"));
                } else {
                    echo "No se hinabilito el Sitio";
                }
            }
        }
    }



    public function getCreate2()
    {
        $obj = new SitiosModel();

        $sql2 = "SELECT * FROM barrio";
        $barrios = $obj->select($sql2);

        $sql3 = "SELECT * from estado";
        $estados = $obj->select($sql3);

        include_once '../view/partials/Sitios/Registrar.php';
    }



    public function validarRegistrar()
    {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST["direccion"];
        $barrio = $_POST['barrio'];
        $estado   = $_POST['estado'];

        $nombre_validar = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/u';

            if(preg_match($nombre_validar,$nombre)){

            }else{

            }

            if

        }

    public function postInsert()
    {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST["direccion"];
        $barrio = $_POST['barrio'];
        $estado   = $_POST['estado'];

        $obj = new SitiosModel();

        $sql = "INSERT INTO sitio (nombre_sitio, direccion, id_barrio, id_estado) 
        VALUES ('$nombre', '$direccion', $barrio, $estado)";

        $ejecutar = $obj->insert($sql);
        if ($ejecutar) {
            redirect(getUrl("Sitios", "Sitios", "getConsultar"));
        } else {
            echo "No se registra un sitio";
        }
    }

    public function getConsultar()
    {
        include_once '../view/partials/Sitios/Consultar.php';
    }

    public function data()

    {

        $obj = new SitiosModel();
        $sql = "SELECT 
            s.id_sitio,
            s.nombre_sitio,
            s.direccion,
            b.nombre_barrio AS barrio,
            e.nombre_estado AS estado
        FROM sitio s
        INNER JOIN barrio b ON s.id_barrio = b.id_barrio
        INNER JOIN estado e ON s.id_estado = e.id_estado";
        # $result = $obj->select($sql);
        $datos = $obj->select($sql);
        return $datos;
    }

    public function getEdit()
    {
        $id = $_GET['id'];
        $obj = new SitiosModel();
        $sql = "SELECT * from sitio WHERE id_sitio = $id";
        $datos = $obj->select($sql);

        $sql2 = "SELECT * FROM barrio";
        $barrios = $obj->select($sql2);

        $sql3 = "SELECT * from estado";
        $estados = $obj->select($sql3);
        include_once '../view/partials/Sitios/Editar.php';
    }

    public function postUpdate()
    {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST["direccion"];
        $barrio = $_POST['barrio'];
        $estado = $_POST['estado'];
        $obj = new SitiosModel();


        $sql = "UPDATE sitio SET 
    nombre_sitio = '$nombre',
    direccion = '$direccion',
    id_barrio = $barrio,
    id_estado = $estado
    WHERE id_sitio = $id";

        $ejecutar = $obj->update($sql);

        if ($ejecutar) {
            redirect(getUrl("Sitios", "Sitios", "getConsultar"));
        } else {
            echo "No se pudo Actualizar el Sitio";
        };
    }
}
