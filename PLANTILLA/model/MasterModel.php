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
    }

    

?>