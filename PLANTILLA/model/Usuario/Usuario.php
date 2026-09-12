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
        
    }
?>