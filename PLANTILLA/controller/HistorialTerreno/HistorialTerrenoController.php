<?php

include_once '../model/HistorialTerreno/FormulariosModel.php';


class HistorialTerrenoController
{
    public function getConsultar()
    {
        $obj = new FormulariosModel();

        $sql = "SELECT s.id_seguimiento_terreno, s.cod_seguimiento, s.fecha, u.documento, s.id_estado, si.nombre_sitio
                FROM seguimiento_terreno s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                LEFT JOIN sitio si ON s.id_sitio = si.id_sitio
                ORDER BY s.id_seguimiento_terreno DESC";

        $seguimientos = $obj->select($sql);

        include_once '../view/partials/HistorialTerreno/Consultar.php';
    }

    public function getEditar()
    {
        $id = $_GET['id'] ?? null;
        $obj = new FormulariosModel();

        $sqlSeg = "SELECT id_seguimiento_terreno, cod_seguimiento, fecha, id_estado
                   FROM seguimiento_terreno
                   WHERE id_seguimiento_terreno = '$id'";
        $segResult = $obj->select($sqlSeg);
        $seguimiento = !empty($segResult) ? $segResult[0] : null;

        // Ahora el tipo de cada fila se obtiene del catálogo real (actividad_terreno) vía la
        // tabla puente actividad_ter_subactividades, y se busca por cod_seguimiento (no por id),
        // igual que hace el módulo de zoo.
        $inspeccion = null;
        $siembra = null;
        $seguimientoDetalle = null;
        $resiembra = null;

        if ($seguimiento) {
            $cod = $seguimiento['cod_seguimiento'];

            $sqlSub = "SELECT sub.*, at.nombre_actividad
                       FROM sub_actividades_ter sub
                       LEFT JOIN actividad_ter_subactividades ats ON sub.id_sub_actividad = ats.id_sub_actividades
                       LEFT JOIN actividad_terreno at ON ats.id_actividad_terreno = at.id_actividad_terreno
                       WHERE sub.cod_seguimiento = '$cod'";
            $subRows = $obj->select($sqlSub);

            foreach ($subRows as $row) {
                switch ($row['nombre_actividad']) {
                    case 'Inspección':
                        $inspeccion = $row;
                        break;
                    case 'Siembra':
                        $siembra = $row;
                        break;
                    case 'Seguimiento':
                        $seguimientoDetalle = $row;
                        break;
                    case 'Resiembra':
                        $resiembra = $row;
                        break;
                }
            }
        }

        $sqlEstados = "SELECT * FROM estado";
        $estados = $obj->select($sqlEstados);

        include_once '../view/partials/HistorialTerreno/Editar.php';
    }

    public function postUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new FormulariosModel();

            $id_seguimiento_terreno = $_POST['id_seguimiento_terreno'] ?? null;
            $cod_seguimiento = $_POST['cod_seguimiento'] ?? '';
            $fecha = $_POST['fecha'] ?? '';
            $id_estado = $_POST['id_estado'] ?? 1;

            if (!$id_seguimiento_terreno) {
                echo "Error: No se proporcionó el ID del seguimiento.";
                return;
            }

            // 1. Actualizar el seguimiento principal
            $sqlSeg = "UPDATE seguimiento_terreno 
                       SET cod_seguimiento = '$cod_seguimiento', 
                           fecha = '$fecha', 
                           id_estado = $id_estado 
                       WHERE id_seguimiento_terreno = $id_seguimiento_terreno";
            $obj->update($sqlSeg);

            // 2. Inspección
            $id_sub_inspeccion = $_POST['id_sub_inspeccion'] ?? '';
            $depositoDetectado = isset($_POST['depositoDetectado']) ? 'true' : 'false';
            $temperatura = $_POST['temperatura'] ?? '';
            $phMedido = $_POST['phMedido'] ?? '';
            $presenciaLarvasInsp = isset($_POST['presenciaLarvasInsp']) ? 'true' : 'false';
            $fecha_inspeccion = $_POST['fecha_inspeccion'] ?? '';
            $obser_inspeccion = $_POST['obser_inspeccion'] ?? '';

            if (!empty($id_sub_inspeccion)) {
                $sql = "UPDATE sub_actividades_ter 
                        SET deposito_agua_detectado = $depositoDetectado, 
                            temperatura = " . ($temperatura !== '' ? $temperatura : 0) . ", 
                            ph_medido = " . ($phMedido !== '' ? $phMedido : 0) . ", 
                            presencia_larvas_inspeccion = $presenciaLarvasInsp, 
                            fecha_inspeccion = '$fecha_inspeccion', 
                            obser_inspeccion = '$obser_inspeccion',
                            cod_seguimiento = '$cod_seguimiento'
                        WHERE id_sub_actividad = $id_sub_inspeccion";
                $obj->update($sql);
            } elseif (!empty($fecha_inspeccion) || !empty($obser_inspeccion)) {
                $tempVal = $temperatura !== '' ? $temperatura : 0;
                $phVal = $phMedido !== '' ? $phMedido : 0;
                $sql = "INSERT INTO sub_actividades_ter 
                        (deposito_agua_detectado, temperatura, ph_medido, presencia_larvas_inspeccion, fecha_inspeccion, obser_inspeccion, id_estado, id_seguimiento_terreno, cod_seguimiento)
                        VALUES ($depositoDetectado, $tempVal, $phVal, $presenciaLarvasInsp, '$fecha_inspeccion', '$obser_inspeccion', $id_estado, $id_seguimiento_terreno, '$cod_seguimiento')";
                $obj->insert($sql);
            }

            // 3. Siembra
            $id_sub_siembra = $_POST['id_sub_siembra'] ?? '';
            $tiempoAclimatacion = $_POST['tiempoAclimatacion'] ?? '';
            $canEmpacados = $_POST['canEmpacados'] ?? '';
            $canHembrasSiembra = $_POST['canHembrasSiembra'] ?? '';
            $canMachosSiembra = $_POST['canMachosSiembra'] ?? '';
            $canGuppiesSiembra = $_POST['canGuppiesSiembra'] ?? '';
            $litrosUtilizados = $_POST['litrosUtilizados'] ?? '';
            $presenciaLarvasSiembra = isset($_POST['presenciaLarvasSiembra']) ? 'true' : 'false';
            $presenciaPecesSiembra = isset($_POST['presenciaPecesSiembra']) ? 'true' : 'false';
            $fecha_siembra = $_POST['fecha_siembra'] ?? '';
            $obser_siembra = $_POST['obser_siembra'] ?? '';

            if (!empty($id_sub_siembra)) {
                $sql = "UPDATE sub_actividades_ter 
                        SET tiempo_aclimatacion = " . ($tiempoAclimatacion !== '' ? $tiempoAclimatacion : 0) . ", 
                            can_peces_empacados = " . ($canEmpacados !== '' ? $canEmpacados : 0) . ", 
                            can_hembras_sembradas = " . ($canHembrasSiembra !== '' ? $canHembrasSiembra : 0) . ", 
                            can_machos_sembrados = " . ($canMachosSiembra !== '' ? $canMachosSiembra : 0) . ", 
                            can_peces_guppies_sembrados = " . ($canGuppiesSiembra !== '' ? $canGuppiesSiembra : 0) . ", 
                            litros_utilizados = " . ($litrosUtilizados !== '' ? $litrosUtilizados : 0) . ", 
                            presencia_larvas_siembra = $presenciaLarvasSiembra, 
                            presencia_peces_siembra = $presenciaPecesSiembra, 
                            fecha_siembra = '$fecha_siembra', 
                            obser_siembra = '$obser_siembra',
                            cod_seguimiento = '$cod_seguimiento'
                        WHERE id_sub_actividad = $id_sub_siembra";
                $obj->update($sql);
            } elseif (!empty($fecha_siembra) || !empty($obser_siembra)) {
                $tiempoVal = $tiempoAclimatacion !== '' ? $tiempoAclimatacion : 0;
                $empacadosVal = $canEmpacados !== '' ? $canEmpacados : 0;
                $hembrasVal = $canHembrasSiembra !== '' ? $canHembrasSiembra : 0;
                $machosVal = $canMachosSiembra !== '' ? $canMachosSiembra : 0;
                $guppiesVal = $canGuppiesSiembra !== '' ? $canGuppiesSiembra : 0;
                $litrosVal = $litrosUtilizados !== '' ? $litrosUtilizados : 0;
                $sql = "INSERT INTO sub_actividades_ter 
                        (tiempo_aclimatacion, can_peces_empacados, can_hembras_sembradas, can_machos_sembrados, can_peces_guppies_sembrados, litros_utilizados, presencia_larvas_siembra, presencia_peces_siembra, fecha_siembra, obser_siembra, id_estado, id_seguimiento_terreno, cod_seguimiento)
                        VALUES ($tiempoVal, $empacadosVal, $hembrasVal, $machosVal, $guppiesVal, $litrosVal, $presenciaLarvasSiembra, $presenciaPecesSiembra, '$fecha_siembra', '$obser_siembra', $id_estado, $id_seguimiento_terreno, '$cod_seguimiento')";
                $obj->insert($sql);
            }

            // 4. Seguimiento (visita)
            $id_sub_seguimiento = $_POST['id_sub_seguimiento'] ?? '';
            $numeroVisita = $_POST['numeroVisita'] ?? '';
            $depositoVisitado = isset($_POST['depositoVisitado']) ? 'true' : 'false';
            $presenciaLarvasSeg = isset($_POST['presenciaLarvasSeg']) ? 'true' : 'false';
            $presenciaPecesSeg = isset($_POST['presenciaPecesSeg']) ? 'true' : 'false';
            $fecha_seguimiento = $_POST['fecha_seguimiento'] ?? '';
            $obser_seguimiento = $_POST['obser_seguimiento'] ?? '';

            if (!empty($id_sub_seguimiento)) {
                $sql = "UPDATE sub_actividades_ter 
                        SET numero_visita = " . ($numeroVisita !== '' ? $numeroVisita : 1) . ", 
                            deposito_agua_visitado = $depositoVisitado, 
                            presencia_larvas_seguimiento = $presenciaLarvasSeg, 
                            presencia_peces_seguimiento = $presenciaPecesSeg, 
                            fecha_seguimiento = '$fecha_seguimiento', 
                            obser_seguimiento = '$obser_seguimiento',
                            cod_seguimiento = '$cod_seguimiento'
                        WHERE id_sub_actividad = $id_sub_seguimiento";
                $obj->update($sql);
            } elseif (!empty($fecha_seguimiento) || !empty($obser_seguimiento)) {
                $visitaVal = $numeroVisita !== '' ? $numeroVisita : 1;
                $sql = "INSERT INTO sub_actividades_ter 
                        (numero_visita, deposito_agua_visitado, presencia_larvas_seguimiento, presencia_peces_seguimiento, fecha_seguimiento, obser_seguimiento, id_estado, id_seguimiento_terreno, cod_seguimiento)
                        VALUES ($visitaVal, $depositoVisitado, $presenciaLarvasSeg, $presenciaPecesSeg, '$fecha_seguimiento', '$obser_seguimiento', $id_estado, $id_seguimiento_terreno, '$cod_seguimiento')";
                $obj->insert($sql);
            }

            // 5. Resiembra
            $id_sub_resiembra = $_POST['id_sub_resiembra'] ?? '';
            $canHembrasResi = $_POST['canHembrasResi'] ?? '';
            $canMachosResi = $_POST['canMachosResi'] ?? '';
            $canGuppiesResi = $_POST['canGuppiesResi'] ?? '';
            $presenciaLarvasResi = isset($_POST['presenciaLarvasResi']) ? 'true' : 'false';
            $presenciaPecesResi = isset($_POST['presenciaPecesResi']) ? 'true' : 'false';
            $fecha_resiembra = $_POST['fecha_resiembra'] ?? '';
            $obser_resiembra = $_POST['obser_resiembra'] ?? '';

            if (!empty($id_sub_resiembra)) {
                $sql = "UPDATE sub_actividades_ter 
                        SET can_hembras_sembradas = " . ($canHembrasResi !== '' ? $canHembrasResi : 0) . ", 
                            can_machos_sembrados = " . ($canMachosResi !== '' ? $canMachosResi : 0) . ", 
                            can_peces_guppies_sembrados = " . ($canGuppiesResi !== '' ? $canGuppiesResi : 0) . ", 
                            presencia_larvas_resiembra = $presenciaLarvasResi, 
                            presencia_peces_resiembra = $presenciaPecesResi, 
                            fecha_resiembra = '$fecha_resiembra', 
                            obser_resiembra = '$obser_resiembra',
                            cod_seguimiento = '$cod_seguimiento'
                        WHERE id_sub_actividad = $id_sub_resiembra";
                $obj->update($sql);
            } elseif (!empty($fecha_resiembra) || !empty($obser_resiembra)) {
                $hembrasVal = $canHembrasResi !== '' ? $canHembrasResi : 0;
                $machosVal = $canMachosResi !== '' ? $canMachosResi : 0;
                $guppiesVal = $canGuppiesResi !== '' ? $canGuppiesResi : 0;
                $sql = "INSERT INTO sub_actividades_ter 
                        (can_hembras_sembradas, can_machos_sembrados, can_peces_guppies_sembrados, presencia_larvas_resiembra, presencia_peces_resiembra, fecha_resiembra, obser_resiembra, id_estado, id_seguimiento_terreno, cod_seguimiento)
                        VALUES ($hembrasVal, $machosVal, $guppiesVal, $presenciaLarvasResi, $presenciaPecesResi, '$fecha_resiembra', '$obser_resiembra', $id_estado, $id_seguimiento_terreno, '$cod_seguimiento')";
                $obj->insert($sql);
            }

            $_SESSION['mensaje_exito'] = "El registro se actualizó correctamente.";
            redirect(getUrl("HistorialTerreno", "HistorialTerreno", "getConsultar"));
        }
    }
}

?>