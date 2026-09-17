<?php

    include_once '../model/SeguimientoZoocriadero/SeguimientoZoocriaderoModel';


    class SeguimientoZoocriaderoController{




    public function getConsultar(){

     $obj = new SeguimientoZoocriaderoModel();
    
     $sql = "SELECT 
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
                                            AND az.id_estado = 1          -- Solo actividades activas
            GROUP BY s.id_seguimiento_zoo, s.cod_seguimiento, s.fecha, s.hora_inicio, s.hora_fin, s.id_estado, 
                    z.cod_zoocriadero, t.codigo_tanque, u.primer_nombre, u.primer_apellido
            ORDER BY s.id_seguimiento_zoo";

    $seguimientos = $obj->select($sql);

    
        $sql2 = "UPDATE seguimiento_zoocriadero 
                SET id_estado = 2 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado = 1";

        $ejecutar = $obj->update($sql2);
        
    
    if(count($seguimientos) <= 0){
        include_once '../view/partials/SeguimientoZoocriadero/notExist.php';
    }else{
        include_once '../view/partials/SeguimientoZoocriadero/Consultar.php';
    }
    


    }


    public function getRegistrar(){

        $obj = new SeguimientoZoocriaderoModel();
        $sql = "SELECT * from zoocriadero";
        $zoocriaderos = $obj->select($sql);

        $sql3 = "SELECT MAX(id_seguimiento_zoo) FROM seguimiento_zoocriadero";
        $id_seg = $obj->select($sql3);
        
        $sql2 = "SELECT * from estado";
        $estados = $obj->select($sql2);

        $sql3 = "SELECT * from actividad_zoocriadero WHERE id_estado = 1";
        $actividades = $obj->select($sql3);
        
        include_once '../view/partials/SeguimientoZoocriadero/Registrar.php';

    }


    public function postRegistrar(){

    $obj = new SeguimientoZoocriaderoModel();

    $codigo = mb_strtoupper($_POST['codigo_Seguimiento']) ?? '';
    $zoo = $_POST['select_zoo'] ?? '';
    $estado = $_POST['id_estado'];
    $usuario = $_POST['selectUsuarios'] ?? '';
    $tanque = $_POST['selectTanques'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $actividades = $_POST['actividades'] ?? [];
    $sql_validar = "SELECT id_seguimiento_zoo FROM seguimiento_zoocriadero WHERE cod_seguimiento = $1 ";
    $existe = $obj->select($sql_validar,[$codigo]);


     $errores = [];
    list($hora_inicio, $hora_fin) = explode('-', $horario);


    

        if(!empty($existe)){
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
        if (empty($horario)) {
            $errores[] = "Debe seleccionar el horario.";
        }
        
        



        if (!empty($errores)) {
           

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('SeguimientoZoocriadero', 'SeguimientoZoocriadero', 'getRegistrar'));

            return;
        }else{ 

   
            $sql = "INSERT INTO seguimiento_zoocriadero (cod_seguimiento, fecha, id_tanque, id_usuario, id_estado, hora_inicio, hora_fin)
                    VALUES ('$codigo', CURRENT_DATE, '$tanque', '$usuario', '$estado', '$hora_inicio', '$hora_fin')
                    RETURNING id_seguimiento_zoo";

            $resultado = $obj->select($sql); 

             
            
            if($resultado){
                $id_seguimiento = $resultado[0]['id_seguimiento_zoo'];


                foreach($actividades as $id_actividad){
                    $sql2 = "INSERT INTO actividad_seg_zoo (id_seguimiento_zoo, id_actividad_zoo) 
                            VALUES ('$id_seguimiento', '$id_actividad')";
                    $obj->insert($sql2);
                }

                $_SESSION['mensaje_exito'] = "El Seguimiento de Zoocriadero se registro correctamente.";
                $sql2 = "UPDATE seguimiento_zoocriadero 
                        SET id_estado = 2 
                        WHERE fecha = CURRENT_DATE 
                        AND hora_fin < LOCALTIME 
                        AND id_estado = 1";

                $ejecutar2 = $obj->update($sql2);
                redirect(getUrl("SeguimientoZoocriadero","SeguimientoZoocriadero","getConsultar"));
            } else {
                echo "No se pudo registrar el seguimiento";
    }
        }

}


public function getEditar()
    {
        $id = $_GET['id'];
        $obj = new SeguimientoZoocriaderoModel();

        $sql = "SELECT id_seguimiento_zoo, fecha, hora_inicio, hora_fin, id_estado, id_tanque, id_usuario
                FROM seguimiento_zoocriadero
                WHERE id_seguimiento_zoo = '$id'";
        $datos = $obj->select($sql);

        $sql3 = "SELECT * from estado";
            $estados = $obj->select($sql3);

            $sql4 = "SELECT * from actividad_zoocriadero WHERE id_estado = 1";
        $actividades = $obj->select($sql4);

        

        $sql4 = "SELECT id_actividad_zoo from actividad_seg_zoo WHERE id_seguimiento_zoo = $1";
        $actividadesSelect = $obj->select($sql4,[$id]);


        include_once '../view/partials/SeguimientoZoocriadero/Editar.php';

    }

    public function postUpdate(){

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
                SET id_estado = 2 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado = 1";

        $ejecutar2 = $obj->update($sql2);

        if ($ejecutar) {
            $_SESSION['mensaje_exito'] = "El Seguimiento de zoocriadero se actualizó correctamente.";
            $sql2 = "UPDATE seguimiento_zoocriadero 
                SET id_estado = 2 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado = 1";

        $ejecutar = $obj->update($sql2);

            
            redirect(getUrl("SeguimientoZoocriadero", "SeguimientoZoocriadero", "getConsultar"));
        } else {
            echo "No se pudo actualizar el seguimiento";
        };

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
                $sql = "UPDATE seguimiento_zoocriadero SET id_estado = 2 WHERE id_seguimiento_zoo = $id";

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

public function getBuscar(){


    $busqueda = mb_strtoupper($_GET['busqueda'] ?? '');
    if(!empty($busqueda)){
    $obj = new SeguimientoZoocriaderoModel();
    
    $palabra = $_GET['busqueda'];
     $sql = "SELECT 
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
        WHERE s.cod_seguimiento ILIKE $1
        GROUP BY s.id_seguimiento_zoo, s.cod_seguimiento, s.fecha, s.hora_inicio, s.hora_fin, s.id_estado, 
                z.cod_zoocriadero, t.codigo_tanque, u.primer_nombre, u.primer_apellido
        ORDER BY s.id_seguimiento_zoo";

            

    $seguimientos = $obj->select($sql, ['%' . $busqueda . '%']);

    include_once '../view/partials/SeguimientoZoocriadero/Buscar.php';
}else{
    $obj = new SeguimientoZoocriaderoModel();
    
     $sql = "SELECT 
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
        GROUP BY s.id_seguimiento_zoo, s.cod_seguimiento, s.fecha, s.hora_inicio, s.hora_fin, s.id_estado, 
                z.cod_zoocriadero, t.codigo_tanque, u.primer_nombre, u.primer_apellido
        ORDER BY s.id_seguimiento_zoo";

    $seguimientos = $obj->select($sql);

    
        $sql2 = "UPDATE seguimiento_zoocriadero 
                SET id_estado = 2 
                WHERE fecha = CURRENT_DATE 
                AND hora_fin < LOCALTIME 
                AND id_estado = 1";

        $ejecutar = $obj->update($sql2);
        

        include_once '../view/partials/SeguimientoZoocriadero/notExist.php';
}

}




public function getTanquesPorZoo(){
    $id_zoocriadero = $_GET['id_zoocriadero'];
    
    $obj = new SeguimientoZoocriaderoModel();
    
    $sql = "SELECT id_tanque, codigo_tanque FROM tanque WHERE id_zoocriadero = '$id_zoocriadero'";
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

?>