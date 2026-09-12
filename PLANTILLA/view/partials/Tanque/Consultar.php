<?php if (!empty($_SESSION['mensaje_exito'])): ?>
  <div id="alertaExito" class="alert d-flex align-items-center border-0 shadow-sm" role="alert" style="border-left: 5px solid #198754 !important; background-color: #fff;">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" style="color:#198754;" role="img" aria-label="Success:">
      <use xlink:href="#check-circle-fill" />
    </svg>
    <div>
      <?php echo $_SESSION['mensaje_exito']; ?>
    </div>
  </div>
  <?php unset($_SESSION['mensaje_exito']); ?>

  <script>
    setTimeout(function() {
      var alerta = document.getElementById('alertaExito');
      if (alerta) {
        alerta.style.transition = "opacity 0.5s ease";
        alerta.style.opacity = "0";
        setTimeout(function() {
          alerta.remove();
        }, 500); // espera a que termine el fade antes de quitarlo del DOM
      }
    }, 5000); // 5 segundos visible
  </script>
<?php endif; ?>


 <div class = "container-fluid text-center px-2">
  
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
<?php


  include_once '../controller/Tanque/TanqueController.php';
  include_once '../model/Tanque/Tanque.php';

  

?>


<div class="d-flex justify-content-end w-100">
    <div class="input-group" style="max-width: 350px;">
<form class="input-group" action="index.php" method="GET">
    <input type="hidden" name="modulo" value="Tanque">
    <input type="hidden" name="controlador" value="Tanque">
    <input type="hidden" name="funcion" value="getBuscar">
    
    <input type="text" name="busqueda" placeholder="Search ..." class="form-control" />
    
    <button type="submit" class="btn btn-outline-secondary">
        <i class="fa fa-search"></i>
    </button>
</form>
</div>
</div>


<?php

  $array = [];

  $obj2 = new TanqueController();
  $result = $obj2 -> getDatos();


  foreach($result as $rs){

    $obj = new Tanque($rs['id_tanque'],$rs['codigo_tanque'],$rs['img'],$rs['nombre_tipo_tanque'],$rs['cod_zoocriadero'],$rs['direcciom'],$rs['nombre_estado']);
    
    $array[] = $obj;

  }

  foreach($array as $ob){
    echo $ob->getCard($ob->getId());

  }

  ?>
</div>
</div>
