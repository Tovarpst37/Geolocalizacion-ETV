<?php
include_once '../model/Sitios/SitiosModel.php';


class TerrenoController {

public function getCreate(){
    $obj = new TerrenoModel();

    $sql1 = "SELECT * FROM estado";

    $estados = $obj -> select($sql1);

    $sql2 = "SELECT nombre FROM tipo_deposito";

    $tipos_deposito = $obj -> select($sql2);

    $sql = "SELECT direccion FROM  direccion";

     $old = $_SESSION['old_input'] ?? [];
        unset($_SESSION['old_input']);


     include_once '../view/partials/Terreno/Registrar.php';
    

}

public function validarRegistrar()
{
    $obj = new TerrenoModel();
    $_SESSION['old_input'] = $_POST;
    $cont = 0;

    $codigo_sitio_deposito = mb_strtoupper(trim($_POST['codigo_sitio_deposito'] ?? ''));
    $direccion = $_POST['direccion'] ?? '';
    $nombre_tipo_deposito = $_POST['nombre_tipo_deposito'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $descripcion = trim($_POST['descripcion'] ?? '');

    // validación por si ya existe el código
    $sql_validar = "SELECT id_terreno FROM terreno WHERE codigo_sitio_deposito = '$codigo_sitio_deposito'";
    $existe = $obj->select($sql_validar);

    $errores = [];

    if (!empty($existe)) {
        $errores[] = "Ya existe un terreno con ese código de sitio de depósito.";
    }

    if (empty($codigo_sitio_deposito)) {
        $errores[] = "El código del sitio de depósito es obligatorio.";
    }
    if (empty($direccion)) {
        $errores[] = "Debe seleccionar una dirección.";
    }
    if (empty($nombre_tipo_deposito)) {
        $errores[] = "Debe seleccionar un tipo de depósito.";
    }
    if (empty($estado)) {
        $errores[] = "Debe seleccionar un estado.";
    }

    $codigo_validar = '/^[a-zA-Z0-9\- ]+$/';

    if (!empty($codigo_sitio_deposito) && !preg_match($codigo_validar, $codigo_sitio_deposito)) {
        $errores[] = "El código solo puede contener letras, números, espacios y guiones.";
    }

    if (!empty($errores)) {

        $sql2 = "SELECT * FROM estado";
        $estados = $obj->select($sql2);

        $sql3 = "SELECT id_tipo_deposito, nombre FROM tipo_deposito";
        $tipos_deposito = $obj->select($sql3);

        $sql4 = "SELECT id_direccion, direccion FROM direccion";
        $direcciones = $obj->select($sql4);

        include_once '../model/Errores/ErrorModal.php';

        ErrorModal::verError($errores, getUrl('Terrenos', 'Terrenos', 'getCreate'));

        return;
    } else {
        $cont = 1;
    }

    if ($cont == 1) {
        $this->postInsert($codigo_sitio_deposito, $direccion, $nombre_tipo_deposito, $estado, $descripcion, $obj);
    }
}

public function postInsert(string $codigo_sitio_deposito1, int $direccion1, int $nombre_tipo_deposito1, int $estado1, string $descripcion1, TerrenoModel $obj)
{

    $codigo_sitio_deposito = mb_strtoupper($codigo_sitio_deposito1);
    $direccion = $direccion1;
    $nombre_tipo_deposito = $nombre_tipo_deposito1;
    $estado = $estado1;
    $descripcion = $descripcion1;

    $sql = "INSERT INTO terreno (codigo_sitio_deposito, id_direccion, id_tipo_deposito, id_estado, descripcion) 
    VALUES ('$codigo_sitio_deposito', $direccion, $nombre_tipo_deposito, $estado, '$descripcion')";

    $ejecutar = $obj->insert($sql);

    if ($ejecutar) {
        $_SESSION['mensaje_exito'] = "El terreno se registró correctamente.";
        redirect(getUrl("Terrenos", "Terrenos", "getConsultar"));
    } else {
        echo "No se registra un terreno";
    }
}


}
