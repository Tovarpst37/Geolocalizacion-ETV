<?php

include_once '../model/FormularioZ/FormulariosModel.php';
class FormularioZController
{

    public function getRegistrar()
    {
        $obj = new FormulariosModel();


        include_once '../view/partials/Formularioz/registrar.php';
    }
}

?>