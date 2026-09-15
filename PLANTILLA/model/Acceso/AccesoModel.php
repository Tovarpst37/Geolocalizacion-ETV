<?php
    include_once '../model/MasterModel.php';

    class AccesoModel extends MasterModel{
        public function buscarPorDocumento($documento) {
            $sql = "SELECT * FROM usuarios WHERE documento = $1 LIMIT 1";
            $result = pg_query_params($this->getConnect(), $sql, [$documento]);

            if ($result === false) {
                error_log("Error en consulta buscarPorDocumento: " . pg_last_error($this->getConnect()));
                return null;
            }

            $usuario = pg_fetch_assoc($result);

            return $usuario ?: null;
        }
    }
?>