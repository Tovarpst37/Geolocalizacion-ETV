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
  $badgeClass = strtolower($ob->getEstado()) === 'activo' ? 'bg-success' : 'bg-danger';

  $id = $ob -> getId();

     

    ?>

        
                <div class = "col">
                
                    <div class="card p-3 h-100" style="width: 100% !important; min-width: 0 !important; d-flex justify-content-center">
        <img src="/Geolocalizacion/Geolocalizacion-ETV/PLANTILLA/web/assets/img/<?php echo $ob->getImg();?>"
            style="width: 15rem; height: 12rem; object-fit: contain;" 
            class="card-img-top mx-auto d-block" 
            alt="Tanque">            
            <div class="card-body">

                <ul class="list-group-item">
                    <li class="badge  <?php echo $badgeClass ?> rounded-pill">Tanque <?php echo $ob->getEstado();?></li>
                </ul>
                        
                        
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Codigo Tanque </b>:   <?php echo $ob->getNombre(); ?></li>
                        <li class="list-group-item"><b>Tipo</b>:   <?php echo $ob->getTipo();?></li>
                        <li class="list-group-item"><b>Zoocriadero</b>:   <?php echo $ob->getZoocriadero();?></li>
                        <li class="list-group-item"><b>Direccion</b>:  <?php echo $ob->getDireccion();?></li>
                       
                    </ul>
                    <div class="card-body">
                        <a href="<?php echo getUrl('Tanque','Tanque','getEdit', array('id'=>$ob->getId())); ?>" class="btn btn-primary">
                            Editar
                        </a>
                          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $ob->getId() ?>">
                            Inhabilitar
                            </button>


                     <div class="modal fade" id="exampleModal<?php echo $id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Inhabilitar Tanque</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de Inhabilitar <?php echo $ob->getNombre() ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-clouse" data-bs-dismiss="modal">Cerrar</button>
                                <a href="<?php echo getUrl('Tanque','Tanque','postDelete', array('id'=>$ob->getId())); ?>"class="btn btn-danger" type="button">Inhabilitar</a>
                            </div>
                            </div>
                        </div>
                        </div>
                            
                                   
                    </div>
                    </div>
                    
            </div>
                <?php 

  }

  ?>
</div>
</div>
