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
        $cont = 0;
        $nombre = $_POST['nombre'] ?? '';
        $via_principal = $_POST['via_principal'] ?? '';
        $numero_via = $_POST['numero_via'] ?? '';
        $via_generadora = $_POST['via_generadora'] ?? '';
        $placa = $_POST['placa'] ?? '';
        $barrio = $_POST['barrio'] ?? '';
        $estado = $_POST['estado'] ?? '';

        $sufijo_via = trim($_POST['sufijo_via'] ?? '');
        $cruce_prefijo = trim($_POST['cruce_prefijo'] ?? '');
        $sufijo_generadora = trim($_POST['sufijo_generadora'] ?? '');

        //validacion 

        //por si llega vacio
        if (empty(trim($sufijo_via))) {
            $sufijo_via = '';
        }

        if (empty(trim($cruce_prefijo))) {
            $cruce_prefijo = '';
        }

        if (empty(trim($sufijo_generadora))) {
            $sufijo_generadora = '';
        }


        $errores = [];

        if (empty($nombre)) {
            $errores[] = "El nombre es obligatorio.";
        }
        if (empty($via_principal)) {
            $errores[] = "Debe seleccionar la vía principal.";
        }
        if (empty($numero_via)) {
            $errores[] = "Debe seleccionar el número de la vía.";
        }
        if (empty($via_generadora)) {
            $errores[] = "Debe seleccionar el número de la vía generadora.";
        }
        if (empty($placa)) {
            $errores[] = "Debe seleccionar el número de placa.";
        }
        if (empty($barrio)) {
            $errores[] = "Debe seleccionar un barrio.";
        }
        if (empty($estado)) {
            $errores[] = "Debe seleccionar un estado.";
        }


        $nombre_validar = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/u';

        if (!empty($nombre) && !preg_match($nombre_validar, $nombre)) {
            $errores[] = "El nombre solo puede contener letras y espacios.";
        }


        if (!empty($errores)) {
            $obj = new SitiosModel();
            $sql2 = "SELECT * FROM barrio";
            $barrios = $obj->select($sql2);

            $sql3 = "SELECT * from estado";
            $estados = $obj->select($sql3);

            include_once '../model/Errores/ErrorModal.php';


            ErrorModal::verError($errores, getUrl('Sitios', 'Sitios', 'getCreate2'));

            return;
        } else {
            $cont = 1;
        }
        if ($cont == 1) {
            $direccion = "$via_principal $numero_via$sufijo_via # $cruce_prefijo$via_generadora$sufijo_generadora-$placa";
            $this->postInsert($nombre, $direccion, $barrio, $estado);
        }
    }



    public function postInsert(String $nombre1, String $direccion1, int $barrio1, int $estado1)
    {

        $nombre = $nombre1;
        $direccion = $direccion1;
        $barrio = $barrio1;
        $estado = $estado1;

        $obj = new SitiosModel();

        $sql = "INSERT INTO sitio (nombre_sitio, direccion, id_barrio, id_estado) 
        VALUES ('$nombre', '$direccion', $barrio, $estado)";

        $ejecutar = $obj->insert($sql);

        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "El sitio se registró correctamente.";
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
        $id = $_GET['id'] ?? null;

        if (empty($id)) {
            redirect(getUrl("Sitios", "Sitios", "getConsultar"));
            return;
        }

        $obj = new SitiosModel();
        $sql = "SELECT * from sitio WHERE id_sitio = $id";
        $datos = $obj->select($sql);

        $sql2 = "SELECT * FROM barrio";
        $barrios = $obj->select($sql2);

        $sql3 = "SELECT * from estado";
        $estados = $obj->select($sql3);
        include_once '../view/partials/Sitios/Editar.php';
    }


    public function validarUpdate()
    {
        $cont = 0;
        $id = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $via_principal = $_POST['via_principal'] ?? '';
        $numero_via = $_POST['numero_via'] ?? '';
        $via_generadora = $_POST['via_generadora'] ?? '';
        $placa = $_POST['placa'] ?? '';
        $barrio = $_POST['barrio'] ?? '';
        $estado = $_POST['estado'] ?? '';

        $sufijo_via = trim($_POST['sufijo_via'] ?? '');
        $cruce_prefijo = trim($_POST['cruce_prefijo'] ?? '');
        $sufijo_generadora = trim($_POST['sufijo_generadora'] ?? '');

        $errores = [];

        if (empty($id)) {
            $errores[] = "No se identificó el sitio a editar.";
        }
        if (empty($nombre)) {
            $errores[] = "El nombre es obligatorio.";
        }
        if (empty($via_principal)) {
            $errores[] = "Debe seleccionar la vía principal.";
        }
        if (empty($numero_via)) {
            $errores[] = "Debe seleccionar el número de la vía.";
        }
        if (empty($via_generadora)) {
            $errores[] = "Debe seleccionar el número de la vía generadora.";
        }
        if (empty($placa)) {
            $errores[] = "Debe seleccionar el número de placa.";
        }
        if (empty($barrio)) {
            $errores[] = "Debe seleccionar un barrio.";
        }
        if (empty($estado)) {
            $errores[] = "Debe seleccionar un estado.";
        }

        $nombre_validar = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/u';
        if (!empty($nombre) && !preg_match($nombre_validar, $nombre)) {
            $errores[] = "El nombre solo puede contener letras y espacios.";
        }

        if (!empty($errores)) {
            $obj = new SitiosModel();

            $sql = "SELECT * from sitio WHERE id_sitio = $id";
            $datos = $obj->select($sql);

            $sql2 = "SELECT * FROM barrio";
            $barrios = $obj->select($sql2);

            $sql3 = "SELECT * from estado";
            $estados = $obj->select($sql3);

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('Sitios', 'Sitios', 'getEdit', array('id' => $id)));

            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $direccion = "$via_principal $numero_via$sufijo_via # $cruce_prefijo$via_generadora$sufijo_generadora-$placa";
            $this->postUpdate($id, $nombre, $direccion, $barrio, $estado);
        }
    }
    public function postUpdate(int $id, string $nombre, string $direccion, int $barrio, int $estado)
    {
        $obj = new SitiosModel();

        $sql = "UPDATE sitio SET 
        nombre_sitio = '$nombre',
        direccion = '$direccion',
        id_barrio = $barrio,
        id_estado = $estado
    WHERE id_sitio = $id";

        $ejecutar = $obj->update($sql);

        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "El sitio se actualizó correctamente.";
            redirect(getUrl("Sitios", "Sitios", "getConsultar"));
        } else {
            echo "No se pudo actualizar el sitio";
        }
    }
}
