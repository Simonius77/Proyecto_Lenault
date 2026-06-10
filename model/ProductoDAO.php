<?php

include_once 'model/Producto.php';
include_once 'database/database.php';

class ProductoDAO
{

    public static function getProductoByID($id_producto)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE ID_PRODUCTO = ?");
        $stmt->bind_param('i', $id_producto);
        $stmt->execute();
        $results = $stmt->get_result();

        $producto = $results->fetch_object('Producto');
        $con->close();

        return $producto;
    }

    public static function getProductos()
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaProductos = [];

        while ($producto = $results->fetch_object('Producto')) {
            $listaProductos[] = $producto;
        }

        $con->close();
        return $listaProductos;
    }

    public static function insert($producto)
    {
        $con = DataBase::connect();
        // Asumiendo id_categoria, nombre, precio, descripcion, imagen
        $stmt = $con->prepare("INSERT INTO PRODUCTO (id_categoria, nombre, precio, descripcion, imagen) VALUES (?, ?, ?, ?, ?)");

        $cat = $producto->getId_categoria();
        $nom = $producto->getNombre();
        $pre = $producto->getPrecio();
        $desc = $producto->getDescripcion();
        $img = $producto->getImagen();

        $stmt->bind_param('isdss', $cat, $nom, $pre, $desc, $img);

        $status = $stmt->execute();
        $insertId = $con->insert_id;
        $con->close();

        return $insertId; // Devuelve ID o false
    }

    public static function update($producto)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE PRODUCTO SET id_categoria=?, nombre=?, precio=?, descripcion=?, imagen=? WHERE id_producto=?");

        $cat = $producto->getId_categoria();
        $nom = $producto->getNombre();
        $pre = $producto->getPrecio();
        $desc = $producto->getDescripcion();
        $img = $producto->getImagen();
        $id = $producto->getId_producto();

        $stmt->bind_param('isdssi', $cat, $nom, $pre, $desc, $img, $id);

        $status = $stmt->execute();
        $con->close();

        return $status;
    }

    public static function delete($id_producto)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM PRODUCTO WHERE id_producto=?");
        $stmt->bind_param('i', $id_producto);
        $status = $stmt->execute();
        $con->close();
        return $status;
    }
}
?>