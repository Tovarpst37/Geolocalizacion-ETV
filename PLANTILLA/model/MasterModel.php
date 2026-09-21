<?php

    include_once __DIR__ . '/../lib/conf/connection.php';

    class MasterModel extends Connection{
        public function insert($sql,$params = []){
            $result = pg_query_params($this->getConnect(),$sql,$params);

            return $result;
        }
        public function select($sql,$params = []){
            $result = pg_query_params($this->getConnect(),$sql,$params);

            return pg_fetch_all($result);
        }
        
        public function update($sql,$params = []){
            $result = pg_query_params($this->getConnect(),$sql,$params);

            return $result;
        }
        
        public function delete($sql,$params = []){
            $result = pg_query_params($this->getConnect(),$sql,$params);

            return $result;
        }

        public function exists($sql,$valor) {
            $result = pg_query_params($this->getConnect(), $sql, [$valor]);
    
            if (!$result) {
                return false; 
            }
    
            return pg_fetch_result($result, 0, 0) === 't';
        }

        public function autoincrement($table,$field){
            $sql = "SELECT MAX($field) FROM $table";
            $result = pg_query($this->getConnect(),$sql);
            $max_id = pg_fetch_array($result);
            return $max_id[0]+1;
        }

    }

    

?>