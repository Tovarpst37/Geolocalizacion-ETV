<?php

include_once '../model/SeguimientoTerreno/SeguimientoTerrenoModel.php';





class SeguimientoTerrenoController
{

    private const ID_ACTIVIDAD_INSPECCION = 1;
    private const ID_ACTIVIDAD_SIEMBRA = 2;
    private const ID_ACTIVIDAD_SEGUIMIENTO = 3;
    private const ID_ACTIVIDAD_RESIEMBRA = 4;






    public function getConsultar()
    {

        $obj = new SeguimientoTerrenoModel();

        $sql = "SELECT 
                s.id_seguimiento_terreno,
                s.cod_seguimiento,
                s.fecha,
                s.hora_inicio,
                s.hora_fin,
                s.id_estado,
                si.nombre_sitio,
                td.nombre AS cod_terreno,
                u.primer_nombre,
                u.primer_apellido,
                STRING_AGG(at.nombre_actividad, ', ') AS actividades
            FROM seguimiento_terreno s
            INNER JOIN usuarios u ON s.id_usuario = u.id_usuario
            INNER JOIN rol r ON u.id_rol = r.id_rol
            LEFT JOIN sitio si ON s.id_sitio = si.id_sitio
            LEFT JOIN tipo_de_deposito td ON si.id_tipo_deposito = td.id_tipo_deposito
            LEFT JOIN actividad_seg_terreno ast ON s.id_seguimiento_terreno = ast.id_seguimiento_terreno
            LEFT JOIN actividad_terreno at ON ast.id_actividad_terreno = at.id_actividad_terreno 
                                            AND at.id_estado = 1          
            WHERE r.nombre_rol IN ('Auxiliar', 'Coordinador')
            GROUP BY 
                s.id_seguimiento_terreno, 
                s.cod_seguimiento, 
                s.fecha, 
                s.hora_inicio, 
                s.hora_fin, 
                s.id_estado, 
                si.nombre_sitio,
                td.nombre,
                u.primer_nombre, 
                u.primer_apellido
            ORDER BY s.id_seguimiento_terreno DESC";



        $seguimientosnew = $obj->select($sql);

        foreach ($seguimientosnew as $se) {
            $sql15 = "SELECT 
                                atr.id_actividad_terreno,
                                atr.nombre_actividad,
                                EXISTS (
                                    SELECT 1
                                    FROM actividad_ter_subactividades ats
                                    INNER JOIN sub_actividades_ter sa 
                                        ON sa.id_sub_actividad = ats.id_sub_actividades
                                    WHERE ats.id_actividad_terreno = atr.id_actividad_terreno
                                    AND sa.id_seguimiento_terreno = ast.id_seguimiento_terreno
                                ) AS ya_registrada
                            FROM actividad_seg_terreno ast
                            INNER JOIN actividad_terreno atr 
                                ON ast.id_actividad_terreno = atr.id_actividad_terreno
                            WHERE ast.id_seguimiento_terreno = $1
                            ORDER BY atr.id_actividad_terreno";
            $act = $obj->select($sql15, [$se['id_seguimiento_terreno']]);


            if (count($act) == 0)
                continue;

            $verify = true;

            foreach ($act as $a) {
                if ($a['ya_registrada'] !== true && $a['ya_registrada'] !== 't') {
                    $verify = false;
                    break;
                }
            }

            if ($verify) {

                $sql22 = "UPDATE seguimiento_terreno 
                            SET id_estado = 5 
                            WHERE id_seguimiento_terreno = $1 AND id_estado = 4";
                $ejecutar2 = $obj->update($sql22, [$se['id_seguimiento_terreno']]);
            } else {

                $sql22 = "UPDATE seguimiento_terreno 
                            SET id_estado = 4 
                            WHERE id_seguimiento_terreno = $1 AND id_estado = 5";
                $ejecutar2 = $obj->update($sql22, [$se['id_seguimiento_terreno']]);
            }
        }




        $sql2 = "UPDATE seguimiento_terreno
                SET id_estado = 3 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado =  4";

        $ejecutar = $obj->update($sql2);
        $seguimientos = $obj->select($sql);

        if (count($seguimientos) <= 0) {
            include_once '../view/partials/SeguimientoTerreno/notExist.php';
        } else {
            include_once '../view/partials/SeguimientoTerreno/Consultar.php';
        }



    }


    public function getRegistrar()
    {

        $obj = new SeguimientoTerrenoModel();
        $sql = "SELECT * from sitio WHERE id_estado = 1";
        $sitio = $obj->select($sql);

        $sql4 = "SELECT MAX(id_seguimiento_terreno) FROM seguimiento_terreno";
        $id_seg = $obj->select($sql4);

        $sql2 = "SELECT * from estado where tipo_estado = 'seguimiento'";
        $estados = $obj->select($sql2);

        $sql3 = "SELECT * from actividad_terreno WHERE id_estado = 1";
        $actividades = $obj->select($sql3);

        include_once '../view/partials/SeguimientoTerreno/Registrar.php';

    }


    public function postRegistrar()
    {
        $obj = new SeguimientoTerrenoModel(); // ajusta el nombre real de tu modelo

        $codigo = mb_strtoupper($_POST['codigo']) ?? '';
        $sitio = $_POST['select_ter'] ?? '';
        $estado = $_POST['id_estado'];
        $usuario = $_POST['selectUsuarios'] ?? '';
        $deposito = $_POST['selectTerreno'] ?? '';
        $horario = $_POST['horario'] ?? '';
        $actividades = $_POST['actividades'] ?? [];

        $sql_validar = "SELECT id_seguimiento_terreno FROM seguimiento_terreno WHERE cod_seguimiento = $1";
        $existe = $obj->select($sql_validar, [$codigo]);

        $errores = [];
        list($hora_inicio, $hora_fin) = explode('-', $horario);

        if (!empty($existe)) {
            $errores[] = "Ya existe un seguimiento con ese código";
        }
        if (empty($codigo)) {
            $errores[] = "Debe ingresar el codigo del seguimiento";
        }
        if (empty($sitio)) {
            $errores[] = "Debe seleccionar el sitio.";
        }
        if (empty($estado)) {
            $errores[] = "Debe seleccionar el estado del seguimiento.";
        }
        if (empty($usuario)) {
            $errores[] = "Debe seleccionar el Auxiliar asignado.";
        }
        if (empty($deposito)) {
            $errores[] = "Debe seleccionar el depósito al que se le hará el seguimiento.";
        }
        if (empty($horario)) {
            $errores[] = "Debe seleccionar el horario.";
        }

        // ---- INSPECCIÓN: validar solo si viene marcada esa actividad ----
        $tieneInspeccion = in_array(self::ID_ACTIVIDAD_INSPECCION, $actividades);

        $fecha_horaInsp = $_POST['fecha_horaInsp'] ?? '';
        $depositoDetRaw = $_POST['depositoDetectado'] ?? '';
        $phMedido = $_POST['phMedido'] ?? '';
        $temperatura = $_POST['temperatura'] ?? '';
        $presenciaLarvRaw = $_POST['presenciaLarvas'] ?? '';
        $obserInsp = trim($_POST['obserInsp'] ?? '');
        $obserInsp = strip_tags($obserInsp);

        if ($tieneInspeccion) {
            if (empty($fecha_horaInsp)) {
                $errores[] = "La fecha y hora de inspección son obligatorias.";
            }
            if ($depositoDetRaw !== '0' && $depositoDetRaw !== '1') {
                $errores[] = "Debe indicar si se detectaron depósitos permanentes de agua.";
            }
            if ($phMedido === '' || !is_numeric($phMedido)) {
                $errores[] = "El PH medido es obligatorio y debe ser un número válido.";
            } elseif ($phMedido < 0 || $phMedido > 14) {
                $errores[] = "El PH medido debe estar entre 0 y 14.";
            }
            if ($temperatura === '' || !is_numeric($temperatura)) {
                $errores[] = "La temperatura medida es obligatoria y debe ser un número válido.";
            }
            if ($presenciaLarvRaw !== '0' && $presenciaLarvRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de larvas de zancudos.";
            }
            if (empty($obserInsp)) {
                $errores[] = "Las observaciones de inspección son obligatorias.";
            }
            if (strlen($obserInsp) > 250) {
                $errores[] = "Las observaciones de inspección no pueden superar los 250 caracteres.";
            }
        }

        // ---- SIEMBRA: validar solo si viene marcada esa actividad ----
        $tieneSiembra = in_array(self::ID_ACTIVIDAD_SIEMBRA, $actividades);

        $fecha_horaSiem = $_POST['fecha_horaSiem'] ?? '';
        $pecesEmpacados = $_POST['pecesEmpacados'] ?? '';
        $tiempoAclimat = $_POST['tiempoAclimat'] ?? '';
        $hembrasSembradas = $_POST['hembrasSembradas'] ?? '';
        $machosSembrados = $_POST['machosSembrados'] ?? '';
        $litrosAgua = $_POST['litrosAgua'] ?? '';
        $presenciaLarvasSiemRaw = $_POST['presenciaLarvasSiem'] ?? '';
        $presenciaPecesSiemRaw = $_POST['presenciaPecesSiem'] ?? '';
        $obserSiem = trim($_POST['obserSiem'] ?? '');
        $obserSiem = strip_tags($obserSiem);

        if ($tieneSiembra) {
            if (empty($fecha_horaSiem)) {
                $errores[] = "La fecha y hora de siembra son obligatorias.";
            }
            if ($pecesEmpacados === '' || !is_numeric($pecesEmpacados) || $pecesEmpacados < 0) {
                $errores[] = "La cantidad de peces empacados es obligatoria y debe ser un número válido.";
            }
            if ($tiempoAclimat === '' || !is_numeric($tiempoAclimat) || $tiempoAclimat < 0) {
                $errores[] = "El tiempo de aclimatación es obligatorio y debe ser un número válido.";
            }
            if ($hembrasSembradas === '' || !is_numeric($hembrasSembradas) || $hembrasSembradas < 0) {
                $errores[] = "La cantidad de hembras sembradas es obligatoria y debe ser un número válido.";
            }
            if ($machosSembrados === '' || !is_numeric($machosSembrados) || $machosSembrados < 0) {
                $errores[] = "La cantidad de machos sembrados es obligatoria y debe ser un número válido.";
            }
            if ($litrosAgua === '' || !is_numeric($litrosAgua) || $litrosAgua < 0) {
                $errores[] = "El volumen de agua utilizado es obligatorio y debe ser un número válido.";
            }
            if ($presenciaLarvasSiemRaw !== '0' && $presenciaLarvasSiemRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de larvas de zancudos en la siembra.";
            }
            if ($presenciaPecesSiemRaw !== '0' && $presenciaPecesSiemRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de peces en la siembra.";
            }
            if (empty($obserSiem)) {
                $errores[] = "Las observaciones de siembra son obligatorias.";
            }
            if (strlen($obserSiem) > 250) {
                $errores[] = "Las observaciones de siembra no pueden superar los 250 caracteres.";
            }
        }

        // ---- SEGUIMIENTO: validar solo si viene marcada esa actividad ----
        $tieneSeguimientoAct = in_array(self::ID_ACTIVIDAD_SEGUIMIENTO, $actividades);

        $fecha_horaSeg = $_POST['fecha_horaSeg'] ?? '';
        $numeroVisitaRaw = $_POST['numeroVisita'] ?? '';
        $depositoVisRaw = $_POST['depositoVisitado'] ?? '';
        $presenciaLarvasSegRaw = $_POST['presenciaLarvasSeg'] ?? '';
        $presenciaPecesSegRaw = $_POST['presenciaPecesSeg'] ?? '';
        $obserSeg = trim($_POST['obserSeg'] ?? '');
        $obserSeg = strip_tags($obserSeg);

        if ($tieneSeguimientoAct) {
            if (empty($fecha_horaSeg)) {
                $errores[] = "La fecha y hora de seguimiento son obligatorias.";
            }
            if ($numeroVisitaRaw !== '1' && $numeroVisitaRaw !== '2') {
                $errores[] = "Debe seleccionar un número de visita válido (1ra o 2da).";
            }
            if ($depositoVisRaw !== '0' && $depositoVisRaw !== '1') {
                $errores[] = "Debe indicar si se visitaron depósitos permanentes con agua.";
            }
            if ($presenciaLarvasSegRaw !== '0' && $presenciaLarvasSegRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de larvas de zancudos en el seguimiento.";
            }
            if ($presenciaPecesSegRaw !== '0' && $presenciaPecesSegRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de peces en el seguimiento.";
            }
            if (empty($obserSeg)) {
                $errores[] = "Las observaciones de seguimiento son obligatorias.";
            }
            if (strlen($obserSeg) > 250) {
                $errores[] = "Las observaciones de seguimiento no pueden superar los 250 caracteres.";
            }
        }

        // ---- RESIEMBRA: validar solo si viene marcada esa actividad ----
        $tieneResiembra = in_array(self::ID_ACTIVIDAD_RESIEMBRA, $actividades);

        $fecha_horaResi = $_POST['fecha_horaResi'] ?? '';
        $canHembrasResi = $_POST['canHembras'] ?? '';
        $canMachosResi = $_POST['canMachos'] ?? '';
        $canGuppiesResi = $_POST['canGuppies'] ?? '';
        $presenciaLarvasResiRaw = $_POST['presenciaLarvasResi'] ?? '';
        $presenciaPecesResiRaw = $_POST['presenciaPecesResi'] ?? '';
        $obserResi = trim($_POST['obserResi'] ?? '');
        $obserResi = strip_tags($obserResi);

        if ($tieneResiembra) {
            if (empty($fecha_horaResi)) {
                $errores[] = "La fecha y hora de resiembra son obligatorias.";
            }
            if ($canHembrasResi === '' || !is_numeric($canHembrasResi) || $canHembrasResi < 0) {
                $errores[] = "La cantidad de hembras sembradas es obligatoria y debe ser un número válido.";
            }
            if ($canMachosResi === '' || !is_numeric($canMachosResi) || $canMachosResi < 0) {
                $errores[] = "La cantidad de machos sembrados es obligatoria y debe ser un número válido.";
            }
            if ($canGuppiesResi === '' || !is_numeric($canGuppiesResi) || $canGuppiesResi < 0) {
                $errores[] = "La cantidad de peces guppies sembrados es obligatoria y debe ser un número válido.";
            }
            if ($presenciaLarvasResiRaw !== '0' && $presenciaLarvasResiRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de larvas de zancudos en la resiembra.";
            }
            if ($presenciaPecesResiRaw !== '0' && $presenciaPecesResiRaw !== '1') {
                $errores[] = "Debe indicar si hay presencia de peces en la resiembra.";
            }
            if (empty($obserResi)) {
                $errores[] = "Las observaciones de resiembra son obligatorias.";
            }
            if (strlen($obserResi) > 250) {
                $errores[] = "Las observaciones de resiembra no pueden superar los 250 caracteres.";
            }
        }


        if (!empty($errores)) {
            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('SeguimientoTerreno', 'SeguimientoTerreno', 'getRegistrar'));
            return;
        }


        $sql = "INSERT INTO seguimiento_terreno (cod_seguimiento, fecha, id_sitio, id_usuario, id_estado, hora_inicio, hora_fin)
        VALUES ($1, CURRENT_DATE, $2, $3, $4, $5, $6)
        RETURNING id_seguimiento_terreno";

        $resultado = $obj->select($sql, [$codigo, $sitio, $usuario, $estado, $hora_inicio, $hora_fin]);

        if ($resultado) {
            $id_seguimiento = $resultado[0]['id_seguimiento_terreno'];

            foreach ($actividades as $id_actividad) {
                $sql2 = "INSERT INTO actividad_seg_terreno (id_seguimiento_terreno, id_actividad_terreno) 
                        VALUES ('$id_seguimiento', '$id_actividad')";
                $obj->insert($sql2);
            }

            // ---- Guardar Inspección si aplica ----
            if ($tieneInspeccion) {
                $this->guardarInspeccion(
                    $obj,
                    $id_seguimiento,
                    $codigo,
                    $fecha_horaInsp,
                    $depositoDetRaw,
                    $phMedido,
                    $temperatura,
                    $presenciaLarvRaw,
                    $obserInsp
                );
            }

            // ---- Guardar Siembra si aplica ----
            if ($tieneSiembra) {
                $this->guardarSiembra(
                    $obj,
                    $id_seguimiento,
                    $codigo,
                    $fecha_horaSiem,
                    $pecesEmpacados,
                    $tiempoAclimat,
                    $hembrasSembradas,
                    $machosSembrados,
                    $litrosAgua,
                    $presenciaLarvasSiemRaw,
                    $presenciaPecesSiemRaw,
                    $obserSiem
                );
            }

            // ---- Guardar Seguimiento si aplica ----
            if ($tieneSeguimientoAct) {
                $this->guardarSeguimientoAct(
                    $obj,
                    $id_seguimiento,
                    $codigo,
                    $fecha_horaSeg,
                    $numeroVisitaRaw,
                    $depositoVisRaw,
                    $presenciaLarvasSegRaw,
                    $presenciaPecesSegRaw,
                    $obserSeg
                );
            }

            // ---- Guardar Resiembra si aplica ----
            if ($tieneResiembra) {
                $this->guardarResiembra(
                    $obj,
                    $id_seguimiento,
                    $codigo,
                    $fecha_horaResi,
                    $canHembrasResi,
                    $canMachosResi,
                    $canGuppiesResi,
                    $presenciaLarvasResiRaw,
                    $presenciaPecesResiRaw,
                    $obserResi
                );
            }

            $_SESSION['mensaje_exito'] = "El Seguimiento de Terreno se registró correctamente.";

            redirect(getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getConsultar"));
        } else {
            echo "No se pudo registrar el seguimiento";
        }
    }

    // ---- Inspección, misma lógica que FormularioInspController::postInsert ----
    private function guardarInspeccion($obj, $id_seguimiento, $codigo, $fechaHora, $depositoDetRaw, $phMedido, $temperatura, $presenciaLarvRaw, $obser)
    {
        $depositoDet = $depositoDetRaw === '1' ? 'true' : 'false';
        $presenciaLarv = $presenciaLarvRaw === '1' ? 'true' : 'false';

        $sqlSub = "INSERT INTO sub_actividades_ter
           (fecha_inspeccion, deposito_agua_detectado, ph_medido, temperatura, 
            presencia_larvas_inspeccion, obser_inspeccion, 
            id_estado, id_seguimiento_terreno, cod_seguimiento) 
           VALUES 
           ($1, $2, $3, $4, 
            $5, $6, 
            1, $7, $8)
           RETURNING id_sub_actividad";

        $resSub = $obj->select($sqlSub, [
            $fechaHora,
            $depositoDet,
            $phMedido,
            $temperatura,
            $presenciaLarv,
            $obser,
            $id_seguimiento,
            $codigo
        ]);

        if (!empty($resSub)) {
            $id_sub_actividad = $resSub[0]['id_sub_actividad'];
            $obj->insert(
                "INSERT INTO actividad_ter_subactividades (id_actividad_terreno, id_sub_actividades) VALUES ($1, $2)",
                [self::ID_ACTIVIDAD_INSPECCION, $id_sub_actividad]
            );
        }
    }

    // ---- Siembra, misma lógica que FormularioSiemController::postInsert ----
    private function guardarSiembra($obj, $id_seguimiento, $codigo, $fechaHora, $pecesEmpacados, $tiempoAclimat, $hembrasSembradas, $machosSembrados, $litrosAgua, $presenciaLarvasRaw, $presenciaPecesRaw, $obser)
    {
        $presenciaLarv = $presenciaLarvasRaw === '1' ? 'true' : 'false';
        $presenciaPec = $presenciaPecesRaw === '1' ? 'true' : 'false';

        $sqlSub = "INSERT INTO sub_actividades_ter
           (fecha_siembra, can_peces_empacados, tiempo_aclimatacion, 
            can_hembras_sembradas, can_machos_sembrados, litros_utilizados, 
            presencia_larvas_siembra, presencia_peces_siembra, obser_siembra, 
            id_estado, id_seguimiento_terreno, cod_seguimiento) 
           VALUES 
           ($1, $2, $3, 
            $4, $5, $6, 
            $7, $8, $9, 
            1, $10, $11)
           RETURNING id_sub_actividad";

        $resSub = $obj->select($sqlSub, [
            $fechaHora,
            $pecesEmpacados,
            $tiempoAclimat,
            $hembrasSembradas,
            $machosSembrados,
            $litrosAgua,
            $presenciaLarv,
            $presenciaPec,
            $obser,
            $id_seguimiento,
            $codigo
        ]);

        if (!empty($resSub)) {
            $id_sub_actividad = $resSub[0]['id_sub_actividad'];
            $obj->insert(
                "INSERT INTO actividad_ter_subactividades (id_actividad_terreno, id_sub_actividades) VALUES ($1, $2)",
                [self::ID_ACTIVIDAD_SIEMBRA, $id_sub_actividad]
            );
        }
    }

    // ---- Seguimiento, misma lógica que FormularioSegTController::postInsert ----
    private function guardarSeguimientoAct($obj, $id_seguimiento, $codigo, $fechaHora, $numeroVisitaRaw, $depositoVisRaw, $presenciaLarvasRaw, $presenciaPecesRaw, $obser)
    {
        $numeroVisita = (int) $numeroVisitaRaw;
        $depositoVis = $depositoVisRaw === '1' ? 'true' : 'false';
        $presenciaLarv = $presenciaLarvasRaw === '1' ? 'true' : 'false';
        $presenciaPec = $presenciaPecesRaw === '1' ? 'true' : 'false';

        $sqlSub = "INSERT INTO sub_actividades_ter
       (fecha_seguimiento, numero_visita, deposito_agua_visitado, 
        presencia_larvas_seguimiento, presencia_peces_seguimiento, obser_seguimiento, 
        id_estado, id_seguimiento_terreno, cod_seguimiento) 
       VALUES 
       ($1, $2, $3, 
        $4, $5, $6, 
        1, $7, $8)
       RETURNING id_sub_actividad";

        $resSub = $obj->select($sqlSub, [
            $fechaHora,
            $numeroVisita,
            $depositoVis,
            $presenciaLarv,
            $presenciaPec,
            $obser,
            $id_seguimiento,
            $codigo
        ]);

        if (!empty($resSub)) {
            $id_sub_actividad = $resSub[0]['id_sub_actividad'];
            $obj->insert(
                "INSERT INTO actividad_ter_subactividades (id_actividad_terreno, id_sub_actividades) VALUES ($1, $2)",
                [self::ID_ACTIVIDAD_SEGUIMIENTO, $id_sub_actividad]
            );
        }
    }

    // ---- Resiembra, misma lógica que FormularioResiController::postInsert ----
    private function guardarResiembra($obj, $id_seguimiento, $codigo, $fechaHora, $canHembras, $canMachos, $canGuppies, $presenciaLarvasRaw, $presenciaPecesRaw, $obser)
    {
        $presenciaLarv = $presenciaLarvasRaw === '1' ? 'true' : 'false';
        $presenciaPec = $presenciaPecesRaw === '1' ? 'true' : 'false';

        $sqlSub = "INSERT INTO sub_actividades_ter
           (fecha_resiembra, can_hembras_sembradas, can_machos_sembrados, can_peces_guppies_sembrados,
            presencia_larvas_resiembra, presencia_peces_resiembra, obser_resiembra, 
            id_estado, id_seguimiento_terreno, cod_seguimiento) 
           VALUES 
           ($1, $2, $3, $4,
            $5, $6, $7, 
            1, $8, $9)
           RETURNING id_sub_actividad";

        $resSub = $obj->select($sqlSub, [
            $fechaHora,
            $canHembras,
            $canMachos,
            $canGuppies,
            $presenciaLarv,
            $presenciaPec,
            $obser,
            $id_seguimiento,
            $codigo
        ]);

        if (!empty($resSub)) {
            $id_sub_actividad = $resSub[0]['id_sub_actividad'];
            $obj->insert(
                "INSERT INTO actividad_ter_subactividades (id_actividad_terreno, id_sub_actividades) VALUES ($1, $2)",
                [self::ID_ACTIVIDAD_RESIEMBRA, $id_sub_actividad]
            );
        }
    }


    public function getEditar()
    {
        $id = $_GET['id'];
        $obj = new SeguimientoTerrenoModel();

        $sql = "SELECT id_seguimiento_terreno, fecha, hora_inicio, hora_fin, id_estado, id_usuario
                FROM seguimiento_terreno
                WHERE id_seguimiento_terreno = '$id'";
        $datos = $obj->select($sql);

        $sql3 = "SELECT * from estado WHERE tipo_estado = 'seguimiento'";
        $estados = $obj->select($sql3);


        $sql4 = "SELECT * from actividad_terreno WHERE id_estado = 1 ORDER BY id_actividad_terreno";

        $actividades = $obj->select($sql4);



        $sql4 = "SELECT id_actividad_terreno from actividad_seg_terreno WHERE id_seguimiento_terreno = $1";
        $actividadesSelect = $obj->select($sql4, [$id]);


        include_once '../view/partials/SeguimientoTerreno/Editar.php';

    }

    public function postUpdate()
    {

        $obj = new SeguimientoTerrenoModel();
        $id = $_POST['id'];
        $fecha = $_POST['fecha'];
        $horario = $_POST['horario'];
        $estado = $_POST['id_estado'];

        list($hora_inicio, $hora_fin) = explode('-', $horario);


        $actividadesNuevas = $_POST['actividades'] ?? [];
        //el array_map lo uso para convertir los valores de actividadesNuevas en numeros enteros por si acaso
        $actividadesNuevas = array_map('intval', $actividadesNuevas);

        $sql = "SELECT id_actividad_terreno FROM actividad_seg_terreno WHERE id_seguimiento_terreno = $1";
        $actividadesActuales = $obj->select($sql, [$id]);
        //se selecciono la columna id_actividad_zoo que trae el array
        $idsActuales = array_column($actividadesActuales, 'id_actividad_terreno');

        //id dif lo que hace es seleccionar los valores que esten en el primer array y que no se repitan en el segundo
        $idsEliminar = array_diff($idsActuales, $actividadesNuevas);
        $idsInsertar = array_diff($actividadesNuevas, $idsActuales);


        foreach ($idsEliminar as $idActividad) {
            $sqlDelete = "DELETE FROM actividad_seg_terreno 
                        WHERE id_seguimiento_terreno = $1 AND id_actividad_terreno = $2";
            $obj->delete($sqlDelete, [$id, $idActividad]);
        }


        foreach ($idsInsertar as $idActividad) {
            $sqlInsert = "INSERT INTO actividad_seg_terreno (id_seguimiento_terreno, id_actividad_terreno) 
                        VALUES ($1, $2)";
            $obj->insert($sqlInsert, [$id, $idActividad]);
        }

        $sql = "UPDATE seguimiento_terreno SET 
            fecha = '$fecha',
            hora_inicio = '$hora_inicio',
            hora_fin = '$hora_fin',
            id_estado = '$estado'
        WHERE id_seguimiento_terreno = '$id'";

        $ejecutar = $obj->update($sql);

        $sql2 = "UPDATE seguimiento_terreno
                SET id_estado = 3 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado =  4";

        $ejecutar2 = $obj->update($sql2);

        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "El Seguimiento de Terreno se actualizó correctamente.";
            $sql2 = "UPDATE seguimiento_terreno 
                SET id_estado = 2 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado = 1";

            $ejecutar = $obj->update($sql2);


            redirect(getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getConsultar"));
        } else {
            echo "No se pudo actualizar el seguimiento";
        }
        ;

    }


    public function postDelete()
    {

        $obj = new SeguimientoTerrenoModel();
        $id = $_GET['id'];

        $sql2 = "SELECT id_estado from seguimiento_Terreno WHERE id_seguimiento_terreno = $id";
        $ejecutar2 = $obj->select($sql2);
        foreach ($ejecutar2 as $s) {


            if ($s['id_estado'] == 2) {

                echo '<script>alert("¡Este Seguimiento ya esta inhabilitado!");</script>';
                redirect(getUrl("SeguimientoTerreno", "SeguimientoTerreno", "getConsultar"));
            } else if ($s['id_estado'] == 1) {
                $sql = "UPDATE seguimiento_Terreno SET id_estado = 3 WHERE id_seguimiento_terreno = $id";

                $ejecutar = $obj->delete($sql);
                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "El seguimiento de Terreno se inhabilito correctamente.";
                    redirect(getUrl("seguimientoTerreno", "seguimientoTerreno", "getConsultar"));
                } else {
                    echo "No se pudo inhabilitar el seguimientoTerreno";
                }
            }
        }
    }

    public function getBuscar()
    {


        $busqueda = mb_strtoupper($_GET['busqueda'] ?? '');
        if (!empty($busqueda)) {
            $obj = new SeguimientoTerrenoModel();

            $palabra = $_GET['busqueda'];

            $sql = "SELECT 
                s.id_seguimiento_terreno,
                s.cod_seguimiento,
                s.fecha,
                s.hora_inicio,
                s.hora_fin,
                s.id_estado,
                si.nombre_sitio,
                sd.codigo_sitio_deposito AS cod_terreno,
                u.primer_nombre,
                u.primer_apellido,
                STRING_AGG(at.nombre_actividad, ', ') AS actividades
            FROM seguimiento_terreno s
            INNER JOIN usuarios u ON s.id_usuario = u.id_usuario
            INNER JOIN rol r ON u.id_rol = r.id_rol
            LEFT JOIN sitio si ON s.id_sitio = si.id_sitio
            LEFT JOIN sitio_deposito sd ON s.id_sitio = sd.id_sitio
            LEFT JOIN actividad_seg_terreno ast ON s.id_seguimiento_terreno = ast.id_seguimiento_terreno
            LEFT JOIN actividad_terreno at ON ast.id_actividad_terreno = at.id_actividad_terreno
            WHERE r.nombre_rol IN ('Auxiliar Terreno', 'Coordinador Terreno') AND s.cod_seguimiento ILIKE $1
            GROUP BY 
                s.id_seguimiento_terreno, 
                s.cod_seguimiento, 
                s.fecha, 
                s.hora_inicio, 
                s.hora_fin, 
                s.id_estado, 
                si.nombre_sitio,
                sd.nombre,
                u.primer_nombre, 
                u.primer_apellido
            ORDER BY s.id_seguimiento_terreno";



            $seguimientos = $obj->select($sql, ['%' . $busqueda . '%']);

            include_once '../view/partials/SeguimientoTerreno/Buscar.php';
        } else {
            $obj = new SeguimientoTerrenoModel();

            $sql = "SELECT 
                s.id_seguimiento_terreno,
                s.cod_seguimiento,
                s.fecha,
                s.hora_inicio,
                s.hora_fin,
                s.id_estado,
                si.nombre_sitio,
                sd.nombre AS cod_terreno,
                u.primer_nombre,
                u.primer_apellido,
                STRING_AGG(at.nombre_actividad, ', ') AS actividades
            FROM seguimiento_terreno s
            INNER JOIN usuarios u ON s.id_usuario = u.id_usuario
            INNER JOIN rol r ON u.id_rol = r.id_rol
            LEFT JOIN sitio si ON s.id_sitio = si.id_sitio
            LEFT JOIN sitio_deposito sd ON s.id_sitio = sd.id_sitio
            LEFT JOIN actividad_seg_terreno ast ON s.id_seguimiento_terreno = ast.id_seguimiento_terreno
            LEFT JOIN actividad_terreno at ON ast.id_actividad_terreno = at.id_actividad_terreno
            WHERE r.nombre_rol IN ('Auxiliar Terreno', 'Coordinador Terreno')
            GROUP BY 
                s.id_seguimiento_terreno, 
                s.cod_seguimiento, 
                s.fecha, 
                s.hora_inicio, 
                s.hora_fin, 
                s.id_estado, 
                si.nombre_sitio,
                sd.nombre,
                u.primer_nombre, 
                u.primer_apellido
            ORDER BY s.id_seguimiento_terreno";

            $seguimientos = $obj->select($sql);


            $sql2 = "UPDATE seguimiento_terreno
                SET id_estado = 3 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado =  4";

            $ejecutar = $obj->update($sql2);


            include_once '../view/partials/SeguimientoTerreno/consultar.php';
        }

    }




    public function getSitios()
    {
        $id_sitio = $_GET['id_sitio'];

        $obj = new SeguimientoTerrenoModel();

        $sql = "SELECT td.id_tipo_deposito, td.nombre 
        FROM tipo_de_deposito td
        INNER JOIN sitio s ON s.id_tipo_deposito = td.id_tipo_deposito
        WHERE s.id_sitio = $1";

        $terreno = $obj->select($sql, [$id_sitio]);

        $sql2 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido FROM usuarios WHERE id_sitio = $1 AND id_rol = 3";
        $usuarios = $obj->select($sql2, [$id_sitio]);

        $resultado = [
            'terreno' => $terreno,
            'usuarios' => $usuarios
        ];

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }





}

?>