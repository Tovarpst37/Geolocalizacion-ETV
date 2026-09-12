<?php

include_once '../model/FormularioM/FormulariosModel.php';
class FormularioMController
{

    public function getRegistrar()
    {
        $obj = new FormulariosModel();


        include_once '../view/partials/FormularioM/registrar.php';
    }
}

?>