<?php
// Autocargador dinamico de clases (Modelo-Vista-Controlador)
spl_autoload_register(function ($class_name) {
    $dirs = [
        'controller/',
        'controller/API/',
        'model/',
        'database/'
    ];
    foreach ($dirs as $dir) {
        $file = $dir . $class_name . '.php';
        if (file_exists($file)) {
            include_once $file;
            return;
        }
    }
});

// Iniciar sesion para carrito y gestion de usuarios
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['controller'])) {
    $nombre_controller = $_GET['controller'] . 'Controller';
    if (class_exists($nombre_controller)) {
        $controller = new $nombre_controller();
        $acttion = $_GET['action'];
        if (isset($_GET['action']) && method_exists($controller, $acttion)) {
            $controller->$acttion();
        } else {
            header("Location:404.php");
        }
    }
} else {
    echo 'Ey! Falta el controller en la URL!!';

}
?>