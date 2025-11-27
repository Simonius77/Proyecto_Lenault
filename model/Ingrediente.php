<?php
class Ingrediente {
private $id_ingrediente;
private $nombre;







/**
 * Get the value of id_ingrediente
 */ 
public function getId_ingrediente()
{
return $this->id_ingrediente;
}

/**
 * Set the value of id_ingrediente
 *
 * @return  self
 */ 
public function setId_ingrediente($id_ingrediente)
{
$this->id_ingrediente = $id_ingrediente;

return $this;
}

/**
 * Get the value of nombre
 */ 
public function getNombre()
{
return $this->nombre;
}

/**
 * Set the value of nombre
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