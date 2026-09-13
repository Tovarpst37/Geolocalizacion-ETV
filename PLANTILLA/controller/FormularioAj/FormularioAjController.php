<?php

include_once '../model/FormularioAj/FormulariosModel.php';
class FormularioAjController
{

    public function getRegistrar()
    {
        $obj = new FormulariosModel();


        include_once '../view/partials/FormularioAj/registrar.php';
    }
}

?>