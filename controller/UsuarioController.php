<?php
include_once 'model/UsuarioDAO.php';
include_once 'model/LogDAO.php';

class UsuarioController
{
    // Mostrar vista de Login
    public function Login()
    {
        $view = "admindViews/login.php";
        require_once __DIR__ . "/../view/plantilla.php";
    }

    // Mostrar vista de Registro
    public function RegisterView()
    {
        $view = "admindViews/registro.php";
        require_once __DIR__ . "/../view/plantilla.php";
    }

    // Autenticar usuario
    public function Authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';

            if (empty($username) || empty($password)) {
                $_SESSION['error'] = "Por favor, completa todos los campos.";
                header("Location: ?controller=Usuario&action=Login");
                exit;
            }

            $user = UsuarioDAO::login($username, $password);

            if ($user) {
                // Iniciar la sesión del usuario
                $_SESSION['user_id'] = $user->getId_usuario();
                $_SESSION['user_name'] = $user->getNombre();
                $_SESSION['user_role'] = $user->getRol();

                // Registrar en el historial de logs
                LogDAO::insertLog($user->getNombre(), "Usuario inició sesión correctamente.");

                // Redireccionar según el rol
                if (strtolower($user->getRol()) === 'admin') {
                    header("Location: ?controller=Admind&action=Admind");
                } else {
                    header("Location: ?controller=Home&action=Home");
                }
                exit;
            } else {
                $_SESSION['error'] = "Usuario o contraseña incorrectos.";
                header("Location: ?controller=Usuario&action=Login");
                exit;
            }
        } else {
            header("Location: ?controller=Usuario&action=Login");
            exit;
        }
    }

    // Registrar nuevo usuario
    public function Register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $telf = isset($_POST['telf']) ? trim($_POST['telf']) : '';
            $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';

            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = "Completa los campos obligatorios (Usuario, Email, Contraseña).";
                header("Location: ?controller=Usuario&action=RegisterView");
                exit;
            }

            // Comprobar si el email ya existe
            if (UsuarioDAO::findByEmail($email)) {
                $_SESSION['error'] = "El correo electrónico ya está registrado.";
                header("Location: ?controller=Usuario&action=RegisterView");
                exit;
            }

            // Insertar usuario (por defecto rol 'cliente')
            $result = UsuarioDAO::insertUsuario($username, $email, $password, $telf, $direccion, 'cliente');

            if ($result) {
                LogDAO::insertLog($username, "Nuevo usuario registrado: $username ($email).");
                $_SESSION['success'] = "¡Registro completado! Ahora puedes iniciar sesión.";
                header("Location: ?controller=Usuario&action=Login");
                exit;
            } else {
                $_SESSION['error'] = "Hubo un error al crear la cuenta. Inténtalo de nuevo.";
                header("Location: ?controller=Usuario&action=RegisterView");
                exit;
            }
        } else {
            header("Location: ?controller=Usuario&action=RegisterView");
            exit;
        }
    }

    // Cerrar sesión
    public function Logout()
    {
        if (isset($_SESSION['user_name'])) {
            LogDAO::insertLog($_SESSION['user_name'], "Usuario cerró sesión.");
        }
        
        // Destruir variables de sesión y sesión completa
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();

        header("Location: ?controller=Home&action=Home");
        exit;
    }
}
?>
