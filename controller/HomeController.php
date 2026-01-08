<?php
include_once 'model/ProductoDAO.php';

class HomeController
{
    /*creamos una funcion para poder llamar a la vista que nos interese */
    public function Home()
    {
        /*Recuperamos todos los productos para mostrarlos en la home */
        $listaproductos = ProductoDAO::getProductos();

        /*Creamos la variable $view a la que le asignamos el valor de la vista deseada */
        $view = "homeViews/home.php";
        /*hacemos la llamada a la vista que desemos cargar teniendo muy encuenta la estructura de carpetas */
        require_once __DIR__ . "\..\\view\plantilla.php";

    }

    public function Legal()
    {
        /*Creamos la variable $view a la que le asignamos el valor de la vista deseada */
        $view = "homeViews/legal.php";
        /*hacemos la llamada a la vista que desemos cargar teniendo muy encuenta la estructura de carpetas */
        require_once __DIR__ . "\..\\view\plantilla.php";

    }

    public function Politicas()
    {

        $view = "homeViews/politica_priv.php";
        require_once __DIR__ . "\..\\view\plantilla.php";

    }

    public function AboutUs()
    {

        $view = "homeViews/quienes_somos.php";
        require_once __DIR__ . "\..\\view\plantilla.php";

    }

    public function Login()
    {

        $view = "admindViews/login.php";
        require_once __DIR__ . "\..\\view\plantilla.php";

    }


}

?>