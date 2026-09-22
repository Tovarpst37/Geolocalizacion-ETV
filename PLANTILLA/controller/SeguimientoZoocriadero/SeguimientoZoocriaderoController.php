<?php

include_once '../model/SeguimientoZoocriadero/SeguimientoZoocriaderoModel';


class SeguimientoZoocriaderoController
{
    private const ID_ACTIVIDAD_ALIMENTACION = 1;
    private const ID_ACTIVIDAD_PECES_MUERTOS_NACIDOS = 2;

    private const ID_ACTIVIDAD_LIMPIEZA = 3;
    private const ID_ACTIVIDAD_AJUSTES_NIVEL = 4;
    private const ID_ACTIVIDAD_LAVADO = 5;





    
        public function getConsultar()
        {



            $obj = new SeguimientoZoocriaderoModel();

            $sql = "SELECT s.id_seguimiento_zoo, s.cod_seguimiento, s.fecha, u.documento, s.id_estado, e.nombre_estado
                FROM seguimiento_zoocriadero s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                LEFT JOIN estado e ON s.id_estado = e.id_estado
                ORDER BY s.id_seguimiento_zoo DESC";

        $seguimientos = $obj->select($sql);

            if (count($seguimientos) <= 0) {
                include_once '../view/partials/SeguimientoZoocriadero/notExist.php';
            } else {
                include_once '../view/partials/SeguimientoZoocriadero/Consultar.php';
            }



        }

        
            


    public function getRegistrar()
    {

        $obj = new SeguimientoZoocriaderoModel();
        $sql = "SELECT * from zoocriadero";
        $zoocriaderos = $obj->select($sql);

        $sql3 = "SELECT MAX(id_seguimiento_zoo) FROM seguimiento_zoocriadero";
        $id_seg = $obj->select($sql3);

        $sql2 = "SELECT * from estado WHERE tipo_estado = 'seguimiento'";
        $estados = $obj->select($sql2);

        $sql3 = "SELECT * from actividad_zoocriadero WHERE id_estado = 1 ORDER BY id_actividad_zoo";
        $actividades = $obj->select($sql3);

        include_once '../view/partials/SeguimientoZoocriadero/Registrar.php';
    }




    // ... (getConsultar, getRegistrar, getEditar, postDelete, getBuscar, getTanquesPorZoo quedan igual) ...

    public function postRegistrar()
    {
        $obj = new SeguimientoZoocriaderoModel();

        $codigo = mb_strtoupper($_POST['codigo']) ?? '';
        $zoo = $_POST['select_zoo'] ?? '';
        $estado = 5;
        $usuario = $_POST['selectUsuarios'] ?? '';
        $tanque = $_POST['selectTanques'] ?? '';
        $actividades = $_POST['actividades'] ?? [];
        $sql_validar = "SELECT id_seguimiento_zoo FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1 ";
        $existe = $obj->select($sql_validar, [$codigo]);

        $errores = [];


        if (!empty($existe)) {
            $errores[] = "Ya existe un seguimiento con ese código";
        }
        if (empty($codigo)) {
            $errores[] = "Debe ingresar el codigo del seguimiento";
        }
        if (empty($zoo)) {
            $errores[] = "Debe seleccionar el zoocriadero.";
        }
        if (empty($estado)) {
            $errores[] = "Debe seleccionar el estado del seguimiento.";
        }
        if (empty($usuario)) {
            $errores[] = "Debe seleccionar el Auxiliar asignado.";
        }
        if (empty($tanque)) {
            $errores[] = "Debe seleccionar el tanque al que se le hara el seguimiento.";
        }

        // ---- ALIMENTACIÓN ----
        $tieneAlimentacion = in_array(self::ID_ACTIVIDAD_ALIMENTACION, $actividades);

        $tipo_pez = $_POST['tipo_pez'] ?? '';
        $tipo_alimen = $_POST['tipo_alimen'] ?? '';
        $obAlimen = trim($_POST['ob'] ?? '');
        $obAlimen = strip_tags($obAlimen);


        if ($tieneAlimentacion) {
            if (empty($tipo_pez))
                $errores[] = "Debe seleccionar el tipo de pez.";
            if (empty($tipo_alimen))
                $errores[] = "Debe seleccionar el tipo de alimentación.";
            if (empty($obAlimen))
                $errores[] = "Las observaciones de alimentación son obligatorias.";
            if (strlen($obAlimen) > 250)
                $errores[] = "Las observaciones de alimentación no pueden superar los 250 caracteres.";
        }

        // ---- PECES MUERTOS Y NACIDOS ----
        $tienePecesMuertosNacidos = in_array(self::ID_ACTIVIDAD_PECES_MUERTOS_NACIDOS, $actividades);

        $canpez = $_POST['canpez'] ?? '';
        $muerto_Macho = $_POST['muerto_Macho'] ?? '';
        $muerto_Hembra = $_POST['muerto_Hembra'] ?? '';
        $obPeces = trim($_POST['obM'] ?? '');
        $obPeces = strip_tags($obPeces);

        if ($tienePecesMuertosNacidos) {
            if ($canpez === '' || !is_numeric($canpez) || $canpez < 0) {
                $errores[] = "La cantidad de peces nacidos debe ser un número mayor o igual a 0.";
            }
            if ($muerto_Macho === '' || !is_numeric($muerto_Macho) || $muerto_Macho < 0) {
                $errores[] = "La cantidad de machos muertos debe ser un número mayor o igual a 0.";
            }
            if ($muerto_Hembra === '' || !is_numeric($muerto_Hembra) || $muerto_Hembra < 0) {
                $errores[] = "La cantidad de hembras muertas debe ser un número mayor o igual a 0.";
            }
            if (empty($obPeces))
                $errores[] = "Las observaciones de peces muertos y nacidos son obligatorias.";
            if (strlen($obPeces) > 250)
                $errores[] = "Las observaciones no pueden superar los 250 caracteres.";
        }

        // ---- LIMPIEZA ----
        $tieneLimpieza = in_array(self::ID_ACTIVIDAD_LIMPIEZA, $actividades);


        $obserLi = trim($_POST['obserLi'] ?? '');
        $obserLi = strip_tags($obserLi);
        $estregarParedes = isset($_POST['estregarParedes']);
        $aspirar = isset($_POST['aspirar']);
        $succionador = isset($_POST['succionador']);

        if ($tieneLimpieza) {

            if (!$estregarParedes && !$aspirar && !$succionador) {
                $errores[] = "Debe seleccionar al menos un tipo de limpieza.";
            }
            if (empty($obserLi)) {
                $errores[] = "Las observaciones de limpieza son obligatorias.";
            }
            if (strlen($obserLi) > 250) {
                $errores[] = "Las observaciones de limpieza no pueden superar los 250 caracteres.";
            }
        }

        // ---- AJUSTES DE NIVEL ----
        $tieneAjuste = in_array(self::ID_ACTIVIDAD_AJUSTES_NIVEL, $actividades);

        $nivelAgua = $_POST['nv'] ?? '';
        $ph = $_POST['ph'] ?? '';
        $temp = $_POST['tem'] ?? '';
        $obserAj = trim($_POST['obAj'] ?? '');
        $obserAj = strip_tags($obserAj);

        if ($tieneAjuste) {
            if ($nivelAgua === '' || !is_numeric($nivelAgua) || $nivelAgua < 0) {
                $errores[] = "El nivel de agua debe ser un valor numérico válido.";
            }
            if ($ph === '' || !is_numeric($ph) || $ph < 0 || $ph > 14) {
                $errores[] = "El valor del pH debe ser un número entre 0 y 14.";
            }
            if ($temp === '' || !is_numeric($temp) || $temp < -10 || $temp > 60) {
                $errores[] = "La temperatura debe ser un valor numérico válido.";
            }
            // Observaciones opcionales (validación removida)
            if (strlen($obserAj) > 250) {
                $errores[] = "Las observaciones de ajustes de nivel no pueden superar los 250 caracteres.";
            }
        }

        // ---- NUEVO: LAVADO ----
        $tieneLavado = in_array(self::ID_ACTIVIDAD_LAVADO, $actividades);


        $porcAgua = $_POST['porcAgua'] ?? '';
        $estadoTanque = trim($_POST['estadoTanque'] ?? '');
        $obLa = trim($_POST['obLa'] ?? '');
        $obLa = strip_tags($obLa);

        if ($tieneLavado) {

            if ($porcAgua === '' || !is_numeric($porcAgua)) {
                $errores[] = "El porcentaje de agua es obligatorio y debe ser un número.";
            } elseif ($porcAgua < 0 || $porcAgua > 100) {
                $errores[] = "El porcentaje de agua debe estar entre 0 y 100.";
            }
            if (empty($estadoTanque)) {
                $errores[] = "Debe indicar el estado del tanque.";
            }
            if (empty($obLa)) {
                $errores[] = "Las observaciones de lavado son obligatorias.";
            }
            if (strlen($obLa) > 250) {
                $errores[] = "Las observaciones de lavado no pueden superar los 250 caracteres.";
            }
        }

        if (!empty($errores)) {
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('SeguimientoZoocriadero', 'SeguimientoZoocriadero', 'getRegistrar'));
            return;
        }

        $sql = "INSERT INTO seguimiento_zoocriadero (cod_seguimiento, fecha, id_tanque, id_usuario, id_estado, hora_inicio, hora_fin)
        VALUES ($1, CURRENT_TIMESTAMP,$2,$3,$4,$5,$6)
        RETURNING id_seguimiento_zoo";

        $resultado = $obj->select($sql,[$codigo,$tanque, $usuario, 5, null, null]);

        if ($resultado) {
            $id_seguimiento = $resultado[0]['id_seguimiento_zoo'];

            foreach ($actividades as $id_actividad) {
                $sql2 = "INSERT INTO actividad_seg_zoo (id_seguimiento_zoo, id_actividad_zoo) 
                        VALUES ('$id_seguimiento', '$id_actividad')";
                $obj->insert($sql2);
            }

            // ---- Guardar Alimentación si aplica ----
            if ($tieneAlimentacion) {
                $this->guardarAlimentacion($obj, $id_seguimiento, $codigo, $tipo_pez, $tipo_alimen, $obAlimen);
            }

            // ---- Guardar Peces Muertos y Nacidos si aplica ----
            if ($tienePecesMuertosNacidos) {
                $this->guardarPecesMuertosNacidos($obj, $id_seguimiento, $codigo, $canpez, $muerto_Macho, $muerto_Hembra, $obPeces);
            }

            // ---- Guardar Limpieza si aplica ----
            if ($tieneLimpieza) {
                $this->guardarLimpieza($obj, $id_seguimiento, $codigo, $estregarParedes, $aspirar, $succionador, $obserLi);
            }

            // ---- Guardar Ajustes de Nivel si aplica ----
            if ($tieneAjuste) {
                $this->guardarAjusteNivel($obj, $id_seguimiento, $codigo, $nivelAgua, $ph, $temp, $obserAj);
            }

            // ---- NUEVO: Guardar Lavado si aplica ----
            if ($tieneLavado) {
                $this->guardarLavado($obj, $id_seguimiento, $codigo, $estadoTanque, $porcAgua, $obLa);
            }
            redirect(getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getConsultar"));
        }   


    }

    // ---- Alimentación ----
    public function guardarAlimentacion($obj, $id_seguimiento, $codigo, $tipo_pez, $tipo_alimen, $ob)
    {


        $sqlSub = "INSERT INTO sub_actividades 
           (tipo_alimento, fecha_alimentacion, genero, obser_alimentacion, 
            can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, obser_canpeces, 
            estregar_paredes, aspirar, succionador, fecha_limpieza, obser_limpieza, 
            adicion_nivel_agua, medicion_ph, medicion_temperatura, fecha_ajuste, obser_ajuste, 
            estado_tanque, agua_cambiada, fecha_lavado, obser_lavado, 
            id_estado, id_seguimiento_zoo, cod_seguimiento) 
           VALUES 
           ($1, CURRENT_TIMESTAMP, $2, $3, 
            NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, 
            1, $4, $5)
           RETURNING id_sub_actividad";

        $resSub = $obj->select($sqlSub, [$tipo_alimen, $tipo_pez, $ob, $id_seguimiento, $codigo]);

        if (!empty($resSub)) {
            $id_sub_actividad = $resSub[0]['id_sub_actividad'];
            $obj->insert(
                "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                [self::ID_ACTIVIDAD_ALIMENTACION, $id_sub_actividad]
            );
        }
    }

    // ---- Peces Muertos y Nacidos ----
    private function guardarPecesMuertosNacidos($obj, $id_seguimiento, $codigo, $canpez, $muerto_Macho, $muerto_Hembra, $ob)
    {
        $canpez = (int) $canpez;
        $muerto_Macho = (int) $muerto_Macho;
        $muerto_Hembra = (int) $muerto_Hembra;

        $sqlSub = "INSERT INTO sub_actividades 
           (tipo_alimento, fecha_alimentacion, genero, obser_alimentacion, 
            can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, obser_canpeces, 
            estregar_paredes, aspirar, succionador, fecha_limpieza, obser_limpieza, 
            adicion_nivel_agua, medicion_ph, medicion_temperatura, fecha_ajuste, obser_ajuste, 
            estado_tanque, agua_cambiada, fecha_lavado, obser_lavado, 
            id_estado, id_seguimiento_zoo, cod_seguimiento) 
           VALUES 
           (NULL, NULL, NULL, NULL, 
            $1, $2, $3, $4, 
            NULL, NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, 
            1, $5, $6)
           RETURNING id_sub_actividad";

        $resSub = $obj->select($sqlSub, [
            $muerto_Hembra,
            $muerto_Macho,
            $canpez,
            $ob,
            $id_seguimiento,
            $codigo
        ]);

        if (!empty($resSub)) {
            $id_sub_actividad = $resSub[0]['id_sub_actividad'];
            $obj->insert(
                "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                [self::ID_ACTIVIDAD_PECES_MUERTOS_NACIDOS, $id_sub_actividad]
            );
        }
    }

    // ---- Limpieza ----
    private function guardarLimpieza($obj, $id_seguimiento, $codigo, $estregarParedes, $aspirar, $succionador, $obserLi)
    {
        $estregarParedesSql = $estregarParedes ? 'true' : 'false';
        $aspirarSql = $aspirar ? 'true' : 'false';
        $succionadorSql = $succionador ? 'true' : 'false';

        $sqlSub = "INSERT INTO sub_actividades 
           (tipo_alimento, fecha_alimentacion, genero, obser_alimentacion, 
            can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, obser_canpeces, 
            estregar_paredes, aspirar, succionador, fecha_limpieza, obser_limpieza, 
            adicion_nivel_agua, medicion_ph, medicion_temperatura, fecha_ajuste, obser_ajuste, 
            estado_tanque, agua_cambiada, fecha_lavado, obser_lavado, 
            id_estado, id_seguimiento_zoo, cod_seguimiento) 
           VALUES 
           (NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, 
            $1, $2, $3, CURRENT_TIMESTAMP, $4, 
            NULL, NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, 
            1, $5, $6)
           RETURNING id_sub_actividad";

        $resSub = $obj->select($sqlSub, [$estregarParedesSql, $aspirarSql, $succionadorSql, $obserLi, $id_seguimiento, $codigo]);

        if (!empty($resSub)) {
            $id_sub_actividad = $resSub[0]['id_sub_actividad'];
            $obj->insert(
                "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                [self::ID_ACTIVIDAD_LIMPIEZA, $id_sub_actividad]
            );
        }
    }

    // ---- Ajustes de Nivel ----
    private function guardarAjusteNivel($obj, $id_seguimiento, $codigo, $nivelAgua, $ph, $temp, $obserAj)
    {
        $nivelAgua = (float) $nivelAgua;
        $ph = (float) $ph;
        $temp = (float) $temp;

        $obserAj = !empty($obserAj) ? $obserAj : null;

        $sqlSub = "INSERT INTO sub_actividades 
           (tipo_alimento, fecha_alimentacion, genero, obser_alimentacion, 
            can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, obser_canpeces, 
            estregar_paredes, aspirar, succionador, fecha_limpieza, obser_limpieza, 
            adicion_nivel_agua, medicion_ph, medicion_temperatura, fecha_ajuste, obser_ajuste, 
            estado_tanque, agua_cambiada, fecha_lavado, obser_lavado, 
            id_estado, id_seguimiento_zoo, cod_seguimiento) 
           VALUES 
           (NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, NULL, 
            $1, $2, $3, CURRENT_TIMESTAMP, $4, 
            NULL, NULL, NULL, NULL, 
            1, $5, $6)
           RETURNING id_sub_actividad";

        $resSub = $obj->select($sqlSub, [
            $nivelAgua,
            $ph,
            $temp,

            $obserAj,
            $id_seguimiento,
            $codigo
        ]);

        if (!empty($resSub)) {
            $id_sub_actividad = $resSub[0]['id_sub_actividad'];
            $obj->insert(
                "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                [self::ID_ACTIVIDAD_AJUSTES_NIVEL, $id_sub_actividad]
            );
        }
    }

    // ---- NUEVO: Lavado, misma lógica que FormularioLaController::postInsert ----
    private function guardarLavado($obj, $id_seguimiento, $codigo, $estadoTanque, $porcAgua, $obLa)
    {
        $sqlSub = "INSERT INTO sub_actividades 
           (tipo_alimento, fecha_alimentacion, genero, obser_alimentacion, 
            can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, obser_canpeces, 
            estregar_paredes, aspirar, succionador, fecha_limpieza, obser_limpieza, 
            adicion_nivel_agua, medicion_ph, medicion_temperatura, fecha_ajuste, obser_ajuste, 
            estado_tanque, agua_cambiada, fecha_lavado, obser_lavado, 
            id_estado, id_seguimiento_zoo, cod_seguimiento) 
           VALUES 
           (NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, NULL, 
            NULL, NULL, NULL, NULL, NULL, 
            $1, $2, CURRENT_TIMESTAMP, $3, 
            1, $4, $5)
           RETURNING id_sub_actividad";

        $resSub = $obj->select($sqlSub, [$estadoTanque, $porcAgua, $obLa, $id_seguimiento, $codigo]);

        if (!empty($resSub)) {
            $id_sub_actividad = $resSub[0]['id_sub_actividad'];
            $obj->insert(
                "INSERT INTO actividad_zoo_subactividades (id_actividad_zoo, id_sub_actividades) VALUES ($1, $2)",
                [self::ID_ACTIVIDAD_LAVADO, $id_sub_actividad]
            );
        }
    }



    /*
        public function getEditar()
        {
            $id = $_GET['id'];
            $obj = new SeguimientoZoocriaderoModel();

            $sql = "SELECT id_seguimiento_zoo, fecha, hora_inicio, hora_fin, id_estado, id_tanque, id_usuario
                    FROM seguimiento_zoocriadero
                    WHERE id_seguimiento_zoo = '$id'";
            $datos = $obj->select($sql);

            $sql3 = "SELECT * from estado WHERE tipo_estado = 'seguimiento'";
            $estados = $obj->select($sql3);

            $sql4 = "SELECT * from actividad_zoocriadero WHERE id_estado = 1";
            $actividades = $obj->select($sql4);



            $sql4 = "SELECT id_actividad_zoo from actividad_seg_zoo WHERE id_seguimiento_zoo = $1";
            $actividadesSelect = $obj->select($sql4, [$id]);


            include_once '../view/partials/SeguimientoZoocriadero/Editar.php';

        }
            */



    public function postUpdate()
    {

        $obj = new SeguimientoZoocriaderoModel();
        $id = $_POST['id'];
        $fecha = $_POST['fecha'];
        $horario = $_POST['horario'];
        $estado = $_POST['id_estado'];
        list($hora_inicio, $hora_fin) = explode('-', $horario);


        $actividadesNuevas = $_POST['actividades'] ?? [];
        //el array_map lo uso para convertir los valores de actividadesNuevas en numeros enteros por si acaso
        $actividadesNuevas = array_map('intval', $actividadesNuevas);

        $sql = "SELECT id_actividad_zoo FROM actividad_seg_zoo WHERE id_seguimiento_zoo = $1";
        $actividadesActuales = $obj->select($sql, [$id]);
        //se selecciono la columna id_actividad_zoo que trae el array
        $idsActuales = array_column($actividadesActuales, 'id_actividad_zoo');

        //id dif lo que hace es seleccionar los valores que esten en el primer array y que no se repitan en el segundo
        $idsEliminar = array_diff($idsActuales, $actividadesNuevas);
        $idsInsertar = array_diff($actividadesNuevas, $idsActuales);


        foreach ($idsEliminar as $idActividad) {
            $sqlDelete = "DELETE FROM actividad_seg_zoo 
                        WHERE id_seguimiento_zoo = $1 AND id_actividad_zoo = $2";
            $obj->delete($sqlDelete, [$id, $idActividad]);
        }


        foreach ($idsInsertar as $idActividad) {
            $sqlInsert = "INSERT INTO actividad_seg_zoo (id_seguimiento_zoo, id_actividad_zoo) 
                        VALUES ($1, $2)";
            $obj->insert($sqlInsert, [$id, $idActividad]);
        }

        $sql = "UPDATE seguimiento_zoocriadero SET 
            fecha = '$fecha',
            hora_inicio = '$hora_inicio',
            hora_fin = '$hora_fin',
            id_estado = '$estado'
        WHERE id_seguimiento_zoo = '$id'";

        $ejecutar = $obj->update($sql);

        $sql2 = "UPDATE seguimiento_zoocriadero 
                SET id_estado = 3 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado = 4";

        $ejecutar2 = $obj->update($sql2);

        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "El Seguimiento de zoocriadero se actualizó correctamente.";
            $sql2 = "UPDATE seguimiento_zoocriadero 
                SET id_estado = 3
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado = 4";

            $ejecutar = $obj->update($sql2);



            $sql15 = "SELECT 
                        az.id_actividad_zoo, 
                        az.nombre_actividad,
                        CASE WHEN sa.id_sub_actividad IS NOT NULL THEN true ELSE false END AS ya_registrada
                    FROM actividad_seg_zoo asz
                    INNER JOIN actividad_zoocriadero az ON asz.id_actividad_zoo = az.id_actividad_zoo
                    LEFT JOIN actividad_zoo_subactividades azs ON az.id_actividad_zoo = azs.id_actividad_zoo
                    LEFT JOIN sub_actividades sa ON azs.id_sub_actividades = sa.id_sub_actividad 
                                                AND sa.id_seguimiento_zoo = asz.id_seguimiento_zoo
                    WHERE asz.id_seguimiento_zoo = $1 ORDER BY id_actividad_zoo";
            $act = $obj->select($sql15, [$id]);

            $verify = true;

            foreach ($act as $a) {
                if ($a['ya_registrada']) {
                    $verify = false;
                    break;
                }
            }

            if ($verify && count($act) > 0) {
                $sql22 = "UPDATE seguimiento_zoocriadero 
                SET id_estado = 5 
                WHERE id_seguimiento_zoo = $1";

                $ejecutar2 = $obj->update($sql22, [$id]);
            }

            redirect(getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getConsultar"));
        } else {
            echo "No se pudo actualizar el seguimiento";
        }
        ;
    }


    public function postDelete()
    {

        $obj = new SeguimientoZoocriaderoModel();
        $id = $_GET['id'];

        $sql2 = "SELECT id_estado from seguimiento_zoocriadero WHERE id_seguimiento_zoo = $id";
        $ejecutar2 = $obj->select($sql2);
        foreach ($ejecutar2 as $s) {


            if ($s['id_estado'] == 2) {

                echo '<script>alert("¡Este Seguimiento ya esta inhabilitado!");</script>';
                redirect(getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getConsultar"));
            } else if ($s['id_estado'] == 1) {
                $sql = "UPDATE seguimiento_zoocriadero SET id_estado = 4 WHERE id_seguimiento_zoo = $id";

                $ejecutar = $obj->delete($sql);
                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "El seguimiento de zoocriadero se inhabilito correctamente.";
                    redirect(getUrl("seguimientozoocriadero", "seguimientozoocriadero", "getConsultar"));
                } else {
                    echo "No se pudo inhabilitar el seguimientozoocriadero";
                }
            }
        }
    }

    public function getBuscar()
{
    $busqueda = mb_strtoupper(trim($_GET['busqueda'] ?? ''));
    $obj = new SeguimientoZoocriaderoModel();

    // ============================================
    // 1. Si hay búsqueda → filtrar por código
    // ============================================
    if (!empty($busqueda)) {

        $palabra = $_GET['busqueda']; // para mantener el valor en el input

        $sql = "SELECT 
                    s.id_seguimiento_zoo, 
                    s.cod_seguimiento, 
                    s.fecha, 
                    u.documento, 
                    s.id_estado, 
                    e.nombre_estado
                FROM seguimiento_zoocriadero s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                LEFT JOIN estado e ON s.id_estado = e.id_estado
                WHERE s.cod_seguimiento ILIKE $1
                ORDER BY s.id_seguimiento_zoo DESC";

        $seguimientos = $obj->select($sql, ['%' . $busqueda . '%']);

        include_once '../view/partials/SeguimientoZoocriadero/Buscar.php';
    } 
    
    // ============================================
    // 2. Si NO hay búsqueda → listar todo + actualizar estados
    // ============================================
    else {

        // Primero actualizamos los estados según las actividades
        $sqlAll = "SELECT 
                        s.id_seguimiento_zoo,
                        s.cod_seguimiento,
                        s.fecha,
                        s.hora_inicio,
                        s.hora_fin,
                        s.id_estado,
                        z.cod_zoocriadero,
                        t.codigo_tanque,
                        u.primer_nombre,
                        u.primer_apellido,
                        STRING_AGG(az.nombre_actividad, ', ') AS actividades
                    FROM seguimiento_zoocriadero s
                    INNER JOIN tanque t ON s.id_tanque = t.id_tanque
                    INNER JOIN zoocriadero z ON t.id_zoocriadero = z.id_zoocriadero
                    INNER JOIN usuarios u ON s.id_usuario = u.id_usuario
                    LEFT JOIN actividad_seg_zoo asz ON s.id_seguimiento_zoo = asz.id_seguimiento_zoo
                    LEFT JOIN actividad_zoocriadero az ON asz.id_actividad_zoo = az.id_actividad_zoo 
                                                    AND az.id_estado = 1  
                    GROUP BY s.id_seguimiento_zoo, s.cod_seguimiento, s.fecha, s.hora_inicio, 
                             s.hora_fin, s.id_estado, z.cod_zoocriadero, t.codigo_tanque, 
                             u.primer_nombre, u.primer_apellido
                    ORDER BY s.id_seguimiento_zoo";

        $seguimientosTemp = $obj->select($sqlAll);

        foreach ($seguimientosTemp as $se) {

            $sqlAct = "SELECT 
                            az.id_actividad_zoo,
                            az.nombre_actividad,
                            EXISTS (
                                SELECT 1
                                FROM actividad_zoo_subactividades azs
                                INNER JOIN sub_actividades sa 
                                    ON sa.id_sub_actividad = azs.id_sub_actividades
                                WHERE azs.id_actividad_zoo = az.id_actividad_zoo
                                  AND sa.id_seguimiento_zoo = asz.id_seguimiento_zoo
                            ) AS ya_registrada
                        FROM actividad_seg_zoo asz
                        INNER JOIN actividad_zoocriadero az 
                            ON asz.id_actividad_zoo = az.id_actividad_zoo
                        WHERE asz.id_seguimiento_zoo = $1
                        ORDER BY az.id_actividad_zoo";

            $actividades = $obj->select($sqlAct, [$se['id_seguimiento_zoo']]);

            $todasCompletas = true;

            foreach ($actividades as $a) {
                if ($a['ya_registrada'] !== true && $a['ya_registrada'] !== 't') {
                    $todasCompletas = false;
                    break;
                }
            }

            if ($todasCompletas && count($actividades) > 0) {
                // Todas las actividades están registradas → Finalizado (5)
                $sqlUpdate = "UPDATE seguimiento_zoocriadero 
                              SET id_estado = 5 
                              WHERE id_seguimiento_zoo = $1 AND id_estado = 4";
                $obj->update($sqlUpdate, [$se['id_seguimiento_zoo']]);
            } else {
                // Aún faltan actividades → En proceso (4)
                $sqlUpdate = "UPDATE seguimiento_zoocriadero 
                              SET id_estado = 4 
                              WHERE id_seguimiento_zoo = $1 AND id_estado = 5";
                $obj->update($sqlUpdate, [$se['id_seguimiento_zoo']]);
            }
        }

       
        $sql = "SELECT 
                    s.id_seguimiento_zoo, 
                    s.cod_seguimiento, 
                    s.fecha, 
                    u.documento, 
                    s.id_estado, 
                    e.nombre_estado
                FROM seguimiento_zoocriadero s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                LEFT JOIN estado e ON s.id_estado = e.id_estado
                ORDER BY s.id_seguimiento_zoo DESC";

        $seguimientos = $obj->select($sql);

        include_once '../view/partials/SeguimientoZoocriadero/Consultar.php';
    }
}




    public function getTanquesPorZoo()
    {
        $id_zoocriadero = $_GET['id_zoocriadero'];

        $obj = new SeguimientoZoocriaderoModel();

        $sql = "SELECT id_tanque, codigo_tanque FROM tanque WHERE id_zoocriadero = '$id_zoocriadero' AND id_estado = 1";
        $tanques = $obj->select($sql);

        $sql2 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido FROM usuarios WHERE id_zoocriadero = '$id_zoocriadero'";
        $usuarios = $obj->select($sql2);

        $resultado = [
            'tanques' => $tanques,
            'usuarios' => $usuarios
        ];

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }
}
