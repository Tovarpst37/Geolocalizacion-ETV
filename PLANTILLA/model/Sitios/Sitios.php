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
    $badgeClass = strtolower($this->estado) === 'activo' ? 'bg-success' : 'bg-danger';
?>
    <div class="col">
        <div class="card p-3 h-100" style="width: 100% !important; min-width: 0 !important;">
            <div class="card-body pb-2 text-start">
                <div class="mb-2">
                    <span class="badge <?php echo $badgeClass ?> rounded-pill"><?php echo $this->estado ?></span>
                </div>
                <h5 class="card-title mb-0"><?php echo $this->nombre_sitio ?></h5>
                <small class="text-muted">ID <?php echo $this->id ?></small>
            </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item"><?php echo $this->direccion ?></li>
                <li class="list-group-item"><?php echo $this->barrio ?></li>
            </ul>

            <div class="card-body d-flex gap-2 pt-3">
                <a href="<?php echo getUrl('Sitios', 'Sitios', 'getEdit', array('id' => $this->id)); ?>" class="btn btn-primary btn-sm flex-fill">
                    Editar
                </a>
                <a href="<?php echo getUrl('Sitios', 'Sitios', 'setDelete', array('id' => $this->id)); ?>" class="btn btn-danger btn-sm flex-fill">
                    Eliminar
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