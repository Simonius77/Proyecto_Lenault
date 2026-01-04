<?php


    class AdmindController {

        public function Registro(){
            /*Creamos la variable $view a la que le asignamos el valor de la vista deseada */
            $view = "registro.php";
            /*hacemos la llamada a la vista que desemos cargar teniendo muy encuenta la estructura de carpetas */
            require_once __DIR__ . "\..\\view\plantilla.php";
        }

        public function Admind(){
            /*Creamos la variable $view a la que le asignamos el valor de la vista deseada */
            $view = "admind.php";
            /*hacemos la llamada a la vista que desemos cargar teniendo muy encuenta la estructura de carpetas */
            require_once __DIR__ . "\..\\view\mainAdmin.php";
        }

    }    


?>