<?php

include_once '../model/Historial/HistorialModel.php';


class HistorialController
{
    public function getConsultar()
    {

        $obj = new HistorialModel(); // O la clase de tu modelo correspondiente

        $sql = "SELECT s.id_seguimiento_zoo, s.cod_seguimiento, s.fecha, u.documento, s.id_estado, 
                       sub.tipo_alimento, sub.genero, sub.observaciones
                FROM seguimiento_zoocriadero s
                LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
                LEFT JOIN sub_actividades sub ON s.id_seguimiento_zoo = sub.id_seguimiento_zoo";

        $seguimientos = $obj->select($sql);

        include_once '../view/partials/Historial/Consultar.php';
    }

    public function getEditar()
    {
        $id = $_GET['id'] ?? null;
        $obj = new HistorialModel();

        // Consulta para obtener el seguimiento y sus detalles de alimentación
        $sql = "SELECT s.id_seguimiento_zoo, s.cod_seguimiento, s.fecha, s.id_estado,
                   sub.id_sub_actividad, sub.tipo_alimento, sub.genero AS tipo_pez, sub.observaciones
            FROM seguimiento_zoocriadero s
            LEFT JOIN sub_actividades sub ON s.id_seguimiento_zoo = sub.id_seguimiento_zoo
            WHERE s.id_seguimiento_zoo = '$id'";

        $datos = $obj->select($sql);

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

        // 1. Recibir los datos enviados desde el formulario modal
        $id_seguimiento_zoo = $_POST['id_seguimiento_zoo'] ?? null;
        $id_sub_actividad   = $_POST['id_sub_actividad'] ?? null;
        
        $cod_seguimiento    = $_POST['cod_seguimiento'] ?? '';
        $fecha              = $_POST['fecha'] ?? '';
        $tipo_pez           = $_POST['tipo_pez'] ?? '';
        $tipo_alimen        = $_POST['tipo_alimen'] ?? '';
        $observaciones      = $_POST['observaciones'] ?? '';
        $id_estado          = $_POST['id_estado'] ?? 1;

        if ($id_seguimiento_zoo) {
            // 2. Actualizar los datos del seguimiento principal
            $sqlSeg = "UPDATE seguimiento_zoocriadero 
                       SET cod_seguimiento = '$cod_seguimiento', 
                           fecha = '$fecha', 
                           id_estado = $id_estado 
                       WHERE id_seguimiento_zoo = $id_seguimiento_zoo";
            
            $obj->update($sqlSeg);

            // 3. Actualizar la subactividad asociada (si existe)
            if (!empty($id_sub_actividad)) {
                $sqlSub = "UPDATE sub_actividades 
                           SET tipo_alimento = '$tipo_alimen', 
                               genero = '$tipo_pez', 
                               observaciones = '$observaciones', 
                               cod_seguimiento = '$cod_seguimiento',
                               fecha = '$fecha' 
                           WHERE id_sub_actividad = $id_sub_actividad";
                
                $obj->update($sqlSub);
            } else {
                // Si por alguna razón no tenía una subactividad previa, la insertamos
                $sqlSubInsert = "INSERT INTO sub_actividades 
                                 (tipo_alimento, fecha, genero, observaciones, id_estado, id_seguimiento_zoo, cod_seguimiento, 
                                  can_peces_mertos_hembra, can_peces_mertos_macho, can_peces_nacido, estregar_paredes, 
                                  aspirar, succionador, adicion_nivel_agua, medicion_ph, medicion_temperatura, estado_tanque, agua_cambiada) 
                                 VALUES 
                                 ('$tipo_alimen', '$fecha', '$tipo_pez', '$observaciones', $id_estado, $id_seguimiento_zoo, '$cod_seguimiento', 
                                  0, 0, 0, false, false, false, 0, 0, 0, 'Bueno', 0)";
                
                $obj->insert($sqlSubInsert);
            }

            // Mensaje opcional de éxito en sesión
            $_SESSION['mensaje_exito'] = "El registro se actualizó correctamente.";

            // Redireccionar a la vista de consulta
            redirect(getUrl("Historial", "Historial", "getConsultar"));
        } else {
            echo "Error: No se proporcionó el ID del seguimiento.";
        }
    }
}

}

?>