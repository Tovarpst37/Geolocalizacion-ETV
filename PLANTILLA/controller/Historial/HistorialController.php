<?php

include_once '../model/Historial/HistorialModel.php';


class HistorialController
{
    public function getConsultar()
    {
        $obj = new HistorialModel();

        // seguimiento_zoocriadero ya es único por cod_seguimiento (los formularios reutilizan
        // el mismo id_seguimiento_zoo), así que no hace falta unir con sub_actividades aquí.
        $sql = "SELECT s.id_seguimiento_zoo, s.cod_seguimiento, s.fecha, u.documento, s.id_estado
                FROM seguimiento_zoocriadero s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                ORDER BY s.id_seguimiento_zoo DESC";

        $seguimientos = $obj->select($sql);

        include_once '../view/partials/Historial/Consultar.php';
    }

    private function getOrCreateActividadZoo($obj, $nombre, $codigoDefault)
    {
        $sqlBuscar = "SELECT id_actividad_zoo FROM actividad_zoocriadero WHERE nombre_actividad = '$nombre'";
        $res = $obj->select($sqlBuscar);

        if (!empty($res)) {
            return $res[0]['id_actividad_zoo'];
        }

        $sqlCrear = "INSERT INTO actividad_zoocriadero (cod_actividad, nombre_actividad, id_estado) 
                 VALUES ('$codigoDefault', '$nombre', 1) 
                 RETURNING id_actividad_zoo";
        $creado = $obj->select($sqlCrear);

        return !empty($creado) ? $creado[0]['id_actividad_zoo'] : null;
    }

    public function getEditar()
    {
        $id = $_GET['id'] ?? null;
        $obj = new HistorialModel();

        $sqlSeg = "SELECT id_seguimiento_zoo, cod_seguimiento, fecha, id_estado
               FROM seguimiento_zoocriadero
               WHERE id_seguimiento_zoo = '$id'";
        $segResult = $obj->select($sqlSeg);
        $seguimiento = !empty($segResult) ? $segResult[0] : null;

        // Ahora el tipo de cada fila se obtiene del catálogo real, vía la tabla puente,
        // en vez de adivinar por columnas nulas.
        $sqlSub = "SELECT sub.id_sub_actividad, sub.tipo_alimento, sub.fecha_alimentacion, sub.genero, sub.obser_alimentacion,
                      sub.can_peces_mertos_hembra, sub.can_peces_mertos_macho, sub.can_peces_nacido, sub.obser_canpeces,
                      sub.estregar_paredes, sub.aspirar, sub.succionador, sub.fecha_limpieza, sub.obser_limpieza,
                      sub.adicion_nivel_agua, sub.medicion_ph, sub.medicion_temperatura, sub.fecha_ajuste, sub.obser_ajuste,
                      sub.estado_tanque, sub.agua_cambiada, sub.fecha_lavado, sub.obser_lavado,
                      az.nombre_actividad
               FROM sub_actividades sub
               LEFT JOIN actividad_zoo_subactividades azs ON sub.id_sub_actividad = azs.id_sub_actividades
               LEFT JOIN actividad_zoocriadero az ON azs.id_actividad_zoo = az.id_actividad_zoo
               WHERE sub.id_seguimiento_zoo = '$id'";
        $subRows = $obj->select($sqlSub);

        $alimentacion = null;
        $canpeces = null;
        $limpieza = null;
        $ajuste = null;
        $lavado = null;

        foreach ($subRows as $row) {
            switch ($row['nombre_actividad']) {
                case 'Alimentacion':
                    $alimentacion = $row;
                    break;
                case 'Peces muertos y nacidos':
                    $canpeces = $row;
                    break;
                case 'Limpieza':
                    $limpieza = $row;
                    break;
                case 'Ajuste de nivel':
                    $ajuste = $row;
                    break;
                case 'Lavado':
                    $lavado = $row;
                    break;
            }
        }

        $sqlEstados = "SELECT * FROM estado";
        $estados = $obj->select($sqlEstados);

        include_once '../model/FormularioZ/tipoPez.php';
        include_once '../model/FormularioZ/tipoAlimen.php';

        include_once '../view/partials/Historial/Editar.php';
    }

    public function postUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $obj = new HistorialModel();

            $id_seguimiento_zoo = $_POST['id_seguimiento_zoo'] ?? null;
            $cod_seguimiento = $_POST['cod_seguimiento'] ?? '';
            $fecha = $_POST['fecha'] ?? '';
            $id_estado = $_POST['id_estado'] ?? 1;

            if (!$id_seguimiento_zoo) {
                echo "Error: No se proporcionó el ID del seguimiento.";
                return;
            }

            // 1. Actualizar el seguimiento principal
            $sqlSeg = "UPDATE seguimiento_zoocriadero 
                       SET cod_seguimiento = '$cod_seguimiento', 
                           fecha = '$fecha', 
                           id_estado = $id_estado 
                       WHERE id_seguimiento_zoo = $id_seguimiento_zoo";
            $obj->update($sqlSeg);

            // 2. Alimentación
            $id_sub_alimentacion = $_POST['id_sub_alimentacion'] ?? '';
            $tipo_pez = $_POST['tipo_pez'] ?? '';
            $tipo_alimen = $_POST['tipo_alimen'] ?? '';
            $fecha_alimentacion = $_POST['fecha_alimentacion'] ?? '';
            $obser_alimentacion = $_POST['obser_alimentacion'] ?? '';

            if (!empty($id_sub_alimentacion)) {
                $sql = "UPDATE sub_actividades 
                        SET tipo_alimento = '$tipo_alimen', 
                            fecha_alimentacion = '$fecha_alimentacion', 
                            genero = '$tipo_pez', 
                            obser_alimentacion = '$obser_alimentacion',
                            cod_seguimiento = '$cod_seguimiento'
                        WHERE id_sub_actividad = $id_sub_alimentacion";
                $obj->update($sql);
            } elseif (!empty($tipo_alimen) || !empty($fecha_alimentacion) || !empty($obser_alimentacion)) {
                $sql = "INSERT INTO sub_actividades 
                        (tipo_alimento, fecha_alimentacion, genero, obser_alimentacion, id_estado, id_seguimiento_zoo, cod_seguimiento)
                        VALUES ('$tipo_alimen', '$fecha_alimentacion', '$tipo_pez', '$obser_alimentacion', $id_estado, $id_seguimiento_zoo, '$cod_seguimiento')";
                $obj->insert($sql);
            }

            // 3. Peces muertos / nacidos
            $id_sub_canpeces = $_POST['id_sub_canpeces'] ?? '';
            $canpez = $_POST['canpez'] ?? '';
            $muerto_Macho = $_POST['muerto_Macho'] ?? '';
            $muerto_Hembra = $_POST['muerto_Hembra'] ?? '';
            $obser_canpeces = $_POST['obser_canpeces'] ?? '';

            if (!empty($id_sub_canpeces)) {
                $sql = "UPDATE sub_actividades 
                        SET can_peces_mertos_hembra = '$muerto_Hembra', 
                            can_peces_mertos_macho = '$muerto_Macho', 
                            can_peces_nacido = '$canpez', 
                            obser_canpeces = '$obser_canpeces',
                            cod_seguimiento = '$cod_seguimiento'
                        WHERE id_sub_actividad = $id_sub_canpeces";
                $obj->update($sql);
            } elseif ($canpez !== '' || $muerto_Macho !== '' || $muerto_Hembra !== '' || !empty($obser_canpeces)) {
                $canpezVal = $canpez !== '' ? $canpez : 0;
                $machoVal = $muerto_Macho !== '' ? $muerto_Macho : 0;
                $hembraVal = $muerto_Hembra !== '' ? $muerto_Hembra : 0;
                $sql = "INSERT INTO sub_actividades 
                        (can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, obser_canpeces, id_estado, id_seguimiento_zoo, cod_seguimiento)
                        VALUES ('$hembraVal', '$machoVal', '$canpezVal', '$obser_canpeces', $id_estado, $id_seguimiento_zoo, '$cod_seguimiento')";
                $obj->insert($sql);
            }

            // 4. Limpieza
            $id_sub_limpieza = $_POST['id_sub_limpieza'] ?? '';
            $estregarParedes = isset($_POST['estregarParedes']) ? 'true' : 'false';
            $aspirar = isset($_POST['aspirar']) ? 'true' : 'false';
            $succionador = isset($_POST['succionador']) ? 'true' : 'false';
            $fecha_limpieza = $_POST['fecha_limpieza'] ?? '';
            $obser_limpieza = $_POST['obser_limpieza'] ?? '';

            if (!empty($id_sub_limpieza)) {
                $sql = "UPDATE sub_actividades 
                        SET estregar_paredes = $estregarParedes, 
                            aspirar = $aspirar, 
                            succionador = $succionador, 
                            fecha_limpieza = '$fecha_limpieza', 
                            obser_limpieza = '$obser_limpieza',
                            cod_seguimiento = '$cod_seguimiento'
                        WHERE id_sub_actividad = $id_sub_limpieza";
                $obj->update($sql);
            } elseif (!empty($fecha_limpieza) || !empty($obser_limpieza) || $estregarParedes === 'true' || $aspirar === 'true' || $succionador === 'true') {
                $sql = "INSERT INTO sub_actividades 
                        (estregar_paredes, aspirar, succionador, fecha_limpieza, obser_limpieza, id_estado, id_seguimiento_zoo, cod_seguimiento)
                        VALUES ($estregarParedes, $aspirar, $succionador, '$fecha_limpieza', '$obser_limpieza', $id_estado, $id_seguimiento_zoo, '$cod_seguimiento')";
                $obj->insert($sql);
            }

            // 5. Ajuste de nivel
            $id_sub_ajuste = $_POST['id_sub_ajuste'] ?? '';
            $nivelAgua = $_POST['nivelAgua'] ?? '';
            $ph = $_POST['ph'] ?? '';
            $temp = $_POST['temp'] ?? '';
            $fecha_ajuste = $_POST['fecha_ajuste'] ?? '';
            $obser_ajuste = $_POST['obser_ajuste'] ?? '';

            if (!empty($id_sub_ajuste)) {
                $sql = "UPDATE sub_actividades 
                        SET adicion_nivel_agua = " . ($nivelAgua !== '' ? $nivelAgua : 0) . ", 
                            medicion_ph = " . ($ph !== '' ? $ph : 0) . ", 
                            medicion_temperatura = " . ($temp !== '' ? $temp : 0) . ", 
                            fecha_ajuste = '$fecha_ajuste', 
                            obser_ajuste = '$obser_ajuste',
                            cod_seguimiento = '$cod_seguimiento'
                        WHERE id_sub_actividad = $id_sub_ajuste";
                $obj->update($sql);
            } elseif (!empty($fecha_ajuste) || !empty($obser_ajuste)) {
                $nivelAguaVal = $nivelAgua !== '' ? $nivelAgua : 0;
                $phVal = $ph !== '' ? $ph : 0;
                $tempVal = $temp !== '' ? $temp : 0;
                $sql = "INSERT INTO sub_actividades 
                        (adicion_nivel_agua, medicion_ph, medicion_temperatura, fecha_ajuste, obser_ajuste, id_estado, id_seguimiento_zoo, cod_seguimiento)
                        VALUES ($nivelAguaVal, $phVal, $tempVal, '$fecha_ajuste', '$obser_ajuste', $id_estado, $id_seguimiento_zoo, '$cod_seguimiento')";
                $obj->insert($sql);
            }

            // 6. Lavado
            $id_sub_lavado = $_POST['id_sub_lavado'] ?? '';
            $estadoTanque = $_POST['estadoTanque'] ?? '';
            $porcAgua = $_POST['porcAgua'] ?? '';
            $fecha_lavado = $_POST['fecha_lavado'] ?? '';
            $obser_lavado = $_POST['obser_lavado'] ?? '';

            if (!empty($id_sub_lavado)) {
                $sql = "UPDATE sub_actividades 
                        SET estado_tanque = '$estadoTanque', 
                            agua_cambiada = " . ($porcAgua !== '' ? $porcAgua : 0) . ", 
                            fecha_lavado = '$fecha_lavado', 
                            obser_lavado = '$obser_lavado',
                            cod_seguimiento = '$cod_seguimiento'
                        WHERE id_sub_actividad = $id_sub_lavado";
                $obj->update($sql);
            } elseif (!empty($fecha_lavado) || !empty($obser_lavado) || !empty($estadoTanque)) {
                $porcAguaVal = $porcAgua !== '' ? $porcAgua : 0;
                $sql = "INSERT INTO sub_actividades 
                        (estado_tanque, agua_cambiada, fecha_lavado, obser_lavado, id_estado, id_seguimiento_zoo, cod_seguimiento)
                        VALUES ('$estadoTanque', $porcAguaVal, '$fecha_lavado', '$obser_lavado', $id_estado, $id_seguimiento_zoo, '$cod_seguimiento')";
                $obj->insert($sql);
            }

            $_SESSION['mensaje_exito'] = "El registro se actualizó correctamente.";
            redirect(getUrl("Historial", "Historial", "getConsultar"));
        }
    }
}

?>