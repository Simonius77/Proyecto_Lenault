<?php 



include_once 'model/Producto.php';
include_once 'database/database.php';
class ProductoDAO {
    public static function getProductoByID($id_producto){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE ID_PRODUCTO = ?");
        $stmt->bind_param('i', $id_producto);
        $stmt->execute();
        $results = $stmt->get_result();

        $producto = $results->fetch_object('Producto');
        $con->close();
        
        return $producto;
    }

    public static function getProductos(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO");
        // $stmt->bind_param('i', $id);
        $stmt->execute();
        $results = $stmt->get_result();

        $listaProductos = [];

        while ($producto = $results->fetch_object('Producto')) {
            $listaProductos[]=$producto;
        }

        $con->close();        
        return $listaProductos;
    }
}





?>