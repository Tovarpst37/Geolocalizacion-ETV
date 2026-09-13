


<div class = "container-fluid text-center px-2">
  
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">


<div class="d-flex justify-content-end w-100">
    <div class="input-group" style="max-width: 350px;">
<form class="input-group" action="index.php" method="GET">
    <input type="hidden" name="modulo" value="Tanque">
    <input type="hidden" name="controlador" value="Tanque">
    <input type="hidden" name="funcion" value="getBuscar">
    
    <input type="text" name="busqueda" placeholder="Search ..." class="form-control " value = "<?php echo $palabra; ?>" />
    
    <button type="submit" class="btn btn-outline-secondary">
        <i class="fa fa-search"></i>
    </button>
</form>
</div>
</div>


<?php


  include_once '../controller/Tanque/TanqueController.php';
  include_once '../model/Tanque/Tanque.php';

  if(!empty($tanque2)){ 
  $array = [];

  foreach($tanque2 as $rs){

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
                                <p>¿Estás seguro de Inhabilitar este tanque?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
</div>
</div>
<?php

 } else { ?>
    <div class="w-100 d-flex flex-column align-items-center justify-content-center text-muted py-5 mt-5">
        <i class="fa fa-search fa-2x mb-3"></i>
        <p class="mb-3">No se encontraron resultados</p>
    </div>
</div>
</div>

<?php } ?>

