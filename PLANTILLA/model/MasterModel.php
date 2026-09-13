<?php

    include_once '../lib/conf/connection.php';

    class MasterModel extends Connection{
        public function insert($sql){
            $result = pg_query($this->getConnect(),$sql);

            return $result;
        }
        public function select($sql){
            $result = pg_query($this->getConnect(),$sql);

            return pg_fetch_all($result);
        }
        
        public function update($sql){
            $result = pg_query($this->getConnect(),$sql);

            return $result;
        }
        
        public function delete($sql){
            $result = pg_query($this->getConnect(),$sql);

            return $result;
        }

        public function autoincrement($table,$field){
            $sql = "SELECT MAX($field) FROM $table";
            $result = pg_query($this->getConnect(),$sql);
            $max_id = pg_fetch_array($result);
            return $max_id[0]+1;
        }
    }

    

?>