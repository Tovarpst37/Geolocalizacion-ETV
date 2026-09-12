

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
        
       

                
        
    }


    
    public function setId( $id2){

        $this->id = $id2; 

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


        public function getId( ){

        return $this->id; 

    }


    public function getDireccion(){

        return $this->direccion; 

    }

    
    public function getEstado(){

        return $this->estado; 

    }

    
    public function getTipo(){

        return $this->tipo; 

    }

    public function getImg(){

        return $this->img; 

    }

    public function getZoocriadero(){

        return $this->zoocriadero; 

    }

    public function getNombre(){
        return $this -> nombre;
    }

}
    ?>