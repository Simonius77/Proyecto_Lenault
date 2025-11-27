<?php

class HomeController {
    /*creamos una funcion para poder llamar a la vista que nos interese */
    
    public function Legal(){
        /*Creamos la variable $view a la que le asignamos el valor de la vista deseada */
        $view = "legal.php";
        /*hacemos la llamada a la vista que desemos cargar teniendo muy encuenta la estructura de carpetas */
        require_once __DIR__ . "\..\\view\plantilla.php";

    }

    public function Politicas(){

        $view = "politica_priv.php";
        require_once __DIR__ . "\..\\view\politica_priv.php";

    }

    public function AboutUs(){

        $view = "quienes_somos.php";
        require_once __DIR__ . "\..\\view\quienes_somos.php";

    }

    public function Login() {

        $view = "login.php";
        require_once __DIR__ . "\..\\view\login.php";

    }

    
}

?>