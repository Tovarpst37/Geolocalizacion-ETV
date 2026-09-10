<?php
include_once '../model/Sitios/SitiosModel.php';
class SitiosController
{

    private int $id;
    private string $nombre_sitio = "";
    private string  $direccion = "";
    private string $barrio = "";

    private string $estado = "";


    public function getConsultar()

    {

        $obj = new SitiosModel();
        $sql = "SELECT 
            s.id_sitio,
            s.nombre_sitio,
            s.direccion,
            b.nombre_barrio AS barrio,
            e.nombre_estado AS estado
        FROM sitio s
        INNER JOIN barrio b ON s.id_barrio = b.id_barrio
        INNER JOIN estado e ON s.id_estado = e.id_estado";
        # $result = $obj->select($sql);
        $resul = $obj->select($sql) ;

        include_once '../view/partials/Sitios/Consultar.php';
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
                    <a href="<?php echo getUrl("Sitios", "Sitios", "postUpdate") ?>">
                        <Button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro">Editar</Button>
                    </a>
                    <a href="<?php echo getUrl("Sitios", "Sitios", "postUpdate") ?> " class="card-link">
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