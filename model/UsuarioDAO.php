
<?php 

include_once 'model/Usuario.php';
include_once 'database/database.php';

class UsuarioDAO {  // Cambiado de ProductoDAO a UsuarioDAO
    
    // Obtener usuario por ID
    public static function getUsuarioByID($id_usuario){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM USUARIO WHERE ID_USUARIO = ?");
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
        $stmt = $con->prepare("SELECT * FROM USUARIO");
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
        $stmt = $con->prepare("SELECT ID_USUARIO, NOMBRE_USUARIO, EMAIL, PASSWORD FROM USUARIO WHERE NOMBRE_USUARIO = ? LIMIT 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $results = $stmt->get_result();

        if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
            
            // Verificar password
            if (password_verify($password, $row['PASSWORD'])) {
                $usuario = new Usuario();
                $usuario->setId_usuario($row['ID_USUARIO']);
                $usuario->setNombre($row['NOMBRE_USUARIO']);
                $usuario->setEmail($row['EMAIL']);
                
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
        $stmt = $con->prepare("SELECT ID_USUARIO, NOMBRE_USUARIO, EMAIL FROM USUARIO WHERE EMAIL = ? LIMIT 1");
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
        
        $stmt = $con->prepare("UPDATE USUARIO SET PASSWORD = ? WHERE ID_USUARIO = ?");
        $stmt->bind_param('si', $hashed_password, $user_id);
        
        $result = $stmt->execute();
        $con->close();
        
        return $result;
    }

    // Insertar nuevo usuario
    public static function insertUsuario($username, $email, $password) {
        $con = DataBase::connect();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $con->prepare("INSERT INTO USUARIO (NOMBRE_USUARIO, EMAIL, PASSWORD) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $hashed_password);
        
        $result = $stmt->execute();
        $con->close();
        
        return $result;
    }
}

?>
