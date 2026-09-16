
<?php



  $obj2 = new ActividadZoocriaderoController();
  $result = $obj2 -> getDatos();

  if(count($result) <= 0){
    include_once '../view/partials/ActividadZoocriadero/notExist.php';
  }else{ 
?>
  <div class = "container-fluid text-center px-2">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
  <?php
  include_once '../controller/ActividadZoocriadero/ActividadZoocriaderoController.php';
  include_once '../model/ActividadZoocriadero/ActividadZoocriadero.php';

  $array = [];


  foreach($result as $rs){

    $obj = new ActividadZoocriadero($rs['id_actividad_zoo'],$rs['cod_actividad'],$rs['nombre_actividad'],$rs['nombre_estado']);
    
    $array[] = $obj;

  }

  foreach($array as $o){
    echo $o->getCard();

  }
  }

  ?>
</div>
</div>
