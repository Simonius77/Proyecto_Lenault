<?php
class Ingrediente {
private $id_ingrediente;
private $nombre;







/**
 * Obtener el valor de id_ingrediente
 */ 
public function getId_ingrediente()
{
return $this->id_ingrediente;
}

/**
 * Establecer el valor de id_ingrediente
 *
 * @return  self
 */ 
public function setId_ingrediente($id_ingrediente)
{
$this->id_ingrediente = $id_ingrediente;

return $this;
}

/**
 * Obtener el valor de nombre
 */ 
public function getNombre()
{
return $this->nombre;
}

/**
 * Establecer el valor de nombre
 *
 * @return  self
 */ 
public function setNombre($nombre)
{
$this->nombre = $nombre;

return $this;
}
}



?>