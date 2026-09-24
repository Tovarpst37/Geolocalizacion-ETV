<?php

include_once '../model/SeguimientoTerreno/SeguimientoTerrenoModel.php';





class SeguimientoTerrenoController
{

    private const COD_INSPECCION = 'AT-1';
private const COD_SIEMBRA = 'AT-2';
private const COD_SEGUIMIENTO = 'AT-3';
private const COD_RESIEMBRA = 'AT-4';

private array $mapaActividadesTerreno = []; 

    private function getMapaActividadesTerreno($obj)
{
    $sql = "SELECT id_actividad_terreno, cod_actividad_terreno FROM actividad_terreno";
    $rows = $obj->select($sql);

    $mapa = [];
    foreach ($rows as $row) {
        $mapa[$row['cod_actividad_terreno']] = $row['id_actividad_terreno'];
    }
    return $mapa;
}





    public function getConsultar()
    {

        $obj = new SeguimientoTerrenoModel();

        
        $sql = "SELECT s.id_seguimiento_terreno, s.cod_seguimiento, s.fecha, u.documento, s.id_estado, si.nombre_sitio
                FROM seguimiento_terreno s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                LEFT JOIN sitio si ON s.id_sitio = si.id_sitio
                ORDER BY s.id_seguimiento_terreno DESC";

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

        

       
// Catálogo maestro: código => nombre (los 4 procesos del mapa de Trabajo de Terreno)
$actividades_proceso_terreno = [
    "AT-1" => "INSPECCION",
    "AT-2" => "SIEMBRA",
    "AT-3" => "SEGUIMIENTO",
    "AT-4" => "RESIEMBRA"
];

$sql = "SELECT id_actividad_terreno, nombre_actividad, id_estado, cod_actividad_terreno 
        FROM actividad_terreno 
        WHERE id_estado = 1 
        ORDER BY id_actividad_terreno";
$actividades = $obj->select($sql);


$codigos_registrados = array_column($actividades, 'cod_actividad_terreno');


$actividades_faltantes = array_diff_key($actividades_proceso_terreno, array_flip($codigos_registrados));




        include_once '../view/partials/SeguimientoTerreno/Registrar.php';

    }


  public function postRegistrar()
{
    $obj = new SeguimientoTerrenoModel(); // ajusta el nombre real de tu modelo

    // Mapa cod_actividad => id_actividad_terreno (no depende del orden ni del valor numérico del id)
    $this->mapaActividadesTerreno = $this->getMapaActividadesTerreno($obj);
    $mapaActividadesTerreno = $this->mapaActividadesTerreno;

    $codigo   = mb_strtoupper($_POST['codigo'] ?? '');
    $sitio    = $_POST['select_ter'] ?? '';
    $usuario  = $_POST['selectUsuarios'] ?? '';
    $deposito = $_POST['selectTerreno'] ?? '';

    $actividades = $_POST['actividades'] ?? [];

    $sql_validar = "SELECT id_seguimiento_terreno FROM seguimiento_terreno WHERE cod_seguimiento = $1";
    $existe      = $obj->select($sql_validar, [$codigo]);

    $errores = [];

    if (!empty($existe)) {
        $errores[] = "Ya existe un seguimiento con ese código";
    }
    if (empty($codigo)) {
        $errores[] = "Debe ingresar el codigo del seguimiento";
    }
    if (empty($sitio)) {
        $errores[] = "Debe seleccionar el sitio.";
    }
    if (empty($usuario)) {
        $errores[] = "Debe seleccionar el Auxiliar asignado.";
    }
    if (empty($deposito)) {
        $errores[] = "Debe seleccionar el depósito al que se le hará el seguimiento.";
    }

    // ---- INSPECCIÓN: validar solo si viene marcada esa actividad ----
    $tieneInspeccion = isset($mapaActividadesTerreno[self::COD_INSPECCION])
        && in_array($mapaActividadesTerreno[self::COD_INSPECCION], $actividades);

    $depositoDetRaw  = $_POST['depositoDetectado'] ?? '';
    $phMedido        = $_POST['phMedido'] ?? '';
    $temperatura     = $_POST['temperatura'] ?? '';
    $presenciaLarvRaw = $_POST['presenciaLarvas'] ?? '';
    $obserInsp       = trim($_POST['obserInsp'] ?? '');
    $obserInsp       = strip_tags($obserInsp);

    if ($tieneInspeccion) {
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
        if (!empty($obserInsp) && strlen($obserInsp) > 250) {
            $errores[] = "Las observaciones de inspección no pueden superar los 250 caracteres.";
        }
    }

    // ---- SIEMBRA: validar solo si viene marcada esa actividad ----
    $tieneSiembra = isset($mapaActividadesTerreno[self::COD_SIEMBRA])
        && in_array($mapaActividadesTerreno[self::COD_SIEMBRA], $actividades);

    $pecesEmpacados         = $_POST['pecesEmpacados'] ?? '';
    $tiempoAclimat          = $_POST['tiempoAclimat'] ?? null;
    $hembrasSembradas       = $_POST['hembrasSembradas'] ?? '';
    $machosSembrados        = $_POST['machosSembrados'] ?? '';
    $litrosAgua             = $_POST['litrosAgua'] ?? '';
    $presenciaLarvasSiemRaw = $_POST['presenciaLarvasSiem'] ?? '';
    $presenciaPecesSiemRaw  = $_POST['presenciaPecesSiem'] ?? '';
    $obserSiem              = trim($_POST['obserSiem'] ?? '');
    $obserSiem              = strip_tags($obserSiem);

    if ($tieneSiembra) {
        if ($pecesEmpacados === '' || !is_numeric($pecesEmpacados) || $pecesEmpacados < 0) {
            $errores[] = "La cantidad de peces empacados es obligatoria y debe ser un número válido.";
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
        if (!empty($obserSiem) && strlen($obserSiem) > 250) {
            $errores[] = "Las observaciones de siembra no pueden superar los 250 caracteres.";
        }
    }

    // ---- SEGUIMIENTO: validar solo si viene marcada esa actividad ----
    $tieneSeguimientoAct = isset($mapaActividadesTerreno[self::COD_SEGUIMIENTO])
        && in_array($mapaActividadesTerreno[self::COD_SEGUIMIENTO], $actividades);

    $numeroVisitaRaw       = $_POST['numeroVisita'] ?? '';
    $depositoVisRaw        = $_POST['depositoVisitado'] ?? '';
    $presenciaLarvasSegRaw = $_POST['presenciaLarvasSeg'] ?? '';
    $presenciaPecesSegRaw  = $_POST['presenciaPecesSeg'] ?? '';
    $obserSeg              = trim($_POST['obserSeg'] ?? '');
    $obserSeg              = strip_tags($obserSeg);

    if ($tieneSeguimientoAct) {
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
        if (!empty($obserSeg) && strlen($obserSeg) > 250) {
            $errores[] = "Las observaciones de seguimiento no pueden superar los 250 caracteres.";
        }
    }

    // ---- RESIEMBRA: validar solo si viene marcada esa actividad ----
    $tieneResiembra = isset($mapaActividadesTerreno[self::COD_RESIEMBRA])
        && in_array($mapaActividadesTerreno[self::COD_RESIEMBRA], $actividades);

    $canHembrasResi         = $_POST['canHembras'] ?? '';
    $canMachosResi          = $_POST['canMachos'] ?? '';
    $canGuppiesResi         = $_POST['canGuppies'] ?? '';
    $presenciaLarvasResiRaw = $_POST['presenciaLarvasResi'] ?? '';
    $presenciaPecesResiRaw  = $_POST['presenciaPecesResi'] ?? '';
    $obserResi              = trim($_POST['obserResi'] ?? '');
    $obserResi              = strip_tags($obserResi);

    if ($tieneResiembra) {
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
        if (!empty($obserResi) && strlen($obserResi) > 250) {
            $errores[] = "Las observaciones de resiembra no pueden superar los 250 caracteres.";
        }
    }

    // ---- Retorno en caso de error ----
    if (!empty($errores)) {
        include_once '../model/Errores/ErrorModal.php';
        ErrorModal::verError($errores, getUrl('SeguimientoTerreno', 'SeguimientoTerreno', 'getRegistrar'));
        return;
    }

    // ---- Inserción Principal ----
    $sql = "INSERT INTO seguimiento_terreno (cod_seguimiento, fecha, id_sitio, id_usuario, id_estado, hora_inicio, hora_fin)
            VALUES ($1, CURRENT_TIMESTAMP, $2, $3, $4, $5, $6)
            RETURNING id_seguimiento_terreno";

    $resultado = $obj->select($sql, [$codigo, $sitio, $usuario, 5, null, null]);

    if ($resultado) {
        $id_seguimiento = $resultado[0]['id_seguimiento_terreno'];

        foreach ($actividades as $id_actividad) {
            $sql2 = "INSERT INTO actividad_seg_terreno (id_seguimiento_terreno, id_actividad_terreno) 
                    VALUES ('$id_seguimiento', '$id_actividad')";
            $obj->insert($sql2);
        }

        // ---- Guardar Inspección ----
        if ($tieneInspeccion) {
            $this->guardarInspeccion(
                $obj,
                $id_seguimiento,
                $codigo,
                $depositoDetRaw,
                $phMedido,
                $temperatura,
                $presenciaLarvRaw,
                $obserInsp
            );
        }

        // ---- Guardar Siembra ----
        if ($tieneSiembra) {
            $this->guardarSiembra(
                $obj,
                $id_seguimiento,
                $codigo,
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

        // ---- Guardar Seguimiento ----
        if ($tieneSeguimientoAct) {
            $this->guardarSeguimientoAct(
                $obj,
                $id_seguimiento,
                $codigo,
                $numeroVisitaRaw,
                $depositoVisRaw,
                $presenciaLarvasSegRaw,
                $presenciaPecesSegRaw,
                $obserSeg
            );
        }

        // ---- Guardar Resiembra ----
        if ($tieneResiembra) {
            $this->guardarResiembra(
                $obj,
                $id_seguimiento,
                $codigo,
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
private function guardarInspeccion($obj, $id_seguimiento, $codigo, $depositoDetRaw, $phMedido, $temperatura, $presenciaLarvRaw, $obser)
{
    $depositoDet = $depositoDetRaw === '1' ? 'true' : 'false';
    $presenciaLarv = $presenciaLarvRaw === '1' ? 'true' : 'false';

    $sqlSub = "INSERT INTO sub_actividades_ter
       (fecha_inspeccion, deposito_agua_detectado, ph_medido, temperatura, 
        presencia_larvas_inspeccion, obser_inspeccion, 
        id_estado, id_seguimiento_terreno, cod_seguimiento) 
       VALUES 
       (CURRENT_TIMESTAMP, $1, $2, $3, 
        $4, $5, 
        1, $6, $7)
       RETURNING id_sub_actividad";

    $resSub = $obj->select($sqlSub, [
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
            [$this->mapaActividadesTerreno[self::COD_INSPECCION], $id_sub_actividad]
        );
    }
}

// ---- Siembra, misma lógica que FormularioSiemController::postInsert ----
private function guardarSiembra($obj, $id_seguimiento, $codigo,  $pecesEmpacados, $tiempoAclimat, $hembrasSembradas, $machosSembrados, $litrosAgua, $presenciaLarvasRaw, $presenciaPecesRaw, $obser)
{
    $presenciaLarv = $presenciaLarvasRaw === '1' ? 'true' : 'false';
    $presenciaPec = $presenciaPecesRaw === '1' ? 'true' : 'false';

    $sqlSub = "INSERT INTO sub_actividades_ter
       (fecha_siembra, can_peces_empacados, tiempo_aclimatacion, 
        can_hembras_sembradas, can_machos_sembrados, litros_utilizados, 
        presencia_larvas_siembra, presencia_peces_siembra, obser_siembra, 
        id_estado, id_seguimiento_terreno, cod_seguimiento) 
       VALUES 
       (CURRENT_TIMESTAMP, $1, $2, 
        $3, $4, $5, 
        $6, $7, $8, 
        1, $9, $10)
       RETURNING id_sub_actividad";

    $resSub = $obj->select($sqlSub, [
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
            [$this->mapaActividadesTerreno[self::COD_SIEMBRA], $id_sub_actividad]
        );
    }
}

// ---- Seguimiento, misma lógica que FormularioSegTController::postInsert ----
private function guardarSeguimientoAct($obj, $id_seguimiento, $codigo,  $numeroVisitaRaw, $depositoVisRaw, $presenciaLarvasRaw, $presenciaPecesRaw, $obser)
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
   (CURRENT_TIMESTAMP, $1, $2, 
    $3, $4, $5, 
    1, $6, $7)
   RETURNING id_sub_actividad";

    $resSub = $obj->select($sqlSub, [
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
            [$this->mapaActividadesTerreno[self::COD_SEGUIMIENTO], $id_sub_actividad]
        );
    }
}

// ---- Resiembra, misma lógica que FormularioResiController::postInsert ----
private function guardarResiembra($obj, $id_seguimiento, $codigo, $canHembras, $canMachos, $canGuppies, $presenciaLarvasRaw, $presenciaPecesRaw, $obser)
{
    $presenciaLarv = $presenciaLarvasRaw === '1' ? 'true' : 'false';
    $presenciaPec = $presenciaPecesRaw === '1' ? 'true' : 'false';

    $sqlSub = "INSERT INTO sub_actividades_ter
       (fecha_resiembra, can_hembras_sembradas, can_machos_sembrados, can_peces_guppies_sembrados,
        presencia_larvas_resiembra, presencia_peces_resiembra, obser_resiembra, 
        id_estado, id_seguimiento_terreno, cod_seguimiento) 
       VALUES 
       (CURRENT_TIMESTAMP, $1, $2, $3,
        $4, $5, $6, 
        1, $7, $8)
       RETURNING id_sub_actividad";

    $resSub = $obj->select($sqlSub, [
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
            [$this->mapaActividadesTerreno[self::COD_RESIEMBRA], $id_sub_actividad]
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
    $obj = new SeguimientoTerrenoModel();
    $palabra = $_GET['busqueda'] ?? '';
    $busqueda = trim($palabra);

    // Actualiza estados vencidos
    $sqlEstado = "UPDATE seguimiento_terreno
        SET id_estado = 3 
        WHERE fecha = CURRENT_DATE 
        AND hora_fin < LOCALTIME 
        AND id_estado = 4";
    $obj->update($sqlEstado);

    if (!empty($busqueda)) {
        $sql = "SELECT 
                    s.id_seguimiento_terreno, 
                    s.cod_seguimiento, 
                    s.fecha, 
                    u.documento, 
                    s.id_estado, 
                    si.nombre_sitio
                FROM seguimiento_terreno s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                LEFT JOIN sitio si ON s.id_sitio = si.id_sitio
                WHERE 
                    s.cod_seguimiento ILIKE $1
                    OR CAST(u.documento AS TEXT) ILIKE $1
                    OR si.nombre_sitio ILIKE $1
                ORDER BY s.id_seguimiento_terreno DESC";

        $seguimientos = $obj->select($sql, ['%' . $busqueda . '%']);

        include_once '../view/partials/SeguimientoTerreno/Buscar.php';
    } else {
        $sql = "SELECT 
                    s.id_seguimiento_terreno, 
                    s.cod_seguimiento, 
                    s.fecha, 
                    u.documento, 
                    s.id_estado, 
                    si.nombre_sitio
                FROM seguimiento_terreno s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                LEFT JOIN sitio si ON s.id_sitio = si.id_sitio
                ORDER BY s.id_seguimiento_terreno DESC";

        $seguimientos = $obj->select($sql);

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