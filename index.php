<?php
//http://localhost/Proyecto_Lenault/?controller=Home&action=legal

include_once 'controller/ProductoController.php';
include_once 'controller/HomeController.php';
include_once 'controller/UsuarioController.php';


if (isset($_GET['controller'])) {
    $nombre_controller = $_GET['controller'].'Controller';
    if (class_exists($nombre_controller)) {
        $controller = new $nombre_controller();
        $acttion = $_GET['action'];
        if (isset($_GET['action']) && method_exists($controller, $acttion)) {
            $controller->$acttion();
        }else {
            header("Location:404.php");
        }
    }
}else {
   echo 'Ey! Falta el controller en la URL!!';
    
}
?>