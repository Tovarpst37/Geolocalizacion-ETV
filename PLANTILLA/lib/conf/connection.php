<?php

    class Connection{
        private $host;
        private $user;
        private $password;
        private $database;
        private $port;
        private $link;

        function __construct(){
            $this->setConnect();
            $this->connect();
        }


        private function setConnect(){

            require_once 'conf.php';

            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->database = $database;
            $this->port = $port;
        }

        private function connect(){
            $this->link = pg_connect("host={$this->host} port={$this->port} dbname={$this->database} user={$this->user} password={$this->password}");

            if(!$this->link){
                 $error = error_get_last();
                    die("Error de conexión: " . ($error['message'] ?? 'Error desconocido al conectar'));

            }
        }

        protected function getConnect(){
            return $this->link;
        }

        
        protected function close(){
            pg_close( $this->link);
        
        }
    }

?>