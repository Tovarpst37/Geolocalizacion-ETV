<?php
class Sitios
{
    private int $id;
    private string $nombre_sitio;
    private string  $direccion;
    private string $barrio;

    private string $estado;

    public function __construct(int $id, string $nombre_sitio, string $direccion, string $barrio, string $estado)
    {
        $this->id = $id;
        $this->nombre_sitio = $nombre_sitio;
        $this->direccion = $direccion;
        $this->barrio = $barrio;
        $this->estado = $estado;
    }
    public function getCreate()
    {
?>
        <div class="col">
            <div class="card p-3 h-100" style="width: 100% !important; min-width: 0 !important;">
                <!--<img src="..." class="card-img-top" alt="..."> -->
                <div class="card-body">
                    <?php
                    echo "<h6 class='card-title'>{$this->id}</h6>";
                    echo "<h5 class='card-title'>Sitio</h5>";
                    ?>
                    <?php
                    echo "<p class='card-text'>{$this->nombre_sitio}</p>"
                    ?>
                </div>




                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Direccion : <?php echo $this->direccion ?> </li>
                    <li class="list-group-item">Barrio : <?php echo $this->barrio ?></li>
                    <li class="list-group-item">Estado : <?php echo $this->estado ?></li>
                </ul>


                <div class="card-body">
                    <a href="<?php echo getUrl('Sitios','Sitios','getEdit', array('id'=>$this->id)); ?>">
                        <Button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro">Editar</Button>
                    </a>
                    <a href="<?php echo getUrl('Sitios','Sitios','setDelete', array('id'=>$this->id)); ?>" class="card-link">
                        <Button class="btn btn-danger">Elimiar</Button>
                    </a>
                </div>
            </div>
        </div>



<?php

    }

    public function postUpdate()
    {

        include_once  '../view/partials/Sitios/Editar.php';
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setNombre_sitio(string $nombre_sitio)
    {
        $this->nombre_sitio = $nombre_sitio;
    }
    public function setDireccion(string $direccion)
    {
        $this->direccion = $direccion;
    }

    public function setBarrio(string $barrio)
    {
        $this->barrio = $barrio;
    }
    public function setEstado(string $estado)
    {
        $this->estado = $estado;
    }
}




?>