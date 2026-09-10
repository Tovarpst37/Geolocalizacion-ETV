<div class = "container-fluid text-center px-2">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
<?php


  include_once '../controller/Tanque/TanqueController.php';

  $array = [];

  $obj2 = new TanqueController();
  $result = $obj2 -> getDatos();


  foreach($result as $rs){

    $obj = new TanqueController();
    

      $obj -> setId($rs['id_tanque']);

      $obj -> setDireccion($rs['direcciom']);

      $obj -> setEstado($rs['nombre_estado']);

      $obj -> setTipo($rs['nombre_tipo_tanque']);

      $obj -> setImg($rs['img']);

      $obj -> setZoocriadero($rs['cod_zoocriadero']);

      $obj -> setNombre($rs['codigo_tanque']);
      

    
    $array[] = $obj;

  }

  foreach($array as $sr){
    echo $sr->getCard();

  }

  ?>
</div>
</div>
