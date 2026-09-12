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

    public function getId(): int
{
    return $this->id;
}

public function getNombre_sitio(): string
{
    return $this->nombre_sitio;
}

public function getDireccion(): string
{
    return $this->direccion;
}

public function getBarrio(): string
{
    return $this->barrio;
}

public function getEstado(): string
{
    return $this->estado;
}
}
