<?php

    class Usuario {
        private $id_usuario;
        private $nombre;
        private $email;
        private $direccion;
        private $password;
        private $telf;
        private $rol;


        //constructor vacio
        public function __construct() {
                
        }





        /**
         * Obtener el valor de id_usuario
         */ 
        public function getId_usuario()
        {
                return $this->id_usuario;
        }

        /**
         * Establecer el valor de id_usuario
         *
         * @return  self
         */ 
        public function setId_usuario($id_usuario)
        {
                $this->id_usuario = $id_usuario;

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

        /**
         * Obtener el valor de email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Establecer el valor de email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Obtener el valor de direccion
         */ 
        public function getDireccion()
        {
                return $this->direccion;
        }

        /**
         * Establecer el valor de direccion
         *
         * @return  self
         */ 
        public function setDireccion($direccion)
        {
                $this->direccion = $direccion;

                return $this;
        }

        /**
         * Obtener el valor de password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Establecer el valor de password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Obtener el valor de telf
         */ 
        public function getTelf()
        {
                return $this->telf;
        }

        /**
         * Establecer el valor de telf
         *
         * @return  self
         */ 
        public function setTelf($telf)
        {
                $this->telf = $telf;

                return $this;
        }

        /**
         * Obtener el valor de rol
         */ 
        public function getRol()
        {
                return $this->rol;
        }

        /**
         * Establecer el valor de rol
         *
         * @return  self
         */ 
        public function setRol($rol)
        {
                $this->rol = $rol;

                return $this;
        }
    }



?>