<?php

class Terreno
{

    private int $id;
    private string $codigo_sitio_deposito;
    private string  $direccion;
    private string $estado;

    private string $descripcion;

    private string $nombre_tipo_deposito;



    public function __construct(int $id, string $codigo_sitio_deposito, string $direccion, string $estado, string $descripcion, string $nombre_tipo_deposito)
    {
        $this->id = $id;
        $this->codigo_sitio_deposito = $codigo_sitio_deposito;
        $this->direccion = $direccion;
        $this->estado = $estado;
        $this->descripcion = $descripcion;
        $this->nombre_tipo_deposito = $nombre_tipo_deposito;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setCodigo_sitio_deposito(string $codigo_sitio_deposito)
    {
        $this->codigo_sitio_deposito = $codigo_sitio_deposito;
    }

    public function setDireccion(string $direccion)
    {
        $this->direccion = $direccion;
    }


    public function setEstado(string $estado)
    {
        $this->estado  = $estado;
    }

    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setNombre_tipo_deposito(string $nombre_tipo_deposito)
    {
        $this->nombre_tipo_deposito = $nombre_tipo_deposito;
    }


    
public function getId(): int
{
    return $this->id;
}

public function getCodigo_sitio_deposito():string 
{
    return $this -> codigo_sitio_deposito;
}
public function getDireccion():string 
{
    return $this -> direccion;

}

public function getEstado():string 
{
    return $this -> estado;

}


public function getDescripcion():string 
{
    return $this -> descripcion;
}


public function getNombre_tipo_deposito(): string 
{
    return $this -> nombre_tipo_deposito;
}

}
