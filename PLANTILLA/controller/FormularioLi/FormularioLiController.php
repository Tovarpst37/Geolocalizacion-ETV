<?php

include_once '../model/FormularioLi/FormulariosModel.php';
class FormularioLiController
{

    public function getRegistrar()
    {
        $obj = new FormulariosModel();


        include_once '../view/partials/FormularioLi/registrar.php';
    }
}

?>