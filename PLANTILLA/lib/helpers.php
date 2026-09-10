<?php


function resolve()
{
    $modulo = ucwords($_GET['modulo']); //Carpeta ej: Usuarios
    $controlador = ucwords($_GET['controlador']); //Archivo ej: UsuarioController.php
    $funcion = $_GET['funcion']; //Metodo en la clase: getUsers

    //if_dir, si es una carpeta
    if (is_dir("../controller/$modulo")) {
        if (is_file("../controller/$modulo/" . $controlador . "Controller.php")) {

            include_once "../controller/$modulo/" . $controlador . "Controller.php";
            $nombreClase = $controlador . "Controller";

            $objeto = new $nombreClase();
            //$objeto = new UsuarioController();

            if (method_exists($objeto, $funcion)) {
                $objeto->$funcion();
            } else {
                echo "El metodo $funcion no existe en el controlador $controlador";
            }
        } else {
            echo "El controlador $controlador no existe en el modulo $modulo";
        }
    } else {
        echo "El modulo $modulo no existe";
    }
}
