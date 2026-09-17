<?php
include_once '../model/Sitios/SitiosModel.php';

class SitiosController
{







    public function posDelete()
    {
        $id = $_GET['id'];
        $obj = new SitiosModel();

        $sql2 = "SELECT id_estado from sitio WHERE id_sitio = $id";
        $validacion =  $obj->select($sql2);
        foreach ($validacion as $j) {

            if ($j['id_estado'] == 2) {
                echo '<script>alert("¡Este tanque ya esta inhabilitado!");</script>';
                redirect(getUrl("Sitios", "Sitios", "getConsultar"));
            }


            $sql = "UPDATE  sitio set id_estado = 2 WHERE id_sitio = $id";
            $ejecutar = $obj->update($sql);

            if ($ejecutar) {
                $_SESSION['mensaje_exito'] = "El sitio se inhabilito correctamente.";
                redirect(getUrl("Sitios", "Sitios", "getConsultar"));
            } else {
                echo "No se hinabilito el Sitio";
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

    $sql4 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
              FROM usuarios 
              WHERE id_rol = 3 AND id_zoocriadero IS NULL AND id_sitio IS NULL";
    $coord = $obj->select($sql4);

    $sql5 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
              FROM usuarios 
              WHERE id_rol = 5 AND id_zoocriadero IS NULL AND id_sitio IS NULL";
    $auxi = $obj->select($sql5);

    include_once '../model/Direcciones/direcciones.php';

    $old = $_SESSION['old_input'] ?? [];
    unset($_SESSION['old_input']);

    include_once '../view/partials/Sitios/Registrar.php';
}

    public function validarRegistrar()
{
    $obj = new SitiosModel();
    $_SESSION['old_input'] = $_POST;
    $cont = 0;
    $nombre = mb_strtoupper($_POST['nombre'] ?? '');
    $via_principal = $_POST['via_principal'] ?? '';
    $numero_via = $_POST['numero_via'] ?? '';
    $via_generadora = $_POST['via_generadora'] ?? '';
    $placa = $_POST['placa'] ?? '';
    $barrio = $_POST['barrio'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $id_coor = $_POST['id_coor'] ?? '';
    $usuarios_asignados = $_POST['usuarios_asignados'] ?? [];

    $sufijo_via = trim($_POST['sufijo_via'] ?? '');
    $cruce_prefijo = trim($_POST['cruce_prefijo'] ?? '');
    $sufijo_generadora = trim($_POST['sufijo_generadora'] ?? '');

    $sql_validar = "SELECT id_sitio FROM sitio WHERE nombre_sitio = '$nombre'";
    $existe = $obj->select($sql_validar);

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

    if (!empty($existe)) {
        $errores[] = "Ya existe un sitio con ese nombre";
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
    if (empty($id_coor)) {
        $errores[] = "Debe seleccionar un coordinador.";
    }

    $nombre_validar = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/u';
    if (!empty($nombre) && !preg_match($nombre_validar, $nombre)) {
        $errores[] = "El nombre solo puede contener letras y espacios.";
    }

    // el coordinador debe ser rol 3 (Coordinador Terreno) y no estar ya asignado
    if (!empty($id_coor)) {
        $sql_coor = "SELECT id_usuario FROM usuarios 
                     WHERE id_usuario = " . (int) $id_coor . " 
                     AND id_rol = 3
                     AND (id_zoocriadero IS NOT NULL OR id_sitio IS NOT NULL)";
        $coor_ocupado = $obj->select($sql_coor);
        if (!empty($coor_ocupado)) {
            $errores[] = "El coordinador seleccionado ya está asignado a otro sitio o zoocriadero.";
        }
    }

    // los auxiliares deben ser rol 5 (Auxiliar Terreno) y no estar ya asignados
    if (!empty($usuarios_asignados)) {
        $ids_aux = implode(',', array_map('intval', $usuarios_asignados));
        $sql_aux = "SELECT id_usuario FROM usuarios 
                    WHERE id_usuario IN ($ids_aux) 
                    AND id_rol = 5
                    AND (id_zoocriadero IS NOT NULL OR id_sitio IS NOT NULL)";
        $aux_ocupados = $obj->select($sql_aux);
        if (!empty($aux_ocupados)) {
            $errores[] = "Uno o más auxiliares seleccionados ya están asignados a otro sitio o zoocriadero.";
        }
    }

    if (!empty($errores)) {

        $sql2 = "SELECT * FROM barrio";
        $barrios = $obj->select($sql2);

        $sql3 = "SELECT * from estado";
        $estados = $obj->select($sql3);

        $sql4 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
                  FROM usuarios WHERE id_rol = 3 AND id_zoocriadero IS NULL AND id_sitio IS NULL";
        $coord = $obj->select($sql4);

        $sql5 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
                  FROM usuarios WHERE id_rol = 5 AND id_zoocriadero IS NULL AND id_sitio IS NULL";
        $auxi = $obj->select($sql5);

        include_once '../model/Errores/ErrorModal.php';
        ErrorModal::verError($errores, getUrl('Sitios', 'Sitios', 'getCreate2'));

        return;
    } else {
        $cont = 1;
    }

    if ($cont == 1) {
        $direccion = "$via_principal $numero_via$sufijo_via # $cruce_prefijo$via_generadora$sufijo_generadora-$placa";
        $this->postInsert($nombre, $direccion, $barrio, $estado, (int) $id_coor, $usuarios_asignados, $obj);
    }
}

    public function postInsert(string $nombre1, string $direccion1, int $barrio1, int $estado1, int $id_coor1, array $auxiliares1, SitiosModel $obj)
    {
        $nombre = mb_strtoupper($nombre1);
        $direccion = $direccion1;
        $barrio = $barrio1;
        $estado = $estado1;
        $id_coor = $id_coor1;
        $auxiliares = $auxiliares1;

        $sql = "INSERT INTO sitio (nombre_sitio, direccion, id_barrio, id_estado) 
            VALUES ('$nombre', '$direccion', $barrio, $estado)
            RETURNING id_sitio";

        $resultado = $obj->select($sql);
        $id_sitio = $resultado[0]['id_sitio'] ?? null;

        if ($id_sitio) {

            $sql_coor = "UPDATE usuarios SET id_sitio = $id_sitio WHERE id_usuario = $id_coor";
            $obj->update($sql_coor);

            if (!empty($auxiliares)) {
                $ids_aux = implode(',', array_map('intval', $auxiliares));
                $sql_aux = "UPDATE usuarios SET id_sitio = $id_sitio WHERE id_usuario IN ($ids_aux)";
                $obj->update($sql_aux);
            }

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
        e.nombre_estado AS estado,
        coor.nombre_coor AS coordinador,
        aux.nombres_aux AS auxiliares
    FROM sitio s
    INNER JOIN barrio b ON s.id_barrio = b.id_barrio
    INNER JOIN estado e ON s.id_estado = e.id_estado
    LEFT JOIN (
        SELECT id_sitio, CONCAT(primer_nombre, ' ', primer_apellido) AS nombre_coor
        FROM usuarios
        WHERE id_rol = 2
    ) coor ON coor.id_sitio = s.id_sitio
    LEFT JOIN (
        SELECT id_sitio, STRING_AGG(CONCAT(primer_nombre, ' ', primer_apellido), ', ') AS nombres_aux
        FROM usuarios
        WHERE id_rol = 3
        GROUP BY id_sitio
    ) aux ON aux.id_sitio = s.id_sitio
    ORDER BY s.id_sitio";
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
    include_once '../model/Direcciones/direcciones.php';
    $partes = parsearDireccion($datos[0]['direccion']);

    $sql2 = "SELECT * FROM barrio";
    $barrios = $obj->select($sql2);

    $sql3 = "SELECT * from estado";
    $estados = $obj->select($sql3);

    $sql4 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
              FROM usuarios 
              WHERE id_rol = 3 AND ((id_zoocriadero IS NULL AND id_sitio IS NULL) OR id_sitio = $id)";
    $coord = $obj->select($sql4);

    $sql5 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
              FROM usuarios 
              WHERE id_rol = 5 AND ((id_zoocriadero IS NULL AND id_sitio IS NULL) OR id_sitio = $id)";
    $auxi = $obj->select($sql5);

    $sql6 = "SELECT id_usuario FROM usuarios WHERE id_sitio = $id AND id_rol = 3";
    $coor_result = $obj->select($sql6);
    $coor_actual = $coor_result[0] ?? null;

    $sql7 = "SELECT id_usuario FROM usuarios WHERE id_sitio = $id AND id_rol = 5";
    $auxi_result = $obj->select($sql7);
    $auxi_actuales = array_column($auxi_result, 'id_usuario');

    include_once '../view/partials/Sitios/Editar.php';
}


   public function validarUpdate()
{
    $obj = new SitiosModel();
    $cont = 0;
    $id = $_POST['id'] ?? '';
    $nombre = mb_strtoupper($_POST['nombre'] ?? '');
    $via_principal = $_POST['via_principal'] ?? '';
    $numero_via = $_POST['numero_via'] ?? '';
    $via_generadora = $_POST['via_generadora'] ?? '';
    $placa = $_POST['placa'] ?? '';
    $barrio = $_POST['barrio'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $id_coor = $_POST['id_coor'] ?? '';
    $usuarios_asignados = $_POST['usuarios_asignados'] ?? [];

    $sufijo_via = trim($_POST['sufijo_via'] ?? '');
    $cruce_prefijo = trim($_POST['cruce_prefijo'] ?? '');
    $sufijo_generadora = trim($_POST['sufijo_generadora'] ?? '');

    $sql_validar = "SELECT id_sitio FROM sitio WHERE nombre_sitio = '$nombre' AND id_sitio != $id";
    $existe = $obj->select($sql_validar);

    $errores = [];

    if (!empty($existe)) {
        $errores[] = "Ya existe un sitio con ese nombre";
    }
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
    if (empty($id_coor)) {
        $errores[] = "Debe seleccionar un coordinador.";
    }

    $nombre_validar = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/u';
    if (!empty($nombre) && !preg_match($nombre_validar, $nombre)) {
        $errores[] = "El nombre solo puede contener letras y espacios.";
    }

   
    if (!empty($id_coor)) {
        $sql_coor = "SELECT id_usuario FROM usuarios 
                     WHERE id_usuario = " . (int) $id_coor . " 
                     AND id_rol = 3
                     AND (id_zoocriadero IS NOT NULL OR (id_sitio IS NOT NULL AND id_sitio != $id))";
        $coor_ocupado = $obj->select($sql_coor);
        if (!empty($coor_ocupado)) {
            $errores[] = "El coordinador seleccionado ya está asignado a otro sitio o zoocriadero.";
        }
    }

  
    if (!empty($usuarios_asignados)) {
        $ids_aux = implode(',', array_map('intval', $usuarios_asignados));
        $sql_aux = "SELECT id_usuario FROM usuarios 
                    WHERE id_usuario IN ($ids_aux) 
                    AND id_rol = 5
                    AND (id_zoocriadero IS NOT NULL OR (id_sitio IS NOT NULL AND id_sitio != $id))";
        $aux_ocupados = $obj->select($sql_aux);
        if (!empty($aux_ocupados)) {
            $errores[] = "Uno o más auxiliares seleccionados ya están asignados a otro sitio o zoocriadero.";
        }
    }

    if (!empty($errores)) {

        $sql = "SELECT * from sitio WHERE id_sitio = $id";
        $datos = $obj->select($sql);
        include_once '../model/Direcciones/direcciones.php';
        $partes = parsearDireccion($datos[0]['direccion']);

        $sql2 = "SELECT * FROM barrio";
        $barrios = $obj->select($sql2);

        $sql3 = "SELECT * from estado";
        $estados = $obj->select($sql3);

        $sql4 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
                  FROM usuarios WHERE id_rol = 3 AND ((id_zoocriadero IS NULL AND id_sitio IS NULL) OR id_sitio = $id)";
        $coord = $obj->select($sql4);

        $sql5 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
                  FROM usuarios WHERE id_rol = 5 AND ((id_zoocriadero IS NULL AND id_sitio IS NULL) OR id_sitio = $id)";
        $auxi = $obj->select($sql5);

        $sql6 = "SELECT id_usuario FROM usuarios WHERE id_sitio = $id AND id_rol = 3";
        $coor_result = $obj->select($sql6);
        $coor_actual = $coor_result[0] ?? null;

        $sql7 = "SELECT id_usuario FROM usuarios WHERE id_sitio = $id AND id_rol = 5";
        $auxi_result = $obj->select($sql7);
        $auxi_actuales = array_column($auxi_result, 'id_usuario');

        include_once '../model/Errores/ErrorModal.php';
        ErrorModal::verError($errores, getUrl('Sitios', 'Sitios', 'getEdit', array('id' => $id)));

        return;
    } else {
        $cont = 1;
    }

    if ($cont == 1) {
        $direccion = "$via_principal $numero_via$sufijo_via # $cruce_prefijo$via_generadora$sufijo_generadora-$placa";
        $this->postUpdate((int) $id, $nombre, $direccion, $barrio, $estado, (int) $id_coor, $usuarios_asignados, $obj);
    }
}
    public function postUpdate(int $id, string $nombre, string $direccion, int $barrio, int $estado, int $id_coor, array $auxiliares, SitiosModel $obj)
{
    $sql = "UPDATE sitio SET 
        nombre_sitio = '$nombre',
        direccion = '$direccion',
        id_barrio = $barrio,
        id_estado = $estado
    WHERE id_sitio = $id";

    $ejecutar = $obj->update($sql);

    if ($ejecutar) {

      
        $sql_liberar = "UPDATE usuarios SET id_sitio = NULL WHERE id_sitio = $id";
        $obj->update($sql_liberar);

 
        $sql_coor = "UPDATE usuarios SET id_sitio = $id WHERE id_usuario = $id_coor";
        $obj->update($sql_coor);

      
        if (!empty($auxiliares)) {
            $ids_aux = implode(',', array_map('intval', $auxiliares));
            $sql_aux = "UPDATE usuarios SET id_sitio = $id WHERE id_usuario IN ($ids_aux)";
            $obj->update($sql_aux);
        }

        $_SESSION['mensaje_exito'] = "El sitio se actualizó correctamente.";
        redirect(getUrl("Sitios", "Sitios", "getConsultar"));
    } else {
        echo "No se pudo actualizar el sitio";
    }
}
}
