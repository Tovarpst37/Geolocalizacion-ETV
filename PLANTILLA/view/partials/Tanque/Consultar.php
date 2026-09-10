<div class = "container-fluid text-center px-2">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
<?php


  include_once '../controller/Tanque/TanqueController.php';
  include_once '../model/Tanque/Tanque.php';

  $array = [];

  $obj2 = new TanqueController();
  $result = $obj2 -> getDatos();


  foreach($result as $rs){

    $obj = new Tanque($rs['id_tanque'],$rs['codigo_tanque'],$rs['img'],$rs['nombre_tipo_tanque'],$rs['cod_zoocriadero'],$rs['direcciom'],$rs['nombre_estado']);
    
    $array[] = $obj;

  }

  foreach($array as $sr){
    echo $sr->getCard();

  }

  ?>
</div>
</div>
