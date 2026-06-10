<?php
// AdminUsuarioController.php
// Controlador para las operaciones de administración de usuarios (ver, editar, borrar).
// Similar al controlador de productos pero enfocado a la gestión de usuarios.

include_once 'model/UsuarioDAO.php';

class AdminUsuarioController {
    // Mostrar lista de todos los usuarios en una tabla HTML.
    public static function index() {
        $usuarios = UsuarioDAO::getUsuarios();
        // Cargar vista que mostrará la tabla.
        $view = "admin/users.php";
        require_once __DIR__ . '/../view/plantilla.php';
    }

    // Mostrar formulario para editar un usuario existente.
    public static function edit() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $usuario = UsuarioDAO::getUsuarioByID($id);
            $view = "admin/edit_user.php";
            require_once __DIR__ . '/../view/plantilla.php';
        } else {
            header('Location: ?controller=AdminUsuario&action=index');
        }
    }

    // Procesar la actualización del usuario enviada vía POST.
    public static function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $rol = $_POST['rol'];
            // Actualizar usando DAO (se asume que existe un método updateUsuario).
            UsuarioDAO::updateUsuario($id, $nombre, $email, $rol);
        }
        header('Location: ?controller=AdminUsuario&action=index');
    }

    // Borrar un usuario.
    public static function delete() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            UsuarioDAO::deleteUsuario($id);
        }
        header('Location: ?controller=AdminUsuario&action=index');
    }
}
?>
