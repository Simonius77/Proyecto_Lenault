<?php

class Producto implements JsonSerializable
{
        private $id_producto;
        private $id_categoria;
        private $nombre;
        private $precio;
        private $descripcion;
        private $imagen;
        private $available;

        public function jsonSerialize(): mixed
        {
                return [
                        'id' => $this->id_producto,
                        'name' => $this->nombre,
                        'description' => $this->descripcion,
                        'category' => $this->id_categoria, // Keeping int, JS might need mapping or display as is
                        'price' => $this->precio,
                        'available' => 1, // Hardcoded for now as DB doesn't seem to have it
                        'image' => $this->getImagen()
                ];
        }

        public function getId_producto()
        {
                return $this->id_producto;
        }
        public function setId_producto($id_producto)
        {
                $this->id_producto = $id_producto;
                return $this;
        }

        public function getId_categoria()
        {
                return $this->id_categoria;
        }
        public function setId_categoria($id_categoria)
        {
                $this->id_categoria = $id_categoria;
                return $this;
        }

        public function getNombre()
        {
                return $this->nombre;
        }
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;
                return $this;
        }

        public function getPrecio()
        {
                return $this->precio;
        }
        public function setPrecio($precio)
        {
                $this->precio = $precio;
                return $this;
        }

        public function getDescripcion()
        {
                return $this->descripcion;
        }
        public function setDescripcion($descripcion)
        {
                $this->descripcion = $descripcion;
                return $this;
        }

        public function getImagen()
        {
                $img = trim($this->imagen, '"\'');
                $img = ltrim($img, '\\/');
                if (stripos($img, 'Imagenes') === 0) {
                    $img = substr($img, strlen('Imagenes'));
                    $img = ltrim($img, '\\/');
                }
                return $img;
        }
        public function setImagen($imagen)
        {
                $this->imagen = $imagen;
                return $this;
        }
}

?>