<?php

    include_once '../model/SeguimientoTerreno/SeguimientoTerrenoModel.php';



    class SeguimientoTerrenoController{




    public function getConsultar(){

     $obj = new SeguimientoTerrenoModel();
    
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
            WHERE r.nombre_rol IN ('Auxiliar Terreno', 'Coordinador Terreno')
            GROUP BY 
                s.id_seguimiento_terreno, 
                s.cod_seguimiento, 
                s.fecha, 
                s.hora_inicio, 
                s.hora_fin, 
                s.id_estado, 
                si.nombre_sitio,
                sd.codigo_sitio_deposito,
                u.primer_nombre, 
                u.primer_apellido
            ORDER BY s.id_seguimiento_terreno";

    $seguimientos = $obj->select($sql);

    
        $sql2 = "UPDATE seguimiento_terreno
                SET id_estado = 2 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado = 1";

        $ejecutar = $obj->update($sql2);
        
    
    if(count($seguimientos) <= 0){
        include_once '../view/partials/SeguimientoTerreno/notExist.php';
    }else{
        include_once '../view/partials/SeguimientoTerreno/Consultar.php';
    }
    


    }


    public function getRegistrar(){

        $obj = new SeguimientoTerrenoModel();
        $sql = "SELECT * from sitio";
        $sitio = $obj->select($sql);

        $sql2 = "SELECT * from estado";
        $estados = $obj->select($sql2);

        $sql3 = "SELECT * from actividad_terreno";
        $actividades = $obj->select($sql3);
        
        include_once '../view/partials/SeguimientoTerreno/Registrar.php';

    }


    public function postRegistrar(){

    $obj = new SeguimientoTerrenoModel();

    $codigo = mb_strtoupper($_POST['nombre_seguimiento']) ?? '';
    $sitio = $_POST['select_ter'] ?? '';
    $estado = $_POST['id_estado'];
    $usuario = $_POST['selectUsuarios'] ?? '';
    $terreno = $_POST['selectTerreno'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $actividades = $_POST['actividades'] ?? [];
    

    $sql_validar = "SELECT id_seguimiento_terreno FROM seguimiento_terreno WHERE cod_seguimiento = $1 ";
    $existe = $obj->select($sql_validar,[$codigo]);


     $errores = [];
    list($hora_inicio, $hora_fin) = explode('-', $horario);


    

        if(!empty($existe)){
            $errores[] = "Ya existe un seguimiento con ese código";
            
        } 
        if (empty($codigo)) {
            $errores[] = "Debe ingresar el codigo del seguimiento";
        }
        if (empty($sitio)) {
            $errores[] = "Debe seleccionar el Sitio.";
        }
        if (empty($estado)) {
            $errores[] = "Debe seleccionar el estado del seguimiento.";
        }
        if (empty($usuario)) {
            $errores[] = "Debe seleccionar el Auxiliar asignado.";
        }
        if (empty($terreno)) {
            $errores[] = "Debe seleccionar el terreno al que se le hara el seguimiento.";
        }
        if (empty($horario)) {
            $errores[] = "Debe seleccionar el horario.";
        }
        
        



        if (!empty($errores)) {
           

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('SeguimientoTerreno', 'SeguimientoTerreno', 'getRegistrar'));

            return;
        }else{ 

   
            $sql = "INSERT INTO seguimiento_terreno  (fecha, id_usuario, id_sitio,  id_estado, hora_inicio, hora_fin,cod_seguimiento)
                    VALUES ( CURRENT_DATE, $1,$2,$3,$4,$5,$6)
                    RETURNING id_seguimiento_terreno";

            $resultado = $obj->select($sql,[$usuario, $sitio,  $estado, $hora_inicio, $hora_fin,$codigo]); 

             
            
            if($resultado){
                $id_seguimiento = $resultado[0]['id_seguimiento_terreno'];


                foreach($actividades as $id_actividad){
                    $sql2 = "INSERT INTO actividad_seg_terreno (id_actividad_terreno, id_seguimiento_terreno) 
                            VALUES ('$id_seguimiento', '$id_actividad')";
                    $obj->insert($sql2);
                }

                $_SESSION['mensaje_exito'] = "El Seguimiento de Terreno se registro correctamente.";
                $sql2 = "UPDATE seguimiento_terreno 
                        SET id_estado = 2 
                        WHERE fecha = CURRENT_DATE 
                        AND hora_fin < LOCALTIME 
                        AND id_estado = 1";

                $ejecutar2 = $obj->update($sql2);
                redirect(getUrl("SeguimientoTerreno","SeguimientoTerreno","getConsultar"));
            } else {
                echo "No se pudo registrar el seguimiento";
    }
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

        $sql3 = "SELECT * from estado";
            $estados = $obj->select($sql3);

            $sql4 = "SELECT * from actividad_terreno";
        $actividades = $obj->select($sql4);

        

        $sql4 = "SELECT id_actividad_terreno from actividad_seg_terreno WHERE id_seguimiento_terreno = $1";
        $actividadesSelect = $obj->select($sql4,[$id]);


        include_once '../view/partials/SeguimientoTerreno/Editar.php';

    }

    public function postUpdate(){

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
                SET id_estado = 2 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado = 1";

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
        };

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
                $sql = "UPDATE seguimiento_Terreno SET id_estado = 2 WHERE id_seguimiento_terreno = $id";

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

public function getBuscar(){


    $busqueda = mb_strtoupper($_GET['busqueda'] ?? '');
    if(!empty($busqueda)){
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
}else{
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
                SET id_estado = 2 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado = 1";

        $ejecutar = $obj->update($sql2);
        

        include_once '../view/partials/SeguimientoTerreno/consultar.php';
}

}




public function getSitios(){
    $id_sitio = $_GET['id_sitio'];
    
    $obj = new SeguimientoTerrenoModel();
    
    $sql = "SELECT id_sitio_deposito, nombre from sitio_deposito WHERE id_sitio = $1";
    $terreno = $obj->select($sql,[$id_sitio]);
    
    $sql2 = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido FROM usuarios WHERE id_sitio = $1";
    $usuarios = $obj->select($sql2,[$id_sitio]);
    
    $resultado = [
        'terreno' => $terreno,
        'usuarios' => $usuarios
    ];
    
    header('Content-Type: application/json');
    echo json_encode($resultado);
}

    


    
    }

?>