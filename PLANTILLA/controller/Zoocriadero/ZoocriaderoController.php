<?php

include_once '../model/Zoocriadero/ZoocriaderoModel.php';

class ZoocriaderoController
{



    public function getRegistrar()
    {

        $obj = new ZoocriaderoModel();

        $sql3 = "SELECT * from estado";

        $estados = $obj->select($sql3);


         $sql = "SELECT * from usuarios WHERE id_rol = 2";

        $usuarios = $obj->select($sql);

        include_once '../model/Direcciones/direcciones.php';
        include_once '../view/partials/Zoocriadero/Registrar.php';
    }

    public function validarRegistrar()
    {
        $cont = 0;
        $codigo = $_POST['codigo_zoocriadero'] ?? '';
        $via_principal = $_POST['via_principal'] ?? '';
        $numero_via = $_POST['numero_via'] ?? '';
        $via_generadora = $_POST['via_generadora'] ?? '';
        $placa = $_POST['placa'] ?? '';
        $usuario = $_POST['id_usuario'] ?? '';
        $estado = $_POST['id_estado'] ?? '';

        $sufijo_via = trim($_POST['sufijo_via'] ?? '');
        $cruce_prefijo = trim($_POST['cruce_prefijo'] ?? '');
        $sufijo_generadora = trim($_POST['sufijo_generadora'] ?? '');

        // por si llega vacío
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

        if (empty($codigo)) {
            $errores[] = "El código del zoocriadero es obligatorio.";
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
        if (empty($usuario)) {
            $errores[] = "Debe seleccionar un coordinador.";
        }
        if (empty($estado)) {
            $errores[] = "Debe seleccionar un estado.";
        }

        if (!empty($errores)) {
            $obj = new ZoocriaderoModel();

            $sql3 = "SELECT * from estado";
            $estados = $obj->select($sql3);

            $sql = "SELECT * from usuarios WHERE id_rol = 2";
            $usuarios = $obj->select($sql);

            include_once '../model/Direcciones/direcciones.php';
            include_once '../model/Errores/ErrorModal.php';

            ErrorModal::verError($errores, getUrl('Zoocriadero', 'Zoocriadero', 'getRegistrar'));

            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $direccion = "$via_principal $numero_via$sufijo_via # $cruce_prefijo$via_generadora$sufijo_generadora-$placa";
            $this->postRegistrar($codigo, $direccion, $usuario, $estado);
        }
    }



    public function postRegistrar(string $codigo, string $direccion, int $usuario, int $estado)
    {
        $obj = new ZoocriaderoModel();

        $sql = "INSERT into zoocriadero (cod_zoocriadero, direcciom, id_usuario, id_estado) VALUES ('$codigo', '$direccion', $usuario, $estado)";
        $ejecutar = $obj->update($sql);

        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "El zoocriadero se registró correctamente.";
            redirect(getUrl("Zoocriadero", "Zoocriadero", "getConsultar"));
        } else {
            echo "No se pudo registrar el zoocriadero";
        }
    }


    public function getConsultar()
    {

        $obj = new ZoocriaderoModel();
        $sql = "SELECT * from zoocriadero";
        $zoocriaderos = $obj->select($sql);

        include_once '../view/partials/Zoocriadero/Consultar.php';
    }

    public function getEditar()
    {
        $id = $_GET['id'];
        $obj = new ZoocriaderoModel();

        $sql = "SELECT * from zoocriadero WHERE id_zoocriadero = '$id'";
        $datos = $obj->select($sql);

        $sql3 = "SELECT * from estado";
            $estados = $obj->select($sql3);

        $sql2 = "SELECT * from usuarios WHERE id_rol = 2";
        $usuarios = $obj->select($sql2);

        include_once '../view/partials/Zoocriadero/Editar.php';

    }


    public function getBuscar()
    {

    $palabra = $_GET['busqueda'] ?? '';
        $obj = new ZoocriaderoModel();
        $sql = "SELECT * from zoocriadero";
        $zoocriaderos = $obj->select($sql);


        include_once "../view/partials/Zoocriadero/Busqueda.php";
    }

    public function postDelete()
    {

        $obj = new ZoocriaderoModel();
        $id = $_GET['id'];

        $sql2 = "SELECT id_estado from zoocriadero WHERE id_zoocriadero = $id";
        $ejecutar2 = $obj->select($sql2);
        foreach ($ejecutar2 as $s) {


            if ($s['id_estado'] == 2) {

                echo '<script>alert("¡Este zoocriadero ya esta inhabilitado!");</script>';
                redirect(getUrl("Zoocriadero", "Zoocriadero", "getConsultar"));
            } else if ($s['id_estado'] == 1) {
                $sql = "UPDATE zoocriadero SET id_estado = 2 WHERE id_zoocriadero = $id";

                $ejecutar = $obj->delete($sql);
                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "El Zoocriadero se inhabilito correctamente.";
                    redirect(getUrl("Zoocriadero", "Zoocriadero", "getConsultar"));
                } else {
                    echo "No se pudo inhabilitar el tanque";
                }
            }
        }
    }
}
