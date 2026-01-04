<?php
include_once 'model/ProductoDAO.php';
// Include other DAOs if needed

class ApiController
{

    public function products()
    {
        $productos = ProductoDAO::getProductos();
        header('Content-Type: application/json');
        echo json_encode($productos);
    }

    public function save_product()
    {
        header('Content-Type: application/json');

        // Read JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
            return;
        }

        $id = isset($input['id']) ? $input['id'] : null;
        $name = $input['name'];
        $description = $input['description'];
        $category = $input['category']; // This might be string or int
        $price = $input['price'];
        $image = isset($input['image']) ? $input['image'] : '';

        // Create Product Object
        $producto = new Producto();
        $producto->setNombre($name);
        $producto->setDescripcion($description);
        $producto->setPrecio($price);
        $producto->setImagen($image);

        // Handle Category: verification needed. For now cast to int or default 
        // If string "Meats", (int)"Meats" is 0. 
        // We really need IDs. 
        $producto->setId_categoria((int) $category);

        if ($id) {
            // Update
            $producto->setId_producto($id);
            $result = ProductoDAO::update($producto);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update product']);
            }
        } else {
            // Create
            $newId = ProductoDAO::insert($producto);
            if ($newId) {
                echo json_encode(['success' => true, 'message' => 'Product created successfully', 'id' => $newId]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create product']);
            }
        }
    }

    public function delete_product()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['id'])) {
            echo json_encode(['success' => false, 'message' => 'Missing ID']);
            return;
        }

        $result = ProductoDAO::delete($input['id']);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Product deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete product']);
        }
    }
}
?>