<?php
    class Usuario{

        private int $id_usuario;
        private string $primer_nombre;
        private string $segundo_nombre;
        private string $primer_apellido;
        private string $segundo_apellido;
        private string $documento;
        private DateTime $fecha_nacimiento;
        private string $correo;
        private string $hash;
        private int $id_genero;
        private int $id_rol;
        private int $id_estado;
        private int $id_rh;

        public function __construct(int $id_usuario,
        String $primer_nombre,String $segundo_nombre,String $primer_apellido,
        String $segundo_apellido,String $documento,DateTime $fecha_nacimiento,
        String $correo,String $hash,int $id_genero,int $id_rol,int $id_estado,
        int $id_rh){
            this->$id_usuario = $id_usuario;
            this->$primer_nombre = $primer_nombre;
            this->$segundo_nombre = $segundo_nombre;
            this->$primer_apellido = $primer_apellido;
            this->$segundo_apellido = $segundo_apellido;
            this->$documento = $documento;
            this->$fecha_nacimiento = $fecha_nacimiento;
            this->$correo = $correo;
            this->$hash = $hash;
            this->$id_genero = $id_genero;
            this->$rol = $rol;
            this>$id_estado = $id_estado;
            this->$id_rh = $id_rh;
        }
        
        public function setId_usuario(int $id_usuario){
            this->$id_usuario = $id_usuario;
        }

        public function getId_usuario(){
            return $id_usuario;
        }

        public function setPrimer_nombre(String $primer_nombre){
            this->$primer_nombre = $primer_nombre;
        }

        public function getPrimer_nombre(){
            return $primer_nombre;
        }

        public function setSegundo_nombre(String $segundo_nombre){
            this->$segundo_nombre = $segundo_nombre;
        }

        public function getSegundo_nombre(){
            return $segundo_nombre;
        }

        public function setPrimer_apellido(String $primer_apellido){
            this->$primer_apellido = $primer_apellido;
        }

        public function getPrimer_apellido(){
            return $primer_apellido;
        }

        public function setSegundo_apellido(String $segundo_apellido){
            this->$segundo_apellido = $segundo_apellido;
        }

        public function getSegundo_apellido(){
            return $segundo_apellido;
        }

        public function setDocumento(String $documento){
            this->$documento = $documento;
        }

        public function getDocumento(){
            return $documento;
        }
        
        public function setFecha_nacimiento(DateTime $fecha_nacimiento){
            this->$fecha_nacimiento = $fecha_nacimiento;
        }

        public function getFecha_nacimiento(){
            return $fecha_nacimiento;
        }

        public function setCorreo(String $correo){
            this->$correo = $correo;
        }

        public function getCorreo(){
            return $correo;
        }

        public function setHash(String $hash){
            this->$hash = $hash;
        }

        public function getHash(){
            return $hash;
        }

        public function setId_genero(int $id_genero){
            this->$id_genero = $id_genero;
        }

        public function getId_genero(){
            return $id_genero;
        }

        public function setId_rol(int $id_rol){
            this->$id_rol = $id_rol
        }

        public function getId_rol(){
            return $id_rol;
        }

        public function setId_estado(int $id_estado){
            this->$id_estado = $id_estado;
        }

        public function getId_estado(){
            return $id_estado;
        }

        public function setId_rh(int $id_rh){
            this->$id_rh = $id_rh;
        }

        public function getId_rh(){
            return $id_rh;
        }

    }
?>