<?php

include_once '../model/Zoocriadero/ZoocriaderoModel.php';

class ZoocriaderoController
{



    public function getRegistrar()
    
    {

        $obj = new ZoocriaderoModel();

        $sql3 = "SELECT * from estado";

        $estados = $obj->select($sql3);


         $sql = "SELECT * from usuarios WHERE id_rol = 2 AND id_zoocriadero IS null";

        $coord = $obj->select($sql);

        $sql2 = "SELECT * from usuarios WHERE id_rol = 4 AND id_zoocriadero IS null";
        $auxi = $obj->select($sql2);

        include_once '../model/Direcciones/direcciones.php';
        include_once '../view/partials/Zoocriadero/Registrar.php';
    }

    public function validarRegistrar()
    {

    $obj = new ZoocriaderoModel();
        $cont = 0;
        $codigo = $_POST['codigo_zoocriadero'] ?? '';
        $via_principal = $_POST['via_principal'] ?? '';
        $numero_via = $_POST['numero_via'] ?? '';
        $via_generadora = $_POST['via_generadora'] ?? '';
        $placa = $_POST['placa'] ?? '';
        $auxi = $_POST['usuarios_asignados'] ?? [];
        $estado = $_POST['id_estado'] ?? '';
        $coor = $_POST['id_coor'] ?? '';

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

        $sql_validar = "SELECT id_zoocriadero FROM zoocriadero WHERE cod_zoocriadero = '$codigo'";
        $existe = $obj->select($sql_validar);

        if(!empty($existe)){
            $errores[] = "Ya existe un Zoocriadero con ese código";
            
        } 

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
        if (empty($auxi)) {
            $errores[] = "Debe seleccionar un auxiliar.";
        }
        if (empty($coor)) {
            $errores[] = "Debe seleccionar un coordinador.";
        }
        if (empty($estado)) {
            $errores[] = "Debe seleccionar un estado.";
        }

        if (!empty($errores)) {
            

            $sql3 = "SELECT * from estado";
            $estados = $obj->select($sql3);

            

            $sql = "SELECT * from usuarios WHERE id_rol = 2 AND id_zoocriadero IS null";

            $coord = $obj->select($sql);

            $sql2 = "SELECT * from usuarios WHERE id_rol = 3 AND id_zoocriadero IS null";
            $auxi = $obj->select($sql2);

            include_once '../model/Direcciones/direcciones.php';
            include_once '../model/Errores/ErrorModal.php';

            ErrorModal::verError($errores, getUrl('Zoocriadero', 'Zoocriadero', 'getRegistrar'));

            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $direccion = "$via_principal $numero_via$sufijo_via # $cruce_prefijo$via_generadora$sufijo_generadora-$placa";
            $this->postRegistrar($codigo, $direccion, $estado, $auxi,$coor,$obj);
        }
    }



    public function postRegistrar(string $codigo,string $direccion,int $estado,array $auxi,string $coor,ZoocriaderoModel $obj
) {
    
    $sql = "INSERT INTO zoocriadero (cod_zoocriadero, direcciom, id_estado) VALUES ($1, $2, $3)";

    $ejecutar = $obj->insert($sql, [$codigo,$direccion,$estado]);

    if (!$ejecutar) {
        echo "No se pudo registrar el zoocriadero";
        return;
    }


    $sql3 = "SELECT id_zoocriadero FROM zoocriadero WHERE cod_zoocriadero = $1";

    $resultado = $obj->select($sql3, [$codigo]);

    if (empty($resultado)) {
        echo "No se pudo obtener el ID del zoocriadero";
        return;
    }

   
    $id_zoo = $resultado[0]['id_zoocriadero'];


    $sql_coord = "UPDATE usuarios SET id_zoocriadero = $1 WHERE id_usuario = $2";

    $ejecutar_coord = $obj->update($sql_coord, [$id_zoo,$coor]);

    if (!$ejecutar_coord) {
        echo "No se pudo asignar el coordinador";
        return;
    }


    $sql_aux = "UPDATE usuarios SET id_zoocriadero = $1 WHERE id_usuario = $2";

    foreach ($auxi as $id_usuario) {

        $ejecutar_aux = $obj->update($sql_aux, [$id_zoo,$id_usuario]);

        if (!$ejecutar_aux) {
            echo "No se pudo asignar el auxiliar: " . $id_usuario;
            return;
        }
    }

    $_SESSION['mensaje_exito'] = "El zoocriadero se registró correctamente.";

    redirect(
        getUrl("Zoocriadero","Zoocriadero","getConsultar"));
}


    public function getConsultar()
    {

        $obj = new ZoocriaderoModel();
        $sql = "SELECT * from zoocriadero";
        $zoocriaderos = $obj->select($sql);

        if(count($zoocriaderos) <= 0){

        include_once '../view/partials/Zoocriadero/notExist.php';
        }else{

        include_once '../view/partials/Zoocriadero/Consultar.php';
        }
    }


    public function getBuscar()
    {
    $busqueda = mb_strtoupper($_GET['busqueda'] ?? '');

    
    if(!empty($busqueda)){
        $palabra = $_GET['busqueda'] ?? '';
        $obj = new ZoocriaderoModel();
        $sql = "SELECT * from zoocriadero WHERE cod_zoocriadero ILIKE $1";
        $zoocriaderos =  $obj->select($sql, ['%' . $busqueda . '%']);


        include_once "../view/partials/Zoocriadero/Busqueda.php";
    }else{
        $obj = new ZoocriaderoModel();
        $sql = "SELECT * from zoocriadero";
        $zoocriaderos = $obj->select($sql);

        include_once '../view/partials/Zoocriadero/Consultar.php';
        
    }
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


    public function getEditar()
    {
        $id = $_GET['id'] ?? null;

        if (empty($id)) {
            redirect(getUrl("Zoocriadero", "Zoocriadero", "getConsultar"));
            return;
        }



        $obj = new ZoocriaderoModel();

        $sql = "SELECT * from usuarios WHERE id_rol = 2 AND id_zoocriadero IS null";
        $coord = $obj->select($sql);

        $sql7 = "SELECT * from usuarios WHERE id_rol = 2 AND id_zoocriadero = $1";
        $coordS = $obj->select($sql7,[$id]);

        $sql2 = "SELECT * from usuarios WHERE id_rol = 4 AND id_zoocriadero IS null";
        $auxi = $obj->select($sql2);

        $sql8 = "SELECT * from usuarios WHERE id_rol = 4 AND id_zoocriadero = $1";
        $auxiS = $obj->select($sql8,[$id]);

        $sql9 = "SELECT * from zoocriadero WHERE id_zoocriadero = $1";
        $datos = $obj->select($sql9,[$id]);

        include_once '../model/Direcciones/direcciones.php';
        $partes = parsearDireccion($datos[0]['direcciom']);

        $sql22 = "SELECT * FROM barrio";
        $barrios = $obj->select($sql22);

        $sql32 = "SELECT * from estado";
        $estados = $obj->select($sql32);


        include_once '../view/partials/Zoocriadero/Editar.php';
    }


    public function validarUpdate()
{
    $obj = new ZoocriaderoModel();

    $id = $_POST['id'] ?? '';
    $codigo = mb_strtoupper($_POST['cod_zoocriadero'] ?? '');
    $id_cor = $_POST['id_coor'] ?? '';
    $auxi = $_POST['usuarios_asignados'] ?? [];
    $estado = $_POST['id_estado'] ?? '';

    $via_principal = $_POST['via_principal'] ?? '';
    $numero_via = $_POST['numero_via'] ?? '';
    $sufijo_via = trim($_POST['sufijo_via'] ?? '');
    $via_generadora = $_POST['via_generadora'] ?? '';
    $placa = $_POST['placa'] ?? '';
    $cruce_prefijo = trim($_POST['cruce_prefijo'] ?? '');
    $sufijo_generadora = trim($_POST['sufijo_generadora'] ?? '');

    $sql_validar = "SELECT cod_zoocriadero FROM zoocriadero WHERE cod_zoocriadero = $1 AND id_zoocriadero != $2";
    $existe = $obj->select($sql_validar, [$codigo, $id]);

    $errores = [];

    if (!empty($existe)) {
        $errores[] = "Ya existe otro zoocriadero con ese código";
    }
    if (empty($id)) {
        $errores[] = "No se identificó el zoocriadero a editar.";
    }
    if (empty($id_cor)) {
        $errores[] = "No seleccionaste un coordinador";
    }
    if (empty($auxi)) {
        $errores[] = "No seleccionaste ningún auxiliar";
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
    if (empty($estado)) {
        $errores[] = "Debe seleccionar un estado.";
    }

    if (!empty($errores)) {

        $sql3 = "SELECT * from estado";
        $estados = $obj->select($sql3);

        $sqlCoordDisp = "SELECT * from usuarios WHERE id_rol = 2 AND (id_zoocriadero IS NULL OR id_zoocriadero = $1)";
        $coord = $obj->select($sqlCoordDisp, [$id]);

        $sqlAuxDisp = "SELECT * from usuarios WHERE id_rol = 3 AND (id_zoocriadero IS NULL OR id_zoocriadero = $1)";
        $auxiliares = $obj->select($sqlAuxDisp, [$id]);

        $sql9 = "SELECT * from zoocriadero WHERE id_zoocriadero = $1";
        $datos = $obj->select($sql9, [$id]);

        include_once __DIR__ . '/../../model/Errores/ErrorModal.php';
        ErrorModal::verError($errores, getUrl('Zoocriadero', 'Zoocriadero', 'getEditar', array('id' => $id)));

        return;
    }

    $direccion = "$via_principal $numero_via$sufijo_via # $cruce_prefijo$via_generadora$sufijo_generadora-$placa";
    $this->postUpdate($id, $direccion, $estado, $codigo, $auxi, $id_cor, $obj);
}

    public function postUpdate(int $id, string $direccion, int $estado, string $codigo, array $auxi, int $id_cor, ZoocriaderoModel $obj)
{
    
    $sql = "UPDATE zoocriadero SET cod_zoocriadero = $1, direcciom = $2, id_estado = $3 
            WHERE id_zoocriadero = $4";
    $obj->update($sql, [$codigo, $direccion, $estado, $id]);

    
    $sqlLimpiar = "UPDATE usuarios SET id_zoocriadero = NULL WHERE id_zoocriadero = $1";
    $obj->update($sqlLimpiar, [$id]);

    
    $sqlCoor = "UPDATE usuarios SET id_zoocriadero = $1 WHERE id_usuario = $2";
    $obj->update($sqlCoor, [$id, $id_cor]);

    
    $sqlAux = "UPDATE usuarios SET id_zoocriadero = $1 WHERE id_usuario = $2";

    foreach ($auxi as $id_usuario) {
        $ejecutar_aux = $obj->update($sqlAux, [$id, $id_usuario]);

        if (!$ejecutar_aux) {
            echo "No se pudo asignar el auxiliar: " . $id_usuario;
            return;
        }
    }

    $_SESSION['mensaje_exito'] = "El zoocriadero se actualizó correctamente.";
    redirect(getUrl("Zoocriadero", "Zoocriadero", "getConsultar"));
}
}
