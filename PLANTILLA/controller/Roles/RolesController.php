<?php
    include_once '../model/Roles/RolesModel.php';
    
        class RolesController{

            public function getCreate(){
                $obj = new RolesModel();
                $sql = "SELECT * FROM modulos";
                $modulos = $obj->select($sql);
                include_once '../view/Roles/create.php';
            }

            public function postCreate(){
                echo "Hola";
            }
            
        }
?>