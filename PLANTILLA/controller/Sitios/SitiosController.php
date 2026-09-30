<?php
include_once '../model/Sitios/SitiosModel.php';

class SitiosController
{

    private function inPlaceholders(array $items, int $start = 1): array
    {
        $placeholders = [];
        for ($i = 0; $i < count($items); $i++) {
            $placeholders[] = '$' . ($start + $i);
        }
        return $placeholders;
    }

    public function posDelete()
    {
        $id = $_GET['id'] ?? null;
        $obj = new SitiosModel();

        $sql2 = "SELECT id_estado from sitio WHERE id_sitio = $1";
        $validacion = $obj->select($sql2, [$id]);
        foreach ($validacion as $j) {

            $sql = "UPDATE sitio SET id_estado = 2 WHERE id_sitio = $1";
            $ejecutar = $obj->update($sql, [$id]);

            if ($ejecutar) {
                $_SESSION['mensaje_exito'] = "El sitio se inhabilito correctamente.";
                redirect(getUrl("Sitios", "Sitios", "getConsultar"));
            } else {
                echo "No se hinabilito el Sitio";
            }
        }
    }

    public function posHabilitar()
    {
        $id = $_GET['id'] ?? null;
        $obj = new SitiosModel();

        $sql2 = "SELECT id_estado from sitio WHERE id_sitio = $1";
        $validacion = $obj->select($sql2, [$id]);
        foreach ($validacion as $j) {

            $sql = "UPDATE sitio SET id_estado = 1 WHERE id_sitio = $1";
            $ejecutar = $obj->update($sql, [$id]);

            if ($ejecutar) {
                $_SESSION['mensaje_exito'] = "El sitio se habilito correctamente.";
                redirect(getUrl("Sitios", "Sitios", "getConsultar"));
            } else {
                echo "No se habilito el Sitio";
            }
        }
    }

    public function getCreate2()
    {
        $obj = new SitiosModel();

        // ← NUEVO: comunas
        $sql_comunas = "SELECT id_comuna, nombre_comuna FROM comuna WHERE id_estado = 1 ORDER BY id_comuna";
        $comunas = $obj->select($sql_comunas);

        // ← MODIFICADO: barrios con id_comuna
        $sql2 = "SELECT id_barrio, nombre_barrio, id_comuna FROM barrio WHERE id_estado = 1 ORDER BY nombre_barrio";
        $barrios = $obj->select($sql2);

        // Solo Activo e Inactivo
        $sql3 = "SELECT * FROM estado WHERE id_estado IN (1, 2) ORDER BY id_estado";
        $estados = $obj->select($sql3);

        // Coordinador = id_rol 2
        $sql4 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
              FROM usuarios 
              WHERE id_rol = 2 AND id_zoocriadero IS NULL AND id_sitio IS NULL";
        $coord = $obj->select($sql4);

        // Auxiliar = id_rol 3
        $sql5 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
              FROM usuarios 
              WHERE id_rol = 3 AND id_zoocriadero IS NULL AND id_sitio IS NULL";
        $auxi = $obj->select($sql5);

        $sql6 = "SELECT id_tipo_deposito, nombre FROM tipo_de_deposito";
        $tipos_deposito = $obj->select($sql6);

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
        $comuna = $_POST['comuna'] ?? '';   // ← NUEVO
        $estado = $_POST['estado'] ?? '';
        $id_coor = $_POST['id_coor'] ?? '';
        $usuarios_asignados = $_POST['usuarios_asignados'] ?? [];

        $sufijo_via = trim($_POST['sufijo_via'] ?? '');
        $cruce_prefijo = trim($_POST['cruce_prefijo'] ?? '');
        $sufijo_generadora = trim($_POST['sufijo_generadora'] ?? '');

        $id_tipo_deposito = $_POST['id_tipo_deposito'] ?? '';
        $descripcion = trim($_POST['descripcion'] ?? '');

        $sql_validar = "SELECT id_sitio FROM sitio WHERE nombre_sitio = $1";
        $existe = $obj->select($sql_validar, [$nombre]);

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
        if (empty($comuna)) {
            $errores[] = "Debe seleccionar una comuna.";   // ← NUEVO
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
        if (empty($id_tipo_deposito)) {
            $errores[] = "Debe seleccionar un tipo de depósito.";
        }
        if (mb_strlen($descripcion) > 300) {
            $errores[] = "La descripción no puede superar los 300 caracteres.";
        }

        $nombre_validar = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/u';
        if (!empty($nombre) && !preg_match($nombre_validar, $nombre)) {
            $errores[] = "El nombre solo puede contener letras y espacios.";
        }

        // Coordinador = id_rol 2
        if (!empty($id_coor)) {
            $sql_coor = "SELECT id_usuario FROM usuarios 
                     WHERE id_usuario = $1 
                     AND id_rol = 2
                     AND (id_zoocriadero IS NOT NULL OR id_sitio IS NOT NULL)";
            $coor_ocupado = $obj->select($sql_coor, [(int) $id_coor]);
            if (!empty($coor_ocupado)) {
                $errores[] = "El coordinador seleccionado ya está asignado a otro sitio o zoocriadero.";
            }
        }

        // Auxiliar = id_rol 3
        if (!empty($usuarios_asignados)) {
            $ids_aux = array_map('intval', $usuarios_asignados);
            $placeholders = implode(',', $this->inPlaceholders($ids_aux));
            $sql_aux = "SELECT id_usuario FROM usuarios 
                    WHERE id_usuario IN ($placeholders) 
                    AND id_rol = 3
                    AND (id_zoocriadero IS NOT NULL OR id_sitio IS NOT NULL)";
            $aux_ocupados = $obj->select($sql_aux, $ids_aux);
            if (!empty($aux_ocupados)) {
                $errores[] = "Uno o más auxiliares seleccionados ya están asignados a otro sitio o zoocriadero.";
            }
        }

        if (!empty($errores)) {

            // ← NUEVO: comunas
            $sql_comunas = "SELECT id_comuna, nombre_comuna FROM comuna WHERE id_estado = 1 ORDER BY id_comuna";
            $comunas = $obj->select($sql_comunas);

            // ← MODIFICADO: barrios con id_comuna
            $sql2 = "SELECT id_barrio, nombre_barrio, id_comuna FROM barrio WHERE id_estado = 1 ORDER BY nombre_barrio";
            $barrios = $obj->select($sql2);

            $sql3 = "SELECT * from estado";
            $estados = $obj->select($sql3);

            $sql4 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
                  FROM usuarios WHERE id_rol = 2 AND id_zoocriadero IS NULL AND id_sitio IS NULL";
            $coord = $obj->select($sql4);

            $sql5 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
                  FROM usuarios WHERE id_rol = 3 AND id_zoocriadero IS NULL AND id_sitio IS NULL";
            $auxi = $obj->select($sql5);

            $sql6 = "SELECT id_tipo_deposito, nombre FROM tipo_de_deposito";
            $tipos_deposito = $obj->select($sql6);

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('Sitios', 'Sitios', 'getCreate2'));

            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $direccion = "$via_principal $numero_via$sufijo_via # $cruce_prefijo$via_generadora$sufijo_generadora-$placa";
            $this->postInsert($nombre,$direccion,(int) $barrio,(int) $estado,(int) $id_coor,$usuarios_asignados,(int) $id_tipo_deposito,$descripcion,(int) $comuna,$obj);
        }
    }

    public function postInsert(string $nombre1, string $direccion1, int $barrio1, int $estado1, int $id_coor1, array $auxiliares1, int $id_tipo_deposito1, string $descripcion1, int $comuna1, SitiosModel $obj)
    {
        $nombre = mb_strtoupper($nombre1);
        $direccion = $direccion1;
        $barrio = $barrio1;
        $estado = $estado1;
        $id_coor = $id_coor1;
        $auxiliares = $auxiliares1;
        $id_tipo_deposito = $id_tipo_deposito1;
        $descripcion = $descripcion1;
        $comuna = $comuna1;   

        
        $sql = "INSERT INTO sitio (nombre_sitio, direccion, id_barrio, id_estado, id_tipo_deposito, descripcion, comuna) 
            VALUES ($1, $2, $3, $4, $5, $6, $7)
            RETURNING id_sitio";

        $resultado = $obj->select($sql, [$nombre, $direccion, $barrio, $estado, $id_tipo_deposito, $descripcion, $comuna]);
        $id_sitio = $resultado[0]['id_sitio'] ?? null;

        if ($id_sitio) {

            $sql_coor = "UPDATE usuarios SET id_sitio = $1 WHERE id_usuario = $2";
            $obj->update($sql_coor, [$id_sitio, $id_coor]);

            if (!empty($auxiliares)) {
                $ids_aux = array_map('intval', $auxiliares);
                $placeholders = implode(',', $this->inPlaceholders($ids_aux, 2));
                $sql_aux = "UPDATE usuarios SET id_sitio = $1 WHERE id_usuario IN ($placeholders)";
                $obj->update($sql_aux, array_merge([$id_sitio], $ids_aux));
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
        co.nombre_comuna AS comuna,   
        e.nombre_estado AS estado,
        coor.nombre_coor AS coordinador,
        aux.nombres_aux AS auxiliares,
        td.nombre AS tipo_deposito,
        s.descripcion
    FROM sitio s
    INNER JOIN barrio b ON s.id_barrio = b.id_barrio
    INNER JOIN estado e ON s.id_estado = e.id_estado
    LEFT JOIN comuna co ON s.comuna = co.id_comuna   
    LEFT JOIN tipo_de_deposito td ON s.id_tipo_deposito = td.id_tipo_deposito
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

        $sql = "SELECT * from sitio WHERE id_sitio = $1";
        $datos = $obj->select($sql, [$id]);
        include_once '../model/Direcciones/direcciones.php';
        $partes = parsearDireccion($datos[0]['direccion']);

       
        $sql_comunas = "SELECT id_comuna, nombre_comuna FROM comuna WHERE id_estado = 1 ORDER BY id_comuna";
        $comunas = $obj->select($sql_comunas);

        
        $sql_barrios = "SELECT id_barrio, nombre_barrio, id_comuna FROM barrio WHERE id_estado = 1 ORDER BY nombre_barrio";
        $barrios = $obj->select($sql_barrios);

        
        $sql3 = "SELECT * FROM estado WHERE id_estado IN (1, 2) ORDER BY id_estado";
        $estados = $obj->select($sql3);

        
        $sql4 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
              FROM usuarios 
              WHERE id_rol = 2 AND ((id_zoocriadero IS NULL AND id_sitio IS NULL) OR id_sitio = $1)";
        $coord = $obj->select($sql4, [$id]);

        
        $sql5 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
              FROM usuarios 
              WHERE id_rol = 3 AND ((id_zoocriadero IS NULL AND id_sitio IS NULL) OR id_sitio = $1)";
        $auxi = $obj->select($sql5, [$id]);

        $sql6 = "SELECT id_usuario FROM usuarios WHERE id_sitio = $1 AND id_rol = 2";
        $coor_result = $obj->select($sql6, [$id]);
        $coor_actual = $coor_result[0] ?? null;

        $sql7 = "SELECT id_usuario FROM usuarios WHERE id_sitio = $1 AND id_rol = 3";
        $auxi_result = $obj->select($sql7, [$id]);
        $auxi_actuales = array_column($auxi_result, 'id_usuario');

        $sql8 = "SELECT id_tipo_deposito, nombre FROM tipo_de_deposito";
        $tipos_deposito = $obj->select($sql8);

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
        $comuna = $_POST['comuna'] ?? '';   
        $estado = $_POST['estado'] ?? '';
        $id_coor = $_POST['id_coor'] ?? '';
        $usuarios_asignados = $_POST['usuarios_asignados'] ?? [];

        $sufijo_via = trim($_POST['sufijo_via'] ?? '');
        $cruce_prefijo = trim($_POST['cruce_prefijo'] ?? '');
        $sufijo_generadora = trim($_POST['sufijo_generadora'] ?? '');

        $id_tipo_deposito = $_POST['id_tipo_deposito'] ?? '';
        $descripcion = trim($_POST['descripcion'] ?? '');

        $sql_validar = "SELECT id_sitio FROM sitio WHERE nombre_sitio = $1 AND id_sitio != $2";
        $existe = $obj->select($sql_validar, [$nombre, $id]);

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
        if (empty($comuna)) {
            $errores[] = "Debe seleccionar una comuna.";   
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
        if (empty($id_tipo_deposito)) {
            $errores[] = "Debe seleccionar un tipo de depósito.";
        }
        if (mb_strlen($descripcion) > 300) {
            $errores[] = "La descripción no puede superar los 300 caracteres.";
        }

        $nombre_validar = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/u';
        if (!empty($nombre) && !preg_match($nombre_validar, $nombre)) {
            $errores[] = "El nombre solo puede contener letras y espacios.";
        }

        
        if (!empty($id_coor)) {
            $sql_coor = "SELECT id_usuario FROM usuarios 
                     WHERE id_usuario = $1 
                     AND id_rol = 2
                     AND (id_zoocriadero IS NOT NULL OR (id_sitio IS NOT NULL AND id_sitio != $2))";
            $coor_ocupado = $obj->select($sql_coor, [(int) $id_coor, $id]);
            if (!empty($coor_ocupado)) {
                $errores[] = "El coordinador seleccionado ya está asignado a otro sitio o zoocriadero.";
            }
        }

       
        if (!empty($usuarios_asignados)) {
            $ids_aux = array_map('intval', $usuarios_asignados);
            $placeholders = implode(',', $this->inPlaceholders($ids_aux, 2));
            $sql_aux = "SELECT id_usuario FROM usuarios 
                    WHERE id_usuario IN ($placeholders) 
                    AND id_rol = 3
                    AND (id_zoocriadero IS NOT NULL OR (id_sitio IS NOT NULL AND id_sitio != $1))";
            $aux_ocupados = $obj->select($sql_aux, array_merge([$id], $ids_aux));
            if (!empty($aux_ocupados)) {
                $errores[] = "Uno o más auxiliares seleccionados ya están asignados a otro sitio o zoocriadero.";
            }
        }

        if (!empty($errores)) {

            $sql = "SELECT * from sitio WHERE id_sitio = $1";
            $datos = $obj->select($sql, [$id]);
            include_once '../model/Direcciones/direcciones.php';
            $partes = parsearDireccion($datos[0]['direccion']);

         
            $sql_comunas = "SELECT id_comuna, nombre_comuna FROM comuna WHERE id_estado = 1 ORDER BY id_comuna";
            $comunas = $obj->select($sql_comunas);

            $sql_barrios = "SELECT id_barrio, nombre_barrio, id_comuna FROM barrio WHERE id_estado = 1 ORDER BY nombre_barrio";
            $barrios = $obj->select($sql_barrios);

            
            $sql3 = "SELECT * FROM estado WHERE id_estado IN (1, 2) ORDER BY id_estado";
            $estados = $obj->select($sql3);

            $sql4 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
                  FROM usuarios WHERE id_rol = 2 AND ((id_zoocriadero IS NULL AND id_sitio IS NULL) OR id_sitio = $1)";
            $coord = $obj->select($sql4, [$id]);

            $sql5 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido 
                  FROM usuarios WHERE id_rol = 3 AND ((id_zoocriadero IS NULL AND id_sitio IS NULL) OR id_sitio = $1)";
            $auxi = $obj->select($sql5, [$id]);

            $sql6 = "SELECT id_usuario FROM usuarios WHERE id_sitio = $1 AND id_rol = 2";
            $coor_result = $obj->select($sql6, [$id]);
            $coor_actual = $coor_result[0] ?? null;

            $sql7 = "SELECT id_usuario FROM usuarios WHERE id_sitio = $1 AND id_rol = 3";
            $auxi_result = $obj->select($sql7, [$id]);
            $auxi_actuales = array_column($auxi_result, 'id_usuario');

            $sql8 = "SELECT id_tipo_deposito, nombre FROM tipo_de_deposito";
            $tipos_deposito = $obj->select($sql8);

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('Sitios', 'Sitios', 'getEdit', array('id' => $id)));

            return;
        } else {
            $cont = 1;
        }

        if ($cont == 1) {
            $direccion = "$via_principal $numero_via$sufijo_via # $cruce_prefijo$via_generadora$sufijo_generadora-$placa";
            $id_coor_final = !empty($id_coor) ? (int) $id_coor : null;
            $this->postUpdate((int) $id,$nombre,$direccion,(int) $barrio,(int) $estado,$id_coor_final,$usuarios_asignados,(int) $id_tipo_deposito,$descripcion,(int) $comuna,$obj);
        }
    }

    public function postUpdate(int $id, string $nombre, string $direccion, int $barrio, int $estado, ?int $id_coor, array $auxiliares, int $id_tipo_deposito, string $descripcion, int $comuna, SitiosModel $obj)
    {

        if (empty($id_coor)) {
            $estado = 2;
        }

        
        $sql = "UPDATE sitio SET 
        nombre_sitio = $1,
        direccion = $2,
        id_barrio = $3,
        id_estado = $4,
        id_tipo_deposito = $5,
        descripcion = $6,
        comuna = $7
    WHERE id_sitio = $8";

        $ejecutar = $obj->update($sql, [$nombre, $direccion, $barrio, $estado, $id_tipo_deposito, $descripcion, $comuna, $id]);

        if ($ejecutar) {

            $sql_liberar = "UPDATE usuarios SET id_sitio = NULL WHERE id_sitio = $1";
            $obj->update($sql_liberar, [$id]);

            if (!empty($id_coor)) {
                $sql_coor = "UPDATE usuarios SET id_sitio = $1 WHERE id_usuario = $2";
                $obj->update($sql_coor, [$id, $id_coor]);
            }

            if (!empty($auxiliares)) {
                $ids_aux = array_map('intval', $auxiliares);
                $placeholders = implode(',', $this->inPlaceholders($ids_aux, 2));
                $sql_aux = "UPDATE usuarios SET id_sitio = $1 WHERE id_usuario IN ($placeholders)";
                $obj->update($sql_aux, array_merge([$id], $ids_aux));
            }

            $_SESSION['mensaje_exito'] = "El sitio se actualizó correctamente.";
            redirect(getUrl("Sitios", "Sitios", "getConsultar"));
        } else {
            echo "No se pudo actualizar el sitio";
        }
    }

    public function getBuscar()
    {
        $busqueda = mb_strtoupper($_GET['busqueda'] ?? '');
        if (!empty($busqueda)) {
            $palabra = $_GET['busqueda'];
            $obj = new SitiosModel();

            $sql = "SELECT 
                s.id_sitio,
                s.nombre_sitio,
                s.direccion,
                b.nombre_barrio AS barrio,
                co.nombre_comuna AS comuna,   
                e.nombre_estado AS estado,
                coor.nombre_coor AS coordinador,
                aux.nombres_aux AS auxiliares,
                td.nombre AS tipo_deposito,
                s.descripcion
            FROM sitio s
            INNER JOIN barrio b ON s.id_barrio = b.id_barrio
            INNER JOIN estado e ON s.id_estado = e.id_estado
            LEFT JOIN comuna co ON s.comuna = co.id_comuna   
            LEFT JOIN tipo_de_deposito td ON s.id_tipo_deposito = td.id_tipo_deposito
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
            WHERE s.nombre_sitio ILIKE $1
            ORDER BY s.id_sitio";

            $datos = $obj->select($sql, ['%' . $busqueda . '%']);

            include_once "../view/partials/Sitios/Busqueda.php";
        } else {
            include_once '../view/partials/Sitios/Consultar.php';
        }
    }
}