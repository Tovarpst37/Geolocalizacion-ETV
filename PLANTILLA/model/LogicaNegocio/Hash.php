<?php

    class Hash{

    public static function encripHash(String $contrasena){
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        return $hash;
    }

    public static function validarHash(String $contrasena,$hash){
        $veri = password_verify($contrasena,$hash);
        return $veri;
    }

    }

?>