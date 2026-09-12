

<?php 

class Tanque{

    private int $id;
    private String $nombre;
    private String $img;
    private String $tipo;
    private String $zoocriadero;
    private String $direccion;
    private String $estado;

    public function __construct(int $id, String $nombre, String $img, String $tipo, String $zoocriadero, String $direccion, String $estado){
      
        $this->id = $id;
        $this->nombre = $nombre;
        $this->img = $img;
        $this->tipo = $tipo;
        $this->zoocriadero = $zoocriadero;
        $this->direccion = $direccion;
        $this->estado = $estado;

    }
    


    public function getCard($id){ 
        
        $badgeClass = strtolower($this->estado) === 'activo' ? 'bg-success' : 'bg-danger';

        ?>

        
                <div class = "col">
                
                    <div class="card p-3 h-100" style="width: 100% !important; min-width: 0 !important; d-flex justify-content-center">
        <img src="/Geolocalizacion/Geolocalizacion-ETV/PLANTILLA/web/assets/img/<?php echo $this->img;?>"
            style="width: 15rem; height: 12rem; object-fit: contain;" 
            class="card-img-top mx-auto d-block" 
            alt="Tanque">            
            <div class="card-body">

                <ul class="list-group-item">
                    <li class="badge  <?php echo $badgeClass ?> rounded-pill">Tanque <?php echo $this->estado;?></li>
                </ul>
                        
                        
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Codigo Tanque </b>:   <?php echo $this->nombre; ?></li>
                        <li class="list-group-item"><b>Tipo</b>:   <?php echo $this->tipo;?></li>
                        <li class="list-group-item"><b>Zoocriadero</b>:   <?php echo $this->zoocriadero;?></li>
                        <li class="list-group-item"><b>Direccion</b>:  <?php echo $this->direccion;?></li>
                       
                    </ul>
                    <div class="card-body">
                        <a href="<?php echo getUrl('Tanque','Tanque','getEdit', array('id'=>$this->id)); ?>" class="btn btn-primary">
                            Editar
                        </a>
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $id?>">
                            Inhabilitar
                            </button>

                     <div class="modal fade" id="exampleModal<?php echo $id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Eliminar Tanque</h5>
                                <button type="button" class="btn-close" onclick="window.location.href='index.php'"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de eliminar este tanque?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <a href="<?php echo getUrl('Tanque','Tanque','postDelete', array('id'=>$id)); ?>" class="btn btn-danger" type="button">Inhabilitar</a>
                            </div>
                            </div>
                        </div>
                        </div>
                            
                                   
                    </div>
                    </div>
                    
            </div>
                <?php

                
        
    }


    
    public function setId( $id2){

        $this->id = $id2; 

    }

    public function getId( ){

        return $this->id; 

    }

    
    public function setDireccion( $direccion){

        $this->direccion = $direccion; 

    }

    
    public function setEstado($estado){

        $this->estado = $estado; 

    }

    
    public function setTipo($tipo){

        $this->tipo = $tipo; 

    }

    public function setImg($img){

        $this->img = $img; 

    }

    public function setZoocriadero($zoocriadero){

        $this->zoocriadero = $zoocriadero; 

    }

    public function setNombre($nombre){
        $this -> nombre = $nombre;
    }

}
    ?>