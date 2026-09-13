<?php

include_once '../model/FormularioLa/FormulariosModel.php';
class FormularioLaController
{

    public function getRegistrar()
    {
        $obj = new FormulariosModel();


        include_once '../view/partials/FormularioLa/registrar.php';
    }
}

?>