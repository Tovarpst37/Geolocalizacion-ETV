<?php
    include_once '../model/TipoDeDeposito/TipoDeDepositoModel.php';

    class TipoDeDepositoController{


        public function getRegistrar(){
            include_once '../view/partials/TipoDeDeposito/Registrar.php';
        }


        public function postRegistrar(){

        $obj = new TipoDeDepositoModel();
        
            $nombre = mb_strtoupper($_POST['nombre'] ?? '');

            $sql_validar = "SELECT id_tipo_deposito FROM tipo_de_deposito WHERE nombre = '$nombre'";
            $existe = $obj->select($sql_validar);


            $errores = [];

        if(!empty($existe)){
            $errores[] = "Ya existe un deposito con el mismo nombre";
            
        } 
        if (empty($nombre)) {
            $errores[] = "Debe ingresar el codigo del seguimiento";
        }


        if (!empty($errores)) {
           

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('TipoDeDeposito', 'TipoDeDeposito', 'getRegistrar'));

            return;
        }else{ 

        
            $sql = "INSERT into tipo_de_deposito (nombre) VALUES ($1)";
            $ejecutar = $obj->insert($sql,[$nombre]);

                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "El tipo de deposito se registro con exito.";
                    redirect(getUrl("TipoDeDeposito", "TipoDeDeposito", "getConsultar"));
                } else {
                    echo "No se pudo registrar el tipo de deposito correctamente";
                }

        }
    }


    public function getConsultar(){

        $obj = new TipoDeDepositoModel();

        $sql =  "SELECT * from tipo_de_deposito ORDER BY id_tipo_deposito";
        $tipos = $obj->select($sql);


        include_once '../view/partials/TipoDeDeposito/Consultar.php';

    }

    public function getEditar(){

        $id = $_GET['id'];
        $obj = new TipoDeDepositoModel();
        $sql = "SELECT * from tipo_de_deposito WHERE id_tipo_deposito = $1";
        $datos = $obj->select($sql,[$id]);

        include_once '../view/partials/TipoDeDeposito/Editar.php';

    }


    public function postUpdate(){

    $obj = new TipoDeDepositoModel();
        $id = $_POST['id'];
        $nombre  = mb_strtoupper($_POST['nombre']);

            $sql_validar = "SELECT id_tipo_deposito FROM tipo_de_deposito WHERE nombre = '$nombre'";
            $existe = $obj->select($sql_validar);


            $errores = [];

        if(!empty($existe)){
            $errores[] = "Ya existe un deposito con el mismo nombre";
            
        } 
        if (empty($nombre)) {
            $errores[] = "Debe ingresar el nombre del deposito";
        }

        if (!empty($errores)) {
           

            include_once '../model/Errores/ErrorModal.php';
            ErrorModal::verError($errores, getUrl('TipoDeDeposito', 'TipoDeDeposito', 'getRegistrar'));

            return;
        }else{ 

        $sql = "UPDATE tipo_de_deposito SET nombre = '$nombre' WHERE id_tipo_deposito = $1";
        $ejecutar = $obj->update($sql,[$id]);

                if ($ejecutar) {
                    $_SESSION['mensaje_exito'] = "El tipo de deposito de actualizo con exito.";
                    redirect(getUrl("TipoDeDeposito", "TipoDeDeposito", "getConsultar"));
                } else {
                    echo "No se pudo actualizar el tipo de deposito correctamente";
                }
        }

    }

    public function getBuscar(){
    $busqueda = mb_strtoupper($_GET['busqueda'] ?? '');

    if(!empty($busqueda)){
    $obj = new TipoDeDepositoModel();
    
    $palabra = $_GET['busqueda'];
     $sql = "SELECT * FROM tipo_de_deposito t WHERE t.nombre ILIKE $1";
    $tipos = $obj->select($sql, ['%' . $busqueda . '%']);;

    include_once '../view/partials/TipoDeDeposito/Buscar.php';
    }else{
        $obj = new TipoDeDepositoModel();

        $sql =  "SELECT * from tipo_de_deposito";
        $tipos = $obj->select($sql);


        include_once '../view/partials/TipoDeDeposito/Consultar.php';
    }
    }
    }

?>