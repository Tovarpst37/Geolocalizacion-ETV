<?php

class ActividadTerreno
{
     private int $id;
     private String $codigo;
     private String $nombre;
     private String $estado;

     public function__construct(int $id,  String $nombre, String $estado)
     {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->estado = $estado;
     }


     public function getCard()
     {
        $badgeClass = strtolower($this->estado) === 'activo' ? 'bg-success' : 'bg-danger';


?>
           <div class="col">

          <div class="card p-3 h-100" style="width: 100% !important; min-width: 0 !important; d-flex justify-content-center">

             <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>codigo</b>: <?php echo $this->codigo; ?></li>
                    <li class="list-group-item"><b>Nombre</b>: <?php echo $this->nombre; ?></li>
                    <li class="list-group-item"><b>Estado</b>: <?php echo $this->estado; ?></li>

</ul>
 
<div class="card-body">
                    <a href="<?php echo getUrl('ActividadTerreno', 'ActividadTerreno', 'getEdit', array('id' => $this->id)); ?>" class="btn btn-primary">
                        Editar
                    </a>
                    <a href="<?php echo getUrl("ActividadTerreno", "ActividadTerreno", "getDelete", array("id" => $this->id)) ?>" class="btn btn-danger">
                        Eliminar
                    </a>

                </div>
            </div>

        </div>
<?php


     }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setEstado($estado)
    {
         $this->estado = $estado;
    }
}


?>




























































}






?>