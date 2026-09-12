


<div class = "container-fluid text-center px-2">
  
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">


<div class="d-flex justify-content-end w-100">
    <div class="input-group" style="max-width: 350px;">
<form class="input-group" action="index.php" method="GET">
    <input type="hidden" name="modulo" value="Tanque">
    <input type="hidden" name="controlador" value="Tanque">
    <input type="hidden" name="funcion" value="getBuscar">
    
    <input type="text" name="busqueda" placeholder="Search ..." class="form-control " value = "<?php $busqueda ?>" />
    
    <button type="submit" class="btn btn-outline-secondary">
        <i class="fa fa-search"></i>
    </button>
</form>
</div>
</div>


<?php


  include_once '../controller/Tanque/TanqueController.php';
  include_once '../model/Tanque/Tanque.php';
  $array = [];

  foreach($tanque2 as $rs){

    $obj = new Tanque($rs['id_tanque'],$rs['codigo_tanque'],$rs['img'],$rs['nombre_tipo_tanque'],$rs['cod_zoocriadero'],$rs['direcciom'],$rs['nombre_estado']);
    
    $array[] = $obj;

  }

  foreach($array as $ob){
    echo $ob->getCard($ob->getId());
    

  }
  ?>
</div>
</div>
