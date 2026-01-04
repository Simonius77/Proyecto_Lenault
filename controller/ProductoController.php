<?php
include_once 'model/ProductoDAO.php';

class ProductoController
{

    public function Producto()
    {
        /* Recuperamos los productos usando el DAO */
        $listaproductos = ProductoDAO::getProductos();

        /* Asignamos la vista correcta */
        $view = "productoViews/carta.php";

        /* Cargamos la plantilla */
        require_once __DIR__ . "\..\\view\plantilla.php";
    }

}
?>