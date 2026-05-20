<?php 

include_once 'model/Usuario.php';
include_once 'database/database.php';

class UsuarioDAO {
    
    // Obtener usuario por ID
    public static function getUsuarioByID($id_usuario){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $results = $stmt->get_result();

        $usuario = $results->fetch_object('Usuario');
        $con->close();
        
        return $usuario;
    }

    // Obtener todos los usuarios
    public static function getUsuarios(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaUsuarios = [];

        while ($usuario = $results->fetch_object('Usuario')) {
            $listaUsuarios[] = $usuario;
        }

        $con->close();        
        return $listaUsuarios;
    }
    
    // Autenticar usuario (LOGIN)
    public static function login($username, $password) {
        $con = DataBase::connect();
        // Buscamos tanto por nombre como por email para mayor flexibilidad y evitar fallos
        $stmt = $con->prepare("SELECT id_usuario, nombre, email, password, rol, telf, direccion FROM usuario WHERE nombre = ? OR email = ? LIMIT 1");
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $results = $stmt->get_result();

        if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
            
            // Verificar password
            if (password_verify($password, $row['password'])) {
                $usuario = new Usuario();
                $usuario->setId_usuario($row['id_usuario']);
                $usuario->setNombre($row['nombre']);
                $usuario->setEmail($row['email']);
                $usuario->setRol($row['rol']);
                $usuario->setTelf($row['telf']);
                $usuario->setDireccion($row['direccion']);
                
                $con->close();
                return $usuario;
            }
        }
        
        $con->close();
        return false;
    }

    // Buscar usuario por email
    public static function findByEmail($email) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT id_usuario, nombre, email, rol FROM usuario WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $results = $stmt->get_result();

        if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
            $con->close();
            return $row;
        }
        
        $con->close();
        return false;
    }

    // Actualizar contraseña
    public static function updatePassword($user_id, $new_password) {
        $con = DataBase::connect();
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $stmt = $con->prepare("UPDATE usuario SET password = ? WHERE id_usuario = ?");
        $stmt->bind_param('si', $hashed_password, $user_id);
        
        $result = $stmt->execute();
        $con->close();
        
        return $result;
    }

    // Insertar nuevo usuario
    public static function insertUsuario($username, $email, $password, $telf = '', $direccion = '', $rol = 'cliente') {
        $con = DataBase::connect();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $con->prepare("INSERT INTO usuario (nombre, email, password, telf, direccion, rol) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $username, $email, $hashed_password, $telf, $direccion, $rol);
        
        $result = $stmt->execute();
        $con->close();
        
        return $result;
    }
}

?>
