<?php

class ActividadZoocriadero
{

    private int $id;
    private  String $codigo;
    private  String $nombre;
    private  String $estado;

    public function __construct(int $id, String $codigo, String $nombre, String $estado)
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

            <div class="card p-3 h-100 text-center flex-column d-flex align-items-center justify-content-center" style="width: 100% !important; min-width: 0 !important; ">

                <ul class="list-group list-group-flush fs-3 w-100">
                    <li class="list-group-item border-0 text-center p-1 d-flex justify-content-center align-items-center">
                        <span class="badge fs-5 fw-bold <?php echo $badgeClass; ?> rounded-pill"><?php echo $this->estado; ?></span></li>                  
                    <li class="list-group-item border-0 text-center fw-bolder p-1 d-flex justify-content-center align-items-center "><?php echo $this->nombre; ?></li>
                    <li class="list-group-item fs-5 border-0 text-center p-1  d-flex justify-content-center align-items-center">Codigo: <?php echo $this->codigo; ?></li>


                </ul>
                <div class="card-body ">
                    <a href="<?php echo getUrl('ActividadZoocriadero', 'ActividadZoocriadero', 'getEdit', array('id' => $this->id)); ?>" class="btn btn-primary fs-4">
                        Editar
                    </a>
                    <a href="<?php echo getUrl("ActividadZoocriadero", "ActividadZoocriadero", "getDelete", array("id" => $this->id)) ?>" class="btn btn-danger fs-4">
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