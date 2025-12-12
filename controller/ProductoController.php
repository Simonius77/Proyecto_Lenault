<?php


    class ProductoControllerController {

        public function Producto(){
            /*Creamos la variable $view a la que le asignamos el valor de la vista deseada */
            $view = "carta.php";
            /*hacemos la llamada a la vista que desemos cargar teniendo muy encuenta la estructura de carpetas */
            require_once __DIR__ . "\..\\view\plantilla.php";
        }

    }    


?>