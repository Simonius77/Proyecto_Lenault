<?php 



include_once 'model/Usuario.php';
include_once 'database/database.php';
class ProductoDAO {
    public static function getProductoByID($id_producto){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM USUARIO WHERE ID_USUARIO = ?");
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $results = $stmt->get_result();

        $usuario = $results->fetch_object('Usuario');
        $con->close();
        
        return $usuario;
    }

    public static function getUsuarios(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM USUARIO");
        // $stmt->bind_param('i', $id);
        $stmt->execute();
        $results = $stmt->get_result();

        $listaUsuarios = [];

        while ($usuario = $results->fetch_object('Usuario')) {
            $listaUsuarios[]=$usuario;
        }

        $con->close();        
        return $listaUsuarios;
    }
}





?>