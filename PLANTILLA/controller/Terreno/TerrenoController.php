<?php
include_once '../model/Terreno/TerrenoModel.php';


class TerrenoController
{

    public function getCreate()
    {
        $obj = new TerrenoModel();

        $sql1 = "SELECT * FROM estado";
        $estados = $obj->select($sql1);
        $sql2 = "SELECT id_tipo_deposito, nombre FROM tipo_de_deposito";
        $tipos_deposito = $obj->select($sql2);

        $sql3 = "SELECT id_sitio, nombre_sitio FROM sitio";
        $sitios = $obj->select($sql3);

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
        $nombre_sitio = $_POST['nombre_sitio'] ?? '';
        $nombre_tipo_deposito = $_POST['nombre_tipo_deposito'] ?? '';
        $estado = $_POST['estado'] ?? '';
        $descripcion = trim($_POST['descripcion'] ?? '');

        // validación por si ya existe el código
        $sql_validar = "SELECT id_sitio  FROM sitio_deposito WHERE codigo_sitio_deposito = '$codigo_sitio_deposito'";
        $existe = $obj->select($sql_validar);

        $errores = [];

        if (!empty($existe)) {
            $errores[] = "Ya existe un terreno con ese código de sitio de depósito.";
        }

        if (empty($codigo_sitio_deposito)) {
            $errores[] = "El código del sitio de depósito es obligatorio.";
        }
        if (empty($nombre_sitio)) {
            $errores[] = "Debe seleccionar un sitio.";
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

            $sql3 = "SELECT id_tipo_deposito, nombre FROM tipo_de_deposito";
            $tipos_deposito = $obj->select($sql3);

            $sql4 = "SELECT id_sitio, nombre_sitio FROM sitio";
            $sitios = $obj->select($sql4);

            include_once '../model/Errores/ErrorModal.php';

            ErrorModal::verError($errores, getUrl('Terreno', 'Terreno', 'getCreate'));

            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $this->postInsert($codigo_sitio_deposito, (int) $nombre_sitio, (int) $nombre_tipo_deposito, (int) $estado, $descripcion, $obj);
        }
    }

    public function postInsert(string $codigo_sitio_deposito1, int $nombre_sitio1, int $nombre_tipo_deposito1, int $estado1, string $descripcion1, TerrenoModel $obj)
    {

        $codigo_sitio_deposito = mb_strtoupper($codigo_sitio_deposito1);
        $nombre_sitio = $nombre_sitio1;
        $nombre_tipo_deposito = $nombre_tipo_deposito1;
        $estado = $estado1;
        $descripcion = $descripcion1;

        $sql = "INSERT INTO sitio_deposito (codigo_sitio_deposito, id_sitio, id_tipo_deposito, id_estado, descripcion) 
    VALUES ('$codigo_sitio_deposito', $nombre_sitio, $nombre_tipo_deposito, $estado, '$descripcion')";

        $ejecutar = $obj->insert($sql);

        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "El terreno se registró correctamente.";
            redirect(getUrl("Terreno", "Terreno", "getConsultar"));
        } else {
            echo "No se registra un terreno";
        }
    }


    public function getConsultar()
    {
        include_once '../view/partials/Terreno/Consultar.php';
    }

    public function data()
    {
        $obj = new TerrenoModel();
        $sql = "SELECT 
        sd.id_sitio_deposito,
        sd.codigo_sitio_deposito,
        s.nombre_sitio AS sitio,
        td.nombre AS tipo_deposito,
        sd.descripcion,
        e.nombre_estado AS estado
    FROM sitio_deposito sd
    INNER JOIN sitio s ON sd.id_sitio = s.id_sitio
    INNER JOIN tipo_de_deposito td ON sd.id_tipo_deposito = td.id_tipo_deposito
    INNER JOIN estado e ON sd.id_estado = e.id_estado
    ORDER BY sd.id_sitio_deposito";
        $datos = $obj->select($sql);
        return $datos;
    }
    public function getEdit()
    {
        $id = $_GET['id'] ?? null;

        if (empty($id)) {
            redirect(getUrl("Terreno", "Terreno", "getConsultar"));
            return;
        }

        $obj = new TerrenoModel();
        $sql = "SELECT * FROM sitio_deposito WHERE id_sitio_deposito = $id";
        $datos = $obj->select($sql);

        $sql2 = "SELECT id_sitio, nombre_sitio FROM sitio";
        $sitios = $obj->select($sql2);

        $sql3 = "SELECT id_tipo_deposito, nombre FROM tipo_de_deposito";
        $tipos_deposito = $obj->select($sql3);

        $sql4 = "SELECT * FROM estado";
        $estados = $obj->select($sql4);

        include_once '../view/partials/Terreno/Editar.php';
    }

    public function validarUpdate()
    {
        $obj = new TerrenoModel();
        $cont = 0;

        $id = $_POST['id'] ?? '';
        $codigo_sitio_deposito = mb_strtoupper(trim($_POST['codigo_sitio_deposito'] ?? ''));
        $nombre_sitio = $_POST['nombre_sitio'] ?? '';
        $nombre_tipo_deposito = $_POST['nombre_tipo_deposito'] ?? '';
        $estado = $_POST['estado'] ?? '';
        $descripcion = trim($_POST['descripcion'] ?? '');

        $sql_validar = "SELECT id_sitio_deposito FROM sitio_deposito WHERE codigo_sitio_deposito = '$codigo_sitio_deposito' AND id_sitio_deposito != $id";
        $existe = $obj->select($sql_validar);

        $errores = [];

        if (!empty($existe)) {
            $errores[] = "Ya existe otro terreno con ese código de sitio de depósito.";
        }

        if (empty($id)) {
            $errores[] = "No se identificó el terreno a editar.";
        }
        if (empty($codigo_sitio_deposito)) {
            $errores[] = "El código del sitio de depósito es obligatorio.";
        }
        if (empty($nombre_sitio)) {
            $errores[] = "Debe seleccionar un sitio.";
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

            $sql = "SELECT * FROM sitio_deposito WHERE id_sitio_deposito = $id";
            $datos = $obj->select($sql);

            $sql2 = "SELECT id_sitio, nombre_sitio FROM sitio";
            $sitios = $obj->select($sql2);

            $sql3 = "SELECT id_tipo_deposito, nombre FROM tipo_de_deposito";
            $tipos_deposito = $obj->select($sql3);

            $sql4 = "SELECT * FROM estado";
            $estados = $obj->select($sql4);

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('Terreno', 'Terreno', 'getEdit', array('id' => $id)));

            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $this->postUpdate((int) $id, $codigo_sitio_deposito, (int) $nombre_sitio, (int) $nombre_tipo_deposito, (int) $estado, $descripcion, $obj);
        }
    }

    public function postUpdate(int $id, string $codigo_sitio_deposito, int $nombre_sitio, int $nombre_tipo_deposito, int $estado, string $descripcion, TerrenoModel $obj)
    {
        $sql = "UPDATE sitio_deposito SET 
        codigo_sitio_deposito = '$codigo_sitio_deposito',
        id_sitio = $nombre_sitio,
        id_tipo_deposito = $nombre_tipo_deposito,
        id_estado = $estado,
        descripcion = '$descripcion'
    WHERE id_sitio_deposito = $id";

        $ejecutar = $obj->update($sql);

        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "El terreno se actualizó correctamente.";
            redirect(getUrl("Terreno", "Terreno", "getConsultar"));
        } else {
            echo "No se pudo actualizar el terreno";
        }
    }

    public function posDelete()
    {
        $id = $_GET['id'];
        $obj = new TerrenoModel();

        $sql2 = "SELECT id_estado FROM sitio_deposito WHERE id_sitio_deposito = $id";
        $validacion = $obj->select($sql2);
        foreach ($validacion as $j) {

            if ($j['id_estado'] == 2) {
                echo '<script>alert("¡Este terreno ya esta inhabilitado!");</script>';
                redirect(getUrl("Terreno", "Terreno", "getConsultar"));
            }


            $sql = "UPDATE sitio_deposito SET id_estado = 2 WHERE id_sitio_deposito = $id";
            $ejecutar = $obj->update($sql);

            if ($ejecutar) {
                $_SESSION['mensaje_exito'] = "El terreno se inhabilitó correctamente.";
                redirect(getUrl("Terreno", "Terreno", "getConsultar"));
            } else {
                echo "No se inhabilitó el terreno";
            }
        }
    }
    public function getBuscar()
    {
        $busqueda = mb_strtoupper($_GET['busqueda'] ?? '');
        if (!empty($busqueda)) {
            $palabra = $_GET['busqueda'];
            $obj = new TerrenoModel();

            $sql = "SELECT 
            sd.id_sitio_deposito,
            sd.codigo_sitio_deposito,
            s.nombre_sitio AS sitio,
            td.nombre AS tipo_deposito,
            sd.descripcion,
            e.nombre_estado AS estado
        FROM sitio_deposito sd
        INNER JOIN sitio s ON sd.id_sitio = s.id_sitio
        INNER JOIN tipo_de_deposito td ON sd.id_tipo_deposito = td.id_tipo_deposito
        INNER JOIN estado e ON sd.id_estado = e.id_estado 
        WHERE sd.codigo_sitio_deposito ILIKE $1";

            $datos = $obj->select($sql, ['%' . $busqueda . '%']);

            include_once "../view/partials/Terreno/Busqueda.php";
        } else {
            include_once '../view/partials/Terreno/Consultar.php';
        }
    }
}
