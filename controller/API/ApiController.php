<?php
include_once 'model/ProductoDAO.php';
include_once 'model/PedidoDAO.php';
include_once 'model/LogDAO.php';
include_once 'model/UsuarioDAO.php';

class ApiController
{
    // Obtener todos los productos en formato JSON
    public function products()
    {
        $productos = ProductoDAO::getProductos();
        header('Content-Type: application/json');
        echo json_encode($productos);
    }

    // Guardar / Actualizar producto
    public function save_product()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            echo json_encode(['success' => false, 'message' => 'JSON inválido']);
            return;
        }

        $id = isset($input['id']) && $input['id'] !== '' ? (int)$input['id'] : null;
        $name = isset($input['name']) ? $input['name'] : '';
        $description = isset($input['description']) ? $input['description'] : '';
        $category = isset($input['category']) ? (int)$input['category'] : 1;
        $price = isset($input['price']) ? (float)$input['price'] : 0.0;
        $image = isset($input['image']) ? $input['image'] : 'default.png';

        if (empty($name) || $price <= 0) {
            echo json_encode(['success' => false, 'message' => 'Nombre y precio son obligatorios']);
            return;
        }

        $producto = new Producto();
        $producto->setNombre($name);
        $producto->setDescripcion($description);
        $producto->setPrecio($price);
        $producto->setImagen($image);
        $producto->setId_categoria($category);

        $admin = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin';

        if ($id) {
            $producto->setId_producto($id);
            $result = ProductoDAO::update($producto);
            if ($result) {
                LogDAO::insertLog($admin, "Modificó el producto #$id ($name)");
                echo json_encode(['success' => true, 'message' => 'Producto actualizado correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el producto']);
            }
        } else {
            $newId = ProductoDAO::insert($producto);
            if ($newId) {
                LogDAO::insertLog($admin, "Creó el producto #$newId ($name)");
                echo json_encode(['success' => true, 'message' => 'Producto creado correctamente', 'id' => $newId]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al crear el producto']);
            }
        }
    }

    // Eliminar producto
    public function delete_product()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID faltante']);
            return;
        }

        $id = (int)$input['id'];
        $admin = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin';

        $result = ProductoDAO::delete($id);
        if ($result) {
            LogDAO::insertLog($admin, "Eliminó el producto #$id");
            echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto. Comprueba que no esté en ningún pedido.']);
        }
    }

    // Obtener todos los pedidos en formato JSON
    public function orders()
    {
        $pedidos = PedidoDAO::getPedidos();
        header('Content-Type: application/json');
        echo json_encode($pedidos);
    }

    // Guardar / Actualizar pedido (Para administracion)
    public function save_order()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        $id_pedido = isset($input['id']) ? (int)$input['id'] : (isset($input['id_pedido']) ? (int)$input['id_pedido'] : null);

        if (!$input || !$id_pedido) {
            echo json_encode(['success' => false, 'message' => 'Datos de pedido inválidos']);
            return;
        }

        $local = isset($input['local']) ? (int)$input['local'] : 0;
        $recoger = isset($input['recoger']) ? (int)$input['recoger'] : 0;
        $importe_total = isset($input['total']) ? (float)$input['total'] : (isset($input['importe_total']) ? (float)$input['importe_total'] : 0.0);

        $admin = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin';

        $result = PedidoDAO::update($id_pedido, $local, $recoger, $importe_total);

        if ($result) {
            LogDAO::insertLog($admin, "Modificó el pedido #$id_pedido (Total: $importe_total €)");
            echo json_encode(['success' => true, 'message' => 'Pedido actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el pedido']);
        }
    }

    // Eliminar pedido
    public function delete_order()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID de pedido faltante']);
            return;
        }

        $id = (int)$input['id'];
        $admin = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin';

        $result = PedidoDAO::delete($id);
        if ($result) {
            LogDAO::insertLog($admin, "Eliminó el pedido #$id");
            echo json_encode(['success' => true, 'message' => 'Pedido eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el pedido']);
        }
    }

    // Obtener historial de logs en formato JSON
    public function logs()
    {
        $logs = LogDAO::getLogs();
        header('Content-Type: application/json');
        echo json_encode($logs);
    }

    // Obtener todos los usuarios en formato JSON (Admin CRUD)
    public function users()
    {
        $usuarios = UsuarioDAO::getUsuarios();
        $res = [];
        foreach ($usuarios as $u) {
            $res[] = [
                'id_usuario' => $u->getId_usuario(),
                'nombre' => $u->getNombre(),
                'email' => $u->getEmail(),
                'rol' => $u->getRol()
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($res);
    }

    // Guardar / Actualizar usuario (Admin CRUD)
    public function save_user()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            echo json_encode(['success' => false, 'message' => 'JSON inválido']);
            return;
        }

        $id = isset($input['id']) && $input['id'] !== '' ? (int)$input['id'] : null;
        $nombre = isset($input['nombre']) ? trim($input['nombre']) : '';
        $email = isset($input['email']) ? trim($input['email']) : '';
        $rol = isset($input['rol']) ? trim($input['rol']) : 'cliente';

        if (empty($nombre) || empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Nombre y email son obligatorios']);
            return;
        }

        $admin = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin';

        if ($id) {
            // Actualizar usuario existente
            $result = UsuarioDAO::updateUsuario($id, $nombre, $email, $rol);
            if ($result) {
                LogDAO::insertLog($admin, "Modificó el usuario #$id ($nombre)");
                echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el usuario']);
            }
        } else {
            // Crear usuario nuevo (con contraseña por defecto '123456')
            $result = UsuarioDAO::insertUsuario($nombre, $email, '123456', '', '', $rol);
            if ($result) {
                // Obtener el ID generado buscando por email
                $uObj = UsuarioDAO::findByEmail($email);
                $newId = $uObj ? $uObj['id_usuario'] : null;
                LogDAO::insertLog($admin, "Creó el usuario #$newId ($nombre)");
                echo json_encode(['success' => true, 'message' => 'Usuario creado correctamente', 'id' => $newId]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al crear el usuario']);
            }
        }
    }

    // Eliminar usuario (Admin CRUD)
    public function delete_user()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID de usuario faltante']);
            return;
        }

        $id = (int)$input['id'];
        $admin = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin';

        $result = UsuarioDAO::deleteUsuario($id);
        if ($result) {
            LogDAO::insertLog($admin, "Eliminó el usuario #$id");
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario']);
        }
    }
}
?>