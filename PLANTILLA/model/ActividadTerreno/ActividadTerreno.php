<?php

class ActividadTerreno
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




   public function getId()
{
    return $this->id;
}

public function getCodigo()
{
    return $this->codigo;
}

public function getNombre()
{
    return $this->nombre;
}

public function getEstado()
{
    return $this->estado;
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