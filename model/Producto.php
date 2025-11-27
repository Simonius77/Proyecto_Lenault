<?php 

    class Producto {
        private $id_producto;
        private $nombre;
        private $precio;








        /**
         * Get the value of id_producto
         */ 
        public function getId_producto()
        {
                return $this->id_producto;
        }

        /**
         * Set the value of id_producto
         *
         * @return  self
         */ 
        public function setId_producto($id_producto)
        {
                $this->id_producto = $id_producto;

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

        /**
         * Get the value of precio
         */ 
        public function getPrecio()
        {
                return $this->precio;
        }

        /**
         * Set the value of precio
         *
         * @return  self
         */ 
        public function setPrecio($precio)
        {
                $this->precio = $precio;

                return $this;
        }
    }



?>